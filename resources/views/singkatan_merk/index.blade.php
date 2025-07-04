@extends('layout.main')

@section('content')
<div class="w-full px-6 py-6 mx-auto mt-10">
    <div class="bg-white shadow-lg rounded-lg p-6">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-2xl font-bold text-gray-800">Data Singkatan Merk</h2>

            @can('create singkatan merk')
            <a href="{{ route('singkatan-merk.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded-lg mb-4 inline-block">
                Tambah Data
            </a>
            @endcan
        </div>

        @if(session('success'))
            <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        <table id="singkatan_merk" class="min-w-full bg-white border border-gray-300 rounded-lg">
            <thead class="bg-gray-200 text-gray-700">
                <tr>
                    <th class="py-3 px-4 border-b text-left">No</th>
                    <th class="py-3 px-4 border-b text-left">Nama Merk</th>
                    <th class="py-3 px-4 border-b text-left">Singkatan</th>
                    <th class="py-3 px-4 border-b text-left">Tahun</th>
                    <th class="py-3 px-4 border-b text-left">Lokasi</th>
                    <th class="py-3 px-4 border-b text-left w-48">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($data as $key => $row)
                <tr class="hover:bg-gray-50">
                    <td class="py-2 px-4 border-b">{{ $key + 1 }}</td>
                    <td class="py-2 px-4 border-b">{{ $row->nama_merk }}</td>
                    <td class="py-2 px-4 border-b">{{ $row->singkatan_merk }}</td>
                    <td class="py-2 px-4 border-b">{{ $row->tahun }}</td>
                    <td class="py-2 px-4 border-b">{{ $row->lokasi }}</td>
                    <td class="py-2 px-4 border-b whitespace-nowrap space-x-2">
                        @can('edit singkatan merk')
                        <a href="{{ route('singkatan-merk.edit', $row->id) }}" class="px-4 py-2 font-bold text-white rounded inline-flex items-center" style="background-color: #FF8C00;">Edit</a>
                        @endcan

                        @can('delete singkatan merk')
                        <form action="{{ route('singkatan-merk.destroy', $row->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-4 py-2 font-bold text-white rounded inline-flex items-center" style="background-color: #ef4444;">
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
<script src="{{ asset('Modal/singkatan_merk.js') }}" defer></script>
@endsection
