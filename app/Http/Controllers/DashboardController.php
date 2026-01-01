<?php

namespace App\Http\Controllers;

use App\Models\Customer; 
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Data Summary Utama
        $total_pelanggan = Customer::count();
        $total_transaksi = Transaction::count();
        $pendapatan_total = Transaction::where('payment_status', 'Lunas')->sum('total_price');
        $cucian_proses = Transaction::whereIn('status_order', ['Dicuci', 'Disetrika'])->count();

        // 2. Ringkasan Hari Ini
        $transaksi_hari_ini = Transaction::whereDate('created_at', today())->count();
        $pendapatan_hari_ini = Transaction::whereDate('created_at', today())
                                ->where('payment_status', 'Lunas')
                                ->sum('total_price');

        // 3. Status Cucian & Metode Pembayaran (Group By)
        $status_counts = Transaction::select('status_order', DB::raw('count(*) as total'))
                            ->groupBy('status_order')
                            ->pluck('total', 'status_order');

        $pembayaran_counts = Transaction::select('payment_method', DB::raw('count(*) as total'))
                                ->groupBy('payment_method')
                                ->pluck('total', 'payment_method');

        // 4. Aktivitas Terbaru (Relasi ke Customer)
        $transaksi_terbaru = Transaction::with('customer')->latest()->take(5)->get();

        // 5. Statistik Pendapatan Mingguan (7 Hari Terakhir)
        $weekly_data = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = today()->subDays($i);
            $weekly_data[] = Transaction::whereDate('created_at', $date)
                                ->where('payment_status', 'Lunas')
                                ->sum('total_price');
        }

        // 6. Statistik Pendapatan Bulanan (Januari - Desember Tahun Ini)
        $monthly_data = [];
        for ($m = 1; $m <= 12; $m++) {
            $monthly_data[] = Transaction::whereYear('created_at', date('Y'))
                                ->whereMonth('created_at', $m)
                                ->where('payment_status', 'Lunas')
                                ->sum('total_price');
        }

        return view('pages.home', [
            'total_pelanggan'     => $total_pelanggan,
            'total_transaksi'     => $total_transaksi,
            'pendapatan_total'    => $pendapatan_total,
            'pendapatan_hari_ini' => $pendapatan_hari_ini,
            'transaksi_hari_ini'  => $transaksi_hari_ini,
            'cucian_proses'       => $cucian_proses,
            'transaksi_terbaru'   => $transaksi_terbaru,
            'status_counts'       => $status_counts,
            'pembayaran_counts'   => $pembayaran_counts,
            'chart_weekly_data'   => $weekly_data,
            'chart_monthly_data'  => $monthly_data,
        ]);
    }
}