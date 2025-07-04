<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MasterPPN;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class MasterPPNController extends Controller
{
    public function index()
    {
        $this->updateExchangeRates();
        $master_ppn = MasterPPN::all();

        activity()
            ->causedBy(Auth::user())
            ->tap(fn ($activity) => $activity->id_user = Auth::id())
            ->log('Mengakses halaman daftar Master PPN');

        return view('master_ppn.index', compact('master_ppn'));
    }

    public function create()
    {
        $this->updateExchangeRates();

        if (MasterPPN::exists()) {
            activity()
                ->causedBy(Auth::user())
                ->tap(fn ($activity) => $activity->id_user = Auth::id())
                ->log('Gagal mengakses form tambah Master PPN karena data sudah ada');

            return redirect()->route('master_ppn.index')->with('error', 'Data sudah ada, tidak dapat menambahkan data baru.');
        }

        activity()
            ->causedBy(Auth::user())
            ->tap(fn ($activity) => $activity->id_user = Auth::id())
            ->log('Mengakses form tambah Master PPN');

        return view('master_ppn.create');
    }

    public function store(Request $request)
    {
        if (MasterPPN::exists()) {
            activity()
                ->causedBy(Auth::user())
                ->tap(fn ($activity) => $activity->id_user = Auth::id())
                ->log('Gagal menyimpan Master PPN karena data sudah ada');

            return redirect()->route('master_ppn.index')->with('error', 'Data sudah ada, tidak dapat menambahkan data baru.');
        }

        $this->updateExchangeRates();

        $request->validate([
            'ppn' => 'required|numeric',
            'pph' => 'required|numeric',
            'additional_cost' => 'required|numeric',
        ]);

        $master = MasterPPN::create([
            'ppn' => $request->ppn,
            'pph' => $request->pph,
            'kurs_usd' => session('kurs_usd', 16492.13),
            'kurs_euro' => session('kurs_euro', 17141.92),
            'kurs_yuan' => session('kurs_yuan', 2264.03),
            'kurs_rupiah' => session('kurs_rupiah', 1),
            'additional_cost' => $request->additional_cost,
        ]);

        activity()
            ->causedBy(Auth::user())
            ->performedOn($master)
            ->tap(fn ($activity) => $activity->id_user = Auth::id())
            ->withProperties($request->all())
            ->log('Menambahkan data Master PPN');

        return redirect()->route('master_ppn.index')->with('success', 'Data berhasil ditambahkan');
    }

    public function edit($id)
    {
        $master_ppn = MasterPPN::findOrFail($id);

        activity()
            ->causedBy(Auth::user())
            ->performedOn($master_ppn)
            ->tap(fn ($activity) => $activity->id_user = Auth::id())
            ->log('Mengakses form edit Master PPN');

        return view('master_ppn.edit', compact('master_ppn'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'ppn' => 'required|numeric',
            'pph' => 'required|numeric',
            'additional_cost' => 'required|numeric',
        ]);

        $master_ppn = MasterPPN::findOrFail($id);
        $master_ppn->update([
            'ppn' => $request->ppn,
            'pph' => $request->pph,
            'additional_cost' => $request->additional_cost,
        ]);

        activity()
            ->causedBy(Auth::user())
            ->performedOn($master_ppn)
            ->tap(fn ($activity) => $activity->id_user = Auth::id())
            ->withProperties($request->all())
            ->log('Memperbarui data Master PPN');

        return redirect()->route('master_ppn.index')->with('success', 'Data berhasil diperbarui');
    }

    public function destroy($id)
    {
        $masterPpn = MasterPPN::findOrFail($id);
        $masterPpn->delete();

        activity()
            ->causedBy(Auth::user())
            ->performedOn($masterPpn)
            ->tap(fn ($activity) => $activity->id_user = Auth::id())
            ->withProperties(['id' => $id])
            ->log('Menghapus data Master PPN');

        return redirect()->route('master_ppn.index')->with('success', 'Data berhasil dihapus');
    }

    public function updateExchangeRates()
    {
        $apiUrl = "https://www.bi.go.id/biwebservice/wskursbi.asmx?op=getSubKursAsing1";

        try {
            $response = Http::withHeaders([
                'Content-Type' => 'text/xml; charset=utf-8',
                'SOAPAction' => 'http://www.bi.go.id/getSubKursAsing1'
            ])->timeout(10)->get($apiUrl);

            if ($response->successful()) {
                $xmlResponse = simplexml_load_string($response->body());

                if ($xmlResponse) {
                    $xmlResponse->registerXPathNamespace('ns', 'http://www.bi.go.id/');
                    $kursData = $xmlResponse->xpath('//ns:getSubKursAsing1Result')[0] ?? null;

                    if ($kursData) {
                        $kursArray = json_decode(json_encode($kursData), true);

                        $kurs_usd = $this->getKursByCode($kursArray, 'USD');
                        $kurs_euro = $this->getKursByCode($kursArray, 'EUR');
                        $kurs_yuan = $this->getKursByCode($kursArray, 'CNY');

                        if ($kurs_usd && $kurs_euro && $kurs_yuan) {
                            $masterPpn = MasterPPN::first();
                            if ($masterPpn) {
                                $masterPpn->update([
                                    'kurs_usd' => $kurs_usd,
                                    'kurs_euro' => $kurs_euro,
                                    'kurs_yuan' => $kurs_yuan,
                                ]);
                            }

                            session([
                                'kurs_usd' => $kurs_usd,
                                'kurs_euro' => $kurs_euro,
                                'kurs_yuan' => $kurs_yuan,
                                'kurs_rupiah' => 1,
                            ]);

                            return;
                        }
                    }
                }
            }
        } catch (\Exception $e) {
            Log::error("Error fetching exchange rates from BI: " . $e->getMessage());

            session([
                'kurs_usd' => 16492.13,
                'kurs_euro' => 17141.92,
                'kurs_yuan' => 2264.03,
                'kurs_rupiah' => 1,
            ]);
        }
    }

    private function getKursByCode($kursArray, $code)
    {
        foreach ($kursArray as $kurs) {
            if (isset($kurs['KODE']) && $kurs['KODE'] === $code) {
                return (float) str_replace(',', '', $kurs['beli']);
            }
        }
        return null;
    }
}
