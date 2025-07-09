<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class RolePermissionController extends Controller
{
    /**
     * Menampilkan halaman pengaturan hak akses role.
     */
    public function index(Request $request)
    {
        $user = auth()->user();

        activity()
            ->causedBy($user)
            ->tap(fn ($activity) => $activity->id_user = $user->id)
            ->log('Mengakses halaman Role Permission');

        if ($user->hasRole('SUPER ADMIN')) {
            $roles = Role::all();
            activity()->causedBy($user)->tap(fn ($activity) => $activity->id_user = $user->id)->log('Menampilkan semua role (SUPER ADMIN)');
        } else {
            $roles = Role::where('name', '!=', 'SUPER ADMIN')->get();
            activity()->causedBy($user)->log('Menampilkan role tanpa SUPER ADMIN');
        }

        $permissions = Permission::all();
        $selectedRole = null;
        $rolePermissions = [];

        if ($request->filled('role_id')) {
            $selectedRole = Role::find($request->role_id);

            activity()
                ->causedBy($user)
                ->tap(fn ($activity) => $activity->id_user = $user->id)
                ->withProperties(['role_id' => $request->role_id])
                ->log('Memilih role untuk pengaturan permission');

            if ($selectedRole) {
                if (!$user->hasRole('SUPER ADMIN') && $selectedRole->name === 'SUPER ADMIN') {
                    activity()
                        ->causedBy($user)
                        ->tap(fn ($activity) => $activity->id_user = $user->id)
                        ->log('DITOLAK: mencoba mengakses role SUPER ADMIN');
                    abort(403, 'Anda tidak memiliki akses untuk mengatur hak akses Super Admin.');
                }

                $rolePermissions = $selectedRole->permissions->pluck('name')->toArray();

                activity()
                    ->causedBy($user)
                    ->tap(fn ($activity) => $activity->id_user = $user->id)
                    ->performedOn($selectedRole)
                    ->withProperties(['permissions' => $rolePermissions])
                    ->log('Menampilkan permission yang dimiliki role');
            }
        }

       $groupedPermissions = $permissions->groupBy(function ($permission) {
    $name = Str::lower($permission->name);

    if (Str::contains($name, 'bahan baku sample')) {
        return 'Master List Sample Bahan Baku';
    }

    if (Str::contains($name, 'master bahan baku') && !Str::contains($name, 'sample')) {
        return 'Master Bahan Baku';
    }

    return match (true) {
        Str::contains($name, 'dashboard') => 'Dashboard',
        Str::contains($name, 'satuan') => 'Master Satuan',
        Str::contains($name, 'harga sample bahan baku') => 'Master Harga Sample Bahan Baku',
        Str::contains($name, 'formula sample') => 'Master Formula Sample',
        Str::contains($name, 'ppn') => 'Master PPN',
        Str::contains($name, 'kategori bahan baku') => 'Master Kategori Bahan Baku',
        Str::contains($name, 'formula produk jadi') => 'Master Formula Produk Jadi',
        Str::contains($name, 'permintaan') => 'Permintaan',
        Str::contains($name, 'pengembalian') => 'Pengembalian',
        Str::contains($name, 'purchase request') => 'Purchase Request',
        Str::contains($name, 'stabilitas') => 'Master Data Stabilitas RND',
        Str::contains($name, 'kategori bahan kemas') => 'Master Kategori Bahan Kemas',
        Str::contains($name, 'bahan kemas') => 'Master Bahan Kemas',
        Str::contains($name, 'kategori produk') => 'Master Kategori Produk Jadi',
        Str::contains($name, 'produk jadi') => 'Master Produk Jadi',
        Str::contains($name, 'ckb') => 'Master CKB',
        Str::contains($name, 'cpb') => 'Master CPB',
        Str::contains($name, 'sample progres') => 'Sample Progress',
        Str::contains($name, 'singkatan merk') => 'Master Singkatan Merk',
        Str::contains($name, ['hak akses', 'role permission']) => 'Hak Akses',
        Str::contains($name, ['account', 'user', 'management']) => 'Account Management',
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
        $user = Auth::user();

        activity()
            ->causedBy($user)
            ->tap(fn ($activity) => $activity->id_user = $user->id)
            ->withProperties($request->all())
            ->log('Memulai proses penyimpanan hak akses');

        $validated = $request->validate([
            'role_id' => 'required|exists:roles,id',
            'permissions' => 'nullable|array',
            'permissions.*' => 'string|exists:permissions,name',
        ]);

        $role = Role::findOrFail($validated['role_id']);
        $role->syncPermissions($validated['permissions'] ?? []);

        activity()
            ->causedBy($user)
            ->performedOn($role)
            ->tap(fn ($activity) => $activity->id_user = $user->id)
            ->withProperties(['permissions_assigned' => $validated['permissions'] ?? []])
            ->log('Berhasil menyimpan hak akses role');

        return redirect()
            ->route('role-permission.index', ['role_id' => $role->id])
            ->with('success', 'Hak akses berhasil diperbarui.');
    }
}
