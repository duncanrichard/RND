@extends('layout.main')

@section('content')
<div class="w-full px-6 py-6 mx-auto mt-10">
    <div class="bg-white shadow-lg rounded-lg p-6">
        <h2 class="text-2xl font-bold mb-6 text-center border-b pb-4">Detail Bahan Baku</h2>



        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-gray-100 p-4 rounded-lg shadow">
                <h3 class="text-lg font-semibold mb-4">Informasi Umum</h3>
                <p><strong>Kategori Bahan Baku:</strong> {{ $bahanBaku->jenisBahanBaku->nama_bahan_baku ?? '-' }}</p>
                <p><strong>Kode Kategori Bahan Baku:</strong> {{ $bahanBaku->jenis_bahan_baku_jenis_urut }}</p>
                <p><strong>Nama Bahan Baku:</strong> {{ $bahanBaku->koding_bahan_baku }}</p>
                <p><strong>Nama Coding:</strong> {{ $bahanBaku->nama_coding }}</p>
                <p><strong>Nama Inci:</strong> {{ $bahanBaku->nama_inci }}</p>
                <p><strong>Jenis Sediaan:</strong> {{ $bahanBaku->jenis_sediaan }}</p>
            </div>

            <div class="bg-gray-100 p-4 rounded-lg shadow">
                <h3 class="text-lg font-semibold mb-4">Informasi Tambahan</h3>
                <p><strong>Satuan:</strong> {{ $bahanBaku->satuan }}</p>
                <p><strong>Cara Penyimpanan:</strong> {{ $bahanBaku->cara_penyimpanan }}</p>
                <p><strong>Harga PO:</strong> Rp {{ number_format($bahanBaku->harga_po, 2) }}</p>
                <p><strong>PPN:</strong> Rp {{ number_format($bahanBaku->ppn, 2) }}</p>
                <p><strong>Additional Cost:</strong> Rp {{ number_format($bahanBaku->mark_up, 2) }}</p>
                <p><strong>HPBB:</strong> Rp {{ number_format($bahanBaku->hpbb, 2) }}</p>
            </div>
        </div>

        <div class="mt-8 bg-gray-100 p-4 rounded-lg shadow">
            <h3 class="text-lg font-semibold mb-4">Dokumen Pendukung</h3>
            <ul class="list-disc pl-6 space-y-2">
                <li>
                    <strong>CoA:</strong> 
                    @if($bahanBaku->coa_file)
                        <a href="{{ asset('storage/' . $bahanBaku->coa_file) }}" target="_blank" class="text-blue-500 underline hover:text-blue-600">Lihat CoA</a>
                    @else
                        <span class="text-gray-500">Tidak ada file</span>
                    @endif
                </li>
                <li>
                    <strong>MSDS:</strong> 
                    @if($bahanBaku->msds_file)
                        <a href="{{ asset('storage/' . $bahanBaku->msds_file) }}" target="_blank" class="text-blue-500 underline hover:text-blue-600">Lihat MSDS</a>
                    @else
                        <span class="text-gray-500">Tidak ada file</span>
                    @endif
                </li>
                <li>
                    <strong>Sertifikat Halal:</strong> 
                    @if($bahanBaku->sertifikat_halal_file)
                        <a href="{{ asset('storage/' . $bahanBaku->sertifikat_halal_file) }}" target="_blank" class="text-blue-500 underline hover:text-blue-600">Lihat Sertifikat Halal</a>
                    @else
                        <span class="text-gray-500">Tidak ada file</span>
                    @endif
                </li>
            </ul>
        </div>
    
    <div>
                
                <a href="{{ route('bahan_baku.index') }}" 
   class="w-full font-bold px-4 py-2 text-white rounded-lg bg-gray-500 hover:bg-gray-600 mt-2 inline-block text-center" 
   style="background-color: #032859;">
    Batal
</a>
</div>
            </div>
</div>

<style>
    .grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 1.5rem;
    }

    @media (min-width: 768px) {
        .grid {
            grid-template-columns: 1fr 1fr;
        }
    }

    .shadow {
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .rounded {
        border-radius: 0.5rem;
    }

    .bg-gray-100 {
        background-color: #f7fafc;
    }

    .text-blue-500 {
        color: #4299e1;
    }

    .text-blue-500:hover {
        color: #3182ce;
    }

    .font-bold {
        font-weight: 700;
    }

    .font-semibold {
        font-weight: 600;
    }

    .text-lg {
        font-size: 1.125rem;
    }

    .underline {
        text-decoration: underline;
    }
</style>
@endsection
