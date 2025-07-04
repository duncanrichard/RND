@extends('layout.main')

@section('content')
<div class="w-full px-6 py-6 mx-auto mt-10">
    <div class="bg-white shadow-lg rounded-lg p-6">
        <h2 class="text-2xl font-bold mb-4">Master CPB</h2>

        <!-- Tombol Tambah -->
        <div class="mb-4">
            @can('create cpb')
            <a href="{{ route('master_cpb.create') }}" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">
                Tambah Data
            </a>
            @endcan
        </div>

        <!-- Tabel Data -->
        <div class="overflow-x-auto">
            <table id="master_cpb" class="table-auto w-full text-left border-collapse border border-gray-300">
                <thead class="bg-gray-100 text-sm text-gray-700">
                    <tr>
                        <th class="px-4 py-2 border">No</th>
                        <th class="px-4 py-2 border">Nama Produk</th>
                        <th class="px-4 py-2 border">Batch Size Berat</th>
                        <th class="px-4 py-2 border">Batch Size Satuan</th>
                        <th class="px-4 py-2 border">Kode Produk</th>
                        <th class="px-4 py-2 border">Nomor CPB</th>
                        <th class="px-4 py-2 border">Dokumen</th>
                        <th class="px-4 py-2 border text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-sm">
                    @forelse($data as $index => $item)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-2 border text-center">{{ $index + 1 }}</td>
                        <td class="px-4 py-2 border">{{ $item->nama_produk }}</td>
                        <td class="px-4 py-2 border">{{ $item->batch_size_berat }}</td>
                        <td class="px-4 py-2 border">{{ $item->batch_size_satuan }}</td>
                        <td class="px-4 py-2 border">{{ $item->kode_produk }}</td>
                        <td class="px-4 py-2 border">{{ $item->nomor_cpb }}</td>
                        <td class="px-4 py-2 border text-center">
                            @can('view cpb')
                                @if($item->file_dokumen)
                                <a href="{{ asset('storage/' . $item->file_dokumen) }}" target="_blank"
                                    class="px-3 py-1 bg-yellow-400 hover:bg-yellow-300 text-white font-semibold rounded text-xs">
                                    Lihat
                                </a>
                                @else
                                <span class="text-gray-500 italic">Tidak Ada</span>
                                @endif
                            @endcan
                        </td>
                        <td class="px-4 py-2 border text-center space-x-2">
                            @can('edit cpb')
                            <a href="{{ route('master_cpb.edit', $item->id) }}"
                                class="px-3 py-1 bg-blue-500 hover:bg-blue-600 text-white font-semibold rounded text-xs">
                                Edit
                            </a>
                            @endcan

                            @can('delete cpb')
                            <form action="{{ route('master_cpb.destroy', $item->id) }}" method="POST" class="inline-block"
                                onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="px-3 py-1 bg-red-500 hover:bg-red-600 text-white font-semibold rounded text-xs">
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

<script src="{{ asset('Modal/master_cpb.js') }}" defer></script>
@endsection
