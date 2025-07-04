<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\PurchaseRequest;
use App\Models\PurchaseRequestDetail;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log; // Tambahkan ini di atas
class PurchaseRequestController extends Controller
{
    public function index()
    {
        // Ambil hanya data dari departemen "RND"
        $purchaseRequests = PurchaseRequest::where('departemen', 'Research & Development')
            ->orderBy('tanggal', 'asc')
            ->get();
    
        // Kirim data ke view
        return view('purchase-requests.index', compact('purchaseRequests'));
    }
    


    public function create()
    {
        // Ambil kode departemen RND secara langsung (tidak perlu ambil dari DB jika sudah pasti RND)
        $kodeDepartemen = 'RD';
    
        // Cek RND terakhir untuk departemen RND tahun ini
        $latestRND = PurchaseRequest::on('purchasing')
            ->where('departemen', $kodeDepartemen)
            ->whereYear('tanggal', now()->year)
            ->orderBy('no_purchase_request', 'desc')
            ->first();
    
        // Ambil nomor urut terakhir
        if ($latestRND) {
            // Ambil angka urut dari no_purchase_request, contoh: "FPR/RND/0012/25"
            preg_match('/FPR\/RD\/(\d{4})\/\d{2}/', $latestRND->no_purchase_request, $matches);
            $lastNumber = isset($matches[1]) ? (int) $matches[1] : 0;
        } else {
            $lastNumber = 0;
        }
    
        // Generate nomor baru
        $newNumber = $lastNumber + 1;
        $noPurchaseRequest = sprintf('FPR/%s/%04d/%s', $kodeDepartemen, $newNumber, now()->format('y'));
    
        return view('purchase-requests.create', compact('noPurchaseRequest'));
    }
    
    public function searchBarang(Request $request)
    {
        $query = $request->input('query');
        $kategori = $request->input('kategori');
    
        if ($kategori === 'Aset') {
            // Aset tetap pakai koneksi HRIS
            $results = DB::connection('hris')
                ->table('aset')
                ->select('kode_aset as kode_barang', 'nama_aset as nama_barang')
                ->where('kode_aset', 'like', "%{$query}%")
                ->orWhere('nama_aset', 'like', "%{$query}%")
                ->get();
        } elseif ($kategori === 'Bahan Kemas') {
            // Bahan Kemas pakai koneksi default (new_rnd)
            $results = DB::table('master_kemasan')
                ->select('kode_kemasan as kode_barang', 'nama_kemasan as nama_barang')
                ->where('kode_kemasan', 'like', "%{$query}%")
                ->orWhere('nama_kemasan', 'like', "%{$query}%")
                ->get();
        } elseif ($kategori === 'Bahan Baku') {
            // Bahan Baku juga pakai koneksi default (new_rnd)
            $results = DB::table('bahan_bakus')
                ->join('jenis_bahan_baku', 'bahan_bakus.kode_bahan_baku', '=', 'jenis_bahan_baku.id')
                ->select(
                    DB::raw("CONCAT(jenis_bahan_baku.jenis_bahan_baku, '-', bahan_bakus.urutan_kode_bahan_baku) as kode_barang"),
                    'bahan_bakus.nama_coding as nama_barang'
                )
                ->where('jenis_bahan_baku.jenis_bahan_baku', 'like', "%{$query}%")
                ->orWhere('bahan_bakus.nama_coding', 'like', "%{$query}%")
                ->orWhere('bahan_bakus.kode_bahan_baku', 'like', "%{$query}%")
                ->orWhere('bahan_bakus.urutan_kode_bahan_baku', 'like', "%{$query}%")
                ->get();
        } else {
            return response()->json([]);
        }
    
        return response()->json($results);
    }
    
    
    
    public function searchAsset(Request $request)
    {
        $query = $request->input('query');

        // Gunakan koneksi database kedua
        $results = DB::connection('hris')
            ->table('aset')
            ->select('kode_aset', 'nama_aset')
            ->where('kode_aset', 'like', "%{$query}%")
            ->orWhere('nama_aset', 'like', "%{$query}%")
            ->get();

        return response()->json($results);
    }
    public function getMasterSatuan()
    {
        // Sebelumnya: pakai DB::connection('new_rnd')
        // Sekarang: cukup pakai default connection saja
        $satuan = DB::table('master_satuan')
            ->select('nama_satuan')
            ->get();
    
        return response()->json($satuan);
    }
    

    public function store(Request $request)
{
    $validatedData = $request->validate([
        'tanggal' => 'required|date',
        'id_input' => 'required|string|max:255',
        'departemen' => 'required|string|max:255',
        'kategori_barang' => 'required|string|max:255',
        'details' => 'required|array',
        'details.*.kode_barang' => 'required|string|max:255',
        'details.*.nama_barang' => 'required|string|max:255',
        'details.*.kategori' => 'required|string|max:255',
        'details.*.jumlah' => 'required|integer|min:1',
        'details.*.satuan' => 'required|string|max:255',
        'details.*.rencana_kedatangan' => 'required|date',
        'details.*.keterangan' => 'nullable|string|max:255',
        'details.*.dokumen' => 'nullable|file|mimes:pdf|max:2048',
    ]);

    DB::beginTransaction();

    try {
        // Kode departemen diset langsung
        $kodeDepartemen = 'RD';

        // Cek PR terakhir berdasarkan departemen dan tahun
        $latestRND = PurchaseRequest::where('departemen', $kodeDepartemen)
            ->whereYear('tanggal', now()->year)
            ->orderBy('no_purchase_request', 'desc')
            ->first();

        if ($latestRND) {
            preg_match('/FPR\/RND\/(\d{4})\/\d{2}/', $latestRND->no_purchase_request, $matches);
            $lastNumber = isset($matches[1]) ? (int) $matches[1] : 0;
        } else {
            $lastNumber = 0;
        }

        $newNumber = $lastNumber + 1;
        $noPurchaseRequest = $request->input('no_purchase_request');


        // Simpan data utama PR
        $purchaseRequest = PurchaseRequest::create([
            'no_purchase_request' => $noPurchaseRequest,
            'tanggal' => $validatedData['tanggal'],
            'id_input' => $validatedData['id_input'],
            'departemen' => $validatedData['departemen'],
            'kategori_barang' => $validatedData['kategori_barang'],
        ]);

        foreach ($validatedData['details'] as $index => $detail) {
            $dokumenPath = null;

            if (isset($request->file('details')[$index]['dokumen']) &&
                $request->file('details')[$index]['dokumen'] instanceof \Illuminate\Http\UploadedFile
            ) {
                $dokumen = $request->file('details')[$index]['dokumen'];
                $dokumenPath = $dokumen->storeAs(
                    "public/PurchaseRequest/{$noPurchaseRequest}",
                    "{$detail['kode_barang']}.pdf"
                );
            }

            PurchaseRequestDetail::create([
                'purchase_request_id' => $purchaseRequest->id,
                'kode_barang' => $detail['kode_barang'],
                'nama_barang' => $detail['nama_barang'],
                'kategori' => $detail['kategori'],
                'jumlah' => $detail['jumlah'],
                'satuan' => $detail['satuan'],
                'rencana_kedatangan' => $detail['rencana_kedatangan'],
                'keterangan' => $detail['keterangan'] ?? null,
                'dokumen' => $dokumenPath,
            ]);
        }

        DB::commit();
        return redirect()->route('purchase-requests.index')
            ->with('success', 'Purchase Request dan detail barang berhasil disimpan.');

    } catch (\Exception $e) {
        DB::rollBack();
        return redirect()->back()
            ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
            ->withInput();
    }
}

    public function edit($id)
    {
        $kodeDepartemen = DB::connection('hris')
            ->table('departemen')
            ->where('nama_departemen', 'Purchasing')
            ->value('kode_departemen');
    
        if (!$kodeDepartemen) {
            return redirect()->back()->with('error', 'Departemen "Purchasing" tidak ditemukan di database.');
        }
    
        $purchaseRequest = PurchaseRequest::with('details')->findOrFail($id);
    
        $satuanList = DB::table('master_satuan')
        ->pluck('nama_satuan')
        ->toArray();
    
    
        return view('purchase-requests.edit', compact('purchaseRequest', 'satuanList'));
    }
    

    public function update(Request $request, $id)
    {
        Log::info('=== MULAI UPDATE PURCHASE REQUEST ===', ['purchase_request_id' => $id]);
    
        $validatedData = $request->validate([
            'tanggal' => 'required|date',
            'departemen' => 'required|string|max:255',
            'kategori' => 'required|string|max:255',
            'details' => 'required|array',
            'details.*.kode_barang' => 'required|string|max:255',
            'details.*.nama_barang' => 'required|string|max:255',
            'details.*.kategori' => 'required|string|max:255',
            'details.*.jumlah' => 'required|integer|min:1',
            'details.*.satuan' => 'required|string|max:255',
            'details.*.rencana_kedatangan' => 'required|date',
            'details.*.keterangan' => 'nullable|string|max:255',
            'details.*.dokumen' => 'nullable|file|mimes:pdf|max:2048',
            'details.*.deleted' => 'nullable|in:0,1',
            'details.*.id' => 'nullable|integer',
        ]);
    
        DB::beginTransaction();
    
        try {
            $purchaseRequest = PurchaseRequest::findOrFail($id);
            Log::info('Data master PR ditemukan.', $purchaseRequest->toArray());
    
            // Update data master
            $purchaseRequest->update([
                'tanggal' => $validatedData['tanggal'],
                'departemen' => $validatedData['departemen'],
                'kategori_barang' => $validatedData['kategori'],
            ]);
    
            $submittedIds = [];
    
            foreach ($request->input('details') as $index => $detail) {
                Log::info("Proses detail index $index", $detail);
    
                $detailId = $detail['id'] ?? null;
    
                // Jika baris ditandai dihapus
                if (isset($detail['deleted']) && $detail['deleted'] == '1') {
                    if ($detailId) {
                        Log::info("Hapus detail dengan ID: $detailId");
                        PurchaseRequestDetail::where('id', $detailId)->delete();
                    }
                    continue; // Lewati simpan
                }
    
                // Simpan dokumen jika ada
                $dokumenPath = null;
                if ($request->hasFile("details.$index.dokumen")) {
                    $dokumen = $request->file("details.$index.dokumen");
                    if ($dokumen instanceof \Illuminate\Http\UploadedFile) {
                        $dokumenPath = $dokumen->storeAs(
                            "public/PurchaseRequest/{$purchaseRequest->no_purchase_request}",
                            "{$detail['kode_barang']}.pdf"
                        );
                        Log::info("Dokumen disimpan untuk detail index $index", ['path' => $dokumenPath]);
                    }
                }
    
                $dataToSave = [
                    'purchase_request_id' => $purchaseRequest->id,
                    'kode_barang' => $detail['kode_barang'],
                    'nama_barang' => $detail['nama_barang'],
                    'kategori' => $detail['kategori'],
                    'jumlah' => $detail['jumlah'],
                    'satuan' => $detail['satuan'],
                    'rencana_kedatangan' => $detail['rencana_kedatangan'],
                    'keterangan' => $detail['keterangan'] ?? null,
                    'dokumen' => $dokumenPath ?? ($detailId ? PurchaseRequestDetail::find($detailId)?->dokumen : null),
                ];
    
                Log::info("Simpan detail ke database", $dataToSave);
    
                if ($detailId) {
                    PurchaseRequestDetail::updateOrCreate(['id' => $detailId], $dataToSave);
                    $submittedIds[] = $detailId;
                } else {
                    $created = PurchaseRequestDetail::create($dataToSave);
                    $submittedIds[] = $created->id;
                }
            }
    
            // Hapus data detail yang tidak dikirim ulang (hilang dari form)
            PurchaseRequestDetail::where('purchase_request_id', $purchaseRequest->id)
                ->whereNotIn('id', $submittedIds)
                ->delete();
    
            Log::info('=== BERHASIL UPDATE PR ===');
            DB::commit();
    
            return redirect()->route('purchase-requests.index')->with('success', 'Data berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Gagal update Purchase Request', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Gagal menyimpan data: ' . $e->getMessage())->withInput();
        }
    }
    
    
    public function show($id)
{
    // Ambil data purchase request berdasarkan ID dengan relasi detail
    $purchaseRequest = PurchaseRequest::with('details')->findOrFail($id);

    // Kirim data ke view
    return view('purchase-requests.show', compact('purchaseRequest'));
}

public function destroy($id)
{
    try {
        // Cari data berdasarkan ID
        $purchaseRequest = PurchaseRequest::findOrFail($id);

        // Hapus data
        $purchaseRequest->delete();

        return redirect()->route('purchase-requests.index')->with('success', 'Purchase Request berhasil dihapus beserta detailnya.');
    } catch (\Exception $e) {
        return redirect()->route('purchase-requests.index')->with('error', 'Terjadi kesalahan saat menghapus data: ' . $e->getMessage());
    }
}
public function print($id)
{
    $purchaseRequest = PurchaseRequest::with('details')->findOrFail($id);

    // Load view untuk PDF
    $pdf = Pdf::loadView('purchase-requests.pdf', compact('purchaseRequest'));

    // Unduh PDF dengan nama file khusus
    return $pdf->stream("Purchase_Request_{$purchaseRequest->no_purchase_request}.pdf");
}

}
