@extends('layout.main')

@section('content')
<div class="w-full px-6 py-6 mx-auto mt-10">
    <div class="bg-white shadow-lg rounded-lg p-6">
        <h2 class="text-2xl font-bold mb-4">Tambah Data Harga Sample Bahan Baku</h2>
 <!-- Form Search -->
 <div class="mb-6">
            <label for="search_bahan_baku" class="block text-sm font-medium text-gray-700">Cari Data Bahan Baku</label>
            <div class="flex gap-2 mt-1">
                <input type="text" id="search_bahan_baku" name="search_bahan_baku" class="block w-full border border-gray-300 rounded shadow-sm py-2 px-3" placeholder="Masukkan kode bahan baku">
                <button type="button" id="search_button" class="px-4 py-2 text-white rounded-lg" style="background-color: #032859;">Cari</button>
            </div>
        </div>

          <!-- Tabel Hasil Pencarian -->
          <div class="overflow-x-auto mb-6">
            <table class="min-w-full bg-white border border-gray-300 rounded-lg">
                <thead class="bg-gray-200 text-gray-700">
                    <tr>
                        <th class="py-2 px-4 text-left border-b">Kode Bahan Baku</th>
                        <th class="py-2 px-4 text-left border-b">Nama Bahan Baku</th>
                        <th class="py-2 px-4 text-left border-b">principle</th>
                    </tr>
                </thead>
                <tbody id="search_results">
                    <tr>
                        <td colspan="4" class="py-4 px-6 text-center text-gray-500">Silakan cari data bahan baku...</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <!-- Form Tambah Data -->
        <form action="{{ route('master_harga_sample_bahan_baku.store') }}" method="POST">
            @csrf
            <div class="grid grid-cols-2 gap-4">
            <div>
                    <label for="kode_bahan_baku" class="block text-sm font-medium text-gray-700">Kode Bahan Baku</label>
                    <input type="text" name="kode_bahan_baku" id="kode_bahan_baku" class="mt-1 block w-full border border-gray-300 rounded shadow-sm py-2 px-3" readonly required>
                </div>
                <br>
                <div>
                    <label for="nama_bahan_baku" class="block text-sm font-medium text-gray-700">Nama Bahan Baku</label>
                    <input type="text" name="nama_bahan_baku" id="nama_bahan_baku" class="mt-1 block w-full border border-gray-300 rounded shadow-sm py-2 px-3" readonly required>
                </div>
                <br>
                <div>
                    <label for="principle" class="block text-sm font-medium text-gray-700">Principle</label>
                    <input type="text" name="principle" id="principle" class="mt-1 block w-full border border-gray-300 rounded shadow-sm py-2 px-3" readonly required>
                </div>
                <br>
                <div>
                    <label for="supplier" class="block text-sm font-medium text-gray-700">Supplier</label>
                    <input type="text" name="supplier" id="supplier" class="mt-1 block w-full border border-gray-300 rounded shadow-sm py-2 px-3" readonly required>
                </div>


                <br>
                <div>
                    <label for="qty" class="block text-sm font-medium text-gray-700">Qty</label>
                    <input type="number" step="0.01" name="qty" id="qty" class="mt-1 block w-full border border-gray-300 rounded shadow-sm py-2 px-3" required>
                </div>
                <br>
                <div>
                    <label for="kategori_satuan" class="block text-sm font-medium text-gray-700">Kategori Satuan</label>
                    <select name="kategori_satuan" id="kategori_satuan" class="mt-1 block w-full border border-gray-300 rounded shadow-sm py-2 px-3" required>
                        <option value="">Pilih Satuan</option>
                        @foreach($satuan as $item)
                            <option value="{{ $item->id }}">{{ $item->nama_satuan }}</option>
                        @endforeach
                    </select>
                </div>
                <br>
                
                <div>
                    <label for="harga_usd" class="block text-sm font-medium text-gray-700">Harga ($)</label>
                    <input type="number" step="0.01" name="harga_usd" id="harga_usd" class="mt-1 block w-full border border-gray-300 rounded shadow-sm py-2 px-3" oninput="calculateHargaIDR()" >
                </div>
                <br>
                <div>
                    <label for="harga_idr" class="block text-sm font-medium text-gray-700">Harga (Rp)</label>
                    <input type="text" id="harga_idr_display" class="mt-1 block w-full border border-gray-300 rounded shadow-sm py-2 px-3" placeholder="Masukkan harga dalam Rupiah">
                    <input type="hidden" name="harga_idr" id="harga_idr">

                </div>
                <br>
                <div>
                    <label for="ppn" class="block text-sm font-medium text-gray-700">PPN</label>
                    <input type="text" id="ppn_display" class="mt-1 block w-full border border-gray-300 rounded shadow-sm py-2 px-3" readonly>
                    <input type="hidden" name="ppn" id="ppn">
                </div>
                <br>
                <div>
                    <label for="pph" class="block text-sm font-medium text-gray-700">PPH</label>
                    <input type="text" id="pph_display" class="mt-1 block w-full border border-gray-300 rounded shadow-sm py-2 px-3" readonly>
                    <input type="hidden" name="pph" id="pph">
                </div>
                <br>
                <div>
                    <label for="harga_total" class="block text-sm font-medium text-gray-700">Harga Total</label>
                    <input type="text" id="harga_total_display" class="mt-1 block w-full border border-gray-300 rounded shadow-sm py-2 px-3" readonly>
                    <input type="hidden" name="harga_total" id="harga_total">
                </div>
                <br>
                <div>
                    <label for="additional_cost_display" class="block text-sm font-medium text-gray-700">+Additional Cost (Rp)</label>
                    <input type="text" id="additional_cost_display" class="mt-1 block w-full border border-gray-300 rounded shadow-sm py-2 px-3" readonly>
                    <input type="hidden" name="additional_cost" id="additional_cost"> <!-- Hidden input untuk nilai asli -->
                </div>
                <br>

                <div>
                    <label for="harga_akhir" class="block text-sm font-medium text-gray-700">Harga Akhir</label>
                    <input type="text" id="harga_akhir_display" class="mt-1 block w-full border border-gray-300 rounded shadow-sm py-2 px-3" readonly>
                    <input type="hidden" name="harga_akhir" id="harga_akhir">
                </div>
                <br>
                <div>
                    <label for="moq" class="block text-sm font-medium text-gray-700">MOQ (Kg)</label>
                    <input type="number" step="0.01" name="moq" id="moq" class="mt-1 block w-full border border-gray-300 rounded shadow-sm py-2 px-3">
                </div>
            </div>

            <br>
            <div>
                <button type="submit" class="w-full font-bold px-4 py-2 text-white rounded-lg" style="background-color: #032859;">
                    Simpan
                </button>
                <a href="{{ route('master_harga_sample_bahan_baku.index') }}"
                class="w-full font-bold px-4 py-2 text-white rounded-lg bg-gray-500 hover:bg-gray-600 mt-2 inline-block text-center" style="background-color: #032859;">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
<style>
     .min-w-full {
        width: 100%; /* Lebarkan tabel mengikuti lebar parent */
    }
    table {
        table-layout: auto; /* Kolom tabel akan menyesuaikan konten */
        border-collapse: collapse; /* Hilangkan jarak antar border */
    }
    th, td {
        text-align: left; /* Ratakan teks ke kiri */
        padding: 12px; /* Tambahkan padding agar lebih rapi */
    }
    th {
        background-color: #f1f5f9; /* Warna background untuk header */
        border-bottom: 2px solid #e2e8f0; /* Border bawah untuk header */
    }
    td {
        border-bottom: 1px solid #e2e8f0; /* Border bawah untuk setiap baris */
    }
    .select2-container {
        width: 100% !important; /* Menjadikan Select2 mengikuti ukuran parent */
    }
    .select2-selection {
        height: 2.5rem !important; /* Menyesuaikan tinggi dengan input lainnya */
        padding: 0.5rem !important;
        border: 1px solid #d1d5db; /* Warna border sesuai desain */
        border-radius: 0.375rem; /* Radius border */
    }
</style>
<script>
      document.getElementById('search_button').addEventListener('click', function() {
        const query = document.getElementById('search_bahan_baku').value;

        if (!query) {
            alert('Masukkan istilah pencarian.');
            return;
        }

        fetch(`{{ route('bahan_baku.search') }}?q=${encodeURIComponent(query)}`)
            .then(response => response.json())
            .then(data => {
                const resultsTable = document.getElementById('search_results');
                resultsTable.innerHTML = ''; // Kosongkan hasil pencarian sebelumnya

                if (data.length === 0) {
                    resultsTable.innerHTML = `
                        <tr>
                            <td colspan="4" class="py-4 px-6 text-center text-gray-500">
                                Tidak ada data ditemukan.
                            </td>
                        </tr>
                    `;
                    return;
                }

                data.forEach(item => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td class="py-2 px-4 border-b">${item.kode}</td>
                        <td class="py-2 px-4 border-b">${item.raw_material}</td>
                        <td class="py-2 px-4 border-b">${item.principle}</td>

                    `;
                    row.addEventListener('click', () => selectBahanBaku(item)); // Tambahkan event untuk memilih data
                    resultsTable.appendChild(row);
                });
            })
            .catch(error => {
                console.error('Error fetching data:', error);
                alert('Terjadi kesalahan. Coba lagi nanti.');
            });
    });

    function selectBahanBaku(item) {
        // Isi form dengan data yang dipilih
        document.getElementById('kode_bahan_baku').value = item.kode;
        document.getElementById('nama_bahan_baku').value = item.raw_material;
        document.getElementById('principle').value = item.principle;
        document.getElementById('supplier').value = item.supplier;

        // Bersihkan hasil pencarian
        document.getElementById('search_results').innerHTML = `
            <tr>
                <td colspan="4" class="py-4 px-6 text-center text-gray-500">
                    Silakan cari data bahan baku...
                </td>
            </tr>
        `;
        document.getElementById('search_bahan_baku').value = '';
    }
    /* Select2  */
    $(document).ready(function() {
        // Inisialisasi Select2 untuk select nama_bahan_baku
        $('#nama_bahan_baku').select2({
            placeholder: "Pilih Bahan Baku",
            minimumInputLength: 3,
            allowClear: true
        });
        $('#kategori_satuan').select2({
            placeholder: "Pilih Kategori Satuan",
            minimumInputLength: 3,
            allowClear: true
        });
    });

    const latestKursUSD = {{ $latestKursUSD ?? 0 }};
    const latestPPNRate = {{ $latestPPN ?? 0 }} / 100;
    const latestPPHRate = {{ $latestPPH ?? 0 }} / 100;

    function formatRupiah(value) {
        return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(value);
    }

    // Logika untuk mengaktifkan/menonaktifkan form
    document.getElementById('harga_usd').addEventListener('input', function () {
        const hargaUSD = parseFloat(this.value) || 0;
        const hargaIDRField = document.getElementById('harga_idr_display');

        if (hargaUSD > 0) {
            hargaIDRField.setAttribute('disabled', true); // Nonaktifkan input harga IDR
            calculateHargaIDR();
        } else {
            hargaIDRField.removeAttribute('disabled'); // Aktifkan kembali input harga IDR jika kosong
        }
    });

// Event Listener untuk Harga IDR Display
document.getElementById('harga_idr_display').addEventListener('input', function () {
    const hargaIDR = parseFloat(this.value.replace(/[^\d.-]/g, '')) || 0;
    document.getElementById('harga_idr').value = hargaIDR.toFixed(2);

    if (hargaIDR > 0) {
        document.getElementById('harga_usd').setAttribute('disabled', true); // Nonaktifkan input Harga USD
        calculateTaxesAndTotal(hargaIDR);
    } else {
        document.getElementById('harga_usd').removeAttribute('disabled'); // Aktifkan kembali input Harga USD jika kosong
    }
});

    function calculateHargaIDR() {
        const hargaUSD = parseFloat(document.getElementById('harga_usd').value) || 0;
        const hargaIDR = hargaUSD * latestKursUSD;
        document.getElementById('harga_idr').value = hargaIDR.toFixed(2);
        document.getElementById('harga_idr_display').value = formatRupiah(hargaIDR);
        calculateTaxesAndTotal(hargaIDR);
    }

    function calculateTaxesAndTotal(hargaIDR) {
    const ppn = hargaIDR * latestPPNRate;
    const pph = hargaIDR * latestPPHRate;
    const hargaTotal = hargaIDR + ppn + pph;

    // Tampilkan hasil perhitungan
    document.getElementById('ppn').value = ppn.toFixed(2);
    document.getElementById('ppn_display').value = formatRupiah(ppn);
    document.getElementById('pph').value = pph.toFixed(2);
    document.getElementById('pph_display').value = formatRupiah(pph);
    document.getElementById('harga_total').value = hargaTotal.toFixed(2);
    document.getElementById('harga_total_display').value = formatRupiah(hargaTotal);

    // Hitung Harga Akhir
    calculateHargaAkhir(hargaTotal);
}

// Fungsi untuk menghitung Harga Akhir dengan tambahan biaya
function calculateHargaAkhir(hargaTotal) {
    const additionalCostRate = {{ $latestAdditionalCost ?? 0 }} / 100;
    const additionalCost = hargaTotal * additionalCostRate;
    const hargaAkhir = hargaTotal + additionalCost;

    // Tampilkan hasil perhitungan
    document.getElementById('additional_cost').value = additionalCost.toFixed(2); // Hidden input
    document.getElementById('additional_cost_display').value = formatRupiah(additionalCost); // Display
    document.getElementById('harga_akhir').value = hargaAkhir.toFixed(2); // Hidden input
    document.getElementById('harga_akhir_display').value = formatRupiah(hargaAkhir); // Display
}


// Event Listener untuk Additional Cost
document.getElementById('additional_cost').addEventListener('input', () => {
    const hargaTotal = parseFloat(document.getElementById('harga_total').value) || 0;
    calculateHargaAkhir(hargaTotal);
});
</script>
@endsection
