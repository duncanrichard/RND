@extends('layout.main')

@section('content')
<div class="w-full px-6 py-6 mx-auto mt-10">
    <div class="bg-white shadow-lg rounded-lg p-6">
        <h2 class="text-2xl font-bold mb-4">Master List Sample Bahan Baku</h2>

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
        @can('create master bahan baku sample')
        <div class="mb-4">
            <a href="{{ route('master_bahan_baku.create') }}" 
               class="px-4 py-2 font-bold bg-blue-500 text-white rounded hover:bg-blue-600">
                Tambah Data
            </a>
        </div>
        @endcan

        <!-- Tabel Data -->
        <div class="overflow-x-auto mt-6">
            <table id="bahanBakuTable" class="min-w-full bg-white border border-gray-300">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="py-2 px-4 border-b text-center">No</th>
                        <th class="py-2 px-4 border-b text-center">Kode</th>
                        <th class="py-2 px-4 border-b text-center">Raw Material</th>
                        <th class="py-2 px-4 border-b text-center">Inci Name</th>
                        <th class="py-2 px-4 border-b text-center">Sediaan</th>
                        <th class="py-2 px-4 border-b text-center">Principle</th>
                        <th class="py-2 px-4 border-b text-center">Supplier</th>
                        <th class="py-2 px-4 border-b text-center">Function</th>
                        <th class="py-2 px-4 border-b text-center">Jumlah Di Terima</th>
                        <th class="py-2 px-4 border-b text-center">Satuan</th>
                        <th class="py-2 px-4 border-b text-center">Tgl Terima</th>
                        <th class="py-2 px-4 border-b text-center">Keterangan</th>
                        <th class="py-2 px-4 border-b text-center" style="min-width: 200px;">Status Approval</th>
                        <th class="py-2 px-4 border-b text-center" style="min-width: 200px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($bahan_baku as $key => $item)
                    <tr>
                        <td class="py-2 px-4 border-b text-center">{{ $key + 1 }}</td>
                        <td class="py-2 px-4 border-b text-center">{{ $item->kode }}</td>
                        <td class="py-2 px-4 border-b text-center">{{ $item->raw_material }}</td>
                        <td class="py-2 px-4 border-b text-center">{{ $item->inci_name }}</td>
                        <td class="py-2 px-4 border-b text-center">{{ $item->sediaan }}</td>
                        <td class="py-2 px-4 border-b text-center">{{ $item->principle }}</td>
                        <td class="py-2 px-4 border-b text-center">{{ $item->supplier }}</td>
                        <td class="py-2 px-4 border-b text-center">{{ $item->function }}</td>
                        <td class="py-2 px-4 border-b text-center">{{ $item->jumlah_diterima }}</td>
                        <td class="py-2 px-4 border-b text-center">{{ $item->satuanData->nama_satuan ?? 'Tidak Diketahui' }}</td>
                        <td class="py-2 px-4 border-b text-center">{{ $item->tgl_terima }}</td>
                        <td class="py-2 px-4 border-b text-center">{{ $item->keterangan }}</td>

                        <td class="py-2 px-4 border-b text-center">
                            @if($item->status_approval)
                                <span class="px-4 py-2 font-bold text-white bg-green-500 rounded inline-block">Approved</span>
                            @else
                                @can('approve master bahan baku sample')
                                <form action="{{ route('master_bahan_baku.toggleApproval', $item->id) }}" method="POST" class="inline-block">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="px-4 py-2 font-bold text-white bg-yellow-500 rounded hover:bg-yellow-600">
                                        Belum Approval
                                    </button>
                                </form>
                                @endcan
                            @endif
                        </td>

                        <td class="py-2 px-4 border-b text-center">
                            @can('edit master bahan baku sample')
                            <a href="{{ route('master_bahan_baku.edit', $item->id) }}" 
                               class="px-4 py-2 font-bold text-white rounded inline-flex items-center" 
                               style="background-color: #B8860B;">
                                Edit
                            </a>
                            @endcan

                            @can('delete master bahan baku sample')
                            <form action="{{ route('master_bahan_baku.destroy', $item->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
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

<script src="{{ asset('Modal/bahan_baku.js') }}" defer></script>
