@extends('layout.main')

@section('content')
<div class="w-full px-6 py-6 mx-auto mt-10">
    <div class="bg-white shadow-lg rounded-lg p-6">
        <h2 class="text-2xl font-bold mb-4">Master CKB</h2>

        <!-- Tombol Tambah -->
        @can('create master ckb')
        <div class="mb-4">
            <a href="{{ route('master_ckb.create') }}" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">Tambah Data</a>
        </div>
        @endcan

        <!-- Tabel Data -->
        <div class="overflow-x-auto" style="max-width: 100%; overflow-x: auto;">
            <table id="master_ckb" class="table-auto w-full text-left border-collapse border border-gray-300">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2 border border-gray-300">No</th>
                        <th class="px-4 py-2 border border-gray-300">Nama Produk</th>
                        <th class="px-4 py-2 border border-gray-300">Batch Size Berat</th>
                        <th class="px-4 py-2 border border-gray-300">Batch Size Satuan</th>
                        <th class="px-4 py-2 border border-gray-300">Kode Produk</th>
                        <th class="px-4 py-2 border border-gray-300">Nomor CKB</th>
                        <th class="px-4 py-2 border border-gray-300">Dokumen</th>
                        <th class="px-4 py-2 border border-gray-300" style="width: 200px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $index => $item)
                        <tr>
                            <td class="px-4 py-2 border border-gray-300">{{ $index + 1 }}</td>
                            <td class="px-4 py-2 border border-gray-300">{{ $item->nama_produk }}</td>
                            <td class="px-4 py-2 border border-gray-300">{{ $item->batch_size_berat }}</td>
                            <td class="px-4 py-2 border border-gray-300">{{ $item->batch_size_satuan }}</td>
                            <td class="px-4 py-2 border border-gray-300">{{ $item->kode_produk }}</td>
                            <td class="px-4 py-2 border border-gray-300">{{ $item->nomor_cpb }}</td>
                            <td class="px-4 py-2 border border-gray-300">
                                @if($item->file_dokumen)
                                    <a href="{{ asset('storage/' . $item->file_dokumen) }}" target="_blank" class="px-4 py-2 font-bold text-white rounded inline-flex items-center" style="background-color: #FFD700;">Lihat</a>
                                @else
                                    Tidak Ada
                                @endif
                            </td>
                            <td class="px-4 py-2 border border-gray-300">
                                @can('edit master ckb')
                                <a href="{{ route('master_ckb.edit', $item->id) }}" class="px-4 py-2 font-bold text-white rounded inline-flex items-center bg-blue-500 hover:bg-blue-600">Edit</a>
                                @endcan

                                @can('delete master ckb')
                                <form action="{{ route('master_ckb.destroy', $item->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-4 py-2 font-bold text-white rounded inline-flex items-center" style="background-color: #ef4444;" onclick="return confirm('Yakin ingin menghapus formula ini?')">Hapus</button>
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

<script src="{{ asset('Modal/master_ckb.js') }}" defer></script>
@endsection
