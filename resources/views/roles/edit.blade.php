@extends('layout.main')

@section('content')
<div class="w-full px-6 py-6 mx-auto mt-10">
    <div class="bg-white shadow-lg rounded-lg p-6">
        <h2 class="text-2xl font-bold mb-4">Edit Jabatan</h2>

        @if($errors->any())
        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form method="POST" action="{{ route('roles.update', $role->id) }}">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="name" class="block font-bold mb-1">Nama Jabatan</label>
                <input type="text" name="name" id="name" value="{{ $role->name }}"  class="w-full px-4 py-2 mt-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>

            <div class="mb-4">
                <label for="guard_name" class="block font-bold mb-1">Guard Name</label>
                <input type="text" name="guard_name" id="guard_name" value="{{ $role->guard_name }}"  class="w-full px-4 py-2 mt-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required readonly >
            </div>

            <div class="flex justify-end">
                <a href="{{ route('roles.index') }}" class="px-4 py-2 bg-gray-400 text-white rounded mr-2">Batal</a>
                <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded">Update</button>
            </div>
        </form>
    </div>
</div>
@endsection
