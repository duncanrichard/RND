<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MasterKemasan;
use App\Models\KodeBahanKemas;
use App\Models\MasterSatuan;
use App\Models\MasterPPN;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

class MasterKemasanController extends Controller
{
    public function index(Request $request)
    {
        $query = MasterKemasan::with(['jenisKemasan', 'satuan']);

        if ($request->has('kategori_kemasan') && $request->kategori_kemasan != '') {
            $query->where('kategori_kemasan', $request->kategori_kemasan);
        }

        $data = $query->get();

        activity()
            ->causedBy(Auth::user())
            ->tap(fn ($a) => $a->id_user = Auth::id())
            ->log('Mengakses halaman daftar Master Bahan Kemas');

        return view('master_kemasan.index', compact('data'));
    }

    public function create()
    {
        $satuanOptions = MasterSatuan::all();
        $latestPPN = MasterPPN::latest('created_at')->first();
        $defaultPPN = $latestPPN->ppn ?? 0;
        $defaultAdditionalCost = $latestPPN->additional_cost ?? 0;

        activity()
            ->causedBy(Auth::user())
            ->tap(fn ($a) => $a->id_user = Auth::id())
            ->log('Mengakses form tambah Master Bahan Kemas');

        return view('master_kemasan.create', compact('satuanOptions', 'defaultPPN', 'defaultAdditionalCost'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kategori_kemasan' => 'required|in:1,2',
            'jenis_kemasan' => 'required|exists:kode_bahan_kemas,id',
            'nama_kemasan' => 'required|string|max:255',
            'satuan' => 'required|exists:master_satuan,nama_satuan',
            'cara_penyimpanan' => 'nullable|string|max:255',
            'harga_po' => 'required|numeric',
            'ppn' => 'nullable|numeric',
            'mark_up' => 'nullable|numeric',
            'hpbk' => 'nullable|numeric',
        ]);

        $latestPPN = MasterPPN::latest('created_at')->first();
        $defaultPPN = $latestPPN->ppn ?? 0;
        $defaultAdditionalCost = $latestPPN->additional_cost ?? 0;

        $hargaPO = $request->harga_po;
        $ppn = $hargaPO * ($defaultPPN / 100);
        $additionalCost = $hargaPO * ($defaultAdditionalCost / 100);
        $hpbk = $hargaPO + $ppn + $additionalCost;

        $prefix = $request->kategori_kemasan == 1 ? 'P' : 'S';
        $kodeJenisKemasan = KodeBahanKemas::find($request->jenis_kemasan)->kode ?? 'XXX';
        $lastKemasan = MasterKemasan::where('kategori_kemasan', $request->kategori_kemasan)
            ->where('jenis_kemasan', $request->jenis_kemasan)
            ->orderBy('kode_kemasan', 'desc')
            ->first();

        $urutBaru = $lastKemasan
            ? str_pad((int) substr($lastKemasan->kode_kemasan, -5) + 1, 5, '0', STR_PAD_LEFT)
            : '00001';

        $kodeKemasanBaru = "{$prefix}{$kodeJenisKemasan}{$urutBaru}";

        $kemasan = MasterKemasan::create([
            'kategori_kemasan' => $request->kategori_kemasan,
            'jenis_kemasan' => $request->jenis_kemasan,
            'kode_kemasan' => $kodeKemasanBaru,
            'nama_kemasan' => $request->nama_kemasan,
            'satuan' => $request->satuan,
            'cara_penyimpanan' => $request->cara_penyimpanan,
            'harga_po' => $hargaPO,
            'ppn' => $ppn,
            'mark_up' => $additionalCost,
            'hpbk' => $hpbk,
        ]);

        activity()
            ->causedBy(Auth::user())
            ->performedOn($kemasan)
            ->tap(fn ($a) => $a->id_user = Auth::id())
            ->withProperties($request->all())
            ->log('Menyimpan data Master Bahan Kemas');

        return redirect()->route('master_kemasan.index')->with('success', 'Data berhasil disimpan.');
    }

    public function edit($id)
    {
        $data = MasterKemasan::findOrFail($id);
        $satuanOptions = MasterSatuan::all();
        $jenisKemasanOptions = KodeBahanKemas::where('jenis_kemasan', $data->kategori_kemasan)->get();
        $latestPPN = MasterPPN::latest('created_at')->first();
        $defaultPPN = $latestPPN->ppn ?? 0;
        $defaultAdditionalCost = $latestPPN->additional_cost ?? 0;

        activity()
            ->causedBy(Auth::user())
            ->performedOn($data)
            ->tap(fn ($a) => $a->id_user = Auth::id())
            ->log('Mengakses form edit Master Bahan Kemas');

        return view('master_kemasan.edit', compact('data', 'satuanOptions', 'jenisKemasanOptions', 'defaultPPN', 'defaultAdditionalCost'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'kategori_kemasan' => 'required|in:1,2',
            'jenis_kemasan' => 'required|exists:kode_bahan_kemas,id',
            'nama_kemasan' => 'required|string|max:255',
            'satuan' => 'required|exists:master_satuan,id',
            'cara_penyimpanan' => 'nullable|string|max:255',
            'harga_po' => 'required|numeric',
            'ppn' => 'nullable|numeric',
            'mark_up' => 'nullable|numeric',
            'hpbk' => 'nullable|numeric',
        ]);

        $data = MasterKemasan::findOrFail($id);

        $latestPPN = MasterPPN::latest('created_at')->first();
        $defaultPPN = $latestPPN->ppn ?? 0;
        $defaultAdditionalCost = $latestPPN->additional_cost ?? 0;

        $hargaPO = $request->harga_po;
        $ppn = $hargaPO * ($defaultPPN / 100);
        $additionalCost = $hargaPO * ($defaultAdditionalCost / 100);
        $hpbk = $hargaPO + $ppn + $additionalCost;

        $data->update([
            'kategori_kemasan' => $request->kategori_kemasan,
            'jenis_kemasan' => $request->jenis_kemasan,
            'nama_kemasan' => $request->nama_kemasan,
            'satuan' => $request->satuan,
            'cara_penyimpanan' => $request->cara_penyimpanan,
            'harga_po' => $hargaPO,
            'ppn' => $ppn,
            'mark_up' => $additionalCost,
            'hpbk' => $hpbk,
        ]);

        activity()
            ->causedBy(Auth::user())
            ->performedOn($data)
            ->tap(fn ($a) => $a->id_user = Auth::id())
            ->withProperties($request->all())
            ->log('Memperbarui data Master Bahan Kemas');

        return redirect()->route('master_kemasan.index')->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $data = MasterKemasan::findOrFail($id);
        $data->delete();

        activity()
            ->causedBy(Auth::user())
            ->performedOn($data)
            ->tap(fn ($a) => $a->id_user = Auth::id())
            ->withProperties(['id' => $id])
            ->log('Menghapus data Master Bahan Kemas');

        return redirect()->route('master_kemasan.index')->with('success', 'Data berhasil dihapus.');
    }

    public function generateKodeKemasan($id, Request $request)
    {
        $kategori = $request->get('kategori');
        $prefix = $kategori == 1 ? 'P' : 'S';
        $kodeJenisKemasan = KodeBahanKemas::find($id)->kode ?? 'XXX';

        $lastKemasan = MasterKemasan::where('kategori_kemasan', $kategori)
            ->where('jenis_kemasan', $id)
            ->orderBy('kode_kemasan', 'desc')
            ->first();

        $urutBaru = $lastKemasan
            ? str_pad((int) substr($lastKemasan->kode_kemasan, -5) + 1, 5, '0', STR_PAD_LEFT)
            : '00001';

        $kodeKemasanBaru = "{$prefix}/{$kodeJenisKemasan}/{$urutBaru}";

        activity()
            ->causedBy(Auth::user())
            ->tap(fn ($a) => $a->id_user = Auth::id())
            ->withProperties(['jenis_kemasan_id' => $id, 'generated_kode' => $kodeKemasanBaru])
            ->log('Generate kode kemasan otomatis');

        return response()->json(['kode_kemasan' => $kodeKemasanBaru]);
    }

    public function print(Request $request)
    {
        $query = MasterKemasan::with(['jenisKemasan']);

        if ($request->has('kategori_kemasan') && $request->kategori_kemasan !== null) {
            $query->where('kategori_kemasan', $request->kategori_kemasan);
        }

        $data = $query->get();

        activity()
            ->causedBy(Auth::user())
            ->tap(fn ($a) => $a->id_user = Auth::id())
            ->withProperties(['kategori_filter' => $request->kategori_kemasan ?? 'semua'])
            ->log('Mencetak PDF data Master Bahan Kemas');

        return Pdf::loadView('master_kemasan.print', compact('data'))
            ->setPaper('a4', 'landscape')
            ->stream('data-master-kemasan.pdf');
    }
}
