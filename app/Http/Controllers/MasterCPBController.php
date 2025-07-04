<?php

namespace App\Http\Controllers;

use App\Models\MasterCPB;
use Illuminate\Http\Request;
use App\Models\MasterProdukJadi;
use App\Models\MasterFormulaProdukJadi;

class MasterCPBController extends Controller
{
    public function index()
    {
        $data = MasterCPB::all(); // Fetch all records
        return view('master_cpb.index', compact('data'));
    }

    public function create()
    {
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

        MasterCPB::create([
            'nama_produk' => $request->nama_produk,
            'batch_size_berat' => $request->batch_size_berat,
            'batch_size_satuan' => $request->batch_size_satuan,
            'kode_produk' => $request->kode_produk,
            'nomor_cpb' => $request->nomor_cpb,
            'file_dokumen' => $filePath,
        ]);

        return redirect()->route('master_cpb.index')->with('success', 'Data berhasil ditambahkan.');
    }

    public function edit($id)
{
    $item = MasterCPB::findOrFail($id);
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

    $filePath = $item->file_dokumen;

    if ($request->hasFile('file_dokumen')) {
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

    return redirect()->route('master_cpb.index')->with('success', 'Data berhasil diperbarui.');
}

public function destroy($id)
{
    $item = MasterCPB::findOrFail($id);
    if ($item->file_dokumen) {
        \Storage::disk('public')->delete($item->file_dokumen);
    }
    $item->delete();

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
        return response()->json($result, 200);
    } catch (\Exception $e) {
        \Log::error('Error fetching products:', ['message' => $e->getMessage()]);
        return response()->json(['error' => 'Terjadi kesalahan saat mengambil data produk'], 500);
    }
}

}
