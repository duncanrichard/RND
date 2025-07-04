<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Spatie\Activitylog\Models\Activity;
use Spatie\Activitylog\Traits\LogsActivity;


class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->except('logout'); // Allow 'logout' for authenticated users
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

   public function login(Request $request)
{
    $credentials = $request->only('username', 'password');

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();

        $user = Auth::user();

        activity()
            ->causedBy($user)
            ->withProperties([
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'username' => $user->username,
                'email' => $user->email,
                'role' => $user->getRoleNames()->first(), // Jika pakai Spatie Role
            ])
            ->tap(function ($activity) use ($user) {
                $activity->id_user = $user->id; // Custom kolom tambahan
            })
            ->log('Login berhasil');

        return redirect()->intended('/home');
    }

    return back()->withErrors([
        'error' => 'Username atau password salah.',
    ])->onlyInput('username');
}

    

    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
{
    $validated = $request->validate([
        'username' => 'required|string|max:255|unique:users,username',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|confirmed|min:8',
    ]);

    $user = User::create([
        'username' => $validated['username'],
        'email' => $validated['email'],
        'password' => Hash::make($validated['password']),
    ]);

    activity()
        ->causedBy($user)
        ->withProperties([
            'ip' => $request->ip(),
            'username' => $user->username,
            'email' => $user->email,
        ])
        ->tap(function ($activity) use ($user) {
            $activity->id_user = $user->id;
        })
        ->log('Registrasi akun baru');

    return redirect()->route('login')->with('success', 'Registrasi berhasil! Silakan login.');
}


   public function logout(Request $request)
{
    $user = Auth::user();

    activity()
        ->causedBy($user)
        ->withProperties([
            'ip' => $request->ip(),
            'username' => $user->username,
            'email' => $user->email,
        ])
        ->tap(function ($activity) use ($user) {
            $activity->id_user = $user->id;
        })
        ->log('Logout');

    Auth::logout();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect()->route('login')->with('success', 'Berhasil logout!');
}


    public function showHome()
    {
        $users = User::all();  
        
        return view('home', compact('users'));
    }
}
