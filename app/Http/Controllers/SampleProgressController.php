<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class SampleProgressController extends Controller
{
    public function index()
    {
        Log::info('Akses halaman sample progress - confirm');
        activity()
            ->causedBy(Auth::user())
            ->tap(fn ($activity) => $activity->id_user = Auth::id())
            ->log('Mengakses halaman sample progress: confirm');

        $samples = DB::connection('pr')->table('request_order_samples')
            ->where('status_permohonan', 1)
            ->select('id', 'no_request_sample', 'tanggal', 'kode_customer', 'nama_customer', 'alamat_pengiriman_sample', 'nomor_telepon_pic')
            ->get();

        $progressCounts = DB::connection('pr')->table('sample_progres')
            ->select('id_request_order_samples', DB::raw('COUNT(*) as total_progress'))
            ->groupBy('id_request_order_samples')
            ->pluck('total_progress', 'id_request_order_samples');

        $statusList = DB::connection('pr')->table('sample_progres')
            ->select('id_request_order_samples', DB::raw('MAX(report_sample) as status'))
            ->groupBy('id_request_order_samples')
            ->pluck('status', 'id_request_order_samples');

        return view('sample_progress.index', compact('samples', 'progressCounts', 'statusList'));
    }

    public function notConfirm()
    {
        Log::info('Akses halaman sample progress - not confirm');
        activity()
            ->causedBy(Auth::user())
            ->tap(fn ($activity) => $activity->id_user = Auth::id())
            ->log('Mengakses halaman sample progress: not confirm');

        $samples = DB::connection('pr')->table('request_order_samples')
            ->where('status_permohonan', 0)
            ->select('id', 'no_request_sample', 'tanggal', 'kode_customer', 'nama_customer', 'alamat_pengiriman_sample', 'nomor_telepon_pic')
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
        Log::info('Akses halaman sample progress - confirm ulang');
        activity()
            ->causedBy(Auth::user())
            ->tap(fn ($activity) => $activity->id_user = Auth::id())
            ->log('Mengakses ulang halaman sample progress: confirm');

        $samples = DB::connection('pr')->table('request_order_samples')
            ->where('status_permohonan', 1)
            ->select('id', 'no_request_sample', 'tanggal', 'kode_customer', 'nama_customer', 'alamat_pengiriman_sample', 'nomor_telepon_pic')
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
        Log::info("Menampilkan detail sample dengan ID: $id");
        activity()
            ->causedBy(Auth::user())
            ->tap(fn ($activity) => $activity->id_user = Auth::id())
            ->log("Menampilkan detail sample ID: $id");

        $sample = DB::connection('pr')->table('request_order_samples')
            ->where('id', $id)
            ->first();

        if (!$sample) {
            Log::warning("Sample tidak ditemukan untuk ID: $id");
            abort(404, 'Data tidak ditemukan');
        }

        $progress = DB::connection('pr')->table('sample_progres')
            ->where('id_request_order_samples', $id)
            ->orderBy('id')
            ->get();

        $hasApproved = $progress->contains(fn ($p) => $p->report_sample == 1);

        return view('sample_progress.show', compact('sample', 'progress', 'hasApproved'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_request_order_samples' => 'required',
        ]);

        $inserted = 0;

        foreach (range(1, 3) as $progress) {
            $tanggal = $request->input("tanggal_penyerahan_$progress");

            if ($tanggal) {
                $exists = DB::connection('pr')->table('sample_progres')
                    ->where('id_request_order_samples', $request->id_request_order_samples)
                    ->whereDate('tanggal_penyerahan', $tanggal)
                    ->exists();

                if (!$exists) {
                    DB::connection('pr')->table('sample_progres')->insert([
                        'id_request_order_samples' => $request->id_request_order_samples,
                        'tanggal_penyerahan' => $tanggal,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                    $inserted++;
                }
            }
        }

        Log::info("Menambahkan $inserted progres untuk sample ID: {$request->id_request_order_samples}");
        activity()
            ->causedBy(Auth::user())
            ->tap(fn ($activity) => $activity->id_user = Auth::id())
            ->log("Menyimpan progres untuk sample ID: {$request->id_request_order_samples}");

        return redirect()->route('sample-progress.index')->with('success', 'Progres berhasil disimpan.');
    }

    public function checkProgress($id)
    {
        Log::info("Memeriksa progres sample ID: $id");
        $progress = DB::connection('pr')->table('sample_progres')
            ->where('id_request_order_samples', $id)
            ->orderBy('id')
            ->get();

        return response()->json(['progress_data' => $progress]);
    }

    public function confirmSample($id)
    {
        $updated = DB::connection('pr')->table('request_order_samples')
            ->where('id', $id)
            ->update(['status_permohonan' => 1]);

        if ($updated) {
            Log::info("Sample dengan ID $id dikonfirmasi");
            activity()
                ->causedBy(Auth::user())
                ->tap(fn ($activity) => $activity->id_user = Auth::id())
                ->log("Mengonfirmasi sample ID: $id");

            return response()->json(['success' => true]);
        }

        Log::warning("Gagal mengonfirmasi sample ID: $id");
        return response()->json(['success' => false], 500);
    }

    public function print($id)
    {
        $sample = DB::connection('pr')->table('request_order_samples')->where('id', $id)->first();

        if (!$sample) {
            Log::error("Gagal mencetak PDF - sample ID $id tidak ditemukan");
            abort(404, 'Data tidak ditemukan');
        }

        $progress = DB::connection('pr')->table('sample_progres')
            ->where('id_request_order_samples', $id)
            ->orderBy('id')
            ->get();

        Log::info("Mencetak PDF untuk sample ID: $id");
        activity()
            ->causedBy(Auth::user())
            ->tap(fn ($activity) => $activity->id_user = Auth::id())
            ->log("Mencetak laporan progres sample ID: $id");

        $pdf = Pdf::loadView('sample_progress.print', compact('sample', 'progress'));
        return $pdf->stream("Sample_Progress_{$sample->no_request_sample}.pdf");
    }
}
