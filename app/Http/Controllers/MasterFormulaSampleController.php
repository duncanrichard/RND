<?php

namespace App\Http\Controllers;

use App\Models\MasterFormulaSample;
use App\Models\FormulaSampleDetail;
use App\Models\MasterSatuan;
use App\Models\MasterBahanBaku;
use App\Models\MasterHargaSampleBahanBaku;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\SingkatanMerk;

class MasterFormulaSampleController extends Controller
{
    public function index(Request $request)
{
    $listMerk = SingkatanMerk::select('nama_merk', 'singkatan_merk')->get();
    $merkFilter = $request->input('merk');

    $query = MasterFormulaSample::query();

    if ($merkFilter) {
        $singkatan = SingkatanMerk::where('nama_merk', $merkFilter)->first();
        if ($singkatan) {
            $query->where('kode_sample', 'like', $singkatan->singkatan_merk . '%');
        }
    }

    $data = $query->orderBy('created_at', 'asc')->get();

    activity()
        ->causedBy(auth()->user())
        ->tap(fn ($activity) => $activity->id_user = auth()->id())
        ->log('Mengakses halaman daftar Master Formula Sample');

    return view('master_formula_sample.index', compact('data', 'listMerk', 'merkFilter'));
}

    
   public function create()
{
    $satuanList = MasterSatuan::all(['id', 'nama_satuan']);
    $listMerk = SingkatanMerk::select('nama_merk', 'singkatan_merk')->get();

    $defaultMerk = $listMerk->first()->singkatan_merk ?? 'DJC';

    $now = now();
    $bulanTahun = $now->format('my');
    $prefixKode = "$defaultMerk-$bulanTahun-";

    $lastSample = MasterFormulaSample::where('kode_sample', 'like', "$prefixKode%")
        ->orderByDesc('kode_sample')
        ->first();

    $lastNumber = 0;
    if ($lastSample && preg_match('/(\d{3})$/', $lastSample->kode_sample, $matches)) {
        $lastNumber = (int) $matches[1];
    }

    $nextSampleNumber = str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);
    $kodeSample = "$defaultMerk-$bulanTahun-$nextSampleNumber";
    $nomorFormula = "MFS/{$kodeSample}";
    $nextFormulaNumber = $lastNumber + 1;

    activity()
        ->causedBy(auth()->user())
        ->tap(fn ($activity) => $activity->id_user = auth()->id())
        ->log('Mengakses form tambah Master Formula Sample');

    return view('master_formula_sample.create', compact(
        'kodeSample',
        'nomorFormula',
        'nextSampleNumber',
        'nextFormulaNumber',
        'satuanList',
        'listMerk'
    ));
}

public function store(Request $request)
{
    // Validasi data
    $validatedData = $request->validate([
        'nomor_formula' => 'required|string|unique:master_formula_samples,nomor_formula',
        'tanggal' => 'required|date',
        'id_input' => 'required|string',
        'kode_sample' => 'nullable|string',
        'nama_sample' => 'required|string',
        'bahan_aktif' => 'required|string',
        'total_jumlah_input' => 'required|numeric',
        'total_hpp_input' => 'required|numeric',
        'premix' => 'array',
        'premix.*' => 'nullable|string',
        'kode_bahan_baku' => 'array',
        'kode_bahan_baku.*' => 'required|string',
        'nama_bahan_baku' => 'array',
        'nama_bahan_baku.*' => 'required|string',
        'inci_name' => 'array',
        'inci_name.*' => 'required|string',
        'function' => 'array',
        'function.*' => 'required|string',
        'supplier' => 'array',
        'supplier.*' => 'required|string',
        'satuan' => 'array',
        'satuan.*' => 'nullable|integer',
        'jumlah' => 'array|required',
        'jumlah.*' => 'required|numeric|min:0.001',
        'hpp' => 'array|required',
        'hpp.*' => 'required|numeric|min:0',
        'prosedur_kerja' => 'array',
        'prosedur_kerja.*' => 'required|string',
        'bentuk' => 'required|string',
        'warna' => 'required|string',
        'bau' => 'required|string',
        'ph' => 'required|string',
        'viskositas' => 'required|string',
        'spesifikasi_lain-Lain' => 'nullable|string',
        'spesifikasi_tambahan' => 'array',
        'spesifikasi_tambahan.*' => 'required|string',
        'hasil_spesifikasi_tambahan' => 'array',
        'hasil_spesifikasi_tambahan.*' => 'required|string',
    ]);

    try {
        // Simpan data utama MasterFormulaSample
        $masterFormula = MasterFormulaSample::create([
            'nomor_formula' => $validatedData['nomor_formula'],
            'tanggal' => $validatedData['tanggal'],
            'id_input' => $validatedData['id_input'],
            'kode_sample' => $validatedData['kode_sample'],
            'nama_sample' => $validatedData['nama_sample'],
            'bahan_aktif' => $validatedData['bahan_aktif'],
            'jumlah_total' => round($validatedData['total_jumlah_input'], 3),
            'jumlah_hpp' => round($validatedData['total_hpp_input'], 3),
        ]);

        // Simpan detail bahan baku
        foreach ($validatedData['kode_bahan_baku'] as $index => $kodeBahanBaku) {
            $masterFormula->details()->create([
                'formula_sample_id' => $masterFormula->id,
                'premix' => $validatedData['premix'][$index] ?? null,
                'kode_bahan_baku' => $kodeBahanBaku,
                'nama_bahan_baku' => $validatedData['nama_bahan_baku'][$index] ?? null,
                'inci_name' => $validatedData['inci_name'][$index] ?? null,
                'function' => $validatedData['function'][$index] ?? null,
                'supplier' => $validatedData['supplier'][$index] ?? null,
                'satuan' => $validatedData['satuan'][$index] ?? null,
                'jumlah_satuan' => round($validatedData['jumlah'][$index], 3),
                'hpp' => round($validatedData['hpp'][$index], 3),
            ]);
        }

        // Simpan prosedur kerja
        foreach ($validatedData['prosedur_kerja'] as $prosedur) {
            $masterFormula->prosedurs()->create([
                'formula_sample_id' => $masterFormula->id,
                'detail' => $prosedur,
            ]);
        }

        // Simpan spesifikasi tambahan
        foreach ($validatedData['spesifikasi_tambahan'] as $index => $dataSpesifikasi) {
            $masterFormula->spesifikasiTambahan()->create([
                'data_spesifikasi' => $dataSpesifikasi,
                'hasil' => $validatedData['hasil_spesifikasi_tambahan'][$index],
            ]);
        }

        // Simpan spesifikasi utama
        $masterFormula->spesifikasis()->create([
            'formula_sample_id' => $masterFormula->id,
            'bentuk' => $validatedData['bentuk'],
            'warna' => $validatedData['warna'],
            'bau' => $validatedData['bau'],
            'ph' => $validatedData['ph'],
            'viskositas' => $validatedData['viskositas'],
            'dll' => $validatedData['spesifikasi_lain-Lain'] ?? null,
        ]);

        // Log aktivitas berhasil
        activity()
            ->causedBy(auth()->user())
            ->performedOn($masterFormula)
            ->tap(fn ($activity) => $activity->id_user = auth()->id())
            ->withProperties([
                'nomor_formula' => $validatedData['nomor_formula'],
                'kode_sample' => $validatedData['kode_sample'],
                'nama_sample' => $validatedData['nama_sample'],
                'total_jumlah_input' => $validatedData['total_jumlah_input'],
            ])
            ->log('Menambahkan data Master Formula Sample');

        return redirect()->route('master_formula_sample.index')->with('success', 'Data berhasil disimpan!');
    } catch (\Exception $e) {
        activity()
            ->causedBy(auth()->user())
            ->tap(fn ($activity) => $activity->id_user = auth()->id())
            ->withProperties(['error' => $e->getMessage()])
            ->log('Gagal menyimpan data Master Formula Sample');

        return back()->withErrors(['error' => $e->getMessage()])->withInput();
    }
}

    
    
    public function searchBahanBaku(Request $request)
{
    $query = $request->get('q', '');

    $results = MasterBahanBaku::where('kode', 'LIKE', "%{$query}%")
        ->orWhere('raw_material', 'LIKE', "%{$query}%")
        ->select('kode', 'raw_material', 'inci_name', 'function', 'supplier')
        ->get();

    activity()
        ->causedBy(auth()->user())
        ->tap(fn ($activity) => $activity->id_user = auth()->id())
        ->withProperties(['keyword' => $query])
        ->log('Mencari bahan baku berdasarkan kata kunci');

    if ($results->isEmpty()) {
        return response()->json([], 200);
    }

    $filteredResults = $results->filter(function ($item) {
        return MasterHargaSampleBahanBaku::where('kode_bahan_baku', $item->kode)->exists();
    });

    if ($filteredResults->isEmpty()) {
        return response()->json([], 200);
    }

    $resultsWithDetails = $filteredResults->map(function ($item) {
        $hargaData = MasterHargaSampleBahanBaku::where('kode_bahan_baku', $item->kode)
            ->select('kategori_satuan', 'qty', 'harga_akhir')
            ->first();

        $item->kategori_satuan = $hargaData->kategori_satuan ?? null;
        $item->qty = $hargaData->qty ?? null;
        $item->harga_akhir = $hargaData->harga_akhir ?? null;

        $satuan = MasterSatuan::find($hargaData->kategori_satuan ?? null);
        $item->nama_satuan = $satuan ? $satuan->nama_satuan : 'Tidak Diketahui';

        return $item;
    });

    return response()->json($resultsWithDetails, 200);
}
public function show($id)
{
    $formulaSample = MasterFormulaSample::with(['details.satuanModel', 'prosedurs', 'spesifikasis'])->findOrFail($id);
    $spesifikasi = $formulaSample->spesifikasis->first();

    activity()
        ->causedBy(auth()->user())
        ->performedOn($formulaSample)
        ->tap(fn ($activity) => $activity->id_user = auth()->id())
        ->log('Melihat detail Master Formula Sample');

    return view('master_formula_sample.detail', compact('formulaSample', 'spesifikasi'));
}

    
  public function destroy($id)
{
    try {
        $formulaSample = MasterFormulaSample::findOrFail($id);

        $formulaSample->details()->delete();
        $formulaSample->prosedurs()->delete();
        $formulaSample->spesifikasis()->delete();
        $formulaSample->spesifikasiTambahan()->delete();
        $formulaSample->delete();

        activity()
            ->causedBy(auth()->user())
            ->performedOn($formulaSample)
            ->tap(fn ($activity) => $activity->id_user = auth()->id())
            ->withProperties(['id' => $id])
            ->log('Menghapus data Master Formula Sample dan seluruh relasinya');

        return redirect()->route('master_formula_sample.index')->with('success', 'Data berhasil dihapus beserta relasi terkait.');
    } catch (\Exception $e) {
        activity()
            ->causedBy(auth()->user())
            ->tap(fn ($activity) => $activity->id_user = auth()->id())
            ->withProperties(['error' => $e->getMessage()])
            ->log('Gagal menghapus data Master Formula Sample');

        return back()->withErrors(['error' => 'Gagal menghapus data: ' . $e->getMessage()]);
    }
}

 public function print($id)
{
    try {
        $formulaSample = MasterFormulaSample::with(['details.satuanModel', 'prosedurs', 'spesifikasis', 'spesifikasiTambahan'])->findOrFail($id);
        $spesifikasi = $formulaSample->spesifikasis->first();
        $pdf = Pdf::loadView('master_formula_sample.pdf', compact('formulaSample', 'spesifikasi'));
        $fileName = 'Formula_Sample_' . $formulaSample->nomor_formula . '.pdf';

        activity()
            ->causedBy(auth()->user())
            ->performedOn($formulaSample)
            ->tap(fn ($activity) => $activity->id_user = auth()->id())
            ->log('Mencetak PDF Master Formula Sample');

        return $pdf->stream($fileName);
    } catch (\Exception $e) {
        activity()
            ->causedBy(auth()->user())
            ->tap(fn ($activity) => $activity->id_user = auth()->id())
            ->withProperties(['error' => $e->getMessage()])
            ->log('Gagal mencetak PDF Master Formula Sample');

        return back()->withErrors(['error' => 'Gagal mencetak PDF: ' . $e->getMessage()]);
    }
}

    public function edit($id)
{
    $formulaSample = MasterFormulaSample::findOrFail($id);

    activity()
        ->causedBy(auth()->user())
        ->performedOn($formulaSample)
        ->tap(fn ($activity) => $activity->id_user = auth()->id())
        ->log('Mengakses form edit Master Formula Sample');

    return view('master_formula_sample.edit', compact('formulaSample'));
}

  public function update(Request $request, $id)
{
    $validatedData = $request->validate([
        'nomor_formula' => 'required|string|unique:master_formula_samples,nomor_formula,' . $id,
        'tanggal' => 'required|date',
        'id_input' => 'required|string',
        'kode_sample' => 'required|string',
        'nama_sample' => 'required|string',
        'bahan_aktif' => 'required|string',
    ]);

    try {
        $formulaSample = MasterFormulaSample::findOrFail($id);
        $formulaSample->update($validatedData);

        activity()
            ->causedBy(auth()->user())
            ->performedOn($formulaSample)
            ->tap(fn ($activity) => $activity->id_user = auth()->id())
            ->withProperties($validatedData)
            ->log('Memperbarui data Master Formula Sample');

        return redirect()->route('master_formula_sample.index')->with('success', 'Data berhasil diperbarui!');
    } catch (\Exception $e) {
        activity()
            ->causedBy(auth()->user())
            ->tap(fn ($activity) => $activity->id_user = auth()->id())
            ->withProperties(['error' => $e->getMessage()])
            ->log('Gagal memperbarui data Master Formula Sample');

        return back()->withErrors(['error' => 'Gagal memperbarui data: ' . $e->getMessage()])->withInput();
    }
}

   public function generateKodeSample(Request $request)
{
    $merk = $request->get('merk');

    if (!$merk) {
        activity()
            ->causedBy(auth()->user())
            ->tap(fn ($a) => $a->id_user = auth()->id())
            ->withProperties(['merk' => null])
            ->log('Gagal generate kode sample: merk tidak ditemukan');

        return response()->json(['error' => 'Merk tidak ditemukan'], 400);
    }

    $now = now();
    $bulanTahun = $now->format('my');
    $prefix = "$merk-$bulanTahun-";

    $last = MasterFormulaSample::where('kode_sample', 'like', "$prefix%-R0")
        ->orderByDesc('kode_sample')
        ->first();

    $lastNumber = 0;
    if ($last && preg_match('/(\d{3})-R0$/', $last->kode_sample, $matches)) {
        $lastNumber = intval($matches[1]);
    }

    $nextNumber = str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);
    $kodeSample = "$prefix$nextNumber-R0";

    activity()
        ->causedBy(auth()->user())
        ->tap(fn ($a) => $a->id_user = auth()->id())
        ->withProperties(['generated_kode_sample' => $kodeSample])
        ->log('Generate kode sample otomatis');

    return response()->json([
        'kode_sample' => $kodeSample
    ]);
}

    
   public function groupDetail($kode_sample)
{
    $formulas = MasterFormulaSample::where('nomor_formula', 'like', "%/$kode_sample/%")
        ->orWhereRaw("SUBSTRING_INDEX(nomor_formula, '/', -2) LIKE ?", ["$kode_sample/%"])
        ->get();

    activity()
        ->causedBy(auth()->user())
        ->tap(fn ($a) => $a->id_user = auth()->id())
        ->withProperties(['kode_sample' => $kode_sample])
        ->log('Mengakses halaman group detail Master Formula Sample');

    return view('master_formula_sample.group_detail', compact('formulas', 'kode_sample'));
}

    public function createRevisi($kode_sample)
{
    $satuanList = MasterSatuan::all(['id', 'nama_satuan']);
    $listMerk = SingkatanMerk::select('nama_merk', 'singkatan_merk')->get();

    $lastFormula = MasterFormulaSample::where('kode_sample', $kode_sample)
        ->where('nomor_formula', 'like', "%/{$kode_sample}/R%")
        ->orderByDesc('nomor_formula')
        ->first();

    $nextRevisi = 1;
    if ($lastFormula && preg_match('/\/R(\d+)$/', $lastFormula->nomor_formula, $match)) {
        $nextRevisi = (int) $match[1] + 1;
    }

    $nomorFormula = "MFS/{$kode_sample}/R{$nextRevisi}";

    activity()
        ->causedBy(auth()->user())
        ->tap(fn ($a) => $a->id_user = auth()->id())
        ->withProperties([
            'kode_sample' => $kode_sample,
            'revisi_ke' => $nextRevisi,
            'nomor_formula' => $nomorFormula,
        ])
        ->log('Mengakses form revisi Master Formula Sample');

    return view('master_formula_sample.create_revisi', [
        'kodeSample' => $kode_sample,
        'nomorFormula' => $nomorFormula,
        'nextSampleNumber' => 0,
        'nextFormulaNumber' => $nextRevisi,
        'satuanList' => $satuanList,
        'listMerk' => $listMerk,
    ]);
}

   public function cekKodeSampleRevisi(Request $request)
{
    $keyword = $request->get('kode_sample');

    if (!$keyword) {
        activity()
            ->causedBy(auth()->user())
            ->tap(fn ($a) => $a->id_user = auth()->id())
            ->log('Gagal cek kode sample revisi: parameter tidak ada');

        return response()->json([
            'success' => false,
            'message' => 'Parameter kode_sample diperlukan.'
        ], 400);
    }

    $samples = MasterFormulaSample::select('kode_sample')
        ->get()
        ->map(fn ($item) => preg_replace('/-R\d+$/', '', $item->kode_sample))
        ->unique()
        ->filter(fn ($value) => strtolower($value) === strtolower($keyword))
        ->values();

    activity()
        ->causedBy(auth()->user())
        ->tap(fn ($a) => $a->id_user = auth()->id())
        ->withProperties(['input_kode_sample' => $keyword])
        ->log('Melakukan pengecekan kode sample untuk revisi');

    return response()->json([
        'success' => true,
        'data' => $samples
    ]);
}

    
public function getRevisiTerakhir(Request $request)
{
    $kodeSampleBase = $request->get('kode_sample');

    if (!$kodeSampleBase) {
        activity()
            ->causedBy(auth()->user())
            ->tap(fn ($a) => $a->id_user = auth()->id())
            ->withProperties(['kode_sample' => null])
            ->log('Gagal mengecek revisi terakhir: parameter kode_sample kosong');

        return response()->json([
            'success' => false,
            'message' => 'Parameter kode_sample diperlukan.'
        ], 400);
    }

    $existingSamples = MasterFormulaSample::where('kode_sample', 'like', $kodeSampleBase . '-R%')
        ->pluck('kode_sample');

    $revisiList = $existingSamples->map(function ($item) {
        if (preg_match('/-R(\d+)$/', $item, $matches)) {
            return (int) $matches[1];
        }
        return 0;
    });

    $lastRevisi = $revisiList->max() ?? 0;
    $nextRevisi = $lastRevisi + 1;

    activity()
        ->causedBy(auth()->user())
        ->tap(fn ($a) => $a->id_user = auth()->id())
        ->withProperties([
            'kode_sample' => $kodeSampleBase,
            'revisi_terakhir' => $lastRevisi,
            'revisi_berikutnya' => $nextRevisi
        ])
        ->log('Melihat revisi terakhir dari kode sample');

    return response()->json([
        'success' => true,
        'revisi_ke' => $nextRevisi
    ]);
}

    
    }
    