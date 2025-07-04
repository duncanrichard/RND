<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductStability;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

class StabilitasRDController extends Controller
{
    public function index()
    {
        $products = Product::with('stabilities')->get();
        $notifications = [];

        foreach ($products as $product) {
            $tanggalAwal = \Carbon\Carbon::parse($product->tanggal);

            $product->nextAccelerated = $tanggalAwal->copy()->addMonth()->subDays(3);
            $product->nextLongTerm = $tanggalAwal->copy()->addMonths(3)->subDays(3);

            $product->daysToAccelerated = now()->diffInDays($product->nextAccelerated, false);
            $product->daysToLongTerm = now()->diffInDays($product->nextLongTerm, false);

            $product->daysToAccelerated = max($product->daysToAccelerated, 0);
            $product->daysToLongTerm = max($product->daysToLongTerm, 0);

            $product->isAcceleratedDue = $product->daysToAccelerated <= 3;
            $product->isLongTermDue = $product->daysToLongTerm <= 3;

            if ($product->isAcceleratedDue || $product->isLongTermDue) {
                $notifications[] = [
                    'nama_produk' => $product->nama_produk,
                    'nextAccelerated' => $product->nextAccelerated->format('d-m-Y'),
                    'nextLongTerm' => $product->nextLongTerm->format('d-m-Y'),
                    'daysToAccelerated' => $product->daysToAccelerated,
                    'daysToLongTerm' => $product->daysToLongTerm,
                ];
            }
        }

        activity()
            ->causedBy(Auth::user())
             ->tap(fn ($activity) => $activity->id_user = auth()->id())
            ->log('Mengakses daftar data stabilitas R&D');

        return view('master_data_stabilitas_rd.index', compact('products', 'notifications'));
    }

    public function create()
    {
        activity()
            ->causedBy(Auth::user())
             ->tap(fn ($activity) => $activity->id_user = auth()->id())
            ->log('Mengakses form input data stabilitas R&D');

        return view('master_data_stabilitas_rd.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_produk' => 'required|string|max:255',
            'syarat_accelerated.*' => 'nullable|string',
            'accelerated' => 'array',
            'syarat_long_term.*' => 'nullable|string',
            'long_term' => 'array',
        ]);

        $product = Product::create($request->only(['nama_produk', 'tanggal', 'id_input', 'tgl_trial', 'no_formula', 'kode_sample']));

        $filled_accelerated = false;
        $filled_long_term = false;

        if (!empty($request->accelerated)) {
            foreach ($request->accelerated as $parameter => $data) {
                $checklist = [];
                foreach ($data as $key => $value) {
                    $checklist[$key] = [
                        'value' => $value ?? '-',
                        'keterangan' => $request->keterangan_accelerated[$parameter][$key] ?? '-',
                    ];
                    if ($key == 'awal' && !empty($value)) {
                        $filled_accelerated = true;
                    }
                }

                ProductStability::create([
                    'product_id' => $product->id,
                    'parameter' => ucfirst($parameter),
                    'type' => 'accelerated',
                    'syarat' => $request->syarat_accelerated[$parameter] ?? '-',
                    'checklist' => json_encode($checklist),
                ]);
            }
        }

        if (!empty($request->long_term)) {
            foreach ($request->long_term as $parameter => $data) {
                $checklist = [];
                foreach ($data as $key => $value) {
                    $checklist[$key] = [
                        'value' => $value ?? '-',
                        'keterangan' => $request->keterangan_long_term[$parameter][$key] ?? '-',
                    ];
                    if ($key == 'awal' && !empty($value)) {
                        $filled_long_term = true;
                    }
                }

                ProductStability::create([
                    'product_id' => $product->id,
                    'parameter' => ucfirst($parameter),
                    'type' => 'long_term',
                    'syarat' => $request->syarat_long_term[$parameter] ?? '-',
                    'checklist' => json_encode($checklist),
                ]);
            }
        }

        session()->flash('filled_columns_accelerated', $filled_accelerated ? '1' : '0');
        session()->flash('filled_columns_long_term', $filled_long_term ? '1' : '0');
        session()->flash('formSubmitted', 'true');

        activity()
            ->causedBy(Auth::user())
             ->tap(fn ($activity) => $activity->id_user = auth()->id())
            ->performedOn($product)
            ->log('Menyimpan data stabilitas R&D baru');

        return redirect()->route('master_data_stabilitas_rd.index')->with('success', 'Data Stabilitas R&D berhasil disimpan.');
    }

    public function edit($id)
    {
        $product = Product::with('stabilities')->findOrFail($id);

        $stabilities = $product->stabilities->groupBy('type')->map(function ($group) {
            return $group->mapWithKeys(function ($stability) {
                return [
                    strtolower($stability->parameter) => [
                        'syarat' => $stability->syarat,
                        'checklist' => json_decode($stability->checklist, true),
                    ],
                ];
            });
        });

        activity()
            ->causedBy(Auth::user())
             ->tap(fn ($activity) => $activity->id_user = auth()->id())
            ->performedOn($product)
            ->log('Mengakses form edit stabilitas R&D');

        return view('master_data_stabilitas_rd.edit', compact('product', 'stabilities'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'syarat_accelerated.*' => 'nullable|string',
            'accelerated' => 'array',
            'syarat_long_term.*' => 'nullable|string',
            'long_term' => 'array',
        ]);

        $product = Product::findOrFail($id);

        $product->update($request->only(['tanggal', 'id_input', 'tgl_trial', 'no_formula', 'kode_sample', 'nama_produk']));

        ProductStability::where('product_id', $product->id)->delete();

        $filled_accelerated = false;

        if (!empty($request->accelerated)) {
            foreach ($request->accelerated as $parameter => $data) {
                $checklist = [];
                foreach ($data as $key => $value) {
                    $checklist[$key] = [
                        'value' => $value ?? '-',
                        'keterangan' => $request->keterangan_accelerated[$parameter][$key] ?? '-',
                    ];
                    if ($key == 'awal' && !empty($value)) {
                        $filled_accelerated = true;
                    }
                }

                ProductStability::create([
                    'product_id' => $product->id,
                    'parameter' => ucfirst($parameter),
                    'type' => 'accelerated',
                    'syarat' => $request->syarat_accelerated[$parameter] ?? '-',
                    'checklist' => json_encode($checklist),
                ]);
            }
        }

        session(['filled_columns_accelerated' => $filled_accelerated ? '1' : '0']);

        activity()
            ->causedBy(Auth::user())
             ->tap(fn ($activity) => $activity->id_user = auth()->id())
            ->performedOn($product)
            ->log('Memperbarui data stabilitas R&D');

        return redirect()->route('master_data_stabilitas_rd.index')->with('success', 'Data Stabilitas R&D berhasil diperbarui.');
    }

    public function show($id)
    {
        $product = Product::with('stabilities')->findOrFail($id);

        activity()
            ->causedBy(Auth::user())
             ->tap(fn ($activity) => $activity->id_user = auth()->id())
            ->performedOn($product)
            ->log('Melihat detail stabilitas R&D');

        return view('master_data_stabilitas_rd.show', compact('product'));
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        ProductStability::where('product_id', $product->id)->delete();
        $product->delete();

        activity()
            ->causedBy(Auth::user())
             ->tap(fn ($activity) => $activity->id_user = auth()->id())
            ->performedOn($product)
            ->log('Menghapus data stabilitas R&D');

        return redirect()->route('master_data_stabilitas_rd.index')->with('success', 'Data produk dan stabilitas berhasil dihapus.');
    }

    public function search(Request $request)
    {
        $search = $request->input('search');

        $results = \App\Models\MasterFormulaSample::where('nomor_formula', 'like', "%{$search}%")
            ->orWhere('tanggal', 'like', "%{$search}%")
            ->orWhere('kode_sample', 'like', "%{$search}%")
            ->orWhere('nama_sample', 'like', "%{$search}%")
            ->get();

        activity()
            ->causedBy(Auth::user())
             ->tap(fn ($activity) => $activity->id_user = auth()->id())
            ->withProperties(['search' => $search])
            ->log('Melakukan pencarian sample untuk input stabilitas R&D');

        return view('master_data_stabilitas_rd.create', compact('results'));
    }

    public function printPDF($id)
    {
        $product = Product::with('stabilities')->findOrFail($id);

        activity()
            ->causedBy(Auth::user())
             ->tap(fn ($activity) => $activity->id_user = auth()->id())
            ->performedOn($product)
            ->log('Mencetak PDF data stabilitas R&D');

        $pdf = Pdf::loadView('master_data_stabilitas_rd.pdf', compact('product'));
        return $pdf->stream("stabilitas_rd_{$product->id}.pdf");
    }
}
