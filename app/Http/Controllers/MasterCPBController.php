<?php

namespace App\Http\Controllers;

use App\Models\MasterCPB;
use Illuminate\Http\Request;
use App\Models\MasterFormulaProdukJadi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class MasterCPBController extends Controller
{
    public function index()
    {
        $data = MasterCPB::all();

        activity()
            ->causedBy(Auth::user())
            ->tap(fn ($activity) => $activity->id_user = Auth::id())
            ->log('Mengakses halaman Master CPB');

        Log::info('User mengakses halaman index CPB', [
            'user' => Auth::user()?->name
        ]);

        return view('master_cpb.index', compact('data'));
    }

    public function create()
    {
        activity()
            ->causedBy(Auth::user())
            ->tap(fn ($activity) => $activity->id_user = Auth::id())
            ->log('Mengakses halaman create Master CPB');

        Log::info('User membuka halaman create CPB', [
            'user' => Auth::user()?->name
        ]);

        return view('master_cpb.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_produk' => 'required|string|max:255',
            'batch_size_berat' => 'required|numeric',
            'batch_size_satuan' => 'required|string|max:50',
            'kode_produk' => 'required|string|max:100',
            'nomor_cpb' => 'required|string|max:100',
            'file_dokumen' => 'nullable|file|mimes:pdf|max:2048',
        ]);

        $filePath = null;

        if ($request->hasFile('file_dokumen')) {
            $filePath = $request->file('file_dokumen')->store('cpb_dokumen', 'public');
        }

        $cpb = MasterCPB::create([
            'nama_produk' => $request->nama_produk,
            'batch_size_berat' => $request->batch_size_berat,
            'batch_size_satuan' => $request->batch_size_satuan,
            'kode_produk' => $request->kode_produk,
            'nomor_cpb' => $request->nomor_cpb,
            'file_dokumen' => $filePath,
        ]);

        activity()
            ->causedBy(Auth::user())
            ->tap(fn ($activity) => $activity->id_user = Auth::id())
            ->performedOn($cpb)
            ->log('Menyimpan data Master CPB');

        Log::info('User menyimpan CPB baru', [
            'user' => Auth::user()?->name,
            'data' => $cpb->toArray()
        ]);

        return redirect()->route('master_cpb.index')->with('success', 'Data berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $item = MasterCPB::findOrFail($id);

        activity()
            ->causedBy(Auth::user())
            ->tap(fn ($activity) => $activity->id_user = Auth::id())
            ->performedOn($item)
            ->log('Mengakses halaman edit Master CPB');

        Log::info('User membuka halaman edit CPB', [
            'user' => Auth::user()?->name,
            'id' => $id
        ]);

        return view('master_cpb.edit', compact('item'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_produk' => 'required|string|max:255',
            'batch_size_berat' => 'required|numeric',
            'batch_size_satuan' => 'required|string|max:50',
            'kode_produk' => 'required|string|max:100',
            'nomor_cpb' => 'required|string|max:100',
            'file_dokumen' => 'nullable|file|mimes:pdf|max:2048',
        ]);

        $item = MasterCPB::findOrFail($id);
        $oldFile = $item->file_dokumen;

        $filePath = $oldFile;
        if ($request->hasFile('file_dokumen')) {
            if ($oldFile) {
                Storage::disk('public')->delete($oldFile);
            }
            $filePath = $request->file('file_dokumen')->store('cpb_dokumen', 'public');
        }

        $item->update([
            'nama_produk' => $request->nama_produk,
            'batch_size_berat' => $request->batch_size_berat,
            'batch_size_satuan' => $request->batch_size_satuan,
            'kode_produk' => $request->kode_produk,
            'nomor_cpb' => $request->nomor_cpb,
            'file_dokumen' => $filePath,
        ]);

        activity()
            ->causedBy(Auth::user())
            ->tap(fn ($activity) => $activity->id_user = Auth::id())
            ->performedOn($item)
            ->log('Memperbarui data Master CPB');

        Log::info('User memperbarui CPB', [
            'user' => Auth::user()?->name,
            'id' => $id
        ]);

        return redirect()->route('master_cpb.index')->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $item = MasterCPB::findOrFail($id);

        if ($item->file_dokumen) {
            Storage::disk('public')->delete($item->file_dokumen);
        }

        $item->delete();

        activity()
            ->causedBy(Auth::user())
            ->tap(fn ($activity) => $activity->id_user = Auth::id())
            ->withProperties(['nama_produk' => $item->nama_produk])
            ->log('Menghapus data Master CPB');

        Log::info('User menghapus CPB', [
            'user' => Auth::user()?->name,
            'id' => $id
        ]);

        return redirect()->route('master_cpb.index')->with('success', 'Data berhasil dihapus.');
    }

    public function getProducts(Request $request)
    {
        $search = $request->input('search', '');

        $produkJadi = MasterFormulaProdukJadi::query();

        if ($search) {
            $produkJadi->where('kode_produk', 'like', "%{$search}%")
                ->orWhere('nama_produk', 'like', "%{$search}%");
        }

        try {
            $result = $produkJadi->select('id', 'kode_produk', 'nama_produk', 'batch_size_berat', 'batch_size_satuan')
                ->limit(10)
                ->get();

            activity()
                ->causedBy(Auth::user())
            ->tap(fn ($activity) => $activity->id_user = Auth::id())
                ->log('Mengambil data produk untuk CPB' . ($search ? " dengan pencarian: $search" : ''));

            Log::info('User mengambil data produk untuk CPB', [
                'user' => Auth::user()?->name,
                'search' => $search
            ]);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            Log::error('Error fetching products for CPB', ['message' => $e->getMessage()]);
            return response()->json(['error' => 'Terjadi kesalahan saat mengambil data produk'], 500);
        }
    }
}
