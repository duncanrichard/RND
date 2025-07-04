<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Str;

class RolePermissionController extends Controller
{
    /**
     * Menampilkan halaman pengaturan hak akses role.
     */
    public function index(Request $request)
    {
        $roles = Role::all();
        $permissions = Permission::all();
        $selectedRole = null;
        $rolePermissions = [];

        if ($request->filled('role_id')) {
            $selectedRole = Role::find($request->role_id);

            if ($selectedRole) {
                $rolePermissions = $selectedRole->permissions->pluck('name')->toArray();
            }
        }

        // Kelompokkan permission berdasarkan modul (match berdasarkan keyword)
        $groupedPermissions = $permissions->groupBy(function ($permission) {
            $name = Str::lower($permission->name);

            return match (true) {
                Str::contains($name, 'dashboard') => 'Dashboard',
                Str::contains($name, ['satuan']) => 'Master Satuan',
                Str::contains($name, ['bahan baku sample']) => 'Master List Sample Bahan Baku',
                Str::contains($name, ['harga sample bahan baku']) => 'Master Harga Sample Bahan Baku',
                Str::contains($name, ['formula sample']) => 'Master Formula Sample',
                Str::contains($name, ['ppn']) => 'Master PPN',
                Str::contains($name, ['kategori bahan baku']) => 'Master Kategori Bahan Baku', 
                Str::contains($name, ['bahan baku']) => 'Master Bahan Baku',
                Str::contains($name, ['formula produk jadi']) => 'Master Formula Produk Jadi',
                Str::contains($name, ['permintaan']) => 'Permintaan',
                Str::contains($name, ['pengembalian']) => 'Pengembalian',
                Str::contains($name, ['purchase request']) => 'Purchase Request',
                Str::contains($name, ['stabilitas']) => 'Master Data Stabilitas RND',
                Str::contains($name, ['kategori bahan kemas']) => 'Master Kategori Bahan Kemas',
                Str::contains($name, ['bahan kemas']) => 'Master Bahan Kemas',
                Str::contains($name, ['kategori produk']) => 'Master Kategori Produk Jadi',
                Str::contains($name, 'produk jadi') => 'Master Produk Jadi',
                Str::contains($name, ['ckb']) => 'Master CKB',
                Str::contains($name, ['cpb']) => 'Master CPB',
                Str::contains($name, ['sample progres']) => 'Sample Progress',
                Str::contains($name, 'singkatan merk') => 'Master Singkatan Merk',
                Str::contains($name, ['purchase request']) => 'Purchase Request',


                default => 'Lainnya',
            };
        });

        return view('role_permission.index', compact(
            'roles',
            'groupedPermissions',
            'selectedRole',
            'rolePermissions'
        ));
    }

    /**
     * Simpan perubahan hak akses role.
     */
    public function assign(Request $request)
    {
        $validated = $request->validate([
            'role_id' => 'required|exists:roles,id',
            'permissions' => 'nullable|array',
            'permissions.*' => 'string|exists:permissions,name',
        ]);

        $role = Role::findOrFail($validated['role_id']);

        // Sinkronisasi permission role
        $role->syncPermissions($validated['permissions'] ?? []);

        return redirect()
            ->route('role-permission.index', ['role_id' => $role->id])
            ->with('success', 'Hak akses berhasil diperbarui.');
    }
}
