@extends('layout.main')
@section('content')
<div class="w-full px-6 py-6 mx-auto mt-10">
    <div class="bg-white shadow-lg rounded-lg p-6">
        <h2 class="text-2xl font-bold mb-4">Tambah Master Data Stabilitas R&D</h2>
        <form action="{{ route('master_data_stabilitas_rd.store') }}" method="POST" class="space-y-6">
            @csrf
            <div class="grid grid-cols-2 gap-4">
                <!-- Kolom Kiri -->
                <div>
                    <label for="nama_produk" class="block text-sm font-medium text-gray-700">Nama Produk</label>
                    <input type="text" name="nama_produk" id="nama_produk"
                           class="mt-1 block w-full border border-gray-300 rounded shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                           placeholder="Masukkan nama produk..." required>
                </div>
                <br>
                <div></div> <!-- Empty cell for alignment -->

                <!-- Accelerated Stability -->
                <div class="table-container bg-gray-50 rounded-lg shadow-md p-4">
                    <table class="w-full bg-white rounded-lg border-collapse">
                        <thead class="bg-gray-100 border-b">
                            <tr>
                                <th class="px-6 py-3 text-left text-gray-600 font-medium w-1/5">Parameter</th>
                                <th class="px-6 py-3 text-left text-gray-600 font-medium w-1/5">Syarat</th>
                                @for($i = 0; $i <= 6; $i++)
                                    <th class="px-6 py-3 text-center text-gray-600 font-medium">{{ $i == 0 ? 'Awal' : $i }}</th>
                                @endfor
                            </tr>
                        </thead>
                        <tbody>
                            @foreach(['Bentuk', 'Warna', 'Bau', 'Kejernihan', 'Homogenitas', 'pH', 'Viskositas'] as $parameter)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="px-6 py-3 text-gray-700">{{ $parameter }}</td>
                                <td class="px-6 py-3">
                                    <input type="text" name="syarat_accelerated[{{ strtolower($parameter) }}]" value="-" 
                                        class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-300">
                                </td>
                                @for($i = 0; $i <= 6; $i++)
                                <td class="px-6 py-3 text-center">
                                    <input type="checkbox" name="accelerated[{{ strtolower($parameter) }}][{{ $i == 0 ? 'awal' : $i }}]" 
                                        class="form-checkbox h-5 w-5 text-blue-600">
                                </td>
                                @endfor
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                        

                            <!-- Long Term Stability -->
                <div class="col-span-2 mt-6">
                    <h3 class="text-xl font-bold text-green-700 mb-4">Long Term Stability Testing</h3>
                    <div class="table-container bg-gray-50 rounded-lg shadow-md p-4">
                        <table class="w-full bg-white rounded-lg border-collapse">
                            <thead class="bg-gray-100 border-b">
                                <tr>
                                    <th class="px-6 py-3 text-left text-gray-600 font-medium w-1/5">Parameter</th>
                                    <th class="px-6 py-3 text-left text-gray-600 font-medium w-1/5">Syarat</th>
                                    @foreach(['Awal', 3, 6, 9, 12, 18, 24, 36] as $month)
                                        <th class="px-6 py-3 text-center text-gray-600 font-medium">{{ $month }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @foreach(['Bentuk', 'Warna', 'Bau', 'Kejernihan', 'Homogenitas', 'pH', 'Viskositas'] as $parameter)
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="px-6 py-3 text-gray-700">{{ $parameter }}</td>
                                    <td class="px-6 py-3">
                                        <input type="text" name="syarat_long_term[{{ strtolower($parameter) }}]" value="-" 
                                            class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-1 focus:ring-green-300">
                                    </td>
                                    @foreach(['awal', 3, 6, 9, 12, 18, 24, 36] as $month)
                                    <td class="px-6 py-3 text-center">
                                        <input type="checkbox" name="long_term[{{ strtolower($parameter) }}][{{ $month }}]" 
                                            class="form-checkbox h-5 w-5 text-green-600">
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
@endsection
