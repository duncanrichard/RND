@extends('layout.main')

@section('content')
<div class="w-full px-6 py-6 mx-auto mt-10">
    <div class="bg-white shadow-lg rounded-lg p-6">
        <h2 class="text-2xl font-bold mb-4">Tambah Master Formula Sample</h2>

        <form action="{{ route('master_formula_sample.store') }}" method="POST">
            @csrf
            <div class="grid grid-cols-2 gap-8">
                <!-- Bagian Kiri -->
                <div>
                    <!-- Nomor Formula Sample -->
                    <div class="mb-4">
    <label for="nomor_formula" class="block text-sm font-medium text-gray-700">Nomor Formula Sample</label>
    <input type="text" name="nomor_formula" id="nomor_formula"
        class="block w-full mt-1 border border-gray-300 rounded-lg shadow-sm py-2 px-3"
        value="" readonly required>
</div>


                    <!-- Tanggal -->
                    <div class="mb-4">
                        <label for="tanggal" class="block text-sm font-medium text-gray-700">Tanggal</label>
                        <input type="date" name="tanggal" id="tanggal" class="block w-full mt-1 border border-gray-300 rounded-lg shadow-sm py-2 px-3" value="{{ date('Y-m-d') }}" readonly required>
                    </div>

                    <!-- ID Input -->
                    <div class="mb-4">
                        <label for="id_input" class="block text-sm font-medium text-gray-700">ID Input</label>
                        <input type="text" name="id_input" id="id_input" class="block w-full mt-1 border border-gray-300 rounded-lg shadow-sm py-2 px-3" value="{{ Auth::user()->username }}" readonly required>
                    </div>

                     <!-- Nama Sample -->
                     <div class="mb-4">
                        <label for="nama_sample" class="block text-sm font-medium text-gray-700">Nama Sample</label>
                        <input type="text" name="nama_sample" id="nama_sample" class="block w-full mt-1 border border-gray-300 rounded-lg shadow-sm py-2 px-3" required>
                    </div>

                    <!-- Bahan Aktif -->
                    <div class="mb-4">
                        <label for="bahan_aktif" class="block text-sm font-medium text-gray-700">Bahan Aktif</label>
                        <input type="text" name="bahan_aktif" id="bahan_aktif" class="block w-full mt-1 border border-gray-300 rounded-lg shadow-sm py-2 px-3" required>
                    </div>
                </div>

                <!-- Bagian Kanan -->
                <div>
                   
<!-- Pilihan Jenis Formula -->
<div class="mb-4">
    <label class="block text-sm font-medium text-gray-700">Jenis Input</label>
    <div class="mt-2 flex gap-4">
    <label class="radio-box px-4 py-2 border rounded cursor-pointer flex items-center gap-2" id="radioBaru">
        <input type="radio" name="jenis_formula" value="baru" checked class="hidden" onchange="toggleJenisFormula(this.value); updateRadioStyle(this)">
        <span>Baru</span>
    </label>
    <label class="radio-box px-4 py-2 border rounded cursor-pointer flex items-center gap-2" id="radioRevisi">
        <input type="radio" name="jenis_formula" value="revisi" class="hidden" onchange="toggleJenisFormula(this.value); updateRadioStyle(this)">
        <span>Revisi</span>
    </label>
</div>


</div>

 <!-- Pilih Merk -->
 <div class="mb-4" id="form_pilih_merk">
    <label for="merk" class="block text-sm font-medium text-gray-700">Merk</label>
    <select name="merk" id="merk" class="block w-full mt-1 border border-gray-300 rounded-lg shadow-sm py-2 px-3">
        <option value="">-- Pilih Merk --</option>
        @foreach($listMerk as $merk)
            <option value="{{ $merk->singkatan_merk }}">{{ $merk->nama_merk }}</option>
        @endforeach
    </select>
</div>
                    <!-- Kode Sample -->
                    <div class="mb-4">
    <label for="kode_sample" class="block text-sm font-medium text-gray-700">Kode Sample</label>
    <input type="text" name="kode_sample" id="kode_sample"
        class="block w-full mt-1 border border-gray-300 rounded-lg shadow-sm py-2 px-3"
        value="" readonly data-next="{{ $nextSampleNumber }}">
</div>
<!-- Form pencarian kode sample untuk revisi -->
<div id="form_cari_kode_sample" class="mb-4 hidden">
    <label for="cari_kode_sample" class="block text-sm font-medium text-gray-700">Cari Kode Sample</label>
    <input type="text" id="cari_kode_sample" class="block w-full mt-1 border border-gray-300 rounded-lg shadow-sm py-2 px-3"
        placeholder="Masukkan kode sample yang ingin direvisi...">
    <button type="button" id="btnCariKodeSample" class="mt-2 bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
        Cari
    </button>
</div>
<!-- Tabel Hasil Pencarian Kode Sample -->
<div id="result_kode_sample_container" class="mt-4 hidden">
    <table class="w-full border border-gray-300">
        <thead class="bg-gray-100">
            <tr>
                <th class="border px-4 py-2 text-center">Kode Sample</th>
                <th class="border px-4 py-2 text-center">Action</th>
            </tr>
        </thead>
        <tbody id="result_kode_sample_body">
            <tr>
                <td colspan="2" class="text-center py-4">Belum ada hasil</td>
            </tr>
        </tbody>
    </table>
</div>
                   
                </div>
            </div>
            <input type="hidden" name="formula_sample_id" id="formula_sample_id">
            <!-- Form Pencarian -->
            <div class="mt-10">
                <h3 class="text-xl font-bold mb-4">Cari Bahan Baku</h3>
                <div class="flex items-center mb-4">
                    <input type="text" id="search_bahan_baku" class="flex-1 border border-gray-300 rounded-lg shadow-sm py-2 px-3" placeholder="Masukkan kode atau nama bahan baku...">
                    <button type="button" class="ml-2 px-4 py-2 font-bold bg-blue-500 text-white rounded hover:bg-blue-600" id="search_button">Cari</button>
                </div>
            </div>

            <!-- Tabel Hasil Pencarian -->
            <div id="search_table_container" class="hidden mt-6">
                <table class="w-full border-collapse border border-gray-300">
                    <thead>
                        <tr class="bg-gray-100 text-left">
                            <th class="border border-gray-300 px-4 py-2" align="center">Kode</th>
                            <th class="border border-gray-300 px-4 py-2" align="center">Nama Bahan Baku</th>
                        </tr>
                    </thead>
                    <tbody id="search_results">
                        <tr>
                            <td colspan="2" class="text-center py-4">Silakan cari data bahan baku...</td>
                        </tr>
                    </tbody>
                </table>
            </div>


            <!-- Tabel Detail Bahan Baku -->
            <div class="overflow-x-auto mt-6">
                <table class="w-full border-collapse border border-gray-300">
                    <thead>
                        <tr class="bg-gray-100 text-left">
                            <th class="border border-gray-300 px-4 py-2">No</th>
                            <th class="border border-gray-300 px-4 py-2">Premix</th>
                            <th class="border border-gray-300 px-4 py-2">Kode Bahan Baku</th>
                            <th class="border border-gray-300 px-4 py-2">Nama Bahan Baku</th>
                            <th class="border border-gray-300 px-4 py-2">Function</th>
                            <th class="border border-gray-300 px-4 py-2">Supplier</th>
                            <th class="jumlah-col border border-gray-300 px-4 py-2">Jumlah</th>
                            <th class="border border-gray-300 px-4 py-2">Satuan</th>
                            <th class="border border-gray-300 px-4 py-2 hidden">Harga Akhir</th>
                            <th class="hpp-col border border-gray-300 px-4 py-2">HPP</th>
                            <th class="border border-gray-300 px-4 py-2 hidden">HPP form input</th>
                            <th class="border border-gray-300 px-4 py-2">Action</th>
                        </tr>
                    </thead>
                    <tbody id="detail_results">
                        <tr>
                            <td colspan="5" class="text-center py-4">Data belum tersedia</td>
                        </tr>
                    </tbody>
                </table>
                <!-- Perhitungan Total -->
                <div class="mt-4">
                    <h3 class="text-xl font-bold mb-2">Total</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="flex justify-between items-center">
                            <span class="font-medium">Total Jumlah:</span>
                            <span id="total_jumlah" class="font-bold">0</span>
                            <input type="hidden" id="total_jumlah_input" name="total_jumlah_input" value="" placeholder="test">
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="font-medium">Total HPP:</span>
                            <span id="total_hpp" class="font-bold">0 </span>
                            <input type="hidden" id="total_hpp_input" name="total_hpp_input" value="" placeholder="test">
                        </div>
                    </div>
                </div>
            </div>
            <br>
            <!-- Prosedur Kerja -->
            <div class="mt-8">
                <h3 class="text-xl font-bold mb-4">Prosedur Kerja</h3>
                <div id="prosedur_kerja_container">
                    <!-- Form Prosedur Kerja akan ditambahkan di sini oleh JavaScript -->
                </div>
                <button type="button" id="add_prosedur_button"
                    class="mt-2 px-4 py-2 font-bold bg-blue-500 text-white rounded hover:bg-blue-600">
                    + Tambah Prosedur Kerja
                </button>
            </div>


            <br>


            <!-- Spesifikasi -->
            <div class="mt-8">
                <h3 class="text-xl font-bold mb-4">Spesifikasi</h3>
                <div id="spesifikasi_container">
                    <!-- Form Spesifikasi -->
                    <div class="spesifikasi-item">
                        <div>
                            <label for="bentuk" class="block text-sm font-medium text-gray-700">Bentuk</label>
                            <input type="text" name="bentuk" id="bentuk"
                                class="block w-full mt-1 border border-gray-300 rounded-lg shadow-sm py-2 px-3"
                                placeholder="Masukkan bentuk..." required>
                        </div>
                        <div>
                            <label for="warna" class="block text-sm font-medium text-gray-700">Warna</label>
                            <input type="text" name="warna" id="warna"
                                class="block w-full mt-1 border border-gray-300 rounded-lg shadow-sm py-2 px-3"
                                placeholder="Masukkan warna..." required>
                        </div>
                        <div>
                            <label for="bau" class="block text-sm font-medium text-gray-700">Bau</label>
                            <input type="text" name="bau" id="bau"
                                class="block w-full mt-1 border border-gray-300 rounded-lg shadow-sm py-2 px-3"
                                placeholder="Masukkan bau..." required>
                        </div>
                        <div>
                            <label for="ph" class="block text-sm font-medium text-gray-700">PH</label>
                            <input type="text" name="ph" id="ph"
                                class="block w-full mt-1 border border-gray-300 rounded-lg shadow-sm py-2 px-3"
                                placeholder="Masukkan PH..." required>
                        </div>
                        <div>
                            <label for="viskositas" class="block text-sm font-medium text-gray-700">Viskositas</label>
                            <input type="text" name="viskositas" id="viskositas"
                                class="block w-full mt-1 border border-gray-300 rounded-lg shadow-sm py-2 px-3"
                                placeholder="Masukkan viskositas..." required>
                        </div>
                        <div id="spesifikasiContainer">
    <label for="spesifikasi_lain" class="block text-sm font-medium text-gray-700">Spesifikasi Lain Lain</label>
    <input type="text" name="spesifikasi lain-Lain" id="spesifikasi_lain"
        class="block w-full mt-1 border border-gray-300 rounded-lg shadow-sm py-2 px-3"
        placeholder="Masukkan spesifikasi lain-Lain...">
</div>

                    </div>
                </div>
            </div>


            <div class="mt-8">
                <h3 class="text-xl font-bold mb-4">Spesifikasi Tambahan</h3>
                <div id="spesifikasi_lain_container">
                    <!-- Form spesifikasi tambahan akan ditambahkan di sini oleh JavaScript -->
                </div>
                <button type="button" id="add_spesifikasi_lain_button"
                    class="mt-2 px-4 py-2 font-bold bg-blue-500 text-white rounded hover:bg-blue-600">
                    + Tambah Spesifikasi Tambahan
                </button>
            </div>



            <!-- Tombol Simpan -->
            <br>
            <div>
                <button type="submit" class="w-full font-bold px-4 py-2 text-white rounded-lg" style="background-color: #032859;">
                    Simpan
                </button>
                <a href="{{ route('master_formula_sample.index') }}"
                    class="w-full font-bold px-4 py-2 text-white rounded-lg bg-gray-500 hover:bg-gray-600 mt-2 inline-block text-center" style="background-color: #032859;">
                    Batal
                </a>
            </div>
    </div>
    </form>
</div>
</div>

<!-- CSS -->
<style>
    .grid-cols-2 {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 2rem;
    }

    @media (max-width: 768px) {
        .grid-cols-2 {
            grid-template-columns: 1fr;
        }
    }

    th {
        white-space: nowrap;
        /* Tetap dalam satu baris */
    }

    .overflow-x-auto {
        overflow-x: auto;
        /* Aktifkan scroll horizontal */
    }

    tbody td {
        font-size: 14px;
        /* Ukuran font lebih kecil hanya untuk data di tbody */
    }

    /* Lebarkan Kolom HPP */
    .hpp-col {
        width: 150px;
        /* Lebar tetap untuk HPP */
        min-width: 150px;
    }

    .jumlah-col {
        width: 130px;
        /* Lebar tetap untuk Jumlah */
        min-width: 130px;
    }

    .jumlah-input {
        width: 100%;
        /* Input dalam kolom Jumlah */
        box-sizing: border-box;
    }

    #search_table_container {
        max-height: 300px;
        /* Batas tinggi tabel */
        overflow-y: auto;
        /* Aktifkan scroll vertikal */
        border: 1px solid #ccc;
        /* Tambahkan border untuk kejelasan */
        border-radius: 8px;
        /* Opsional: Membuat sudut tabel lebih rapi */
    }

    .prosedur-item {
        display: grid;
        grid-template-columns: 1fr 1fr;
        /* Dua kolom untuk Premix dan Prosedur */
        gap: 1rem;
        /* Jarak antar kolom */
        margin-bottom: 1rem;
        /* Jarak antar item */
    }

    .remove-prosedur-button {
        grid-column: span 2;
        /* Memanjang di kedua kolom */
        justify-self: start;
        /* Posisi tombol di kiri */
        margin-top: 0.5rem;
        /* Jarak atas untuk tombol */
        background-color: #e3342f;
        /* Warna merah untuk tombol hapus */
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 5px;
        font-weight: bold;
        cursor: pointer;
    }

    .remove-prosedur-button:hover {
        background-color: #cc1f1a;
        /* Warna merah lebih gelap saat hover */
    }
    .remove-spesifikasi-tambahan-butto {
        grid-column: span 2;
        /* Memanjang di kedua kolom */
        justify-self: start;
        /* Posisi tombol di kiri */
        margin-top: 0.5rem;
        /* Jarak atas untuk tombol */
        background-color: #e3342f;
        /* Warna merah untuk tombol hapus */
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 5px;
        font-weight: bold;
        cursor: pointer;
    }

    .remove-spesifikasi-tambahan-butto:hover {
        background-color: #cc1f1a;
        /* Warna merah lebih gelap saat hover */
    }

    .spesifikasi-item {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        /* Dua kolom */
        gap: 1rem;
        /* Jarak antar kolom */
        margin-bottom: 1rem;
        /* Jarak antar item */
    }

    .remove-spesifikasi-button {
        grid-column: span 2;
        /* Memanjang di kedua kolom */
        justify-self: start;
        /* Posisi tombol di kiri */
        margin-top: 0.5rem;
        /* Jarak atas untuk tombol */
        background-color: #e3342f;
        /* Warna merah untuk tombol hapus */
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 5px;
        font-weight: bold;
        cursor: pointer;
    }

    .remove-spesifikasi-button:hover {
        background-color: #cc1f1a;
        /* Warna merah lebih gelap saat hover */
    }
    #spesifikasiContainer {
        display: none; /* Sembunyikan elemen */
    }
    .remove-spesifikasi-tambahan-button {
    display: inline-block;
    margin-top: 0.5rem;
    background-color: #e3342f; /* Warna merah */
    color: white;
    padding: 0.5rem 1rem;
    border-radius: 5px;
    font-weight: bold;
    text-align: center;
    cursor: pointer;
    transition: background-color 0.3s ease; /* Animasi saat hover */
}

.remove-spesifikasi-tambahan-button:hover {
    background-color: #cc1f1a; /* Warna merah lebih gelap saat hover */
    color: #ffffff; /* Pastikan teks tetap putih */
}
button.ml-2.px-4.py-2.font-bold.bg-red-500.text-white.rounded.hover\:bg-red-600.py-1 {
    display: inline-block;
    margin-top: 0.5rem;
    background-color: #e3342f; /* Warna merah untuk tombol hapus */
    color: white; /* Warna teks */
    padding: 0.5rem 1rem; /* Padding dalam tombol */
    border-radius: 5px; /* Membulatkan sudut tombol */
    font-weight: bold; /* Teks lebih tebal */
    text-align: center; /* Teks di tengah */
    cursor: pointer; /* Tunjukkan tombol dapat diklik */
    transition: background-color 0.3s ease; /* Animasi transisi warna */
}

button.ml-2.px-4.py-2.font-bold.bg-red-500.text-white.rounded.hover\:bg-red-600.py-1:hover {
    background-color: #cc1f1a; /* Warna merah lebih gelap saat hover */
    color: #ffffff; /* Pastikan teks tetap putih */
}
.radio-box {
    border: 2px solid #ccc;
    transition: all 0.3s ease;
}

.radio-box.active {
    border-color: #2563eb;
    background-color: #eff6ff;
    box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.2);
    font-weight: bold;
}

/* Style form Select2 */
.select2-container--default .select2-selection--single {
    height: 42px;
    border-radius: 0.5rem;
    border: 1px solid #d1d5db;
    padding: 0.25rem 0.75rem;
}
.select2-selection__rendered {
    line-height: 42px;
}
.select2-selection__arrow {
    height: 42px !important;
}

</style>
<script src="{{ asset('Modal/select2.js') }}" defer></script>
<!-- Script -->
<script>

document.addEventListener('DOMContentLoaded', function () {
    const kodeSampleInput = document.getElementById('kode_sample');
    const nomorFormulaInput = document.getElementById('nomor_formula');
    const merkSelect = document.getElementById('merk');
    const nextSampleNumber = parseInt(kodeSampleInput.dataset.next || "1");
    const nextFormulaNumber = parseInt("{{ $nextFormulaNumber }}");



    // Saat halaman pertama kali dimuat, jika merk sudah dipilih sebelumnya
    if (merkSelect.value) {
        generateKodeSampleDanNomorFormula(merkSelect.value);
    }

    // Saat merk dipilih
    merkSelect.addEventListener('change', function () {
    const merk = this.value;

    if (merk) {
        fetch(`/generate-kode-sample?merk=${merk}`)
            .then(response => response.json())
            .then(data => {
    const kodeSample = data.kode_sample; // ✅ Langsung pakai dari controller
    const nomorFormula = `MFS/${kodeSample}`;

    kodeSampleInput.value = kodeSample;
    nomorFormulaInput.value = nomorFormula;
})


            .catch(error => {
                console.error('Error fetching kode sample:', error);
                kodeSampleInput.value = '';
                nomorFormulaInput.value = '';
            });
    } else {
        kodeSampleInput.value = '';
        nomorFormulaInput.value = '';
    }
});


    // Jika kode sample diubah manual (tidak wajib karena readonly)
    kodeSampleInput.addEventListener('input', function () {
        const kodeSample = kodeSampleInput.value;
        nomorFormulaInput.value = `MFS/${kodeSample}`;

    });
    /* Pencarian Data Bahan Baku */
    document.getElementById('search_button').addEventListener('click', function() {
        const query = document.getElementById('search_bahan_baku').value.trim();

        if (query) {
            fetch(`{{ url('search-bahan-baku') }}?q=${encodeURIComponent(query)}`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest' // Pastikan AJAX request dikenali backend
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Gagal mengambil data!');
                    }
                    return response.json();
                })
                .then(data => {
                    const resultsTable = document.getElementById('search_results');
                    const tableContainer = document.getElementById('search_table_container');
                    resultsTable.innerHTML = ''; // Kosongkan tabel sebelumnya

                    // Tampilkan tabel pencarian
                    tableContainer.classList.remove('hidden');

                    if (data.length > 0) {
                        data.forEach(item => {
                            const row = `
                        <tr data-kode="${item.kode}" data-nama="${item.raw_material}" data-function="${item.function}" data-supplier="${item.supplier}" data-satuan="${item.nama_satuan}" data-qty="${item.qty}" data-harga="${item.harga_akhir}">
                            <td class="border border-gray-300 px-4 py-2" align="center">${item.kode}</td>
                            <td class="border border-gray-300 px-4 py-2" align="center">${item.raw_material}</td>
                        </tr>
                    `;
                            resultsTable.insertAdjacentHTML('beforeend', row);
                        });
                    } else {
                        // Jika data tidak ditemukan
                        resultsTable.innerHTML = `
                    <tr>
                        <td colspan="2" class="text-center py-4">Data Tidak Ditemukan</td>
                    </tr>
                `;
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat mencari data.');
                });
        } else {
            alert('Harap masukkan kata kunci pencarian!');
        }
    });

    // Tambahkan event listener untuk klik baris hasil pencarian
    document.getElementById('search_results').addEventListener('click', function(event) {
        const row = event.target.closest('tr');
        if (row) {
            const kode = row.dataset.kode;
            const nama = row.dataset.nama;
            const functionName = row.dataset.function;
            const supplier = row.dataset.supplier;
            const satuan = row.dataset.satuan;
            const qty = row.dataset.qty;
            const harga = row.dataset.harga;

            addToDetail(kode, nama, functionName, supplier, satuan, qty, harga);
        }
    });

    function addToDetail(kode, nama, functionName, supplier, satuan, qty, hargaAkhir) {
        const detailResults = document.getElementById('detail_results');
        const rowCount = detailResults.querySelectorAll('tr').length;

        // Hapus baris "Data belum tersedia" jika ada data yang ditambahkan
        const emptyRow = detailResults.querySelector('tr td[colspan="5"]');
        if (emptyRow) {
            emptyRow.parentElement.remove();
        }

        const row = `
        <tr>
            <td class="border border-gray-300 px-4 py-2">${rowCount + 1}</td>
            <td class="border border-gray-300 px-4 py-2"><input type="text" name="premix[]" class="border rounded px-2 py-1 w-full" placeholder="Masukkan premix"></td>
            <td class="border border-gray-300 px-4 py-2">${kode}<input type="hidden" name="kode_bahan_baku[]" value="${kode}"></td>
            <td class="border border-gray-300 px-4 py-2">${nama}<input type="hidden" name="nama_bahan_baku[]" value="${nama}"></td>
            <td class="border border-gray-300 px-4 py-2">${functionName}<input type="hidden" name="function[]" value="${functionName}"></td>
            <td class="border border-gray-300 px-4 py-2">${supplier}<input type="hidden" name="supplier[]" value="${supplier}"></td>
            

            <td class="jumlah-col border border-gray-300 px-4 py-2">
                <input type="number" name="jumlah[]" class="jumlah-input border rounded px-2 py-1" placeholder="Masukkan jumlah" step="0.01">
            </td>

            <td class="border border-gray-300 px-4 py-2">
    <select name="satuan[]" class="border rounded px-2 py-1 w-full satuan-select">
        <option value="" selected disabled>Pilih Satuan</option>
        @foreach ($satuanList as $satuan)
            <option value="{{ $satuan->id }}">{{ $satuan->nama_satuan }}</option>
        @endforeach
    </select>
</td>
            <td class="border border-gray-300 px-4 py-2 hidden">${formatRupiah(hargaAkhir)}</td>
            <td class="hpp-col border border-gray-300 px-4 py-2 hpp-cell">-</td>
            <td class="hidden"><input type="text" class="hpp-cell-input border rounded px-2 py-1" name="hpp[]"></td>
            <td class="border border-gray-300 px-4 py-2">
               <button type="button" class="ml-2 px-4 py-2 font-bold bg-red-500 text-white rounded hover:bg-red-600 py-1" onclick="removeBahanBakuRow(this)">Hapus</button>

            </td>
        </tr>
        `;

        detailResults.insertAdjacentHTML('beforeend', row);
        updateRowNumbers();

        // Tambahkan perhitungan HPP saat jumlah diubah
        const jumlahInput = detailResults.querySelector('tr:last-child .jumlah-input');
        jumlahInput.addEventListener('input', function() {
            calculateHPP(jumlahInput);
            calculateTotals(); // Hitung ulang total setelah HPP diperbarui
        });

        calculateTotals(); // Hitung total setelah menambah data
    }

    function updateRowNumbers() {
        const detailResults = document.getElementById('detail_results');
        const rows = detailResults.querySelectorAll('tr');

        rows.forEach((row, index) => {
            const firstCell = row.querySelector('td');
            if (firstCell) {
                firstCell.textContent = index + 1;
            }
        });
    }

    function removeRow(button) {
        const row = button.parentElement.parentElement;
        row.remove();
        updateRowNumbers();
        calculateTotals(); // Perbarui total setelah baris dihapus
    }

    function calculateHPP(input) {
    const row = input.closest('tr');
    const jumlahValue = parseFloat(input.value) || 0; // Ambil nilai jumlah sebagai angka
    const hargaAkhirValue = parseFloat(row.querySelector('td:nth-child(9)').innerText.replace(/[^0-9.-]+/g, "")) || 0;

    const hppCell = row.querySelector('.hpp-cell');
    const hppCellInput = row.querySelector('.hpp-cell-input');

    if (jumlahValue > 0 && hargaAkhirValue > 0) {
        // Perhitungan HPP
        const hpp = (jumlahValue / 1000) * hargaAkhirValue; // Contoh: Konversi ke gram
        hppCell.textContent = hpp.toFixed(3); // Tampilkan hasil dengan 3 desimal
        hppCellInput.value = hpp.toFixed(3); // Simpan hasil dengan 3 desimal
    } else {
        hppCell.textContent = '-';
        hppCellInput.value = '';
    }
}

function calculateTotals() {
    const rows = document.querySelectorAll('#detail_results tr');
    let totalJumlah = 0;
    let totalHPP = 0;

    rows.forEach(row => {
        const jumlahInput = row.querySelector('.jumlah-input');
        const hppCell = row.querySelector('.hpp-cell');

        if (jumlahInput && hppCell) {
            const jumlahValue = parseFloat(jumlahInput.value) || 0;
            const hppValue = parseFloat(hppCell.textContent.replace(/[^0-9.-]+/g, "")) || 0;

            totalJumlah += jumlahValue;
            totalHPP += hppValue;
        }
    });

    // Update nilai total
    document.getElementById('total_jumlah').textContent = totalJumlah.toFixed(3); // Tampilkan hingga 3 desimal
    document.getElementById('total_jumlah_input').value = totalJumlah;
    document.getElementById('total_hpp').textContent = totalHPP.toFixed(3); // Tampilkan hingga 3 desimal
    document.getElementById('total_hpp_input').value = totalHPP;
}


    function formatRupiah(angka, prefix = 'Rp') {
        const numberString = angka.toString().replace(/[^,\d]/g, '');
        const split = numberString.split(',');
        const sisa = split[0].length % 3;
        let rupiah = split[0].substr(0, sisa);
        const ribuan = split[0].substr(sisa).match(/\d{3}/g);

        if (ribuan) {
            const separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }

        return prefix + ' ' + rupiah + (split[1] ? ',' + split[1] : '');
    }

    function parseRupiah(rupiah) {
        return parseFloat(rupiah.replace(/[^\d,.-]+/g, '').replace(',', '.')) || 0;
    }
});

    
    
    // Hitung HPP dengan benar
    function calculateHPP(input) {
    const row = input.closest('tr');
    const jumlahValue = parseFloat(input.value) || 0; // Ambil nilai jumlah sebagai angka desimal
    const hargaAkhirValue = parseFloat(row.querySelector('td:nth-child(9)').innerText.replace(/[^0-9.-]+/g, "")) || 0;

    const hppCell = row.querySelector('.hpp-cell');
    const hppCellInput = row.querySelector('.hpp-cell-input');

    if (jumlahValue > 0 && hargaAkhirValue > 0) {
        // Rumus HPP: (jumlah * harga akhir)
        const hpp = (jumlahValue / 1000) * hargaAkhirValue; // Misalnya konversi ke gram atau unit kecil lainnya
        hppCell.textContent = formatRupiah(hpp.toFixed(2)); // Format ke 2 desimal
        hppCellInput.value = hpp;
    } else {
        hppCell.textContent = '-';
        hppCellInput.value = '';
    }
}

    // Perbarui Nomor Baris
    function updateRowNumbers() {
        const detailResults = document.getElementById('detail_results');
        const rows = detailResults.querySelectorAll('tr:not(.empty-row)'); // Abaikan baris dengan kelas "empty-row"

        // Hapus semua baris yang ada di tabel jika tabel kosong
        if (rows.length === 0) {
            detailResults.innerHTML = ''; // Kosongkan tabel tanpa menambahkan baris kosong
        } else {
            rows.forEach((row, index) => {
                const firstCell = row.querySelector('td');
                if (firstCell) {
                    firstCell.textContent = index + 1; // Perbarui nomor baris
                }
            });
        }
    }


    // Fungsi untuk Menghitung Total Jumlah dan Total HPP
    function calculateTotals() {
    const rows = document.querySelectorAll('#detail_results tr');
    let totalJumlah = 0;
    let totalHPP = 0;

    rows.forEach(row => {
        const jumlahInput = row.querySelector('.jumlah-input'); // Input jumlah
        const hppCell = row.querySelector('.hpp-cell'); // HPP Cell

        if (jumlahInput && hppCell) {
            const jumlahValue = parseFloat(jumlahInput.value) || 0;
            const hppValue = parseFloat(hppCell.textContent.replace(/[^0-9.-]+/g, "")) || 0;

            totalJumlah += jumlahValue; // Total jumlah
            totalHPP += hppValue; // Total HPP
        }
    });

    // Update nilai total di elemen HTML
    document.getElementById('total_jumlah').textContent = totalJumlah.toFixed(2); // Jumlah desimal
    document.getElementById('total_jumlah_input').value = totalJumlah; // Input jumlah
    document.getElementById('total_hpp').textContent = formatRupiah(totalHPP); // Total HPP
    document.getElementById('total_hpp_input').value = totalHPP; // Input HPP
}


  

    function initializeScroll() {
        const tableContainer = document.getElementById('search_table_container');
        tableContainer.classList.remove('hidden'); // Pastikan tabel tampil
        tableContainer.style.maxHeight = '300px'; // Maksimal tinggi tabel
        tableContainer.style.overflowY = 'auto'; // Aktifkan scroll vertikal
    }


    /* Add Form Prosedur */
    document.addEventListener('DOMContentLoaded', function() {
        let prosedurCount = 0; // Mulai dari 0 karena form pertama ditambahkan oleh tombol

        // Tambahkan form prosedur kerja baru
        document.getElementById('add_prosedur_button').addEventListener('click', function() {
            prosedurCount++;
            const prosedurContainer = document.getElementById('prosedur_kerja_container');

            const newProsedurForm = document.createElement('div');
            newProsedurForm.className = 'prosedur-item'; // Tambahkan kelas untuk grid layout
            newProsedurForm.innerHTML = `

            <!-- Kolom Kanan -->
            <div>
                <label for="prosedur_kerja_${prosedurCount}" class="block text-sm font-medium text-gray-700">Prosedur Kerja</label>
                <input type="text" name="prosedur_kerja[]" id="prosedur_kerja_${prosedurCount}"
                       class="block w-full mt-1 border border-gray-300 rounded-lg shadow-sm py-2 px-3"
                       placeholder="Masukkan prosedur kerja..." required>
            </div>

            <!-- Tombol Hapus -->
            <button type="button" class="remove-prosedur-button ">
                Hapus
            </button>
        `;

            prosedurContainer.appendChild(newProsedurForm);

            // Event Listener untuk tombol hapus
            const removeButton = newProsedurForm.querySelector('.remove-prosedur-button');
            removeButton.addEventListener('click', function() {
                newProsedurForm.remove(); // Hapus form terkait
            });
        });
    });

    document.addEventListener('DOMContentLoaded', function() {
    let spesifikasiTambahanCount = 0; // Counter untuk form spesifikasi tambahan

    // Tambahkan form spesifikasi tambahan baru
    document.getElementById('add_spesifikasi_lain_button').addEventListener('click', function() {
        spesifikasiTambahanCount++;
        const spesifikasiTambahanContainer = document.getElementById('spesifikasi_lain_container');

        const newSpesifikasiTambahanForm = document.createElement('div');
        newSpesifikasiTambahanForm.className = 'spesifikasi-tambahan-item mt-4'; // Tambahkan kelas untuk styling
        newSpesifikasiTambahanForm.innerHTML = `
            <div class="grid grid-cols-2 gap-4">
                <!-- Data Spesifikasi Tambahan -->
                <div>
                    <label for="spesifikasi_tambahan_${spesifikasiTambahanCount}" class="block text-sm font-medium text-gray-700">Data Spesifikasi Tambahan</label>
                    <input type="text" name="spesifikasi_tambahan[]" id="spesifikasi_tambahan_${spesifikasiTambahanCount}"
                           class="block w-full mt-1 border border-gray-300 rounded-lg shadow-sm py-2 px-3"
                           placeholder="Masukkan data spesifikasi tambahan..." required>
                </div>

                <!-- Hasil -->
                <div>
                    <label for="hasil_spesifikasi_tambahan_${spesifikasiTambahanCount}" class="block text-sm font-medium text-gray-700">Hasil</label>
                    <input type="text" name="hasil_spesifikasi_tambahan[]" id="hasil_spesifikasi_tambahan_${spesifikasiTambahanCount}"
                           class="block w-full mt-1 border border-gray-300 rounded-lg shadow-sm py-2 px-3"
                           placeholder="Masukkan hasil spesifikasi tambahan..." required>
                </div>
            </div>

            <!-- Tombol Hapus -->
         <button type="button" class="remove-spesifikasi-tambahan-button">
                Hapus
            </button>
        `;

        spesifikasiTambahanContainer.appendChild(newSpesifikasiTambahanForm);

        // Event Listener untuk tombol hapus
        const removeButton = newSpesifikasiTambahanForm.querySelector('.remove-spesifikasi-tambahan-button');
        removeButton.addEventListener('click', function() {
            newSpesifikasiTambahanForm.remove(); // Hapus form terkait
        });
    });
});
function removeBahanBakuRow(button) {
    // Dapatkan elemen baris tempat tombol diklik
    const row = button.closest('tr');

    // Hapus baris dari tabel
    row.remove();

    // Perbarui penomoran ulang baris
    updateBahanBakuRowNumbers();

    // Perbarui total jumlah dan total HPP setelah baris dihapus
    calculateTotals();
}

function updateBahanBakuRowNumbers() {
    // Ambil semua baris pada tabel detail bahan baku
    const rows = document.querySelectorAll('#detail_results tr');

    // Perbarui nomor setiap baris
    rows.forEach((row, index) => {
        const numberCell = row.querySelector('td:first-child');
        if (numberCell) {
            numberCell.textContent = index + 1; // Perbarui nomor sesuai indeks (dimulai dari 1)
        }
    });
}

function toggleJenisFormula(value) {
    const cariForm = document.getElementById('form_cari_kode_sample');
    const formMerk = document.getElementById('form_pilih_merk');
    const kodeSampleInput = document.getElementById('kode_sample');
    const nomorFormulaInput = document.getElementById('nomor_formula');
    const resultKodeSampleContainer = document.getElementById('result_kode_sample_container');
    const merk = document.getElementById('merk').value;

    if (value === 'revisi') {
        cariForm.classList.remove('hidden');  // tampilkan form input pencarian
        formMerk.classList.add('hidden');     // sembunyikan field merk
        kodeSampleInput.value = '';
        nomorFormulaInput.value = '';
        resultKodeSampleContainer.classList.remove('hidden'); // tampilkan tabel hasil pencarian jika ada
    } else {
        cariForm.classList.add('hidden');     // sembunyikan form pencarian
        formMerk.classList.remove('hidden');  // tampilkan field merk
        resultKodeSampleContainer.classList.add('hidden');    // sembunyikan tabel pencarian
        if (merk) {
            generateKodeSampleDanNomorFormula(merk);
        }
    }
}


function generateKodeSampleDanNomorFormula(singkatanMerk) {
    const kodeSampleInput = document.getElementById('kode_sample');
    const nomorFormulaInput = document.getElementById('nomor_formula');
    const nextSampleNumber = parseInt(kodeSampleInput.dataset.next || "1");

    const now = new Date();
    const bulan = String(now.getMonth() + 1).padStart(2, '0');
    const tahun = String(now.getFullYear()).slice(-2);
    const nomorUrut = String(nextSampleNumber).padStart(3, '0');

    // Contoh: IMO-0425-004
    const kodeSampleBase = `${singkatanMerk}-${bulan}${tahun}-${nomorUrut}`;
    const kodeSample = `${kodeSampleBase}/R0`; // Format tampilan di input kode sample
    const nomorFormula = `MFS/${kodeSample}`;   // Format tampilan di input nomor formula

    kodeSampleInput.value = kodeSample;
    nomorFormulaInput.value = nomorFormula;
}


// Fungsi pencarian kode sample revisi
document.getElementById('btnCariKodeSample').addEventListener('click', function () {
    const keyword = document.getElementById('cari_kode_sample').value.trim();
    const resultContainer = document.getElementById('result_kode_sample_container');
    const resultBody = document.getElementById('result_kode_sample_body');

    if (!keyword) {
        alert('Masukkan kode sample yang ingin direvisi!');
        return;
    }

    fetch(`/cek-kode-sample-revisi?kode_sample=${keyword}`)
        .then(res => res.json())
        .then(data => {
            if (data.success && data.data.length > 0) {
                resultBody.innerHTML = '';
                data.data.forEach(sample => {
                    const row = `
                        <tr>
                            <td class="border px-4 py-2 text-center">${sample}</td>
                            <td class="border px-4 py-2 text-center">
                                <button type="button" class="bg-blue-500 text-white px-3 py-1 rounded" onclick="selectKodeSample('${sample}')">
                                    Pilih
                                </button>
                            </td>
                        </tr>
                    `;
                    resultBody.insertAdjacentHTML('beforeend', row);
                });
                resultContainer.classList.remove('hidden');
            } else {
                resultBody.innerHTML = `<tr><td colspan="2" class="text-center py-4">Tidak ditemukan</td></tr>`;
                resultContainer.classList.remove('hidden');
            }
        })
        .catch(err => {
            console.error('Gagal fetch kode sample:', err);
            alert('Terjadi kesalahan saat mengambil data.');
        });
});

function selectKodeSample(kodeSampleBase) {
    fetch(`/get-revisi-terakhir?kode_sample=${kodeSampleBase}`)
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                const revisiKe = data.revisi_ke;

                const fullKodeSample = `${kodeSampleBase}-R${revisiKe}`;
                const fullNomorFormula = `MFS/${fullKodeSample}`;

                // Masukkan ke input
                document.getElementById('kode_sample').value = fullKodeSample;
                document.getElementById('nomor_formula').value = fullNomorFormula;
            } else {
                alert('Gagal mendapatkan revisi terakhir!');
            }
        })
        .catch(err => {
            console.error('Error mengambil revisi terakhir:', err);
            alert('Terjadi kesalahan saat mengambil revisi.');
        });
}

function updateRadioStyle(radio) {
    const radioBoxes = document.querySelectorAll('.radio-box');
    radioBoxes.forEach(box => box.classList.remove('active'));

    const parent = radio.closest('.radio-box');
    if (radio.checked) {
        parent.classList.add('active');
    }
}

// Setel default saat pertama kali load
document.addEventListener('DOMContentLoaded', () => {
    const selectedRadio = document.querySelector('input[name="jenis_formula"]:checked');
    if (selectedRadio) {
        updateRadioStyle(selectedRadio);
    }

    document.querySelectorAll('.radio-box').forEach(box => {
        box.addEventListener('click', function () {
            const input = this.querySelector('input[type="radio"]');
            if (!input.checked) {
                input.checked = true;
                input.dispatchEvent(new Event('change'));
            }
        });
    });
});


</script>
@endsection