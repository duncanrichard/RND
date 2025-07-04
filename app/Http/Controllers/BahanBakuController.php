<?php

namespace App\Http\Controllers;

use App\Models\BahanBaku;
use App\Models\JenisBahanBaku;
use App\Models\MasterSatuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class BahanBakuController extends Controller
{
    public function index(Request $request)
    {
        $jenisBahanBakus = JenisBahanBaku::all();
        $selectedKode = $request->get('kode_bahan_baku');

        $bahanBakus = BahanBaku::with('jenisBahanBaku');

        if ($selectedKode) {
            $bahanBakus = $bahanBakus->where('kode_bahan_baku', $selectedKode);
        }

        $bahanBakus = $bahanBakus->get();

        foreach ($bahanBakus as $bahanBaku) {
            $bahanBaku->jenis_bahan_baku_jenis_urut = ($bahanBaku->jenisBahanBaku->jenis_bahan_baku ?? '-') . '-' . $bahanBaku->urutan_kode_bahan_baku;
        }

        activity()->causedBy(Auth::user())
             ->tap(fn ($activity) => $activity->id_user = auth()->id())->log('Mengakses halaman Master Bahan Baku');
        return view('bahan_baku.index', compact('bahanBakus', 'jenisBahanBakus', 'selectedKode'));
    }

    public function create()
    {
        $jenisBahanBakus = JenisBahanBaku::all();
        $satuans = MasterSatuan::all();
        $ppn = \DB::table('master_p_p_n_s')->latest('id')->value('ppn');
        $markUp = \DB::table('master_p_p_n_s')->latest('id')->value('additional_cost');

        activity()->causedBy(Auth::user())
             ->tap(fn ($activity) => $activity->id_user = auth()->id())->log('Mengakses form tambah Master Bahan Baku');
        return view('bahan_baku.create', compact('jenisBahanBakus', 'satuans', 'ppn', 'markUp'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'kode_nama_bahan_baku' => 'nullable|exists:jenis_bahan_baku,id',
            'nama_bahan_baku_manual' => 'nullable|string|max:255',
            'koding_bahan_baku' => 'required|string|max:255',
            'nama_coding' => 'required|string|max:255',
            'nama_inci' => 'required|string|max:255',
            'jenis_sediaan' => 'required|string|max:255',
            'satuan' => 'required|exists:master_satuan,id',
            'cara_penyimpanan' => 'required|string|max:255',
            'harga_po' => 'required|numeric|min:0',
            'ppn' => 'required|numeric|min:0',
            'mark_up' => 'required|numeric|min:0',
            'hpbb' => 'required|numeric|min:0',
            'coa_file' => 'nullable|mimes:pdf|max:2048',
            'msds_file' => 'nullable|mimes:pdf|max:2048',
            'sertifikat_halal_file' => 'nullable|mimes:pdf|max:2048',
        ]);

        $satuan = MasterSatuan::find($validatedData['satuan']);
        $validatedData['satuan'] = $satuan ? $satuan->nama_satuan : null;

        if ($request->filled('kode_nama_bahan_baku')) {
            $jenisBahanBaku = JenisBahanBaku::find($request->kode_nama_bahan_baku);
            $validatedData['jenis_bahan_baku'] = $jenisBahanBaku->jenis_bahan_baku ?? null;
            $validatedData['nama_bahan_baku'] = $jenisBahanBaku->nama_bahan_baku ?? null;
            $validatedData['kode_bahan_baku'] = $request->kode_nama_bahan_baku;
        } elseif ($request->filled('nama_bahan_baku_manual')) {
            $validatedData['nama_bahan_baku'] = $request->nama_bahan_baku_manual;
            $validatedData['kode_bahan_baku'] = null;
        }

        $validatedData['urutan_kode_bahan_baku'] = '00001';
        if (!empty($validatedData['kode_bahan_baku'])) {
            $last = BahanBaku::where('kode_bahan_baku', $validatedData['kode_bahan_baku'])->latest('urutan_kode_bahan_baku')->first();
            $validatedData['urutan_kode_bahan_baku'] = $last
                ? str_pad((int) $last->urutan_kode_bahan_baku + 1, 5, '0', STR_PAD_LEFT)
                : '00001';
        }

        $timestamp = now()->format('Ymd_His');
        $namaCoding = str_replace(' ', '_', $validatedData['nama_coding']);

        foreach (['coa_file', 'msds_file', 'sertifikat_halal_file'] as $fileType) {
            if ($request->hasFile($fileType)) {
                $filename = "{$namaCoding}_" . strtoupper(str_replace('_file', '', $fileType)) . "_{$timestamp}.pdf";
                $validatedData[$fileType] = $request->file($fileType)->storeAs("uploads/{$fileType}s", $filename, 'public');
            }
        }

        $bahanBaku = BahanBaku::create($validatedData);

        activity()->causedBy(Auth::user())
             ->tap(fn ($activity) => $activity->id_user = auth()->id())->performedOn($bahanBaku)->log('Menambahkan Master Bahan Baku');

        return redirect()->route('bahan_baku.index')->with('success', 'Master Bahan Baku berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $bahanBaku = BahanBaku::findOrFail($id);
        $jenisBahanBakus = JenisBahanBaku::all();
        $satuans = MasterSatuan::all();
        $ppn = \DB::table('master_p_p_n_s')->latest('id')->value('ppn');
        $markUp = \DB::table('master_p_p_n_s')->latest('id')->value('additional_cost');

        activity()->causedBy(Auth::user())
             ->tap(fn ($activity) => $activity->id_user = auth()->id())->performedOn($bahanBaku)->log('Mengakses form edit Master Bahan Baku');

        return view('bahan_baku.edit', compact('bahanBaku', 'jenisBahanBakus', 'satuans', 'ppn', 'markUp'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'kode_nama_bahan_baku' => 'nullable|exists:jenis_bahan_baku,id',
            'nama_bahan_baku_manual' => 'nullable|string|max:255',
            'koding_bahan_baku' => 'required|string|max:255',
            'nama_coding' => 'required|string|max:255',
            'nama_inci' => 'required|string|max:255',
            'jenis_sediaan' => 'required|string|max:255',
            'satuan' => 'required|exists:master_satuan,id',
            'cara_penyimpanan' => 'required|string|max:255',
            'harga_po' => 'required|numeric',
            'ppn' => 'required',
            'mark_up' => 'required',
            'hpbb' => 'required',
            'coa_file' => 'nullable|mimes:pdf|max:2048',
            'msds_file' => 'nullable|mimes:pdf|max:2048',
            'sertifikat_halal_file' => 'nullable|mimes:pdf|max:2048',
        ]);

        $hargaPo = $validatedData['harga_po'];
        $ppnValue = $hargaPo * ($validatedData['ppn'] / 100);
        $markUpValue = $hargaPo * ($validatedData['mark_up'] / 100);
        $validatedData['hpbb'] = $hargaPo + $ppnValue + $markUpValue;

        $satuan = MasterSatuan::find($validatedData['satuan']);
        $validatedData['satuan'] = $satuan ? $satuan->nama_satuan : null;

        $bahanBaku = BahanBaku::findOrFail($id);

        if ($request->filled('kode_nama_bahan_baku')) {
            $jenisBahanBaku = JenisBahanBaku::find($request->kode_nama_bahan_baku);
            $validatedData['nama_bahan_baku'] = $jenisBahanBaku->jenis_bahan_baku ?? '-';
        } elseif ($request->filled('nama_bahan_baku_manual')) {
            $validatedData['nama_bahan_baku'] = $request->nama_bahan_baku_manual;
        }

        $timestamp = now()->format('Ymd_His');
        $namaCoding = str_replace(' ', '_', $validatedData['nama_coding']);

        foreach (['coa_file', 'msds_file', 'sertifikat_halal_file'] as $fileType) {
            if ($request->hasFile($fileType)) {
                if ($bahanBaku->{$fileType}) {
                    Storage::disk('public')->delete($bahanBaku->{$fileType});
                }
                $filename = "{$namaCoding}_" . strtoupper(str_replace('_file', '', $fileType)) . "_{$timestamp}.pdf";
                $validatedData[$fileType] = $request->file($fileType)->storeAs("uploads/{$fileType}s", $filename, 'public');
            }
        }

        $bahanBaku->update($validatedData);

        activity()->causedBy(Auth::user())
             ->tap(fn ($activity) => $activity->id_user = auth()->id())->performedOn($bahanBaku)->log('Memperbarui Master Bahan Baku');

        return redirect()->route('bahan_baku.index')->with('success', 'Master Bahan Baku berhasil diperbarui.');
    }

    public function show($id)
    {
        $bahanBaku = BahanBaku::with('jenisBahanBaku')->findOrFail($id);

        activity()->causedBy(Auth::user())
             ->tap(fn ($activity) => $activity->id_user = auth()->id())->performedOn($bahanBaku)->log('Melihat detail Master Bahan Baku');

        return view('bahan_baku.show', compact('bahanBaku'));
    }

    public function destroy($id)
    {
        $bahanBaku = BahanBaku::findOrFail($id);
        $bahanBaku->delete();

        activity()->causedBy(Auth::user())
             ->tap(fn ($activity) => $activity->id_user = auth()->id())->performedOn($bahanBaku)->log('Menghapus Master Bahan Baku');

        return redirect()->route('bahan_baku.index')->with('success', 'Master Bahan Baku berhasil dihapus.');
    }

    public function print(Request $request)
    {
        $selectedKode = $request->get('kode_bahan_baku');
        $bahanBakus = BahanBaku::with('jenisBahanBaku');

        if ($selectedKode) {
            $bahanBakus = $bahanBakus->where('kode_bahan_baku', $selectedKode);
        }

        $bahanBakus = $bahanBakus->get();

        foreach ($bahanBakus as $bahanBaku) {
            $bahanBaku->jenis_bahan_baku_jenis_urut = ($bahanBaku->jenisBahanBaku->jenis_bahan_baku ?? '-') . '-' . $bahanBaku->urutan_kode_bahan_baku;
        }

        activity()->causedBy(Auth::user())
             ->tap(fn ($activity) => $activity->id_user = auth()->id())->log('Mencetak data Master Bahan Baku');

        return Pdf::loadView('bahan_baku.print', compact('bahanBakus'))->stream('data-bahan-baku.pdf');
    }
}
