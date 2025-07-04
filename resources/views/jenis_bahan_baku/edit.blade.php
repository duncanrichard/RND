@extends('layout.main')

@section('content')
<div class="w-full px-6 py-6 mx-auto mt-10">
    <div class="bg-white shadow-lg rounded-lg p-6">
        <h2 class="text-2xl font-bold mb-4 text-center text-blue-700">Update Jenis Bahan Baku</h2>
        
        <form action="{{ route('jenis-bahan-baku.update', $jenisBahanBaku->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Grid Layout for Fields -->
            <div class="grid grid-cols-2 gap-4">
                <!-- Jenis Bahan Baku Input -->
                <div>
                    <label for="jenis_bahan_baku" class="block text-sm font-medium text-gray-700">Kode Kategori Bahan Baku</label>
                    <input type="text" name="jenis_bahan_baku" id="jenis_bahan_baku" 
                           value="{{ $jenisBahanBaku->jenis_bahan_baku }}" 
                           class="mt-1 block w-full border border-gray-300 rounded shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" 
                           required>
                </div>

                <!-- Nama Bahan Baku Input -->
                <div>
                    <label for="nama_bahan_baku" class="block text-sm font-medium text-gray-700">Kategori Bahan Baku</label>
                    <input type="text" name="nama_bahan_baku" id="nama_bahan_baku" 
                           value="{{ $jenisBahanBaku->nama_bahan_baku }}" 
                           class="mt-1 block w-full border border-gray-300 rounded shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" 
                           required>
                </div>
            </div>
<br>
            <!-- Action Buttons -->
            <div>
                <button type="submit" class="w-full font-bold px-4 py-2 text-white rounded-lg" style="background-color: #032859;">
                    Simpan
                </button>
                <a href="{{ route('jenis-bahan-baku.index') }}" 
                   class="w-full font-bold px-4 py-2 text-white rounded-lg bg-gray-500 hover:bg-gray-600 mt-2 inline-block text-center" style="background-color: #032859;">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
