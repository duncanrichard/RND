@extends('layout.main')

@section('content')


<div class="w-full px-6 py-6 mx-auto mt-10">
    <div class="bg-white shadow-lg rounded-lg p-6">
    @if ($errors->any())
    <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-lg">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
    <h1 class="text-2xl font-bold mb-4">Tambah Master Kategori Bahan Kemas</h1>
    <form action="{{ route('kode_bahan_kemas.store') }}" method="POST" class="bg-white shadow-md rounded-lg p-4">
        @csrf
        <div class="mb-4">
            <label for="kode" class="block font-semibold">Kode Bahan Kemas</label>
            <input type="text" name="kode" id="kode" class="w-full border p-2 rounded-lg" required>
        </div>
        <div class="mb-4">
            <label for="nama_kode" class="block font-semibold">Nama Bahan Kemas</label>
            <input type="text" name="nama_kode" id="nama_kode" class="w-full border p-2 rounded-lg">
        </div>
        <div class="mb-4">
                <label for="jenis_kemasan" class="block font-semibold">Jenis Kemasan</label>
                <select name="jenis_kemasan" id="jenis_kemasan" class="w-full border p-2 rounded-lg" required>
                    <option value="">-- Pilih Jenis Kemasan --</option>
                    <option value="1">Primer</option>
                    <option value="2">Sekunder</option>
                </select>
            </div>

        <!-- Submit Button -->
        <div>
            <button type="submit" class="w-full font-bold px-4 py-2 text-white rounded-lg" style="background-color: #032859;">Simpan</button>
            <a href="{{ route('kode_bahan_kemas.index') }}" class="w-full font-bold px-4 py-2 text-white rounded-lg bg-gray-500 hover:bg-gray-600 mt-2 inline-block text-center" style="background-color: #032859;"> Batal
            </a>
        </div>
    </form>
</div>
@endsection
