@extends('layout.main')

@section('content')
<div class="w-full px-6 py-6 mx-auto mt-10">
    <div class="bg-white shadow-lg rounded-lg p-6">
        <h2 class="text-2xl font-bold mb-4">Daftar Purchase Request</h2>

        @can('create purchase request')
        <a href="{{ route('purchase-requests.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded-lg mb-4 inline-block">
            Buat Purchase Request
        </a>
        @endcan

        <table id="Purchase_Request" class="min-w-full bg-white border border-gray-300 rounded-lg">
            <thead class="bg-gray-200 text-gray-700">
                <tr>
                    <th class="py-2 px-4 text-left border-b">No</th>
                    <th class="py-2 px-4 text-left border-b">No Purchase Request</th>
                    <th class="py-2 px-4 text-left border-b">Tanggal Request</th>
                    <th class="py-2 px-4 text-left border-b">Departemen</th>
                    <th class="py-2 px-4 text-left border-b">Status</th>
                    <th class="py-2 px-4 text-left border-b">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($purchaseRequests as $key => $request)
                <tr class="hover:bg-gray-50">
                    <td class="py-2 px-4 border-b">{{ $key + 1 }}</td>
                    <td class="py-2 px-4 border-b">{{ $request->no_purchase_request }}</td>
                    <td class="py-2 px-4 border-b">{{ $request->tanggal }}</td>
                    <td class="py-2 px-4 border-b">{{ $request->departemen }}</td>
                    <td class="py-2 px-4 border-b">
                        @if($request->status_request == 0)
                            <span class="bg-red-500 text-white px-3 py-1 rounded text-sm">Belum Approval</span>
                        @else
                            <span class="bg-green-500 text-white px-3 py-1 rounded text-sm">Approval</span>
                        @endif
                    </td>
                    <td class="py-2 px-4 border-b space-x-1">
                        @can('view purchase request')
                        <a href="{{ route('purchase-requests.show', $request->id) }}" class="px-3 py-1 text-white bg-blue-500 rounded hover:bg-blue-600 text-sm">Lihat</a>
                        @endcan

                        @can('edit purchase request')
                        @if($request->status_request == 0)
                        <a href="{{ route('purchase-requests.edit', $request->id) }}" class="px-3 py-1 text-white bg-yellow-500 rounded hover:bg-yellow-600 text-sm">Edit</a>
                        @endif
                        @endcan

                        @can('delete purchase request')
                        <form action="{{ route('purchase-requests.destroy', $request->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-3 py-1 text-white bg-red-500 rounded hover:bg-red-600 text-sm">Hapus</button>
                        </form>
                        @endcan
                    </td>
                </tr>
                @empty
                
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

<script src="{{ asset('Modal/Purchase_Request.js') }}" defer></script>
