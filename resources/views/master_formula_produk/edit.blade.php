@extends('layout.main')

@section('content')
<div class="w-full px-6 py-6 mx-auto mt-10">
    <div class="bg-white shadow-lg rounded-lg p-6">
        <h2 class="text-2xl font-bold mb-4">Update Formula Produk Jadi</h2>
     <form action="{{ route('master_formula_produk.update', $formula->id) }}" method="POST">
            @csrf
            @method('PUT')
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
                    <input type="text" value="{{ $formula->nomor_formula }}" name="nomor_formula" id="nomor_formula" class="w-full border p-2 rounded-lg" readonly required>
                </div>

                    <input type="hidden" name="kode_produk_id" id="id_kode_produk" required>


                    <div class="mb-4">
                        <label for="tanggal" class="block font-semibold">Tanggal</label>
                        <input type="date" name="tanggal" id="tanggal" class="w-full border p-2 rounded-lg" value="{{ now()->format('Y-m-d') }}" value="{{ $formula->tanggal }}"  required>
                    </div>

                    <div class="mb-4">
                        <label for="id_input" class="block font-semibold">ID Input</label>
                        <input type="text" name="id_input" id="id_input" class="w-full border p-2 rounded-lg" value="{{ $formula->id_input }}" required>
                    </div>

                    <div class="mb-4">
                        <label for="kode_produk" class="block font-semibold">Kode Produk</label>
                        <input type="hidden" name="id_kode_produk" id="id_kode_produk" class="w-full border p-2 rounded-lg" required>
                        <input type="text" name="kode_produk" id="kode_produk" value="{{ $formula->kode_produk }}" class="w-full border p-2 rounded-lg" required readonly>
                    </div>
                    <div class="mb-4">
                        <label for="netto" class="block font-semibold">Netto</label>
                        <input type="text" name="netto" id="netto" class="w-full border p-2 rounded-lg" value="{{ $formula->netto }}" required readonly>
                    </div>
                </div>

                <!-- Kolom Kanan -->
                <div>
                    <div class="mb-4">
                        <label for="nama_merek" class="block font-semibold">Nama Merek</label>
                        <input type="text" name="nama_merek" id="nama_merek" class="w-full border p-2 rounded-lg"  value="{{ $formula->nama_merek }}" required readonly>
                    </div>

                    <div class="mb-4">
                        <label for="kategori" class="block font-semibold">Kategori</label>
                        <input type="text" name="kategori" id="kategori" value="{{ $formula->kategori }}" class="w-full border p-2 rounded-lg" required readonly>
                    </div>

                    <div class="mb-4">
                        <label for="nama_produk" class="block font-semibold">Nama Produk</label>
                        <input type="text" name="nama_produk" id="nama_produk" value="{{ $formula->nama_produk }}" class="w-full border p-2 rounded-lg" required readonly>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <!-- Form Batch Size Berat -->
                        <div class="mb-4">
                            <label for="batch_size_berat" class="block font-semibold">Batch Size Berat</label>
                            <input type="number" name="batch_size_berat" id="batch_size_berat" min='0' class="w-full border p-2 rounded-lg"  value="{{ $formula->batch_size_berat }}" required>
                        </div>

                        <!-- Form Satuan Berat -->
                        <div class="mb-4">
                            <label for="satuan_berat" class="block font-semibold">Satuan Berat</label>
                            <input type="text" name="satuan_berat" id="satuan_berat" class="w-full border p-2 rounded-lg" value='Gram' value="{{ $formula->satuan_berat }}" readonly required>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="mb-4">
                            <label for="batch_size_satuan" class="block font-semibold">Batch Size Satuan</label>
                            <input type="number" name="batch_size_satuan" value="{{ $formula->batch_size_satuan }}" id="batch_size_satuan" class="w-full border p-2 rounded-lg" readonly required>
                        </div>
                        <div class="mb-4">
                            <label for="jenis_satuan" class="block font-semibold">Jenis Satuan</label>
                            <input type="text" name="jenis_satuan" value="{{ $formula->jenis_satuan }}" id="jenis_satuan" class="w-full border p-2 rounded-lg" value='Pcs' readonly required>
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