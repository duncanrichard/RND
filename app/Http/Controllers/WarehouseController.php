<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Warehouse;


class WarehouseController extends Controller
{
    public function index(Request $request)
    {
        $data = warehouse::all();
        return view('warehouse', compact('data'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_warehouse' => 'required|string|max:255',
            'warehouse' => 'required|string|max:255',
        ]);

        Warehouse::create([
            'kode_warehouse' => $request->kode_warehouse,
            'warehouse' => $request->warehouse,
        ]);

        return redirect()->route('warehouse.index')->with('success', 'Data warehouse berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $warehouse = Warehouse::findOrFail($id);
        return view('warehouse', compact('warehouse'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'kode_warehouse' => 'required|string|max:255',
            'warehouse' => 'required|string|max:255',
        ]);

        $warehouse = Warehouse::findOrFail($id);
        $warehouse->update([
            'kode_warehouse' => $request->kode_warehouse,
            'warehouse' => $request->warehouse,
        ]);

        return redirect()->route('warehouse.index')->with('success', 'Data warehouse berhasil diupdate.');
    }
    
    public function destroy($id)
    {
        $warehouse = Warehouse::findOrFail($id);
        $warehouse->delete();

        return redirect()->route('warehouse.index')->with('success', 'Data warehouse berhasil dihapus.');
    }


    public function export()
    {
        return Excel::download(new warehouseExport, 'warehouse.xlsx');
    }



    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xls,xlsx',
        ]);

        Excel::import(new class implements ToModel {
            public function model(array $row)
            {
                return new warehouse([
                    'jenis'            => $row[0] ?? null,
                    'golongan_tindakan' => $row[1] ?? null,
                    'nama_tindakan'     => $row[2] ?? null,
                    'kode_tindakan'     => $row[3] ?? null,
                    'id_jenis'          => $row[4] ?? null,
                    'id_anatomi'        => $row[5] ?? null,
                    'kode_treatment'    => $row[6] ?? null,
                ]);
            }
        }, $request->file('file'));

        return redirect()->route('warehouse.index')
                         ->with('success', 'Data berhasil diimpor!');
    }

    public function printPDF()
    {
        $data = warehouse::all();
        $pdf = Pdf::loadView('print.warehouse_pdf', compact('data'));
        return $pdf->download('warehouse.pdf');
    }


}