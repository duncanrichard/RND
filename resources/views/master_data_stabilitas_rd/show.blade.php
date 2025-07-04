@extends('layout.main')
@section('content')
<div class="w-full px-6 py-6 mx-auto mt-10">
    <div class="bg-white shadow-lg rounded-lg p-6">
    <h2 class="text-2xl font-bold mb-4">Detail Produk: {{ $product->nama_produk }}</h2>
        
        <!-- Informasi Detail -->
        <div class="grid grid-cols-2 gap-6">
    <!-- Bagian Kiri -->
    <div class="space-y-4">
        <div>
            <label for="tanggal" class="block text-sm font-medium text-gray-700">Tanggal</label>
            <input type="date" name="tanggal" id="tanggal" value="{{ $product->tanggal }}"
                class="mt-1 block w-full border border-gray-300 rounded shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                readonly>
        </div>
        <div>
            <label for="id_input" class="block text-sm font-medium text-gray-700">ID Input</label>
            <input type="text" name="id_input" id="id_input" value="{{ $product->id_input }}"
                class="mt-1 block w-full border border-gray-300 rounded shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                readonly>
        </div>
        <div>
            <label for="tgl_trial" class="block text-sm font-medium text-gray-700">Tanggal Trial</label>
            <input type="date" name="tgl_trial" id="tgl_trial" value="{{ $product->tgl_trial }}"
                class="mt-1 block w-full border border-gray-300 rounded shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                readonly>
        </div>
    </div>

    <!-- Bagian Kanan -->
    <div class="space-y-4">
        <div>
            <label for="nama_produk" class="block text-sm font-medium text-gray-700">Nama Produk</label>
            <input type="text" name="nama_produk" id="nama_produk" value="{{ $product->nama_produk }}"
                class="mt-1 block w-full border border-gray-300 rounded shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                readonly>
        </div>
        <div>
            <label for="no_formula" class="block text-sm font-medium text-gray-700">No Formula</label>
            <input type="text" name="no_formula" id="no_formula" value="{{ $product->no_formula }}"
                class="mt-1 block w-full border border-gray-300 rounded shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                readonly>
        </div>
        <div>
            <label for="kode_sample" class="block text-sm font-medium text-gray-700">Kode Sample</label>
            <input type="text" name="kode_sample" id="kode_sample" value="{{ $product->kode_sample }}"
                class="mt-1 block w-full border border-gray-300 rounded shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                readonly>
        </div>
    </div>
</div>

        <div class="flex justify-end mt-10">
        <a href="{{ route('master_data_stabilitas_rd.print', $product->id) }}" 
   target="_blank"
   class="bg-green-500 text-white px-4 py-2 rounded shadow hover:bg-green-700">
    Print PDF
</a>

</div>

        <!-- Accelerated Stability -->
        <div class="mt-10">
            <h3 class="text-xl font-bold text-blue-700 mb-6">Accelerated Stability Testing</h3>
            <div class="table-container bg-gray-50 rounded-lg shadow-md p-4">
                <table class="w-full bg-white rounded-lg border-collapse">
                    <thead class="bg-gray-100 border-b">
                        <tr>
                            <th class="px-6 py-3 text-left text-gray-600 font-medium w-1/5">Parameter</th>
                            <th class="px-6 py-3 text-left text-gray-600 font-medium w-1/5">Syarat</th>
                            @foreach(['Awal', 1, 2, 3, 4, 5, 6] as $timepoint)
                                <th class="px-6 py-3 text-center text-gray-600 font-medium">{{ $timepoint }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($product->stabilities->where('type', 'accelerated') as $stability)
                            @php
                                $checklist = json_decode($stability->checklist, true) ?? [];
                            @endphp
                            <tr class="border-b hover:bg-gray-50">
                                <td class="px-6 py-3 text-gray-700">{{ $stability->parameter }}</td>
                                <td class="px-6 py-3 text-gray-700">{{ $stability->syarat }}</td>
                                @foreach(['awal', 1, 2, 3, 4, 5, 6] as $timepoint)
                                    <td class="px-6 py-3 text-center text-gray-700">
                                        @if(isset($checklist[$timepoint]))
                                            {{ $checklist[$timepoint]['keterangan'] ?? '-' }} 
                                            ({{ $checklist[$timepoint]['value'] ?? '-' }})
                                        @else
                                            -
                                        @endif
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <br>

        <!-- Long Term Stability -->
        <div class="mt-10">
            <h3 class="text-xl font-bold text-green-700 mb-6">Long Term Stability Testing</h3>
            <div class="table-container bg-gray-50 rounded-lg shadow-md p-4">
                <table class="w-full bg-white rounded-lg border-collapse">
                    <thead class="bg-gray-100 border-b">
                        <tr>
                            <th class="px-6 py-3 text-left text-gray-600 font-medium w-1/5">Parameter</th>
                            <th class="px-6 py-3 text-left text-gray-600 font-medium w-1/5">Syarat</th>
                            @foreach(['Awal', 3, 6, 9, 12, 18, 24, 36] as $timepoint)
                                <th class="px-6 py-3 text-center text-gray-600 font-medium">{{ $timepoint }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($product->stabilities->where('type', 'long_term') as $stability)
                            @php
                                $checklist = json_decode($stability->checklist, true) ?? [];
                            @endphp
                            <tr class="border-b hover:bg-gray-50">
                                <td class="px-6 py-3 text-gray-700">{{ $stability->parameter }}</td>
                                <td class="px-6 py-3 text-gray-700">{{ $stability->syarat }}</td>
                                @foreach(['awal', 3, 6, 9, 12, 18, 24, 36] as $timepoint)
                                    <td class="px-6 py-3 text-center text-gray-700">
                                        @if(isset($checklist[$timepoint]))
                                            {{ $checklist[$timepoint]['keterangan'] ?? '-' }} 
                                            ({{ $checklist[$timepoint]['value'] ?? '-' }})
                                        @else
                                            -
                                        @endif
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Close Button -->
        <div class="flex justify-end mt-10">
            <a href="{{ route('master_data_stabilitas_rd.index') }}" 
               class="w-full font-bold px-4 py-2 text-white rounded-lg bg-gray-500 hover:bg-gray-600 mt-2 inline-block text-center" 
               style="background-color: #032859;">
                Close
            </a>
        </div>
    </div>
</div>
@endsection
<style>
/* Gaya grid utama */
.grid {
    display: grid;
    grid-template-columns: 1fr 1fr; /* Membagi form menjadi dua kolom */
    gap: 1.5rem; /* Jarak antar kolom */
}

/* Form input */
input[type="text"],
input[type="date"] {
    padding: 0.5rem;
    border: 1px solid #d1d5db; /* Warna border abu-abu */
    border-radius: 0.375rem; /* Border melengkung */
    width: 100%;
    box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05); /* Sedikit bayangan */
}

/* Label */
label {
    font-size: 0.875rem; /* Ukuran font kecil */
    font-weight: 500; /* Teks bold */
    color: #374151; /* Warna teks abu-abu gelap */
}

/* Fokus input */
input:focus {
    border-color: #6366f1; /* Warna fokus ungu */
    outline: none;
    box-shadow: 0 0 0 2px rgba(99, 102, 241, 0.5); /* Lingkaran fokus */
}
</style>
