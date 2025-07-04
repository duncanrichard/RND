@extends('layout.main')

@section('content')
<div class="w-full px-6 py-6 mx-auto mt-10">
    <div class="bg-white shadow-lg rounded-lg p-6">
        <h2 class="text-2xl font-bold mb-4">Detail Formula Produk</h2>

        <div class="mb-4">
            <a href="{{ route('master_formula_produk.index') }}" class="px-4 py-2 text-white bg-gray-500 rounded-lg hover:bg-gray-600">Kembali</a>
        </div>

        <div class="grid grid-cols-2 gap-6">
    <!-- Kolom Kiri -->
    <div>
        <p><strong>Nomor Formula :</strong> {{ $formula->nomor_formula }}</p>
        <p><strong>Nama Merek :</strong> {{ $formula->nama_merek }}</p>
        <p><strong>Tanggal :</strong> {{ \Carbon\Carbon::parse($formula->tanggal)->format('d-m-Y') }}</p>
        <p><strong>Kategori :</strong> {{ $formula->kategori }}</p>
        <p><strong>Id Input :</strong> {{ $formula->id_input }}</p>
    </div>

    <!-- Kolom Kanan -->
    <div>
        <p><strong>Kode Produk :</strong> {{ $formula->kode_produk }}</p>
        <p><strong>Nama Produk :</strong> {{ $formula->nama_produk }}</p>
        <p><strong>Batch Size Berat :</strong> {{ $formula->batch_size_berat }} /{{ $formula->satuan_berat }}</p>
        <p><strong>Batch Size Satuan :</strong> {{ $formula->batch_size_satuan }} /{{ $formula->jenis_satuan }}</p>
        <p><strong>Netto :</strong> {{ $formula->netto }}</p>
    </div>
</div>

        <h3 class="text-xl font-bold mt-6">Bahan Baku</h3>
        <table class="min-w-full bg-white border border-gray-300 rounded-lg mt-4">
            <thead class="bg-gray-200 text-gray-700">
                <tr>
                    
                    <th class="py-3 px-6 text-left">Kode Bahan Baku</th>
                    <th class="py-3 px-6 text-left">Nama</th>
                    <th class="py-3 px-6 text-left">Jumlah</th>
                    <th class="py-3 px-6 text-left">Satuan</th>
                    <th class="py-3 px-6 text-left">HPP</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($formula->bahanBaku as $bahan)
                <tr>
                    <td class="py-3 px-6">{{ $bahan->kode_bahan_baku }}</td>
                    <td class="py-3 px-6">{{ $bahan->nama_coding }}</td>
                    <td class="py-3 px-6">{{ $bahan->jumlah }}</td>
                    <td class="py-3 px-6">{{ $bahan->satuan }}</td>
                    <td class="py-3 px-6">{{ $bahan->hpp }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
<!-- Total Data Bahan Baku -->
<div class="mt-4">
    <h3 class="text-xl font-bold mb-2">Total Data Bahan Baku</h3>
    <div class="grid grid-cols-2 gap-4">
        <div class="flex justify-between items-center">
            <span class="font-medium">Total Jumlah:</span>
            <span class="font-bold">{{ $totalJumlahBahanBaku }}</span>
        </div>
        <div class="flex justify-between items-center">
            <span class="font-medium">Total HPP:</span>
            <span class="font-bold">{{ number_format($formula->total_hpp_bahan_baku, 2) }}</span>
        </div>
    </div>
</div>

        <h3 class="text-xl font-bold mt-6">Bahan Kemas</h3>
        <table class="min-w-full bg-white border border-gray-300 rounded-lg mt-4">
            <thead class="bg-gray-200 text-gray-700">
                <tr>
                    <th class="py-3 px-6 text-left">Kode</th>
                    <th class="py-3 px-6 text-left">Nama</th>
                    <th class="py-3 px-6 text-left">Jumlah</th>
                    <th class="py-3 px-6 text-left">Satuan</th>
                    <th class="py-3 px-6 text-left">HPP</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($formula->bahanKemas as $kemas)
                <tr>
                    <td class="py-3 px-6">{{ $kemas->kode_kemasan }}</td>
                    <td class="py-3 px-6">{{ $kemas->nama_kemasan }}</td>
                    <td class="py-3 px-6">{{ $kemas->jumlah }}</td>
                    <td class="py-3 px-6">{{ $kemas->satuan }}</td>
                    <td class="py-3 px-6">{{ $kemas->hpp }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <!-- Total Data Bahan Kemas -->
<div class="mt-4">
    <h3 class="text-xl font-bold mb-2">Total</h3>
    <div class="grid grid-cols-2 gap-4">
        <div class="flex justify-between items-center">
            <span class="font-medium">Total Jumlah Bahan Kemas:</span>
            <span class="font-bold">{{ $totalJumlahBahanKemas }}</span>
        </div>
        <div class="flex justify-between items-center">
            <span class="font-medium">Total HPP Bahan Kemas:</span>
            <span class="font-bold">{{ number_format($formula->total_hpp_bahan_kemas, 2) }}</span>
        </div>
    </div>
</div>
        <div class="mt-6">
            <a href="{{ route('master_formula_produk.index') }}" class="px-6 py-3 bg-blue-500 text-white text-lg font-semibold rounded-lg hover:bg-blue-600 transition duration-200">Kembali</a>
            <a href="{{ route('master_formula_produk.print_pdf', $formula->id) }}" 
   target="_blank" 
   class="px-6 py-3 bg-blue-500 text-white text-lg font-semibold rounded-lg hover:bg-blue-600 transition duration-200">
   Print PDF
</a>

        </div>
    </div>
    
</div>

<style>
       .grid {
        display: grid;
    }

    .grid-cols-2 {
        grid-template-columns: 1fr 1fr;
    }

    .gap-6 {
        gap: 1.5rem;
    }

    p {
        margin-bottom: 0.5rem;
    }

    strong {
        font-weight: bold;
    }
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
@endsection
