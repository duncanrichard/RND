@extends('layout.main')

@section('content')
<div class="w-full px-6 py-6 mx-auto mt-10">
    <div class="bg-white shadow-lg rounded-lg p-6">
        <h1 class="text-2xl font-bold mb-4">Master Bahan Kemas</h1>

        {{-- Flash Message --}}
        @if (session('success'))
        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
            <span class="block sm:inline">{{ session('success') }}</span>
            <button type="button" class="absolute top-0 bottom-0 right-0 px-4 py-3" onclick="this.parentElement.style.display='none'">
                <svg class="fill-current h-6 w-6 text-green-500" viewBox="0 0 20 20">
                    <path d="M14.348 5.652a.5.5 0 00-.707 0L10 9.293 6.354 5.647a.5.5 0 10-.707.707L9.293 10l-3.646 3.646a.5.5 0 10.707.707L10 10.707l3.646-3.646a.5.5 0 000-.707z"/>
                </svg>
            </button>
        </div>
        @endif

        {{-- Filter dan Tambah --}}
        <div class="flex justify-between items-center mb-4">
            @can('create master bahan kemas')
            <a href="{{ route('master_kemasan.create') }}" class="px-4 py-2 text-white bg-blue-500 rounded-lg hover:bg-blue-600">
                Tambah Data
            </a>
            @endcan

            <form action="{{ route('master_kemasan.index') }}" method="GET" class="flex items-center gap-2">
                <label for="kategori_kemasan" class="font-semibold">Filter Kategori:</label>
                <select name="kategori_kemasan" id="kategori_kemasan" class="border p-2 rounded-lg">
                    <option value="">-- Semua Kategori --</option>
                    <option value="1" {{ request('kategori_kemasan') == '1' ? 'selected' : '' }}>Primer</option>
                    <option value="2" {{ request('kategori_kemasan') == '2' ? 'selected' : '' }}>Sekunder</option>
                </select>
                <button type="submit" class="px-4 py-2 text-white bg-blue-500 rounded-lg hover:bg-blue-600">Filter</button>
            </form>
        </div>

        {{-- Tombol Export --}}
        @can('print master bahan kemas')
        <a href="{{ route('master_kemasan.print', ['kategori_kemasan' => request('kategori_kemasan')]) }}" target="_blank"
           class="px-4 py-2 bg-red-500 text-white font-semibold rounded hover:bg-red-600">
           Print PDF
        </a>
 @endcan
        {{-- Tabel --}}
        <div class="mt-6 overflow-x-auto">
            <table id="master_bahan_kemas" class="min-w-full bg-white border border-gray-300 rounded">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="border px-4 py-2">No</th>
                        <th class="border px-4 py-2">Kategori</th>
                        <th class="border px-4 py-2">Jenis Kemasan</th>
                        <th class="border px-4 py-2">Kode</th>
                        <th class="border px-4 py-2">Nama</th>
                        <th class="border px-4 py-2">Satuan</th>
                        <th class="border px-4 py-2">Penyimpanan</th>
                        <th class="border px-4 py-2">Harga PO</th>
                        <th class="border px-4 py-2">PPN</th>
                        <th class="border px-4 py-2">Additional Cost</th>
                        <th class="border px-4 py-2">HPBK</th>
                        <th class="border px-4 py-2 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($data as $item)
                    <tr class="hover:bg-gray-50">
                        <td class="border px-4 py-2 text-center">{{ $loop->iteration }}</td>
                        <td class="border px-4 py-2">
                            {{ $item->kategori_kemasan == 1 ? 'Primer' : ($item->kategori_kemasan == 2 ? 'Sekunder' : '-') }}
                        </td>
                        <td class="border px-4 py-2">{{ $item->jenisKemasan->nama_kode ?? '-' }}</td>
                        <td class="border px-4 py-2">{{ $item->kode_kemasan }}</td>
                        <td class="border px-4 py-2">{{ $item->nama_kemasan }}</td>
                        <td class="border px-4 py-2">{{ $item->satuan }}</td>
                        <td class="border px-4 py-2">{{ $item->cara_penyimpanan }}</td>
                        <td class="border px-4 py-2">{{ number_format($item->harga_po, 2, ',', '.') }}</td>
                        <td class="border px-4 py-2">{{ number_format($item->ppn, 2, ',', '.') }}</td>
                        <td class="border px-4 py-2">{{ $item->mark_up ?? '-' }}</td>
                        <td class="border px-4 py-2">{{ number_format($item->hpbk, 2, ',', '.') }}</td>
                        <td class="border px-4 py-2 text-center space-x-2">
                            @can('edit master bahan kemas')
                            <a href="{{ route('master_kemasan.edit', $item->id) }}" class="px-3 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600 text-sm">Edit</a>
                            @endcan

                            @can('delete master bahan kemas')
                            <form action="{{ route('master_kemasan.destroy', $item->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600 text-sm">Hapus</button>
                            </form>
                            @endcan
                        </td>
                    </tr>
                    @empty
                  
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
    table {
        table-layout: auto;
    }
    th {
        white-space: nowrap;
    }
    .overflow-x-auto {
        overflow-x: auto;
    }
</style>

<script src="{{ asset('Modal/master_bahan_kemas.js') }}" defer></script>
@endsection
