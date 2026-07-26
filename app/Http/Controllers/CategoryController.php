<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    // Daftar kategori (misal buat halaman "cari berdasarkan kategori")
    public function index()
    {
        $categories = Category::withCount('vehicles')->get();

        return view('categories.index', compact('categories'));
    }

    // Kendaraan dalam 1 kategori tertentu
    public function show(Category $category)
    {
        $vehicles = $category->vehicles()
            ->with(['images', 'seller'])
            ->where('status', 'tersedia')
            ->latest()
            ->paginate(12);

        return view('categories.show', compact('category', 'vehicles'));
    }

    // Form tambah kategori baru (penjual)
    public function create()
    {
        $this->authorizeSeller();

        return view('categories.create');
    }

    // Simpan kategori baru
    public function store(Request $request)
    {
        $this->authorizeSeller();

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
        ]);

        Category::create([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
        ]);

        return redirect()->route('categories.index')
            ->with('success', 'Kategori berhasil ditambahkan!');
    }

    private function authorizeSeller(): void
    {
        abort_unless(Auth::user()?->isPenjual(), 403, 'Cuma penjual yang bisa mengakses halaman ini.');
    }
}