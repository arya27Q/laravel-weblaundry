<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\CucianController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\PembayaranController; 
use App\Http\Controllers\LaporanController;


// 1. Dashboard
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

// 2. Pelanggan
Route::resource('pelanggan', PelangganController::class);

// 3. Transaksi
Route::get('/transaksi', [TransactionController::class, 'index'])->name('transaksi.index');
Route::post('/transaksi', [TransactionController::class, 'store'])->name('transaksi.store');

// 4. Cucian
Route::get('/cucian', [CucianController::class, 'index'])->name('cucian');
Route::post('/cucian/update-status', [CucianController::class, 'updateStatus']);

// 5. Pembayaran (Menggunakan PembayaranController)
// Route untuk menampilkan halaman (index)
Route::get('/pembayaran', [PembayaranController::class, 'index'])->name('pembayaran.index');

// Route untuk memproses update pembayaran lunas
Route::post('/pembayaran/konfirmasi', [PembayaranController::class, 'update'])->name('pembayaran.update');

// 6. Laporan & Pengaturan
Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');

Route::post('/laporan/update-status/{id}', [LaporanController::class, 'updateStatus'])->name('laporan.updateStatus');
Route::view('/pengaturan', 'pages.pengaturan')->name('pengaturan');

// 7. Auth
Route::view('/login', 'pages.login')->name('login');
Route::view('/signup', 'pages.signup')->name('signup');

Route::get('/laporan/cetak', [LaporanController::class, 'cetak'])->name('laporan.cetak');