<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Constructor untuk menerapkan middleware 'auth' ke semua metode di controller ini.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Menampilkan halaman dashboard setelah login.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Mendapatkan data pengguna yang sedang login
        $user = Auth::user();

        // Mengirim data nama pengguna ke view 'home'
        return view('home', ['nama' => $user->name]);
    }
}
