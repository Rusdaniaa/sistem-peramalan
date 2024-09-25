<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\HasilPeramalanController;
use App\Http\Controllers\HitungController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\ProsesPeramalanController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::middleware(['auth', 'level'])->group(
    function () {
        Route::get('/', function () {
            return view('welcome');
        });
        Route::get('/home', [HomeController::class, 'show'])->name('home');
        //Route User
        Route::resource('user', UserController::class);
        Route::get('/user/cetak', [UserController::class, 'cetak'])->name('user.cetak');

        //Route Produk
        Route::resource('produk', ProdukController::class);
        Route::get('/user/profil', [UserController::class, 'password'])->name('user.password');
        Route::post('/user/profil', [UserController::class, 'passwordUpdate'])->name('user.password.update');
        //Route::get('/user/setting', [UserController::class, 'setting'])->name('user.setting');
        Route::post('/user/setting', [UserController::class, 'settingUpdate'])->name('user.setting .update');
        Route::get('/user/logout', [UserController::class, 'logout'])->name('user.logout');

        //Route Penjualan
        Route::resource('/penjualan', PenjualanController::class);
        Route::get('/penjualan/cetak', [PenjualanController::class, 'cetak'])->name('penjualan.cetak');
        Route::get('hitung', [HitungController::class, 'index'])->name('hitung.index');
        Route::post('hitung', [HitungController::class, 'detail'])->name('hitung.detail');
        Route::get('hitung/cetak', [HitungController::class, 'cetak'])->name('hitung.cetak');
        Route::get('hitung/hasil', [HitungController::class, 'hasil'])->name('hitung.hasil');
        Route::get('hitung/hasil/cetak', [HitungController::class, 'hasilCetak'])->name('hitung.hasil.cetak');


        Route::get('account/setting', [UserController::class, 'setting'])->name('account.setting');

    });

Route::get('/login', [UserController::class, 'loginForm'])->name('login');
Route::post('/login', [UserController::class, 'loginAction'])->name('login.action');
