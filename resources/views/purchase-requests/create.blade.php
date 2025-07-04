@extends('layout.main')

@section('content')
<div class="w-full px-6 py-6 mx-auto mt-10">
    <div class="bg-white shadow-lg rounded-lg p-6">
        <h2 class="text-2xl font-bold mb-4">Buat Purchase Request</h2>
        <form action="{{ route('purchase-requests.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

            <!-- Bagian Formulir Utama -->
            <div class="grid grid-cols-2 gap-6">
                <!-- Kolom Kiri -->
                <div>
                <div class="mb-4">
                    <label for="no_purchase_request" class="block font-semibold">No Purchase Request</label>
                    <input type="text" id="no_purchase_request" name="no_purchase_request" class="form-input bg-gray-100" value="{{ $noPurchaseRequest }}" readonly>
                </div>

                    <div class="mb-4">
                        <label for="tanggal" class="block font-semibold">Tanggal</label>
                        <input type="date" id="tanggal" name="tanggal" class="form-input" value="{{ now()->format('Y-m-d') }}" required>
                    </div>
                    <div class="mb-4">
                        <label for="id_input" class="block font-semibold">ID Input</label>
                        <input type="text" id="id_input" name="id_input" class="form-input" required>
                    </div>
                </div>

                <!-- Kolom Kanan -->
                <div>
                    <div class="mb-4">
                        <label for="departemen" class="block font-semibold">Departemen</label>
                        <input type="text" id="departemen" name="departemen" class="form-input" value='Research & Development' required>
                    </div>
                   <!-- Dropdown Kategori Barang -->
                <div class="mb-4">
                    <label for="kategori_barang" class="block font-semibold">Kategori Barang</label>
                    <select id="kategori_barang" name="kategori_barang" class="form-input" required>
                        <option value="">-- Pilih Kategori --</option>
                        <option value="Aset">Aset</option>
                         <option value="Bahan Kemas">Bahan Kemas</option>
                        <option value="Bahan Baku">Bahan Baku</option> 
                    </select>
                </div>

                                    
                </div>
                
            </div>

           <!-- Bagian Pencarian Barang -->
                <div class="mt-6">
                    <label for="cari_barang" class="block font-semibold">Cari Barang</label>
                    <input type="text" id="cari_barang" name="cari_barang" class="form-input" placeholder="Masukkan nama barang...">
                    <div class="mt-4 overflow-x-auto">
                        <table class="w-full bg-white border border-gray-300 rounded-lg">
                            <thead class="bg-gray-200 text-gray-700">
                                <tr>
                                    <th class="py-2 px-4 text-left border-b">Kode Barang</th>
                                    <th class="py-2 px-4 text-left border-b">Nama Barang</th>
                                </tr>
                            </thead>
                            <tbody id="search_results">
                                <tr>
                                    <td colspan="2" class="py-4 px-6 text-center text-gray-500">Silakan pilih kategori barang...</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

            <div class="table-container mt-6">
    <h3 class="text-xl font-bold mb-2">Detail Barang</h3>
    <table class="w-full bg-white border border-gray-300 rounded-lg">
        <thead class="bg-gray-200 text-gray-700">
            <tr>
                <th class="py-2 px-4 text-left border-b">No</th>
                <th class="py-2 px-4 text-left border-b">Kode Barang</th>
                <th class="py-2 px-4 text-left border-b">Nama Barang</th>
                <th class="py-2 px-4 text-left border-b kategori-column">Kategori</th>
                <th class="py-2 px-4 text-left border-b jumlah-column">Jumlah</th>
                <th class="py-2 px-4 text-left border-b satuan-column">Satuan</th>
                <th class="py-2 px-4 text-left border-b">Rencana Kedatangan</th>
                <th class="py-2 px-4 text-left border-b">Keterangan</th>
                <th class="py-2 px-4 text-left border-b">Dokumen</th>
                <th class="py-2 px-4 text-left border-b">Hapus</th>

            </tr>
        </thead>
        <tbody id="detail_results">
            <tr class="placeholder">
                <td colspan="8" class="py-4 px-6 text-center text-gray-500">Tidak ada data barang...</td>
            </tr>
        </tbody>
    </table>
</div>

            </div>
            <br>
            <div>
                <button type="submit" class="w-full font-bold px-4 py-2 text-white rounded-lg" style="background-color: #032859;">
                    Simpan
                </button>
                <a href="{{ route('purchase-requests.index') }}"
                class="w-full font-bold px-4 py-2 text-white rounded-lg bg-gray-500 hover:bg-gray-600 mt-2 inline-block text-center" style="background-color: #032859;">
                    Batal
                </a>
            </div>
          
        </form>
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
    overflow-x: auto;
    display: block;
}
    /* Lebarkan kolom kategori */
/* Lebarkan kolom Kode Barang, Nama Barang, Keterangan, dan Dokumen */
.kode-barang-column,
.nama-barang-column,
.keterangan-column,
.dokumen-column {
    width: 300px; /* Bisa diperbesar lagi jika diperlukan */
    min-width: 300px; /* Minimum lebar agar tidak terlalu kecil */
    white-space: nowrap; /* Mencegah teks turun ke baris baru */
}


/* Perbesar input kategori */
.kategori-input {
    width: 100%;
    max-width: 100%;
    padding: 8px;
    border-radius: 5px;
    font-size: 14px;
}
/* Lebarkan kolom Kategori dan Satuan */
.kategori-column {
    width: 350px; /* Bisa diperbesar lagi jika diperlukan */
    min-width: 300px;
}

.satuan-column {
    width: 300px; /* Bisa diperbesar lagi jika diperlukan */
    min-width: 200px;
}

/* Perbesar input dalam kategori dan satuan */
.kategori-input,
.satuan-input {
    width: 100%;
    max-width: 100%;
    padding: 8px;
    border-radius: 5px;
    font-size: 14px;
}
/* Pastikan tombol hapus selalu terlihat */
.button-hapus {
    background-color: #ef4444; /* Warna merah */
    color: white;
    padding: 8px 12px;
    border-radius: 6px;
    border: none;
    cursor: pointer;
    font-size: 14px;
    transition: background-color 0.3s ease;
}

/* Hover effect */
.button-hapus:hover {
    background-color: #dc2626; /* Warna merah lebih gelap saat hover */
}



</style>

<script>
    document.getElementById('cari_barang').addEventListener('input', function () {
        const query = this.value;
        const kategori = document.getElementById('kategori_barang').value;

        if (!kategori) {
            alert("Silakan pilih kategori barang terlebih dahulu!");
            this.value = "";
            return;
        }

        if (query.length > 2) {
            fetch(`{{ route('purchase-requests.search-barang') }}?query=${query}&kategori=${kategori}`)
                .then(response => response.json())
                .then(data => {
                    const tableBody = document.getElementById('search_results');
                    tableBody.innerHTML = '';

                    if (data.length > 0) {
                        data.forEach(item => {
                            // Escape tanda kutip tunggal (') agar tidak error saat onclick
                            const safeKode = item.kode_barang.replace(/'/g, "\\'");
                            const safeNama = item.nama_barang.replace(/'/g, "\\'");
                            const safeKategori = kategori.replace(/'/g, "\\'");
                            
                            const row = `
                                <tr onclick="addToDetail('${safeKode}', '${safeNama}', '${safeKategori}')">
                                    <td class="py-2 px-4 border-b">${item.kode_barang}</td>
                                    <td class="py-2 px-4 border-b">${item.nama_barang}</td>
                                </tr>
                            `;
                            tableBody.innerHTML += row;
                        });
                    } else {
                        tableBody.innerHTML = `
                            <tr>
                                <td colspan="2" class="py-4 px-6 text-center text-gray-500">Barang tidak ditemukan...</td>
                            </tr>
                        `;
                    }
                })
                .catch(error => console.error('Error:', error));
        } else {
            document.getElementById('search_results').innerHTML = `
                <tr>
                    <td colspan="2" class="py-4 px-6 text-center text-gray-500">Silakan cari barang terlebih dahulu...</td>
                </tr>
            `;
        }
    });

    let detailIndex = 0;

    function addToDetail(kodeBarang, namaBarang, kategoriBarang) {
        fetch(`{{ route('purchase-requests.get-satuan') }}`)
            .then(response => response.json())
            .then(satuanData => {
                const satuanOptions = satuanData.map(s => `<option value="${s.nama_satuan}">${s.nama_satuan}</option>`).join('');
                const tableDetailBody = document.getElementById('detail_results');

                const placeholderRow = tableDetailBody.querySelector('.placeholder');
                if (placeholderRow) {
                    placeholderRow.remove();
                }

                const newRow = `
                    <tr id="row_${detailIndex}">
                        <td class="py-2 px-4 border-b">${detailIndex + 1}</td>
                        <td class="py-2 px-4 border-b kode-barang-column">
                            <input type="text" name="details[${detailIndex}][kode_barang]" value="${kodeBarang}" class="form-input bg-gray-100" readonly>
                        </td>
                        <td class="py-2 px-4 border-b nama-barang-column">
                            <input type="text" name="details[${detailIndex}][nama_barang]" value="${namaBarang}" class="form-input bg-gray-100" readonly>
                        </td>
                        <td class="py-2 px-4 border-b kategori-column">
                            <input type="text" name="details[${detailIndex}][kategori]" value="${kategoriBarang}" class="form-input bg-gray-100" readonly>
                        </td>
                        <td class="py-2 px-4 border-b jumlah-column">
                            <input type="number" name="details[${detailIndex}][jumlah]" class="form-input" min="0" required>
                        </td>
                        <td class="py-2 px-4 border-b satuan-column">
                            <select name="details[${detailIndex}][satuan]" class="form-input" required>
                                ${satuanOptions}
                            </select>
                        </td>
                        <td class="py-2 px-4 border-b">
                            <input type="date" name="details[${detailIndex}][rencana_kedatangan]" class="form-input" required>
                        </td>
                        <td class="py-2 px-4 border-b keterangan-column">
                            <input type="text" name="details[${detailIndex}][keterangan]" class="form-input">
                        </td>
                        <td class="py-2 px-4 border-b dokumen-column">
                            <input type="file" name="details[${detailIndex}][dokumen]" class="form-input" accept="application/pdf">
                        </td>
                        <td class="py-2 px-4 border-b">
                            <button type="button" onclick="removeDetail(${detailIndex})" class="button-hapus">Hapus</button>
                        </td>
                    </tr>
                `;

                tableDetailBody.innerHTML += newRow;
                detailIndex++;
            })
            .catch(error => console.error('Error:', error));
    }

    function removeDetail(index) {
        const row = document.getElementById(`row_${index}`);
        if (row) {
            row.remove();
        }
    }
</script>


@endsection
