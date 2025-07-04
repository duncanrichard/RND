@extends('layout.main')
@section('content')
<div class="w-full px-6 py-6 mx-auto mt-10">
    <div class="bg-white shadow-lg rounded-lg p-6">
        <h2 class="text-2xl font-bold mb-4">Data warehouse</h2>
        <li class="relative flex items-center justify-center pr-2">
            <p class="hidden transform-dropdown-show"></p>
            <a href="javascript:;" class="px-4 py-2 font-bold bg-blue-500 text-white rounded inline-flex items-right ml-auto" dropdown-trigger aria-expanded="false">
                <i class="cursor-pointer"></i> Tambah Data
            </a>
            <ul dropdown-menu class="text-sm transform-dropdown before:font-awesome before:leading-default before:duration-350
                before:ease lg:shadow-3xl duration-250 min-w-64 before:sm:right-8 before:text-5.5 pointer-events-none
                absolute right-0 top-0 z-50 origin-top list-none rounded-lg border-0 border-solid border-transparent
                dark:shadow-dark-xl dark:bg-slate-850 bg-skyblue-500 bg-clip-padding px-2 py-4 text-left text-slate-500
                opacity-0 transition-all before:absolute before:right-2 before:left-auto before:top-0 before:z-50
                before:inline-block before:font-normal before:text-white before:antialiased before:transition-all
                before:content-['\f0d8'] sm:-mr-6 lg:absolute lg:right-auto lg:left-auto lg:mt-2 lg:block lg:cursor-pointer"
                style="left: 50%; transform: translateX(-50%); min-width: 400px; margin-top: 50px";>
                <li class="relative mb-2">
                    <form action="{{ route('warehouse.store') }}" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <label for="kode_warehouse" class="block font-bold text-sm font-medium text-white">Kode Warehouse</label>
                            <input type="text" id="kode_warehouse" name="kode_warehouse" class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                        </div>
                        <br>  
                        <div>
                            <label for="warehouse" class="block font-bold text-sm font-medium text-white">Nama Warehouse</label>
                            <input type="text" id="warehouse" name="warehouse" class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                        </div>
                        <br>
                        <div>
                            <button type="submit" class="w-full font-bold px-4 py-2 text-white rounded-lg" style="background-color: #032859;">Simpan Data</button>
                        </div>
                    </form>
                </li>
            </ul>
        </li>
        <br>
        <form action="{{ route('warehouse.import') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="file" name="file" required class="border border-gray-200 rounded p-1 w-48">
            <br><br>
            <button type="submit" class="px-4 py-2 font-bold bg-blue-500 text-white rounded inline-flex items-center" style="background-color: #FF8C00;">Import Excel</button>
            <a href="{{ route('warehouse.export') }}" class="px-4 py-2 font-bold bg-blue-500 text-white rounded inline-flex items-center" style="background-color: #008000;">Unduh Excel</a>
            <a href="{{ route('warehouse.print') }}" class="px-4 py-2 font-bold bg-blue-500 text-white rounded inline-flex items-center" style="background-color: #ef4444;">Unduh PDF</a>
        </form>
        <div class="overflow-x-auto mt-6">
            <table id="warehouse_table" class="display nowrap" style="width:100%">
                <thead>
                    <tr>
                        <th class="px-1 py-1">No</th>
                        <th class="px-1 py-1">Kode Warehouse</th>
                        <th class="px-1 py-1">Warehouse</th>
                        <th class="px-1 py-1">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $key => $item)
                    <tr class="w-full border-b hover:bg-gray-100">
                        <td class="px-1 py-1">{{ $key+1 }}</td>
                        <td class="px-1 py-1">{{ $item->kode_warehouse }}</td>
                        <td class="px-1 py-1">{{ $item->warehouse }}</td>
                        <td class="px-1 py-1">
                            <div class="flex items-center">
                                <a href="javascript:;" class="px-4 py-2 font-bold text-white rounded inline-flex items-center mr-2" style="background-color: #FF8C00;" 
                                onclick="openDropdown({{ $item->id }}, '{{ $item->kode_warehouse }}', '{{ $item->warehouse }}')">
                                    <i class="cursor-pointer"></i> Edit
                                </a>
                                <form action="{{ route('warehouse.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-4 py-2 font-bold text-white rounded inline-flex items-center" style="background-color: #ef4444;">
                                        <i class="cursor-pointer"></i> Hapus
                                    </button>
                                </form>

                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div id="dropdown-form" class="inset-0 flex items-center justify-center z-50 hidden">
            <div class="relative bg-skyblue-500 rounded-lg shadow-lg p-8 w-full max-w-md transform transition-all duration-300" style="width: 50%; height: auto; transform: translateY(-400px);">
                <button onclick="closeDropdown()" class="absolute top-0 right-0 m-4 text-white text-xl font-bold z-50">
                    &times;
                </button>
                <form action="" method="POST" id="edit-form" class="space-y-4 pt-12">
                    @csrf
                    @method('PUT')
                        <div>
                        <label for="kode_warehouse" class="block font-bold text-sm font-medium text-white">Kode Warehouse</label>
                            <input type="text" id="kode_warehouse" name="kode_warehouse" class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                        </div>
                        <br>  
                        <div>
                            <label for="warehouse" class="block font-bold text-sm font-medium text-white">Nama Warehouse</label>
                            <input type="text" id="warehouse" name="warehouse" class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                        </div>
                        <br>
                        <div>
                            <button type="submit" class="w-full font-bold px-4 py-2 text-white rounded-lg" style="background-color: #032859;">Simpan Data</button>
                        </div>
                    <br>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('Modal/warehouse.js') }}" defer></script>
<script>
    function openDropdown(itemId, kode_warehouse, warehouse) {
        const form = document.getElementById('edit-form');
        form.action = `{{ route('warehouse.update', ':id') }}`.replace(':id', itemId);

        document.getElementById('kode_warehouse').value = kode_warehouse;
        document.getElementById('warehouse').value = warehouse;

        document.getElementById('dropdown-form').classList.remove('hidden');
    }

    function closeDropdown() {
        document.getElementById('dropdown-form').classList.add('hidden');
    }
</script>
@endsection
