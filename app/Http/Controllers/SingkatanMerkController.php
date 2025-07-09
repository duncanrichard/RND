<?php

namespace App\Http\Controllers;

use App\Models\SingkatanMerk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class SingkatanMerkController extends Controller
{
    public function index()
    {
        Log::info('Mengakses halaman Singkatan Merk', [
            'user_id' => optional(Auth::user())->id,
            'timestamp' => now()
        ]);

        activity()
            ->causedBy(Auth::user())
            ->tap(fn ($activity) => $activity->id_user = Auth::id())
            ->log('Mengakses halaman Master Singkatan Merk');

        $data = SingkatanMerk::all();
        return view('singkatan_merk.index', compact('data'));
    }

    public function create()
    {
        Log::info('Mengakses halaman create Singkatan Merk', [
            'user_id' => optional(Auth::user())->id,
            'timestamp' => now()
        ]);

        activity()
            ->causedBy(Auth::user())
            ->tap(fn ($activity) => $activity->id_user = Auth::id())
            ->log('Mengakses halaman tambah Singkatan Merk');

        return view('singkatan_merk.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_merk' => 'required|unique:singkatan_merk,nama_merk',
            'singkatan_merk' => 'required|unique:singkatan_merk,singkatan_merk',
            'tahun' => 'required|digits:4',
            'lokasi' => 'required',
        ], [
            'nama_merk.unique' => 'Nama Merk sudah ada, silakan gunakan yang lain.',
            'singkatan_merk.unique' => 'Singkatan Merk sudah ada, silakan gunakan yang lain.'
        ]);

        $data = SingkatanMerk::create($request->all());

        Log::info('Menyimpan data Singkatan Merk baru', [
            'user_id' => optional(Auth::user())->id,
            'data_id' => $data->id,
            'data' => $data->toArray(),
            'timestamp' => now()
        ]);

        activity()
            ->causedBy(Auth::user())
            ->tap(fn ($activity) => $activity->id_user = Auth::id())
            ->withProperties(['data' => $data->toArray()])
            ->log("Menambahkan Singkatan Merk ID: {$data->id}");

        return redirect()->route('singkatan-merk.index')->with('success', 'Data berhasil ditambahkan');
    }

    public function edit($id)
    {
        $merk = SingkatanMerk::findOrFail($id);

        Log::info("Mengakses halaman edit Singkatan Merk ID: $id", [
            'user_id' => optional(Auth::user())->id,
            'timestamp' => now()
        ]);

        activity()
            ->causedBy(Auth::user())
            ->tap(fn ($activity) => $activity->id_user = Auth::id())
            ->log("Mengakses halaman edit Singkatan Merk ID: $id");

        return view('singkatan_merk.edit', compact('merk'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_merk' => 'required',
            'singkatan_merk' => 'required',
            'tahun' => 'required|digits:4',
            'lokasi' => 'required',
        ]);

        $merk = SingkatanMerk::findOrFail($id);
        $merk->update($request->all());

        Log::info("Memperbarui data Singkatan Merk ID: $id", [
            'user_id' => optional(Auth::user())->id,
            'data' => $merk->toArray(),
            'timestamp' => now()
        ]);

        activity()
            ->causedBy(Auth::user())
            ->tap(fn ($activity) => $activity->id_user = Auth::id())
            ->withProperties(['data' => $merk->toArray()])
            ->log("Memperbarui Singkatan Merk ID: $id");

        return redirect()->route('singkatan-merk.index')->with('success', 'Data berhasil diperbarui');
    }

    public function destroy($id)
    {
        $merk = SingkatanMerk::findOrFail($id);
        $merk->delete();

        Log::warning("Menghapus data Singkatan Merk ID: $id", [
            'user_id' => optional(Auth::user())->id,
            'timestamp' => now()
        ]);

        activity()
            ->causedBy(Auth::user())
            ->tap(fn ($activity) => $activity->id_user = Auth::id())
            ->log("Menghapus Singkatan Merk ID: $id");

        return redirect()->route('singkatan-merk.index')->with('success', 'Data berhasil dihapus');
    }
}
