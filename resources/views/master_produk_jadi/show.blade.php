@extends('layout.main')

@section('content')
<div class="w-full px-6 py-6 mx-auto mt-10">
    <div class="bg-white shadow-lg rounded-lg p-6">
        <h2 class="text-2xl font-bold mb-4">Detail Produk Jadi</h2>

        <table class="table-auto w-full border-collapse border border-gray-300">
            <tr>
                <th class="border px-4 py-2">Kode Produk</th>
                <td class="border px-4 py-2">{{ $produk->kode_produk_jadi }}</td>
            </tr>
            <tr>
                <th class="border px-4 py-2">Nama Merk</th>
                <td class="border px-4 py-2">{{ $produk->nama_merek }}</td>
            </tr>
            <tr>
                <th class="border px-4 py-2">Kategori Produk</th>
                <td class="border px-4 py-2">{{ $produk->kategori_produk_jadi }}</td>
            </tr>
            <tr>
                <th class="border px-4 py-2">Nama Produk</th>
                <td class="border px-4 py-2">{{ $produk->nama_produk }}</td>
            </tr>
            <tr>
                <th class="border px-4 py-2">Netto</th>
                <td class="border px-4 py-2">{{ $produk->netto }} {{ $produk->satuan }}</td>
            </tr>
            <tr>
    <th class="border px-4 py-2">Kategori Kemasan</th>
    <td class="border px-4 py-2">
        {{ $produk->kategori_kemasan == 1 ? 'Primer' : ($produk->kategori_kemasan == 2 ? 'Sekunder' : '-') }}
    </td>
</tr>

            <tr>
                <th class="border px-4 py-2">Jenis Kemasan</th>
                <td class="border px-4 py-2">{{ $produk->nama_jenis_kemasan ?? '-' }}</td>

            </tr>
            <tr>
                <th class="border px-4 py-2">Expired Date</th>
                <td class="border px-4 py-2">{{ $produk->expired_date_produk_jadi }}</td>
            </tr>
            <tr>
                <th class="border px-4 py-2">Rekomendasi Penyimpanan</th>
                <td class="border px-4 py-2">{{ $produk->rekomendasi_penyimpanan }}</td>
            </tr>
            <tr>
                <th class="border px-4 py-2">Nomor Merk</th>
                <td class="border px-4 py-2">{{ $produk->nomor_merk ?? '-' }}</td>
            </tr>
            <tr>
                <th class="border px-4 py-2">Expired Merk</th>
                <td class="border px-4 py-2">{{ $produk->masa_berlaku_merk ?? '-' }}</td>
            </tr>
            <tr>
                <th class="border px-4 py-2">Nomor HAKI</th>
                <td class="border px-4 py-2">{{ $produk->nomor_haki ?? '-' }}</td>
            </tr>
            <tr>
                <th class="border px-4 py-2">Masa Berlaku HAKI</th>
                <td class="border px-4 py-2">{{ $produk->masa_berlaku_haki ?? '-' }}</td>
            </tr>
            <tr>
                <th class="border px-4 py-2">Nomor Notifikasi BPOM</th>
                <td class="border px-4 py-2">{{ $produk->nomor_notifikasi_bpom ?? '-' }}</td>
            </tr>
            <tr>
                <th class="border px-4 py-2">Masa Berlaku BPOM</th>
                <td class="border px-4 py-2">{{ $produk->masa_berlaku_notifikasi_bpom ?? '-' }}</td>
            </tr>
            <tr>
                <th class="border px-4 py-2">Nomor Sertifikat Halal</th>
                <td class="border px-4 py-2">{{ $produk->nomor_sertifikat_halal ?? '-' }}</td>
            </tr>
            <tr>
                <th class="border px-4 py-2">Masa Berlaku Sertifikat Halal</th>
                <td class="border px-4 py-2">{{ $produk->masa_berlaku_sertifikat_halal ?? '-' }}</td>
            </tr>
        </table>
        <a href="{{ route('master_produk_jadi.previewPdf', $produk->id) }}" target="_blank" class="mt-4 inline-block px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600">
    Print
</a>

        <a href="{{ route('master_produk_jadi.index') }}" class="mt-4 inline-block px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
            Kembali
        </a>
    </div>
</div>
@endsection
