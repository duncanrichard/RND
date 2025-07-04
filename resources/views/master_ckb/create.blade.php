@extends('layout.main')

@section('content')
<div class="w-full px-6 py-6 mx-auto mt-10">
    <div class="bg-white shadow-lg rounded-lg p-6">
        <h2 class="text-2xl font-bold mb-4">Tambah Data CKB</h2>
        <form action="{{ route('master_ckb.store') }}" method="POST" enctype="multipart/form-data">

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
                    <th class="py-2 px-4 text-left border-b">Nama Produk</th>
                    <th class="py-2 px-4 text-left border-b">Batch Size Berat</th>
                    <th class="py-2 px-4 text-left border-b">Batch Size Satuan</th>
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

<!-- Field untuk menampilkan data yang dipilih -->
<div class="mb-4">
    <label for="kode_produk" class="block font-semibold">Kode Produk</label>
    <input type="text" name="kode_produk" id="kode_produk" class="w-full border p-2 rounded-lg" readonly required>
</div>

<div class="mb-4">
    <label for="nama_produk" class="block font-semibold">Nama Produk</label>
    <input type="text" name="nama_produk" id="nama_produk" class="w-full border p-2 rounded-lg" readonly required>
</div>

<div class="mb-4">
    <label for="batch_size_berat" class="block font-semibold">Batch Size Berat</label>
    <input type="number" name="batch_size_berat" id="batch_size_berat" class="w-full border p-2 rounded-lg" readonly required>
</div>

<div class="mb-4">
    <label for="batch_size_satuan" class="block font-semibold">Batch Size Satuan</label>
    <input type="text" name="batch_size_satuan" id="batch_size_satuan" class="w-full border p-2 rounded-lg" readonly required>
</div>
<div class="mb-4">
    <label for="nomor_cpb" class="block font-semibold">Nomor CKB</label>
    <input type="text" name="nomor_cpb" id="nomor_cpb" class="w-full border p-2 rounded-lg"  required>
</div>
<div class="mb-4">
    <label for="file_dokumen" class="block font-semibold">Upload Dokumen (PDF)</label>
    <input type="file" name="file_dokumen" id="file_dokumen" class="w-full border p-2 rounded-lg" accept=".pdf">
</div>

<!-- Field untuk menyimpan ID Produk -->
<input type="hidden" name="id_kode_produk" id="id_kode_produk">

        
            <!-- Tombol Aksi -->
            <div class="mt-6">
                <button type="submit" class="w-full font-bold px-4 py-2 text-white rounded-lg" style="background-color: #032859;">Simpan</button>
                <a href="{{ route('master_ckb.index') }}" class="w-full font-bold px-4 py-2 text-white rounded-lg bg-gray-500 hover:bg-gray-600 mt-2 inline-block text-center" style="background-color: #032859;">Batal</a>
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
        const response = await fetch(`/master-ckb/get-products?search=${encodeURIComponent(search)}`);
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
        <tr class="cursor-pointer" onclick="selectProduct('${product.id}', '${product.kode_produk}', '${product.nama_produk}', '${product.batch_size_berat}', '${product.batch_size_satuan}')">
            <td class="py-2 px-4 border-b">${product.kode_produk}</td>
            <td class="py-2 px-4 border-b">${product.nama_produk}</td>
            <td class="py-2 px-4 border-b">${product.batch_size_berat}</td>
            <td class="py-2 px-4 border-b">${product.batch_size_satuan}</td>
        </tr>`;
            tbody.innerHTML += row;
        });
    } catch (error) {
        console.error('Error fetching products:', error);
        alert('Gagal memuat data. Silakan coba lagi.');
    }
}

// Function untuk memilih produk dari tabel pencarian
function selectProduct(id, kode_produk, nama_produk, batch_size_berat, batch_size_satuan) {
    document.getElementById('id_kode_produk').value = id; // Set ID produk yang dipilih
    document.getElementById('kode_produk').value = kode_produk;
    document.getElementById('nama_produk').value = nama_produk;
    document.getElementById('batch_size_berat').value = batch_size_berat;
    document.getElementById('batch_size_satuan').value = batch_size_satuan;
}

// Event listener untuk tombol pencarian
document.getElementById('searchButton').addEventListener('click', () => {
    const search = document.getElementById('search').value;
    fetchProducts(search);
});


</script>
@endsection