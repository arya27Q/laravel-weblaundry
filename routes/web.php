<?php

use Illuminate\Support\Facades\Route;


Route::view('/', 'pages.home')->name('dashboard');

Route::view('/pelanggan', 'pages.pelanggan')->name('pelanggan');

Route::view('/transaksi', 'pages.transaksi')->name('transaksi');

Route::view('/cucian', 'pages.cucian')->name('cucian');

Route::view('/pembayaran', 'pages.pembayaran')->name('pembayaran');

Route::view('/laporan', 'pages.laporan')->name('laporan');

Route::view('/pengaturan', 'pages.pengaturan')->name('pengaturan');

Route::view('/login', 'pages.login')->name('login');

Route::view('/signup', 'pages.signup')->name('signup');

Route::view('/forgot-password', 'pages.forgot_pw')->name('forgot-password');

Route::view('/reset-password', 'pages.reset_pw')->name('password.reset');

use App\Http\Controllers\CucianController;

Route::post('/cucian/update-status', [CucianController::class, 'updateStatus']);
