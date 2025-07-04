@extends('layout.main')

@section('content')
<div class="w-full px-6 py-6 mx-auto mt-10">
    <div class="bg-white shadow-lg rounded-lg p-6">
        <h2 class="text-2xl font-bold mb-4">Master Bahan Baku</h2>

        {{-- Alert --}}
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

        {{-- Tombol Tambah Data --}}
        @can('create master bahan baku')
        <div class="mb-4">
            <a href="{{ route('bahan_baku.create') }}" class="px-4 py-2 font-bold bg-blue-500 text-white rounded hover:bg-blue-600">
                Tambah Data
            </a>
        </div>
        @endcan

        {{-- Filter --}}
        <div class="mb-4 bg-white shadow-md rounded-lg p-4">
            <form action="{{ route('bahan_baku.index') }}" method="GET" class="flex flex-wrap items-center gap-4">
                <label for="kode_bahan_baku" class="font-semibold text-gray-700">Jenis Bahan Baku:</label>
                <div class="flex-grow">
                    <select name="kode_bahan_baku" id="kode_bahan_baku" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-400 focus:outline-none">
                        <option value="">-- Semua --</option>
                        @foreach($jenisBahanBakus as $jenis)
                            <option value="{{ $jenis->id }}" {{ $selectedKode == $jenis->id ? 'selected' : '' }}>
                                {{ $jenis->nama_bahan_baku }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="px-6 py-2 bg-blue-500 text-white font-semibold rounded-lg shadow-md hover:bg-blue-600">
                    Filter
                </button>
            </form>
        </div>

        {{-- Tombol Print --}}
        @can('print master bahan baku')
        <a href="{{ route('bahan_baku.print', ['kode_bahan_baku' => $selectedKode]) }}"
           target="_blank"
           class="px-4 py-2 bg-red-500 text-white font-semibold rounded hover:bg-red-600">
           Print PDF
        </a>
        @endcan

        {{-- Tabel Data --}}
        <div class="overflow-x-auto mt-6">
            <table id="data_harga_sample_bahan_baku" class="min-w-full bg-white border-collapse border border-gray-300">
                <thead class="bg-gray-200">
                    <tr>
                        <th>No</th>
                        <th>Kategori Bahan Baku</th>
                        <th>Kode kategori bahan baku</th>
                        <th>Nama Bahan Baku</th>
                        <th>Nama Coding</th>
                        <th>Nama Inci</th>
                        <th>Jenis Sediaan</th>
                        <th class="w-40">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($bahanBakus as $bahanBaku)
                        <tr>
                            <td class="border px-4 py-2 text-center">{{ $loop->iteration }}</td>
                            <td class="border px-4 py-2">{{ $bahanBaku->jenisBahanBaku->nama_bahan_baku ?? '-' }}</td>
                            <td class="border px-4 py-2">{{ $bahanBaku->jenis_bahan_baku_jenis_urut }}</td>
                            <td class="border px-4 py-2">{{ $bahanBaku->koding_bahan_baku }}</td>
                            <td class="border px-4 py-2">{{ $bahanBaku->nama_coding }}</td>
                            <td class="border px-4 py-2">{{ $bahanBaku->nama_inci }}</td>
                            <td class="border px-4 py-2">{{ $bahanBaku->jenis_sediaan }}</td>
                            <td class="border px-4 py-2 whitespace-nowrap">
                                <a href="{{ route('bahan_baku.show', $bahanBaku->id) }}" class="px-4 py-2 font-bold text-white rounded inline-flex items-center bg-green-500 hover:bg-green-600">
                                    Detail
                                </a>
                                @can('edit master bahan baku')
                                <a href="{{ route('bahan_baku.edit', $bahanBaku->id) }}" class="px-4 py-2 font-bold text-white rounded inline-flex items-center" style="background-color: #FF8C00;">
                                    Edit
                                </a>
                                @endcan
                                @can('delete master bahan baku')
                                <form action="{{ route('bahan_baku.destroy', $bahanBaku->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus?')">
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

<script src="{{ asset('Modal/data_harga_sample_bahan_baku.js') }}" defer></script>
