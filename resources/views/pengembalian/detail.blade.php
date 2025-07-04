
@extends('layout.main')
@section('content')
<div class="w-full px-6 py-6 mx-auto mt-10">
    <div class="bg-white shadow-lg rounded-lg p-6">
        <h2 class="text-2xl font-bold mb-4">Detail Pengembalian</h2>
        <li class="relative flex items-center justify-end pr-2">
            <p class="hidden transform-dropdown-show"></p>
        </li>
        <div class="flex space-x-4 items-center mb-6">
            <a href="{{ route('pengembalian.export') }}" 
                class="px-4 py-2 font-bold bg-blue-500 text-white rounded inline-flex items-center mr-4" 
                style="background-color: #008000;">
                    Unduh Excel
            </a>
            <a href="{{ route('pengembalian.printDetailPengembalian', ['id' => $mainData->id]) }}" 
                class="px-4 py-2 font-bold bg-blue-500 text-white rounded inline-flex items-center mr-4" 
                style="background-color: #ef4444;">
                Print Pengembalian
            </a>

        </div>

        <br>
        <div class="flex justify-between items-center border-b border-gray-300">
            <span class="font-bold text-gray-700">Nomor Pengembalian Barang</span>
            <span id="nomor_pengembalian_barang" class="text-gray-700 w-1/2">{{ $mainData->nomor_pengembalian_barang }}</span>
        </div>
        <div class="flex justify-between items-center border-b border-gray-300">
            <span class="font-bold text-gray-700">Tanggal</span>
            <span id="tanggal" class="text-gray-700 w-1/2">{{ $mainData->tanggal }}</span>
        </div>
        <div class="flex justify-between items-center border-b border-gray-300">
            <span class="font-bold text-gray-700">ID Input</span>
            <span id="id_input" class="text-gray-700 w-1/2">{{ $mainData->id_input }}</span>
        </div>
        <div class="flex justify-between items-center border-b border-gray-300">
            <span class="font-bold text-gray-700">Nama Gudang</span>
            <span id="nama_gudang" class="text-gray-700 w-1/2">{{ $mainData->nama_gudang }}</span>
        </div>
        <div class="flex justify-between items-center border-b border-gray-300">
            <span class="font-bold text-gray-700">Jenis Pengembalian</span>
            <span id="jenis_pengembalian" class="text-gray-700 w-1/2">{{ $mainData->jenis_pengembalian }}</span>
        </div>
        <div class="flex justify-between items-center border-b border-gray-300">
            <span class="font-bold text-gray-700">Tujuan Pengembalian</span>
            <span id="tujuan_pengembalian_barang" class="text-gray-700 w-1/2">{{ $mainData->tujuan_pengembalian_barang }}</span>
        </div>
        <br>
        <div class="bg-gray-100 rounded-lg shadow-md p-6 mt-6">
            @if(!empty($detail))
                <h3 class="text-lg font-bold mb-4 mt-6">Detail Pengembalian</h3>
                <div class="overflow-x-auto">
                    <table id="detail_pengembalian" class="display nowrap" style="width:100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kode Barang</th>
                                <th>Nama Barang</th>
                                <th>Jumlah</th>
                                <th>Satuan</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($detail as $key => $item)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $item['kode_barang'] ?? '-' }}</td>
                                    <td>{{ $item['nama_barang'] ?? '-' }}</td>
                                    <td>{{ $item['jumlah'] ?? '-' }}</td>
                                    <td>{{ $item['satuan'] ?? '-' }}</td>
                                    <td>{{ $item['keterangan'] ?? '-' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
  
            @if(empty($detail))
                <h3 class="text-lg font-bold mb-4 text-center">Tidak ada data ditemukan.</h3>
            @endif
        </div>
    </div>
</div>
<script src="{{ asset('Modal/pengembalian.js') }}" defer></script>
@endsection