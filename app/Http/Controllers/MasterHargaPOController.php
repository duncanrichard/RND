<?php

namespace App\Http\Controllers;

use App\Models\MasterHargaPO;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MasterHargaPOController extends Controller
{
    public function index()
    {
        $data = MasterHargaPO::all();

        activity()
            ->causedBy(Auth::user())
            ->tap(fn ($a) => $a->id_user = Auth::id())
            ->log('Mengakses halaman daftar Harga PO');

        return view('master_harga_po.index', compact('data'));
    }

    public function create()
    {
        activity()
            ->causedBy(Auth::user())
            ->tap(fn ($a) => $a->id_user = Auth::id())
            ->log('Mengakses form tambah Harga PO');

        return view('master_harga_po.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'harga' => 'required|numeric|min:0',
        ]);

        $hargaPO = MasterHargaPO::create($request->all());

        activity()
            ->causedBy(Auth::user())
            ->performedOn($hargaPO)
            ->tap(fn ($a) => $a->id_user = Auth::id())
            ->withProperties($request->only(['harga']))
            ->log('Menambahkan data Harga PO');

        return redirect()->route('master_harga_po.index')->with('success', 'Harga PO berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $data = MasterHargaPO::findOrFail($id);

        activity()
            ->causedBy(Auth::user())
            ->performedOn($data)
            ->tap(fn ($a) => $a->id_user = Auth::id())
            ->log('Mengakses form edit Harga PO');

        return view('master_harga_po.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'harga' => 'required|numeric|min:0',
        ]);

        $data = MasterHargaPO::findOrFail($id);
        $data->update($request->all());

        activity()
            ->causedBy(Auth::user())
            ->performedOn($data)
            ->tap(fn ($a) => $a->id_user = Auth::id())
            ->withProperties($request->only(['harga']))
            ->log('Memperbarui data Harga PO');

        return redirect()->route('master_harga_po.index')->with('success', 'Harga PO berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $data = MasterHargaPO::findOrFail($id);
        $data->delete();

        activity()
            ->causedBy(Auth::user())
            ->performedOn($data)
            ->tap(fn ($a) => $a->id_user = Auth::id())
            ->withProperties(['id' => $id])
            ->log('Menghapus data Harga PO');

        return redirect()->route('master_harga_po.index')->with('success', 'Harga PO berhasil dihapus!');
    }
}
