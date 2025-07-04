<?php

namespace App\Http\Controllers;

use App\Models\MasterSatuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MasterSatuanController extends Controller
{
    public function index()
    {
        $satuan = MasterSatuan::orderBy('created_at', 'asc')->get();

        activity()
            ->causedBy(Auth::user())
            ->tap(fn ($activity) => $activity->id_user = Auth::id())
            ->log('Melihat daftar Master Satuan');

        return view('master_satuan.index', compact('satuan'));
    }

    public function create()
    {
        $lastSatuan = MasterSatuan::orderBy('id', 'desc')->first();
        $lastNumber = $lastSatuan ? intval(substr($lastSatuan->deskripsi, 3)) : 0;
        $newCode = 'ST-' . str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);

        activity()
            ->causedBy(Auth::user())
            ->tap(fn ($activity) => $activity->id_user = Auth::id())
            ->log('Mengakses form tambah Master Satuan');

        return view('master_satuan.create', compact('newCode'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_satuan' => 'required|string|max:255',
        ]);

        $lastSatuan = MasterSatuan::orderBy('id', 'desc')->first();
        $lastNumber = $lastSatuan ? intval(substr($lastSatuan->deskripsi, 3)) : 0;
        $newCode = 'ST-' . str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);

        $satuan = MasterSatuan::create([
            'deskripsi' => $newCode,
            'nama_satuan' => $request->nama_satuan,
        ]);

        activity()
            ->causedBy(Auth::user())
            ->performedOn($satuan)
            ->tap(fn ($activity) => $activity->id_user = Auth::id())
            ->withProperties([
                'deskripsi' => $newCode,
                'nama_satuan' => $request->nama_satuan
            ])
            ->log('Menambahkan Master Satuan baru');

        return redirect()->route('master_satuan.index')
            ->with('success', 'Data Master Satuan berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $satuan = MasterSatuan::findOrFail($id);

        activity()
            ->causedBy(Auth::user())
            ->performedOn($satuan)
            ->tap(fn ($activity) => $activity->id_user = Auth::id())
            ->log('Mengakses form edit Master Satuan');

        return view('master_satuan.edit', compact('satuan'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_satuan' => 'required|string|max:255',
            'deskripsi' => 'nullable|string'
        ]);

        $satuan = MasterSatuan::findOrFail($id);
        $satuan->update($request->only(['nama_satuan', 'deskripsi']));

        activity()
            ->causedBy(Auth::user())
            ->performedOn($satuan)
            ->tap(fn ($activity) => $activity->id_user = Auth::id())
            ->withProperties($request->only(['nama_satuan', 'deskripsi']))
            ->log('Memperbarui Master Satuan');

        return redirect()->route('master_satuan.index')
            ->with('success', 'Data Master Satuan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $satuan = MasterSatuan::findOrFail($id);
        $satuan->delete();

        activity()
            ->causedBy(Auth::user())
            ->performedOn($satuan)
            ->tap(fn ($activity) => $activity->id_user = Auth::id())
            ->withProperties(['id' => $id, 'nama_satuan' => $satuan->nama_satuan])
            ->log('Menghapus Master Satuan');

        return redirect()->route('master_satuan.index')
            ->with('success', 'Data Master Satuan berhasil dihapus.');
    }
}
