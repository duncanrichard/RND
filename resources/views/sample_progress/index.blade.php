@extends('layout.main')

@section('content')
<div class="w-full px-6 py-6 mx-auto mt-10">
    <div class="bg-white shadow-lg rounded-lg p-6">
        <h2 class="text-2xl font-bold mb-4">Sample Progres - {{ $title ?? '' }}</h2>

        @if(session('success'))
            <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
                <button type="button" class="absolute top-0 bottom-0 right-0 px-4 py-3" onclick="this.parentElement.style.display='none'">
                    <svg class="fill-current h-6 w-6 text-green-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <title>Close</title>
                        <path d="M14.348 5.652a.5.5 0 00-.707 0L10 9.293 6.354 5.647a.5.5 0 10-.707.707L9.293 10l-3.646 3.646a.5.5 0 10.707.707L10 10.707l3.646 3.646a.5.5 0 10.707-.707L10.707 10l3.646-3.646a.5.5 0 000-.707z"/>
                    </svg>
                </button>
            </div>
        @endif

        <!-- Tabs -->
        <div class="mb-4 flex space-x-4">
            <a href="{{ route('sample-progress.not-confirm') }}" class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600 {{ request()->routeIs('sample-progress.index') || request()->routeIs('sample-progress.not-confirm') ? 'font-bold' : '' }}">
                Not Confirm
            </a>
            <a href="{{ route('sample-progress.confirm') }}" class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600 {{ request()->routeIs('sample-progress.confirm') ? 'font-bold' : '' }}">
                Confirm
            </a>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto mt-6">
            <table id="sample_progres" class="min-w-full bg-white border-collapse border border-gray-300">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="px-4 py-2 border text-center">No</th>
                        <th class="px-4 py-2 border text-center">No Request Sample</th>
                        <th class="px-4 py-2 border text-center">Tanggal</th>
                        <th class="px-4 py-2 border text-center">Kode Customer</th>
                        <th class="px-4 py-2 border text-center">Nama Customer</th>
                        <th class="px-4 py-2 border text-center">Alamat Pengiriman Sample</th>
                        <th class="px-4 py-2 border text-center">Nomor Telepon PIC</th>
                        <th class="px-4 py-2 border text-center">Progres</th>
                        <th class="px-4 py-2 border text-center">Status</th>
                        @if($title === 'Not Confirm')
                            <th class="px-4 py-2 border text-center">Status Confirm</th>
                        @endif
                        <th class="px-4 py-2 border text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($samples as $sample)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-2 border text-center">{{ $loop->iteration }}</td>
                        <td class="px-4 py-2 border text-center">{{ $sample->no_request_sample }}</td>
                        <td class="px-4 py-2 border text-center">{{ $sample->tanggal }}</td>
                        <td class="px-4 py-2 border text-center">{{ $sample->kode_customer }}</td>
                        <td class="px-4 py-2 border text-center">{{ $sample->nama_customer }}</td>
                        <td class="px-4 py-2 border text-left truncate max-w-xs">{{ $sample->alamat_pengiriman_sample }}</td>
                        <td class="px-4 py-2 border text-center">{{ $sample->nomor_telepon_pic }}</td>
                        <td class="px-4 py-2 border text-center">{{ $progressCounts[$sample->id] ?? 0 }} / 3</td>
                        <td class="px-4 py-2 border text-center">
                            @if(isset($statusList[$sample->id]) && $statusList[$sample->id] == 1)
                                <span class="text-green-500 font-bold">Approved</span>
                            @else
                                <span class="text-red-500 font-bold">Not Approved</span>
                            @endif
                        </td>
                        @if($title === 'Not Confirm')
                        <td class="px-4 py-2 border text-center" id="confirm-status-{{ $sample->id }}">
                            @can('confirm sample progres')
                            <button class="px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600"
                                    onclick="confirmSample({{ $sample->id }})">
                                Confirm
                            </button>
                            @endcan
                        </td>
                        @endif
                        <td class="px-4 py-2 border text-center">
                            @can('view sample progres')
                            <a href="{{ route('sample-progress.show', $sample->id) }}"
                               class="px-2 py-1 bg-green-500 text-white rounded hover:bg-green-600">
                                Detail
                            </a>
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

<script src="{{ asset('Modal/sample_progres.js') }}" defer></script>

@push('scripts')
<script>
function confirmSample(id) {
    if (confirm('Yakin ingin mengonfirmasi permohonan ini?')) {
        fetch(`/sample-progress/${id}/confirm`, {
            method: 'PUT',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({})
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const row = document.getElementById(`confirm-status-${id}`);
                row.innerHTML = '<span class="text-green-600 font-bold">Confirmed</span>';
            } else {
                alert('Gagal mengubah status.');
            }
        })
        .catch(() => alert('Terjadi kesalahan saat menghubungi server.'));
    }
}
</script>
@endpush
