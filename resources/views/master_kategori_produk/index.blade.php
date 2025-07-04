@extends('layout.main')

@section('content')
<div class="w-full px-6 py-6 mx-auto mt-10">
    <div class="bg-white shadow-lg rounded-lg p-6">
        <h2 class="text-2xl font-bold mb-4">Master Kategori Produk Jadi</h2>

        @can('create master kategori produk jadi')
        <a href="{{ route('master_kategori_produk.create') }}"
           class="px-4 py-2 text-white bg-blue-500 rounded hover:bg-blue-600 mb-4 inline-block">
           Tambah Kategori
        </a>
        @endcan

        <div class="overflow-x-auto mt-4">
            <table id="Master_Kategori_Produk" class="min-w-full bg-white border border-gray-300 rounded">
                <thead class="bg-gray-200 text-gray-700 uppercase text-sm">
                    <tr>
                        <th class="py-3 px-6 text-left">No</th>
                        <th class="py-3 px-6 text-left">Kode</th>
                        <th class="py-3 px-6 text-left">Nama Kategori</th>
                        <th class="py-3 px-6 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $category)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="py-3 px-6 text-center">{{ $loop->iteration }}</td>
                            <td class="py-3 px-6">{{ $category->kode }}</td>
                            <td class="py-3 px-6">{{ $category->nama_kategori }}</td>
                            <td class="py-3 px-6 text-center space-x-2 whitespace-nowrap">
                                @can('edit master kategori produk jadi')
                                <a href="{{ route('master_kategori_produk.edit', $category->id) }}"
                                   class="px-3 py-1 bg-yellow-500 text-white rounded text-sm hover:bg-yellow-600">
                                   Edit
                                </a>
                                @endcan

                                @can('delete master kategori produk jadi')
                                <form action="{{ route('master_kategori_produk.destroy', $category->id) }}"
                                      method="POST" class="inline-block"
                                      onsubmit="return confirm('Yakin ingin menghapus kategori ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="px-3 py-1 bg-red-500 text-white rounded text-sm hover:bg-red-600">
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

<script src="{{ asset('Modal/Master_Kategori_Produk.js') }}" defer></script>
@endsection
