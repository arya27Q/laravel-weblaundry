<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    DashboardController, PelangganController, CucianController, 
    TransactionController, PembayaranController, LaporanController, 
    PengaturanController, AuthController
};

// --- AUTH GUEST (Hanya bisa diakses kalau BELUM login) ---
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    
    Route::get('/forgot-password', [AuthController::class, 'showForgot'])->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');
    
    Route::get('/reset-password/{token}', [AuthController::class, 'showReset'])->name('password.reset');
    Route::post('/reset-password', [AuthController::class, 'updatePassword'])->name('password.update');
});

// --- AUTH PROTECTED (Hanya bisa diakses kalau SUDAH login) ---
Route::middleware('auth')->group(function () {
    
    // Dashboard (Arahkan ke Controller, jangan cuma return view)
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard', [DashboardController::class, 'index']); // Alias agar tidak error jika dipanggil via /dashboard

    // Pelanggan
    Route::resource('pelanggan', PelangganController::class);

    // Transaksi & Cucian
    Route::get('/transaksi', [TransactionController::class, 'index'])->name('transaksi.index');
    Route::post('/transaksi', [TransactionController::class, 'store'])->name('transaksi.store');
    Route::get('/cucian', [CucianController::class, 'index'])->name('cucian');
    Route::post('/cucian/update-status', [CucianController::class, 'updateStatus']);

    // Pembayaran
    Route::get('/pembayaran', [PembayaranController::class, 'index'])->name('pembayaran.index');
    Route::post('/pembayaran/konfirmasi', [PembayaranController::class, 'update'])->name('pembayaran.update');

    // Laporan & Export
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::post('/laporan/update-status/{id}', [LaporanController::class, 'updateStatus'])->name('laporan.updateStatus');
    Route::get('/laporan/excel', [LaporanController::class, 'exportExcel'])->name('laporan.excel');
    Route::get('/laporan/cetak', [LaporanController::class, 'cetak'])->name('laporan.cetak');

    // Pengaturan
    Route::get('/pengaturan', [PengaturanController::class, 'index'])->name('pengaturan.index');
    Route::post('/pengaturan/update-profil', [PengaturanController::class, 'updateProfil'])->name('pengaturan.updateProfil');
    Route::post('/pengaturan/update-password', [PengaturanController::class, 'updatePassword'])->name('pengaturan.updatePassword');
    Route::post('/pengaturan/layanan', [PengaturanController::class, 'storeLayanan'])->name('layanan.store');

    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});