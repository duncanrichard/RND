<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;

class AccountController extends Controller
{
  public function index()
{
    $users = User::with('roles')->whereNull('deleted_at')->get();
    return view('accounts.index', compact('users'));
}


   public function create()
{
    $roles = Role::all();
    return view('accounts.create', compact('roles'));
}


    public function store(Request $request)
{
    $validated = $request->validate([
        'username' => 'required|string|max:255',
        'email' => 'required|email|unique:users',
        'password' => 'required|confirmed|min:6',
        'role' => 'required|exists:roles,name',
    ]);

    $user = User::create([
        'username' => $validated['username'],
        'email' => $validated['email'],
        'password' => bcrypt($validated['password']),
    ]);

    $user->assignRole($validated['role']);

    return redirect()->route('accounts.index')->with('success', 'Akun berhasil dibuat.');
}



    public function edit($id)
{
    $user = User::findOrFail($id);
    $roles = Role::all();

    return view('accounts.edit', compact('user', 'roles'));
}


   public function update(Request $request, $id)
{
    $user = User::findOrFail($id);

    $validated = $request->validate([
        'username' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,' . $user->id,
        'password' => 'nullable|confirmed|min:6',
        'role' => 'required|exists:roles,name',
    ]);

    $user->username = $validated['username'];
    $user->email = $validated['email'];

    if (!empty($validated['password'])) {
        $user->password = bcrypt($validated['password']);
    }

    $user->save();
    $user->syncRoles([$validated['role']]);

    return redirect()->route('accounts.index')->with('success', 'Akun berhasil diperbarui.');
}
public function destroy($id)
{
    $user = User::findOrFail($id);
    $user->delete();

    return redirect()->route('accounts.index')->with('success', 'Akun berhasil dihapus.');
}


}
