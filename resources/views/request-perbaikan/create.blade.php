@extends('layout.main')

@section('title', 'Detail Pengajuan Pemeriksaan Bahan Baku')

@section('content')
<div class="flex flex-wrap -mx-3">
    <div class="w-full max-w-full px-3 flex-0">
        <div class="flex flex-wrap px-4 -mx-3">
            <div class="w-full max-w-full p-6 mx-auto my-6 bg-white dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl flex-0 lg:w-12/12">
                <h2 id="title_content" class="text-2xl font-bold mb-4">Tambah Request Perbaikan Teknik</h2>

                <form action="{{ route('request_perbaikan.store') }}" method="post" id="addForm" enctype="multipart/form-data">
                    @csrf
                    <!-- Informasi Pengajuan -->
                    <div class="w-full max-w-full px-3 flex items-center mb-2">
                        <label for="jenis_request" class="block text-gray-700 font-medium md:w-2/12">Jenis Request:</label>
                        <div class="flex space-x-6">
                            <label class="flex items-center space-x-2">
                                <input type="radio" name="jenis_request" value="Perbaikan" id="jenis_request_perbaikan"
                                    class="radio-btn focus:ring focus:ring-blue-300" {{ $type === 'Perbaikan' ? 'checked' : '' }}>
                                <span class="text-sm font-medium text-gray-700 pl-2">Perbaikan</span>
                            </label>
                            <label class="flex items-center space-x-2 pl-4">
                                <input type="radio" name="jenis_request" value="Pemeliharaan" id="jenis_request_pemeliharaan"
                                    class="radio-btn focus:ring focus:ring-blue-300" {{ $type === 'Pemeliharaan' ? 'checked' : '' }}>
                                <span class="text-sm font-medium text-gray-700 pl-2">Pemeliharaan</span>
                            </label>
                        </div>
                    </div>
                    <div class="w-full max-w-full px-3 flex-0">
                        <label for="nomor_request_perbaikan" class="block text-gray-700 font-medium">Nomor Request:</label>
                        <input type="text" id="nomor_request_perbaikan" name="nomor_request_perbaikan" class="focus:shadow-primary-outline text-sm leading-5.6 ease block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-gray-500 bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-blue-500 focus:outline-none mb-2" value="" readonly>
                        <span id="error_message_nomor_request_perbaikan" class="error-message text-red-500 text-sm"></span>
                    </div>
                    <div class="w-full max-w-full px-3 flex-0">
                        <label for="tgl_permintaan" class="block text-gray-700 font-medium">Tanggal:</label>
                        <input type="text" id="tgl_permintaan" class="focus:shadow-primary-outline text-sm leading-5.6 ease block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-gray-500 bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-blue-500 focus:outline-none mb-2" name="tgl_permintaan" value="{{ date('Y-m-d') }}" readonly>
                    </div>
                    <div class="w-full max-w-full px-3 flex-0">
                        <label for="nama_pemohon" class="block text-gray-700 font-medium">ID Input:</label>
                        <input type="text" class="focus:shadow-primary-outline text-sm leading-5.6 ease block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-gray-500 bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-blue-500 focus:outline-none mb-2" id="nama_pemohon" name="nama_pemohon" placeholder="Masukkan User" value="{{ Auth::user()->username }}" readonly>
                    </div>
                    <div class="w-full max-w-full px-3 flex-0 mt-2">
                        <label id="label_departemen" for="departemen_pemohon" class="block text-gray-700 font-medium">Departemen Pemohon:</label>
                        <select id="kode_departemen" name="kode_departemen" class="focus:shadow-primary-outline text-sm leading-5.6 ease block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-blue-500 focus:outline-none mb-2 hidden">
                            <option value="">Pilih Kode Departemen</option>
                            @foreach ($departemens as $departemen)
                            <option value="{{ $departemen->kode_departemen }}" {{ stripos($departemen->kode_departemen, 'RD') !== false ? 'selected' : '' }}>{{ $departemen->kode_departemen }}</option>
                            @endforeach
                        </select>
                        <select id="departemen_pemohon" name="departemen_pemohon" class="focus:shadow-primary-outline text-sm leading-5.6 ease block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-blue-500 focus:outline-none mb-2" style="height: auto;">
                            <option value="">Pilih Departemen</option>
                            @foreach ($departemens as $departemen)
                            <option value="{{ $departemen->nama_departemen }}" {{ stripos($departemen->nama_departemen, 'Research & Development') !== false ? 'selected' : '' }}>{{ $departemen->nama_departemen }}</option>
                            @endforeach
                        </select>
                        <span id="error_message_departemen_pemohon" class="error-message text-red-500 text-sm"></span>
                    </div>

                    <div class="w-full max-w-full px-3 flex-0 mt-2">
                        <label for="lokasi_ruangan" class="block text-gray-700 font-medium">Lokasi / Ruangan:</label>
                        <select id="kode_lokasi" name="kode_lokasi" class="focus:shadow-primary-outline text-sm leading-5.6 ease block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-blue-500 focus:outline-none mb-2 hidden">
                            <option value="">Pilih Kode ruangan</option>
                            @foreach ($ruangans as $ruangan)
                            <option value="{{ $ruangan->kode_ruangan }}">{{ $ruangan->kode_ruangan }}</option>
                            @endforeach
                        </select>
                        <select id="lokasi_ruangan" name="lokasi_ruangan" class="focus:shadow-primary-outline text-sm leading-5.6 ease block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-blue-500 focus:outline-none mb-2" style="height: auto;">
                            <option value="">Pilih Lokasi/Ruangan</option>
                            @foreach ($ruangans as $ruangan)
                            <option value="{{ $ruangan->nama_ruangan }}">{{ $ruangan->nama_ruangan }}</option>
                            @endforeach
                        </select>
                        <span id="error_message_lokasi_ruangan" class="error-message text-red-500 text-sm"></span>
                    </div>

                    <div class="w-full max-w-full px-3 flex-0 mt-2" id="div_periode">
                        <label for="periode" class="block text-gray-700 font-medium">Periode:</label>
                        <select id="periode" name="periode" class="focus:shadow-primary-outline text-sm leading-5.6 ease block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-blue-500 focus:outline-none mb-2" style="height: auto;">
                            <option value="">Pilih Periode</option>
                            <option value="1 Minggu">1 Minggu</option>
                            <option value="1 Bulan">1 Bulan</option>
                            <option value="3 Bulan">3 Bulan</option>
                            <option value="6 Bulan">6 Bulan</option>
                        </select>
                        <span id="error_message_periode" class="error-message text-red-500 text-sm"></span>
                    </div>

                    <div class="w-full max-w-full px-3 flex items-center mt-2 mb-2">
                        <label for="pilih_perbaikan" class="block text-gray-700 font-medium md:w-2/12">Pilih Kategori:</label>
                        <div class="flex space-x-6">
                            <label class="flex items-center space-x-2">
                                <input type="radio" name="pilih_perbaikan" value="Aset" id="pilih_perbaikan_aset"
                                    class="radio-btn focus:ring focus:ring-blue-300">
                                <span class="text-sm font-medium text-gray-700 pl-2">Aset</span>
                            </label>
                            <label class="flex items-center space-x-2 pl-4">
                                <input type="radio" name="pilih_perbaikan" value="Bangunan" id="pilih_perbaikan_bangunan"
                                    class="radio-btn focus:ring focus:ring-blue-300">
                                <span class="text-sm font-medium text-gray-700 pl-2">Bangunan</span>
                            </label>
                        </div>
                    </div>

                    <div class="w-full max-w-full px-3 flex-0 mb-2">
                        <span id="error_message_pilih_perbaikan" class="error-message text-red-500 text-sm"></span>
                    </div>

                    <div id="perbaikan_aset" class="hidden">
                        <!-- Form Pencarian Nomor SPK -->
                        <div class="w-full max-w-full px-3 flex-0 mt-2">
                            <label for="input_aset_search" class="block text-gray-700 font-medium">Cari Aset</label>
                            <div class="flex items-center gap-4">
                                <input type="text" class="focus:shadow-primary-outline text-sm leading-5.6 ease block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-blue-500 focus:outline-none" id="input_aset_search" name="input_aset_search" placeholder="Masukkan Aset">
                                <div class="px-1">

                                </div>
                                <button type="button" id="search_button" class="inline-block px-6 py-3 font-bold text-center bg-gradient-to-tl from-blue-500 to-violet-500 uppercase align-middle transition-all rounded-lg cursor-pointer leading-normal text-xs ease-in tracking-tight-rem shadow-xs bg-150 bg-x-25 hover:-translate-y-px active:opacity-85 hover:shadow-md text-white">Cari</button>
                            </div>
                        </div>
                        <br>
                        <!-- Tabel Hasil Pencarian Nomor SPK -->
                        <div class="w-full max-w-full px-3 flex-0">
                            <div class="overflow-x-auto mb-2">
                                <div class="overflow-y-auto max-h-64">
                                    <table id="search-_table" class="w-full bg-white border border-gray-300 rounded-lg">
                                        <thead class="bg-gray-200 text-gray-700">
                                            <tr>
                                                <th class="py-2 px-4 text-left border-b">Kode Aset</th>
                                                <th class="py-2 px-4 text-left border-b">Nama Aset</th>
                                                <th class="py-2 px-4 text-left border-b">Kategori Aset</th>
                                            </tr>
                                        </thead>
                                        <tbody id="search_results">
                                            <tr>
                                                <td colspan="5" class="py-4 px-6 text-center text-gray-500">Silakan cari aset terlebih dahulu...</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Detail Barang -->
                        <div class="w-full max-w-full px-3 flex-0">
                            <h3 id="label_detail" class="text-lg font-bold mt-6">Detail Perbaikan Aset</h3>
                            <div class="overflow-x-auto">
                                <div class="overflow-y-auto max-h-64">
                                    <table id="details" class="table-auto w-full bg-white border border-gray-300 rounded-lg">
                                        <thead>
                                            <tr class="bg-gray-200 text-gray-700">
                                                <th class="border-b px-4 py-2">No</th>
                                                <th class="border-b px-4 py-2">Kode Aset</th>
                                                <th class="border-b px-4 py-2">Nama Aset</th>
                                                <th class="border-b px-4 py-2">Kategori Aset</th>
                                                <th id="label_deskripsi_kerusakan" class="border-b px-4 py-2">Deskripsi Kerusakan</th>
                                                <th id="label_dokumentasi_kerusakan" class="border-b px-4 py-2">Dokumentasi Kerusakan</th>
                                                <th class="border-b px-4 py-2">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody id="details_tbody">
                                            <tr>
                                                <td colspan="7" class="py-4 px-6 text-center text-gray-500">Tidak ada data</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="perbaikan_bangunan" class="hidden">
                        <div class="w-full max-w-full px-3 flex-0">
                            <div class="mb-2">
                                <label for="deskripsi_kerusakan_bangunan" id="label_deskripsi_kerusakan_bangunan" class="block text-gray-700 font-medium">Deskripsi Kerusakan:</label>
                                <textarea name="deskripsi_kerusakan_bangunan" id="deskripsi_kerusakan_bangunan" class="focus:shadow-primary-outline text-sm leading-5.6 ease block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-blue-500 focus:outline-none" style="text-align: justify;" rows="5" placeholder="Tuliskan detail tindakan sementara">{{ old('deskripsi_kerusakan_bangunan')}}</textarea>
                                <span id="error_message_deskripsi_kerusakan_bangunan" class="text-red-500 text-sm"></span>
                            </div>
                        </div>
                        <div class="w-full max-w-full px-3 flex-0">
                            <div class="mb-4">
                                <label for="dokumentasi_kerusakan_bangunan" id="label_dokumentasi_kerusakan_bangunan" class="block text-gray-700 font-medium">Dokumentasi Kerusakan:</label>
                                <input type="file" id="dokumentasi_kerusakan_bangunan" name="dokumentasi_kerusakan_bangunan[]" class="dokumentasi-input focus:shadow-primary-outline text-sm leading-5.6 ease block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-blue-500 focus:outline-none" multiple accept=".jpeg, .jpg, .png" value="{{ old('dokumentasi_kerusakan_bangunan') }}">
                                <span id="info_message_dokumentasi_kerusakan_bangunan" class="text-blue-500 text-xs">Maks Foto 2 MB</span><br>
                                <span id="error_message_dokumentasi_kerusakan_bangunan" class="text-red-500 text-sm"></span>
                            </div>
                        </div>
                    </div>
                    <div class="w-full px-1 py-6 mx-auto mt-10 flex justify-end">
                        <button type="submit" id="btnSubmit" name="btn_submit" class="px-4 py-2 font-bold bg-blue-500 text-white rounded-lg inline-flex items-right ml-auto">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        // Inisialisasi Select2 untuk departemen
        $('#departemen_pemohon').select2({
            placeholder: 'Pilih Departemen',
            allowClear: true,
        });

        // Sinkronisasi departemen_pemohon dan kode_gudang
        $('#departemen_pemohon').change(function() {
            const selectedIndex = $(this).prop('selectedIndex'); // Ambil indeks dropdown yang dipilih
            $('#kode_departemen').prop('selectedIndex', selectedIndex); // Setel dropdown kode_departemen ke indeks yang sama
            generateNoPerbaikan();
        });

        $('#kode_departemen').change(function() {
            const selectedIndex = $(this).prop('selectedIndex'); // Ambil indeks dropdown yang dipilih
            $('#departemen_pemohon').prop('selectedIndex', selectedIndex); // Setel dropdown departemen_pemohon ke indeks yang sama
            generateNoPerbaikan();
        });

        // Inisialisasi Select2 untuk ruangan
        $('#lokasi_ruangan').select2({
            placeholder: 'Pilih Lokasi Ruangan',
            allowClear: true,
        });

        // Sinkronisasi lokasi_ruangan dan kode_gudang
        $('#lokasi_ruangan').change(function() {
            const selectedIndex = $(this).prop('selectedIndex'); // Ambil indeks dropdown yang dipilih
            $('#kode_lokasi').prop('selectedIndex', selectedIndex); // Setel dropdown kode_lokasi ke indeks yang sama
            generateNoPerbaikan();
        });

        $('#kode_lokasi').change(function() {
            const selectedIndex = $(this).prop('selectedIndex'); // Ambil indeks dropdown yang dipilih
            $('#lokasi_ruangan').prop('selectedIndex', selectedIndex); // Setel dropdown departemen_pemohon ke indeks yang sama
            generateNoPerbaikan();
        });

        // Inisialisasi Select2 untuk departemen
        $('#periode').select2({
            placeholder: 'Pilih Periode',
            allowClear: true,
        });

        // Fungsi untuk generate No Pengajuan
        function generateNoPerbaikan() {
            const kodeDepartemen = $('#kode_departemen').val(); // Ambil nilai kode_departemen yang dipilih
            const jenisRequest = $('input[name="jenis_request"]:checked').val(); // Ambil nilai jenis_request yang dipilih
            const kodeDepartemenEncode = encodeURI(kodeDepartemen);
            const jenisRequestEncode = encodeURI(jenisRequest);

            if (kodeDepartemen) {
                $.ajax({
                    url: '{{ route("request_perbaikan.generateNomor") }}', // Route Laravel untuk memanggil fungsi controller
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}', // Token CSRF untuk keamanan
                        kodeDepartemen: kodeDepartemenEncode,
                        jenisRequest: jenisRequestEncode,
                    },
                    success: function(response) {
                        $('#nomor_request_perbaikan').val(response.noPerbaikan); // Tampilkan hasil pada input
                    },
                    error: function(xhr) {
                        console.error('Error:', xhr.responseText); // Debug jika ada error
                    }
                });
            } else {
                $('#nomor_request_perbaikan').val(''); // Kosongkan jika tidak ada kode gudang yang dipilih
            }
        }

        // Fungsi untuk mengatur visibilitas berdasarkan radio button yang dipilih
        function toggleJenisRequestSections() {
            if ($('#jenis_request_pemeliharaan').is(':checked')) {
                $('#div_periode').removeClass('hidden').show(); // Tampilkan div perbaikan aset
                $('#title_content').text('Tambah Request Pemeliharaan Teknik');
                $('#label_departemen').text('Departemen Tujuan');
                $('#label_detail').text('Detail Pemeliharaan Aset');
                $('#label_deskripsi_kerusakan').text('Deskripsi Pemeliharaan');
                $('#label_dokumentasi_kerusakan').text('Dokumentasi Pemeliharaan');
                $('#label_deskripsi_kerusakan_bangunan').text('Deskripsi Pemeliharaan');
                $('#label_dokumentasi_kerusakan_bangunan').text('Dokumentasi Pemeliharaan');
            } else if ($('#jenis_request_perbaikan').is(':checked')) {
                $('#div_periode').addClass('hidden').hide(); // Sembunyikan div perbaikan aset
                $('#title_content').text('Tambah Request Perbaikan Teknik');
                $('#label_departemen').text('Departemen Pemohon');
                $('#label_detail').text('Detail Perbaikan Aset');
                $('#label_deskripsi_kerusakan').text('Deskripsi Perbaikan');
                $('#label_dokumentasi_kerusakan').text('Dokumentasi Perbaikan');
                $('#label_deskripsi_kerusakan_bangunan').text('Deskripsi Perbaikan');
                $('#label_dokumentasi_kerusakan_bangunan').text('Dokumentasi Perbaikan');
            }

            generateNoPerbaikan();
        }

        // Panggil fungsi saat halaman dimuat
        toggleJenisRequestSections();

        // Tambahkan event listener untuk perubahan pada radio button
        $('input[name="jenis_request"]').on('change', function() {
            toggleJenisRequestSections();
        });

        // Fungsi untuk mengatur visibilitas berdasarkan radio button yang dipilih
        function togglePerbaikanSections() {
            if ($('#pilih_perbaikan_aset').is(':checked')) {
                $('#perbaikan_aset').removeClass('hidden').show(); // Tampilkan div perbaikan aset
                $('#perbaikan_bangunan').addClass('hidden').hide(); // Sembunyikan div perbaikan bangunan
            } else if ($('#pilih_perbaikan_bangunan').is(':checked')) {
                $('#perbaikan_bangunan').removeClass('hidden').show(); // Tampilkan div perbaikan bangunan
                $('#perbaikan_aset').addClass('hidden').hide(); // Sembunyikan div perbaikan aset
            }
        }

        // Panggil fungsi saat halaman dimuat
        togglePerbaikanSections();

        // Tambahkan event listener untuk perubahan pada radio button
        $('input[name="pilih_perbaikan"]').on('change', function() {
            togglePerbaikanSections();
        });

        // Mencegah submit form pada Enter untuk semua input
        $('#addForm').on('keydown', 'input', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault(); // Mencegah submit default form
                // Panggil fungsi pencarian jika input dengan id "no_spp" yang di-enter
                if ($(this).attr('id') === 'no_spp') {
                    $('#search_button').click(); // Trigger tombol search_button
                }
            }
        });

        // Fungsi pencarian nomor SPK
        $('#search_button').click(function() {
            const aset_search = $('#input_aset_search').val(); // Ambil input dari pengguna
            const departemen = $('#kode_departemen').val(); // Ambil input dari departemen_pemohon
            const ruangan = $('#kode_lokasi').val(); // Ambil input dari lokasi ruangan

            const encodeDepartemen = encodeURI(departemen);
            const encodeRuangan = encodeURI(ruangan);

            if (!aset_search) {
                Notiflix.Report.info('Info', 'Masukkan aset terlebih dahulu!');
                return;
            }

            $.ajax({
                url: '{{ route("request_perbaikan.search") }}', // Route Laravel untuk pencarian
                type: 'GET',
                data: {
                    search: aset_search,
                    departemen: encodeDepartemen,
                    ruangan: encodeRuangan,
                },
                success: function(response) {
                    if (response.status === 'success') {
                        const results = response.result;

                        // Kosongkan tabel sebelum menambahkan hasil baru
                        $('#search_results').empty();

                        // Tambahkan setiap hasil ke tabel
                        results.forEach(result => {
                            $('#search_results').append(`
                                <tr class="cursor-pointer hover:bg-gray-100" onclick="addToDetails(this)">
                                    <td class="py-2 px-4 border-b">${result.kode_aset}</td>
                                    <td class="py-2 px-4 border-b">${result.nama_aset}</td>
                                    <td class="py-2 px-4 border-b">${result.nama_kategori_aset ?? ''}</td>
                                </tr>
                    `);
                        });
                    } else {
                        // Jika tidak ada data, tampilkan pesan default
                        $('#search_results').html(`
                            <tr>
                                <td colspan="5" class="py-4 px-6 text-center text-gray-500">Data tidak ditemukan.</td>
                            </tr>
                `);
                    }
                },
                error: function(xhr) {
                    const message = xhr.responseJSON?.message || 'Terjadi kesalahan saat mencari data.';
                    Notiflix.Report.failure('Error', message);
                },
            });
        });

        // Fungsi untuk menambahkan data ke tabel details
        window.addToDetails = function(row) {
            const columns = $(row).children('td');
            const kode_aset = $(columns[0]).text().trim();
            const nama_aset = $(columns[1]).text().trim();
            const nama_kategori_aset = $(columns[2]).text().trim();

            // Cek apakah kode_aset sudah ada di tabel detail
            let isDuplicate = false;
            $('#details_tbody tr').each(function() {
                const existingKodeAset = $(this).find('td:nth-child(2)').text().trim();
                if (existingKodeAset === kode_aset) {
                    isDuplicate = true;
                    return false; // Hentikan loop
                }
            });

            if (isDuplicate) {
                Notiflix.Report.info('Info', 'Aset sudah ditambahkan ke tabel detail.');
                return;
            }

            // Jika tabel kosong (hanya ada baris default), hapus baris default
            if ($('#details_tbody tr').length === 1) {
                const firstRow = $('#details_tbody tr:first');
                const firstRowContent = firstRow.find('td:first').text().trim();
                if (firstRowContent === 'Tidak ada data') {
                    firstRow.remove(); // Hapus baris default
                }
            }

            // Tambahkan data ke tabel detail
            const newRow = `
                <tr>
                    <td class="border-b px-4 py-2"></td>
                    <td class="border-b px-4 py-2">
                        ${kode_aset}
                        <input type="hidden" name="kode_aset[]" value="${kode_aset}">
                    </td>
                    <td class="border-b px-4 py-2">
                        ${nama_aset}
                        <input type="hidden" name="nama_aset[]" value="${nama_aset}">
                    </td>
                    <td class="border-b px-4 py-2">
                        ${nama_kategori_aset}
                        <input type="hidden" name="kategori_aset[]" value="${nama_kategori_aset}">
                    </td>
                    <td class="border-b px-4 py-2">
                        <textarea name="deskripsi_kerusakan[]" class="focus:shadow-primary-outline text-sm leading-5.6 ease block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-blue-500 focus:outline-none" placeholder="Tuliskan detail kerusakan" rows="4" cols="100"></textarea>
                    </td>
                    <td class="border-b px-4 py-2">
                        <input type="file" name="dokumentasi_kerusakan[]" class="dokumentasi-input focus:shadow-primary-outline text-sm leading-5.6 ease block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-blue-500 focus:outline-none" multiple accept=".jpeg, .jpg, .png">
                        <span name="info_message_dokumentasi_kerusakan[]" class="text-blue-500 text-xs">Maks Foto 2 MB</span><br>
                        <span name="error_message_dokumentasi_kerusakan[]" class="text-red-500 text-sm"></span>
                    </td>
                    <td class="border-b px-4 py-2">
                        <button type="button" class="inline-block px-4 py-2 font-bold text-white bg-red-500 rounded hover:bg-red-600" onclick="removeRow(this)">Hapus</button>
                    </td>
                </tr>
            `;

            const addROw = $('#details_tbody').append(newRow);

            // Perbarui nomor urut dan indeks dokumentasi setelah penambahan
            updateRowNumbersAndIndexes();

            if (addROw) {
                Notiflix.Report.success('Success', 'Aset berhasil ditambahkan ke tabel.');
                columns.addClass('hidden');
            }

        };

        // Fungsi untuk menghapus baris dari tabel details
        window.removeRow = function(button) {
            // Hapus baris yang diklik
            $(button).closest('tr').remove();

            // Perbarui nomor urut dan indeks dokumentasi setelah penghapusan
            updateRowNumbersAndIndexes();
        };

        // Fungsi untuk memperbarui nomor urut dan indeks dokumentasi
        function updateRowNumbersAndIndexes() {
            $('#details_tbody tr').each(function(index) {
                // Perbarui nomor urut
                $(this).find('td:first').text(index + 1);

                // Perbarui indeks dokumentasi_kerusakan
                const inputFile = $(this).find('input.dokumentasi-input');
                inputFile.attr('name', `dokumentasi_kerusakan[${index}][]`);
            });

            // Jika tabel kosong, tampilkan pesan default
            if ($('#details_tbody tr').length === 0) {
                resetToDefault();
            }
        }

        // Fungsi untuk mereset tabel ke nilai default saat kosong
        function resetToDefault() {
            const defaultRow = `
                <tr>
                    <td colspan="7" class="text-center text-gray-500 py-4">Tidak ada data</td>
                </tr>
            `;
            $('#details_tbody').html(defaultRow);
        }

        let isSubmitting = false; // Flag untuk mencegah double submit

        // Fungsi validasi sebelum submit
        $('#btnSubmit').on('click', function(e) {
            e.preventDefault(); // Mencegah submit form default

            //console.log("Tombol btnSubmit diklik!"); // Debugging: pastikan event listener berfungsi

            if (isSubmitting) {
                console.log("Form sudah dikirim, mencegah submit ganda.");
                return; // Jika sudah diklik, hentikan eksekusi
            }

            // Reset pesan error
            const allErrorMessage = $('.error-message');
            if (allErrorMessage.length > 0) {
                allErrorMessage.text('');
            }

            let isValid = true; // Menyimpan status validasi

            // Validasi Nomor Request Perbaikan
            const nomorRequest = $('#nomor_request_perbaikan').val();
            if (!nomorRequest) {
                $('#error_message_nomor_request_perbaikan').text('Nomor Request Perbaikan harus diisi.');
                isValid = false;
            }

            // Validasi Departemen Pemohon
            const departemenPemohon = $('#departemen_pemohon').val();
            if (!departemenPemohon) {
                $('#error_message_departemen_pemohon').text('Departemen Pemohon harus diisi.');
                isValid = false;
            }

            // Validasi Lokasi Ruangan
            const lokasiRuangan = $('#lokasi_ruangan').val();
            if (!lokasiRuangan) {
                $('#error_message_lokasi_ruangan').text('Lokasi Ruangan harus diisi.');
                isValid = false;
            }

            // Validasi Pilih Perbaikan
            const pilihPerbaikan = $('input[name="pilih_perbaikan"]:checked').val();

            if (pilihPerbaikan === 'Aset') {
                // Validasi data pada tabel detail
                $('#details_tbody tr').each(function() {
                    const deskripsiKerusakan = $(this).find('textarea[name="deskripsi_kerusakan[]"]').val();
                    const dokumentasiKerusakan = $(this).find('input[type="file"]')[0].files; // Mengambil nilai file input
                    const errorMessageDokumentasi = $(this).find('span[name="error_message_dokumentasi_kerusakan[]"]').text('');

                    if (!deskripsiKerusakan) {
                        $(this).find('textarea[name="deskripsi_kerusakan[]"]').after('<span class="error-message text-red-500 text-sm">Deskripsi Kerusakan harus diisi.</span>');
                        isValid = false;
                    }

                    if (!dokumentasiKerusakan.length) {
                        //console.log('tes 1', dokumentasiKerusakan);
                        //console.log('ada error woi');
                        // $(this).find('input[type="file"]').after('<span class="error-message text-red-500 text-sm">Dokumentasi Kerusakan harus diunggah.</span>');
                        errorMessageDokumentasi.text('Dokumentasi Kerusakan harus diunggah.');
                        isValid = false;
                    } else {
                        // Validasi ukuran file
                        for (let i = 0; i < dokumentasiKerusakan.length; i++) {
                            if (dokumentasiKerusakan[i].size > 2 * 1024 * 1024) { // 2 MB
                                //console.log('ada error woi');
                                // $(this).find('input[type="file"]').after('<span class="error-message text-red-500 text-sm">Ukuran setiap file Dokumentasi Kerusakan tidak boleh lebih dari 2 MB.</span>');
                                errorMessageDokumentasi.text('Ukuran setiap file Dokumentasi Kerusakan tidak boleh lebih dari 2 MB.');
                                isValid = false;
                                break;
                            }
                        }
                    }
                });
            } else if (pilihPerbaikan === 'Bangunan') {
                // Validasi deskripsi_kerusakan_bangunan dan dokumentasi_kerusakan_bangunan[]
                const deskripsiKerusakanBangunan = $('#deskripsi_kerusakan_bangunan').val();
                const dokumentasiKerusakanBangunan = $('#dokumentasi_kerusakan_bangunan')[0].files;
                const errorMessageDeskripsi = $('#error_message_deskripsi_kerusakan_bangunan').text('');
                const errorMessageDokumentasi = $('#error_message_dokumentasi_kerusakan_bangunan').text('');

                if (!deskripsiKerusakanBangunan) {
                    errorMessageDeskripsi.text('Deskripsi Kerusakan untuk Bangunan harus diisi.');
                    isValid = false;
                }

                if (!dokumentasiKerusakanBangunan.length) {
                    errorMessageDokumentasi.text('Dokumentasi Kerusakan untuk Bangunan harus diunggah.');
                    //$('#info_message_dokumentasi_kerusakan_bangunan').after('<span class="error-message text-red-500 text-sm">Dokumentasi Kerusakan untuk Bangunan harus diunggah.</span>');
                    isValid = false;
                } else {
                    // Validasi ukuran file
                    for (let i = 0; i < dokumentasiKerusakanBangunan.length; i++) {
                        if (dokumentasiKerusakanBangunan[i].size > 2 * 1024 * 1024) { // 2 MB
                            errorMessageDokumentasi.text('Ukuran setiap file Dokumentasi Kerusakan untuk Bangunan tidak boleh lebih dari 2 MB.');
                            isValid = false;
                            break;
                        }
                    }
                }
            } else {
                $('#error_message_pilih_perbaikan').text('Pilih Perbaikan harus dipilih (Aset atau Bangunan).');
                isValid = false;
            }

            // Jika semua validasi lolos, submit form
            if (isValid) {
                isSubmitting = true; // Set flag bahwa form sedang dikirim
                $('#btnSubmit').prop('disabled', true).text('Menyimpan...'); // Nonaktifkan tombol submit

                $('#addForm').submit();
            }
        });
    });
</script>

@endsection
