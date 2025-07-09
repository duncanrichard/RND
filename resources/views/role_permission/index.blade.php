@extends('layout.main')

@section('content')
<div class="w-full px-6 py-6 mx-auto mt-10">
    <div class="bg-white shadow-xl rounded-xl p-6 border border-gray-200">
        <h2 class="text-3xl font-bold text-gray-800 mb-6">🔐 Manajemen Hak Akses</h2>

        {{-- Notifikasi --}}
        @if(session('success'))
        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
        @endif

        {{-- Pilih Role --}}
        <form method="GET" action="{{ route('role-permission.index') }}" class="mb-6">
            <label for="role_id" class="block text-sm font-medium text-gray-700 mb-1">Pilih Role</label>
            <select name="role_id" id="role_id" class="w-full border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200">
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

            <div class="flex items-center justify-between mb-4">
                <h3 class="text-xl font-semibold text-gray-800">
                    Hak Akses untuk: <span class="text-indigo-600">{{ $selectedRole->name }}</span>
                </h3>
            </div>

            <div class="space-y-5">
                @foreach ($groupedPermissions as $group => $perms)
                <div class="border border-gray-200 rounded-lg shadow-sm overflow-hidden">
                    <button type="button"
                            onclick="togglePanel('{{ $group }}')"
                            class="w-full flex justify-between items-center px-5 py-3 bg-gray-100 hover:bg-gray-200 transition">
                        <span class="font-semibold text-gray-700 capitalize">{{ str_replace('_', ' ', $group) }}</span>
                        <svg id="icon-{{ $group }}" class="w-5 h-5 transform transition-transform duration-200" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <div id="panel-{{ $group }}" class="hidden px-5 py-4 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 bg-white">
                        @foreach ($perms as $permission)
                        <label class="flex items-center space-x-3">
                            <input type="checkbox" name="permissions[]" value="{{ $permission->name }}"
                                   class="form-checkbox h-5 w-5 text-indigo-600 transition duration-150 ease-in-out"
                                   {{ in_array($permission->name, $rolePermissions) ? 'checked' : '' }}>
                            <span class="text-sm text-gray-700">{{ $permission->name }}</span>
                        </label>
                        @endforeach
                    </div>
                </div>
                @endforeach
            </div>

            <div class="text-right mt-8">
                <button type="submit" class="w-full font-bold px-4 py-2 text-white rounded-lg bg-gray-500 hover:bg-gray-600 mt-2 inline-block text-center" style="background-color: #032859;">
                    💾 Simpan Perubahan
                </button>
            </div>
        </form>
        @endif
    </div>
</div>
@endsection

@push('styles')
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
<style>
/* Styling Select2 agar mirip Tailwind input */
.select2-container--default .select2-selection--single {
    height: 2.75rem; /* h-11 */
    border-radius: 0.5rem; /* rounded-lg */
    padding: 0.5rem 0.75rem;
    border: 1px solid #d1d5db; /* border-gray-300 */
    font-size: 0.875rem; /* text-sm */
    display: flex;
    align-items: center;
}

.select2-container--default .select2-selection--single .select2-selection__arrow {
    height: 2.75rem;
    right: 0.75rem;
}

.select2-container--default .select2-selection--single .select2-selection__rendered {
    line-height: 1.5rem;
    color: #374151; /* text-gray-700 */
}
</style>
@endpush

@push('scripts')
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<script>
    // Toggle panel accordion
    function togglePanel(id) {
        const panel = document.getElementById('panel-' + id);
        const icon = document.getElementById('icon-' + id);
        if (panel && icon) {
            panel.classList.toggle('hidden');
            icon.classList.toggle('rotate-180');
        }
    }

    // Init Select2
    $(document).ready(function () {
        $('#role_id').select2({
            placeholder: "-- Pilih Role --",
            allowClear: true,
            width: '100%'
        }).on('change', function () {
            this.form.submit();
        });
    });
</script>
@endpush
