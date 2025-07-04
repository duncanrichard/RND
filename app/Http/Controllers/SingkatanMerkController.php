<?php
namespace App\Http\Controllers;

use App\Models\SingkatanMerk;
use Illuminate\Http\Request;

class SingkatanMerkController extends Controller
{
    public function index()
    {
        $data = SingkatanMerk::all();
        return view('singkatan_merk.index', compact('data'));
    }

    public function create()
    {
        return view('singkatan_merk.create');
    }

    public function store(Request $request)
{
    $request->validate([
        'nama_merk' => 'required|unique:singkatan_merk,nama_merk',
        'singkatan_merk' => 'required|unique:singkatan_merk,singkatan_merk',
        'tahun' => 'required|digits:4',
        'lokasi' => 'required',
    ], [
        'nama_merk.unique' => 'Nama Merk sudah ada, silakan gunakan yang lain.',
        'singkatan_merk.unique' => 'Singkatan Merk sudah ada, silakan gunakan yang lain.'
    ]);

    SingkatanMerk::create($request->all());

    return redirect()->route('singkatan-merk.index')->with('success', 'Data berhasil ditambahkan');
}


    public function edit($id)
    {
        $merk = SingkatanMerk::findOrFail($id);
        return view('singkatan_merk.edit', compact('merk'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_merk' => 'required',
            'singkatan_merk' => 'required',
            'tahun' => 'required|digits:4',
            'lokasi' => 'required',
        ]);

        SingkatanMerk::findOrFail($id)->update($request->all());

        return redirect()->route('singkatan-merk.index')->with('success', 'Data berhasil diperbarui');
    }

    public function destroy($id)
    {
        SingkatanMerk::destroy($id);
        return redirect()->route('singkatan-merk.index')->with('success', 'Data berhasil dihapus');
    }
}
