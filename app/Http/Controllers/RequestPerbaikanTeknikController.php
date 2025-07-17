<?php

namespace App\Http\Controllers;

use App\Events\PerbaikanStatusUpdated;
use App\Helpers\BroadcastHelper;
use App\Helpers\NotificationHelper;
use App\Models\Aset;
use App\Models\Departemen;
use App\Models\LokasiRuangan;
use App\Models\RequestPerbaikanTeknik;
use App\Models\RequestPerbaikanTeknikDetail;
use App\Models\RequestPerbaikanTeknikSparepart;
use App\Models\RequestPerbaikanTeknikTindakan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Log;

class RequestPerbaikanTeknikController extends Controller
{
    // halaman requesr perbaikan untuk status null dan open
    public function index()
    {
        // Query untuk RequestPerbaikanTeknik dengan relasi Detail
        $data = RequestPerbaikanTeknik::with(['Detail' => function ($query) {
            $query->whereNull('status_perbaikan') // Filter status_perbaikan null
                ->orWhere('status_perbaikan', '=', 'Open'); // Atau status_perbaikan = 'Open'
        }])->where('jenis', 'Perbaikan')
            ->where('departemen_pemohon', '=', 'Research & Development')->get();

        // dd($data->toSql());

        // Log query yang dijalankan
        // /Log::info("Query Request Perbaikan: " . $query->toSql());

        // Eksekusi query
        // $data = $query->get();

        $title = 'Data Request Perbaikan Teknisi - Open';
        $type = 'Perbaikan';
        $subType = 'Open';

        return view('request-perbaikan.index', compact('data', 'title', 'type', 'subType'));
    }

    // halaman request perbaikan untuk status progress
    public function progress()
    {
        // Query untuk RequestPerbaikanTeknik dengan relasi Detail
        $data = RequestPerbaikanTeknik::with(['Detail' => function ($query) {
            $query->where('status_perbaikan', '=', 'Progress'); // Atau status_perbaikan = 'Open'
        }])->where('jenis', 'Perbaikan')
            ->where('departemen_pemohon', '=', 'Research & Development')->get();

        // /dd($data);

        $title = 'Data Request Perbaikan Teknisi - Progress';
        $type = 'Perbaikan';
        $subType = 'Progress';

        return view('request-perbaikan.index', compact('data', 'title', 'type', 'subType'));
    }

    // halaman request perbaikan untuk status close
    public function close()
    {
        // Query untuk RequestPerbaikanTeknik dengan relasi Detail
        $data = RequestPerbaikanTeknik::with(['Detail' => function ($query) {
            $query->where('status_perbaikan', '=', 'Close'); // Atau status_perbaikan = 'Open'
        }])->where('jenis', 'Perbaikan')
            ->where('departemen_pemohon', '=', 'Research & Development')->get();

        // /dd($data);

        $title = 'Data Request Perbaikan Teknisi - Close';
        $type = 'Perbaikan';
        $subType = 'Close';

        return view('request-perbaikan.index', compact('data', 'title', 'type', 'subType'));
    }

    public function create()
    {
        $departemens = Departemen::where('nama_departemen', '=', 'Research & Development')
            ->get();

        $ruangans = LokasiRuangan::all();

        $type = 'Perbaikan';

        return view('request-perbaikan.create', compact('departemens', 'ruangans', 'type'));
    }

    public function generateNoPerbaikan(Request $request)
    {
        $kodeDepartemen = urldecode($request->kodeDepartemen);
        $jenis = urldecode($request->jenisRequest);

        if (!$kodeDepartemen) {
            return response()->json(['error' => 'Kode Departemen tidak ditemukan'], 400);
        }

        try {
            // Dapatkan tahun saat ini
            $tahun = date('y'); // Ambil dua digit terakhir tahun

            // Cari nomor terakhir berdasarkan kode departemen dan tahun saat ini
            $lastPengajuan = DB::connection('engineering')->table('request_perbaikan_teknik')
                ->whereRaw("YEAR(created_at) = ?", [date('Y')]) // Filter berdasarkan tahun
                ->where('nomor_request_perbaikan', 'like', "%.$kodeDepartemen.%") // Filter berdasarkan kode departemen
                ->where('jenis', '=', $jenis)
                ->orderBy('created_at', 'desc')
                ->first();

            // Nomor urut baru
            $nomorUrut = 1;
            if ($lastPengajuan) {
                // Ekstrak nomor urut dari nomor_request_perbaikan terakhir
                $lastNo = explode('.', $lastPengajuan->nomor_request_perbaikan);

                // Pastikan indeks 4 (nomor urut) ada sebelum mengambil nilai
                if (isset($lastNo[4]) && is_numeric($lastNo[4])) {
                    $nomorUrut = (int) $lastNo[4] + 1;
                }
            }

            if ($jenis === 'Perbaikan') {
                // Gabungkan menjadi format nomor transaksi
                $noPerbaikan = "DJC.WO.$tahun.$kodeDepartemen." . str_pad($nomorUrut, 3, '0', STR_PAD_LEFT);
            } elseif ($jenis === 'Pemeliharaan') {
                $noPerbaikan = "DJC.PM.$tahun.$kodeDepartemen." . str_pad($nomorUrut, 3, '0', STR_PAD_LEFT);
            }

            return response()->json(['noPerbaikan' => $noPerbaikan]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500); // Tangani error
        }
    }

    private function generateNoPerbaikanInternal($kodeDepartemen, $jenis)
    {
        try {
            // Dapatkan tahun saat ini
            $tahun = date('y'); // Ambil dua digit terakhir tahun

            // Cari nomor terakhir berdasarkan kode departemen dan tahun saat ini
            $lastPengajuan = DB::connection('engineering')->table('request_perbaikan_teknik')
                ->whereRaw("YEAR(created_at) = ?", [date('Y')]) // Filter berdasarkan tahun
                ->where('nomor_request_perbaikan', 'like', "%.$kodeDepartemen.%") // Filter berdasarkan kode departemen
                ->where('jenis', '=', $jenis)
                ->orderBy('created_at', 'desc')
                ->first();

            // Nomor urut baru
            $nomorUrut = 1;
            if ($lastPengajuan) {
                // Ekstrak nomor urut dari nomor_request_perbaikan terakhir
                $lastNo = explode('.', $lastPengajuan->nomor_request_perbaikan);

                // Pastikan indeks 4 (nomor urut) ada sebelum mengambil nilai
                if (isset($lastNo[4]) && is_numeric($lastNo[4])) {
                    $nomorUrut = (int) $lastNo[4] + 1;
                }
            }

            if ($jenis === 'Perbaikan') {
                $no_perbaikan = "DJC.WO.$tahun.$kodeDepartemen." . str_pad($nomorUrut, 3, '0', STR_PAD_LEFT);
            } elseif ($jenis === 'Pemeliharaan') {
                $no_perbaikan = "DJC.PM.$tahun.$kodeDepartemen." . str_pad($nomorUrut, 3, '0', STR_PAD_LEFT);
            }

            // Gabungkan menjadi format nomor transaksi
            return $no_perbaikan;
        } catch (\Exception $e) {
            throw new \Exception("Gagal membuat nomor perbaikan: " . $e->getMessage());
        }
    }


    public function search(Request $request)
    {
        // dd($request->all());

        $search = $request->input('search', '');
        $departemen = urldecode($request->input('departemen', ''));
        $ruangan = urldecode($request->input('ruangan', ''));

        // Query pencarian
        $data = Aset::with('kategoriAset')->where(function ($query) use ($search) {
            $query->where('nama_aset', 'like', "%{$search}%")
                ->orWhere('kode_aset', 'like', "%{$search}%");
        })
            //uncomment jika sudah banyak data atau diperlukan
            // ->where('departemen', '=', $departemen) // Filter berdasarkan departemen
            // ->where('lokasi_aset', '=', $ruangan)  // Filter berdasarkan ruangan
            ->get(); // Ambil satu data pertama yang cocok

        //dd($data);

        // Jika data tidak ditemukan, kembalikan respons error
        if ($data->isEmpty()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data tidak ditemukan untuk aset tersebut.',
            ], 404);
        }

        // Format hasil untuk di-return sebagai JSON
        $result = $data->map(function ($item) {
            return [
                'kode_aset' => $item->kode_aset,
                'nama_aset' => $item->nama_aset,
                'kategori_aset' => $item->kategori_aset,
                'nama_kategori_aset' => $item->kategoriAset->nama_kategori_aset,
            ];
        });

        return response()->json([
            'status' => 'success',
            'result' => $result,
        ]);
    }

    public function store(Request $request)
    {
        //dd($request->all());
        // Validasi awal
        $validatedData = $request->validate([
            'jenis_request' => 'required',
            'nomor_request_perbaikan' => 'required|string|unique:engineering.request_perbaikan_teknik,nomor_request_perbaikan',
            'tgl_permintaan' => 'required|date',
            'nama_pemohon' => 'required|string',
            'departemen_pemohon' => 'required|string',
            'lokasi_ruangan' => 'required|string',
            'pilih_perbaikan' => 'required|string|in:Aset,Bangunan',
        ]);

        if ($request->jenis_request === 'Pemeliharaan') {
            $validatedData = array_merge($validatedData, $request->validate([
                'periode' => 'required|in:1 Minggu,1 Bulan,3 Bulan,6 Bulan',
            ]));
        }

        // Tambahkan aturan validasi dinamis berdasarkan pilih_perbaikan
        if ($request->pilih_perbaikan === 'Aset') {
            $validatedData = array_merge($validatedData, $request->validate([
                'kode_aset' => 'array',
                'kode_aset.*' => 'nullable|string',
                'nama_aset' => 'array',
                'nama_aset.*' => 'nullable|string',
                'kategori_aset' => 'array',
                'kategori_aset.*' => 'required|string',
                'deskripsi_kerusakan' => 'array',
                'deskripsi_kerusakan.*' => 'required|string',
                'dokumentasi_kerusakan' => 'array',
                'dokumentasi_kerusakan.*' => 'array',
                'dokumentasi_kerusakan.*.*' => 'required|file|mimes:jpeg,jpg,png|max:2048',
            ]));
        } elseif ($request->pilih_perbaikan === 'Bangunan') {
            $validatedData = array_merge($validatedData, $request->validate([
                'deskripsi_kerusakan_bangunan' => 'required|string',
                'dokumentasi_kerusakan_bangunan' => 'required|array',
                'dokumentasi_kerusakan_bangunan.*' => 'required|file|mimes:jpeg,jpg,png|max:2048',
            ]));
        }

        // Pisahkan nomor pengajuan menjadi bagian-bagian (prefix, kode produk, nomor urut, bulan/tahun)
        $parts = explode('.', $validatedData['nomor_request_perbaikan']);
        if (count($parts) !== 5) {
            return back()->with('error', 'Format nomor pengajuan tidak valid.');
        }

        $prefix = $parts[0]; // DJC
        $prefixWo = $parts[1]; // WO
        $tahun = $parts[2]; // 25
        $kodeDepartemen = $parts[3]; // QA
        $nomorUrut = $parts[4]; // 003

        $jenis = '';
        if ($prefixWo === 'WO') {
            $jenis = 'Perbaikan';
        } elseif ($prefixWo === 'PM') {
            $jenis = 'Pemeliharaan';
        }

        // Periksa apakah nomor urut yang sama sudah ada di bulan/tahun yang sama
        $existingPengajuan = DB::connection('engineering')->table('request_perbaikan_teknik')
            ->where('nomor_request_perbaikan', $validatedData['nomor_request_perbaikan'])
            ->exists();

        if ($existingPengajuan) {
            // Jika nomor urut sudah ada, buat nomor pengajuan baru
            $noPerbaikan = $this->generateNoPerbaikanInternal($kodeDepartemen, $jenis);
        } else {
            // Jika tidak ada, gunakan nomor pengajuan dari request
            $noPerbaikan = $validatedData['nomor_request_perbaikan'];
        }


        try {
            DB::beginTransaction();
            // Simpan data ke tabel `request_perbaikan_teknik`
            $requestPerbaikanTeknik = RequestPerbaikanTeknik::create([
                'nomor_request_perbaikan' => $noPerbaikan,
                'jenis' => $validatedData['jenis_request'],
                'jenis_perbaikan' => $validatedData['pilih_perbaikan'],
                'tanggal' => $validatedData['tgl_permintaan'],
                'id_input' => $validatedData['nama_pemohon'],
                'departemen_pemohon' => $validatedData['departemen_pemohon'],
                'lokasi_ruangan' => $validatedData['lokasi_ruangan'],
                'periode' => $request->jenis_request === 'Pemeliharaan' ? $validatedData['periode'] : NULL,
            ]);

            if ($request->pilih_perbaikan === 'Aset') {
                // Simpan detail aset dan upload file
                try {
                    foreach ($request->kode_aset as $index => $kodeAset) {
                        try {
                            $uploadedPaths = [];
                            if (isset($request->dokumentasi_kerusakan[$index])) {
                                foreach ($request->dokumentasi_kerusakan[$index] as $file) {
                                    $filename = $kodeAset . '-' . time() . '-' . $file->getClientOriginalName();
                                    $filePath = 'uploads/dokumentasi_kerusakan/' . $filename;

                                    // Kompres gambar dengan Intervention Image
                                    $image = Image::make($file->getRealPath());
                                    if (!$image) {
                                        throw new \Exception('Gagal membuat instance image');
                                    }
                                    $image->resize(
                                        $image->width() / 2,
                                        $image->height() / 2,
                                        function ($constraint) {
                                            $constraint->aspectRatio();
                                        }
                                    )->encode('jpg', 50); // Kompres ke 50% kualitas

                                    // cek apakah berhasil encode
                                    if (!$image) {
                                        Log::debug('Gagal meng-encode image');
                                        throw new \Exception('Gagal meng-encode image');
                                    }
                                    $saveSuccess = Storage::disk('engineering')->put($filePath, $image->__toString());

                                    if (!$saveSuccess) {
                                        Log::debug('Gagal menyimpan gambar ke storage');
                                        throw new \Exception('Gagal menyimpan gambar ke storage');
                                    }

                                    $uploadedPaths[] = $filePath;
                                }
                            }

                            $detail = RequestPerbaikanTeknikDetail::create([
                                'request_perbaikan_id' => $requestPerbaikanTeknik->id,
                                'kode_aset' => $kodeAset,
                                'nama_aset' => $request->nama_aset[$index],
                                'kategori_aset' => $request->kategori_aset[$index],
                                'deskripsi_kerusakan' => $request->deskripsi_kerusakan[$index],
                                'dokumentasi_kerusakan' => json_encode($uploadedPaths),
                                'status_permohonan' => 'Not Confirmed',
                            ]);

                            if (!$detail) {
                                Log::debug('Gagal menyimpan detail perbaikan aset');
                                throw new \Exception("Gagal menyimpan detail perbaikan aset.");
                            }

                            $title = $validatedData['jenis_request'] === 'Perbaikan' ? 'permintaan perbaikan' : 'permintaan pemeliharaan';

                            $notif = NotificationHelper::saveToDepartment([
                                'sender_name' => $validatedData['nama_pemohon'],
                                'sender_departement' => $validatedData['departemen_pemohon'],
                                'receiver_name' => null,
                                'receiver_departement' => 'Engineering',
                                'for_role' => 'all',
                                'title' => ucwords($title),
                                'message' => ucfirst($title) . ' #' . $noPerbaikan . ' dari ' . $validatedData['departemen_pemohon'],
                                'url' => '/request_perbaikan/show?id=' .  $detail->id,
                                'is_read' => false
                            ], 'Engineering');

                            if (!$notif) {
                                throw new \Exception("Gagal menyimpan notif.");
                            }

                            //Log::info('Broadcast event PerbaikanApproved dikirim!');
                            if ($notif) {
                                BroadcastHelper::broadcastToDepartment(
                                    'Engineering',
                                    PerbaikanStatusUpdated::class,
                                    [
                                        'id' => $notif->id, // ambil dari DB
                                        'title' => $notif->title,
                                        'message' => $notif->message,
                                        'url' => $notif->url,
                                        'status' => 'Created',
                                        'step_label' => 'Permintaan telah dibuat oleh Tim Research & Development.',
                                    ]
                                );
                            }
                        } catch (\Exception $e) {
                            Log::debug("Gagal menyimpan detail aset index ke-$index: " . $e->getMessage());
                            throw new \Exception("Gagal menyimpan detail aset index ke-$index: " . $e->getMessage());
                        }
                    }
                } catch (\Exception $e) {
                    DB::rollBack();
                    Log::error('Kesalahan saat simpan detail: ' . $e->getMessage());
                    return back()->withErrors(['error' => 'Gagal menyimpan data detail: ' . $e->getMessage()])->withInput();
                }
            } elseif ($request->pilih_perbaikan === 'Bangunan') {
                try {
                    $uploadedPaths = [];

                    // Periksa apakah ada file yang diunggah
                    if ($request->hasFile('dokumentasi_kerusakan_bangunan')) {
                        foreach ($request->file('dokumentasi_kerusakan_bangunan') as $file) {
                            // Buat nama file unik
                            $filename = $validatedData['lokasi_ruangan'] . '-' . time() . '-' . $file->getClientOriginalName();
                            $filePath = 'uploads/dokumentasi_kerusakan/' . $filename;

                            // Kompres gambar dengan Intervention Image
                            $image = Image::make($file->getRealPath());
                            $image->resize(
                                $image->width() / 2,
                                $image->height() / 2,
                                function ($constraint) {
                                    $constraint->aspectRatio();
                                }
                            )->encode('jpg', 50); // Kompres ke 50% kualitas

                            // cek apakah berhasil encode
                            if (!$image) {
                                Log::debug('Gagal meng-encode image');
                                throw new \Exception('Gagal meng-encode image');
                            }
                            $saveSuccess = Storage::disk('engineering')->put($filePath, $image->__toString());

                            if (!$saveSuccess) {
                                Log::debug('Gagal menyimpan gambar ke storage');
                                throw new \Exception('Gagal menyimpan gambar ke storage');
                            }

                            $uploadedPaths[] = $filePath; // Simpan path file
                        }
                    }

                    // Simpan data ke tabel detail
                    $detail = RequestPerbaikanTeknikDetail::create([
                        'request_perbaikan_id' => $requestPerbaikanTeknik->id,
                        'deskripsi_kerusakan' => $request->deskripsi_kerusakan_bangunan,
                        'dokumentasi_kerusakan' => json_encode($uploadedPaths), // Simpan sebagai JSON
                        'status_permohonan' => 'Not Confirmed',
                    ]);

                    if (!$detail) {
                        Log::debug('Gagal menyimpan detail perbaikan bangunan');
                        throw new \Exception("Gagal menyimpan detail perbaikan bangunan.");
                    }

                    $title = $validatedData['jenis_request'] === 'Perbaikan' ? 'permintaan perbaikan' : 'permintaan pemeliharaan';

                    $notif = NotificationHelper::saveToDepartment([
                        'sender_name' => $validatedData['nama_pemohon'],
                        'sender_departement' => $validatedData['departemen_pemohon'],
                        'receiver_name' => null,
                        'receiver_departement' => 'Engineering',
                        'for_role' => 'all',
                        'title' => ucwords($title),
                        'message' => ucfirst($title) . ' #' . $noPerbaikan . ' dari ' . $validatedData['departemen_pemohon'],
                        'url' => '/request_perbaikan/show?id=' .  $detail->id,
                        'is_read' => false
                    ], 'Engineering');

                    if (!$notif) {
                        throw new \Exception("Gagal menyimpan notif.");
                    }

                    //Log::info('Broadcast event PerbaikanApproved dikirim!');
                    if ($notif) {
                        BroadcastHelper::broadcastToDepartment(
                            'Engineering',
                            PerbaikanStatusUpdated::class,
                            [
                                'id' => $notif->id, // ambil dari DB
                                'title' => $notif->title,
                                'message' => $notif->message,
                                'url' => $notif->url,
                                'status' => 'Created',
                                'step_label' => 'Permintaan telah dibuat oleh Tim Research & Development.',
                            ]
                        );
                    }
                } catch (\Exception $e) {
                    Log::debug("Gagal menyimpan detail bangunan: " . $e->getMessage());
                    throw new \Exception("Gagal menyimpan detail bangunan: " . $e->getMessage());
                }
            }

            DB::commit();
            if ($request->jenis_request === 'Perbaikan') {
                return redirect()->route('request_perbaikan.index')->with('success', 'Data berhasil disimpan!');
            } else {
                return redirect()->route('request_pemeliharaan.index')->with('success', 'Data berhasil disimpan!');
            }
        } catch (\Exception $e) {
            DB::rollBack();

            // Log error untuk debugging
            Log::error('Gagal menyimpan data:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            // Redirect dengan pesan error
            return back()->withErrors(['error' => 'Gagal menyimpan data: ' . $e->getMessage()])->withInput();
        }
    }

    public function updateStatusApproval(Request $request)
    {
        //dd($request->all());
        $request->validate([
            'id_detail' => 'required|integer',
            'status_acc' => 'required|in:0,1',
            'nama_approval' => 'required',
        ]);

        $jenis = $this->determineJenis($request->nomor_request_perbaikan);

        try {
            DB::beginTransaction();

            $requestPerbaikan = RequestPerbaikanTeknikDetail::find($request->id_detail);
            if (!$requestPerbaikan) {
                throw new \Exception('Data tidak ditemukan.');
            }

            $updated = $requestPerbaikan->update([
                'status_permohonan' => 'Confirmed',
                'tanggal_confirmed' => now(),
                'approval_status' => $request->status_acc,
                'approval_by' => $request->nama_approval,
                'tanggal_approval' => now(),
                'status_perbaikan' => $request->status_acc == 1 ? 'Open' : null,
                'tanggal_open' => $request->status_acc == 1 ? now() : null,
            ]);

            $status = $request->status_acc == 1 ? 'Disetujui' : 'Ditolak';

            $notif = NotificationHelper::saveToDepartment([
                'sender_name' => $request->nama_approval,
                'sender_departement' => $request->departemen_pemohon,
                'receiver_name' => $request->nama_pemohon,
                'receiver_departement' => 'Engineering',
                'title' => 'Approval Pemeliharaan',
                'message' => 'Permintaan ' . $jenis . ' #' . $request->nomor_request_perbaikan . ' ' . $status . '.',
                'url' => '/request_perbaikan/show?id=' . $request->id_detail,
                'is_read' => false
            ], 'Engineering');

            if (!$notif) {
                throw new \Exception("Gagal menyimpan notif.");
            }

            //Log::info('Broadcast event PerbaikanApproved dikirim!');
            if ($notif) {
                BroadcastHelper::broadcastToDepartment(
                    'Engineering',
                    PerbaikanStatusUpdated::class,
                    [
                        'id' => $notif->id, // ambil dari DB
                        'title' => $notif->title,
                        'message' => $notif->message,
                        'url' => $notif->url,
                        'status' => 'Approval',
                        'step_label' => 'Permintaan pemeliharan telah di-approval oleh Tim Research & Development.',
                    ]
                );
            }

            DB::commit(); // Commit transaksi jika semua berhasil

            session()->flash('success', 'Status Approval berhasil diperbarui');

            if ($request->type === 'Perbaikan') {
                return redirect()->route('request_perbaikan.index');
            } else {
                return redirect()->route('request_pemeliharaan.index');
            }
        } catch (\Exception $e) {
            DB::rollback(); // Rollback jika ada error

            Log::error('Gagal update status approval: ' . $e->getMessage());
            session()->flash('error', 'Terjadi kesalahan saat memperbarui status approval.');
        }
    }

    public function show(Request $request)
    {
        $data = RequestPerbaikanTeknikDetail::with('Request')
            ->where('id', $request->id)
            ->whereHas('Request', function ($query) {
                $query->where('departemen_pemohon', '=', 'Research & Development');
            })
            ->first();

        if (!$data) {
            return response()->json(['error' => 'Data tidak ditemukan'], 400);
        }

        $dataTindakan = RequestPerbaikanTeknikTindakan::with('Sparepart', 'Sparepart.masterSparepart')
            ->where('request_perbaikan_detail_id', $request->id)
            ->first();

        //dd($data, $dataTindakan);

        return view('request-perbaikan.show', compact('data', 'dataTindakan'));
    }

    public function updateProgressToClose(Request $request)
    {
        $requestPerbaikan = RequestPerbaikanTeknikDetail::find($request->id_detail);
        //$user = auth()->user();
        $jenis = $this->determineJenis($request->nomor_request_perbaikan);

        try {
            DB::beginTransaction();

            $updated = $requestPerbaikan->update([
                'status_perbaikan' => 'Close',
                'tanggal_close' => now(),
                'updated_at' => now(),
                'close_by' => $request->closed_by,
            ]);

            $notif = NotificationHelper::saveToDepartment([
                'sender_name' => $request->closed_by,
                'sender_departement' => 'Engineering',
                'receiver_name' => $request->nama_pemohon,
                'receiver_departement' => $request->departemen_pemohon,
                'title' => 'Permintaan Ditutup',
                'message' => 'Permintaan ' . $jenis . ' #' . $request->nomor_request_perbaikan . ' telah ditutup oleh ' . $request->close_by . '.',
                'url' => '/request_perbaikan/show?id=' . $request->id_detail,
                'is_read' => false
            ], 'Engineering');

            if (!$notif) {
                throw new \Exception("Gagal menyimpan notif.");
            }

            //Log::info('Broadcast event PerbaikanApproved dikirim!');
            if ($notif) {
                BroadcastHelper::broadcastToDepartment(
                    'Engineering',
                    PerbaikanStatusUpdated::class,
                    [
                        'id' => $notif->id, // ambil dari DB
                        'title' => $notif->title,
                        'message' => $notif->message,
                        'url' => $notif->url,
                        'status' => 'Closed',
                        'step_label' => 'Permintaan telah ditutup oleh Tim Research & Development.',
                    ]
                );
            }

            if ($updated) {
                session()->flash('success', 'Status Approval berhasil diperbarui');
            } else {
                session()->flash('error', 'Gagal update status di tabel request_perbaikan_teknik_detail');
            }

            DB::commit();

            if ($request->type === 'Perbaikan') {
                return redirect()->route('request_perbaikan.close');
            } else {
                return redirect()->route('request_pemeliharaan.close');
            }
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Gagal update status progress: ' . $e->getMessage());
            session()->flash('error', 'Terjadi kesalahan saat memperbarui status progress.');
            return redirect()->back();
        }
    }

    public function print(Request $request)
    {
        $data = RequestPerbaikanTeknikDetail::with('Request')
            ->where('id', $request->id)
            ->first();

        $dataTindakan = RequestPerbaikanTeknikTindakan::with('Sparepart', 'Sparepart.masterSparepart')
            ->where('request_perbaikan_detail_id', $request->id)
            ->first();

        return view('request-perbaikan.print', compact('data', 'dataTindakan'));
    }

    public function destroy(Request $request)
    {
        $requestPerbaikan = RequestPerbaikanTeknikDetail::find($request->id);

        if ($requestPerbaikan) {
            $deleted = $requestPerbaikan->delete();

            if ($deleted) {
                session()->flash('success', 'Data berhasil dihapus.');
            } else {
                session()->flash('error', 'gagal menghapus data.');
            }

            if ($request->type === 'Perbaikan') {
                return redirect()->route('request_perbaikan.index');
            } else {
                return redirect()->route('request_pemeliharaan.index');
            }
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Data tidak ditemukan.'
        ], 404);
    }

    private function determineJenis($nomorRequestPerbaikan)
    {
        return substr($nomorRequestPerbaikan, 4, 2) === 'WO' ? 'Perbaikan' : 'Pemeliharaan';
    }
}
