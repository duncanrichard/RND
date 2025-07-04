@extends('layout.main')
@section('content')
<div class="w-full px-6 py-6 mx-auto mt-10">
    <div class="bg-white shadow-lg rounded-lg p-6">
        <h2 class="text-2xl font-bold mb-4">Tambah Master Data Stabilitas R&D</h2>
        @if(session('formSubmitted'))
    <script>
        sessionStorage.setItem("formSubmitted", "true");
    </script>
@endif
        <!-- Form Pencarian -->
        <div class="mb-6">
        <form action="{{ route('master_data_stabilitas_rd.search') }}" method="GET" class="flex items-center space-x-4">
            <input type="text" name="search" id="search" placeholder="Cari data..."
                class="w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 sm:text-sm">
            <button type="submit"
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:ring-2 focus:ring-blue-300">
                Cari
            </button>
        </form>

        </div>

<!-- Tabel Hasil Pencarian -->
<div class="overflow-x-auto bg-gray-50 rounded-lg shadow-md p-4">
    <h3 class="text-lg font-bold mb-4">Hasil Pencarian</h3>
    <table class="w-full bg-white rounded-lg border-collapse">
    <thead class="bg-gray-100 border-b">
        <tr>
            <th class="px-6 py-3 text-left text-gray-600 font-medium">No</th>
            <th class="px-6 py-3 text-left text-gray-600 font-medium">No Formula</th>
            <th class="px-6 py-3 text-left text-gray-600 font-medium">Kode Sample</th>
            <th class="px-6 py-3 text-left text-gray-600 font-medium">Nama Sample</th>
        </tr>
    </thead>
    <tbody>
        @if(isset($results) && $results->count() > 0)
            @foreach($results as $index => $result)
                <tr class="border-b hover:bg-gray-50 cursor-pointer" onclick="selectRow(this)">
                    <td class="px-6 py-3 text-gray-700" data-id="{{ $result->id }}">{{ $index + 1 }}</td>
                    <td class="px-6 py-3 text-gray-700" data-nomor-formula="{{ $result->nomor_formula }}">{{ $result->nomor_formula }}</td>
                    <td class="px-6 py-3 text-gray-700" data-kode-sample="{{ $result->kode_sample }}">{{ $result->kode_sample }}</td>
                    <td class="px-6 py-3 text-gray-700" data-nama-sample="{{ $result->nama_sample }}">{{ $result->nama_sample }}</td>
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="4" class="px-6 py-3 text-center text-gray-700">Tidak ada data yang ditemukan</td>
            </tr>
        @endif
    </tbody>
</table>

</div>

<br>
        <form action="{{ route('master_data_stabilitas_rd.store') }}" method="POST" class="space-y-6">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Kolom 1 -->
                <div>
                    <label for="tanggal" class="block text-sm font-medium text-gray-700">Tanggal</label>
                    <input type="date" name="tanggal" id="tanggal"
                        value="{{ date('Y-m-d') }}"
                        class="mt-1 block w-full border border-gray-300 rounded shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                        readonly required>
                </div>

                <div>
                    <label for="id_input" class="block text-sm font-medium text-gray-700">ID Input</label>
                    <input type="text" name="id_input" id="id_input"
                           class="mt-1 block w-full border border-gray-300 rounded shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                           placeholder="Masukkan ID Input..." value="{{ Auth::user()->username }}" required readonly>
                </div>
                <div>
                    <label for="tgl_trial" class="block text-sm font-medium text-gray-700">Tanggal Trial</label>
                    <input type="date" name="tgl_trial" id="tgl_trial" value="{{ date('Y-m-d') }}"
                           class="mt-1 block w-full border border-gray-300 rounded shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                           required >
                </div>
                <div>
                    <label for="nama_produk" class="block text-sm font-medium text-gray-700">Nama Produk</label>
                    <input type="text" name="nama_produk" id="nama_produk"
                           class="mt-1 block w-full border border-gray-300 rounded shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                           placeholder="Masukkan nama produk..." required readonly>
                </div>
                <div>
                    <label for="no_formula" class="block text-sm font-medium text-gray-700">No Formula</label>
                    <input type="text" name="no_formula" id="no_formula"
                           class="mt-1 block w-full border border-gray-300 rounded shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                           placeholder="Masukkan No Formula..." required readonly>
                </div>
                <div>
                    <label for="kode_sample" class="block text-sm font-medium text-gray-700">Kode Sample</label>
                    <input type="text" name="kode_sample" id="kode_sample"
                           class="mt-1 block w-full border border-gray-300 rounded shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                           placeholder="Masukkan Kode Sample..." required readonly>
                </div>
            </div>
            <input type="hidden" name="filled_columns_accelerated" id="filled_columns_accelerated" value="">
            <input type="hidden" name="filled_columns_long_term" id="filled_columns_long_term" value="">

                <!-- Accelerated Stability -->
                <div class="col-span-2 mt-6">
                    <h3 class="text-xl font-bold text-blue-700 mb-4">Accelerated Stability Testing</h3>
                    <div class="overflow-x-auto bg-gray-50 rounded-lg shadow-md p-4">
                        <table class="w-full bg-white rounded-lg border-collapse">
                            <thead class="bg-gray-100 border-b">
                                <tr>
                                    <th class="px-6 py-3 text-left text-gray-600 font-medium">Parameter</th>
                                    <th class="px-6 py-3 text-left text-gray-600 font-medium w-1/5">Syarat</th>
                                    <th class="px-6 py-3 text-center text-gray-600 font-medium">Awal</th>
                                    @for($i = 1; $i <= 6; $i++)
                                    <th class="px-6 py-3 text-center text-gray-600 font-medium column-width">{{ $i }}</th>
                                    @endfor
                                </tr>
                            </thead>
                            <tbody>
                                @foreach(['Bentuk', 'Warna', 'Bau', 'Kejernihan', 'Homogenitas', 'pH', 'Viskositas' , 'Mikrobiologi'] as $parameter)
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="px-6 py-3 text-gray-700">{{ $parameter }}</td>
                                    <td class="px-6 py-3">
                                    <input type="text" name="syarat_accelerated[{{ strtolower($parameter) }}]" value="-" 
                                        class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-300">
                                </td>
                                    @for($i = 0; $i <= 6; $i++)
                                    <td class="px-6 py-3 text-center">
                                    <div class="flex flex-col space-y-2">
                                    <input type="text" name="keterangan_accelerated[{{ strtolower($parameter) }}][{{ $i == 0 ? 'awal' : $i }}]"
       placeholder="Masukkan keterangan..."
       class="border border-gray-300 rounded px-2 py-1 focus:outline-none focus:ring-1 focus:ring-blue-300 text-sm w-full">

                                               <select name="accelerated[{{ strtolower($parameter) }}][{{ $i == 0 ? 'awal' : $i }}]" 
                                                        class="form-select border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500 text-sm w-full">
                                                    <option value="" disabled selected>Pilih Data</option>
                                                    <option value="MS">MS</option>
                                                    <option value="TMS">TMS</option>
                                                </select>

                                    </div>
                                </td>
                                    @endfor
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Long Term Stability -->
                <div class="col-span-2 mt-6">
                    <h3 class="text-xl font-bold text-green-700 mb-4">Long Term Stability Testing</h3>
                    <div class="overflow-x-auto bg-gray-50 rounded-lg shadow-md p-4">
                        <table class="w-full bg-white rounded-lg border-collapse">
                            <thead class="bg-gray-100 border-b">
                                <tr>
                                    <th class="px-6 py-3 text-left text-gray-600 font-medium">Parameter</th>
                                    <th class="px-6 py-3 text-left text-gray-600 font-medium w-1/5">Syarat</th>
                                    <th class="px-6 py-3 text-center text-gray-600 font-medium">Awal</th>
                                    @foreach([3, 6, 9, 12, 18, 24, 36] as $month)
                                        <th class="px-6 py-3 text-center text-gray-600 font-medium">{{ $month }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @foreach(['Bentuk', 'Warna', 'Bau', 'Kejernihan', 'Homogenitas', 'pH', 'Viskositas', 'Mikrobiologi'] as $parameter)
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="px-6 py-3 text-gray-700">{{ $parameter }}</td>
                                    <td class="px-6 py-3">
                                    <input type="text" 
                                        name="syarat_long_term[{{ strtolower($parameter) }}]" 
                                        placeholder="Masukkan syarat..." 
                                        class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-300">
                                </td>

                                    @foreach(['awal', 3, 6, 9, 12, 18, 24, 36] as $month)
                                    <td class="px-6 py-3 text-center">
                                        <div class="flex flex-col space-y-2">
                                            <input type="text" name="keterangan_long_term[{{ strtolower($parameter) }}][{{ $month }}]" placeholder="Keterangan..."
                                                   class="border border-gray-300 rounded px-2 py-1 focus:outline-none focus:ring-1 focus:ring-green-300 text-sm w-full">
                                                   <select name="accelerated[{{ strtolower($parameter) }}][{{ $i == 0 ? 'awal' : $i }}]" 
                                                            class="form-select border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500 text-sm w-full">
                                                        <option value="" disabled selected>Pilih Data</option>
                                                        <option value="MS">MS</option>
                                                        <option value="TMS">TMS</option>
                                                    </select>

                                        </div>
                                    </td>
                                    @endforeach
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <br>
            <input type="hidden" name="filled_columns_accelerated" id="filled_columns_accelerated" value="{{ session('filled_columns_accelerated') ?? '0' }}">
            <input type="hidden" name="filled_columns_long_term" id="filled_columns_long_term" value="{{ session('filled_columns_long_term') ?? '0' }}">

            <div>
                <button type="submit" class="w-full font-bold px-4 py-2 text-white rounded-lg" style="background-color: #032859;">
                    Simpan
                </button>
                <a href="{{ route('master_data_stabilitas_rd.index') }}" 
                   class="w-full font-bold px-4 py-2 text-white rounded-lg bg-gray-500 hover:bg-gray-600 mt-2 inline-block text-center" style="background-color: #032859;">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
<style>
    /* Grid */
    .grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 16px;
    }

    /* Tabel */
    table {
        border-spacing: 0;
        width: 100%;
    }

    th, td {
        padding: 12px;
        border: 1px solid #d1d5db;
        text-align: center;
        font-size: 14px;
    }

    th {
        background-color: #f3f4f6;
        font-weight: bold;
    }

    /* Responsif */
    @media (max-width: 768px) {
        .grid {
            grid-template-columns: 1fr;
        }

        th, td {
            font-size: 12px;
            padding: 8px;
        }
    }
    .hidden {
    display: none;
}
</style>
<script>
function selectRow(row) {
    // Ambil data dari baris yang dipilih
    const nomorFormula = row.querySelector('[data-nomor-formula]').textContent;
    const kodeSample = row.querySelector('[data-kode-sample]').textContent;
    const namaSample = row.querySelector('[data-nama-sample]').textContent;
    const id = row.querySelector('[data-id]').textContent;

    // Isi form dengan data yang dipilih
    document.getElementById('no_formula').value = nomorFormula;
    document.getElementById('kode_sample').value = kodeSample;
    document.getElementById('nama_produk').value = namaSample;  // Isi Nama Sample ke Nama Produk
    document.getElementById('id_input').value = id;  // Isi ID jika diperlukan

    // Sembunyikan hanya baris yang dipilih
    row.classList.add('hidden');  // Menambahkan kelas 'hidden' pada baris yang dipilih
}
document.querySelector('form').addEventListener('submit', function (e) {
    const selects = document.querySelectorAll('select[name^="accelerated"], select[name^="long_term"]');
    let valid = true;

    selects.forEach(select => {
        if (!select.value) {
            valid = false;
            select.classList.add('border-red-500');
        } else {
            select.classList.remove('border-red-500');
        }
    });

    if (!valid) {
        e.preventDefault();
        alert('Harap pilih nilai MS/TMS untuk semua parameter.');
    }
});


document.addEventListener("DOMContentLoaded", function () {
    function checkAndNotify() {
        const today = new Date();
        const isFilledAccelerated = document.getElementById("filled_columns_accelerated").value === "1";
        const isFilledLongTerm = document.getElementById("filled_columns_long_term").value === "1";

        if (isFilledAccelerated) {
            document.querySelectorAll('input[name^="keterangan_accelerated"]').forEach(input => {
                const column = input.name.match(/\d+/g);
                if (column && column[0] !== "awal") {
                    const dueDate = new Date();
                    dueDate.setMonth(dueDate.getMonth() + parseInt(column[0]) - 1);
                    dueDate.setDate(dueDate.getDate() - 7);

                    if (today >= dueDate) {
                        alert(`⚠️ Notifikasi: Anda harus mengisi data untuk bulan ke-${column[0]} dalam Accelerated Stability Testing!`);
                    }
                }
            });
        }

        if (isFilledLongTerm) {
            document.querySelectorAll('input[name^="keterangan_long_term"]').forEach(input => {
                const column = input.name.match(/\d+/g);
                if (column && column[0] !== "awal") {
                    const dueDate = new Date();
                    dueDate.setMonth(dueDate.getMonth() + (parseInt(column[0]) / 3) - 1);
                    dueDate.setDate(dueDate.getDate() - 7);

                    if (today >= dueDate) {
                        alert(`⚠️ Notifikasi: Anda harus mengisi data untuk bulan ke-${column[0]} dalam Long Term Stability Testing!`);
                    }
                }
            });
        }
    }

    // Pastikan hanya muncul setelah penyimpanan pertama kali
    if (sessionStorage.getItem("formSubmitted") === "true") {
        checkAndNotify();
    }
});


</script>


@endsection
