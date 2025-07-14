<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ExchangeRateController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Di sini kamu bisa mendaftarkan route API untuk aplikasi kamu.
| Route ini otomatis menggunakan prefix "/api" dan middleware "api".
|
*/

// ✅ Route untuk ambil kurs dari Bank Indonesia (dipanggil dari frontend)
Route::get('/get-latest-exchange-rates', [ExchangeRateController::class, 'getLatestRates']);

// ✅ Contoh route API dengan autentikasi (optional, bisa kamu gunakan jika pakai Sanctum)
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
