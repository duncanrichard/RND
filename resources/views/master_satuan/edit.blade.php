@extends('layout.main')

@section('content')
<div class="w-full px-6 py-6 mx-auto mt-10">
    <div class="bg-white shadow-lg rounded-lg p-6">
        <h2 class="text-2xl font-bold mb-4">Update Master Satuan</h2>
        <form action="{{ route('master_satuan.update', $satuan->id) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')
            <!-- Input Kode Satuan -->
            <div>
                <label for="deskripsi" class="block text-sm font-medium">Kode Satuan</label>
                <input type="text" id="deskripsi" name="deskripsi" 
                       value="{{ $satuan->deskripsi }}" 
                       class="mt-1 block w-full border border-gray-300 rounded shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" 
                       readonly required>
            </div>
            <br>
            <!-- Input Nama Satuan -->
            <div>
                <label for="nama_satuan" class="block text-sm font-medium">Nama Satuan</label>
                <input type="text" id="nama_satuan" name="nama_satuan" 
                       value="{{ $satuan->nama_satuan }}" 
                       class="mt-1 block w-full border border-gray-300 rounded shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" 
                       required>
            </div>
            <br>
            <!-- Tombol Simpan dan Batal -->
            <div>
                <button type="submit" class="w-full font-bold px-4 py-2 text-white rounded-lg" style="background-color: #032859;">
                    Simpan Perubahan
                </button>
                <a href="{{ route('master_satuan.index') }}" 
                   class="w-full font-bold px-4 py-2 text-white rounded-lg bg-gray-500 hover:bg-gray-600 mt-2 inline-block text-center" style="background-color: #032859;">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
