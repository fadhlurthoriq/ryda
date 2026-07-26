<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;
use App\Models\Vehicle;
use App\Models\VehicleImage;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class VehicleController extends Controller
{

    public function dashboard(){
        $this->authorizeSeller();

        $userId = Auth::id();

        $stats = [
            'total'     => Vehicle::where('user_id', $userId)->count(),
            'tersedia'  => Vehicle::where('user_id', $userId)->where('status', 'tersedia')->count(),
            'terjual'   => Vehicle::where('user_id', $userId)->where('status', 'terjual')->count(),
        ];

        $recentVehicles = Vehicle::with('images')
            ->where('user_id', $userId)
            ->latest()
            ->take(5)
            ->get();

        $pendingTransactions = Transaction::with(['vehicle', 'buyer'])
            ->where('seller_id', $userId)
            ->where('status', 'pending')
            ->latest()
            ->take(5)
            ->get();

        return view('vehicles.dashboard', compact('stats', 'recentVehicles', 'pendingTransactions'));
    }

    // Halaman utama: list semua kendaraan tersedia + search & filter
    public function index(Request $request) {
        if (! Auth::check()) {
            return redirect()->route('login');
        }

        if (Auth::user()->isPenjual()) {
            return redirect()->route('seller.dashboard');
        }

        return redirect()->route('dashboard');
    }

    // Detail 1 kendaraan (pakai slug, sesuai getRouteKeyName)
    public function show(Vehicle $vehicle)
    {
        $vehicle->load(['images', 'category', 'seller']);

        return view('vehicles.show', compact('vehicle'));
    }

    // Form buat iklan baru (khusus penjual)
    public function create()
    {
        $this->authorizeSeller();

        $categories = Category::all();

        return view('vehicles.create', compact('categories'));
    }

    // Simpan iklan baru
    public function store(Request $request)
    {
        $this->authorizeSeller();

        $validated = $request->validate([
            'category_id'  => 'required|exists:categories,id',
            'title'        => 'required|string|max:255',
            'description'  => 'required|string',
            'price'        => 'required|numeric|min:0',
            'condition'    => 'required|in:baru,bekas',
            'brand'        => 'required|string|max:255',
            'model'        => 'required|string|max:255',
            'year'         => 'required|integer|min:1980|max:' . (date('Y') + 1),
            'location'     => 'required|string|max:255',
            'images'       => 'required|array|min:3',
            'images.*'     => 'image|mimes:jpg,jpeg,png|max:20480',
        ], [
            'images.min' => 'Minimal upload 3 foto (depan, samping kanan, samping kiri).',
        ]);

        $vehicle = Vehicle::create([
            'user_id'     => Auth::id(),
            'category_id' => $validated['category_id'],
            'title'       => $validated['title'],
            'slug'        => Str::slug($validated['title']) . '-' . Str::random(5),
            'description' => $validated['description'],
            'price'       => $validated['price'],
            'condition'   => $validated['condition'],
            'brand'       => $validated['brand'],
            'model'       => $validated['model'],
            'year'        => $validated['year'],
            'location'    => $validated['location'],
            'status'      => 'tersedia',
        ]);

        foreach ($request->file('images') as $image) {
            $path = $image->store('vehicles', 'public');
            VehicleImage::create([
                'vehicle_id' => $vehicle->id,
                'path'       => $path,
            ]);
        }

        return redirect()->route('vehicles.my-vehicles')
            ->with('success', 'Iklan berhasil dibuat!');
    }

    // Form edit (cuma pemilik)
    public function edit(Vehicle $vehicle)
    {
        $this->authorizeOwner($vehicle);
        abort_if($vehicle->status === 'terjual', 403, 'Kendaraan yang sudah terjual tidak bisa diedit.');

        $categories = Category::all();

        return view('vehicles.edit', compact('vehicle', 'categories'));
    }

    // Update iklan
    public function update(Request $request, Vehicle $vehicle)
    {
        $this->authorizeOwner($vehicle);
        abort_if($vehicle->status === 'terjual', 403, 'Kendaraan yang sudah terjual tidak bisa diedit.');

        $validated = $request->validate([
            'category_id'  => 'required|exists:categories,id',
            'title'        => 'required|string|max:255',
            'description'  => 'required|string',
            'price'        => 'required|numeric|min:0',
            'condition'    => 'required|in:baru,bekas',
            'brand'        => 'required|string|max:255',
            'model'        => 'required|string|max:255',
            'year'         => 'required|integer|min:1980|max:' . (date('Y') + 1),
            'location'     => 'required|string|max:255',
            'status'       => 'required|in:tersedia,terjual',
        ]);

        $vehicle->update($validated);

        return redirect()->route('vehicles.my-vehicles')
            ->with('success', 'Iklan berhasil diupdate!');
    }

    // Hapus iklan
    public function destroy(Vehicle $vehicle)
    {
        $this->authorizeOwner($vehicle);
        abort_if($vehicle->status === 'terjual', 403, 'Kendaraan yang sudah terjual tidak bisa diedit.');

        foreach ($vehicle->images as $image) {
            storage::disk('public')->delete($image->path);
        }

        $vehicle->delete();

        return redirect()->route('vehicles.my-vehicles')
            ->with('success', 'Iklan berhasil dihapus!');
    }

    // Iklan milik penjual yang lagi login
    public function myVehicles(Request $request){
        $this->authorizeSeller();

        $query = Vehicle::with('images', 'category')
            ->where('user_id', Auth::id());

        if ($request->filled('search')) {
            $keyword = $request->search;
            $query->where(function ($q) use ($keyword) {
                $q->where('title', 'like', "%{$keyword}%")
                ->orWhere('brand', 'like', "%{$keyword}%")
                ->orWhere('model', 'like', "%{$keyword}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $vehicles = $query->latest()->paginate(10)->withQueryString();

        return view('vehicles.my-vehicles', compact('vehicles'));
    }

    // Helper: pastikan yang akses adalah penjual
    private function authorizeSeller(): void
    {
        abort_unless(Auth::user()?->isPenjual(), 403, 'Cuma penjual yang bisa mengakses halaman ini.');
    }

    // Helper: pastikan yang akses adalah pemilik kendaraan
    private function authorizeOwner(Vehicle $vehicle): void
    {
        abort_unless(Auth::id() === $vehicle->user_id, 403, 'Kamu bukan pemilik iklan ini.');
    }
}