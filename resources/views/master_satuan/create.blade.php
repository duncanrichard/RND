@extends('layout.main')
@section('content')
<div class="w-full px-6 py-6 mx-auto mt-10">
    <div class="bg-white shadow-lg rounded-lg p-6">
        <h2 class="text-2xl font-bold mb-4">Tambah Master Satuan</h2>
        @if ($errors->any())
        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        <form action="{{ route('master_satuan.store') }}" method="POST">
            @csrf
            <div class="mb-4">
    <label for="deskripsi" class="block text-gray-700">Kode Satuan</label>
    <input type="text" name="deskripsi" id="deskripsi" 
           class="w-full px-4 py-2 mt-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" 
           value="{{ $newCode }}" readonly>
</div>

            <div class="mb-4">
                <label for="nama_satuan" class="block text-gray-700">Nama Satuan</label>
                <input type="text" name="nama_satuan" id="nama_satuan" class="w-full px-4 py-2 mt-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>
            <button type="submit" class="px-4 py-2 font-bold text-white bg-blue-500 rounded-lg">
                Simpan
            </button>
            <a href="{{ route('master_satuan.index') }}" class="px-4 py-2 ml-2 font-bold text-gray-700 bg-gray-200 rounded-lg">
                Kembali
            </a>
        </form>
    </div>
</div>
@endsection
