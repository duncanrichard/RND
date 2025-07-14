<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class ExchangeRateController extends Controller
{
    public function getLatestRates()
    {
        $rates = $this->updateExchangeRates();

        return response()->json([
            'kurs_usd' => $rates['kurs_usd'],
            'kurs_euro' => $rates['kurs_euro'],
            'kurs_yuan' => $rates['kurs_yuan'],
        ]);
    }

    private function updateExchangeRates()
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
        ];

        try {
            $response = Http::withHeaders([
                'Content-Type' => 'text/xml; charset=utf-8',
                'SOAPAction' => 'http://www.bi.go.id/getSubKursAsing1',
            ])->timeout(10)->post('https://www.bi.go.id/biwebservice/wskursbi.asmx', $soapBody);

            if (!$response->successful()) {
                throw new \Exception('Response gagal: ' . $response->status());
            }

            $xml = simplexml_load_string($response->body());
            if (!$xml) {
                throw new \Exception('Gagal parsing XML');
            }

            $xml->registerXPathNamespace('soap', 'http://schemas.xmlsoap.org/soap/envelope/');
            $body = $xml->xpath('//soap:Body')[0] ?? null;
            if (!$body) {
                throw new \Exception('XPath body tidak ditemukan');
            }

            $json = json_encode($body);
            $array = json_decode($json, true);

            $kursList = $array['getSubKursAsing1Response']['getSubKursAsing1Result']['tabelKurs']['Kurs'] ?? [];

            $rates = [
                'kurs_usd' => $this->getKursByCode($kursList, 'USD') ?? $defaultRates['kurs_usd'],
                'kurs_euro' => $this->getKursByCode($kursList, 'EUR') ?? $defaultRates['kurs_euro'],
                'kurs_yuan' => $this->getKursByCode($kursList, 'CNY') ?? $defaultRates['kurs_yuan'],
            ];

            session($rates);
            return $rates;

        } catch (\Exception $e) {
            Log::error('Gagal mengambil kurs dari BI: ' . $e->getMessage());
            session($defaultRates);
            return $defaultRates;
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
