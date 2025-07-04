@extends('layout.main')

@section('content')
<div class="w-full px-6 py-6 mx-auto mt-10">
    <div class="bg-white shadow-lg rounded-xl p-8 border border-gray-300 max-w-5xl mx-auto px-6 md:px-10 lg:px-16">
        <h2 class="text-3xl font-bold text-gray-800 mb-6 text-center border-b pb-4 uppercase tracking-wide">Detail Sample Progress</h2>

        <!-- Informasi Utama -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mx-4 md:mx-10 lg:mx-20">
            @foreach([
                'No Request Sample' => $sample->no_request_sample,
                'Tanggal' => $sample->tanggal,
                'Kode Customer' => $sample->kode_customer,
                'Nama Customer' => $sample->nama_customer,
                'Nomor Telepon PIC' => $sample->nomor_telepon_pic,
                'Alamat Email' => $sample->alamat_email,
                'Nomor Master Formula Sample' => $sample->nomor_master_formula_sample,
                'Kode Sample' => $sample->kode_sample, 
                'Nama Sample' => $sample->nama_sample,
                'Bahan Aktif' => $sample->bahan_aktif
            ] as $label => $value)
            <div class="bg-gray-50 p-6 rounded-lg shadow-md border border-gray-300 hover:shadow-lg transition">
                <p class="font-semibold text-gray-700 uppercase text-sm">{{ $label }}:</p>
                <p class="text-gray-900 font-medium text-lg">{{ $value }}</p>
            </div>
            @endforeach

            <!-- Alamat Pengiriman Sample -->
            <div class="col-span-1 md:col-span-2 bg-blue-50 p-6 rounded-lg shadow-md border border-blue-300 hover:shadow-lg transition">
                <p class="font-semibold text-blue-700 uppercase text-sm">Alamat Pengiriman Sample:</p>
                <p class="text-blue-900 font-medium text-lg">{{ $sample->alamat_pengiriman_sample }}</p>
            </div>
        </div>

        <!-- Form Progres Sample -->
        <div class="mt-10 mx-4 md:mx-10 lg:mx-20">
            <h3 class="text-2xl font-bold text-gray-800 mb-4 text-center uppercase tracking-wide">Progres Sample</h3>

            <form action="{{ route('sample-progress.store') }}" method="POST">
                @csrf
                <input type="hidden" name="id_request_order_samples" value="{{ $sample->id }}">

                @foreach(range(1, 3) as $progress)
                <div class="progress-section bg-white p-6 rounded-lg border border-gray-300 shadow-md hover:shadow-lg transition mb-6" 
                     id="progress_{{ $progress }}" 
                     style="display: none;">
                    <h4 class="text-xl font-bold text-gray-700 mb-3">Progres {{ $progress }}</h4>

                    <div class="grid grid-cols-2 gap-6">
                        <div class="mb-4">
                            <label class="block text-gray-700 font-semibold mb-2">Tanggal Penyerahan Sample {{ $progress }} Ke PR:</label>
                            <input type="date" name="tanggal_penyerahan_{{ $progress }}" 
                                   class="w-full px-3 py-2 border rounded-lg bg-gray-50 focus:ring-2 focus:ring-blue-400 transition">
                        </div>

                        <div class="mb-4 col-span-2">
                            <label class="block text-gray-700 font-semibold mb-2">Report Sample {{ $progress }}:</label>
                            <textarea name="report_sample_{{ $progress }}" 
                                      class="w-full px-3 py-2 border rounded-lg bg-gray-50 focus:ring-2 focus:ring-blue-400 transition" 
                                      readonly placeholder="Report Menunggu PR"></textarea>
                        </div>

                        <div class="mb-4 col-span-2">
                            <label class="block text-gray-700 font-semibold mb-2">Keterangan Sample {{ $progress }}:</label>
                            <textarea name="keterangan_sample_{{ $progress }}" 
                                      class="w-full px-3 py-2 border rounded-lg bg-gray-50 focus:ring-2 focus:ring-blue-400 transition" 
                                      readonly placeholder="Keterangan Menunggu PR"></textarea>
                        </div>
                    </div>
                </div>
                @endforeach
                <a href="{{ route('sample-progress.print', $sample->id) }}" target="_blank"
   class="w-full inline-block text-center font-bold px-4 py-2 mt-4 text-white rounded-lg"
   style="background-color: #4CAF50;">
   Cetak PDF
</a>

                <button type="submit" id="submit-button" class="w-full font-bold px-4 py-2 text-white rounded-lg" style="background-color: #032859;">Simpan</button>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        fetch("{{ route('sample-progress.check', $sample->id) }}")
            .then(response => response.json())
            .then(data => {
                let progressData = data.progress_data;
                let hasApproved = false;
                let nextProgress = 1;

                progressData.forEach((progress, index) => {
                    let progressNum = index + 1;

                    // Tampilkan history progres yang ada
                    document.getElementById("progress_" + progressNum).style.display = "block";

                    // Isi field dengan data dari database
                    document.querySelector("input[name='tanggal_penyerahan_" + progressNum + "']").value = progress.tanggal_penyerahan;
                    let reportSampleField = document.querySelector("textarea[name='report_sample_" + progressNum + "']");
                    reportSampleField.value = progress.report_sample == 1 ? 'Approved' : 'Not Approved';

                    document.querySelector("textarea[name='keterangan_sample_" + progressNum + "']").value = progress.keterangan_sample;

                    // Jadikan readonly untuk history
                    document.querySelector("input[name='tanggal_penyerahan_" + progressNum + "']").readOnly = true;
                    reportSampleField.readOnly = true;
                    document.querySelector("textarea[name='keterangan_sample_" + progressNum + "']").readOnly = true;

                    // Jika ada yang Approved, jangan tampilkan progres selanjutnya
                    if (progress.report_sample == 1) {
                        hasApproved = true;
                    } else {
                        nextProgress = progressNum + 1;
                    }
                });

                // Tampilkan progres selanjutnya jika belum ada Approved
                if (!hasApproved && document.getElementById("progress_" + nextProgress)) {
                    document.getElementById("progress_" + nextProgress).style.display = "block";
                }

                // Sembunyikan tombol submit jika sudah ada Approved
                if (hasApproved) {
                    document.getElementById("submit-button").style.display = "none";
                }
            });
    });
</script>

@endsection
