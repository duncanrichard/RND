@extends('layout.main')

@section('content')
<div class="w-full px-6 py-6 mx-auto mt-10">
    <div class="bg-white shadow-lg rounded-lg p-6">
        <h2 class="text-2xl font-bold mb-4">Edit Purchase Request</h2>
        <form action="{{ route('purchase-requests.update', $purchaseRequest->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Formulir Utama -->
            <div class="grid grid-cols-2 gap-6">
                <div>
                    <label class="block font-semibold">Tanggal</label>
                    <input type="date" name="tanggal" class="form-input" value="{{ $purchaseRequest->tanggal }}" readonly required>
                </div>
                <div>
                    <label class="block font-semibold">Departemen</label>
                    <input type="text" name="departemen" class="form-input" value="{{ $purchaseRequest->departemen }}" readonly required>
                </div>
                <div>
                    <label class="block font-semibold">Kategori Barang</label>
                    <select name="kategori" id="kategori_barang" class="form-input" required>
                        <option value="Aset" {{ $purchaseRequest->kategori_barang == 'Aset' ? 'selected' : '' }}>Aset</option>
                    </select>
                </div>
            </div>
            
<!-- Form Pencarian -->
<h3 class="text-xl font-bold mt-6">Pencarian Barang</h3>
            <div class="mt-4">
                <label class="block font-semibold">Cari Barang</label>
                <input type="text" id="search_input" class="form-input" placeholder="Masukkan nama atau kode barang...">
                <div class="mt-4 overflow-x-auto">
                    <table id="search_results" class="min-w-full bg-white border border-gray-300 rounded-lg">
                        <thead class="bg-gray-200 text-gray-700">
                            <tr>
                                <th class="py-2 px-4 text-left border-b">Kode Barang</th>
                                <th class="py-2 px-4 text-left border-b">Nama Barang</th>
                                <th class="py-2 px-4 text-left border-b">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="3" class="py-4 px-6 text-center text-gray-500">Masukkan kata kunci untuk mencari barang...</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
           <!-- Tabel Detail Barang -->
<h3 class="text-xl font-bold mt-6">Detail Barang</h3>
<table class="min-w-full bg-white border border-gray-300 rounded-lg mt-4">
    <thead>
        <tr>
            <th class="py-2 px-4 border-b whitespace-nowrap">Kode Barang</th>
            <th class="py-2 px-4 border-b whitespace-nowrap">Nama Barang</th>
            <th class="py-2 px-4 border-b whitespace-nowrap">Kategori</th>
            <th class="py-2 px-4 border-b whitespace-nowrap">Jumlah</th>
            <th class="py-2 px-4 border-b ">Satuan</th>
            <th class="py-2 px-4 border-b whitespace-nowrap">Rencana Kedatangan</th>
            <th class="py-2 px-4 border-b whitespace-nowrap">Keterangan</th>
            <th class="py-2 px-4 border-b whitespace-nowrap">Dokumen</th>
            <th class="py-2 px-4 border-b whitespace-nowrap">Aksi</th>
        </tr>
    </thead>
    <tbody id="detail_results">
        @foreach ($purchaseRequest->details as $detail)
        <tr>
            <input type="hidden" name="details[{{ $loop->index }}][id]" value="{{ $detail->id }}">
            <td><input type="text" name="details[{{ $loop->index }}][kode_barang]" class="form-input" value="{{ $detail->kode_barang }}" required readonly></td>
            <td><input type="text" name="details[{{ $loop->index }}][nama_barang]" class="form-input" value="{{ $detail->nama_barang }}" required readonly></td>
            <td><input type="text" name="details[{{ $loop->index }}][kategori]" class="form-input" value="{{ $detail->kategori }}" required readonly></td>

            <td><input type="number" name="details[{{ $loop->index }}][jumlah]" class="form-input" value="{{ $detail->jumlah }}" min="0" required></td>
            <td>
    <select name="details[{{ $loop->index }}][satuan]" class="form-input" required>
        <option value="">-- Pilih Satuan --</option>
        @foreach ($satuanList as $satuan)
            <option value="{{ $satuan }}" {{ $detail->satuan == $satuan ? 'selected' : '' }}>{{ $satuan }}</option>
        @endforeach
    </select>
</td>

            <td><input type="date" name="details[{{ $loop->index }}][rencana_kedatangan]" class="form-input" value="{{ $detail->rencana_kedatangan }}" required></td>
            <td><input type="text" name="details[{{ $loop->index }}][keterangan]" class="form-input" value="{{ $detail->keterangan }}"></td>
            <td>
                @if ($detail->dokumen)
                <a href="{{ asset('storage/' . str_replace('public/', '', $detail->dokumen)) }}" target="_blank" class="text-blue-500 hover:underline">Lihat Dokumen</a>

                @endif
                <input type="file" name="details[{{ $loop->index }}][dokumen]" class="form-input">
            </td>
            <td><button type="button" class="text-red-500 hover:underline" onclick="removeRow(this)">Hapus</button></td>
        </tr>
        @endforeach
    </tbody>
</table>

            <br>
            <div>
                <button type="submit" class="w-full font-bold px-4 py-2 text-white rounded-lg" style="background-color: #032859;">
                    Update
                </button>
                <a href="{{ route('purchase-requests.index') }}"
                class="w-full font-bold px-4 py-2 text-white rounded-lg bg-gray-500 hover:bg-gray-600 mt-2 inline-block text-center" style="background-color: #032859;">
                    Batal
                </a>
            </div>
            <br>
    </div>
</div>

<style>
    /* Grid layout untuk form */
    .grid-cols-2 {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1.5rem;
    }

    /* Input form */
    .form-input {
        background-color: #fff;
        border: 1px solid #ccc;
        border-radius: 0.5rem;
        padding: 0.5rem;
        width: 100%;
        outline: none;
        transition: border-color 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
    }

    .form-input:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2);
    }

    .form-input:hover {
        border-color: #6b7280;
    }

    /* Tabel */
    table {
        border-collapse: collapse;
        width: 100%;
    }

    th, td {
        padding: 10px 15px; /* Ukuran padding untuk tabel */
        text-align: left;
        border-bottom: 1px solid #ddd;
    }

    th {
        background-color: #f4f4f4;
        font-weight: bold;
    }

    tr:hover {
        background-color: #f9f9f9;
    }

    /* Kolom tabel */
    .satuan-column {
        width: 250px; /* Lebar untuk kolom Satuan */
    }

    .jumlah-column {
        width: 200px; /* Lebar untuk kolom Jumlah */
    }

    .file-column {
        width: 300px; /* Lebar untuk kolom Upload File */
    }

    /* Scroll horizontal */
    .table-container {
        overflow-x: auto; /* Scroll horizontal */
        white-space: nowrap; /* Hindari teks meluber */
    }
</style>

<script>
     const satuanList = @json($satuanList);

document.getElementById('search_input').addEventListener('input', function () {
    const query = this.value;
    const kategori = document.getElementById('kategori_barang').value;

    if (query.length > 2 && kategori !== "") {
        fetch(`{{ route('purchase-requests.search-barang') }}?query=${query}&kategori=${kategori}`)
            .then(response => response.json())
            .then(data => {
                const tableBody = document.querySelector('#search_results tbody');
                tableBody.innerHTML = '';

                if (data.length > 0) {
                    data.forEach(item => {
                        const row = `
                            <tr>
                                <td class="py-2 px-4 border-b">${item.kode_barang}</td>
                                <td class="py-2 px-4 border-b">${item.nama_barang}</td>
                                <td class="py-2 px-4 border-b">
                                    <button type="button" class="text-blue-500 hover:underline" onclick="addToDetail('${item.kode_barang}', '${item.nama_barang}', '${kategori}')">Tambah</button>
                                </td>
                            </tr>
                        `;
                        tableBody.innerHTML += row;
                    });
                } else {
                    tableBody.innerHTML = '<tr><td colspan="3" class="py-4 px-6 text-center text-gray-500">Barang tidak ditemukan...</td></tr>';
                }
            });
    }
});

function addToDetail(kode, nama, kategoriBarang) {
    const tableBody = document.getElementById('detail_results');
    const index = tableBody.querySelectorAll('tr').length;

    // Cek duplikat
    for (let row of tableBody.querySelectorAll('tr')) {
        let kodeBarang = row.querySelector('input[name*="[kode_barang]"]');
        if (kodeBarang && kodeBarang.value === kode) {
            Swal.fire({
                title: 'Peringatan',
                text: 'Barang ini sudah ada di tabel detail!',
                icon: 'warning',
                confirmButtonText: 'OK'
            });
            return;
        }
    }

    // Opsi satuan
    let satuanOptions = '<option value="">-- Pilih Satuan --</option>';
    satuanList.forEach(satuan => {
        satuanOptions += `<option value="${satuan}">${satuan}</option>`;
    });

    const row = `
        <tr>
            <td><input type="text" name="details[${index}][kode_barang]" class="form-input" value="${kode}" readonly></td>
            <td><input type="text" name="details[${index}][nama_barang]" class="form-input" value="${nama}" readonly></td>
            <td><input type="text" name="details[${index}][kategori]" class="form-input" value="${kategoriBarang}" readonly></td>
            <td><input type="number" name="details[${index}][jumlah]" class="form-input" min="0" required></td>
            <td>
                <select name="details[${index}][satuan]" class="form-input" required>
                    ${satuanOptions}
                </select>
            </td>
            <td><input type="date" name="details[${index}][rencana_kedatangan]" class="form-input" required></td>
            <td><input type="text" name="details[${index}][keterangan]" class="form-input"></td>
            <td><input type="file" name="details[${index}][dokumen]" class="form-input"></td>
            <td>
                <input type="hidden" name="details[${index}][deleted]" value="0" class="deleted-flag">
                <button type="button" class="text-red-500 hover:underline" onclick="removeRow(this)">Hapus</button>
            </td>
        </tr>
    `;

    tableBody.innerHTML += row;
}

function removeRow(button) {
    const row = button.closest('tr');
    const deletedInput = row.querySelector('input.deleted-flag');

    if (deletedInput) {
        // Tandai untuk dihapus saat submit
        deletedInput.value = '1';
        row.style.display = 'none';
    } else {
        // Jika baris baru, hapus langsung dari DOM
        row.remove();
    }
}
</script>

@endsection
