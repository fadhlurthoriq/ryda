<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class TransactionController extends Controller
{
    // Riwayat transaksi (beda tampilan tergantung role: pembeli lihat "purchases", penjual lihat "sales")
    public function index(Request $request) {
        $user = Auth::user();

        $query = $user->isPenjual()
            ? Transaction::with(['vehicle', 'buyer'])->where('seller_id', $user->id)
            : Transaction::with(['vehicle', 'seller'])->where('buyer_id', $user->id);

        if ($request->filled('search')) {
            $keyword = $request->search;
            $query->where(function ($q) use ($keyword) {
                $q->where('invoice_number', 'like', "%{$keyword}%")
                ->orWhereHas('vehicle', function ($q2) use ($keyword) {
                    $q2->where('title', 'like', "%{$keyword}%");
                });
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $transactions = $query->latest()->paginate(10)->withQueryString();

        return view('transactions.index', compact('transactions'));
    }

    // Pembeli mulai transaksi pembelian dari halaman detail kendaraan
    public function store(Vehicle $vehicle)
    {
        abort_if(Auth::id() === $vehicle->user_id, 403, 'Kamu tidak bisa membeli kendaraan sendiri.');
        abort_if($vehicle->status === 'terjual', 400, 'Kendaraan ini sudah terjual.');

        // Cegah pembeli bikin transaksi pending ganda buat kendaraan yang sama
        $existing = Transaction::where('vehicle_id', $vehicle->id)
            ->where('buyer_id', Auth::id())
            ->where('status', 'pending')
            ->first();

        if ($existing) {
            return redirect()->route('transactions.show', $existing)
                ->with('info', 'Kamu sudah punya transaksi pending untuk kendaraan ini.');
        }

        $transaction = Transaction::create([
            'invoice_number' => $this->generateInvoiceNumber(),
            'buyer_id'       => Auth::id(),
            'seller_id'      => $vehicle->user_id,
            'vehicle_id'     => $vehicle->id,
            'price'          => $vehicle->price,
            'status'         => 'pending',
        ]);

        return redirect()->route('transactions.show', $transaction)
            ->with('success', 'Transaksi berhasil dibuat, menunggu konfirmasi penjual.');
    }

    // Detail transaksi + tampilan struk
    public function show(Transaction $transaction)
    {
        $this->authorizeParticipant($transaction);

        $transaction->load(['vehicle', 'buyer', 'seller']);

        return view('transactions.show', compact('transaction'));
    }

    // Penjual konfirmasi transaksi -> selesai, kendaraan jadi terjual
    public function confirm(Transaction $transaction)
    {
        abort_unless(Auth::id() === $transaction->seller_id, 403, 'Cuma penjual yang bisa konfirmasi transaksi ini.');
        abort_unless($transaction->status === 'pending', 400, 'Transaksi ini sudah diproses sebelumnya.');

        $transaction->update(['status' => 'selesai']);
        $transaction->vehicle->update(['status' => 'terjual']);

        // Batalkan otomatis transaksi pending lain buat kendaraan yang sama (kalau ada pembeli lain yang antre)
        Transaction::where('vehicle_id', $transaction->vehicle_id)
            ->where('id', '!=', $transaction->id)
            ->where('status', 'pending')
            ->update(['status' => 'dibatalkan']);

        return redirect()->route('transactions.show', $transaction)
            ->with('success', 'Transaksi dikonfirmasi! Struk sudah bisa dilihat.');
    }

    // Penjual atau pembeli batalkan transaksi (selama masih pending)
    public function cancel(Transaction $transaction)
    {
        $this->authorizeParticipant($transaction);
        abort_unless($transaction->status === 'pending', 400, 'Transaksi ini tidak bisa dibatalkan lagi.');

        $transaction->update(['status' => 'dibatalkan']);

        return redirect()->route('transactions.index')
            ->with('success', 'Transaksi dibatalkan.');
    }

    // Generate nomor invoice unik, format: INV-20260726-A1B2C3
    private function generateInvoiceNumber(): string
    {
        do {
            $invoiceNumber = 'INV-' . now()->format('Ymd') . '-' . strtoupper(Str::random(6));
        } while (Transaction::where('invoice_number', $invoiceNumber)->exists());

        return $invoiceNumber;
    }

    // Helper: pastikan yang akses adalah buyer atau seller dari transaksi ini
    private function authorizeParticipant(Transaction $transaction): void
    {
        $userId = Auth::id();

        abort_unless(
            $userId === $transaction->buyer_id || $userId === $transaction->seller_id,
            403,
            'Kamu tidak terlibat dalam transaksi ini.'
        );
    }
}