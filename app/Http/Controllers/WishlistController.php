<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    // Halaman daftar wishlist milik pembeli yang login
    public function index()
    {
        $wishlists = Wishlist::with(['vehicle.images', 'vehicle.category', 'vehicle.seller'])
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('wishlists.index', compact('wishlists'));
    }

    // Toggle: kalau belum ada di wishlist -> simpan, kalau udah ada -> hapus
    public function toggle(Vehicle $vehicle)
    {
        $wishlist = Wishlist::where('user_id', Auth::id())
            ->where('vehicle_id', $vehicle->id)
            ->first();

        if ($wishlist) {
            $wishlist->delete();
            $message = 'Dihapus dari wishlist.';
            $status = 'removed';
        } else {
            Wishlist::create([
                'user_id'    => Auth::id(),
                'vehicle_id' => $vehicle->id,
            ]);
            $message = 'Ditambahkan ke wishlist!';
            $status = 'added';
        }

        return back()->with('success', $message);
    }

    // Hapus langsung dari halaman wishlist (tombol "hapus")
    public function destroy(Wishlist $wishlist)
    {
        abort_unless(Auth::id() === $wishlist->user_id, 403, 'Ini bukan wishlist kamu.');

        $wishlist->delete();

        return back()->with('success', 'Dihapus dari wishlist.');
    }
}