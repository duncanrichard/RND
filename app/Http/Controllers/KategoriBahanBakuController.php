<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KategoriBahanBaku;
use Illuminate\Support\Facades\Auth;

class KategoriBahanBakuController extends Controller
{
    public function index()
    {
        $data = KategoriBahanBaku::all();

        activity()
            ->causedBy(Auth::user())
            ->tap(fn ($activity) => $activity->id_user = Auth::id())
            ->log('Melihat daftar Kategori Bahan Baku');

        return view('kategori_bahan_baku.index', compact('data'));
    }

    public function create()
    {
        activity()
            ->causedBy(Auth::user())
            ->tap(fn ($activity) => $activity->id_user = Auth::id())
            ->log('Mengakses form tambah Kategori Bahan Baku');

        return view('kategori_bahan_baku.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_kategori' => 'required|unique:kategori_bahan_baku,kode_kategori',
            'nama_kategori' => 'required|string',
        ]);

        $kategori = KategoriBahanBaku::create($request->all());

        activity()
            ->causedBy(Auth::user())
            ->performedOn($kategori)
            ->tap(fn ($activity) => $activity->id_user = Auth::id())
            ->withProperties($request->only(['kode_kategori', 'nama_kategori']))
            ->log('Menambahkan Kategori Bahan Baku');

        return redirect()->route('kategori_bahan_baku.index')
            ->with('success', 'Data berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $data = KategoriBahanBaku::findOrFail($id);

        activity()
            ->causedBy(Auth::user())
            ->performedOn($data)
            ->tap(fn ($activity) => $activity->id_user = Auth::id())
            ->log('Mengakses form edit Kategori Bahan Baku');

        return view('kategori_bahan_baku.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'kode_kategori' => 'required|unique:kategori_bahan_baku,kode_kategori,' . $id,
            'nama_kategori' => 'required|string',
        ]);

        $data = KategoriBahanBaku::findOrFail($id);
        $data->update($request->all());

        activity()
            ->causedBy(Auth::user())
            ->performedOn($data)
            ->tap(fn ($activity) => $activity->id_user = Auth::id())
            ->withProperties($request->only(['kode_kategori', 'nama_kategori']))
            ->log('Memperbarui Kategori Bahan Baku');

        return redirect()->route('kategori_bahan_baku.index')
            ->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $data = KategoriBahanBaku::findOrFail($id);
        $data->delete();

        activity()
            ->causedBy(Auth::user())
            ->performedOn($data)
            ->tap(fn ($activity) => $activity->id_user = Auth::id())
            ->withProperties([
                'id' => $id,
                'kode_kategori' => $data->kode_kategori,
                'nama_kategori' => $data->nama_kategori
            ])
            ->log('Menghapus Kategori Bahan Baku');

        return redirect()->route('kategori_bahan_baku.index')
            ->with('success', 'Data berhasil dihapus.');
    }
}
