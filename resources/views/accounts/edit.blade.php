@extends('layout.main')

@section('content')
<div class="w-full px-6 py-6 mx-auto mt-10">
    <div class="bg-white shadow-lg rounded-lg p-6 max-w-lg mx-auto">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-2xl font-bold">Edit Akun</h2>
           
        </div>

        {{-- Tampilkan error validasi --}}
        @if ($errors->any())
            <div class="mb-4">
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                    <ul class="list-disc pl-5 text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <form action="{{ route('accounts.update', $user->id) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-medium text-gray-700">Username</label>
                <input type="text" name="username" value="{{ old('username', $user->username) }}" class="w-full mt-1 border rounded px-3 py-2 focus:ring-2 focus:ring-blue-500" required>
            </div>

           <!--  <div>
                <label class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" class="w-full mt-1 border rounded px-3 py-2 focus:ring-2 focus:ring-blue-500" required>
            </div> -->

            <div>
                <label class="block text-sm font-medium text-gray-700">Password <span class="text-sm text-gray-500">(Kosongkan jika tidak diubah)</span></label>
                <input type="password" name="password" class="w-full mt-1 border rounded px-3 py-2 focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" class="w-full mt-1 border rounded px-3 py-2 focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Role</label>
                <select name="role" class="w-full mt-1 border rounded px-3 py-2 focus:ring-2 focus:ring-blue-500" required>
                    @foreach($roles as $role)
                        <option value="{{ $role->name }}" {{ $user->roles->first()?->name == $role->name ? 'selected' : '' }}>
                            {{ strtoupper($role->name) }}
                        </option>
                    @endforeach
                </select>
            </div>

<br>
           <div>
                <button type="submit" class="w-full font-bold px-4 py-2 text-white rounded-lg" style="background-color: #032859;">
                    Simpan
                </button>
                <a href="{{ route('accounts.index') }}" 
   class="w-full font-bold px-4 py-2 text-white rounded-lg bg-gray-500 hover:bg-gray-600 mt-2 inline-block text-center" 
   style="background-color: #032859;">
    Batal
</a>

            </div>
        </form>
    </div>
</div>
@endsection
