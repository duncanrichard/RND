<?php

namespace App\Http\Controllers;

use App\Models\RequestPerbaikanTeknik;
use Illuminate\Http\Request;

class RequestPemeliharaanTeknikController extends Controller
{
    // halaman requesr perbaikan untuk status null dan open
    public function index()
    {
        // Query untuk RequestPerbaikanTeknik dengan relasi Detail
        $data = RequestPerbaikanTeknik::with(['Detail' => function ($query) {
            $query->whereNull('status_perbaikan') // Filter status_perbaikan null
                ->orWhere('status_perbaikan', '=', 'Open'); // Atau status_perbaikan = 'Open'
        }])->where('jenis', 'Pemeliharaan')
            ->where('departemen_pemohon', '=', 'Research & Development')->get();

        //dd($query->toSql());

        // Log query yang dijalankan
        // /Log::info("Query Request Perbaikan: " . $query->toSql());

        // Eksekusi query
        // $data = $query->get();

        $title = 'Data Request Pemeliharaan Teknisi - Open';
        $type = 'Pemeliharaan';
        $subType = 'Open';

        return view('request-perbaikan.index', compact('data', 'title', 'type', 'subType'));
    }

    // halaman request perbaikan untuk status progress
    public function progress()
    {
        // Query untuk RequestPerbaikanTeknik dengan relasi Detail
        $data = RequestPerbaikanTeknik::with(['Detail' => function ($query) {
            $query->where('status_perbaikan', '=', 'Progress'); // Atau status_perbaikan = 'Open'
        }])->where('jenis', 'Pemeliharaan')
            ->where('departemen_pemohon', '=', 'Research & Development')->get();

        // /dd($data);

        $title = 'Data Request Pemeliharaan Teknisi - Progress';
        $type = 'Pemeliharaan';
        $subType = 'Progress';

        return view('request-perbaikan.index', compact('data', 'title', 'type', 'subType'));
    }

    // halaman request perbaikan untuk status close
    public function close()
    {
        // Query untuk RequestPerbaikanTeknik dengan relasi Detail
        $data = RequestPerbaikanTeknik::with(['Detail' => function ($query) {
            $query->where('status_perbaikan', '=', 'Close'); // Atau status_perbaikan = 'Open'
        }])->where('jenis', 'Pemeliharaan')
            ->where('departemen_pemohon', '=', 'Research & Development')->get();

        // /dd($data);

        $title = 'Data Request Pemeliharaan Teknisi - Close';
        $type = 'Pemeliharaan';
        $subType = 'Close';

        return view('request-perbaikan.index', compact('data', 'title', 'type', 'subType'));
    }
}
