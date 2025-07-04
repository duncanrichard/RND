@extends('layout.main')

@section('content')
<div class="w-full px-6 py-6 mx-auto mt-10">
    <div class="bg-white shadow-lg rounded-lg p-6">
        <h2 class="text-2xl font-bold mb-4">Tambah Master Bahan Baku</h2>

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
        <form action="{{ route('bahan_baku.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-grid">

<!-- Left Column -->
<div class="form-column">
<div class="form-group">
    <label for="kode_nama_bahan_baku">Jenis Bahan Baku</label>
    <select name="kode_nama_bahan_baku" id="kode_nama_bahan_baku" class="select2" required>
        <option value="" disabled selected>Pilih Nama Bahan Baku</option>
        @foreach ($jenisBahanBakus as $jenis)
            <option value="{{ $jenis->id }}"
                {{ old('kode_nama_bahan_baku', $bahanBaku->kode_nama_bahan_baku ?? '') == $jenis->id ? 'selected' : '' }}>
                {{ $jenis->nama_bahan_baku }}
            </option>
        @endforeach
    </select>
    @error('kode_nama_bahan_baku')
        <div class="error-message">{{ $message }}</div>
    @enderror
</div>





<!-- Koding Bahan Baku -->
<div class="form-group">
    <label for="koding_bahan_baku">Nama Bahan Baku</label>
    <input type="text" name="koding_bahan_baku" id="koding_bahan_baku" value="{{ old('koding_bahan_baku') }}" required>
    @error('koding_bahan_baku')
        <div class="error-message">{{ $message }}</div>
    @enderror
</div>

    <!-- Nama Coding -->
    <div class="form-group">
        <label for="nama_coding">Nama Coding</label>
        <input type="text" name="nama_coding" id="nama_coding" value="{{ old('nama_coding') }}" required>
        @error('nama_coding')
            <div class="error-message">{{ $message }}</div>
        @enderror
    </div>

    <!-- Nama Inci -->
    <div class="form-group">
        <label for="nama_inci">Nama Inci</label>
        <input type="text" name="nama_inci" id="nama_inci" value="{{ old('nama_inci') }}" required>
        @error('nama_inci')
            <div class="error-message">{{ $message }}</div>
        @enderror
    </div>

    <!-- Jenis Sediaan -->
    <div class="form-group">
        <label for="jenis_sediaan">Jenis Sediaan</label>
        <input type="text" name="jenis_sediaan" id="jenis_sediaan" value="{{ old('jenis_sediaan') }}" required>
        @error('jenis_sediaan')
            <div class="error-message">{{ $message }}</div>
        @enderror
    </div>

<!-- Form Upload CoA -->
<div class="form-group">
    <label for="coa_file">Upload CoA</label>
    <input type="file" name="coa_file" id="coa_file" accept=".pdf" class="form-control">
    @error('coa_file')
        <div class="error-message">{{ $message }}</div>
    @enderror
</div>


<!-- Form Upload MSDS -->
<div class="form-group">
    <label for="msds_file">Upload MSDS</label>
    <input type="file" name="msds_file" id="msds_file" accept=".pdf" class="form-control">
    @error('msds_file')
        <div class="error-message">{{ $message }}</div>
    @enderror
</div>
</div>

<!-- Right Column -->
<div class="form-column">
    <!-- Satuan -->
    <div class="form-group">
    <label for="satuan">Satuan</label>
                        <select name="satuan" id="satuan" class="select2" required>
                            <option value="" disabled selected>Pilih Satuan</option>
                            @foreach ($satuans as $satuan)
                                <option value="{{ $satuan->id }}" {{ old('satuan') == $satuan->id ? 'selected' : '' }}>
                                    {{ $satuan->nama_satuan }}
                                </option>
                            @endforeach
                        </select>
                        @error('satuan')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
    </div>

    <!-- Cara Penyimpanan -->
    <div class="form-group">
        <label for="cara_penyimpanan">Cara Penyimpanan</label>
        <input type="text" name="cara_penyimpanan" id="cara_penyimpanan" value="{{ old('cara_penyimpanan') }}" required>
        @error('cara_penyimpanan')
            <div class="error-message">{{ $message }}</div>
        @enderror
    </div>

    <!-- Harga PO -->
    <div class="form-group">
        <label for="harga_po">Harga PO</label>
        <input type="number" name="harga_po" id="harga_po" value="{{ old('harga_po') }}" step="0.01" required>
        @error('harga_po')
            <div class="error-message">{{ $message }}</div>
        @enderror
    </div>

<!-- PPN -->
<div class="form-group">
    <label for="ppn">PPN (Rp)</label>
    <input type="number" name="ppn" id="ppn" value="{{ old('ppn') }}" step="0.01" readonly required>
    @error('ppn')
        <div class="error-message">{{ $message }}</div>
    @enderror
</div>


<div class="form-group">
    <label for="mark_up">Additional Cost</label>
    <input
        type="number"
        name="mark_up"
        id="mark_up"
        value="{{ old('mark_up', $markUp) }}"
        step="0.01"
        readonly
        required
    >
    @error('mark_up')
    <div class="error-message">{{ $message }}</div>
    @enderror
</div>


<!-- HPBB -->
<div class="form-group">
    <label for="hpbb">HPBB (Harga Pokok Bahan Baku)</label>
    <input type="number" name="hpbb" id="hpbb" value="{{ old('hpbb') }}" step="0.01" readonly required>
    @error('hpbb')
    <div class="error-message">{{ $message }}</div>
    @enderror
</div>

<!-- Form Upload Sertifikat Halal -->
<div class="form-group">
    <label for="sertifikat_halal_file">Upload Sertifikat Halal</label>
    <input type="file" name="sertifikat_halal_file" id="sertifikat_halal_file" accept=".pdf" class="form-control">
    @error('sertifikat_halal_file')
        <div class="error-message">{{ $message }}</div>
    @enderror
</div>

</div>

</div>

</div>

<!-- Submit Button -->
<div>
                <button type="submit" class="w-full font-bold px-4 py-2 text-white rounded-lg" style="background-color: #032859;">
                    Simpan
                </button>
                <a href="{{ route('bahan_baku.index') }}" 
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
    .form-group select {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 8px;
    font-size: 14px;
    background-color: #fff;
}

.form-group select:focus {
    border-color: #3182ce;
    box-shadow: 0 0 0 2px rgba(66, 153, 225, 0.4);
    outline: none;
}
.select2-container .select2-selection--single {
        height: 42px;
        padding: 5px;
        border: 1px solid #ccc;
        border-radius: 8px;
    }

    .select2-container--classic .select2-selection--single .select2-selection__arrow {
        height: 100%;
    }

    .select2-container .select2-selection__placeholder {
        color: #9ca3af; /* Warna placeholder */
    }

    .select2-container--classic .select2-selection--single:focus {
        border-color: #3182ce;
        box-shadow: 0 0 0 2px rgba(66, 153, 225, 0.4);
        outline: none;
    }

</style>
<script>
$(document).ready(function () {
    // Inisialisasi select2 untuk Nama Bahan Baku
    $('#kode_nama_bahan_baku').select2({
        placeholder: "Pilih Nama Bahan Baku",
        allowClear: true,
        theme: "classic"
    });

    // Inisialisasi select2 untuk Satuan
    $('#satuan').select2({
        placeholder: "Pilih Satuan",
        allowClear: true,
        theme: "classic"
    });

    // Fungsi untuk menghitung nilai
    function calculateValues() {
        const hargaPo = parseFloat($('#harga_po').val()) || 0; // Harga PO
        const ppnPercent = {{ $ppn }}; // Persentase PPN
        const markUpPercent = {{ $markUp }}; // Additional Cost dalam bentuk persentase

        // Hitung nilai PPN
        const ppnValue = hargaPo * (ppnPercent / 100);
        $('#ppn').val(ppnValue.toFixed(2)); // Tampilkan PPN

        // Hitung Additional Cost
        const markUpValue = hargaPo * (markUpPercent / 100);
        $('#mark_up').val(markUpValue.toFixed(2)); // Tampilkan Additional Cost

        // Hitung HPBB
        const hpbbValue = hargaPo + ppnValue + markUpValue;
        $('#hpbb').val(hpbbValue.toFixed(2)); // Tampilkan HPBB
    }

    // Event listener untuk perubahan input
    $('#harga_po').on('input', calculateValues);

    // Hitung ulang saat halaman dimuat
    calculateValues();
});
</script>


@endsection
