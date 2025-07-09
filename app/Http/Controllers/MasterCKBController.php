<?php

namespace App\Http\Controllers;

use App\Models\MasterCKB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\MasterFormulaProdukJadi;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class MasterCKBController extends Controller
{
    public function index()
    {
        $data = MasterCKB::all();

        activity() ->causedBy(Auth::user())
            ->tap(fn ($activity) => $activity->id_user = Auth::id())->log('Mengakses halaman Master CKB');
        Log::info('User mengakses halaman index CKB', ['user' => Auth::user()?->name]);

        return view('master_ckb.index', compact('data'));
    }

    public function create()
    {
        activity() ->causedBy(Auth::user())
            ->tap(fn ($activity) => $activity->id_user = Auth::id())->log('Mengakses halaman create Master CKB');
        Log::info('User membuka form create CKB', ['user' => Auth::user()?->name]);

        return view('master_ckb.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_produk' => 'required|string|max:255',
            'batch_size_berat' => 'required|numeric',
            'batch_size_satuan' => 'required|string|max:50',
            'kode_produk' => 'required|string|max:100',
            'nomor_cpb' => 'nullable|string|max:100',
            'file_dokumen' => 'nullable|file|mimes:pdf|max:2048',
        ]);

        $filePath = null;

        if ($request->hasFile('file_dokumen')) {
            $filePath = $request->file('file_dokumen')->store('ckb_dokumen', 'public');
        }

        $ckb = MasterCKB::create([
            'nama_produk' => $request->nama_produk,
            'batch_size_berat' => $request->batch_size_berat,
            'batch_size_satuan' => $request->batch_size_satuan,
            'kode_produk' => $request->kode_produk,
            'nomor_cpb' => $request->nomor_cpb,
            'file_dokumen' => $filePath,
        ]);

        activity() ->causedBy(Auth::user())
            ->tap(fn ($activity) => $activity->id_user = Auth::id())->performedOn($ckb)->log('Menambahkan data Master CKB');
        Log::info('User menyimpan data CKB', ['user' => Auth::user()?->name, 'data' => $ckb->toArray()]);

        return redirect()->route('master_ckb.index')->with('success', 'Data berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $item = MasterCKB::findOrFail($id);

        activity() ->causedBy(Auth::user())
            ->tap(fn ($activity) => $activity->id_user = Auth::id())->performedOn($item)->log('Mengakses form edit Master CKB');
        Log::info('User mengedit data CKB', ['user' => Auth::user()?->name, 'id' => $id]);

        return view('master_ckb.edit', compact('item'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_produk' => 'required|string|max:255',
            'batch_size_berat' => 'required|numeric',
            'batch_size_satuan' => 'required|string|max:50',
            'kode_produk' => 'required|string|max:100',
            'nomor_cpb' => 'nullable|string|max:100',
            'file_dokumen' => 'nullable|file|mimes:pdf|max:2048',
        ]);

        $item = MasterCKB::findOrFail($id);
        $oldFile = $item->file_dokumen;

        $filePath = $oldFile;

        if ($request->hasFile('file_dokumen')) {
            if ($oldFile) {
                Storage::disk('public')->delete($oldFile);
            }
            $filePath = $request->file('file_dokumen')->store('ckb_dokumen', 'public');
        }

        $item->update([
            'nama_produk' => $request->nama_produk,
            'batch_size_berat' => $request->batch_size_berat,
            'batch_size_satuan' => $request->batch_size_satuan,
            'kode_produk' => $request->kode_produk,
            'nomor_cpb' => $request->nomor_cpb,
            'file_dokumen' => $filePath,
        ]);

        activity() ->causedBy(Auth::user())
            ->tap(fn ($activity) => $activity->id_user = Auth::id())->performedOn($item)->log('Memperbarui data Master CKB');
        Log::info('User memperbarui data CKB', ['user' => Auth::user()?->name, 'id' => $id]);

        return redirect()->route('master_ckb.index')->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $item = MasterCKB::findOrFail($id);
        $namaProduk = $item->nama_produk;

        if ($item->file_dokumen) {
            Storage::disk('public')->delete($item->file_dokumen);
        }

        $item->delete();

        activity() ->causedBy(Auth::user())
            ->tap(fn ($activity) => $activity->id_user = Auth::id())->log("Menghapus data Master CKB: {$namaProduk}");
        Log::info('User menghapus data CKB', ['user' => Auth::user()?->name, 'id' => $id]);

        return redirect()->route('master_ckb.index')->with('success', 'Data berhasil dihapus.');
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

            activity() ->causedBy(Auth::user())
            ->tap(fn ($activity) => $activity->id_user = Auth::id())->log("Mengambil produk untuk CKB dengan pencarian: $search");
            Log::info('User mengambil produk MasterFormulaProdukJadi', ['user' => Auth::user()?->name, 'search' => $search]);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            Log::error('Error fetching products for CKB', ['message' => $e->getMessage()]);
            return response()->json(['error' => 'Terjadi kesalahan saat mengambil data produk'], 500);
        }
    }

    public function getNomorFormula(Request $request)
    {
        $kodeProduk = $request->input('kode_produk');

        if (!$kodeProduk) {
            return response()->json(['error' => 'Kode produk tidak ditemukan'], 400);
        }

        try {
            $nomorUrut = $this->getLastNomorFormula($kodeProduk);
            $monthYear = now()->format('mY');
            $nomorFormula = "MFP/{$kodeProduk}/{$nomorUrut}/{$monthYear}";

            Log::info('Nomor formula berhasil dibuat', ['nomor_formula' => $nomorFormula, 'user' => Auth::user()?->name]);
            return response()->json(['nomor_formula' => $nomorFormula], 200);
        } catch (\Exception $e) {
            Log::error('Gagal membuat nomor formula', ['message' => $e->getMessage()]);
            return response()->json(['error' => 'Terjadi kesalahan saat membuat nomor formula'], 500);
        }
    }

    private function getLastNomorFormula($kodeProduk)
    {
        $lastFormula = MasterFormulaProdukJadi::where('kode_produk', $kodeProduk)
            ->orderBy('created_at', 'desc')
            ->first();

        if ($lastFormula) {
            $lastNomor = explode('/', $lastFormula->nomor_formula)[2] ?? '000000';
            return str_pad(((int)$lastNomor) + 1, 6, '0', STR_PAD_LEFT);
        }

        return "000001";
    }
}
