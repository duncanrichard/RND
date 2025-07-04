@extends('layout.main')

@section('content')
<div class="w-full px-6 py-6 mx-auto mt-10">
    <div class="bg-white shadow-lg rounded-lg p-6">
        <h2 class="text-2xl font-bold mb-4">Detail Purchase Request</h2>
      
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
    <div class="flex">
        <p class="text-gray-600 w-56"><strong class="text-gray-800">No Purchase Request</strong></p>
        <p class="text-gray-600 w-4 text-center">:</p>
        <p class="text-lg text-gray-900 font-semibold">{{ $purchaseRequest->no_purchase_request }}</p>
    </div>
    <div class="flex">
        <p class="text-gray-600 w-56"><strong class="text-gray-800">Tanggal</strong></p>
        <p class="text-gray-600 w-4 text-center">:</p>
        <p class="text-lg text-gray-900 font-semibold">{{ \Carbon\Carbon::parse($purchaseRequest->tanggal)->format('d/m/Y') }}</p>
    </div>
    <div class="flex">
        <p class="text-gray-600 w-56"><strong class="text-gray-800">Departemen</strong></p>
        <p class="text-gray-600 w-4 text-center">:</p>
        <p class="text-lg text-gray-900 font-semibold">{{ $purchaseRequest->departemen }}</p>
    </div>
    <div class="flex">
        <p class="text-gray-600 w-56"><strong class="text-gray-800">Kategori Barang</strong></p>
        <p class="text-gray-600 w-4 text-center">:</p>
        <p class="text-lg text-gray-900 font-semibold">{{ $purchaseRequest->kategori_barang }}</p>
    </div>
</div>



        <h3 class="text-xl font-bold mt-6">Detail Barang</h3>
        <table id="Purchase_Request"  class="min-w-full bg-white border border-gray-300 rounded-lg mt-4">
            <thead class="bg-gray-200 text-gray-700">
                <tr>
                    <th class="py-2 px-4 text-left border-b">No</th>
                    <th class="py-2 px-4 text-left border-b">Kode Barang</th>
                    <th class="py-2 px-4 text-left border-b">Nama Barang</th>
                    <th class="py-2 px-4 text-left border-b">Kategori</th>
                    <th class="py-2 px-4 text-left border-b">Jumlah</th>
                    <th class="py-2 px-4 text-left border-b">Satuan</th>
                    <th class="py-2 px-4 text-left border-b">Rencana Kedatangan</th>
                    <th class="py-2 px-4 text-left border-b">Keterangan</th>
                    <th class="py-2 px-4 text-left border-b">Lihat Dokumen</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($purchaseRequest->details as $key => $detail)
                <tr>
                    <td class="py-2 px-4 border-b">{{ $key + 1 }}</td>
                    <td class="py-2 px-4 border-b">{{ $detail->kode_barang }}</td>
                    <td class="py-2 px-4 border-b">{{ $detail->nama_barang }}</td>
                    <td class="py-2 px-4 border-b">{{ $detail->kategori }}</td>
                    <td class="py-2 px-4 border-b">{{ $detail->jumlah }}</td>
                    <td class="py-2 px-4 border-b">{{ $detail->satuan }}</td>
                    <td class="py-2 px-4 border-b">{{ $detail->rencana_kedatangan }}</td>
                    <td class="py-2 px-4 border-b">{{ $detail->keterangan }}</td>
                    <td class="py-2 px-4 border-b">
                @if ($detail->dokumen)
                <a href="{{ asset('storage/' . str_replace('public/', '', $detail->dokumen)) }}" target="_blank" class="px-4 py-2 font-bold text-white rounded inline-flex items-center" style="background-color: #FFD700; hover:background-color: #FFC700;">Lihat PDF</a>



                @else
                    <span class="text-gray-500">Tidak ada dokumen</span>
                @endif
            </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="py-4 px-6 text-center text-gray-500">Tidak ada detail barang</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        <a href="{{ route('purchase-requests.print', $purchaseRequest->id) }}" target="_blank" 
        class="px-4 py-2 font-bold text-white rounded inline-flex items-center bg-blue-500 hover:bg-blue-600">
    Print PDF
</a>

        <a href="{{ route('purchase-requests.index') }}"   class="w-full font-bold px-4 py-2 text-white rounded-lg bg-gray-500 hover:bg-gray-600 mt-2 inline-block text-center" style="background-color: #032859;">Kembali ke Daftar</a>
        <div>

        </div>
    </div>
</div>
<script src="{{ asset('Modal/Purchase_Request.js') }}" defer></script>
@endsection
