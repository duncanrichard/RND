@extends('layout.main')

@section('content')
<div class="w-full px-6 py-6 mx-auto mt-10">
    <div class="bg-white shadow-lg rounded-lg p-6">
        <h2 class="text-2xl font-bold mb-4">Tambah Formula Produk Jadi</h2>
        <form action="{{ route('master_formula_produk.store') }}" method="POST">
            @csrf
            <!-- Form Pencarian -->
            <div id="searchForm" method="GET" class="mb-6">
                <div class="flex items-center gap-4">
                    <div class="flex-grow">
                        <label for="search" class="block font-semibold mb-1">Cari Produk Jadi</label>
                        <input type="text" name="search" id="search" class="w-full border p-2 rounded-lg" placeholder="Masukkan Nama Produk">
                    </div>
                    <button type="button" id="searchButton" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">Cari</button>
                </div>
            </div>
            <br>
            <!-- Tabel Hasil Pencarian -->
            <div class="overflow-x-auto mb-6">
                <div class="overflow-y-auto max-h-64">
                    <table class="min-w-full bg-white border border-gray-300 rounded-lg">
                        <thead class="bg-gray-200 text-gray-700">
                            <tr>
                                <th class="py-2 px-4 text-left border-b">Kode Produk</th>
                                <th class="py-2 px-4 text-left border-b">Nama Merk</th>
                                <th class="py-2 px-4 text-left border-b">Kategori</th>
                                <th class="py-2 px-4 text-left border-b">Nama Produk</th>
                            </tr>
                        </thead>
                        <tbody id="search_results">
                            <tr>
                                <td colspan="4" class="py-4 px-6 text-center text-gray-500">Silakan cari produk terlebih dahulu...</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>


            <div class="grid grid-cols-2 gap-4">
                <!-- Kolom Kiri -->
                <div>
                <div class="mb-4">
                    <label for="nomor_formula" class="block font-semibold">Nomor Formula Produk</label>
                    <input type="text" name="nomor_formula" id="nomor_formula" class="w-full border p-2 rounded-lg" readonly required>
                </div>

                    <input type="text" name="kode_produk_id" id="id_kode_produk" required>


                    <div class="mb-4">
                        <label for="tanggal" class="block font-semibold">Tanggal</label>
                        <input type="date" name="tanggal" id="tanggal" class="w-full border p-2 rounded-lg" value="{{ now()->format('Y-m-d') }}" readonly required>
                    </div>

                    <div class="mb-4">
                        <label for="id_input" class="block font-semibold">ID Input</label>
                        <input type="text" name="id_input" id="id_input" class="w-full border p-2 rounded-lg" value="{{ Auth::user()->username }}" readonly required>
                    </div>

                    <div class="mb-4">
                        <label for="kode_produk" class="block font-semibold">Kode Produk</label>
                        <!-- <input type="hidden" name="id_kode_produk" id="id_kode_produk" class="w-full border p-2 rounded-lg" required> -->
                        <input type="text" name="kode_produk" id="kode_produk" class="w-full border p-2 rounded-lg" required readonly>
                    </div>
                    <div class="mb-4">
                        <label for="netto" class="block font-semibold">Netto</label>
                        <input type="text" name="netto" id="netto" class="w-full border p-2 rounded-lg" required readonly>
                    </div>
                </div>

                <!-- Kolom Kanan -->
                <div>
                    <div class="mb-4">
                        <label for="nama_merek" class="block font-semibold">Nama Merek</label>
                        <input type="text" name="nama_merek" id="nama_merek" class="w-full border p-2 rounded-lg" required readonly>
                    </div>

                    <div class="mb-4">
                        <label for="kategori" class="block font-semibold">Kategori</label>
                        <input type="text" name="kategori" id="kategori" class="w-full border p-2 rounded-lg" required readonly>
                    </div>

                    <div class="mb-4">
                        <label for="nama_produk" class="block font-semibold">Nama Produk</label>
                        <input type="text" name="nama_produk" id="nama_produk" class="w-full border p-2 rounded-lg" required readonly>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <!-- Form Batch Size Berat -->
                        <div class="mb-4">
                            <label for="batch_size_berat" class="block font-semibold">Batch Size Berat</label>
                            <input type="number" name="batch_size_berat" id="batch_size_berat" min='0' class="w-full border p-2 rounded-lg" required>
                        </div>

                        <!-- Form Satuan Berat -->
                        <div class="mb-4">
                            <label for="satuan_berat" class="block font-semibold">Satuan Berat</label>
                            <input type="text" name="satuan_berat" id="satuan_berat" class="w-full border p-2 rounded-lg" value='Gram' readonly required>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="mb-4">
                            <label for="batch_size_satuan" class="block font-semibold">Batch Size Satuan</label>
                            <input type="number" name="batch_size_satuan" id="batch_size_satuan" class="w-full border p-2 rounded-lg" readonly required>
                            
                        </div>
                        <div class="mb-4">
                            <label for="jenis_satuan" class="block font-semibold">Jenis Satuan</label>
                            <input type="text" name="jenis_satuan" id="jenis_satuan" class="w-full border p-2 rounded-lg" value='PCS' readonly required>
                        </div>
                    </div>

                </div>
            </div>


            <!-- PENCARIAN BAHAN BAKU -->
            <div class="flex items-center gap-4">
                <div class="flex-grow">
                    <label for="search_bahan_baku" class="block font-semibold mb-1">Cari Bahan Baku</label>
                    <input type="text" id="search_bahan_baku" class="w-full border p-2 rounded-lg" placeholder="Masukkan Bahan Baku">
                </div>
                <button type="button" id="searchBahanBakuButton" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">Cari</button>
            </div>
            <br>
            <!-- Tabel Hasil Pencarian Bahan Baku -->
            <div class="overflow-x-auto mb-6">
                <div class="overflow-y-auto max-h-64">
                    <table class="min-w-full bg-white border border-gray-300 rounded-lg">
                        <thead class="bg-gray-200 text-gray-700">
                            <tr>
                                <th class="py-2 px-4 text-left border-b">Kode Bahan Baku</th>
                                <th class="py-2 px-4 text-left border-b">Nama Bahan Baku</th>
                                <th class="py-2 px-4 text-left border-b">Koding Bahan Baku</th>
                                <th class="py-2 px-4 text-left border-b">Nama Koding</th>
                            </tr>
                        </thead>
                        <tbody id="search_results_bahan_baku">
                            <tr>
                                <td colspan="3" class="py-4 px-6 text-center text-gray-500">Silakan cari bahan baku terlebih dahulu...</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Tabel Detail Bahan Baku -->
            <div class="overflow-x-auto mt-6">
                <table class="w-full border-collapse border border-gray-300">
                    <thead>
                        <tr class="bg-gray-100 text-left">
                            <th class="border border-gray-300 px-4 py-2">No</th>
                            <th class="border border-gray-300 px-4 py-2">Kode Bahan Baku</th>
                            <th class="border border-gray-300 px-4 py-2">Nama Koding Bahan Baku</th>
                            <th class="border border-gray-300 px-4 py-2">Satuan</th>
                            <th class="border border-gray-300 px-4 py-2">Jumlah</th>
                            <th class="border border-gray-300 px-4 py-2" hidden>HPBB</th>
                            <th class="border border-gray-300 px-4 py-2">HPP</th>
                            <th class="border border-gray-300 px-4 py-2">Action</th>
                        </tr>
                    </thead>
                    <tbody id="detail_results">
                        <tr class="no-data-row">
                            <td colspan="7" class="text-center py-4 text-gray-500">Data belum tersedia</td>
                        </tr>
                    </tbody>

                </table>
                <!-- Perhitungan Total -->
                <div class="mt-4">
                    <h3 class="text-xl font-bold mb-2">Total Data Bahan Baku</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="flex justify-between items-center">
                            <span class="font-medium">Total Jumlah:</span>
                            <span id="total_jumlah_input_bahan_baku" class="font-bold">0</span>
                            <input type="hidden" id="total_jumlah_input_bahan_baku_value" name="total_jumlah_input_bahan_baku" value="0" placeholder="">
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="font-medium">Total HPP:</span>
                            <span id="total_hpp_input_bahan_baku" class="font-bold">0 </span>
                            <input type="hidden" id="total_hpp_input_bahan_baku_value" name="total_hpp_input_bahan_baku" value="0" placeholder="">
                        </div>
                    </div>
                </div>
            </div>
            <br>

            <!-- Form Pencarian Bahan Kemas -->
            <div class="flex items-center gap-4">
                <div class="flex-grow">
                    <label for="search_bahan_kemas" class="block font-semibold mb-1">Cari Bahan Kemas</label>
                    <input type="text" id="search_bahan_kemas" class="w-full border p-2 rounded-lg" placeholder="Masukkan Nama Bahan Kemas">
                </div>
                <button type="button" id="searchBahanKemasButton" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">Cari</button>
            </div>
            <br>
            <!-- Tabel Hasil Pencarian Bahan Kemas -->
            <div class="overflow-x-auto mb-6">
                <div class="overflow-y-auto max-h-64">
                    <table class="min-w-full bg-white border border-gray-300 rounded-lg">
                        <thead class="bg-gray-200 text-gray-700">
                            <tr>
                                <th class="py-2 px-4 text-left border-b">Kode Kemasan</th>
                                <th class="py-2 px-4 text-left border-b">Nama Kemasan</th>
                                <th class="py-2 px-4 text-left border-b">HPBK</th>
                            </tr>
                        </thead>
                        <tbody id="search_results_bahan_kemas">
                            <tr>
                                <td colspan="3" class="py-4 px-6 text-center text-gray-500">Silakan cari bahan kemas terlebih dahulu...</td>
                            </tr>
                        </tbody>

                    </table>
                </div>
            </div>
            <!-- Tabel Detail Bahan Baku -->
            <div class="overflow-x-auto mt-6">
                <table class="w-full border-collapse border border-gray-300">
                    <thead>
                        <tr class="bg-gray-100 text-left">
                            <th class="border border-gray-300 px-4 py-2">No</th>
                            <th class="border border-gray-300 px-4 py-2">Kode Bahan Kemas</th>
                            <th class="border border-gray-300 px-4 py-2">Nama Bahan Kemas</th>
                            <th class="border border-gray-300 px-4 py-2">Satuan</th>
                            <th class="border border-gray-300 px-4 py-2">Jumlah</th>
                            <th class="border border-gray-300 px-4 py-2 hidden">HPBK</th>
                            <th class="border border-gray-300 px-4 py-2">HPP</th>
                            <th class="border border-gray-300 px-4 py-2">Action</th>
                        </tr>
                    </thead>
                    <tbody id="detail_results_kemas">
                        <tr class="no-data-row">
                            <td colspan="7" class="text-center py-4 text-gray-500">Data belum tersedia</td>
                        </tr>
                    </tbody>

                </table>
                <!-- Perhitungan Total -->
                <div class="mt-4">
                    <h3 class="text-xl font-bold mb-2">Total</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="flex justify-between items-center">
                            <span class="font-medium">Total Jumlah:</span>
                            <span id="total_jumlah_input_bahan_kemas" class="font-bold">0</span>
                            <input type="hidden" id="total_jumlah_input_bahan_kemas_value" name="total_jumlah_input_bahan_kemas" value="" placeholder="">
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="font-medium">Total HPP:</span>
                            <span id="total_hpp_input_bahan_kemas" class="font-bold">0 </span>
                            <input type="hidden" id="total_hpp_input_bahan_kemas_value" name="total_hpp_input_bahan_kemas" value="" placeholder="">
                        </div>
                    </div>
                </div>
            </div>
            <!-- Tombol Aksi -->
            <div class="mt-6">
                <button type="submit" class="w-full font-bold px-4 py-2 text-white rounded-lg" style="background-color: #032859;">Simpan</button>
                <a href="{{ route('master_formula_produk.index') }}" class="w-full font-bold px-4 py-2 text-white rounded-lg bg-gray-500 hover:bg-gray-600 mt-2 inline-block text-center" style="background-color: #032859;">Batal</a>
            </div>
        </form>
    </div>
</div>
<style>
    .overflow-y-auto {
        overflow-y: auto;
    }

    .max-h-64 {
        max-height: 16rem;
    }

    .grid {
        display: grid;
    }

    .grid-cols-2 {
        grid-template-columns: 1fr 1fr;
    }

    .gap-4 {
        gap: 1rem;
    }

    .w-full {
        width: 100%;
    }

    .border {
        border: 1px solid #ccc;
    }

    .rounded-lg {
        border-radius: 0.5rem;
    }

    .p-2 {
        padding: 0.5rem;
    }

    .mb-4 {
        margin-bottom: 1rem;
    }

    .mt-6 {
        margin-top: 1.5rem;
    }

    .hover\:bg-blue-600:hover {
        background-color: #2563eb;
    }

    .hover\:bg-gray-600:hover {
        background-color: #4b5563;
    }

    .text-white {
        color: #fff;
    }

    .font-semibold {
        font-weight: 600;
    }

    .max-h-64 {
        max-height: 16rem;
        /* Maksimal tinggi tabel */
    }

    .min-w-full {
        width: 100%;
        /* Lebarkan tabel mengikuti lebar parent */
    }

    table {
        table-layout: auto;
        /* Kolom tabel akan menyesuaikan konten */
        border-collapse: collapse;
        /* Hilangkan jarak antar border */
    }

    th,
    td {
        text-align: left;
        /* Ratakan teks ke kiri */
        padding: 12px;
        /* Tambahkan padding agar lebih rapi */
    }

    th {
        background-color: #f1f5f9;
        /* Warna background untuk header */
        border-bottom: 2px solid #e2e8f0;
        /* Border bawah untuk header */
    }

    td {
        border-bottom: 1px solid #e2e8f0;
        /* Border bawah untuk setiap baris */
    }

    thead th {
        background-color: #f9fafb;
        text-align: left;
        border-bottom: 2px solid #e5e7eb;
        padding: 10px;
    }

    tbody td {
        padding: 10px;
        border-bottom: 1px solid #e5e7eb;
    }

    .hidden {
        display: none;
    }
</style>

<script>
    // Function untuk memuat data berdasarkan pencarian
    async function fetchProducts(search = '') {
        const tbody = document.getElementById('search_results');
        tbody.innerHTML = ''; // Reset tabel sebelum menampilkan data

        if (search === '') {
            tbody.innerHTML = `
            <tr>
                <td colspan="4" class="py-4 px-6 text-center text-gray-500">Silakan cari produk terlebih dahulu...</td>
            </tr>`;
            return;
        }

        try {
            const response = await fetch(`/master-formula-produk/get-products?search=${encodeURIComponent(search)}`);
            if (!response.ok) {
                throw new Error(`HTTP error! Status: ${response.status}`);
            }

            const data = await response.json();

            if (!data || data.length === 0) {
                tbody.innerHTML = `
                <tr>
                    <td colspan="4" class="py-4 px-6 text-center text-gray-500">Tidak ada data ditemukan...</td>
                </tr>`;
                return;
            }

            data.forEach(product => {
                const row = `
        <tr class="cursor-pointer" onclick="selectProduct('${product.id}', '${product.kode_produk_jadi}', '${product.nama_merek}', '${product.kategori}', '${product.nama_produk}', '${product.netto}')">
            <td class="py-2 px-4 border-b">${product.kode_produk_jadi}</td>
            <td class="py-2 px-4 border-b">${product.nama_merek}</td>
            <td class="py-2 px-4 border-b">${product.kategori}</td>
            <td class="py-2 px-4 border-b">${product.nama_produk}</td>
        </tr>`;
                tbody.innerHTML += row;
            });
        } catch (error) {
            console.error('Error fetching products:', error);
            alert('Gagal memuat data. Silakan coba lagi.');
        }
    }

    function generateNomorFormula(kodeProduk) {
        const currentDate = new Date();
        const month = (currentDate.getMonth() + 1).toString().padStart(2, '0'); // Bulan dalam format dua digit
        const year = currentDate.getFullYear().toString().slice(-2); // Tahun dua digit

        // Contoh nomor urut sementara, bisa digantikan dengan nomor urut dinamis dari database
        const nomorUrut = "000001";

        // Format Nomor Formula: MFP/Kode Produk/000001/072024
        const nomorFormula = `MFP/${kodeProduk}/${nomorUrut}/${month}${year}`;
        document.getElementById('nomor_formula').value = nomorFormula; // Set nilai pada form
    }

   async function fetchNomorFormula(kodeProduk) {
    if (!kodeProduk) {
        alert('Kode produk tidak ditemukan. Mohon pilih kode produk terlebih dahulu.');
        return;
    }

    try {
        const response = await fetch(`master-formula-produk/get-nomor-formula?kode_produk=${encodeURIComponent(kodeProduk)}`);
        if (!response.ok) {
            throw new Error(`HTTP error! Status: ${response.status}`);
        }

        const data = await response.json();

        if (data.nomor_formula) {
            document.getElementById('nomor_formula').value = data.nomor_formula;
        } else {
            throw new Error('Nomor formula tidak tersedia.');
        }
    } catch (error) {
        console.error('Error fetching nomor formula:', error);
        alert('Terjadi kesalahan saat mengambil nomor formula. Silakan coba lagi.');
        document.getElementById('nomor_formula').value = ''; // Kosongkan jika gagal
    }
}

// Event listener untuk perubahan pada input kode_produk
document.getElementById('kode_produk').addEventListener('input', (event) => {
    const kodeProduk = event.target.value.trim();
    fetchNomorFormula(kodeProduk);
});


function selectProduct(id, kode_produk, nama_merek, kategori, nama_produk, netto) {
    document.getElementById('id_kode_produk').value = id;
    document.getElementById('kode_produk').value = kode_produk;
    document.getElementById('nama_merek').value = nama_merek;
    document.getElementById('kategori').value = kategori;
    document.getElementById('nama_produk').value = nama_produk;
    document.getElementById('netto').value = netto;

    // Panggil API untuk mendapatkan nomor formula
    fetchNomorFormula(kode_produk);
}


    // Event listener untuk tombol pencarian
    document.getElementById('searchButton').addEventListener('click', () => {
        const search = document.getElementById('search').value;
        fetchProducts(search);
    });

    // Set tabel default kosong saat halaman pertama kali dimuat
    document.addEventListener('DOMContentLoaded', () => {
        fetchProducts();
    });

    /* FUNGSI UNTUK PENCARIAN BAHAN BAKU */
    async function fetchBahanBaku(search = '') {
    const tbody = document.getElementById('search_results_bahan_baku');
    tbody.innerHTML = ''; // Reset tabel sebelum menampilkan data

    if (search === '') {
        tbody.innerHTML = `
        <tr>
            <td colspan="6" class="py-4 px-6 text-center text-gray-500">Silakan cari bahan baku terlebih dahulu...</td>
        </tr>`;
        return;
    }

    try {
        const response = await fetch(`/master-formula-produk/get-bahan-baku?search=${encodeURIComponent(search)}`);
        if (!response.ok) {
            throw new Error(`HTTP error! Status: ${response.status}`);
        }

        const data = await response.json();

        if (!data || data.length === 0) {
            tbody.innerHTML = `
            <tr>
                <td colspan="6" class="py-4 px-6 text-center text-gray-500">Tidak ada data ditemukan...</td>
            </tr>`;
            return;
        }

        data.forEach(bahan => {
            const kodeBahanBaku = `${bahan.jenis_bahan_baku}${bahan.urutan_kode_bahan_baku}`;
            const row = `
    <tr class="cursor-pointer" onclick="selectBahanBaku('${bahan.id}', '${kodeBahanBaku}', '${bahan.nama_bahan_baku}', '${bahan.koding_bahan_baku}', '${bahan.nama_coding}', '${bahan.hpbb}', '${bahan.satuan}', '${bahan.jenis_bahan_baku}', this)">
    <td class="py-2 px-4 border-b">${kodeBahanBaku}</td>
        <td class="py-2 px-4 border-b">${bahan.nama_bahan_baku}</td>
        <td class="py-2 px-4 border-b">${bahan.koding_bahan_baku}</td>
        <td class="py-2 px-4 border-b">${bahan.nama_coding}</td>
    </tr>`;
            tbody.innerHTML += row;
        });

    } catch (error) {
        console.error('Error fetching bahan baku:', error);
        alert('Gagal memuat data. Silakan coba lagi.');
    }
}
    // Event listener untuk tombol pencarian bahan baku
    document.getElementById('searchBahanBakuButton').addEventListener('click', () => {
        const search = document.getElementById('search_bahan_baku').value;
        fetchBahanBaku(search);
    });

    // Set tabel default kosong saat halaman pertama kali dimuat
    document.addEventListener('DOMContentLoaded', () => {
        fetchBahanBaku();
    });

    function selectBahanBaku(id, kodeBahanBaku, namaBahanBaku, kodingBahanBaku, namaCoding, hpbb, satuan, jenisBahanBaku, row) {
    const tbodyDetail = document.getElementById('detail_results');

    // Hapus baris "Data belum tersedia" jika ada
    const noDataRow = tbodyDetail.querySelector('.no-data-row');
    if (noDataRow) {
        noDataRow.remove();
    }

    const formattedKodeBahanBaku = kodeBahanBaku.replace(/^([A-Za-z]+)(\d+)$/, "$1-$2");
    const rowCount = tbodyDetail.querySelectorAll('tr').length + 1;

    const newRow = `
        <tr data-kode="${formattedKodeBahanBaku}">
            <td class="border px-4 py-2">${rowCount} <input type="hidden" name="id_bahan_baku[]" value="${id}"></td>
            <td class="border px-4 py-2">${formattedKodeBahanBaku}  
                <input type="hidden" name="kode_bahan_baku[]" value="${formattedKodeBahanBaku}">
            </td>
            <td class="border px-4 py-2">${namaCoding} <input type="hidden" name="nama_coding[]" value="${namaCoding}"></td>
            <td class="border px-4 py-2">${satuan} <input type="hidden" name="satuan_bahan_baku[]" value="${satuan}"></td>
            <td class="border px-4 py-2">
                <input type="number" name="jumlah_bahan_baku[]" class="nominal-input border rounded p-1 w-full" 
                    min="0" step="0.001" oninput="updateHPP(this, '${hpbb}', this.closest('tr'))">
            </td>
            <td class="border px-4 py-2 hidden">${hpbb}</td>
            <td class="border px-4 py-2 hpp-cell">0</td>
            <td class="hidden">
                <input type="text" class="hpp-bahan-baku-input border rounded px-2 py-1" name="hpp_bahan_baku[]">
            </td>
            <td class="border px-4 py-2">
                <button type="button" class="text-red-500 hover:text-red-700" onclick="removeRow(this, '${formattedKodeBahanBaku}')">Hapus</button>
            </td>
        </tr>`;

    tbodyDetail.innerHTML += newRow;
    row.classList.add('hidden');
}




    // Fungsi untuk menghitung HPP dengan rumus (Nominal Satuan / 1000) * HPBB
    // Fungsi untuk menghitung HPP dengan rumus (Nominal Satuan / 1000) * HPBB
    function updateHPP(input, hpbb, row) {
        const nominal = parseFloat(input.value) || 0; // Ambil nilai input Nominal Satuan
        const hppCell = row.querySelector('.hpp-cell'); // Kolom HPP
        const hppCellInput = row.querySelector('.hpp-bahan-baku-input');
        const hpp = (nominal / 1000) * parseFloat(hpbb); // Rumus HPP

        hppCell.textContent = hpp.toFixed(2); // Tampilkan hasil dengan 2 angka desimal
        hppCellInput.value = hpp.toFixed(2);

        updateTotalHPP(); // Update total HPP keseluruhan
        updateTotalJumlah(); // Update total jumlah keseluruhan
    }


    function updateTotalJumlah() {
    let totalJumlah = 0;
    document.querySelectorAll("input[name='jumlah_bahan_baku[]']").forEach(input => {
        totalJumlah += parseFloat(input.value) || 0;
    });

    document.getElementById('total_jumlah_input_bahan_baku').textContent = totalJumlah.toFixed(2);
    document.getElementById('total_jumlah_input_bahan_baku_value').value = totalJumlah.toFixed(2); // Update hidden input
}


function updateTotalHPP() {
    let totalHPP = 0;
    document.querySelectorAll(".hpp-cell").forEach(cell => {
        totalHPP += parseFloat(cell.textContent) || 0;
    });

    document.getElementById('total_hpp_input_bahan_baku').textContent = totalHPP.toFixed(2);
    document.getElementById('total_hpp_input_bahan_baku_value').value = totalHPP.toFixed(2);
}

    
    // Function untuk menghapus baris dari tabel detail bahan baku
    function removeRow(button, kodingBahanBaku) {
        const row = button.closest('tr');
        row.remove();

        // Jika tidak ada baris data, tambahkan baris "Data belum tersedia"
        const tbodyDetail = document.getElementById('detail_results');
        if (tbodyDetail.querySelectorAll('tr').length === 0) {
            tbodyDetail.innerHTML = `
            <tr class="no-data-row">
                <td colspan="4" class="text-center py-4 text-gray-500">Data belum tersedia</td>
            </tr>
        `;
        }

        // Tampilkan kembali baris yang di-hide di tabel pencarian
        const tbodySearch = document.getElementById('search_results_bahan_baku');
        const hiddenRow = tbodySearch.querySelector(`tr[data-koding='${kodingBahanBaku}']`);
        if (hiddenRow) {
            hiddenRow.style.display = '';
        }
    }

    /* Pencarian Bahan kemas */
    // Function untuk memuat data bahan kemas berdasarkan pencarian
    async function fetchBahanKemas(search = '') {
        const tbody = document.getElementById('search_results_bahan_kemas');
        tbody.innerHTML = ''; // Reset tabel sebelum menampilkan data

        if (search === '') {
            tbody.innerHTML = `
            <tr>
                <td colspan="3" class="py-4 px-6 text-center text-gray-500">Silakan cari bahan kemas terlebih dahulu...</td>
            </tr>`;
            return;
        }

        try {
            const response = await fetch(`get-bahan-kemas?search=${encodeURIComponent(search)}`);
            if (!response.ok) {
                throw new Error(`HTTP error! Status: ${response.status}`);
            }

            const data = await response.json();

            if (!data || data.length === 0) {
                tbody.innerHTML = `
                <tr>
                    <td colspan="3" class="py-4 px-6 text-center text-gray-500">Tidak ada data ditemukan...</td>
                </tr>`;
                return;
            }

            data.forEach(kemasan => {
                const row = `
                <tr class="cursor-pointer" onclick="selectBahanKemas('${kemasan.id}', '${kemasan.kode_kemasan}', '${kemasan.nama_kemasan}', '${kemasan.hpbk}', '${kemasan.satuan}', this)">
                    <td class="py-2 px-4 border-b">${kemasan.kode_kemasan}</td>
                    <td class="py-2 px-4 border-b">${kemasan.nama_kemasan}</td>
                    <td class="py-2 px-4 border-b">${kemasan.hpbk}</td>
                </tr>`;
                tbody.innerHTML += row;
            });
        } catch (error) {
            console.error('Error fetching bahan kemas:', error);
            alert('Gagal memuat data. Silakan coba lagi.');
        }
    }

    // Function untuk memilih bahan kemas dan menambahkannya ke tabel detail
    function selectBahanKemas(id, kode_kemasan, nama_kemasan, hpbk, satuan, row) {
    const tbodyDetail = document.getElementById('detail_results_kemas');

    // Cek apakah kode kemasan sudah ada di tabel detail
    const existingRows = tbodyDetail.querySelectorAll('tr');
    for (let existingRow of existingRows) {
        const existingKode = existingRow.querySelector('input[name="kode_kemasan[]"]');
        const existingNama = existingRow.querySelector('input[name="nama_kemasan[]"]');

        if (
            existingKode && existingNama &&
            existingKode.value === kode_kemasan &&
            existingNama.value === decodeURIComponent(nama_kemasan)
        ) {
            alert(`Bahan kemas dengan kode "${kode_kemasan}" dan nama "${nama_kemasan}" sudah ditambahkan.`);
            return; // Hentikan jika sudah ada
        }
    }

    // Hapus baris "Data belum tersedia" jika ada
    const noDataRow = tbodyDetail.querySelector('.no-data-row');
    if (noDataRow) {
        noDataRow.remove();
    }

    const rowCount = tbodyDetail.querySelectorAll('tr').length + 1;

    const newRow = `
    <tr data-kode="${kode_kemasan}">
        <td class="border px-4 py-2">${rowCount}</td>
        <td class="border px-4 py-2">${kode_kemasan}
            <input type="hidden" class="border rounded px-2 py-1" name="id_bahan_kemas[]" value="${id}">
            <input type="hidden" name="kode_kemasan[]" value="${kode_kemasan}">
        </td>
        <td class="border px-4 py-2">${nama_kemasan}
            <input type="hidden" name="nama_kemasan[]" value="${decodeURIComponent(nama_kemasan)}">
        </td>
        <td class="border px-4 py-2">${satuan}
            <input type="hidden" name="satuan_kemasan[]" value="${satuan}">
        </td>
        <td class="border px-4 py-2">
            <input type="number" class="jumlah-satuan-input border rounded p-1 w-full" 
                min="0" step="0.001" name="jumlah_bahan_kemas[]" 
                oninput="updateHPPKemas(this, ${hpbk}, this.closest('tr'))">
        </td>
        <td class="border px-4 py-2 hidden">${hpbk}</td>
        <td class="border px-4 py-2 hpp-cell">0</td>
        <td class="hidden">
            <input type="text" class="hpp-bahan-kemas-input border rounded px-2 py-1" name="hpp_bahan_kemas[]">
        </td>
        <td class="border px-4 py-2">
            <button type="button" class="text-red-500 hover:text-red-700" onclick="removeRowKemas(this, '${kode_kemasan}')">Hapus</button>
        </td>
    </tr>`;

    tbodyDetail.innerHTML += newRow;
    row.style.display = 'none';
}


    // Fungsi untuk menghitung HPP bahan kemas dengan rumus (Jumlah Satuan * HPBK)
    function updateHPPKemas(input, hpbk, row) {
        const jumlah = parseFloat(input.value) || 0; // Ambil nilai input Jumlah Satuan
        const hppCell = row.querySelector('.hpp-cell'); // Kolom HPP
        const hppCellInput = row.querySelector('.hpp-bahan-kemas-input'); // Kolom HPP
        const hpp = jumlah * parseFloat(hpbk); // Rumus HPP

        hppCell.textContent = hpp.toFixed(2); // Tampilkan hasil dengan 2 angka desimal
        hppCellInput.value = hpp.toFixed(2);

        updateTotalHPPKemas(); // Update total HPP keseluruhan
        updateTotalJumlahKemas(); // Update total jumlah keseluruhan
    }

    // Fungsi untuk menghitung total jumlah dari semua jumlah satuan bahan kemas
    function updateTotalJumlahKemas() {
        const jumlahInputs = document.querySelectorAll('.jumlah-satuan-input'); // Ambil semua input jumlah satuan
        let totalJumlah = 0;

        jumlahInputs.forEach(input => {
            totalJumlah += parseFloat(input.value) || 0; // Akumulasi nilai jumlah satuan
        });

        // Tampilkan total jumlah
        document.getElementById('total_jumlah_input_bahan_kemas').textContent = totalJumlah.toFixed(2);
        document.getElementById('total_jumlah_input_bahan_kemas_value').value = totalJumlah.toFixed(2);
    }

    // Fungsi untuk menghitung total HPP dari semua baris di kolom HPP bahan kemas
    function updateTotalHPPKemas() {
        const hppCells = document.querySelectorAll('.hpp-cell'); // Ambil semua kolom HPP
        let totalHPP = 0;

        hppCells.forEach(cell => {
            totalHPP += parseFloat(cell.textContent) || 0; // Jumlahkan semua nilai HPP
        });

        // Tampilkan total HPP
        document.getElementById('total_hpp_input_bahan_kemas').textContent = totalHPP.toFixed(2);
        document.getElementById('total_hpp_input_bahan_kemas_value').value = totalHPP.toFixed(2);
    }

    // Function untuk menghapus baris dari tabel detail bahan kemas
    function removeRowKemas(button, kodeKemasan) {
        const row = button.closest('tr');
        row.remove();

        // Jika tidak ada baris data, tambahkan baris "Data belum tersedia"
        const tbodyDetail = document.getElementById('detail_results_kemas');
        if (tbodyDetail.querySelectorAll('tr').length === 0) {
            tbodyDetail.innerHTML = `
            <tr class="no-data-row">
                <td colspan="7" class="text-center py-4 text-gray-500">Data belum tersedia</td>
            </tr>
        `;
        }

        // Tampilkan kembali baris yang di-hide di tabel pencarian
        const tbodySearch = document.getElementById('search_results_bahan_kemas');
        const hiddenRow = tbodySearch.querySelector(`tr[data-kode='${kodeKemasan}']`);
        if (hiddenRow) {
            hiddenRow.style.display = '';
        }
    }

    // Event listener untuk tombol pencarian bahan kemas
    document.getElementById('searchBahanKemasButton').addEventListener('click', () => {
        const search = document.getElementById('search_bahan_kemas').value;
        fetchBahanKemas(search);
    });

    // Fungsi untuk menghitung Batch Size Satuan
    function calculateBatchSizeSatuan() {
        const batchSizeBerat = parseFloat(document.getElementById('batch_size_berat').value) || 0;
        const nettoInput = document.getElementById('netto');
        const netto = parseFloat(nettoInput.value);

        // Jika netto kosong atau tidak valid, berikan alert
        if (!netto || netto <= 0) {
            alert('Netto masih kosong atau tidak valid. Harap isi netto terlebih dahulu.');
            nettoInput.focus(); // Fokus pada input netto
            document.getElementById('batch_size_satuan').value = ''; // Kosongkan nilai batch size satuan
            return;
        }

        // Hitung Batch Size Satuan
        const batchSizeSatuan = batchSizeBerat / netto; // Rumus perhitungan
        document.getElementById('batch_size_satuan').value = batchSizeSatuan.toFixed(4); // Update nilai dan format ke 4 desimal
    }

    // Event listener untuk perubahan pada Batch Size Berat atau Netto
    document.getElementById('batch_size_berat').addEventListener('input', calculateBatchSizeSatuan);
    document.getElementById('netto').addEventListener('input', calculateBatchSizeSatuan);
</script>
@endsection