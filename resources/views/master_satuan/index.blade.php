@extends('layout.main')

@section('content')
<div class="w-full px-6 py-6 mx-auto mt-10">
    <div class="bg-white shadow-lg rounded-lg p-6">
        <h2 class="text-2xl font-bold mb-4">Master Satuan</h2>

        @if(session('success'))
        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
        @endif

        {{-- Tombol Tambah Data hanya muncul jika punya permission --}}
        @can('create master satuan')
        <div class="flex justify-end mb-4">
            <a href="{{ route('master_satuan.create') }}" class="px-4 py-2 font-bold bg-blue-500 text-white rounded inline-flex items-right ml-auto">
                Tambah Data
            </a>
        </div>
        @endcan

        <div class="overflow-x-auto">
            <table id="satuan_table" class="display nowrap w-full">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode</th>
                        <th>Satuan</th>
                        @canany(['edit master satuan', 'delete master satuan'])
                        <th>Aksi</th>
                        @endcanany
                    </tr>
                </thead>
                <tbody>
                    @foreach($satuan as $item)
                    <tr class="hover:bg-gray-100 border-b">
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td class="text-center">{{ $item->deskripsi }}</td>
                        <td class="text-center">{{ $item->nama_satuan }}</td>
                        @canany(['edit master satuan', 'delete master satuan'])
                        <td class="text-center">
                            <div class="flex justify-center space-x-2">
                                @can('edit master satuan')
                                <a href="{{ route('master_satuan.edit', $item->id) }}"
                                  class="px-4 py-2 font-bold text-white rounded inline-flex items-center" 
                                  style="background-color: #FF8C00;"> 
                                    Update
                                </a>
                                @endcan

                                @can('delete master satuan')
                                <form action="{{ route('master_satuan.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-4 py-2 font-bold text-white rounded inline-flex items-center" style="background-color: #ef4444;">
                                        Hapus
                                    </button>
                                </form>
                                @endcan
                            </div>
                        </td>
                        @endcanany
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="{{ asset('Modal/satuan.js') }}" defer></script>
@endsection
