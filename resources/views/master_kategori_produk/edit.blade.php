@extends('layout.main')

@section('content')
<div class="w-full px-6 py-6 mx-auto mt-10">
    <div class="bg-white shadow-lg rounded-lg p-6">
        <h2 class="text-2xl font-bold mb-4">Edit Kategori Produk Jadi</h2>
        <form action="{{ route('master_kategori_produk.update', $category->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label for="kode" class="block font-semibold">Kode</label>
                <input type="text" name="kode" id="kode" value="{{ $category->kode }}" class="w-full border p-2 rounded-lg"  required>
            </div>
            <div class="mb-4">
                <label for="nama_kategori" class="block font-semibold">Nama Kategori</label>
                <input type="text" name="nama_kategori" id="nama_kategori" value="{{ $category->nama_kategori }}" class="w-full border p-2 rounded-lg" required>
            </div>
            <div>
                <button type="submit" class="w-full font-bold px-4 py-2 text-white rounded-lg" style="background-color: #032859;">Simpan</button>
                <a href="{{ route('master_kategori_produk.index') }}"  class="w-full font-bold px-4 py-2 text-white rounded-lg bg-gray-500 hover:bg-gray-600 mt-2 inline-block text-center" style="background-color: #032859;">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
