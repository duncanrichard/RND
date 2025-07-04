@extends('layout.main')

@section('content')
<div class="w-full px-6 py-6 mx-auto mt-10">
    <div class="bg-white shadow-xl rounded-lg p-6 max-w-lg mx-auto">
        <div class="flex justify-between items-center mb-6 border-b pb-2">
            <h2 class="text-2xl font-bold text-gray-800">Tambah Akun</h2>
        </div>

        {{-- Alert Global Error --}}
        @if ($errors->has('password'))
            <div class="mb-4">
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                    <span class="block text-sm">{{ $errors->first('password') }}</span>
                </div>
            </div>
        @endif

        <form action="{{ route('accounts.store') }}" method="POST" class="space-y-5">
            @csrf

            {{-- Username --}}
            <div>
                <label class="block text-sm font-medium text-gray-700">Username</label>
                <input type="text" name="username" value="{{ old('username') }}"
                    class="w-full mt-1 border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 {{ $errors->has('username') ? 'border-red-500' : '' }}"
                    required>
                @error('username')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Email --}}
            <div>
                <label class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" name="email" value="{{ old('email') }}"
                    class="w-full mt-1 border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 {{ $errors->has('email') ? 'border-red-500' : '' }}"
                    required>
                @error('email')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Password --}}
            <div>
                <label class="block text-sm font-medium text-gray-700">Password</label>
                <input type="password" name="password"
                    class="w-full mt-1 border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 {{ $errors->has('password') ? 'border-red-500' : '' }}"
                    required>
                @error('password')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Konfirmasi Password --}}
            <div>
                <label class="block text-sm font-medium text-gray-700">Konfirmasi Password</label>
                <input type="password" name="password_confirmation"
                    class="w-full mt-1 border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 {{ $errors->has('password_confirmation') ? 'border-red-500' : '' }}"
                    required>
                @error('password_confirmation')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Role --}}
            <div>
                <label class="block text-sm font-medium text-gray-700">Role</label>
                <select name="role"
                    class="w-full mt-1 border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 {{ $errors->has('role') ? 'border-red-500' : '' }}"
                    required>
                    <option value="">-- Pilih Role --</option>
                    @foreach($roles as $role)
                        <option value="{{ $role->name }}" {{ old('role') == $role->name ? 'selected' : '' }}>
                            {{ strtoupper($role->name) }}
                        </option>
                    @endforeach
                </select>
                @error('role')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Tombol Aksi --}}

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
