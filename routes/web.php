<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\CucianController;

// 1. Dashboard
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

// 2. Pelanggan (Gunakan Resource agar Edit & Hapus Terdaftar Otomatis)
// Ini akan menyediakan rute: pelanggan.index, pelanggan.store, pelanggan.update, pelanggan.destroy, dll.
Route::resource('pelanggan', PelangganController::class);

Route::get('/cucian', [CucianController::class, 'index'])->name('cucian');
Route::post('/cucian/update-status', [CucianController::class, 'updateStatus']);
Route::view('/transaksi', 'pages.transaksi')->name('transaksi');
Route::view('/pembayaran', 'pages.pembayaran')->name('pembayaran');
Route::view('/laporan', 'pages.laporan')->name('laporan');
Route::view('/pengaturan', 'pages.pengaturan')->name('pengaturan');

Route::view('/login', 'pages.login')->name('login');
Route::view('/signup', 'pages.signup')->name('signup');