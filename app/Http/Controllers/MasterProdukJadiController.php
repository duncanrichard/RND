<?php

namespace App\Http\Controllers;

use App\Models\MasterProdukJadi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class MasterProdukJadiController extends Controller
{
    public function index()
{
    // Ambil semua produk utama
    $produkUtama = DB::table('master_produk_jadis')->get();

    // Ambil data eksternal dan mapping berdasarkan kode_produk_jadi
    $notifikasiBPOM = DB::table('qa_djc.notifikasi_bpom')
        ->select('kode_produk_jadi', DB::raw('MAX(nomor_notifikasi_bpom) as nomor_notifikasi_bpom'), DB::raw('MAX(masa_berlaku_notifikasi_bpom) as masa_berlaku_notifikasi_bpom'))
        ->groupBy('kode_produk_jadi')
        ->get()->keyBy('kode_produk_jadi');

    $sertifikasiHalal = DB::table('qa_djc.sertifikasi_halal')
        ->select('kode_produk_jadi', DB::raw('MAX(nomor_sertifikasi_halal) as nomor_sertifikat_halal'), DB::raw('MAX(masa_berlaku_sertifikasi_halal) as masa_berlaku_sertifikat_halal'))
        ->groupBy('kode_produk_jadi')
        ->get()->keyBy('kode_produk_jadi');

    $merek = DB::table('legal.merek')
        ->select('kode_produk_jadi', DB::raw('MAX(nomor_merek) as nomor_merk'), DB::raw('MAX(masa_berlaku_merek) as masa_berlaku_merk'))
        ->groupBy('kode_produk_jadi')
        ->get()->keyBy('kode_produk_jadi');

    $haki = DB::table('legal.haki')
        ->select('kode_produk_jadi', DB::raw('MAX(nomor_haki) as nomor_haki'), DB::raw('MAX(masa_berlaku_haki) as masa_berlaku_haki'))
        ->groupBy('kode_produk_jadi')
        ->get()->keyBy('kode_produk_jadi');

    // Gabungkan semuanya
    $produkJadi = $produkUtama->map(function ($produk) use ($notifikasiBPOM, $sertifikasiHalal, $merek, $haki) {
        $produk->nomor_notifikasi_bpom = $notifikasiBPOM[$produk->kode_produk_jadi]->nomor_notifikasi_bpom ?? null;
        $produk->masa_berlaku_notifikasi_bpom = $notifikasiBPOM[$produk->kode_produk_jadi]->masa_berlaku_notifikasi_bpom ?? null;

        $produk->nomor_sertifikat_halal = $sertifikasiHalal[$produk->kode_produk_jadi]->nomor_sertifikat_halal ?? null;
        $produk->masa_berlaku_sertifikat_halal = $sertifikasiHalal[$produk->kode_produk_jadi]->masa_berlaku_sertifikat_halal ?? null;

        $produk->nomor_merk = $merek[$produk->kode_produk_jadi]->nomor_merk ?? null;
        $produk->masa_berlaku_merk = $merek[$produk->kode_produk_jadi]->masa_berlaku_merk ?? null;

        $produk->nomor_haki = $haki[$produk->kode_produk_jadi]->nomor_haki ?? null;
        $produk->masa_berlaku_haki = $haki[$produk->kode_produk_jadi]->masa_berlaku_haki ?? null;

        $produk->kategori_kemasan = $produk->kategori_kemasan == 1 ? 'Primer' : 'Sekunder';

        $jenisKemasan = DB::table('kode_bahan_kemas')->where('id', $produk->jenis_kemasan)->first();
        $produk->jenis_kemasan = $jenisKemasan ? $jenisKemasan->nama_kode : '-';

        return $produk;
    });

    return view('master_produk_jadi.index', compact('produkJadi'));
}


    public function create()
    {
        $categories = \App\Models\MasterKategoriProduk::all(); // Ambil kategori
        $satuans = \App\Models\MasterSatuan::all(); // Ambil data satuan
        return view('master_produk_jadi.create', compact('categories', 'satuans'));
    }

    public function store(Request $request)
{
    $validated = $request->validate([
        'kategori_produk_jadi' => 'required|string',
        'nama_merek' => 'required|string',
        'kode_produk_jadi' => 'required|string|unique:master_produk_jadis,kode_produk_jadi',
        'nama_produk' => 'required|string',
        'netto' => 'required|numeric',
        'satuan' => 'required|string',
        'expired_date_produk_jadi' => 'required|date',
        'rekomendasi_penyimpanan' => 'required|string',
        'kategori_kemasan' => 'required|string',
        'jenis_kemasan' => 'required|string',
        'harga_produk' => 'nullable|numeric',
    ], [
        'kode_produk_jadi.unique' => 'Kode produk jadi sudah digunakan.',
    ]);

    MasterProdukJadi::create($validated);

    return redirect()->route('master_produk_jadi.index')->with('success', 'Produk Jadi berhasil ditambahkan.');
}


    public function edit($id)
{
    $produk = MasterProdukJadi::findOrFail($id);
    $categories = \App\Models\MasterKategoriProduk::all();
    $satuans = \App\Models\MasterSatuan::all();
    $jenisKemasan = DB::table('kode_bahan_kemas')->select('id', 'nama_kode')->get(); // Ambil data jenis kemasan

    return view('master_produk_jadi.edit', compact('produk', 'categories', 'satuans', 'jenisKemasan'));
}

public function update(Request $request, $id)
{
    // Validasi data
    $validated = $request->validate([
        'kategori_produk_jadi' => 'string',
        'nama_merek' => 'string',
        'kode_produk_jadi' => 'string',
        'nama_produk' => 'string',
        'netto' => 'numeric',
        'satuan' => 'string',
        'expired_date_produk_jadi' => 'date',
        'rekomendasi_penyimpanan' => 'string',
        'kategori_kemasan' => 'string',
        'jenis_kemasan' => 'string',
        'harga_produk' => 'nullable|numeric',
    ]);

    // Cari produk berdasarkan ID
    $produk = MasterProdukJadi::findOrFail($id);

    // Update data produk
    $produk->update($validated);

    // Redirect kembali ke halaman index
    return redirect()->route('master_produk_jadi.index')->with('success', 'Produk Jadi berhasil diperbarui.');
}


    public function destroy($id)
    {
        $produk = MasterProdukJadi::findOrFail($id);
        $produk->delete();
        return redirect()->route('master_produk_jadi.index')->with('success', 'Produk Jadi berhasil dihapus.');
    }

    public function filterJenisKemasan($kategori)
    {
        // Validasi input kategori: 1 (Primer), 2 (Sekunder)
        if (!in_array($kategori, [1, 2])) {
            return response()->json(['error' => 'Kategori tidak valid.'], 400);
        }

        // Ambil data dari tabel kode_bahan_kemas berdasarkan kategori
        $jenisKemasan = DB::table('kode_bahan_kemas')
            ->where('jenis_kemasan', $kategori)
            ->select('id', 'nama_kode')
            ->get();

        return response()->json($jenisKemasan);
    }

    public function show($id)
{
    $produk = DB::table('master_produk_jadis')
        ->leftJoin('qa_djc.notifikasi_bpom', 'master_produk_jadis.kode_produk_jadi', '=', 'qa_djc.notifikasi_bpom.kode_produk_jadi')
        ->leftJoin('qa_djc.sertifikasi_halal', 'master_produk_jadis.kode_produk_jadi', '=', 'qa_djc.sertifikasi_halal.kode_produk_jadi')
        ->leftJoin('legal.merek', 'master_produk_jadis.kode_produk_jadi', '=', 'legal.merek.kode_produk_jadi')
        ->leftJoin('legal.haki', 'master_produk_jadis.kode_produk_jadi', '=', 'legal.haki.kode_produk_jadi')
        ->leftJoin('kode_bahan_kemas', 'master_produk_jadis.jenis_kemasan', '=', 'kode_bahan_kemas.id')
        ->select(
            'master_produk_jadis.*',
            'kode_bahan_kemas.nama_kode as nama_jenis_kemasan',
            'qa_djc.notifikasi_bpom.nomor_notifikasi_bpom',
            'qa_djc.notifikasi_bpom.masa_berlaku_notifikasi_bpom',
            'qa_djc.sertifikasi_halal.nomor_sertifikasi_halal as nomor_sertifikat_halal',
            'qa_djc.sertifikasi_halal.masa_berlaku_sertifikasi_halal as masa_berlaku_sertifikat_halal',
            'legal.merek.nomor_merek as nomor_merk',
            'legal.merek.masa_berlaku_merek as masa_berlaku_merk',
            'legal.haki.nomor_haki',
            'legal.haki.masa_berlaku_haki'
        )
        ->where('master_produk_jadis.id', $id)
        ->first();

    if (!$produk) {
        abort(404);
    }

    return view('master_produk_jadi.show', compact('produk'));
}

public function printDetail($id)
{
    // Cari produk berdasarkan ID
    $produk = DB::table('master_produk_jadis')
        ->leftJoin('qa_djc.notifikasi_bpom', 'master_produk_jadis.kode_produk_jadi', '=', 'qa_djc.notifikasi_bpom.kode_produk_jadi')
        ->leftJoin('qa_djc.sertifikasi_halal', 'master_produk_jadis.kode_produk_jadi', '=', 'qa_djc.sertifikasi_halal.kode_produk_jadi')
        ->leftJoin('legal.merek', 'master_produk_jadis.kode_produk_jadi', '=', 'legal.merek.kode_produk_jadi')
        ->leftJoin('legal.haki', 'master_produk_jadis.kode_produk_jadi', '=', 'legal.haki.kode_produk_jadi')
        ->select(
            'master_produk_jadis.*',
            'qa_djc.notifikasi_bpom.nomor_notifikasi_bpom',
            'qa_djc.notifikasi_bpom.masa_berlaku_notifikasi_bpom',
            'qa_djc.sertifikasi_halal.nomor_sertifikasi_halal as nomor_sertifikat_halal',
            'qa_djc.sertifikasi_halal.masa_berlaku_sertifikasi_halal as masa_berlaku_sertifikat_halal',
            'legal.merek.nomor_merek as nomor_merk',
            'legal.merek.masa_berlaku_merek as masa_berlaku_merk',
            'legal.haki.nomor_haki',
            'legal.haki.masa_berlaku_haki'
        )
        ->where('master_produk_jadis.id', $id)
        ->first();

    // Jika data tidak ditemukan, kembalikan 404
    if (!$produk) {
        abort(404);
    }

    return view('master_produk_jadi.print', compact('produk'));
}
public function previewPdf($id)
{
    $produk = DB::table('master_produk_jadis')
        ->leftJoin('qa_djc.notifikasi_bpom', 'master_produk_jadis.kode_produk_jadi', '=', 'qa_djc.notifikasi_bpom.kode_produk_jadi')
        ->leftJoin('qa_djc.sertifikasi_halal', 'master_produk_jadis.kode_produk_jadi', '=', 'qa_djc.sertifikasi_halal.kode_produk_jadi')
        ->leftJoin('legal.merek', 'master_produk_jadis.kode_produk_jadi', '=', 'legal.merek.kode_produk_jadi')
        ->leftJoin('legal.haki', 'master_produk_jadis.kode_produk_jadi', '=', 'legal.haki.kode_produk_jadi')
        ->leftJoin('kode_bahan_kemas', 'master_produk_jadis.jenis_kemasan', '=', 'kode_bahan_kemas.id')
        ->select(
            'master_produk_jadis.*',
            'kode_bahan_kemas.nama_kode as nama_jenis_kemasan',
            'qa_djc.notifikasi_bpom.nomor_notifikasi_bpom',
            'qa_djc.notifikasi_bpom.masa_berlaku_notifikasi_bpom',
            'qa_djc.sertifikasi_halal.nomor_sertifikasi_halal as nomor_sertifikat_halal',
            'qa_djc.sertifikasi_halal.masa_berlaku_sertifikasi_halal as masa_berlaku_sertifikat_halal',
            'legal.merek.nomor_merek as nomor_merk',
            'legal.merek.masa_berlaku_merek as masa_berlaku_merk',
            'legal.haki.nomor_haki',
            'legal.haki.masa_berlaku_haki'
        )
        ->where('master_produk_jadis.id', $id)
        ->first();

    $pdf = PDF::loadView('master_produk_jadi.print', compact('produk'));
    return $pdf->stream('Master-Produk.pdf');
}

}
