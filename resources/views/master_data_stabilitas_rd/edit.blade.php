@extends('layout.main')
@section('content')
<div class="w-full px-6 py-6 mx-auto mt-10">
    <div class="bg-white shadow-lg rounded-lg p-6">
        <h2 class="text-2xl font-bold mb-4">Update Master Data Stabilitas R&D</h2>

       

        <!-- Form Update -->
        <form action="{{ route('master_data_stabilitas_rd.update', $product->id) }}" method="POST" class="space-y-6">
    @csrf
    @method('PUT')
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Kolom 1 -->
                <div>
                    <label for="tanggal" class="block text-sm font-medium text-gray-700">Tanggal</label>
                    <input type="date" name="tanggal" id="tanggal"
                        value="{{ $product->tanggal }}"
                        class="mt-1 block w-full border border-gray-300 rounded shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                        readonly required>
                </div>

                <div>
                    <label for="id_input" class="block text-sm font-medium text-gray-700">ID Input</label>
                    <input type="text" name="id_input" id="id_input"
                           class="mt-1 block w-full border border-gray-300 rounded shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" value="{{ $product->id_input }}"
                           placeholder="Masukkan ID Input..." readonly required>
                </div>
                <div>
                    <label for="tgl_trial" class="block text-sm font-medium text-gray-700">Tanggal Trial</label>
                    <input type="date" name="tgl_trial" id="tgl_trial"
                           class="mt-1 block w-full border border-gray-300 rounded shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" value="{{ $product->tgl_trial }}" readonly
                           required>
                </div>
                <div>
                    <label for="nama_produk" class="block text-sm font-medium text-gray-700">Nama Produk</label>
                    <input type="text" name="nama_produk" id="nama_produk"
                           class="mt-1 block w-full border border-gray-300 rounded shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" value="{{ $product->nama_produk }}"
                           placeholder="Masukkan nama produk..." readonly required>
                </div>
                <div>
                    <label for="no_formula" class="block text-sm font-medium text-gray-700">No Formula</label>
                    <input type="text" name="no_formula" id="no_formula"
                           class="mt-1 block w-full border border-gray-300 rounded shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" value="{{ $product->no_formula }}"
                           placeholder="Masukkan No Formula..." readonly required>
                </div>
                <div>
                    <label for="kode_sample" class="block text-sm font-medium text-gray-700">Kode Sample</label>
                    <input type="text" name="kode_sample" id="kode_sample"
                           class="mt-1 block w-full border border-gray-300 rounded shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" value="{{ $product->kode_sample }}"
                           placeholder="Masukkan Kode Sample..." readonly required>
                </div>
            </div>
            

            <!-- Accelerated Stability -->
            <div class="col-span-2 mt-6">
                <h3 class="text-xl font-bold text-blue-700 mb-4">Accelerated Stability Testing</h3>
                <div class="overflow-x-auto bg-gray-50 rounded-lg shadow-md p-4">
                    <table class="w-full bg-white rounded-lg border-collapse">
                        <thead class="bg-gray-100 border-b">
                            <tr>
                                <th class="px-6 py-3 text-left text-gray-600 font-medium">Parameter</th>
                                <th class="px-6 py-3 text-left text-gray-600 font-medium w-1/5">Syarat</th>
                                @foreach(['awal', 1, 2, 3, 4, 5, 6] as $timepoint)
                                    <th class="px-6 py-3 text-center text-gray-600 font-medium">{{ $timepoint }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                        @foreach(['Bentuk', 'Warna', 'Bau', 'Kejernihan', 'Homogenitas', 'pH', 'Viskositas', 'Mikrobiologi'] as $parameter)
<tr class="border-b hover:bg-gray-50">
    <td class="px-6 py-3 text-gray-700">{{ $parameter }}</td>
    <td class="px-6 py-3">
        <input type="text" name="syarat_accelerated[{{ strtolower($parameter) }}]" 
               value="{{ $stabilities['accelerated'][strtolower($parameter)]['syarat'] ?? '' }}"
               class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-300">
    </td>
    @for($i = 0; $i <= 6; $i++)
        <td class="px-6 py-3 text-center">
            <div class="flex flex-col space-y-2">
                <input type="text" 
                       name="keterangan_accelerated[{{ strtolower($parameter) }}][{{ $i == 0 ? 'awal' : $i }}]" 
                       placeholder="Keterangan..."
                       value="{{ $stabilities['accelerated'][strtolower($parameter)]['checklist'][$i == 0 ? 'awal' : $i]['keterangan'] ?? '' }}"
                       class="border border-gray-300 rounded px-2 py-1 focus:outline-none focus:ring-1 focus:ring-blue-300 text-sm w-full">
                <select name="accelerated[{{ strtolower($parameter) }}][{{ $i == 0 ? 'awal' : $i }}]" 
                        class="form-select border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500 text-sm w-full">
                    <option value="" disabled {{ !isset($stabilities['accelerated'][strtolower($parameter)]['checklist'][$i == 0 ? 'awal' : $i]['value']) ? 'selected' : '' }}>
                        Pilih Data
                    </option>
                    <option value="MS" {{ ($stabilities['accelerated'][strtolower($parameter)]['checklist'][$i == 0 ? 'awal' : $i]['value'] ?? '') == 'MS' ? 'selected' : '' }}>
                        MS
                    </option>
                    <option value="TMS" {{ ($stabilities['accelerated'][strtolower($parameter)]['checklist'][$i == 0 ? 'awal' : $i]['value'] ?? '') == 'TMS' ? 'selected' : '' }}>
                        TMS
                    </option>
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
                                @foreach(['awal', 3, 6, 9, 12, 18, 24, 36] as $timepoint)
                                    <th class="px-6 py-3 text-center text-gray-600 font-medium">{{ $timepoint }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                        @foreach(['Bentuk', 'Warna', 'Bau', 'Kejernihan', 'Homogenitas', 'pH', 'Viskositas', 'Mikrobiologi'] as $parameter)
<tr class="border-b hover:bg-gray-50">
    <td class="px-6 py-3 text-gray-700">{{ $parameter }}</td>
    <td class="px-6 py-3">
        <input type="text" name="syarat_long_term[{{ strtolower($parameter) }}]" 
               value="{{ $stabilities['long_term'][strtolower($parameter)]['syarat'] ?? '' }}"
               class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-300">
    </td>
    @foreach(['awal', 3, 6, 9, 12, 18, 24, 36] as $month)
        <td class="px-6 py-3 text-center">
            <div class="flex flex-col space-y-2">
                <input type="text" 
                       name="keterangan_long_term[{{ strtolower($parameter) }}][{{ $month }}]" 
                       placeholder="Keterangan..."
                       value="{{ $stabilities['long_term'][strtolower($parameter)]['checklist'][$month]['keterangan'] ?? '' }}"
                       class="border border-gray-300 rounded px-2 py-1 focus:outline-none focus:ring-1 focus:ring-green-300 text-sm w-full">
                <select name="long_term[{{ strtolower($parameter) }}][{{ $month }}]" 
                        class="form-select border-gray-300 rounded focus:ring-green-500 focus:border-green-500 text-sm w-full">
                    <option value="" disabled {{ !isset($stabilities['long_term'][strtolower($parameter)]['checklist'][$month]['value']) ? 'selected' : '' }}>
                        Pilih Data
                    </option>
                    <option value="MS" {{ ($stabilities['long_term'][strtolower($parameter)]['checklist'][$month]['value'] ?? '') == 'MS' ? 'selected' : '' }}>
                        MS
                    </option>
                    <option value="TMS" {{ ($stabilities['long_term'][strtolower($parameter)]['checklist'][$month]['value'] ?? '') == 'TMS' ? 'selected' : '' }}>
                        TMS
                    </option>
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

            <!-- Submit Buttons -->
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
</style>
<script>
function selectRow(row) {
    const nomorFormula = row.querySelector('[data-nomor-formula]').textContent;
    const kodeSample = row.querySelector('[data-kode-sample]').textContent;
    const namaSample = row.querySelector('[data-nama-sample]').textContent;
    const id = row.querySelector('[data-id]').textContent;

    document.getElementById('no_formula').value = nomorFormula;
    document.getElementById('kode_sample').value = kodeSample;
    document.getElementById('nama_produk').value = namaSample;
    document.getElementById('id_input').value = id;
}

</script>
@endsection
