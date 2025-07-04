@extends('layout.main')

@section('content')
<div class="w-full px-6 py-6 mx-auto mt-10">
    <div class="bg-white shadow-lg rounded-lg p-6">
        <h2 class="text-2xl font-bold mb-4">Tambah Data Kategori Bahan Baku</h2>

        <!-- Alert -->
        @if(session('success'))
        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
            <button type="button" class="absolute top-0 bottom-0 right-0 px-4 py-3" onclick="this.parentElement.style.display='none'">
                <svg class="fill-current h-6 w-6 text-green-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                    <title>Close</title>
                    <path d="M14.348 5.652a.5.5 0 00-.707 0L10 9.293 6.354 5.647a.5.5 0 10-.707.707L9.293 10l-3.646 3.646a.5.5 0 10.707.707L10 10.707l3.646 3.646a.5.5 0 10.707-.707L10.707 10l3.646-3.646a.5.5 0 000-.707z"/>
                </svg>
            </button>
        </div>
        @endif

        <!-- Form Tambah Data -->
        <form action="{{ route('jenis-bahan-baku.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-grid">

<!-- Left Column -->
<div class="form-column">
    <!-- Kode Bahan Baku -->
    <div class="form-group">
        <label for="kode_bahan_baku">Kode Kategori Bahan Baku</label>
        <input type="text" name="jenis_bahan_baku" id="jenis_bahan_baku" class="form-control"  required>
    </div>

</div>

<!-- Right Column -->
<div class="form-column">
    <!-- Satuan -->
    <div class="form-group">
        <label for="satuan">Kategori Bahan Baku</label>
        <input type="text" name="nama_bahan_baku" id="nama_bahan_baku" class="form-control" required>
    </div>

</div>

</div>

<!-- Submit Button -->
<div>
                <button type="submit" class="w-full font-bold px-4 py-2 text-white rounded-lg" style="background-color: #032859;">
                    Simpan
                </button>
                <a href="{{ route('jenis-bahan-baku.index') }}" 
   class="w-full font-bold px-4 py-2 text-white rounded-lg bg-gray-500 hover:bg-gray-600 mt-2 inline-block text-center" 
   style="background-color: #032859;">
   Batal
</a>


            </div>
</form>
</div>
</div>

<!-- Custom Styles -->
<style>
    .form-container {
        max-width: 900px;
        margin: 0 auto;
        padding: 20px;
    }

    .form-card {
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        padding: 30px;
    }

    .form-title {
        font-size: 24px;
        font-weight: bold;
        margin-bottom: 20px;
        text-align: center;
    }

    .form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }

    .form-column {
        display: flex;
        flex-direction: column;
    }

    .form-group {
        margin-bottom: 15px;
    }

    .form-group label {
        font-size: 14px;
        font-weight: 600;
        margin-bottom: 5px;
    }

    .form-group input {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 8px;
        font-size: 14px;
    }

    .form-group input:focus {
        border-color: #3182ce;
        box-shadow: 0 0 0 2px rgba(66, 153, 225, 0.4);
        outline: none;
    }

    .error-message {
        color: #e53e3e;
        font-size: 12px;
        margin-top: 5px;
    }

    .alert {
        background-color: #c6f6d5;
        color: #38a169;
        padding: 10px;
        border-radius: 5px;
        margin-bottom: 20px;
        position: relative;
    }

    .alert-close {
        position: absolute;
        top: 0;
        right: 0;
        padding: 5px;
        background: none;
        border: none;
        font-size: 18px;
        cursor: pointer;
    }

    .form-footer {
        text-align: right;
        margin-top: 20px;
    }

    .btn-submit {
        padding: 12px 20px;
        background-color: #3182ce;
        color: white;
        border: none;
        border-radius: 5px;
        font-size: 16px;
        cursor: pointer;
    }

    .btn-submit:hover {
        background-color: #2b6cb0;
    }
</style>
@endsection
