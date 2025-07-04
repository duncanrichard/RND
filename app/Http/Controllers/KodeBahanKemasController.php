<?php

namespace App\Http\Controllers;

use App\Models\KodeBahanKemas;
use Illuminate\Http\Request;
use App\Models\MasterSatuan;
use Illuminate\Support\Facades\Auth;

class KodeBahanKemasController extends Controller
{
    public function index(Request $request)
    {
        $query = KodeBahanKemas::query();

        if ($request->has('jenis_kemasan') && $request->jenis_kemasan != '') {
            $query->where('jenis_kemasan', $request->jenis_kemasan);
        }

        $data = $query->get();

        activity()
            ->causedBy(Auth::user())
            ->tap(fn ($activity) => $activity->id_user = Auth::id())
            ->log('Melihat daftar Master Kategori Bahan Kemas');

        return view('kode_bahan_kemas.index', compact('data'));
    }

    public function filterJenisKemasan($kategoriKemasan)
    {
        $jenisKemasan = KodeBahanKemas::where('jenis_kemasan', $kategoriKemasan)
            ->select('id', 'nama_kode')
            ->get();

        activity()
            ->causedBy(Auth::user())
            ->tap(fn ($activity) => $activity->id_user = Auth::id())
            ->log("Filter data berdasarkan jenis_kemasan = $kategoriKemasan");

        return response()->json($jenisKemasan);
    }

    public function create()
    {
        $satuanOptions = MasterSatuan::all();

        activity()
            ->causedBy(Auth::user())
            ->tap(fn ($activity) => $activity->id_user = Auth::id())
            ->log('Mengakses form tambah Master Kategori Bahan Kemas');

        return view('kode_bahan_kemas.create', compact('satuanOptions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode' => 'required|unique:kode_bahan_kemas',
            'nama_kode' => 'nullable',
            'jenis_kemasan' => 'required|in:1,2',
        ]);

        $data = KodeBahanKemas::create($request->all());

        activity()
            ->causedBy(Auth::user())
            ->performedOn($data)
            ->tap(fn ($activity) => $activity->id_user = Auth::id())
            ->withProperties($request->only(['kode', 'nama_kode', 'jenis_kemasan']))
            ->log('Menambahkan Master Kategori Bahan Kemas');

        return redirect()->route('kode_bahan_kemas.index')->with('success', 'Master Kategori Bahan Kemas berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $item = KodeBahanKemas::findOrFail($id);
        $satuanOptions = MasterSatuan::all();
        $jenisKemasanOptions = KodeBahanKemas::where('jenis_kemasan', $item->jenis_kemasan)->get();

        activity()
            ->causedBy(Auth::user())
            ->performedOn($item)
            ->tap(fn ($activity) => $activity->id_user = Auth::id())
            ->log("Mengakses form edit Master Kategori Bahan Kemas ID $id");

        return view('kode_bahan_kemas.edit', compact('item', 'satuanOptions', 'jenisKemasanOptions'));
    }

    public function update(Request $request, $id)
    {
        $item = KodeBahanKemas::findOrFail($id);

        $request->validate([
            'kode' => 'required|unique:kode_bahan_kemas,kode,' . $item->id,
            'nama_kode' => 'nullable|string|max:255',
            'jenis_kemasan' => 'required|in:1,2',
        ]);

        $item->update([
            'kode' => $request->kode,
            'nama_kode' => $request->nama_kode,
            'jenis_kemasan' => $request->jenis_kemasan,
        ]);

        activity()
            ->causedBy(Auth::user())
            ->performedOn($item)
            ->tap(fn ($activity) => $activity->id_user = Auth::id())
            ->withProperties($request->only(['kode', 'nama_kode', 'jenis_kemasan']))
            ->log('Memperbarui Master Kategori Bahan Kemas');

        return redirect()->route('kode_bahan_kemas.index')->with('success', 'Master Kategori Bahan Kemas berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $item = KodeBahanKemas::findOrFail($id);
        $item->delete();

        activity()
            ->causedBy(Auth::user())
            ->performedOn($item)
            ->tap(fn ($activity) => $activity->id_user = Auth::id())
            ->withProperties([
                'id' => $id,
                'kode' => $item->kode,
                'nama_kode' => $item->nama_kode,
            ])
            ->log('Menghapus Master Kategori Bahan Kemas');

        return redirect()->route('kode_bahan_kemas.index')->with('success', 'Master Kategori Bahan Kemas berhasil dihapus.');
    }
}
