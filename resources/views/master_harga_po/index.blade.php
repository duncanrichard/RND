@extends('layouts.app')

@section('title', 'Master Harga PO')

@section('content')
<div class="container">
    <h1 class="text-2xl font-bold mb-4">Master Harga PO</h1>

    <!-- Tombol Tambah Data -->
    <button id="openAddModal" class="bg-blue-500 text-white px-4 py-2 rounded mb-4 inline-block">Tambah Harga PO</button>

    @if(session('success'))
        <div class="bg-green-500 text-white p-4 rounded mb-4">{{ session('success') }}</div>
    @endif

    <!-- Tabel dengan DataTables -->
    <div class="overflow-x-auto">
        <table id="hargaPOTable" class="min-w-full bg-white border-collapse">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">No</th>
                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Harga</th>
                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $index => $item)
                <tr class="border-b">
                    <td class="px-6 py-4">{{ $index + 1 }}</td>
                    <td class="px-6 py-4">{{ number_format($item->harga, 2) }}</td>
                    <td class="px-6 py-4">
                        <button 
                            class="bg-yellow-500 text-white px-2 py-1 rounded editBtn"
                            data-id="{{ $item->id }}"
                            data-harga="{{ $item->harga }}"
                        >Edit</button>
                        <form action="{{ route('master_harga_po.destroy', $item->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 text-white px-2 py-1 rounded">Hapus</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Modal -->
<div id="modal" class="fixed inset-0 bg-gray-900 bg-opacity-50 hidden z-50 flex items-center justify-center">
    <div class="bg-white rounded-lg shadow-lg w-1/3 p-6">
        <h2 id="modalTitle" class="text-xl font-bold mb-4">Tambah Harga PO</h2>
        <form id="modalForm" action="{{ route('master_harga_po.store') }}" method="POST">
            @csrf
            <input type="hidden" id="idField" name="id">
            <div id="methodField"></div> <!-- Tempat untuk menambahkan metode PUT -->
            <div class="mb-4">
                <label for="harga" class="block text-gray-700">Harga</label>
                <input type="number" step="0.01" id="hargaField" name="harga" class="w-full border rounded px-3 py-2" required>
            </div>
            <div class="flex justify-end">
                <button type="button" id="closeModal" class="bg-gray-500 text-white px-4 py-2 rounded mr-2">Batal</button>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Simpan</button>
            </div>
        </form>
    </div>
</div>


<!-- Tambahkan DataTables -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

<script>
   $(document).ready(function() {
    // Modal
    const modal = $('#modal');
    const modalForm = $('#modalForm');
    const idField = $('#idField');
    const hargaField = $('#hargaField');
    const modalTitle = $('#modalTitle');
    const methodField = $('#methodField');

    // Buka modal untuk tambah
    $('#openAddModal').on('click', function() {
        modalTitle.text('Tambah Harga PO');
        modalForm.attr('action', '{{ route('master_harga_po.store') }}');
        methodField.html(''); // Tidak perlu method PUT untuk tambah
        idField.val('');
        hargaField.val('');
        modal.removeClass('hidden');
    });

    // Buka modal untuk edit
    $('.editBtn').on('click', function() {
        const id = $(this).data('id');
        const harga = $(this).data('harga');

        modalTitle.text('Edit Harga PO');
        modalForm.attr('action', '{{ route('master_harga_po.update', '') }}/' + id);
        methodField.html('@method("PUT")'); // Tambahkan method PUT
        idField.val(id);
        hargaField.val(harga);
        modal.removeClass('hidden');
    });

    // Tutup modal
    $('#closeModal').on('click', function() {
        modal.addClass('hidden');
    });
});

    
</script>
@endsection
