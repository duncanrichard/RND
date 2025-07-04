<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class SampleProgressController extends Controller
{
    public function index()
{
    // Mengambil data sample dari database 'pr' dengan status_permohonan = 1
    $samples = DB::connection('pr')->table('request_order_samples')
                ->where('status_permohonan', 1)
                ->select(
                    'id',
                    'no_request_sample',
                    'tanggal',
                    'kode_customer',
                    'nama_customer',
                    'alamat_pengiriman_sample',
                    'nomor_telepon_pic'
                )
                ->get();

    // Mengambil jumlah progres untuk setiap sample berdasarkan id_request_order_samples
    $progressCounts = DB::connection('pr')->table('sample_progres')
                        ->select('id_request_order_samples', DB::raw('COUNT(*) as total_progress'))
                        ->groupBy('id_request_order_samples')
                        ->pluck('total_progress', 'id_request_order_samples');

    // Menentukan status berdasarkan apakah ada "Approved" di report_sample
    $statusList = DB::connection('pr')->table('sample_progres')
                    ->select('id_request_order_samples', DB::raw('MAX(report_sample) as status'))
                    ->groupBy('id_request_order_samples')
                    ->pluck('status', 'id_request_order_samples');

    return view('sample_progress.index', compact('samples', 'progressCounts', 'statusList'));
}
public function notConfirm()
{
    $samples = DB::connection('pr')->table('request_order_samples')
                ->where('status_permohonan', 0)
                ->select(
                    'id', 'no_request_sample', 'tanggal', 'kode_customer',
                    'nama_customer', 'alamat_pengiriman_sample', 'nomor_telepon_pic'
                )
                ->get();

    $progressCounts = DB::connection('pr')->table('sample_progres')
                        ->select('id_request_order_samples', DB::raw('COUNT(*) as total_progress'))
                        ->groupBy('id_request_order_samples')
                        ->pluck('total_progress', 'id_request_order_samples');

    $statusList = DB::connection('pr')->table('sample_progres')
                    ->select('id_request_order_samples', DB::raw('MAX(report_sample) as status'))
                    ->groupBy('id_request_order_samples')
                    ->pluck('status', 'id_request_order_samples');

    return view('sample_progress.index', [
        'samples' => $samples,
        'progressCounts' => $progressCounts,
        'statusList' => $statusList,
        'title' => 'Not Confirm'
    ]);
}

public function confirm()
{
    $samples = DB::connection('pr')->table('request_order_samples')
                ->where('status_permohonan', 1)
                ->select(
                    'id', 'no_request_sample', 'tanggal', 'kode_customer',
                    'nama_customer', 'alamat_pengiriman_sample', 'nomor_telepon_pic'
                )
                ->get();

    $progressCounts = DB::connection('pr')->table('sample_progres')
                        ->select('id_request_order_samples', DB::raw('COUNT(*) as total_progress'))
                        ->groupBy('id_request_order_samples')
                        ->pluck('total_progress', 'id_request_order_samples');

    $statusList = DB::connection('pr')->table('sample_progres')
                    ->select('id_request_order_samples', DB::raw('MAX(report_sample) as status'))
                    ->groupBy('id_request_order_samples')
                    ->pluck('status', 'id_request_order_samples');

    return view('sample_progress.index', [
        'samples' => $samples,
        'progressCounts' => $progressCounts,
        'statusList' => $statusList,
        'title' => 'Confirm'
    ]);
}

    
public function show($id)
{
    // Mengambil data sample
    $sample = DB::connection('pr')->table('request_order_samples')
                ->where('id', $id)
                ->select(
                    'id',
                    'no_request_sample',
                    'tanggal',
                    'kode_customer',
                    'nama_customer',
                    'alamat_pengiriman_sample',
                    'nomor_telepon_pic',
                    'alamat_email',
                    'nomor_master_formula_sample',
                    'kode_sample',
                    'nama_sample',
                    'bahan_aktif'
                )
                ->first();

    if (!$sample) {
        abort(404, 'Data tidak ditemukan');
    }

    // Ambil data progres yang sudah ada
    $progress = DB::connection('pr')->table('sample_progres')
                ->where('id_request_order_samples', $id)
                ->orderBy('id')
                ->get();

    // Cek apakah ada progres yang "Approved"
    $hasApproved = $progress->contains(function ($progress) {
        return $progress->report_sample == 1;
    });

    return view('sample_progress.show', compact('sample', 'progress', 'hasApproved'));
}

    
public function store(Request $request)
{
    $validatedData = $request->validate([
        'id_request_order_samples' => 'required',
    ]);

    foreach(range(1, 3) as $progress) {
        $tanggal = $request->input("tanggal_penyerahan_$progress");

        if ($tanggal) {
            // Cek apakah data progres ke-n ini sudah ada (berdasarkan tanggal & id)
            $existing = DB::connection('pr')->table('sample_progres')
                ->where('id_request_order_samples', $request->id_request_order_samples)
                ->whereDate('tanggal_penyerahan', $tanggal)
                ->first();

            if (!$existing) {
                // Insert hanya jika belum ada
                DB::connection('pr')->table('sample_progres')->insert([
                    'id_request_order_samples' => $request->id_request_order_samples,
                    'tanggal_penyerahan' => $tanggal,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }

    return redirect()->route('sample-progress.index')->with('success', 'Progres berhasil disimpan.');
}

    public function checkProgress($id)
    {
        $progress = DB::connection('pr')->table('sample_progres')
                          ->where('id_request_order_samples', $id)
                          ->orderBy('id')
                          ->get();
    
        return response()->json([
            'progress_data' => $progress
        ]);
    }
    
    public function confirmSample($id)
    {
        $updated = DB::connection('pr')->table('request_order_samples')
            ->where('id', $id)
            ->update(['status_permohonan' => 1]);
    
        if ($updated) {
            return response()->json(['success' => true]);
        }
    
        return response()->json(['success' => false], 500);
    }
    
    public function print($id)
    {
        $sample = DB::connection('pr')->table('request_order_samples')
            ->where('id', $id)
            ->first();
    
        if (!$sample) {
            abort(404, 'Data tidak ditemukan');
        }
    
        $progress = DB::connection('pr')->table('sample_progres')
            ->where('id_request_order_samples', $id)
            ->orderBy('id')
            ->get();
    
        $pdf = Pdf::loadView('sample_progress.print', compact('sample', 'progress'));
        return $pdf->stream("Sample_Progress_{$sample->no_request_sample}.pdf");
    }
}