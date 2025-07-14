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
    // Cek jika data sudah ada (hanya boleh satu entry)
    if (MasterPPN::exists()) {
        activity()
            ->causedBy(Auth::user())
            ->tap(fn ($activity) => $activity->id_user = Auth::id())
            ->log('Gagal menyimpan Master PPN karena data sudah ada');

        return redirect()->route('master_ppn.index')->with('error', 'Data sudah ada, tidak dapat menambahkan data baru.');
    }

    // Ambil kurs terbaru dari BI (akan disimpan ke session)
    $this->updateExchangeRates();

    // Validasi input user
    $request->validate([
        'ppn' => 'required|numeric',
        'pph' => 'required|numeric',
        'additional_cost' => 'required|numeric',
    ]);

    // Ambil kurs dari session (sudah diisi oleh updateExchangeRates)
    $kurs_usd = session('kurs_usd');
    $kurs_euro = session('kurs_euro');
    $kurs_yuan = session('kurs_yuan');
    $kurs_rupiah = session('kurs_rupiah', 1); // fallback to 1

    // Simpan data ke database
    $master = MasterPPN::create([
        'ppn' => $request->ppn,
        'pph' => $request->pph,
        'kurs_usd' => $kurs_usd,
        'kurs_euro' => $kurs_euro,
        'kurs_yuan' => $kurs_yuan,
        'kurs_rupiah' => $kurs_rupiah,
        'additional_cost' => $request->additional_cost,
    ]);

    // Logging activity
    activity()
        ->causedBy(Auth::user())
        ->performedOn($master)
        ->tap(fn ($activity) => $activity->id_user = Auth::id())
        ->withProperties($request->all())
        ->log('Menambahkan data Master PPN');

    // Redirect dengan pesan sukses
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
    $soapBody = <<<XML
<?xml version="1.0" encoding="utf-8"?>
<soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
               xmlns:xsd="http://www.w3.org/2001/XMLSchema"
               xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
  <soap:Body>
    <getSubKursAsing1 xmlns="http://www.bi.go.id/" />
  </soap:Body>
</soap:Envelope>
XML;

    $defaultRates = [
        'kurs_usd' => 16492.13,
        'kurs_euro' => 17141.92,
        'kurs_yuan' => 2264.03,
        'kurs_rupiah' => 1,
    ];

    try {
        $response = Http::withHeaders([
            'Content-Type' => 'text/xml; charset=utf-8',
            'SOAPAction' => 'http://www.bi.go.id/getSubKursAsing1',
        ])->timeout(10)->post('https://www.bi.go.id/biwebservice/wskursbi.asmx', $soapBody);

        if (!$response->successful()) {
            throw new \Exception('SOAP response failed with status: ' . $response->status());
        }

        $xml = simplexml_load_string($response->body());
        if (!$xml) {
            throw new \Exception('Gagal parsing XML dari BI');
        }

        $xml->registerXPathNamespace('soap', 'http://schemas.xmlsoap.org/soap/envelope/');
        $body = $xml->xpath('//soap:Body')[0] ?? null;
        if (!$body) {
            throw new \Exception('Elemen Body SOAP tidak ditemukan');
        }

        $json = json_encode($body);
        $array = json_decode($json, true);
        $kursList = $array['getSubKursAsing1Response']['getSubKursAsing1Result']['tabelKurs']['Kurs'] ?? [];

        $kurs_usd = $this->getKursByCode($kursList, 'USD') ?? $defaultRates['kurs_usd'];
        $kurs_euro = $this->getKursByCode($kursList, 'EUR') ?? $defaultRates['kurs_euro'];
        $kurs_yuan = $this->getKursByCode($kursList, 'CNY') ?? $defaultRates['kurs_yuan'];

        // Simpan ke session
        session([
            'kurs_usd' => $kurs_usd,
            'kurs_euro' => $kurs_euro,
            'kurs_yuan' => $kurs_yuan,
            'kurs_rupiah' => 1,
        ]);
    } catch (\Exception $e) {
        Log::error("Gagal mengambil kurs BI: " . $e->getMessage());

        // Simpan fallback default
        session($defaultRates);
    }
}


  private function getKursByCode($kursList, $code)
{
    foreach ($kursList as $kurs) {
        if (
            isset($kurs['KODE']) &&
            strtoupper($kurs['KODE']) === strtoupper($code) &&
            isset($kurs['beli'])
        ) {
            return (float) str_replace(',', '', $kurs['beli']);
        }
    }
    return null;
}
}
