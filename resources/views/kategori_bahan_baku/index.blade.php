@extends('layout.main')
@section('content')
<div class="w-full px-6 py-6 mx-auto mt-10">
    <div class="bg-white shadow-lg rounded-lg p-6">
        <h2 class="text-2xl font-bold mb-4">Kode Kategori Bahan Baku</h2>

        <!-- Alert -->
        @if(session('success'))
        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
            <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                <svg class="fill-current h-6 w-6 text-green-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                    <title>Close</title>
                    <path d="M14.348 5.652a.5.5 0 00-.707 0L10 9.293 6.354 5.647a.5.5 0 10-.707.707L9.293 10l-3.646 3.646a.5.5 0 10.707.707L10 10.707l3.646 3.646a.5.5 0 10.707-.707L10.707 10l3.646-3.646a.5.5 0 000-.707z"/>
                </svg>
            </span>
        </div>
        @endif

        <!-- Tombol Tambah Data -->
        <div class="mb-4">
            <a href="{{ route('kategori_bahan_baku.create') }}" 
               class="px-4 py-2 font-bold bg-blue-500 text-white rounded hover:bg-blue-600">
                Tambah Data
            </a>
        </div>

        <!-- Tabel Data -->
        <div class="overflow-x-auto mt-6">
            <table id="kode_kategori_bahan_baku" class="min-w-full bg-white border border-gray-300">
                <thead class="bg-gray-200">
                <tr>
                    <th class="px-4 py-2 border border-gray-300">No</th>
                    <th class="px-4 py-2 border border-gray-300">Kode Kategori</th>
                    <th class="px-4 py-2 border border-gray-300">Nama Kategori</th>
                    <th class="px-4 py-2 border border-gray-300">Aksi</th>
                </tr>
                </thead>
                <tbody>
                @foreach($data as $index => $item)
                <tr>
                    <td class="px-4 py-2 border border-gray-300">{{ $index + 1 }}</td>
                    <td class="px-4 py-2 border border-gray-300">{{ $item->kode_kategori }}</td>
                    <td class="px-4 py-2 border border-gray-300">{{ $item->nama_kategori }}</td>
                    <td class="px-4 py-2 border border-gray-300">
                        <a href="{{ route('kategori_bahan_baku.edit', $item->id) }}"  class="px-4 py-2 font-bold text-white rounded inline-flex items-center" style="background-color: #FF8C00;">Edit</a>
                        <form action="{{ route('kategori_bahan_baku.destroy', $item->id) }}" method="POST" class="inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-4 py-2 font-bold text-white rounded inline-flex items-center" style="background-color: #ef4444;">Hapus</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
            </table>
        </div>
    </div>
</div>
@endsection


<script src="{{ asset('Modal/kode_kategori_bahan_baku.js') }}" defer></script>
