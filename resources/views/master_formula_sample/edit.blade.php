@extends('layout.main')

@section('content')
<div class="w-full px-6 py-6 mx-auto mt-10">
    <div class="bg-white shadow-lg rounded-lg p-6">
        <h2 class="text-2xl font-bold mb-4">Edit Master Formula Sample</h2>

        <form action="{{ route('master_formula_sample.update', $formulaSample->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-2 gap-8">
                <!-- Bagian Kiri -->
                <div>
                    <!-- Nomor Formula Sample -->
                    <div class="mb-4">
                        <label for="nomor_formula" class="block text-sm font-medium text-gray-700">Nomor Formula Sample</label>
                        <input type="text" name="nomor_formula" id="nomor_formula"
                            class="block w-full mt-1 border border-gray-300 rounded-lg shadow-sm py-2 px-3"
                            value="{{ $formulaSample->nomor_formula }}" readonly required>
                    </div>

                    <!-- Tanggal -->
                    <div class="mb-4">
                        <label for="tanggal" class="block text-sm font-medium text-gray-700">Tanggal</label>
                        <input type="date" name="tanggal" id="tanggal"
                            class="block w-full mt-1 border border-gray-300 rounded-lg shadow-sm py-2 px-3"
                            value="{{ $formulaSample->tanggal }}" required>
                    </div>

                    <!-- ID Input -->
                    <div class="mb-4">
                        <label for="id_input" class="block text-sm font-medium text-gray-700">ID Input</label>
                        <input type="text" name="id_input" id="id_input"
                            class="block w-full mt-1 border border-gray-300 rounded-lg shadow-sm py-2 px-3"
                            value="{{ $formulaSample->id_input }}" required>
                    </div>
                </div>

                <!-- Bagian Kanan -->
                <div>
                    <!-- Kode Sample -->
                    <div class="mb-4">
                        <label for="kode_sample" class="block text-sm font-medium text-gray-700">Kode Sample</label>
                        <input type="text" name="kode_sample" id="kode_sample"
                            class="block w-full mt-1 border border-gray-300 rounded-lg shadow-sm py-2 px-3"
                            value="{{ $formulaSample->kode_sample }}" readonly>
                    </div>

                    <!-- Nama Sample -->
                    <div class="mb-4">
                        <label for="nama_sample" class="block text-sm font-medium text-gray-700">Nama Sample</label>
                        <input type="text" name="nama_sample" id="nama_sample"
                            class="block w-full mt-1 border border-gray-300 rounded-lg shadow-sm py-2 px-3"
                            value="{{ $formulaSample->nama_sample }}" required>
                    </div>

                    <!-- Bahan Aktif -->
                    <div class="mb-4">
                        <label for="bahan_aktif" class="block text-sm font-medium text-gray-700">Bahan Aktif</label>
                        <input type="text" name="bahan_aktif" id="bahan_aktif"
                            class="block w-full mt-1 border border-gray-300 rounded-lg shadow-sm py-2 px-3"
                            value="{{ $formulaSample->bahan_aktif }}" required>
                    </div>
                </div>
            </div>

            <div class="mt-6">
                <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 font-bold">
                    Update Data
                </button>
                <a href="{{ route('master_formula_sample.index') }}" class="ml-4 px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
