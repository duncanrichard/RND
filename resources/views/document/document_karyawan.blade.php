@extends('layout.main')
@section('content')
<div class="w-full px-6 py-6 mx-auto mt-10">
    <div class="bg-white shadow-lg rounded-lg p-6">
        <h2 class="text-2xl font-bold mb-4">Data Karyawan</h2>
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
                    <form action="{{ route('karyawan.store') }}" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <label for="jenis" class="block font-bold text-sm font-medium text-white">Jenis</label>
                            <input type="text" id="jenis" name="jenis" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                        </div>
                        <br>  
                        <div>
                            <label for="golongan_tindakan" class="block font-bold text-sm font-medium text-white">Golongan Tindakan</label>
                            <input type="text" id="golongan_tindakan" name="golongan_tindakan" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                        </div>
                        <br>
                        <div>
                            <label for="nama_tindakan" class="block font-bold text-sm font-medium text-white">Nama Tindakan</label>
                            <input type="text" id="nama_tindakan" name="nama_tindakan" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                        </div>
                        <br>
                        <div>
                            <label for="kode_tindakan" class="block font-bold text-sm font-medium text-white">Kode Tindakan</label>
                            <input type="text" id="kode_tindakan" name="kode_tindakan" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                        </div>
                        <br>
                        <div>
                            <button type="submit" class="w-full font-bold px-4 py-2 text-white rounded-md" style="background-color: #032859;">Simpan Data</button>
                        </div>
                    </form>
                </li>
            </ul>
        </li>
        <br>
        <form action="{{ route('karyawan.import') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="file" name="file" required class="border border-gray-200 rounded p-1 w-48">
            <br><br>
            <button type="submit" class="px-4 py-2 font-bold bg-blue-500 text-white rounded inline-flex items-center" style="background-color: #FF8C00;">Import Excel</button>
            <a href="{{ route('karyawan.export') }}" class="px-4 py-2 font-bold bg-blue-500 text-white rounded inline-flex items-center" style="background-color: #008000;">Unduh Excel</a>
            <a href="{{ route('karyawan.print') }}" class="px-4 py-2 font-bold bg-blue-500 text-white rounded inline-flex items-center" style="background-color: #ef4444;">Unduh PDF</a>
        </form>
        <div class="overflow-x-auto mt-6">
            <table id="karyawan" class="display nowrap" style="width:100%">
                <thead>
                    <tr>
                        <th class="px-1 py-1">No</th>
                        <th class="px-1 py-1">Nama</th>
                        <th class="px-1 py-1">No Karyawan</th>
                        <th class="px-1 py-1">Agama</th>
                        <th class="px-1 py-1">Kewarganegaraan</th>
                        <th class="px-1 py-1">Golongan Darah</th>
                        <th class="px-1 py-1">Jenis Kelamin</th>
                        <th class="px-1 py-1">No WA</th>
                        <th class="px-1 py-1">NIK</th>
                        <th class="px-1 py-1">Email</th>
                        <th class="px-1 py-1">Tempat Lahir</th>
                        <th class="px-1 py-1">Tanggal Lahir</th>
                        <th class="px-1 py-1">Status Martial</th>

                        <!-- Data Domisili -->
                        <th class="px-1 py-1">Domisili Kota</th>
                        <th class="px-1 py-1">Domisili Kecamatan</th>
                        <th class="px-1 py-1">Domisili Kelurahan</th>
                        <th class="px-1 py-1">Domisili Alamat</th>
                        <th class="px-1 py-1">Tinggal Kota</th>
                        <th class="px-1 py-1">Tinggal Kecamatan</th>
                        <th class="px-1 py-1">Tinggal Alamat</th>
                        <th class="px-1 py-1">Office ID</th>
                        <th class="px-1 py-1">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $key => $item)
                    <tr class="w-full border-b hover:bg-gray-100">
                        <td class="px-1 py-1">{{ $key+1 }}</td>
                        <td class="px-1 py-1">{{ $item->nama }}</td>
                        <td class="px-1 py-1">{{ $item->no_karyawan }}</td>
                        <td class="px-1 py-1">{{ $item->agama }}</td>
                        <td class="px-1 py-1">{{ $item->kewarganegaraan }}</td>
                        <td class="px-1 py-1">{{ $item->golongan_darah }}</td>
                        <td class="px-1 py-1">{{ $item->jenis_kelamin }}</td>
                        <td class="px-1 py-1">{{ $item->no_wa }}</td>
                        <td class="px-1 py-1">{{ $item->nik }}</td>
                        <td class="px-1 py-1">{{ $item->email }}</td>
                        <td class="px-1 py-1">{{ $item->tempat_lahir }}</td>
                        <td class="px-1 py-1">{{ $item->tgl_lahir }}</td>
                        <td class="px-1 py-1">{{ $item->status_martial }}</td>

                        <!-- Data Domisili -->
                        <td class="px-1 py-1">{{ $item->domisili_kota }}</td>
                        <td class="px-1 py-1">{{ $item->domisili_kecamatan }}</td>
                        <td class="px-1 py-1">{{ $item->domisili_kelurahan }}</td>
                        <td class="px-1 py-1">{{ $item->domisili_alamat }}</td>
                        <td class="px-1 py-1">{{ $item->tinggal_kota }}</td>
                        <td class="px-1 py-1">{{ $item->tinggal_kecamatan }}</td>
                        <td class="px-1 py-1">{{ $item->tinggal_alamat }}</td>

                        <td class="px-1 py-1">{{ $item->office_id }}</td>
                        <td class="px-1 py-1">
                            <div class="flex items-center">
                                <a href="{{ route('karyawan.detail', $item->id) }}" class="px-4 py-2 font-bold text-white rounded inline-flex items-center mr-2" style="background-color: #3b82f6;">
                                    <i class="cursor-pointer"></i> Detail
                                </a>
                                <a href="{{ route('karyawan.edit', $item->id) }}" class="px-4 py-2 font-bold text-white rounded inline-flex items-center mr-2" style="background-color: #f59e0b;">
                                    <i class="cursor-pointer"></i> Edit
                                </a>
                                <form action="{{ route('karyawan.destroy', $item->id) }}" method="POST" class="inline-flex items-center">
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
    </div>
</div>

<script src="{{ asset('Modal/karyawan.js') }}" defer></script>
@endsection
