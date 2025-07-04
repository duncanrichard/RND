@extends('layout.main')

@section('content')
<div class="w-full px-6 py-6 mx-auto mt-10">
    <div class="bg-white shadow-lg rounded-lg p-6">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-2xl font-bold text-gray-800">Edit Singkatan Merk</h2>
            <a href="{{ route('singkatan-merk.index') }}" class="text-blue-600 hover:underline">← Kembali</a>
        </div>

        <form action="{{ route('singkatan-merk.update', $merk->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="nama_merk" class="block text-gray-700 font-semibold mb-2">Nama Merk</label>
                <input type="text" name="nama_merk" id="nama_merk" value="{{ old('nama_merk', $merk->nama_merk) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                @error('nama_merk')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4">
                <label for="singkatan_merk" class="block text-gray-700 font-semibold mb-2">Singkatan Merk</label>
                <input type="text" name="singkatan_merk" id="singkatan_merk" value="{{ old('singkatan_merk', $merk->singkatan_merk) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                @error('singkatan_merk')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4">
                <label for="tahun" class="block text-gray-700 font-semibold mb-2">Tahun</label>
                <select name="tahun" id="tahun" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    <option value="">-- Pilih Tahun --</option>
                    @for ($year = now()->year; $year >= 2000; $year--)
                        <option value="{{ $year }}" {{ old('tahun', $merk->tahun) == $year ? 'selected' : '' }}>{{ $year }}</option>
                    @endfor
                </select>
                @error('tahun')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-6">
                <label for="lokasi" class="block text-gray-700 font-semibold mb-2">Lokasi</label>
                <input type="text" name="lokasi" id="lokasi" value="{{ old('lokasi', $merk->lokasi) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                @error('lokasi')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <button type="submit" class="w-full font-bold px-4 py-2 text-white rounded-lg" style="background-color: #032859;">
                    Update
                </button>
                <a href="{{ route('singkatan-merk.index') }}"
                   class="w-full font-bold px-4 py-2 text-white rounded-lg bg-gray-500 hover:bg-gray-600 mt-2 inline-block text-center">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
