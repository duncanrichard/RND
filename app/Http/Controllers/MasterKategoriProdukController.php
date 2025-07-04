<?php

namespace App\Http\Controllers;

use App\Models\MasterKategoriProduk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MasterKategoriProdukController extends Controller
{
    public function index()
    {
        $categories = MasterKategoriProduk::all();

        activity()
            ->causedBy(Auth::user())
            ->tap(fn($a) => $a->id_user = Auth::id())
            ->log('Mengakses halaman Master Kategori Produk');

        return view('master_kategori_produk.index', compact('categories'));
    }

    public function create()
    {
        activity()
            ->causedBy(Auth::user())
            ->tap(fn($a) => $a->id_user = Auth::id())
            ->log('Mengakses form tambah Kategori Produk');

        return view('master_kategori_produk.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode' => 'required|string|max:50',
            'nama_kategori' => 'required|string|max:255',
        ]);

        $kategori = MasterKategoriProduk::create([
            'kode' => $validated['kode'],
            'nama_kategori' => $validated['nama_kategori'],
        ]);

        activity()
            ->causedBy(Auth::user())
            ->performedOn($kategori)
            ->tap(fn($a) => $a->id_user = Auth::id())
            ->withProperties($validated)
            ->log('Menambahkan Kategori Produk');

        return redirect()->route('master_kategori_produk.index')->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $category = MasterKategoriProduk::findOrFail($id);

        activity()
            ->causedBy(Auth::user())
            ->performedOn($category)
            ->tap(fn($a) => $a->id_user = Auth::id())
            ->log('Mengakses form edit Kategori Produk');

        return view('master_kategori_produk.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'kode' => 'required|string|max:255',
            'nama_kategori' => 'required|string|max:255',
        ]);

        $category = MasterKategoriProduk::findOrFail($id);
        $category->update($validated);

        activity()
            ->causedBy(Auth::user())
            ->performedOn($category)
            ->tap(fn($a) => $a->id_user = Auth::id())
            ->withProperties($validated)
            ->log('Memperbarui Kategori Produk');

        return redirect()->route('master_kategori_produk.index')->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $category = MasterKategoriProduk::findOrFail($id);
        $category->delete();

        activity()
            ->causedBy(Auth::user())
            ->performedOn($category)
            ->tap(fn($a) => $a->id_user = Auth::id())
            ->withProperties(['id' => $id])
            ->log('Menghapus Kategori Produk');

        return redirect()->route('master_kategori_produk.index')->with('success', 'Kategori berhasil dihapus.');
    }
}
