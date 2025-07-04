@extends('layout.main')

@section('content')
<div class="w-full px-6 py-6 mx-auto mt-10">
    <div class="bg-white shadow-lg rounded-lg p-6">
        <h2 class="text-2xl font-bold mb-4">Master Produk Jadi</h2>

        @can('create master produk jadi')
        <a href="{{ route('master_produk_jadi.create') }}" class="px-4 py-2 text-white bg-blue-500 rounded-lg hover:bg-blue-600 mb-4 inline-block">Tambah Produk Jadi</a>
        @endcan

        {{-- Flash Message --}}
        @if (session('success'))
        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
        @endif

        <div class="overflow-x-auto">
            <div class="overflow-y-auto max-h-[600px] relative">
                <table id="Master_produk_jadi" class="min-w-full bg-white border-collapse border border-gray-300 table-auto">
                    <thead class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal text-center sticky top-0 z-10">
                        <tr>
                            <th class="py-3 px-6">No</th>
                            <th class="py-3 px-6">Kode</th>
                            <th class="py-3 px-6">Merek</th>
                            <th class="py-3 px-6">Kategori</th>
                            <th class="py-3 px-6">Nama Produk</th>
                            <th class="py-3 px-6">Netto</th>
                            <th class="py-3 px-6">Satuan</th>
                            <th class="py-3 px-6">Kategori Kemasan</th>
                            <th class="py-3 px-6">Jenis Kemasan</th>
                            <th class="py-3 px-6">Expired Produk</th>
                            <th class="py-3 px-6">Penyimpanan</th>
                            <th class="py-3 px-6">Nomor Merk</th>
                            <th class="py-3 px-6">Expired Merk</th>
                            <th class="py-3 px-6">Nomor HAKI</th>
                            <th class="py-3 px-6">Masa HAKI</th>
                            <th class="py-3 px-6">No BPOM</th>
                            <th class="py-3 px-6">Masa BPOM</th>
                            <th class="py-3 px-6">No Halal</th>
                            <th class="py-3 px-6">Masa Halal</th>
                            <th class="py-3 px-6">Harga</th>
                            <th class="py-3 px-6">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($produkJadi as $index => $produk)
                        <tr class="border-b border-gray-200 hover:bg-gray-100 text-center">
                            <td class="py-2 px-3">{{ $loop->iteration }}</td>
                            <td class="py-2 px-3">{{ $produk->kode_produk_jadi }}</td>
                            <td class="py-2 px-3">{{ $produk->nama_merek }}</td>
                            <td class="py-2 px-3">{{ $produk->kategori_produk_jadi }}</td>
                            <td class="py-2 px-3">{{ $produk->nama_produk }}</td>
                            <td class="py-2 px-3">{{ $produk->netto }}</td>
                            <td class="py-2 px-3">{{ $produk->satuan }}</td>
                            <td class="py-2 px-3">{{ $produk->kategori_kemasan == 'Primer' ? 'Primer' : 'Sekunder' }}</td>
                            <td class="py-2 px-3">{{ $produk->jenis_kemasan }}</td>
                            <td class="py-2 px-3">
                                {{ $produk->expired_date_produk_jadi ? \Carbon\Carbon::parse($produk->expired_date_produk_jadi)->format('d/m/Y') : '-' }}
                            </td>
                            <td class="py-2 px-3">{{ $produk->rekomendasi_penyimpanan }}</td>
                            <td class="py-2 px-3">{{ $produk->nomor_merk ?? '-' }}</td>
                            <td class="py-2 px-3">{{ $produk->masa_berlaku_merk ? \Carbon\Carbon::parse($produk->masa_berlaku_merk)->format('d/m/Y') : '-' }}</td>
                            <td class="py-2 px-3">{{ $produk->nomor_haki ?? '-' }}</td>
                            <td class="py-2 px-3">{{ $produk->masa_berlaku_haki ? \Carbon\Carbon::parse($produk->masa_berlaku_haki)->format('d/m/Y') : '-' }}</td>
                            <td class="py-2 px-3">{{ $produk->nomor_notifikasi_bpom ?? '-' }}</td>
                            <td class="py-2 px-3">{{ $produk->masa_berlaku_notifikasi_bpom ? \Carbon\Carbon::parse($produk->masa_berlaku_notifikasi_bpom)->format('d/m/Y') : '-' }}</td>
                            <td class="py-2 px-3">{{ $produk->nomor_sertifikat_halal ?? '-' }}</td>
                            <td class="py-2 px-3">{{ $produk->masa_berlaku_sertifikat_halal ? \Carbon\Carbon::parse($produk->masa_berlaku_sertifikat_halal)->format('d/m/Y') : '-' }}</td>
                            <td class="py-2 px-3">{{ $produk->harga_produk ? 'Rp ' . number_format($produk->harga_produk, 0, ',', '.') : '-' }}</td>

                            <td class="py-2 px-3 space-x-1">
                                @can('detail master produk jadi')
                                <a href="{{ route('master_produk_jadi.show', $produk->id) }}" class="px-3 py-1 bg-blue-500 text-white rounded text-sm hover:bg-blue-600">Detail</a>
                                @endcan
                                
                                @can('edit master produk jadi')
                                <a href="{{ route('master_produk_jadi.edit', $produk->id) }}" class="px-3 py-1 bg-yellow-500 text-white rounded text-sm hover:bg-yellow-600">Edit</a>
                                @endcan
                                
                                @can('delete master produk jadi')
                                <form action="{{ route('master_produk_jadi.destroy', $produk->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-3 py-1 bg-red-500 text-white rounded text-sm hover:bg-red-600">Hapus</button>
                                </form>
                                @endcan
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('Modal/Master_produk_jadi.js') }}" defer></script>

<style>
    thead th {
        text-align: center;
        white-space: nowrap;
        padding: 10px;
    }

    tbody td {
        text-align: center;
        vertical-align: middle;
    }

    .max-h-[600px] {
        max-height: 600px;
    }
</style>
@endsection
