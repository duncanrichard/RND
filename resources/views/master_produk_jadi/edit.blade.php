@extends('layout.main')

@section('content')
<div class="w-full px-6 py-6 mx-auto mt-10">
    <div class="bg-white shadow-lg rounded-lg p-6">
        <h2 class="text-2xl font-bold mb-4">Update Produk Jadi</h2>
        <form action="{{ route('master_produk_jadi.update', $produk->id) }}" method="POST" class="bg-white shadow-md rounded-lg p-4">
            @csrf
            @method('PUT')
            <div class="flex flex-wrap -mx-4">
                <!-- Kolom Kiri -->
                <div class="w-full lg:w-1/2 px-4">
                <div class="mb-4">
                        <label for="kategori_produk_jadi" class="block font-semibold">Kategori Produk Jadi</label>
                        <input type="text" name="kategori_produk_jadi" id="kategori_produk_jadi" class="w-full border p-2 rounded-lg" value="{{ $produk->kategori_produk_jadi }}"  >
                    </div>
                    <div class="mb-4">
                        <label for="kode_produk_jadi" class="block font-semibold">Kode Produk Jadi</label>
                        <input type="text" name="kode_produk_jadi" id="kode_produk_jadi" class="w-full border p-2 rounded-lg" value="{{ $produk->kode_produk_jadi }}" >
                    </div>
                    <div class="mb-4">
                        <label for="nama_merek" class="block font-semibold">Nama Merek</label>
                        <input type="text" name="nama_merek" id="nama_merek" class="w-full border p-2 rounded-lg" value="{{ $produk->nama_merek }}" >
                    </div>
                  <!--   <div class="mb-4">
                        <label for="nomor_merk" class="block font-semibold">Nomor Merek</label>
                        <input type="text" name="nomor_merk" id="nomor_merk" class="w-full border p-2 rounded-lg" value="{{ old('nomor_merk', $produk->nomor_merk) }}" required>
                    </div> -->
                    <div class="mb-4">
                        <label for="nama_produk" class="block font-semibold">Nama Produk</label>
                        <input type="text" name="nama_produk" id="nama_produk" class="w-full border p-2 rounded-lg" value="{{ $produk->nama_produk }}" >
                    </div>
                    <div class="mb-4">
                        <label for="netto" class="block font-semibold">Netto</label>
                        <input type="number" name="netto" id="netto" class="w-full border p-2 rounded-lg" value="{{ $produk->netto }}" >
                    </div>
                    <div class="mb-4">
                        <label for="satuan" class="block font-semibold">Satuan</label>
                        <select name="satuan" id="satuan" class="w-full border border-gray-300 rounded-lg p-2 focus:ring focus:ring-blue-200 focus:outline-none select2" >
                            <option value="">-- Pilih Satuan --</option>
                            @foreach($satuans as $satuan)
                                <option value="{{ $satuan->nama_satuan }}" {{ $satuan->nama_satuan == $produk->satuan ? 'selected' : '' }}>
                                    {{ $satuan->nama_satuan }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                  <!--   <div class="mb-4">
                        <label for="nomor_sertifikat_halal" class="block font-semibold">Nomor Halal</label>
                        <input type="text" name="nomor_sertifikat_halal" id="nomor_sertifikat_halal" class="w-full border p-2 rounded-lg" value="{{ $produk->nomor_sertifikat_halal }}">
                    </div>
                    <div class="mb-4">
                        <label for="masa_berlaku_sertifikat_halal" class="block font-semibold">Masa Berlaku Halal</label>
                        <input type="date" name="masa_berlaku_sertifikat_halal" id="masa_berlaku_sertifikat_halal" class="w-full border p-2 rounded-lg" value="{{ $produk->masa_berlaku_sertifikat_halal }}">
                    </div> -->
                </div>

                <!-- Kolom Kanan -->
                <div class="w-full lg:w-1/2 px-4">
                <div class="mb-4">
                    <label for="kategori_kemasan" class="block font-semibold">Kategori Kemasan</label>
                    <select name="kategori_kemasan" id="kategori_kemasan" class="w-full border p-2 rounded-lg" onchange="filterJenisKemasan()" >
                        <option value="">-- Pilih Kategori Kemasan --</option>
                        <option value="1" {{ $produk->kategori_kemasan == 1 ? 'selected' : '' }}>Primer</option>
                        <option value="2" {{ $produk->kategori_kemasan == 2 ? 'selected' : '' }}>Sekunder</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label for="jenis_kemasan" class="block font-semibold">Jenis Kemasan</label>
                    <select name="jenis_kemasan" id="jenis_kemasan" class="w-full border p-2 rounded-lg" >
                        <option value="">-- Pilih Jenis Kemasan --</option>
                        @foreach($jenisKemasan as $item)
                            <option value="{{ $item->id }}" {{ $item->id == $produk->jenis_kemasan ? 'selected' : '' }}>
                                {{ $item->nama_kode }}
                            </option>
                        @endforeach
                    </select>
                </div>

                    <div class="mb-4">
                        <label for="expired_date_produk_jadi" class="block font-semibold">Expired Date Produk Jadi</label>
                        <input type="date" name="expired_date_produk_jadi" id="expired_date_produk_jadi" class="w-full border p-2 rounded-lg" value="{{ $produk->expired_date_produk_jadi }}" >
                    </div>
                    <!-- <div class="mb-4">
                        <label for="masa_berlaku_merk" class="block font-semibold">Masa Berlaku Merek</label>
                        <input type="date" name="masa_berlaku_merk" id="masa_berlaku_merk" class="w-full border p-2 rounded-lg" value="{{ old('masa_berlaku_merk', $produk->masa_berlaku_merk) }}" required>
                    </div> -->
                    <div class="mb-4">
                        <label for="rekomendasi_penyimpanan" class="block font-semibold">Rekomendasi Penyimpanan</label>
                        <input type="text" name="rekomendasi_penyimpanan" id="rekomendasi_penyimpanan" class="w-full border p-2 rounded-lg" value="{{ $produk->rekomendasi_penyimpanan }}" >
                    </div>
                    <div class="mb-4">
    <label for="harga_produk" class="block font-semibold">Harga Produk</label>
    <input type="number" step="0.01" name="harga_produk" id="harga_produk"
           class="w-full border p-2 rounded-lg"
           value="{{ old('harga_produk', $produk->harga_produk) }}"
           placeholder="Contoh: 15000.00">
</div>

                   <!--  <div class="mb-4">
                        <label for="nomor_notifikasi_bpom" class="block font-semibold">Nomor Notifikasi BPOM</label>
                        <input type="text" name="nomor_notifikasi_bpom" id="nomor_notifikasi_bpom" class="w-full border p-2 rounded-lg" value="{{ $produk->nomor_notifikasi_bpom }}">
                    </div>
                    <div class="mb-4">
                        <label for="masa_berlaku_notifikasi_bpom" class="block font-semibold">Masa Berlaku Notifikasi BPOM</label>
                        <input type="date" name="masa_berlaku_notifikasi_bpom" id="masa_berlaku_notifikasi_bpom" class="w-full border p-2 rounded-lg" value="{{ $produk->masa_berlaku_notifikasi_bpom }}">
                    </div>
                    <div class="mb-4">
                        <label for="nomor_haki" class="block font-semibold">Nomor HAKI</label>
                        <input type="text" name="nomor_haki" id="nomor_haki" class="w-full border p-2 rounded-lg" value="{{ $produk->nomor_haki }}">
                    </div>
                    <div class="mb-4">
                        <label for="masa_berlaku_haki" class="block font-semibold">Masa Berlaku HAKI</label>
                        <input type="date" name="masa_berlaku_haki" id="masa_berlaku_haki" class="w-full border p-2 rounded-lg" value="{{ $produk->masa_berlaku_haki }}">
                    </div> -->
                </div>
            </div>

            <!-- Submit Button -->
            <div class="mt-6">
                <button type="submit" class="w-full font-bold px-4 py-2 text-white rounded-lg bg-gray-500 hover:bg-gray-600 mt-2 inline-block text-center" style="background-color: #032859;">Simpan</button>
                <a href="{{ route('master_produk_jadi.index') }}" class="w-full font-bold px-4 py-2 text-white rounded-lg bg-gray-500 hover:bg-gray-600 mt-2 inline-block text-center" style="background-color: #032859;">Batal</a>
            </div>
        </form>
    </div>
</div>
<style>
/* Pastikan Select2 menyesuaikan dengan input lainnya */
.select2-container--default .select2-selection--single {
    height: 40px; /* Sesuaikan dengan tinggi input lainnya */
    border: 1px solid #ccc;
    border-radius: 6px; /* Sesuaikan dengan elemen lainnya */
    padding: 8px 12px; /* Sesuaikan padding */
}

.select2-container--default .select2-selection--single .select2-selection__rendered {
    line-height: 24px; /* Sesuaikan dengan padding */
    font-size: 14px;
    color: #333;
}

.select2-container--default .select2-selection--single .select2-selection__arrow {
    height: 40px; /* Sesuaikan dengan tinggi input lainnya */
}

.select2-container {
    width: 100% !important; /* Pastikan lebar sesuai dengan elemen form lainnya */
}
</style>

<script>
$(document).ready(function () {
    $('#kategori_produk_jadi').select2({
        placeholder: "-- Pilih Kategori Produk Jadi --",
        allowClear: true
    });

    $('#satuan').select2({
        placeholder: "-- Pilih Satuan --",
        allowClear: true
    });

    // Update kode_produk_jadi saat kategori_produk_jadi diubah
    $('#kategori_produk_jadi').on('change', async function () {
        const categoryName = this.value;
        if (categoryName) {
            try {
                const response = await fetch(`/master-produk-jadi/get-latest-kode?kategori=${encodeURIComponent(categoryName)}`);
                const data = await response.json();
                $('#kode_produk_jadi').val(data.kode_produk_jadi || '');
            } catch (error) {
                console.error('Error fetching kode produk jadi:', error);
                alert('Gagal memuat kode produk jadi.');
            }
        } else {
            $('#kode_produk_jadi').val('');
        }
    });
});
</script>
<script>
  $(document).ready(function () {
    $('#kategori_produk_jadi').select2({
        placeholder: "-- Pilih Kategori Produk Jadi --",
        allowClear: true,
        minimumInputLength: 5,
    });

    $('#satuan').select2({
        placeholder: "-- Pilih Satuan --",
        allowClear: true,
        minimumInputLength: 2,
    });
});


document.addEventListener('DOMContentLoaded', function () {
    const kategoriKemasanField = document.getElementById('kategori_kemasan');
    const jenisKemasanField = document.getElementById('jenis_kemasan');

    async function fetchJenisKemasan(kategori) {
        jenisKemasanField.innerHTML = '<option value="">-- Pilih Jenis Kemasan --</option>';
        if (!kategori) return;

        try {
            const response = await fetch(`/kode-bahan-kemas/filter-jenis/${kategori}`);
            const data = await response.json();

            data.forEach(item => {
                const option = document.createElement('option');
                option.value = item.id;
                option.textContent = item.nama_kode; // Nama Kode ditampilkan
                jenisKemasanField.appendChild(option);
            });
        } catch (error) {
            console.error('Error fetching jenis kemasan:', error);
            alert('Gagal memuat jenis kemasan.');
        }
    }

    kategoriKemasanField.addEventListener('change', function () {
        const kategori = this.value;
        fetchJenisKemasan(kategori);
    });
});

</script>

@endsection
