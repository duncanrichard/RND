@extends('layout.main')

@section('content')
<div class="w-full px-6 py-6 mx-auto mt-10">
    <div class="bg-white shadow-lg rounded-lg p-6">
        <h2 class="text-2xl font-bold mb-6 text-center text-blue-700">Update Bahan Baku</h2>
        <form action="{{ route('master_bahan_baku.update', $bahan_baku->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-2 gap-4">
                <!-- Kolom Kiri -->
                <div>
                        <label for="kode" class="block text-sm font-medium text-gray-700">Kode</label>
                        <input type="text" name="kode" id="kode" 
                               value="{{ $bahan_baku->kode }}" 
                              class="mt-1 block w-full border border-gray-300 rounded shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" 
                       readonly required>
                    </div>
                <br>
                <div>
                        <label for="raw_material" class="block text-sm font-medium text-gray-700">Raw Material</label>
                        <input type="text" name="raw_material" id="raw_material" 
                               value="{{ $bahan_baku->raw_material }}" 
                              class="mt-1 block w-full border border-gray-300 rounded shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" 
                       required>
                    </div>
                <br>
                <div>
                        <label for="inci_name" class="block text-sm font-medium text-gray-700">Inci Name</label>
                        <input type="text" name="inci_name" id="inci_name" 
                               value="{{ $bahan_baku->inci_name }}" 
                              class="mt-1 block w-full border border-gray-300 rounded shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" 
                       required>
                    </div>
                <br>
                <div>
                        <label for="sediaan" class="block text-sm font-medium text-gray-700">Sediaan</label>
                        <input type="text" name="sediaan" id="sediaan" 
                               value="{{ $bahan_baku->sediaan }}" 
                              class="mt-1 block w-full border border-gray-300 rounded shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" 
                       required>
                       </div>
                <br>
                <div>
                        <label for="principle" class="block text-sm font-medium text-gray-700">Principle</label>
                        <input type="text" name="principle" id="principle" 
                               value="{{ $bahan_baku->principle }}" 
                              class="mt-1 block w-full border border-gray-300 rounded shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" 
                       required>
                    </div>
                <br>
                <div>
                    <label for="supplier" class="block text-sm font-medium text-gray-700">Supplier</label>
                    <input type="text" name="supplier" id="supplier" 
                               value="{{ $bahan_baku->supplier }}" 
                              class="mt-1 block w-full border border-gray-300 rounded shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" 
                       required>
                </div>
                <br>
                <div>
                        <label for="function" class="block text-sm font-medium text-gray-700">Function</label>
                        <input type="text" name="function" id="function" 
                               value="{{ $bahan_baku->function }}" 
                              class="mt-1 block w-full border border-gray-300 rounded shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" 
                       required>
                    </div>
                <br>
                <div>
                    <label for="jumlah_diterima" class="block text-sm font-medium text-gray-700">Jumlah Di Terima</label>
                    <input type="text" name="jumlah_diterima" id="jumlah_diterima" value="{{ $bahan_baku->jumlah_diterima }}"
                           class="mt-1 block w-full border border-gray-300 rounded shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" 
                           required>
                </div>
                <br>
                <div>
                <label for="satuan" class="block text-sm font-medium text-gray-700">Satuan</label>
                    <select name="satuan" id="satuan" 
                        class="mt-1 block w-full border border-gray-300 rounded shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" 
                        required>
                        <option value="" disabled>Pilih Satuan</option>
                        @foreach($satuanList as $satuan)
                            <option value="{{ $satuan->id }}" {{ $bahan_baku->satuan == $satuan->nama_satuan ? 'selected' : '' }}>
                                {{ $satuan->nama_satuan }}
                            </option>
                        @endforeach
                    </select>
                    </div>
                <br>
                <div>
                        <label for="tgl_terima" class="block text-sm font-medium text-gray-700">Tanggal Terima</label>
                        <input type="date" name="tgl_terima" id="tgl_terima" 
                               value="{{ $bahan_baku->tgl_terima }}" 
                              class="mt-1 block w-full border border-gray-300 rounded shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" 
                       required>
                    </div>
               
<br>
            <div class="mt-6">
                <label for="keterangan" class="block text-sm font-medium text-gray-700">Keterangan</label>
                <textarea name="keterangan" id="keterangan" rows="4" 
                          class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm py-2 px-4 focus:ring-blue-500 focus:border-blue-500">{{ $bahan_baku->keterangan }}</textarea>
            </div>
    <br>
    
            <div>
                <button type="submit" class="w-full font-bold px-4 py-2 text-white rounded-lg" style="background-color: #032859;">
                    Simpan
                </button>
                <a href="{{ route('master_bahan_baku.index') }}" 
                   class="w-full font-bold px-4 py-2 text-white rounded-lg bg-gray-500 hover:bg-gray-600 mt-2 inline-block text-center" style="background-color: #032859;">
                    Batal
                </a>
            </div>
            </div>
    </div>
        </form>
    </div>
</div>
@endsection
