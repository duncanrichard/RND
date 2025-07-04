<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\MasterHargaSampleBahanBaku;
use App\Models\MasterPPN;
use App\Models\MasterSatuan;
use App\Models\MasterBahanBaku;
use Illuminate\Support\Facades\DB;

class MasterHargaSampleBahanBakuController extends Controller
{
    public function index()
    {
        $data = MasterHargaSampleBahanBaku::with(['supplierData', 'satuan'])->get();
        $latestKursUSD = MasterPPN::latest('id')->value('kurs_usd');
        $latestPPN = MasterPPN::latest('id')->value('ppn');
        $latestPPH = MasterPPN::latest('id')->value('pph');
        $latestAdditionalCost = MasterPPN::latest('id')->value('additional_cost');

        activity()
            ->causedBy(Auth::user())
            ->tap(fn($activity) => $activity->id_user = Auth::id())
            ->log('Melihat daftar Master Harga Sample Bahan Baku');

        return view('master_harga_sample_bahan_baku.index', compact(
            'data', 'latestKursUSD', 'latestPPN', 'latestPPH', 'latestAdditionalCost'
        ));
    }

    public function create()
    {
        $latestKursUSD = MasterPPN::latest('id')->value('kurs_usd');
        $latestPPN = MasterPPN::latest('id')->value('ppn');
        $latestPPH = MasterPPN::latest('id')->value('pph');
        $latestAdditionalCost = MasterPPN::latest('id')->value('additional_cost');
        $satuan = MasterSatuan::all();
        $bahanBaku = MasterBahanBaku::select('id', 'raw_material')->get();
        $suppliers = DB::connection('purchasing')->table('suppliers')->select('id', 'nama_suplier')->get();

        activity()
            ->causedBy(Auth::user())
            ->tap(fn($activity) => $activity->id_user = Auth::id())
            ->log('Mengakses form tambah harga sample bahan baku');

        return view('master_harga_sample_bahan_baku.create', compact(
            'latestKursUSD', 'latestPPN', 'latestPPH', 'latestAdditionalCost',
            'satuan', 'bahanBaku', 'suppliers'
        ));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'kode_bahan_baku' => 'required|string|exists:master_bahan_bakus,kode',
            'nama_bahan_baku' => 'required|string|exists:master_bahan_bakus,raw_material',
            'principle' => 'required|string',
            'supplier' => 'required|string',
            'harga_usd' => 'nullable|numeric',
            'harga_idr' => 'required|numeric',
            'ppn' => 'required|numeric',
            'pph' => 'required|numeric',
            'harga_total' => 'required|numeric',
            'qty' => 'nullable|numeric',
            'kategori_satuan' => 'required|exists:master_satuan,id',
            'moq' => 'nullable|numeric',
        ]);

        $additionalCostRate = MasterPPN::latest('id')->value('additional_cost') / 100;
        $validatedData['additional_cost'] = $validatedData['harga_total'] * $additionalCostRate;
        $validatedData['harga_akhir'] = $validatedData['harga_total'] + $validatedData['additional_cost'];

        $record = MasterHargaSampleBahanBaku::create($validatedData);

        activity()
            ->causedBy(Auth::user())
            ->performedOn($record)
            ->tap(fn($activity) => $activity->id_user = Auth::id())
            ->withProperties($validatedData)
            ->log('Menambahkan data harga sample bahan baku');

        return redirect()->route('master_harga_sample_bahan_baku.index')->with('success', 'Data berhasil ditambahkan');
    }

    public function edit($id)
    {
        $data = MasterHargaSampleBahanBaku::with('supplierData')->findOrFail($id);
        $latestKursUSD = MasterPPN::latest('id')->value('kurs_usd');
        $latestPPN = MasterPPN::latest('id')->value('ppn');
        $latestPPH = MasterPPN::latest('id')->value('pph');
        $latestAdditionalCost = MasterPPN::latest('id')->value('additional_cost');
        $satuan = MasterSatuan::all();

        activity()
            ->causedBy(Auth::user())
            ->performedOn($data)
            ->tap(fn($activity) => $activity->id_user = Auth::id())
            ->log("Mengakses form edit harga sample bahan baku ID: {$id}");

        return view('master_harga_sample_bahan_baku.edit', compact(
            'data', 'latestKursUSD', 'latestPPN', 'latestPPH', 'latestAdditionalCost', 'satuan'
        ));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'kode_bahan_baku' => 'required|string|exists:master_bahan_bakus,kode',
            'nama_bahan_baku' => 'required|string|exists:master_bahan_bakus,raw_material',
            'principle' => 'required|string',
            'supplier' => 'required|string',
            'harga_usd' => 'nullable|string',
            'harga_idr' => 'required|string',
            'ppn' => 'required|string',
            'pph' => 'required|string',
            'harga_total' => 'required|string',
            'qty' => 'nullable|numeric',
            'kategori_satuan' => 'required|exists:master_satuan,id',
            'moq' => 'nullable|numeric',
            'additional_cost' => 'required|string',
            'harga_akhir' => 'required|string',
        ]);

        $data = MasterHargaSampleBahanBaku::findOrFail($id);
        $data->update($validatedData);

        activity()
            ->causedBy(Auth::user())
            ->performedOn($data)
            ->tap(fn($activity) => $activity->id_user = Auth::id())
            ->withProperties($validatedData)
            ->log("Memperbarui harga sample bahan baku ID: {$id}");

        return redirect()->route('master_harga_sample_bahan_baku.index')->with('success', 'Data berhasil diperbarui');
    }

    public function destroy($id)
    {
        $data = MasterHargaSampleBahanBaku::findOrFail($id);
        $data->delete();

        activity()
            ->causedBy(Auth::user())
            ->performedOn($data)
            ->tap(fn($activity) => $activity->id_user = Auth::id())
            ->log("Menghapus data harga sample bahan baku ID: {$id}");

        return redirect()->route('master_harga_sample_bahan_baku.index')->with('success', 'Data berhasil dihapus');
    }
    public function getBahanBaku(Request $request)
    {
        $query = $request->get('q', ''); // Ambil istilah pencarian dari request
        $bahanBaku = \App\Models\MasterBahanBaku::where('raw_material', 'LIKE', "%{$query}%")
            ->select('id', 'raw_material') // Ambil ID dan Nama Bahan Baku
            ->limit(10) // Batasi jumlah hasil pencarian untuk efisiensi
            ->get();
    
        return response()->json($bahanBaku); // Kembalikan data dalam format JSON
    }
    
    public function getBahanBakuDetail(Request $request)
{
    $bahanBaku = \App\Models\MasterBahanBaku::find($request->id);

    if ($bahanBaku) {
        return response()->json([
            'principle' => $bahanBaku->principle ?? 'Tidak Ditemukan',
            'supplier' => $bahanBaku->supplier ?? 'Tidak Ditemukan',
        ]);
    }

    return response()->json(['message' => 'Data tidak ditemukan'], 404);
}


public function getKategoriSatuan(Request $request)
{
    $query = $request->get('q', '');
    $satuan = \App\Models\MasterSatuan::where('nama_satuan', 'LIKE', "%{$query}%")
        ->select('id', 'nama_satuan')
        ->limit(10)
        ->get();

    return response()->json($satuan);
}

public function searchBahanBaku(Request $request)
{
    $query = $request->get('q', ''); // Ambil istilah pencarian dari request
    $bahanBaku = \App\Models\MasterBahanBaku::where('kode', 'LIKE', "%{$query}%")
        ->orWhere('raw_material', 'LIKE', "%{$query}%")
        ->orWhere('principle', 'LIKE', "%{$query}%")
        ->orWhere('supplier', 'LIKE', "%{$query}%")
        ->select('kode', 'raw_material', 'principle', 'supplier')
        ->limit(10) // Batasi jumlah hasil pencarian
        ->get();

    return response()->json($bahanBaku); // Kembalikan data dalam format JSON
}


}
