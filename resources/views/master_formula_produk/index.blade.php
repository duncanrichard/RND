@extends('layout.main')

@section('content')
<div class="w-full px-6 py-6 mx-auto mt-10">
    <div class="bg-white shadow-lg rounded-lg p-6">
        <h2 class="text-2xl font-bold mb-4">Master Formula Produk Jadi</h2>

        {{-- Tombol Tambah --}}
        @can('create master formula produk jadi')
        <div class="mb-4">
            <a href="{{ route('master_formula_produk.create') }}"
               class="px-4 py-2 text-white bg-blue-500 rounded-lg hover:bg-blue-600">
                Tambah Formula
            </a>
        </div>
        @endcan

        {{-- Tabel Data --}}
        <div class="overflow-x-auto">
            <table id="master_formula_produk" class="min-w-full bg-white border border-gray-300 rounded-lg">
                <thead class="bg-gray-200 text-gray-700">
                    <tr>
                        <th class="py-3 px-6 text-left">No</th>
                        <th class="py-3 px-6 text-left">Nomor Formula</th>
                        <th class="py-3 px-6 text-left">Tanggal</th>
                        <th class="py-3 px-6 text-left">Kode Produk</th>
                        <th class="py-3 px-6 text-left">Nama Produk</th>
                        <th class="py-3 px-6 text-left">Nama Merk</th>
                        <th class="py-3 px-6 text-left">Kategori</th>
                        <th class="py-3 px-6 text-left">Netto</th>
                        <th class="py-3 px-6 text-left">Batch Size Berat</th>
                        <th class="py-3 px-6 text-left">Satuan</th>
                        <th class="py-3 px-6 text-left">Batch Size Satuan</th>
                        <th class="py-3 px-6 text-left">Satuan</th>
                        <th class="py-3 px-6 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700">
                    @forelse($formulas as $formula)
                    <tr class="hover:bg-gray-50">
                        <td class="border px-4 py-2 text-center">{{ $loop->iteration }}</td>
                        <td class="py-3 px-6">{{ $formula->nomor_formula }}</td>
                        <td class="py-3 px-6">{{ \Carbon\Carbon::parse($formula->tanggal)->format('d-m-Y') }}</td>
                        <td class="py-3 px-6">{{ $formula->kode_produk }}</td>
                        <td class="py-3 px-6">{{ $formula->nama_produk }}</td>
                        <td class="py-3 px-6">{{ $formula->nama_merek }}</td>
                        <td class="py-3 px-6">{{ $formula->kategori }}</td>
                        <td class="py-3 px-6">{{ $formula->netto }}</td>
                        <td class="py-3 px-6">{{ $formula->batch_size_berat }}</td>
                        <td class="py-3 px-6">{{ $formula->satuan_berat }}</td>
                        <td class="py-3 px-6">{{ $formula->batch_size_satuan }}</td>
                        <td class="py-3 px-6">{{ $formula->jenis_satuan }}</td>
                        <td class="py-3 px-6 text-center space-x-2 whitespace-nowrap">
                            @can('detail master formula produk jadi')
                            <a href="{{ route('master_formula_produk.show', $formula->id) }}"
                               class="px-4 py-2 bg-blue-600 text-white text-sm rounded hover:bg-blue-700">
                                Detail
                            </a>
                            @endcan

                            @can('edit master formula produk jadi')
                            <a href="{{ route('master_formula_produk.edit', $formula->id) }}"
                               class="px-4 py-2 bg-yellow-500 text-white text-sm rounded hover:bg-yellow-600">
                                Edit
                            </a>
                            @endcan

                            @can('delete master formula produk jadi')
                            <form action="{{ route('master_formula_produk.destroy', $formula->id) }}"
                                  method="POST" class="inline-block"
                                  onsubmit="return confirm('Yakin ingin menghapus formula ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-4 py-2 bg-red-500 text-white text-sm rounded hover:bg-red-600">
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
@endsection

{{-- JS --}}
<script src="{{ asset('Modal/master_formula_produk.js') }}" defer></script>

{{-- Optional Styling --}}
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
