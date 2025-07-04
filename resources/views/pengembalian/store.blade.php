@extends('layout.main')
@section('content')
<div class="w-full px-6 py-6 mx-auto mt-10">
    <div class="bg-white shadow-lg rounded-lg p-6">
        <div class="text-center flex-1 mb-6">
            <h2 class="mb-2 font-bold text-white rounded-md px-4 py-2 inline-block rounded-xl shadow-md md:text-lg text-2xl" style="background-color: #000923;">
                Tambah Pengembalian
            </h2>
        </div>
        <div class="mb-4">
            <label for="nomor_pengembalian_barang" class="block text-gray-700 font-bold">Nomor Pengembalian Barang</label>
            <input type="text" id="nomor_pengembalian_barang" name="nomor_pengembalian_barang"
                class="w-full border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                value="{{ $nomor_pengembalian_barang ?? '' }}" readonly>
        </div>
        <div class="mb-4">
            <label for="tanggal" class="block text-gray-700 font-bold">Tanggal</label>
            <input type="date" id="tanggal" name="tanggal"
                class="w-full border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                value="{{ now()->format('Y-m-d') }}" readonly>
        </div>

        <div class="mb-4">
            <label for="id_input" class="block text-gray-700 font-bold">ID Input</label>
            <input type="text" id="id_input" name="id_input" 
                class="w-full border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                value="{{ auth()->user()->username ?? '' }}" readonly>
        </div>
        <div class="mb-4">
            <label for="departemen" class="block text-gray-700 font-bold">Departemen</label>
            <input type="text" id="departemen" name="departemen"
                class="w-full border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                value="Research & Development" readonly>
        </div>

        <div class="mt-6">
            <label for="warehouse" class="font-bold text-gray-700">Gudang Penyimpanan</label>
            <select id="warehouse" name="warehouse"
                class="w-full rounded-lg mt-1 block border border-gray-300 focus:ring-blue-500 focus:border-blue-500 text-gray-700 text-sm h-10 px-3">
                <option value="" selected disabled>Pilih Gudang</option>
                            <input type="hidden" id="kode_gudang" name="kode_gudang">
            </select>
        </div>

        
        
        <div>
            <label for="jenis_pengembalian" class="font-bold text-gray-700 mt-4">Jenis Pengembalian</label>
            <select id="jenis_pengembalian" name="jenis_pengembalian" 
                class="rounded-lg mt-1 block w-full border border-gray-300 focus:ring-blue-500 focus:border-blue-500 text-gray-700 text-sm h-10 px-3">
                <option value="">Pilih Jenis Pengembalian</option>
               <!--  <option value="spp">SPP</option> -->
                <option value="nonspp">Non SPP</option>
            </select>
        </div>

      <!--   <div id="spp_container" class="mt-6 hidden">
            <label for="nomor_surat_perintah_produksi" class="font-bold text-gray-700">Cari Nomor Surat Perintah Produksi</label>
            <div class="relative">
                <div class="flex items-center space-x-2">
                    <input type="text" id="nomor_surat_perintah_produksi" name="nomor_surat_perintah_produksi" 
                        class="form-control flex-1 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 transition duration-300 h-10 px-3 mr-4"
                        placeholder="Cari Nomor Surat Perintah Produksi" 
                        onkeyup="searchNomorSuratPerintahProduksiPengembalian()" />
                    <button id="search-button" 
                        class="bg-blue-500 text-white font-semibold px-4 py-2 rounded-lg flex items-center hover:bg-blue-600 transition duration-300" 
                        onclick="searchNomorSuratPerintahProduksiPengembalian()">
                        <i class="fas fa-search mr-2"></i>Search
                    </button>
                </div>
                <div id="search-results" 
                    class="absolute z-10 bg-white border border-gray-300 rounded-lg shadow-md hidden mt-1 w-full">
                </div>
            </div>
        </div>
        <div class="w-full px-6 py-6 mx-auto mt-10 mt-6">
                <div class="overflow-x-auto max-w-full">
                    <table id="datatable_pengembalian" class="display w-full border-collapse border border-gray-300">
                        <thead>
                            <tr>
                            <th class="border border-gray-300 px-4 py-2">No</th>
                                <th class="border border-gray-300 px-4 py-2">Nomor SPP</th>
                                <th class="border border-gray-300 px-8 py-4">Nama Merek</th>
                                <th class="border border-gray-300 px-4 py-2">Kategori</th>
                                <th class="border border-gray-300 px-4 py-2">Nama Produk</th>
                                <th class="border border-gray-300 px-8 py-4">Nomor Batch</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
        </div> -->
        <div>
            <label for="tujuan_pengembalian_barang" class="font-bold text-gray-700 mt-4">Tujuan Pengembalian Barang </label>
            <input type="text" id="tujuan_pengembalian_barang" name="tujuan_pengembalian_barang" 
                class="rounded-lg mt-1 block w-full border border-gray-300 focus:ring-blue-500 focus:border-blue-500 text-gray-700 text-sm h-10 px-3"  placeholder="Input Tujuan Pengembalian Barang">
        </div>
        <div class="w-full px-6 py-6 mx-auto mt-10 mt-6">
            <div class="bg-white shadow-lg p-6">
                <h2 class="mb-2 font-bold text-white rounded-md px-4 py-2 inline-block rounded-xl shadow-md md:text-lg text-xl mb-6" style="background-color: #000923;">
                    List Barang
                </h2>
                <div class="overflow-x-auto max-w-full">
                    <table id="datatable_barang" class="display w-full border-collapse border border-gray-300">
                        <thead>
                            <tr>
                            <th class="border border-gray-300 px-4 py-2">No</th>
                                <th class="border border-gray-300 px-4 py-2">Kode Barang</th>
                                <th class="border border-gray-300 px-8 py-4">Nama Barang</th>
                                <th class="border border-gray-300 px-4 py-2">Jumlah</th>
                                <th class="border border-gray-300 px-4 py-2">Satuan</th>
                                <th class="border border-gray-300 px-8 py-4">Keterangan</th>
                                <th class="border border-gray-300 px-8 py-4">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="text-right mt-6">
            <button id="save-button" class="bg-blue-500 text-white font-semibold px-4 py-2 rounded" onclick="saveDataPengembalian()">Simpan</button>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{ asset('Modal/pengembalian.js') }}" defer></script>

<style>
.select2-container .select2-selection--single {
    height: 40px !important;
    border: 1px solid #d1d5db; /* Tailwind border-gray-300 */
    border-radius: 0.5rem; /* Tailwind rounded-lg */
    padding: 5px 12px;
    font-size: 0.875rem; /* text-sm */
    color: #374151; /* Tailwind text-gray-700 */
}
.select2-selection__rendered {
    line-height: 30px !important;
}
.select2-selection__arrow {
    height: 100% !important;
}
</style>
<script>
    $('#warehouse').select2({
        ajax: {
            url: '{{ route("pengembalian.warehouse") }}',
            type: 'GET',
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    term: params.term,
                };
            },
            processResults: function (data) {
                return {
                    results: data,
                };
            },
            cache: true,
        },
    });

    $('#warehouse').on('select2:select', function (e) {
        let selectedData = e.params.data;
    
        $('#kode_gudang').val(selectedData.id);

        updateNomorPengembalian(); 

        let satuanList = [];
        $.ajax({
            url: '{{ route("pengembalian.getMasterSatuan") }}',
            type: 'GET',
            async: false, // perlu agar bisa pakai daftar di loop berikutnya
            success: function (response) {
                satuanList = response;
            },
            error: function () {
                Swal.fire('Gagal', 'Gagal mengambil data satuan.', 'error');
            }
        });

        $.ajax({
            url: '{{ route("pengembalian.getStokBarang") }}',
            type: 'GET',
            data: { gudang: selectedData.text }, 
            success: function (response) {
                if (response.status === 'success') {
                    let data = response.data;
                    let table = $('#datatable_barang').DataTable();
                    table.clear();
                    
                    data.forEach((item, index) => {
                        let satuanOptions = '<select class="input-satuan w-full px-2 border rounded">';
                        satuanList.forEach(s => {
                            let selected = (s.text === item.satuan) ? 'selected' : '';
                            satuanOptions += `<option value="${s.text}" ${selected}>${s.text}</option>`;
                        });
                        satuanOptions += '</select>';

                        table.row.add([
                            index + 1,
                            item.kode_barang,
                            item.nama_barang,
                           `<input type="number" class="input-jumlah w-full px-2 border rounded" value="0" min="0">
                            `,
                            satuanOptions,
                            `<input type="text" class="input-keterangan w-full px-2 border rounded" value="${item.keterangan ?? ''}">`,
                            `<button type="button" class="btn-hapus-row text-red-600 hover:text-red-800"><i class="fas fa-trash-alt"></i></button>`
                        ]);
                    });

                    table.draw();
                } else {
                    Swal.fire('Gagal', response.message, 'error');
                }
            },
            error: function () {
                Swal.fire('Gagal', 'Terjadi kesalahan saat mengambil data stok', 'error');
            }
        });

    });

    
    document.addEventListener("DOMContentLoaded", function () {
        const jenisPengembalian = document.getElementById("jenis_pengembalian");
        const sppContainer = document.getElementById("spp_container");


        if (jenisPengembalian) {
            jenisPengembalian.addEventListener("change", function () {
                const selectedValue = this.value;

                if (selectedValue === "spp") {
                    sppContainer.classList.remove("hidden"); 
                } else {
                    sppContainer.classList.add("hidden");
                }
            });
        } else {
            console.error("Jenis Pengembalian tidak ditemukan dalam DOM");
        }
    });

    function searchNomorSuratPerintahProduksiPengembalian() {
        var keyword = $('#nomor_surat_perintah_produksi').val().trim();
        var searchIcon = $('#search-icon');
        var resultsDropdown = $('#search-results');

        if (!keyword) {
            resultsDropdown.empty().addClass('hidden');
            return;
        }

        searchIcon.removeClass('fas fa-search').addClass('fas fa-spinner fa-spin');

        if (this.currentAjaxRequest) {
            this.currentAjaxRequest.abort();
        }

        this.currentAjaxRequest = $.ajax({
            url: '{{ route("cariNomorSuratPerintahProduksiPengembalian") }}',
            type: 'GET',
            data: { keyword: keyword },
            success: function (response) {
                searchIcon.removeClass('fas fa-spinner fa-spin').addClass('fas fa-search');
                resultsDropdown.empty();

                if (response.status === 'success' && response.data.length > 0) {
                    response.data.forEach(item => {
                        const option = `
                            <div class="px-4 py-2 cursor-pointer hover:bg-gray-200" 
                                onclick="selectNomorSuratPerintahProduksiPengembalian(
                                    '${item.id}',
                                    '${item.nomor_surat_perintah_produksi}', 
                                    '${item.nama_merek}', 
                                    '${item.kategori}', 
                                    '${item.nomor_batch}', 
                                    '${item.nama_produk}'
                                )">
                                ${item.nomor_surat_perintah_produksi}
                            </div>`;
                        resultsDropdown.append(option);
                    });
                    resultsDropdown.removeClass('hidden');
                } else {
                    resultsDropdown.append('<div class="px-4 py-2 text-gray-700">Tidak ada hasil ditemukan.</div>');
                    resultsDropdown.removeClass('hidden');
                }

            },
            error: function () {
                searchIcon.removeClass('fas fa-spinner fa-spin').addClass('fas fa-search');
                resultsDropdown.empty().append('<div class="px-4 py-2 text-red-500">Terjadi kesalahan.</div>').removeClass('hidden');
            }
        });
    }

    function selectNomorSuratPerintahProduksiPengembalian(
        id, nomorSPP, namaMerek, kategori, nomorBatch, namaProduk
    ) {
        $('#nomor_surat_perintah_produksi').val(nomorSPP);
        $('#nama_merek').text(namaMerek || '-');
        $('#kategori').text(kategori || '-');
        $('#nomor_batch').text(nomorBatch || '-');
        $('#nama_produk').text(namaProduk || '-');

        $('#search-results').empty().addClass('hidden');

        updateNomorPengembalian();

        let table = $('#datatable_pengembalian').DataTable(); 
        let tableBody = $('#datatable_pengembalian tbody');

        let isDuplicate = table.rows().data().toArray().some(row => row[1] === nomorSPP);

        if (!isDuplicate) {
            table.row.add([
                table.rows().count() + 1,  
                nomorSPP,
                namaMerek,
                kategori,
                namaProduk,
                nomorBatch
            ]).draw();
        }
    }

    function updateNomorPengembalian() {
        const kodeGudang = document.getElementById('kode_gudang')?.value || 'KodeGudangTidakAda';
        if (kodeGudang === 'KodeGudangTidakAda') {
            console.warn("Gudang belum dipilih.");
            return;
        }

        const today = new Date();
        const year = today.getFullYear();
        const month = (today.getMonth() + 1).toString().padStart(2, '0');
        const formattedDate = `${month}${year}`;

        let lastNumber = localStorage.getItem('lastPengembalianNumber') || 0;
        lastNumber = parseInt(lastNumber, 10);
        const nextNumber = lastNumber + 1;
        const nomorUrutFormatted = nextNumber.toString().padStart(6, '0');

        localStorage.setItem('lastPengembalianNumber', nextNumber);

        const nomorPengembalian = `PGB/${kodeGudang}/${nomorUrutFormatted}/${formattedDate}`;

        document.getElementById('nomor_pengembalian_barang').value = nomorPengembalian;
        console.log('Nomor Pengembalian Barang:', nomorPengembalian);
    }

    function saveDataPengembalian() {
        let nomor_pengembalian_barang = $('#nomor_pengembalian_barang').val();
        let tanggal = $('#tanggal').val();
        let id_input = $('#id_input').val();
        let departemen = $('#departemen').val(); 
        let kode_gudang = $('#kode_gudang').val();
        let warehouse = $('#warehouse option:selected').text(); 
        let jenis_pengembalian = $('#jenis_pengembalian').val();
        let nomor_surat_perintah_produksi = $('#nomor_surat_perintah_produksi').val();
        let tujuan_pengembalian_barang = $('#tujuan_pengembalian_barang').val();

        if (!tujuan_pengembalian_barang || tujuan_pengembalian_barang.trim() === '') {
            Swal.fire('Peringatan', 'Tujuan Pengembalian Barang wajib diisi.', 'warning');
            return;
        }

        let table = $('#datatable_barang').DataTable();
        let dataBarang = [];

        table.rows().every(function () {
            let $row = $(this.node());

            dataBarang.push({
                kode_barang: $row.find('td').eq(1).text().trim(),
                nama_barang: $row.find('td').eq(2).text().trim(),
                jumlah: $row.find('td').eq(3).find('input').val(),
                satuan: $row.find('td').eq(4).find('select').val(),
                keterangan: $row.find('td').eq(5).find('input').val()
            });
        });


        if (dataBarang.length === 0) {
            Swal.fire('Gagal', 'List barang tidak boleh kosong.', 'warning');
            return;
        }

        $.ajax({
            url: '{{ route("pengembalian.simpanPengembalian") }}',
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            data: {
                nomor_pengembalian_barang,
                tanggal,
                id_input,
                kode_gudang,
                warehouse,
                jenis_pengembalian,
                nomor_surat_perintah_produksi,
                tujuan_pengembalian_barang,
                departemen,
                list_barang: dataBarang,
            },
            success: function (response) {
                Swal.fire('Berhasil', response.message, 'success').then(() => {
                    window.location.href = '{{ route("pengembalian") }}';
                });

            },
            error: function (xhr) {
                let err = xhr.responseJSON?.message || 'Terjadi kesalahan saat menyimpan data.';
                Swal.fire('Gagal', err, 'error');
            }
        });
    }

    $(document).on('click', '.btn-hapus-row', function () {
        const table = $('#datatable_barang').DataTable();
        table.row($(this).closest('tr')).remove().draw();
    });




</script>
@endsection
