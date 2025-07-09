<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::all();

        activity()
            ->causedBy(Auth::user())
            ->tap(fn ($activity) => $activity->id_user = Auth::id())
            ->log('Mengakses halaman daftar Jabatan');

        return view('roles.index', compact('roles'));
    }

    public function create()
    {
        return view('roles.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:roles,name',
            'guard_name' => 'required|string',
        ]);

        $role = Role::create([
            'name' => $request->name,
            'guard_name' => $request->guard_name,
        ]);

        activity()
            ->causedBy(Auth::user())
            ->performedOn($role)
            ->tap(fn ($activity) => $activity->id_user = Auth::id())
            ->withProperties($request->all())
            ->log('Menambahkan Jabatan baru');

        return redirect()->route('roles.index')->with('success', 'Jabatan berhasil ditambahkan.');
    }
    public function edit($id)
{
    $role = Role::findOrFail($id);

    if (auth()->user()->hasRole('Direktur (DIR-OPS)') && $role->name === 'SUPER ADMIN') {
        abort(403, 'Anda tidak diizinkan mengedit jabatan SUPER ADMIN.');
    }

    return view('roles.edit', compact('role'));
}

public function update(Request $request, $id)
{
    $role = Role::findOrFail($id);

    if (auth()->user()->hasRole('Direktur (DIR-OPS)') && $role->name === 'SUPER ADMIN') {
        abort(403, 'Anda tidak diizinkan mengubah jabatan SUPER ADMIN.');
    }

    $request->validate([
        'name' => 'required|string|unique:roles,name,' . $id,
        'guard_name' => 'required|string',
    ]);

    $role->update([
        'name' => $request->name,
        'guard_name' => $request->guard_name,
    ]);

    activity()
        ->causedBy(Auth::user())
        ->performedOn($role)
        ->tap(fn ($activity) => $activity->id_user = Auth::id())
        ->withProperties($request->all())
        ->log('Memperbarui Jabatan');

    return redirect()->route('roles.index')->with('success', 'Jabatan berhasil diperbarui.');
}

public function destroy($id)
{
    $role = Role::findOrFail($id);

    if (auth()->user()->hasRole('Direktur (DIR-OPS)') && $role->name === 'SUPER ADMIN') {
        abort(403, 'Anda tidak diizinkan menghapus jabatan SUPER ADMIN.');
    }

    $role->delete();

    activity()
        ->causedBy(Auth::user())
        ->performedOn($role)
        ->tap(fn ($activity) => $activity->id_user = Auth::id())
        ->log('Menghapus Jabatan');

    return redirect()->route('roles.index')->with('success', 'Jabatan berhasil dihapus.');
}

}
