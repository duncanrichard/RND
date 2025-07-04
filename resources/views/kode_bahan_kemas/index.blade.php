@extends('layout.main')

@section('content')
<div class="w-full px-6 py-6 mx-auto mt-10">
    <div class="bg-white shadow-lg rounded-lg p-6">
        <h1 class="text-2xl font-bold mb-4">Master Kategori Bahan Kemas</h1>

        {{-- Flash Message --}}
        @if (session('success'))
        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
            <span class="block sm:inline">{{ session('success') }}</span>
            <button type="button" class="absolute top-0 bottom-0 right-0 px-4 py-3" onclick="this.parentElement.style.display='none'">
                <svg class="fill-current h-6 w-6 text-green-500" viewBox="0 0 20 20">
                    <path d="M14.348 5.652a.5.5 0 00-.707 0L10 9.293 6.354 5.647a.5.5 0 10-.707.707L9.293 10l-3.646 3.646a.5.5 0 10.707.707L10 10.707l3.646 3.646a.5.5 0 10.707-.707L10.707 10l3.646-3.646a.5.5 0 000-.707z"/>
                </svg>
            </button>
        </div>
        @endif

        {{-- Filter --}}
        <div class="mb-4">
            <form action="{{ route('kode_bahan_kemas.index') }}" method="GET" class="flex items-center gap-2">
                <label for="jenis_kemasan" class="font-semibold">Filter Jenis Kemasan:</label>
                <select name="jenis_kemasan" id="jenis_kemasan" class="border p-2 rounded-lg">
                    <option value="">-- Semua Jenis Kemasan --</option>
                    <option value="1" {{ request('jenis_kemasan') == '1' ? 'selected' : '' }}>Primer</option>
                    <option value="2" {{ request('jenis_kemasan') == '2' ? 'selected' : '' }}>Sekunder</option>
                </select>
                <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">Filter</button>
            </form>
        </div>

        {{-- Tombol Tambah --}}
        @can('create master kategori bahan kemas')
        <div class="mb-4">
            <a href="{{ route('kode_bahan_kemas.create') }}" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">
                Tambah Kode Bahan Kemas
            </a>
        </div>
        @endcan

        {{-- Tabel Data --}}
        <div class="overflow-x-auto mt-6">
            <table id="kode_bahan_kemas" class="min-w-full bg-white border border-gray-300 rounded">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="border px-4 py-2 text-center">No</th>
                        <th class="border px-4 py-2">Kode</th>
                        <th class="border px-4 py-2">Nama Kemasan</th>
                        <th class="border px-4 py-2">Jenis Kemasan</th>
                        <th class="border px-4 py-2 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($data as $item)
                        <tr class="hover:bg-gray-50">
                            <td class="border px-4 py-2 text-center">{{ $loop->iteration }}</td>
                            <td class="border px-4 py-2">{{ $item->kode }}</td>
                            <td class="border px-4 py-2">{{ $item->nama_kode }}</td>
                            <td class="border px-4 py-2">
                                @switch($item->jenis_kemasan)
                                    @case(1) Primer @break
                                    @case(2) Sekunder @break
                                    @default Tidak Diketahui
                                @endswitch
                            </td>
                            <td class="border px-4 py-2 text-center space-x-2">
                                @can('edit master kategori bahan kemas')
                                <a href="{{ route('kode_bahan_kemas.edit', $item->id) }}"
                                   class="px-3 py-1 text-white bg-yellow-500 rounded hover:bg-yellow-600 text-sm">
                                   Edit
                                </a>
                                @endcan

                                @can('delete master kategori bahan kemas')
                                <form action="{{ route('kode_bahan_kemas.destroy', $item->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-3 py-1 text-white bg-red-500 rounded hover:bg-red-600 text-sm">
                                        Hapus
                                    </button>
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
<script src="{{ asset('Modal/kode_bahan_kemas.js') }}" defer></script>
@endsection
