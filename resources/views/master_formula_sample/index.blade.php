@extends('layout.main')

@section('content')
<div class="w-full px-6 py-6 mx-auto mt-10">
    <div class="bg-white shadow-lg rounded-lg p-6">
        <h2 class="text-2xl font-bold mb-4">Master Formula Sample</h2>

        {{-- Tombol Tambah Data --}}
        @can('create master formula sample')
        <a href="{{ route('master_formula_sample.create') }}"
           class="px-4 py-2 font-bold bg-blue-500 text-white rounded hover:bg-blue-600">
            Tambah Data
        </a>
        @endcan

        {{-- Filter Merk --}}
        <div class="mt-4 mb-4">
            <form method="GET" action="{{ route('master_formula_sample.index') }}" class="flex gap-4 items-center">
                <select name="merk" class="border border-gray-300 rounded-lg py-2 px-3">
                    <option value="">-- Semua Merk --</option>
                    @foreach ($listMerk as $merk)
                        <option value="{{ $merk->nama_merk }}" {{ $merk->nama_merk == $merkFilter ? 'selected' : '' }}>
                            {{ $merk->nama_merk }}
                        </option>
                    @endforeach
                </select>
                <button type="submit" class="px-4 py-2 font-bold text-white bg-blue-500 rounded hover:bg-blue-600">
                    Filter
                </button>
            </form>
        </div>

        {{-- Tabel --}}
        <div class="overflow-x-auto mt-4">
            <table id="formula_sample" class="min-w-full bg-white border border-gray-300 rounded-lg">
                <thead class="bg-gray-200 text-gray-700">
                    <tr>
                        <th class="py-2 px-4 text-left border-b">#</th>
                        <th class="py-2 px-4 text-left border-b">No Formula</th>
                        <th class="py-2 px-4 text-left border-b">Tanggal</th>
                        <th class="py-2 px-4 text-left border-b">Kode Sample</th>
                        <th class="py-2 px-4 text-left border-b">Nama Sample</th>
                        <th class="py-2 px-4 text-left border-b">Bahan Aktif</th>
                        <th class="py-2 px-4 text-left border-b">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($data as $item)
                    <tr class="hover:bg-gray-50">
                        <td class="py-2 px-4 border-b">{{ $loop->iteration }}</td>
                        <td class="py-2 px-4 border-b">{{ $item->nomor_formula }}</td>
                        <td class="py-2 px-4 border-b">{{ $item->tanggal }}</td>
                        <td class="py-2 px-4 border-b">{{ $item->kode_sample }}</td>
                        <td class="py-2 px-4 border-b">{{ $item->nama_sample }}</td>
                        <td class="py-2 px-4 border-b">{{ $item->bahan_aktif }}</td>
                        <td class="py-2 px-4 border-b">
                            <div class="flex flex-wrap gap-1">
                                @can('view master formula sample')
                                <a href="{{ route('master_formula_sample.show', $item->id) }}"
                                   class="px-3 py-1 text-white bg-green-600 rounded hover:bg-green-700 text-sm">
                                   Detail
                                </a>
                                @endcan

                                @can('edit master formula sample')
                                <a href="{{ route('master_formula_sample.edit', $item->id) }}"
                                   class="px-3 py-1 text-white bg-blue-600 rounded hover:bg-blue-700 text-sm">
                                   Edit
                                </a>
                                @endcan

                                @can('delete master formula sample')
                                <form action="{{ route('master_formula_sample.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-3 py-1 text-white bg-red-600 rounded hover:bg-red-700 text-sm">
                                        Hapus
                                    </button>
                                </form>
                                @endcan
                            </div>
                        </td>
                    </tr>
                    @empty
                    
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
<script src="{{ asset('Modal/formula_sample.js') }}" defer></script>
@endsection
