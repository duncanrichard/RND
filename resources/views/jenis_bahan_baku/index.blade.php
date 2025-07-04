@extends('layout.main')

@section('content')
<div class="w-full px-6 py-6 mx-auto mt-10">
    <div class="bg-white shadow-lg rounded-lg p-6">
        <h2 class="text-2xl font-bold mb-4">Master Kategori Bahan Baku</h2>

        {{-- Alert sukses --}}
        @if(session('success'))
        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
            <span class="block sm:inline">{{ session('success') }}</span>
            <button type="button" class="absolute top-0 bottom-0 right-0 px-4 py-3" onclick="this.parentElement.style.display='none'">
                <svg class="fill-current h-6 w-6 text-green-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                    <title>Close</title>
                    <path d="M14.348 5.652a.5.5 0 00-.707 0L10 9.293 6.354 5.647a.5.5 0 10-.707.707L9.293 10l-3.646 3.646a.5.5 0 10.707.707L10 10.707l3.646 3.646a.5.5 0 10.707-.707L10.707 10l3.646-3.646a.5.5 0 000-.707z"/>
                </svg>
            </button>
        </div>
        @endif

        {{-- Tombol Tambah --}}
        @can('create master kategori bahan baku')
        <div class="mb-4">
            <a href="{{ route('jenis-bahan-baku.create') }}" class="px-4 py-2 font-bold bg-blue-500 text-white rounded hover:bg-blue-600">
                Tambah Data
            </a>
        </div>
        @endcan

        {{-- Tabel Data --}}
        <div class="overflow-x-auto mt-6">
            <table id="Jenis_Master_Bahan_Baku" class="min-w-full bg-white border border-gray-300 rounded">
                <thead class="bg-gray-200 text-gray-700">
                    <tr>
                        <th class="px-4 py-2 text-left">#</th>
                        <th class="px-4 py-2 text-left">Kode Kategori</th>
                        <th class="px-4 py-2 text-left">Nama Kategori</th>
                        <th class="px-4 py-2 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($jenisBahanBakus as $index => $jenisBahanBaku)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-2">{{ $index + 1 }}</td>
                        <td class="px-4 py-2">{{ $jenisBahanBaku->jenis_bahan_baku }}</td>
                        <td class="px-4 py-2">{{ $jenisBahanBaku->nama_bahan_baku }}</td>
                        <td class="px-4 py-2 text-center space-x-2">
                            @can('edit master kategori bahan baku')
                            <a href="{{ route('jenis-bahan-baku.edit', $jenisBahanBaku->id) }}"
                               class="px-4 py-2 font-bold text-white rounded inline-flex items-center" style="background-color: #FF8C00;">
                                Edit
                            </a>
                            @endcan

                            @can('delete master kategori bahan baku')
                            <form action="{{ route('jenis-bahan-baku.destroy', $jenisBahanBaku->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-4 py-2 font-bold text-white rounded inline-flex items-center" style="background-color: #ef4444;">
                                    Hapus
                                </button>
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
@endsection

{{-- JavaScript --}}
<script src="{{ asset('Modal/Jenis_Master_Bahan_Baku.js') }}" defer></script>

{{-- Optional Style --}}
<style>
    th {
        white-space: nowrap;
    }
    .overflow-x-auto {
        overflow-x: auto;
    }
    tbody td {
        font-size: 14px;
    }
</style>
