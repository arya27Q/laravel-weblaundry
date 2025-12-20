<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('pages.home');
});

Route::get('/pelanggan', function () {
    return view('pages.pelanggan');
});
route::get('/transaksi', function () {
    return view('pages.');
});
Route::view('/', 'pages.home')->name('dashboard');
Route::view('/pelanggan', 'pages.pelanggan')->name('pelanggan');
Route::view('/transaksi', 'pages.transaksi')->name('transaksi');
