@extends('layout.main')

@section('content')
<div class="w-full px-6 py-6 mx-auto mt-10">
    <div class="bg-white shadow-lg rounded-lg p-6">
        <h2 class="text-2xl font-bold mb-4">Master Harga Sample Bahan Baku</h2>

        <!-- Alert -->
        @if(session('success'))
        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
            <span class="block sm:inline">{{ session('success') }}</span>
            <button type="button" class="absolute top-0 bottom-0 right-0 px-4 py-3" onclick="this.parentElement.style.display='none'">
                <svg class="fill-current h-6 w-6 text-green-500" viewBox="0 0 20 20">
                    <title>Close</title>
                    <path d="M14.348 5.652a.5.5 0 00-.707 0L10 9.293 6.354 5.647a.5.5 0 10-.707.707L9.293 10l-3.646 3.646a.5.5 0 10.707.707L10 10.707l3.646 3.646a.5.5 0 10.707-.707L10.707 10l3.646-3.646a.5.5 0 000-.707z"/>
                </svg>
            </button>
        </div>
        @endif

        <!-- Tombol Tambah Data -->
        <div class="mb-4">
            @can('create master harga sample bahan baku')
            <a href="{{ route('master_harga_sample_bahan_baku.create') }}" 
               class="px-4 py-2 font-bold bg-blue-500 text-white rounded hover:bg-blue-600">
                Tambah Data
            </a>
            @endcan
        </div>

        <!-- Tabel Data -->
        <div class="overflow-x-auto mt-6">
            <table id="data_harga_sample_bahan_baku" class="min-w-full bg-white border border-gray-300">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="px-4 py-2 border">No</th>
                        <th class="px-4 py-2 border">Kode</th>
                        <th class="px-4 py-2 border">Nama Bahan Baku</th>
                        <th class="px-4 py-2 border">Principle</th>
                        <th class="px-4 py-2 border">Supplier</th>
                        <th class="px-4 py-2 border">Qty</th>
                        <th class="px-4 py-2 border">Satuan</th>
                        <th class="px-4 py-2 border">Harga ($)</th>
                        <th class="px-4 py-2 border">Harga (Rp)</th>
                        <th class="px-4 py-2 border">PPN</th>
                        <th class="px-4 py-2 border">PPH</th>
                        <th class="px-4 py-2 border">Harga Total</th>
                        <th class="px-4 py-2 border">+ Additional Cost</th>
                        <th class="px-4 py-2 border">MOQ (Kg)</th>
                        <th class="px-4 py-2 border">Harga Akhir</th>
                        <th class="px-4 py-2 border">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $index => $item)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-2 border text-center">{{ $index + 1 }}</td>
                        <td class="px-4 py-2 border">{{ $item->kode_bahan_baku }}</td>
                        <td class="px-4 py-2 border">{{ $item->nama_bahan_baku }}</td>
                        <td class="px-4 py-2 border">{{ $item->principle }}</td>
                        <td class="px-4 py-2 border">{{ $item->supplier }}</td>
                        <td class="px-4 py-2 border text-right">{{ $item->qty }}</td>
                        <td class="px-4 py-2 border">{{ $item->satuan->nama_satuan ?? '-' }}</td>
                        <td class="px-4 py-2 border text-right">$ {{ number_format($item->harga_usd, 2) }}</td>
                        <td class="px-4 py-2 border text-right">Rp {{ number_format($item->harga_idr, 2, ',', '.') }}</td>
                        <td class="px-4 py-2 border text-right">Rp {{ number_format($item->ppn, 2, ',', '.') }}</td>
                        <td class="px-4 py-2 border text-right">Rp {{ number_format($item->pph, 2, ',', '.') }}</td>
                        <td class="px-4 py-2 border text-right">Rp {{ number_format($item->harga_total, 2, ',', '.') }}</td>
                        <td class="px-4 py-2 border text-center">Rp {{ number_format($item->additional_cost, 2, ',', '.') }}</td>
                        <td class="px-4 py-2 border text-center">{{ $item->moq }}</td>
                        <td class="px-4 py-2 border text-right">Rp {{ number_format($item->harga_akhir, 2, ',', '.') }}</td>
                        <td class="px-4 py-2 border text-center space-x-1">
                            @can('edit master harga sample bahan baku')
                            <a href="{{ route('master_harga_sample_bahan_baku.edit', $item->id) }}" 
                               class="px-3 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600 text-sm">
                                Edit
                            </a>
                            @endcan

                            @can('delete master harga sample bahan baku')
                            <form action="{{ route('master_harga_sample_bahan_baku.destroy', $item->id) }}" 
                                  method="POST" class="inline-block"
                                  onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700 text-sm">
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

@push('scripts')
<script src="{{ asset('Modal/harga_bahan_baku.js') }}" defer></script>
@endpush

@push('styles')
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
@endpush
