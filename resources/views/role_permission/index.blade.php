@extends('layout.main')

@section('content')
<div class="w-full px-6 py-6 mx-auto mt-10">
    <div class="bg-white shadow-lg rounded-lg p-6">
        <h2 class="text-2xl font-bold mb-4">Manajemen Hak Akses</h2>

        {{-- Notifikasi --}}
        @if(session('success'))
        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
        @endif

        {{-- Pilih Role --}}
        <form method="GET" action="{{ route('role-permission.index') }}" class="mb-6">
            <label for="role_id" class="block text-sm font-medium text-gray-700 mb-1">Pilih Role</label>
            <select name="role_id" id="role_id" onchange="this.form.submit()" class="w-full rounded border-gray-300">
                <option disabled selected>-- Pilih Role --</option>
                @foreach ($roles as $role)
                <option value="{{ $role->id }}" {{ request('role_id') == $role->id ? 'selected' : '' }}>
                    {{ $role->name }}
                </option>
                @endforeach
            </select>
        </form>

       @if($selectedRole)
<form action="{{ route('role-permission.assign') }}" method="POST">
    @csrf
    <input type="hidden" name="role_id" value="{{ $selectedRole->id }}">

    <h3 class="text-lg font-semibold mb-4">Hak Akses untuk: <span class="text-indigo-600">{{ $selectedRole->name }}</span></h3>

    <div class="space-y-4">
        @foreach ($groupedPermissions as $group => $perms)
        <div class="border rounded shadow-sm">
            <button type="button" onclick="togglePanel('{{ $group }}')" class="w-full flex justify-between items-center px-4 py-2 bg-gray-100 hover:bg-gray-200">
                <span class="font-semibold">{{ $group }}</span>
                <span class="text-sm text-gray-500">▼</span>
            </button>
            <div id="panel-{{ $group }}" class="hidden px-4 py-2 space-y-2">
                @foreach ($perms as $permission)
                <label class="flex items-center space-x-2">
                    <input type="checkbox" name="permissions[]" value="{{ $permission->name }}"
                           class="form-checkbox h-4 w-4 text-indigo-600"
                           {{ in_array($permission->name, $rolePermissions) ? 'checked' : '' }}>
                    <span class="text-sm">{{ $permission->name }}</span>
                </label>
                @endforeach
            </div>
        </div>
        @endforeach
    </div>

    <div class="text-right mt-6">
        <button type="submit" class="px-4 py-2 font-bold bg-blue-500 text-white rounded hover:bg-blue-600">
            Simpan
        </button>
    </div>
</form>
@endif

    </div>
</div>

<script>
    function togglePanel(id) {
        const panel = document.getElementById('panel-' + id);
        if (panel) {
            panel.classList.toggle('hidden');
        }
    }
</script>
@endsection
