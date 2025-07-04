<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengembalian;
use App\Models\PengembalianDetail;
use App\Models\Warehouse;
use App\Models\SuratPerintahProduksi;
use App\Models\SuratPerintahProduksiDetail;
use App\Models\StokBahanBaku;
use App\Models\StokBahanBakuDetail;
use App\Models\StokBahanKemas;
use App\Models\StokBahanKemasDetail;
use App\Models\MasterSatuan;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use App\Exports\PackingListExport;
use App\Exports\PackingListDetailExport;
use Illuminate\Support\Facades\Validator;

class pengembalianController extends Controller
{
    public function index()
    {
        $data = Pengembalian::all();
        $data = Pengembalian::where('departemen', 'Research & Development')->get();
        return view('pengembalian.pengembalian', compact('data'));
    }

    public function create()
    {
        $data = Pengembalian::all();

        return view('pengembalian.store', compact('data'));
    }

    public function Warehouse(Request $request)
{
    $search = $request->get('term', '');

    $result = Warehouse::select('kode_warehouse', 'warehouse')
        ->when($search, function ($query, $search) {
            $query->where('warehouse', 'like', "%$search%");
        })
        ->limit(10)
        ->get()
        ->map(function ($item) {
            return [
                'id' => $item->kode_warehouse,
                'text' => $item->warehouse,
            ];
        });

    return response()->json($result);
}

    public function getStokBarang(Request $request)
    {
        $gudang = $request->get('gudang');
        $kodeBahanBaku = $request->get('kode_bahan_baku', []);
        $kodeBahanKemas = $request->get('kode_bahan_kemas', []);
    
        if (!$gudang) {
            return response()->json(['status' => 'error', 'message' => 'Gudang tidak ditemukan'], 400);
        }
    
        // Ambil stok bahan baku detail
        $stokBakuQuery = StokBahanBakuDetail::query();
        if (!empty($kodeBahanBaku)) {
            $stokBakuQuery->whereIn('kode_bahan_baku', $kodeBahanBaku);
        }
        $stokBakuQuery->whereHas('stokbahanbaku', function ($q) use ($gudang) {
            $q->where('gudang_penyimpanan', $gudang);
        });
        $stokBaku = $stokBakuQuery->get();
    
        // Ambil stok bahan kemas detail
        $stokKemasQuery = StokBahanKemasDetail::query();
        if (!empty($kodeBahanKemas)) {
            $stokKemasQuery->whereIn('kode_bahan_kemas', $kodeBahanKemas);
        }
        $stokKemasQuery->whereHas('stokbahankemas', function ($q) use ($gudang) {
            $q->where('gudang_penyimpanan', $gudang);
        });
        $stokKemas = $stokKemasQuery->get();
    
        // Gabungkan hasil
        $result = [];
    
        $groupedBaku = $stokBaku->groupBy('kode_bahan_baku');
        foreach ($groupedBaku as $kode => $items) {
            $totalJumlah = $items->sum('jumlah_stok_masuk');
            $first = $items->first();
    
            $result[] = [
                'kode_barang' => $kode,
                'nama_barang' => $first->nama_bahan_baku,
                'jumlah' => $totalJumlah,
                'satuan' => $first->satuan ?? '',
                'keterangan' => $first->keterangan ?? '',
                'jenis' => 'Bahan Baku',
            ];
        }
    
        // Group bahan kemas juga kalau perlu
        $groupedKemas = $stokKemas->groupBy('kode_bahan_kemas');
        foreach ($groupedKemas as $kode => $items) {
            $totalJumlah = $items->sum('jumlah');
            $first = $items->first();
    
            $result[] = [
                'kode_barang' => $kode,
                'nama_barang' => $first->nama_bahan_kemas,
                'jumlah' => $totalJumlah,
                'satuan' => $first->satuan ?? '',
                'keterangan' => $first->keterangan ?? '',
                'jenis' => 'Bahan Kemas',
            ];
        }
    
    
        return response()->json(['status' => 'success', 'data' => $result]);
    }

    public function getMasterSatuan()
    {
        $satuan = MasterSatuan::select('nama_satuan as text', 'id')->get();

        return response()->json($satuan);
    }


    public function show($id)
    {
        $mainData = Pengembalian::findOrFail($id);
    
        $detail = PengembalianDetail::where('id_pengembalian', $mainData->id)
            ->select('*')
            ->get()
            ->toArray();
    
        return view('pengembalian.detail', [
            'mainData' => $mainData,
            'detail' => $detail,
        ]);
    }

    public function cariNomorSuratPerintahProduksiPengembalian(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'keyword' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->messages()->first(),
            ]);
        }

        $keyword = $request->input('keyword');

        $data = SuratPerintahProduksi::with('detailsuratperintahproduksi')
            ->where('nomor_surat_perintah_produksi', 'LIKE', "%$keyword%")
            ->get();

        if ($data->isNotEmpty()) {
            return response()->json([
                'status' => 'success',
                'data' => $data,
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Tidak ada hasil yang ditemukan.',
            ]);
        }
    }

    public function detailNomorSuratPerintahProduksiPengembalian(Request $request)
    {
        $request->validate([
            'id' => 'required|integer',
        ]);
    
        $id = $request->input('id');
    
        $SPP = SuratPerintahProduksi::with('detailsuratperintahproduksi')->find($id);
    
        if (!$SPP) {
            return response()->json([
                'status' => 'error',
                'message' => 'Surat Perintah Produksi tidak ditemukan.',
            ], 404);
        }
    
        return response()->json([
            'status' => 'success',
            'data' => $SPP,
        ]);
    }
    

    public function simpanPengembalian(Request $request)
    {
        DB::beginTransaction();
        try {
            $request->validate([
                'nomor_pengembalian_barang' => 'nullable|string',
                'tanggal' => 'nullable|date',
                'id_input' => 'nullable|string',
                'kode_gudang' => 'nullable|string',
                'warehouse' => 'nullable|string',
                'jenis_pengembalian' => 'nullable|string', 
                'nomor_surat_perintah_produksi' => 'nullable|string',
                'tujuan_pengembalian_barang' => 'nullable|string',
                'list_barang' => 'nullable|array',
                'departemen' => 'required|string',
            ]);
    
            $pengembalian = Pengembalian::create([
                'nomor_pengembalian_barang' => $request->nomor_pengembalian_barang,
                'tanggal' => $request->tanggal,
                'id_input' => $request->id_input,
                'kode_gudang' => $request->kode_gudang,
                'nama_gudang' => $request->warehouse,
                'jenis_pengembalian' => $request->jenis_pengembalian === 'nonspp' ? 'Non SPP' : 'SPP',
                'nomor_surat_perintah_produksi' => $request->nomor_surat_perintah_produksi,
                'tujuan_pengembalian_barang' => $request->tujuan_pengembalian_barang,
                'departemen' => $request->departemen, 
            ]);
    
            foreach ($request->list_barang as $item) {
                PengembalianDetail::create([
                    'id_pengembalian' => $pengembalian->id,
                    'nomor_pengembalian_barang' => $request->nomor_pengembalian_barang,
                    'kode_barang' => $item['kode_barang'] ?? '',
                    'nama_barang' => $item['nama_barang'] ?? '',
                    'jumlah' => $item['jumlah'] ?? 0, // Default 0 jika tidak tersedia
                    'satuan' => $item['satuan'] ?? '',
                    'keterangan' => $item['keterangan'] ?? '',
                ]);
            }
    
            DB::commit();
    
            return response()->json([
                'status' => 'success',
                'message' => 'Data pengembalian berhasil disimpan.',
            ], 200);
    
        } catch (\Exception $e) {
            DB::rollBack();
    
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal menyimpan data: ' . $e->getMessage(),
            ], 500);
        }
    }
    
    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            // Cek apakah data pengembalian ada
            $pengembalian = Pengembalian::find($id);

            if (!$pengembalian) {
                return redirect()->back()->with('error', 'Data pengembalian tidak ditemukan.');
            }

            // Hapus detail pengembalian terlebih dahulu
            PengembalianDetail::where('id_pengembalian', $id)->delete();

            // Hapus data utama pengembalian
            $pengembalian->delete();

            DB::commit();

            return redirect()->back()->with('success', 'Data pengembalian berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }

    public function printDetailPengembalian($id)
{
    $data = DB::connection('warehouse')->table('pengembalian AS p')
        ->join('detail_pengembalian AS details', 'p.id', '=', 'details.id_pengembalian')
        ->where('details.id_pengembalian', '=', $id)
        ->select('p.*', 'details.*')
        ->whereNotNull('details.kode_barang')
        ->get();

    $dataArray = $data->toArray();

    $path = public_path('assets\img\dwijaya-logo-01.png');
    $type = strtolower(pathinfo($path, PATHINFO_EXTENSION));
    $data = file_get_contents($path);
    $base64Image = 'data:image/' . $type . ';base64,' . base64_encode($data);

    $pdf = PDF::loadView('print.detail_pengembalian', [
        'data' => $dataArray,
        'base64Image' => $base64Image
    ]);

    return $pdf->stream('pengembalian.pdf');
}

}
