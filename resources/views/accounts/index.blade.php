@extends('layout.main')

@section('content')
<div class="w-full px-6 py-6 mx-auto mt-10">
    <div class="bg-white shadow-lg rounded-lg p-6">
        <h2 class="text-2xl font-bold mb-4">Daftar Akun</h2>

        {{-- Alert --}}
        @if(session('success'))
        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
            <span class="block sm:inline">{{ session('success') }}</span>
            <button type="button" class="absolute top-0 bottom-0 right-0 px-4 py-3" onclick="this.parentElement.style.display='none'">
                <svg class="fill-current h-6 w-6 text-green-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                    <title>Close</title>
                    <path d="M14.348 5.652a.5.5 0 00-.707 0L10 9.293 6.354 5.647a.5.5 0 10-.707.707L9.293 10l-3.646 3.646a.5.5 0 10.707.707L10 10.707l3.646 3.646a.5.5 0 10.707-.707L10.707 10l3.646-3.646a.5.5 0 000-.707z"/>
                </svg>
            </button>
        </div>
        @endif

        {{-- Tombol Tambah Data --}}
        <div class="mb-4">
            <a href="{{ route('accounts.create') }}" class="px-4 py-2 font-bold bg-blue-500 text-white rounded hover:bg-blue-600">
                Tambah Akun
            </a>
        </div>

        {{-- Tabel Data --}}
        <div class="overflow-x-auto mt-6">
            <table id="akun" class="min-w-full bg-white border-collapse border border-gray-300">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="px-4 py-2 border">No</th>
                        <th class="px-4 py-2 border">Username</th>
                        <!-- <th class="px-4 py-2 border">Email</th> -->
                        <th class="px-4 py-2 border">Role</th>
                        <th class="px-4 py-2 border">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $index => $user)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-2 border text-center">{{ $index + 1 }}</td>
                        <td class="px-4 py-2 border">{{ $user->username }}</td>
                        <!-- <td class="px-4 py-2 border">{{ $user->email }}</td> -->
                        <td class="px-4 py-2 border">{{ $user->getRoleNames()->join(', ') }}</td>
                        <td class="px-4 py-2 border whitespace-nowrap">
                            <a href="{{ route('accounts.edit', $user->id) }}" class="px-4 py-2 font-bold text-white rounded inline-flex items-center" style="background-color: #FF8C00;">
                                Edit
                            </a>
                             <form action="{{ route('accounts.destroy', $user->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus akun ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="px-4 py-2 font-bold text-white rounded inline-flex items-center" style="background-color: #ef4444;">
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
@endsection

<script src="{{ asset('Modal/akun.js') }}" defer></script>
