@extends('layout.main')

@section('content')
<div class="w-full px-6 py-6 mx-auto mt-10">
    <div class="bg-white shadow-lg rounded-lg p-6">
        <h2 class="text-2xl font-bold mb-4">Master Data Stabilitas RND</h2>

        {{-- Alert Success --}}
        @if(session('success'))
        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
        @endif

        {{-- Pengingat Jadwal --}}
        <div class="mb-6 bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded">
            <strong>📅 Pengingat Jadwal Pengisian:</strong>
            <ul class="list-disc ml-5 mt-2">
                <li>Accelerated Stability Testing: Setiap 1 bulan, notifikasi muncul <strong>H-3 sebelum deadline</strong>.</li>
                <li>Long Term Stability Testing: Setiap 3 bulan, notifikasi muncul <strong>H-3 sebelum deadline</strong>.</li>
            </ul>
        </div>

        {{-- Notifikasi --}}
        <div class="mb-6 bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded">
            <strong>🔔 Notifikasi Pengujian:</strong>
            <ul class="list-disc ml-5 mt-2">
                @if(count($notifications) > 0)
                    @foreach($notifications as $notif)
                        <li>
                            <strong>{{ $notif['nama_produk'] }}</strong> - 
                            Accelerated: <span class="text-red-600">{{ $notif['nextAccelerated'] }}</span> 
                            ({{ $notif['daysToAccelerated'] }} hari lagi),
                            Long Term: <span class="text-red-600">{{ $notif['nextLongTerm'] }}</span> 
                            ({{ $notif['daysToLongTerm'] }} hari lagi).
                        </li>
                    @endforeach
                @else
                    <li class="text-green-600">Tidak ada pengujian yang jatuh tempo dalam waktu dekat.</li>
                @endif
            </ul>
        </div>

        {{-- Tombol Tambah --}}
        <div class="mb-4">
            <a href="{{ route('master_data_stabilitas_rd.create') }}" 
               class="px-4 py-2 font-bold bg-blue-500 text-white rounded hover:bg-blue-600">
                Tambah Data
            </a>
        </div>

        {{-- Tabel --}}
        <div class="overflow-x-auto mt-6">
            <table id="data_stabilitas_rnd_Table" class="min-w-full bg-white border border-gray-300 rounded-lg">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="px-4 py-2">No</th>
                        <th class="px-4 py-2 whitespace-nowrap">Nama Produk</th>
                        <th class="px-4 py-2 whitespace-nowrap">Status Accelerated</th>
                        <th class="px-4 py-2 whitespace-nowrap">Status Long Term</th>
                        <th class="px-4 py-2 whitespace-nowrap">Jadwal Pengujian Berikutnya</th>
                        <th class="px-4 py-2 whitespace-nowrap">Sisa Hari</th>
                        <th class="px-4 py-2">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $index => $product)
                    <tr class="border-b">
                        <td class="px-4 py-2 text-center">{{ $index + 1 }}</td>
                        <td class="px-4 py-2">{{ $product->nama_produk }}</td>
                        <td class="px-4 py-2 text-center">
                            <span class="px-2 py-1 text-white rounded {{ $product->isAcceleratedDue ? 'bg-red-500' : 'bg-green-500' }}">
                                {{ $product->isAcceleratedDue ? 'Segera Isi!' : 'Lengkap' }}
                            </span>
                        </td>
                        <td class="px-4 py-2 text-center">
                            <span class="px-2 py-1 text-white rounded {{ $product->isLongTermDue ? 'bg-red-500' : 'bg-green-500' }}">
                                {{ $product->isLongTermDue ? 'Segera Isi!' : 'Lengkap' }}
                            </span>
                        </td>
                        <td class="px-4 py-2 text-center text-blue-700">
                            Accelerated: {{ \Carbon\Carbon::parse($product->nextAccelerated)->format('d-m-Y') }}<br>
                            Long Term: {{ \Carbon\Carbon::parse($product->nextLongTerm)->format('d-m-Y') }}
                        </td>
                        <td class="px-4 py-2 text-center">
                            <span class="{{ $product->daysToAccelerated <= 3 ? 'text-red-600' : 'text-green-600' }}">
                                Accelerated: {{ $product->daysToAccelerated }} hari
                            </span><br>
                            <span class="{{ $product->daysToLongTerm <= 3 ? 'text-red-600' : 'text-green-600' }}">
                                Long Term: {{ $product->daysToLongTerm }} hari
                            </span>
                        </td>
                        <td class="px-4 py-2 text-center">
                            <a href="{{ route('master_data_stabilitas_rd.show', $product->id) }}" 
                               class="px-3 py-1 text-white bg-blue-600 rounded hover:bg-blue-700 text-sm">
                                Detail
                            </a>
                            <a href="{{ route('master_data_stabilitas_rd.edit', $product->id) }}" 
                               class="px-3 py-1 text-white bg-orange-500 rounded hover:bg-orange-600 text-sm">
                                Edit
                            </a>
                            <form action="{{ route('master_data_stabilitas_rd.destroy', $product->id) }}" 
                                  method="POST" class="inline-block" 
                                  onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="px-3 py-1 text-white bg-red-600 rounded hover:bg-red-700 text-sm">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Notifikasi JS --}}
<script>
    document.addEventListener("DOMContentLoaded", function () {
        let rows = document.querySelectorAll("#data_stabilitas_rnd_Table tbody tr");
        rows.forEach(row => {
            let text = row.children[5].textContent;
            let daysToAccelerated = parseInt(text.match(/Accelerated: (\d+)/)?.[1] || 999);
            let daysToLongTerm = parseInt(text.match(/Long Term: (\d+)/)?.[1] || 999);

            if (daysToAccelerated <= 3) {
                alert("⚠️ Peringatan: Ada data Accelerated Stability Testing yang harus segera diisi!");
            }
            if (daysToLongTerm <= 3) {
                alert("⚠️ Peringatan: Ada data Long Term Stability Testing yang harus segera diisi!");
            }
        });

        let notifications = @json($notifications);
        if (notifications.length > 0) {
            let alertMessage = "⚠️ Peringatan: Beberapa pengujian telah jatuh tempo!\n";
            notifications.forEach(notif => {
                alertMessage += `\n${notif.nama_produk} - Accelerated: ${notif.nextAccelerated} (${notif.daysToAccelerated} hari), Long Term: ${notif.nextLongTerm} (${notif.daysToLongTerm} hari)`;
            });
            alert(alertMessage);
        }
    });
</script>

<script src="{{ asset('Modal/stabilitas_rnd.js') }}" defer></script>
@endsection
