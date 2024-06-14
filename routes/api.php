<?php

use App\Http\Controllers\InformasiController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\KeranjangController;
use App\Http\Controllers\Paket_pembelian;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\UsersController;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/paket_pembelian', [Paket_pembelian::class, 'index']);

Route::post('/paket_pembelian', [Paket_pembelian::class, 'store']);

Route::get('/paket_pembelian/{id}', [Paket_pembelian::class, 'show']);

Route::delete('/paket_pembelian/{id}', [Paket_pembelian::class, 'destroy']);

Route::put('/paket_pembelian/{id}', [Paket_pembelian::class, 'update']);

Route::get('/kategori', [KategoriController::class, 'index']);

Route::post('/kategori', [KategoriController::class, 'store']);

Route::get('/kategori/{id}', [KategoriController::class, 'show']);

Route::put('/kategori/{id}', [KategoriController::class, 'update']);

Route::delete('/kategori/{id}', [KategoriController::class, 'destroy']);

Route::get('/informasi', [InformasiController::class, 'index']);

Route::post('/informasi', [InformasiController::class, 'store']);

Route::put('/informasi/{id}', [InformasiController::class, 'update']);

Route::get('/informasi/{id}', [InformasiController::class, 'show']);

Route::delete('/informasi/{id}', [InformasiController::class, 'destroy']);

Route::get('/user', [UsersController::class, 'index']);

Route::post('/register', [UsersController::class, 'store']);

Route::delete('/user/{id}', [UsersController::class, 'destroy']);

Route::post('/login', [UsersController::class, 'login']);

Route::middleware('auth:api')->post('/logout', [UsersController::class, 'logout']);

Route::get('/loggedin', [UsersController::class, 'loggedin'])->name('login');

Route::post('/keranjang/{id}', [KeranjangController::class, 'store']);

Route::get('/keranjang', [KeranjangController::class, 'index']);

Route::delete('keranjang/{id}', [KeranjangController::class, 'destroy']);

Route::get('/transaksi', [TransaksiController::class, 'index']);

Route::post('/transaksi/{id}', [TransaksiController::class, 'store']);

Route::get('/transaksi-all', [TransaksiController::class, 'showAll']);
