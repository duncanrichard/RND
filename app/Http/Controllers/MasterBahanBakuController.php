<?php

namespace App\Http\Controllers;

use App\Models\MasterBahanBaku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MasterBahanBakuController extends Controller
{
    public function index()
    {
        $bahan_baku = MasterBahanBaku::with(['supplierData', 'satuanData'])->get();

        activity()
            ->causedBy(Auth::user())
            ->tap(fn ($activity) => $activity->id_user = Auth::id())
            ->log('Melihat daftar Master List Sample Bahan Baku');

        return view('master_bahan_baku.index', compact('bahan_baku'));
    }

    public function create()
    {
        $lastBahanBaku = MasterBahanBaku::orderBy('kode', 'desc')->first();
        $lastNumber = $lastBahanBaku ? intval(substr($lastBahanBaku->kode, 1)) : 0;
        $kode = sprintf("S%05d", $lastNumber + 1);
        $satuanList = \App\Models\MasterSatuan::all(['id', 'nama_satuan']);

        activity()
            ->causedBy(Auth::user())
            ->tap(fn ($activity) => $activity->id_user = Auth::id())
            ->log('Mengakses form tambah Master List Sample Bahan Baku');

        return view('master_bahan_baku.create', compact('kode', 'satuanList'));
    }

    public function getNextKodeBahanBaku()
    {
        $lastBahanBaku = MasterBahanBaku::orderBy('kode', 'desc')->first();
        $kode = sprintf("S%05d", ($lastBahanBaku ? intval(substr($lastBahanBaku->kode, 1)) : 0) + 1);

        return response()->json(['kode' => $kode]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode' => 'required|string|unique:master_bahan_bakus,kode|max:255',
            'raw_material' => 'required|string|max:255',
            'inci_name' => 'required|string|max:255',
            'sediaan' => 'required|string|max:255',
            'principle' => 'required|string|max:255',
            'supplier' => 'required|string|max:255',
            'function' => 'required|string|max:255',
            'jumlah_diterima' => 'required|string|max:255',
            'satuan' => 'required|exists:master_satuan,id',
            'tgl_terima' => 'nullable|date',
            'keterangan' => 'nullable|string'
        ]);

        $bahan = MasterBahanBaku::create($validated);

        activity()
            ->causedBy(Auth::user())
            ->performedOn($bahan)
            ->tap(fn ($activity) => $activity->id_user = Auth::id())
            ->withProperties($validated)
            ->log('Menambahkan Master List Sample Bahan Baku');

        return redirect()->route('master_bahan_baku.index')
                         ->with('success', 'Data Master List Sample Bahan Baku berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $bahan_baku = MasterBahanBaku::findOrFail($id);
        $suppliers = \DB::connection('purchasing')->table('suppliers')->select('id', 'nama_suplier')->get();
        $satuanList = \App\Models\MasterSatuan::all(['id', 'nama_satuan']);

        activity()
            ->causedBy(Auth::user())
            ->performedOn($bahan_baku)
            ->tap(fn ($activity) => $activity->id_user = Auth::id())
            ->log('Mengakses form edit Master List Sample Bahan Baku');

        return view('master_bahan_baku.edit', compact('bahan_baku', 'suppliers', 'satuanList'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'kode' => 'required|string|max:255|unique:master_bahan_bakus,kode,' . $id,
            'raw_material' => 'required|string|max:255',
            'inci_name' => 'required|string|max:255',
            'sediaan' => 'required|string|max:255',
            'principle' => 'required|string|max:255',
            'supplier' => 'required|string|max:255',
            'function' => 'required|string|max:255',
            'jumlah_diterima' => 'required|string|max:255',
            'satuan' => 'required|exists:master_satuan,id',
            'tgl_terima' => 'nullable|date',
            'keterangan' => 'nullable|string'
        ]);

        $bahan_baku = MasterBahanBaku::findOrFail($id);
        $bahan_baku->update($validated);

        activity()
            ->causedBy(Auth::user())
            ->performedOn($bahan_baku)
            ->tap(fn ($activity) => $activity->id_user = Auth::id())
            ->withProperties($validated)
            ->log('Memperbarui Master List Sample Bahan Baku');

        return redirect()->route('master_bahan_baku.index')
                         ->with('success', 'Data Master List Sample Bahan Baku berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $bahan_baku = MasterBahanBaku::findOrFail($id);
        $bahan_baku->delete();

        activity()
            ->causedBy(Auth::user())
            ->performedOn($bahan_baku)
            ->tap(fn ($activity) => $activity->id_user = Auth::id())
            ->withProperties(['id' => $id, 'kode' => $bahan_baku->kode])
            ->log('Menghapus Master List Sample Bahan Baku');

        return redirect()->route('master_bahan_baku.index')
                         ->with('success', 'Data Master List Sample Bahan Baku berhasil dihapus.');
    }

    public function toggleApproval($id)
    {
        $bahan_baku = MasterBahanBaku::findOrFail($id);
        $bahan_baku->status_approval = !$bahan_baku->status_approval;
        $bahan_baku->save();

        activity()
            ->causedBy(Auth::user())
            ->performedOn($bahan_baku)
            ->tap(fn ($activity) => $activity->id_user = Auth::id())
            ->withProperties(['status_approval' => $bahan_baku->status_approval])
            ->log('Mengubah status approval Master List Sample Bahan Baku');

        return redirect()->route('master_bahan_baku.index')
                         ->with('success', 'Status approval berhasil diperbarui.');
    }
}
