<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Transaction;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Mengambil data ringkasan untuk dashboard
        $data = [
            'total_pelanggan'    => Customer::count(),
            'total_transaksi'    => Transaction::count(),
            'pendapatan_hari_ini' => Transaction::whereDate('created_at', today())
                                    ->where('payment_status', 'Lunas')
                                    ->sum('total_price'),
            'cucian_proses'      => Transaction::whereIn('status_order', ['Dicuci', 'Disetrika'])->count(),
            'cucian_siap'        => Transaction::where('status_order', 'Siap Diambil')->count(),
            'cucian_selesai'     => Transaction::where('status_order', 'Selesai')->count(),
            
            // Mengambil 5 transaksi terbaru untuk tabel "Aktivitas Terbaru"
            'transaksi_terbaru'  => Transaction::with('customer')->latest()->take(5)->get(),
        ];

        // Ganti 'dashboard' dengan nama file blade kamu (misal: 'admin.dashboard')
       // Ganti baris ini:
// return view('dashboard', $data);

// Menjadi ini:
    return view('pages.home', $data);
    }
}