@extends('layout.main')

@section('content')
<div class="w-full px-6 py-6 mx-auto mt-10">
    <div class="bg-white shadow-lg rounded-lg p-6">
        <h2 class="text-2xl font-bold mb-4">Update Kategori Bahan Baku</h2>
        <form action="{{ route('kategori_bahan_baku.update', $data->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div>
                <label for="kode_kategori" class="block text-sm font-medium text-gray-700">Kode Kategori</label>
                <input type="text" name="kode_kategori" id="kode_kategori" 
                       class="mt-1 block w-full border border-gray-300 rounded py-2 px-3" 
                       value="{{ $data->kode_kategori }}" required>
            </div>
            <br>
            <div>
                <label for="nama_kategori" class="block text-sm font-medium text-gray-700">Nama Kategori</label>
                <input type="text" name="nama_kategori" id="nama_kategori" 
                       class="mt-1 block w-full border border-gray-300 rounded py-2 px-3" 
                       value="{{ $data->nama_kategori }}" required>
            </div>
            <br>
            <div>
                <button type="submit" class="w-full font-bold px-4 py-2 text-white rounded-lg" style="background-color: #032859;">
                    Simpan
                </button>
                <a href="{{ route('kategori_bahan_baku.index') }}" 
                   class="w-full font-bold px-4 py-2 text-white rounded-lg bg-gray-500 hover:bg-gray-600 mt-2 inline-block text-center" style="background-color: #032859;">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
