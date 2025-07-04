@extends('layout.main')

@section('content')
<div class="w-full px-6 py-6 mx-auto mt-10">
    <div class="bg-white shadow-lg rounded-lg p-6">
        <h2 class="text-3xl font-bold mb-6 text-blue-600">Detail Formula Sample</h2>

        <!-- Informasi Utama -->
        <div class="mb-8">
            <h3 class="font-semibold text-2xl text-gray-700 mb-4 border-b pb-2">Informasi Utama</h3>
            <div class="grid grid-cols-2 gap-6">
                <div>
                    <p class="text-lg"><strong>No Formula:</strong> {{ $formulaSample->nomor_formula }}</p>
                    <p class="text-lg"><strong>Tanggal:</strong> {{ $formulaSample->tanggal }}</p>
                    <p class="text-lg"><strong>Nama Sample:</strong> {{ $formulaSample->nama_sample }}</p>
                </div>
                <div>
                    <p class="text-lg"><strong>Kode Sample:</strong> {{ $formulaSample->kode_sample }}</p>
                    <p class="text-lg"><strong>Bahan Aktif:</strong> {{ $formulaSample->bahan_aktif }}</p>
                    <p class="text-lg"><strong>ID Imput:</strong> {{ $formulaSample->id_input }}</p>
                </div>
            </div>
        </div>

        

        <!-- Detail Bahan -->
        <div class="mb-8">
            <h3 class="font-semibold text-2xl text-gray-700 mb-4 border-b pb-2">Detail Bahan</h3>
            @if($formulaSample->details->count() > 0)
            <div class="overflow-x-auto">
                <table class="table-full-width border border-gray-300 rounded-lg">
                    <thead class="bg-blue-100 text-blue-800">
                        <tr>
                            <th class="py-3 px-4 border-b text-left">Premix</th>
                            <th class="py-3 px-4 border-b text-left">Kode Bahan Baku</th>
                            <th class="py-3 px-4 border-b text-left">Nama Bahan Baku</th>
                            <th class="py-3 px-4 border-b text-left">Function</th>
                            <th class="py-3 px-4 border-b text-left">Supplier</th>
                            <th class="py-3 px-4 border-b text-left">Jumlah</th>
                            <th class="py-3 px-4 border-b text-left">Satuan</th>
                            <th class="py-3 px-4 border-b text-left">HPP</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($formulaSample->details as $detail)
                        <tr class="hover:bg-gray-100">
                            <td class="py-3 px-4 border-b">{{ $detail->premix }}</td>
                            <td class="py-3 px-4 border-b">{{ $detail->kode_bahan_baku }}</td>
                            <td class="py-3 px-4 border-b">{{ $detail->nama_bahan_baku }}</td>
                            <td class="py-3 px-4 border-b">{{ $detail->function }}</td>
                            <td class="py-3 px-4 border-b">{{ $detail->supplier }}</td>
                            <td class="py-3 px-4 border-b">{{ $detail->jumlah_satuan}}</td>
                            <td class="py-3 px-4 border-b">
                                {{ $detail->satuanModel->nama_satuan ?? 'Tidak Diketahui' }}
                            </td>
                            <td class="py-3 px-4 border-b">{{ $detail->hpp}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <p class="text-gray-500 text-lg">Detail bahan belum tersedia.</p>
            @endif
        </div>

       

        <!-- Prosedur Kerja -->
      <!-- Prosedur Kerja -->
<div class="mb-8">
    <h3 class="font-semibold text-2xl text-gray-700 mb-4 border-b pb-2">Prosedur Kerja</h3>
    @if($formulaSample->prosedurs->count() > 0)
    <ol class="list-decimal list-inside text-lg text-gray-700">
        @foreach($formulaSample->prosedurs->sortBy('id') as $prosedur)
        <li>{{ $prosedur->detail }}</li>
        @endforeach
    </ol>
    @else
    <p class="text-gray-500 text-lg">Prosedur kerja belum tersedia.</p>
    @endif
</div>

         <!-- Spesifikasi -->
         <div class="mb-8">
            <h3 class="font-semibold text-2xl text-gray-700 mb-4 border-b pb-2">Spesifikasi</h3>
            @if($spesifikasi)
            <div class="grid grid-cols-2 gap-6">
                <p class="text-lg"><strong>Bentuk:</strong> {{ $spesifikasi->bentuk }}</p>
                <p class="text-lg"><strong>Warna:</strong> {{ $spesifikasi->warna }}</p>
                <p class="text-lg"><strong>Bau:</strong> {{ $spesifikasi->bau }}</p>
                <p class="text-lg"><strong>pH:</strong> {{ $spesifikasi->ph }}</p>
                <p class="text-lg"><strong>Viskositas:</strong> {{ $spesifikasi->viskositas }}</p>
            </div>
            @else
            <p class="text-gray-500 text-lg">Spesifikasi belum tersedia.</p>
            @endif
        </div>

         <!-- Spesifikasi Tambahan -->
         <div class="mb-8">
            <h3 class="font-semibold text-2xl text-gray-700 mb-4 border-b pb-2">Spesifikasi Tambahan</h3>
            @if($formulaSample->spesifikasiTambahan->count() > 0)
            <div class="overflow-x-auto">
                <table class="table-full-width border border-gray-300 rounded-lg">
                    <thead class="bg-blue-100 text-blue-800">
                        <tr>
                            <th class="py-3 px-4 border-b text-left">Data Spesifikasi</th>
                            <th class="py-3 px-4 border-b text-left">Hasil</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($formulaSample->spesifikasiTambahan as $spesifikasi)
                        <tr class="hover:bg-gray-100">
                            <td class="py-3 px-4 border-b">{{ $spesifikasi->data_spesifikasi }}</td>
                            <td class="py-3 px-4 border-b">{{ $spesifikasi->hasil }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <p class="text-gray-500 text-lg">Data spesifikasi tambahan belum tersedia.</p>
            @endif
        </div>
        <!-- Tombol Kembali -->
        <div class="mt-6">
        <a href="{{ route('master_formula_sample.print', $formulaSample->id) }}" target="_blank" 
   class="px-6 py-3 bg-green-500 text-white text-lg font-semibold rounded-lg hover:bg-green-600">
    Print PDF
</a>

            <a href="{{ route('master_formula_sample.index') }}" class="px-6 py-3 bg-blue-500 text-white text-lg font-semibold rounded-lg hover:bg-blue-600 transition duration-200">Kembali</a>
        </div>
    </div>
</div>

<!-- CSS -->
<style>
    .grid-cols-2 {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1.5rem;
    }

    .border-b {
        border-bottom: 2px solid #e2e8f0;
    }

    .bg-blue-100 {
        background-color: #ebf8ff;
    }

    .text-blue-800 {
        color: #2b6cb0;
    }

    .hover\:bg-gray-100:hover {
        background-color: #f7fafc;
    }

    .font-semibold {
        font-weight: 600;
    }

    .rounded-lg {
        border-radius: 0.75rem;
    }

    .shadow-lg {
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1), 0 1px 3px rgba(0, 0, 0, 0.06);
    }

    .transition {
        transition: all 0.3s ease-in-out;
    }

    .hover\:bg-blue-600:hover {
        background-color: #3182ce;
    }

    .px-6 {
        padding-left: 1.5rem;
        padding-right: 1.5rem;
    }

    .py-3 {
        padding-top: 0.75rem;
        padding-bottom: 0.75rem;
    }

    .text-lg {
        font-size: 1.125rem;
        line-height: 1.75rem;
    }

    .table-full-width {
        width: 100%;
        /* Buat tabel memiliki lebar penuh */
    }
</style>
@endsection
