@extends('layout.main')
@section('content')
<div class="w-full px-6 py-6 mx-auto mt-10">
    <div class="bg-white shadow-lg rounded-lg p-6">
        <h2 class="text-2xl font-bold mb-4">Master PPN</h2>

        <!-- Alert -->
        @if(session('success'))
            <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        <!-- Tombol Tambah Data -->
        <div class="mb-4">
            @can('create master ppn')
                @if($master_ppn->count() == 0)
                    <a href="{{ route('master_ppn.create') }}" 
                       class="px-4 py-2 font-bold bg-blue-500 text-white rounded hover:bg-blue-600">
                        Tambah Data
                    </a>
                @else
                    <button disabled class="px-4 py-2 font-bold bg-gray-300 text-white rounded">
                        Tambah Data (Tidak Tersedia)
                    </button>
                @endif
            @endcan
        </div>

        <!-- Informasi Sumber Kurs -->
        <div class="mb-4 p-4 bg-blue-100 border-l-4 border-blue-500 text-blue-700">
            <p><strong>Informasi Kurs:</strong> Nilai tukar kurs diperoleh dari 
                <a href="https://www.bi.go.id/id/statistik/informasi-kurs/transaksi-bi/Default.aspx" target="_blank" class="text-blue-600 underline">Bank Indonesia</a>.
            </p>
            <p>Pastikan Anda memeriksa sumber resmi untuk kurs terbaru.</p>
        </div>

        <!-- Tabel Data -->
        <div class="overflow-x-auto mt-6">
            <table id="ppnTable" class="min-w-full bg-white">
                <thead class="bg-gray-200 text-center">
                    <tr>
                        <th class="py-2 px-4 border-b">No</th>
                        <th class="py-2 px-4 border-b">PPN</th>
                        <th class="py-2 px-4 border-b">PPH</th>
                        <th class="py-2 px-4 border-b">Rupiah</th>
                        <th class="py-2 px-4 border-b">USD $</th>
                        <th class="py-2 px-4 border-b">Kurs Euro</th>
                        <th class="py-2 px-4 border-b">Kurs Yuan</th>
                        <th class="py-2 px-4 border-b">Additional Cost</th>
                        <th class="py-2 px-4 border-b">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    @foreach($master_ppn as $key => $item)
                    <tr>
                        <td class="py-2 px-4 border-b">{{ $key + 1 }}</td>
                        <td class="py-2 px-4 border-b">{{ $item->ppn }} %</td>
                        <td class="py-2 px-4 border-b">{{ $item->pph }} %</td>
                        <td class="py-2 px-4 border-b">Rp. {{ number_format($item->kurs_rupiah, 2, ',', '.') }}</td>
                        <td class="py-2 px-4 border-b">Rp. {{ number_format($item->kurs_usd, 2, ',', '.') }}</td>
                        <td class="py-2 px-4 border-b">Rp. {{ number_format($item->kurs_euro, 2, ',', '.') }}</td>
                        <td class="py-2 px-4 border-b">Rp. {{ number_format($item->kurs_yuan, 2, ',', '.') }}</td>
                        <td class="py-2 px-4 border-b">{{ $item->additional_cost }} %</td>
                        <td class="py-2 px-4 border-b">
                            @can('edit master ppn')
                            <a href="{{ route('master_ppn.edit', $item->id) }}" 
                               class="px-4 py-2 font-bold text-white rounded inline-flex items-center" 
                               style="background-color: #FF8C00;">
                                Edit
                            </a>
                            @endcan

                            @can('delete master ppn')
                            <form action="{{ route('master_ppn.destroy', $item->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-4 py-2 font-bold text-white rounded inline-flex items-center" style="background-color: #ef4444;">
                                    Hapus
                                </button>
                            </form>
                            @endcan
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

<script src="{{ asset('Modal/ppn.js') }}" defer></script>
