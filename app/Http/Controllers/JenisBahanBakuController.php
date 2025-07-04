<?php

namespace App\Http\Controllers;

use App\Models\JenisBahanBaku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JenisBahanBakuController extends Controller
{
    public function index()
    {
        $jenisBahanBakus = JenisBahanBaku::all();

        activity()
            ->causedBy(Auth::user())
            ->tap(fn ($activity) => $activity->id_user = Auth::id())
            ->log('Melihat daftar Kategori Bahan Baku');

        return view('jenis_bahan_baku.index', compact('jenisBahanBakus'));
    }

    public function create()
    {
        activity()
            ->causedBy(Auth::user())
            ->tap(fn ($activity) => $activity->id_user = Auth::id())
            ->log('Mengakses form tambah Kategori Bahan Baku');

        return view('jenis_bahan_baku.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'jenis_bahan_baku' => 'required',
            'nama_bahan_baku' => 'required',
        ]);

        $jenisBahanBaku = JenisBahanBaku::create($request->all());

        activity()
            ->causedBy(Auth::user())
            ->performedOn($jenisBahanBaku)
            ->tap(fn ($activity) => $activity->id_user = Auth::id())
            ->withProperties($request->only(['jenis_bahan_baku', 'nama_bahan_baku']))
            ->log('Menambahkan Kategori Bahan Baku');

        return redirect()->route('jenis-bahan-baku.index')
            ->with('success', 'Kategori Bahan Baku berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $jenisBahanBaku = JenisBahanBaku::findOrFail($id);

        activity()
            ->causedBy(Auth::user())
            ->performedOn($jenisBahanBaku)
            ->tap(fn ($activity) => $activity->id_user = Auth::id())
            ->log('Mengakses form edit Kategori Bahan Baku');

        return view('jenis_bahan_baku.edit', compact('jenisBahanBaku'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'jenis_bahan_baku' => 'required',
            'nama_bahan_baku' => 'required',
        ]);

        $jenisBahanBaku = JenisBahanBaku::findOrFail($id);
        $jenisBahanBaku->update($request->all());

        activity()
            ->causedBy(Auth::user())
            ->performedOn($jenisBahanBaku)
            ->tap(fn ($activity) => $activity->id_user = Auth::id())
            ->withProperties($request->only(['jenis_bahan_baku', 'nama_bahan_baku']))
            ->log('Memperbarui Kategori Bahan Baku');

        return redirect()->route('jenis-bahan-baku.index')
            ->with('success', 'Kategori Bahan Baku berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $jenisBahanBaku = JenisBahanBaku::findOrFail($id);
        $jenisBahanBaku->delete();

        activity()
            ->causedBy(Auth::user())
            ->performedOn($jenisBahanBaku)
            ->tap(fn ($activity) => $activity->id_user = Auth::id())
            ->withProperties(['id' => $id, 'nama_bahan_baku' => $jenisBahanBaku->nama_bahan_baku])
            ->log('Menghapus Kategori Bahan Baku');

        return redirect()->route('jenis-bahan-baku.index')
            ->with('success', 'Kategori Bahan Baku berhasil dihapus.');
    }
}
