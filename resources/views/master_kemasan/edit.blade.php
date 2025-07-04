@extends('layout.main')

@section('content')
<div class="w-full px-6 py-6 mx-auto mt-10">
    <div class="bg-white shadow-lg rounded-lg p-6">
        <h1 class="text-2xl font-bold mb-4">Edit Data Bahan Kemas</h1>
        <form action="{{ route('master_kemasan.update', $data->id) }}" method="POST" class="bg-white shadow-md rounded-lg p-4">
            @csrf
            @method('PUT')
            <div class="flex flex-wrap -mx-4">
                <!-- Kolom Kiri -->
                <div class="w-full lg:w-1/2 px-4">
                <div class="mb-4">
                    <label for="kategori_kemasan" class="block font-semibold">Kategori Bahan Kemas</label>
                    <select name="kategori_kemasan" id="kategori_kemasan" class="w-full border p-2 rounded-lg" onchange="filterJenisKemasan(); generateKodeKemasan();" required>
    <option value="">-- Pilih Kategori Bahan Kemas --</option>
    <option value="1" {{ $data->kategori_kemasan == 1 ? 'selected' : '' }}>Primer</option>
    <option value="2" {{ $data->kategori_kemasan == 2 ? 'selected' : '' }}>Sekunder</option>
</select>
                </div>
                <div class="mb-4">
                    <label for="jenis_kemasan" class="block font-semibold">Jenis Bahan Kemas</label>
                    <select name="jenis_kemasan" id="jenis_kemasan" class="w-full border p-2 rounded-lg" required>
                        <option value="">-- Pilih Jenis Bahan Kemas --</option>
                        @foreach ($jenisKemasanOptions as $option)
                            <option value="{{ $option->id }}" {{ $data->jenis_kemasan == $option->id ? 'selected' : '' }}>
                                {{ $option->nama_kode }}
                            </option>
                        @endforeach
                    </select>
                </div>

                    <div class="mb-4">
                        <label for="nama_kemasan" class="block font-semibold">Nama Bahan Kemas</label>
                        <input type="text" name="nama_kemasan" id="nama_kemasan" class="w-full border p-2 rounded-lg" value="{{ $data->nama_kemasan }}" required>
                    </div>
                    <div class="mb-4">
                        <label for="satuan" class="block font-semibold">Satuan</label>
                        <select name="satuan" id="satuan" class="w-full border p-2 rounded-lg" required>
                            @foreach ($satuanOptions as $satuan)
                                <option value="{{ $satuan->id }}" {{ $data->satuan == $satuan->id ? 'selected' : '' }}>
                                    {{ $satuan->nama_satuan }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="cara_penyimpanan" class="block font-semibold">Cara Penyimpanan</label>
                        <input type="text" name="cara_penyimpanan" id="cara_penyimpanan" class="w-full border p-2 rounded-lg" value="{{ $data->cara_penyimpanan }}">
                    </div>
                </div>

                <!-- Kolom Kanan -->
                <div class="w-full lg:w-1/2 px-4">
                    <div class="mb-4">
                        <label for="harga_po" class="block font-semibold">Harga PO</label>
                        <input type="number" name="harga_po" id="harga_po" class="w-full border p-2 rounded-lg" value="{{ $data->harga_po }}" >
                    </div>
                    <div class="mb-4">
                        <label for="ppn" class="block font-semibold">PPN</label>
                        <input type="number" name="ppn" id="ppn" class="w-full border p-2 rounded-lg" value="{{ $data->ppn }}" readonly>
                    </div>
                    <div class="mb-4">
                        <label for="mark_up" class="block font-semibold">Mark Up (%)</label>
                        <input type="number" name="mark_up" id="mark_up" class="w-full border p-2 rounded-lg" value="{{ $data->mark_up }}" readonly >
                    </div>
                    <div class="mb-4">
                        <label for="hpbk" class="block font-semibold">HPBK</label>
                        <input type="number" name="hpbk" id="hpbk" class="w-full border p-2 rounded-lg" value="{{ $data->hpbk }}" readonly>
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="mt-6">
                <button type="submit" class="w-full font-bold px-4 py-2 text-white rounded-lg bg-gray-500 hover:bg-gray-600 mt-2 inline-block text-center" style="background-color: #032859;">Perbarui</button>
                <a href="{{ route('master_kemasan.index') }}" class="w-full font-bold px-4 py-2 text-white rounded-lg bg-gray-500 hover:bg-gray-600 mt-2 inline-block text-center" style="background-color: #032859;">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
<script>
    document.getElementById('jenis_kemasan').addEventListener('change', async function () {
        const jenisKemasanId = this.value;
        const kodeKemasanInput = document.getElementById('kode_kemasan');

        if (jenisKemasanId) {
            try {
                const response = await fetch(`/master-kemasan/generate-kode/${jenisKemasanId}`);
                const data = await response.json();
                kodeKemasanInput.value = data.kode_kemasan;
            } catch (error) {
                console.error('Error:', error);
            }
        } else {
            kodeKemasanInput.value = '';
        }
    });

    async function filterJenisKemasan() {
        const kategoriKemasan = document.getElementById('kategori_kemasan').value;
        const jenisKemasan = document.getElementById('jenis_kemasan');

        // Reset dropdown "Jenis Kemasan"
        jenisKemasan.innerHTML = '<option value="">-- Pilih Jenis Kemasan --</option>';

        if (kategoriKemasan) {
            try {
                // Ambil data dari API berdasarkan kategori kemasan
                const response = await fetch(`/kode-bahan-kemas/filter-jenis/${kategoriKemasan}`);
                const data = await response.json();

                // Tambahkan data ke dropdown
                data.forEach(item => {
                    const option = document.createElement('option');
                    option.value = item.id;
                    option.textContent = item.nama_kode;
                    jenisKemasan.appendChild(option);
                });
            } catch (error) {
                console.error('Error fetching jenis kemasan:', error);
            }
        }
    }
    document.addEventListener('DOMContentLoaded', function () {
    const hargaPOField = document.getElementById('harga_po');
    const ppnField = document.getElementById('ppn');
    const markUpField = document.getElementById('mark_up'); // Gunakan untuk additional_cost
    const hpbkField = document.getElementById('hpbk'); // Field untuk HPBK

    const defaultPPN = {{ $defaultPPN }}; // Nilai PPN dari server
    const defaultAdditionalCost = {{ $defaultAdditionalCost }}; // Nilai Additional Cost dari server

    function calculateFields() {
        const hargaPO = parseFloat(hargaPOField.value) || 0;

        // Perhitungan PPN
        const ppnValue = hargaPO * (defaultPPN / 100);
        ppnField.value = ppnValue.toFixed(2);

        // Perhitungan Additional Cost
        const additionalCostValue = hargaPO * (defaultAdditionalCost / 100);
        markUpField.value = additionalCostValue.toFixed(2);

        // Perhitungan HPBK (Harga PO + PPN + Additional Cost)
        const hpbkValue = hargaPO + ppnValue + additionalCostValue;
        hpbkField.value = hpbkValue.toFixed(2);
    }

    // Event listeners untuk perubahan input
    hargaPOField.addEventListener('input', calculateFields);
});

</script>

@endsection
