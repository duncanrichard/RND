<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\MasterProdukJadi;
use App\Models\MasterFormulaProdukJadi;
use App\Models\MasterFormulaProdukJadiBahanBaku;
use App\Models\MasterFormulaProdukJadiBahanKemas;

class MasterFormulaProdukController extends Controller
{
    public function index()
    {
        $formulas = MasterFormulaProdukJadi::select(
            'id',
            'nomor_formula',
            'tanggal',
            'kode_produk',
            'nama_produk',
            'nama_merek',
            'kategori',
            'netto',
            'batch_size_berat',
            'satuan_berat',
            'batch_size_satuan',
            'jenis_satuan',
        )
            ->orderBy('created_at', 'asc')
            ->paginate(10);

        // Logging aktivitas pengguna
        activity()
            ->causedBy(Auth::user())
             ->tap(fn ($activity) => $activity->id_user = auth()->id())
            ->log('Mengakses halaman Master Formula Produk Jadi');

        return view('master_formula_produk.index', compact('formulas'));
    }

    public function create(Request $request)
    {
        $search = $request->input('search');
        $produkJadi = MasterProdukJadi::query();

        if ($search) {
            $produkJadi = $produkJadi->where('kode_produk_jadi', 'like', "%{$search}%")
                ->orWhere('nama_merek', 'like', "%{$search}%")
                ->orWhere('kategori', 'like', "%{$search}%")
                ->orWhere('nama_produk', 'like', "%{$search}%");
        }

        $produkJadi = $produkJadi->limit(10)->get();

        // Logging aktivitas pengguna
        $logMessage = $search
            ? 'Mencari produk jadi pada form create Master Formula Produk Jadi dengan kata kunci: ' . $search
            : 'Mengakses halaman create Master Formula Produk Jadi';
        activity()
            ->causedBy(Auth::user())
            ->log($logMessage);

        return view('master_formula_produk.create', compact('produkJadi', 'search'));
    }

public function getProducts(Request $request)
{
    $search = $request->input('search', '');

    $produkJadi = MasterProdukJadi::query();

    if ($search) {
        $produkJadi->where('kode_produk_jadi', 'like', "%{$search}%")
            ->orWhere('nama_merek', 'like', "%{$search}%")
            ->orWhere('kategori_produk_jadi', 'like', "%{$search}%")
            ->orWhere('nama_produk', 'like', "%{$search}%");
    }

    try {
        $result = $produkJadi->select('id', 'kode_produk_jadi', 'nama_merek', 'kategori_produk_jadi as kategori', 'nama_produk', 'netto')
            ->limit(10)
            ->get();

        // Logging
        activity()
            ->causedBy(Auth::user())
            ->log('Mengambil data produk jadi ' . ($search ? "dengan pencarian: $search" : 'tanpa pencarian'));

        return response()->json($result, 200);
    } catch (\Exception $e) {
        \Log::error('Error fetching products:', ['message' => $e->getMessage()]);
        return response()->json(['error' => 'Terjadi kesalahan saat mengambil data produk jadi'], 500);
    }
}

public function getBahanBaku(Request $request)
{
    $search = $request->input('search', '');

    $bahanBaku = BahanBaku::query()
        ->join('jenis_bahan_baku', 'bahan_bakus.kode_bahan_baku', '=', 'jenis_bahan_baku.id')
        ->select(
            'bahan_bakus.id', 
            'bahan_bakus.kode_bahan_baku', 
            'bahan_bakus.koding_bahan_baku', 
            'bahan_bakus.nama_bahan_baku', 
            'bahan_bakus.nama_coding', 
            'bahan_bakus.hpbb', 
            'bahan_bakus.urutan_kode_bahan_baku', 
            'bahan_bakus.satuan', 
            'jenis_bahan_baku.jenis_bahan_baku'
        );

    if ($search) {
        $bahanBaku = $bahanBaku->where(function ($query) use ($search) {
            $query->where('bahan_bakus.kode_bahan_baku', 'like', "%{$search}%")
                ->orWhere('bahan_bakus.urutan_kode_bahan_baku', 'like', "%{$search}%")
                ->orWhere('bahan_bakus.nama_bahan_baku', 'like', "%{$search}%")
                ->orWhere('bahan_bakus.koding_bahan_baku', 'like', "%{$search}%")
                ->orWhere('bahan_bakus.nama_coding', 'like', "%{$search}%")
                ->orWhere('jenis_bahan_baku.jenis_bahan_baku', 'like', "%{$search}%");
        });
    }

    try {
        $result = $bahanBaku->limit(10)->get();

        activity()
            ->causedBy(Auth::user())
            ->log('Mengambil data bahan baku ' . ($search ? "dengan pencarian: $search" : 'tanpa pencarian'));

        return response()->json($result, 200);
    } catch (\Exception $e) {
        \Log::error('Error fetching bahan baku:', ['message' => $e->getMessage()]);
        return response()->json(['error' => 'Terjadi kesalahan saat mengambil data'], 500);
    }
}

public function getBahanKemas(Request $request)
{
    $search = $request->input('search', '');

    $bahanKemas = \DB::table('master_kemasan');

    if ($search) {
        $bahanKemas = $bahanKemas->where('nama_kemasan', 'like', "%{$search}%")
            ->orWhere('kode_kemasan', 'like', "%{$search}%");
    }

    try {
        $result = $bahanKemas->select('id', 'kode_kemasan', 'nama_kemasan', 'hpbk', 'satuan')->limit(10)->get();

        activity()
            ->causedBy(Auth::user())
            ->log('Mengambil data bahan kemas ' . ($search ? "dengan pencarian: $search" : 'tanpa pencarian'));

        return response()->json($result, 200);
    } catch (\Exception $e) {
        \Log::error('Error fetching bahan kemas:', ['message' => $e->getMessage()]);
        return response()->json(['error' => 'Terjadi kesalahan saat mengambil data'], 500);
    }
}

public function store(Request $request)
{
    \Log::info('Data yang diterima:', $request->all());

    $validated = $request->validate([
        'nomor_formula' => 'required|unique:master_formula_produk_jadi,nomor_formula',
        'tanggal' => 'required|date',
        'id_input' => 'required|string',
        'kode_produk_id' => 'required|exists:master_produk_jadis,id',
        'kode_produk' => 'required|string',
        'nama_merek' => 'required|string',
        'kategori' => 'required|string',
        'nama_produk' => 'required|string',
        'netto' => 'required|numeric',
        'batch_size_berat' => 'required|numeric',
        'satuan_berat' => 'required|string',
        'batch_size_satuan' => 'required|numeric',
        'jenis_satuan' => 'required|string',
        'total_jumlah_input_bahan_baku' => 'required',
        'total_hpp_input_bahan_baku' => 'required',
        'total_jumlah_input_bahan_kemas' => 'required',
        'total_hpp_input_bahan_kemas' => 'required',
        'id_bahan_baku' => 'array',
        'id_bahan_baku.*' => 'required|exists:bahan_bakus,id',
        'kode_bahan_baku' => 'array',
        'kode_bahan_baku.*' => 'required|string',
        'nama_coding' => 'array',
        'nama_coding.*' => 'required|string',
        'satuan_bahan_baku' => 'array',
        'satuan_bahan_baku.*' => 'required|string',
        'jumlah_bahan_baku' => 'array',
        'jumlah_bahan_baku.*' => 'required|numeric',
        'hpp_bahan_baku' => 'array',
        'hpp_bahan_baku.*' => 'required|numeric',
        'id_bahan_kemas' => 'array',
        'id_bahan_kemas.*' => 'required|exists:master_kemasan,id',
        'kode_kemasan' => 'array',
        'kode_kemasan.*' => 'required|string',
        'nama_kemasan' => 'array',
        'nama_kemasan.*' => 'required|string',
        'satuan_kemasan' => 'array',
        'satuan_kemasan.*' => 'required|string',
        'jumlah_bahan_kemas' => 'array',
        'jumlah_bahan_kemas.*' => 'required|numeric',
        'hpp_bahan_kemas' => 'array',
        'hpp_bahan_kemas.*' => 'required|numeric',
    ]);

    \Log::info('Data tervalidasi:', $validated);

    \DB::beginTransaction();
    try {
        $formula = MasterFormulaProdukJadi::create([
            'nomor_formula' => $validated['nomor_formula'],
            'tanggal' => $validated['tanggal'],
            'kode_produk_id' => $validated['kode_produk_id'],
            'id_input' => $validated['id_input'],
            'kode_produk' => $validated['kode_produk'],
            'nama_merek' => $validated['nama_merek'],
            'kategori' => $validated['kategori'],
            'nama_produk' => $validated['nama_produk'],
            'netto' => $validated['netto'],
            'batch_size_berat' => $validated['batch_size_berat'],
            'satuan_berat' => $validated['satuan_berat'],
            'batch_size_satuan' => $validated['batch_size_satuan'],
            'jenis_satuan' => $validated['jenis_satuan'],
            'total_jumlah_bahan_baku' => $validated['total_jumlah_input_bahan_baku'],
            'total_hpp_bahan_baku' => $validated['total_hpp_input_bahan_baku'],
            'total_jumlah_bahan_kemas' => $validated['total_jumlah_input_bahan_kemas'],
            'total_hpp_bahan_kemas' => $validated['total_hpp_input_bahan_kemas'],
        ]);

        \Log::info('Formula disimpan, ID:', ['id' => $formula->id]);

        if (!empty($request->id_bahan_baku)) {
            foreach ($request->id_bahan_baku as $index => $idBahanBaku) {
                MasterFormulaProdukJadiBahanBaku::create([
                    'master_formula_produk_jadi_id' => $formula->id,
                    'bahan_baku_id' => $idBahanBaku,
                    'kode_bahan_baku' => $request->kode_bahan_baku[$index],
                    'nama_coding' => $request->nama_coding[$index],
                    'satuan' => $request->satuan_bahan_baku[$index],
                    'jumlah' => $request->jumlah_bahan_baku[$index],
                    'hpp' => $request->hpp_bahan_baku[$index],
                ]);
            }
        }

        if (!empty($request->id_bahan_kemas)) {
            foreach ($request->id_bahan_kemas as $index => $idBahanKemas) {
                MasterFormulaProdukJadiBahanKemas::create([
                    'master_formula_produk_jadi_id' => $formula->id,
                    'bahan_kemas_id' => $idBahanKemas,
                    'kode_kemasan' => $request->kode_kemasan[$index],
                    'nama_kemasan' => trim($request->nama_kemasan[$index]),
                    'satuan' => $request->satuan_kemasan[$index],
                    'jumlah' => $request->jumlah_bahan_kemas[$index],
                    'hpp' => $request->hpp_bahan_kemas[$index],
                ]);
            }
        }

        \DB::commit();

        // ✅ Tambah Log Aktivitas (Spatie)
        activity()
            ->causedBy(Auth::user())
            ->performedOn($formula)
            ->withProperties(['nomor_formula' => $formula->nomor_formula])
            ->log('Menambahkan data formula produk jadi');

        return redirect()
            ->route('master_formula_produk.index')
            ->with('success', 'Data formula berhasil disimpan!');
    } catch (\Exception $e) {
        \DB::rollBack();
        \Log::error('Error storing formula:', ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
        return redirect()
            ->back()
            ->with('error', 'Terjadi kesalahan saat menyimpan data formula!');
    }
}


    public function getLastNomorFormula($kodeProduk)
{
    $lastFormula = MasterFormulaProdukJadi::where('kode_produk', $kodeProduk)
        ->orderBy('created_at', 'desc')
        ->first();

    if ($lastFormula) {
        $lastNomor = explode('/', $lastFormula->nomor_formula)[2] ?? '000000';
        return str_pad(((int) $lastNomor) + 1, 6, '0', STR_PAD_LEFT);
    }

    return "000001";
}

public function getNomorFormula(Request $request)
{
    $kodeProduk = $request->input('kode_produk');

    if (!$kodeProduk) {
        return response()->json(['error' => 'Kode produk tidak ditemukan'], 400);
    }

    try {
        $nomorUrut = $this->getLastNomorFormula($kodeProduk);
        $currentDate = now();
        $monthYear = $currentDate->format('mY');
        $nomorFormula = "MFP/{$kodeProduk}/{$nomorUrut}/{$monthYear}";

        \Log::info('Nomor formula berhasil dibuat', ['nomor_formula' => $nomorFormula, 'user' => Auth::user()?->name]);

        return response()->json(['nomor_formula' => $nomorFormula], 200);
    } catch (\Exception $e) {
        \Log::error('Gagal membuat nomor formula', ['message' => $e->getMessage()]);
        return response()->json(['error' => 'Terjadi kesalahan saat membuat nomor formula'], 500);
    }
}

public function destroy($id)
{
    DB::beginTransaction();
    try {
        $formula = MasterFormulaProdukJadi::findOrFail($id);
        $nomorFormula = $formula->nomor_formula;

        // Hapus data terkait
        MasterFormulaProdukJadiBahanBaku::where('master_formula_produk_jadi_id', $id)->delete();
        MasterFormulaProdukJadiBahanKemas::where('master_formula_produk_jadi_id', $id)->delete();
        $formula->delete();

        DB::commit();

        // ✅ Log aktivitas pengguna
        activity()
            ->causedBy(Auth::user())
            ->performedOn($formula)
            ->withProperties(['nomor_formula' => $nomorFormula])
            ->log("Menghapus formula produk jadi");

        \Log::info("Formula dengan ID $id berhasil dihapus", ['nomor_formula' => $nomorFormula]);

        return redirect()->route('master_formula_produk.index')->with('success', 'Formula berhasil dihapus.');
    } catch (\Exception $e) {
        DB::rollBack();

        \Log::error('Gagal menghapus formula', [
            'formula_id' => $id,
            'message' => $e->getMessage(),
        ]);

        return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus formula.');
    }
}

public function show($id)
{
    try {
        $formula = MasterFormulaProdukJadi::with(['bahanBaku', 'bahanKemas'])->findOrFail($id);

        $totalJumlahBahanBaku = $formula->bahanBaku->sum('jumlah');
        $totalHppBahanBaku = $formula->bahanBaku->sum(function ($bahan) {
            return $bahan->jumlah * $bahan->hpp;
        });

        $totalJumlahBahanKemas = $formula->bahanKemas->sum('jumlah');
        $totalHppBahanKemas = $formula->bahanKemas->sum(function ($kemas) {
            return $kemas->jumlah * $kemas->hpp;
        });

        activity()->causedBy(Auth::user())->performedOn($formula)->log("Melihat detail formula: {$formula->nomor_formula}");
        Log::info("User melihat detail formula", ['id' => $formula->id]);

        return view('master_formula_produk.detail', compact(
            'formula',
            'totalJumlahBahanBaku',
            'totalHppBahanBaku',
            'totalJumlahBahanKemas',
            'totalHppBahanKemas'
        ));
    } catch (\Exception $e) {
        Log::error('Gagal menampilkan detail formula', ['message' => $e->getMessage()]);
        return redirect()->back()->with('error', 'Gagal menampilkan detail formula.');
    }
}


public function printPdf($id)
{
    try {
        $formula = MasterFormulaProdukJadi::with(['bahanBaku', 'bahanKemas'])->findOrFail($id);

        $totalJumlahBahanBaku = $formula->bahanBaku->sum('jumlah');
        $totalHppBahanBaku = $formula->bahanBaku->sum(fn($bahan) => $bahan->jumlah * $bahan->hpp);
        $totalJumlahBahanKemas = $formula->bahanKemas->sum('jumlah');
        $totalHppBahanKemas = $formula->bahanKemas->sum(fn($kemas) => $kemas->jumlah * $kemas->hpp);

        $pdf = Pdf::loadView('master_formula_produk.pdf', compact(
            'formula',
            'totalJumlahBahanBaku',
            'totalHppBahanBaku',
            'totalJumlahBahanKemas',
            'totalHppBahanKemas'
        ));

        activity()->causedBy(Auth::user())->performedOn($formula)->log("Mencetak PDF formula: {$formula->nomor_formula}");
        Log::info('PDF formula dicetak', ['nomor_formula' => $formula->nomor_formula]);

        return $pdf->stream("Detail_Formula_Produk_{$formula->nomor_formula}.pdf");
    } catch (\Exception $e) {
        Log::error('Gagal mencetak PDF formula', ['message' => $e->getMessage()]);
        return redirect()->back()->with('error', 'Gagal mencetak PDF formula.');
    }
}

public function edit($id)
{
    try {
        $formula = MasterFormulaProdukJadi::findOrFail($id);

        activity()->causedBy(Auth::user())->performedOn($formula)->log("Mengedit formula: {$formula->nomor_formula}");
        Log::info('User mengakses halaman edit formula', ['id' => $formula->id]);

        return view('master_formula_produk.edit', compact('formula'));
    } catch (\Exception $e) {
        Log::error('Gagal membuka halaman edit formula', ['message' => $e->getMessage()]);
        return redirect()->back()->with('error', 'Gagal membuka halaman edit.');
    }
}

public function update(Request $request, $id)
{
    $validated = $request->validate([
        'nomor_formula' => 'required|string',
        'tanggal' => 'date',
        'id_input' => 'required|string',
        'kode_produk_id' => 'required|exists:master_produk_jadis,id',
        'kode_produk' => 'required|string',
        'nama_merek' => 'required|string',
        'kategori' => 'required|string',
        'nama_produk' => 'required|string',
        'netto' => 'required|numeric',
        'batch_size_berat' => 'required|numeric',
        'satuan_berat' => 'required|string',
        'batch_size_satuan' => 'required|numeric',
        'jenis_satuan' => 'required|string',
    ]);

    try {
        $formula = MasterFormulaProdukJadi::findOrFail($id);
        $formula->update($validated);

        activity()->causedBy(Auth::user())->performedOn($formula)->withProperties($validated)->log("Memperbarui formula: {$formula->nomor_formula}");
        Log::info('Formula berhasil diperbarui', ['id' => $formula->id]);

        return redirect()->route('master_formula_produk.index')->with('success', 'Formula berhasil diperbarui.');
    } catch (\Exception $e) {
        Log::error('Gagal memperbarui formula', ['message' => $e->getMessage()]);
        return redirect()->back()->with('error', 'Gagal memperbarui formula.');
    }
}

}
