@extends('layout.main')

@section('content')
<div class="w-full px-6 py-6 mx-auto mt-10">
    <div class="bg-white shadow-lg rounded-lg p-6">
        <h2 class="text-2xl font-bold mb-4">Daftar Jabatan</h2>

        @if(session('success'))
        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
        @endif

<div class="flex justify-end mb-4">
    <a href="{{ route('roles.create') }}" class="px-4 py-2 font-bold bg-blue-500 text-white rounded inline-flex items-right ml-auto">
        Tambah Jabatan
    </a>
</div>


        <div class="overflow-x-auto">
            <table id="jabatan_table" class="display nowrap w-full">
               <thead>
    <tr>
        <th class="text-center">No</th>
        <th class="text-center">Nama Jabatan</th>
        <th class="text-center">Guard Name</th>
        <th class="text-center">Dibuat</th>
        <th class="text-center">Diperbarui</th>
        <th class="text-center">Aksi</th>
    </tr>
</thead>
<tbody>
    @foreach($roles as $role)
        <tr class="hover:bg-gray-100 border-b">
            <td >{{ $loop->iteration }}</td>
            <td >{{ $role->name }}</td>
            <td >{{ $role->guard_name }}</td>
            <td >{{ $role->created_at }}</td>
            <td >{{ $role->updated_at }}</td>
            <td >
                @php
                    $isSuperAdmin = $role->name === 'SUPER ADMIN';
                    $isDirOps = auth()->user()->hasRole('Direktur (DIR-OPS)');
                @endphp

                <div class="flex justify-center space-x-2">
                    @if(!($isDirOps && $isSuperAdmin))
                        <a href="{{ route('roles.edit', $role->id) }}" class="px-4 py-2 font-bold text-white rounded inline-flex items-center" 
                                  style="background-color: #FF8C00;">
                            Edit
                        </a>

                        <form action="{{ route('roles.destroy', $role->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus jabatan ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-4 py-2 font-bold text-white rounded inline-flex items-center" style="background-color: #ef4444;">
                                Hapus
                            </button>
                        </form>
                    @else
                        <span class="text-gray-400 italic">Tidak Diizinkan</span>
                    @endif
                </div>
            </td>
        </tr>
    @endforeach
</tbody>

            </table>
        </div>
    </div>
</div>
<script src="{{ asset('Modal/jabatan.js') }}" defer></script>
@endsection
