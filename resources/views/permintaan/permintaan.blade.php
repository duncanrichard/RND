@extends('layout.main')

@section('content')
<div class="w-full px-6 py-6 mx-auto mt-10">
    <div class="bg-white shadow-lg rounded-lg p-6">
        <h2 class="text-2xl font-bold mb-4">Permintaan</h2>

        @can('create permintaan')
        <div class="mb-4 text-right">
            <a href="{{ route('permintaan.create') }}" class="px-4 py-2 font-bold bg-blue-500 text-white rounded hover:bg-blue-600">
                Tambah Permintaan
            </a>
        </div>
        @endcan

        <div class="overflow-x-auto mt-6">
            <table id="permintaan_table" class="display nowrap w-full">
                <thead>
                    <tr>
                        <th class="px-1 py-1">No</th>
                        <th class="px-1 py-1">Nomor Permintaan Barang</th>
                        <th class="px-1 py-1">Nama Gudang</th>
                        <th class="px-1 py-1">Jenis Permintaan</th>
                        <th class="px-1 py-1">Tujuan Permintaan Barang</th>
                        <th class="px-1 py-1">Departemen</th>
                        <th class="px-1 py-1">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $key => $item)
                    <tr class="w-full border-b hover:bg-gray-100">
                        <td class="px-1 py-1">{{ $key+1 }}</td>
                        <td class="px-1 py-1">{{ $item->nomor_permintaan_barang }}</td>
                        <td class="px-1 py-1">{{ $item->nama_gudang }}</td>
                        <td class="px-1 py-1">{{ $item->jenis_permintaan }}</td>
                        <td class="px-1 py-1">{{ $item->tujuan_permintaan_barang }}</td>
                        <td class="px-1 py-1">{{ $item->departemen }}</td>
                        <td class="px-1 py-1">
                            <div class="flex items-center space-x-2">
                                @can('detail permintaan')
                                <a href="{{ route('permintaan.detail', ['id' => $item->id]) }}" class="px-4 py-2 font-bold text-white rounded bg-purple-600 hover:bg-purple-700">
                                    Detail
                                </a>
                                @endcan

                                @can('edit permintaan')
                                <a href="{{ route('permintaan.edit', $item->id) }}" class="px-4 py-2 font-bold text-white rounded bg-orange-500 hover:bg-orange-600">
                                    Edit
                                </a>
                                @endcan

                                @can('delete permintaan')
                                <form action="{{ route('permintaan.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-4 py-2 font-bold text-white rounded bg-red-500 hover:bg-red-600">
                                        Hapus
                                    </button>
                                </form>
                                @endcan
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="{{ asset('Modal/permintaan.js') }}" defer></script>
@endsection
