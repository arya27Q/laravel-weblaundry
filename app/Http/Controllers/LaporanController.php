<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use Carbon\Carbon;

class LaporanController extends Controller
{
  public function updateStatus(Request $request, $id)
{
    $transaction = \App\Models\Transaction::find($id);
    if ($transaction) {
        // Logika ganti status: Jika 'Selesai' jadi 'Belum Bayar', dan sebaliknya
        $transaction->payment_status = ($transaction->payment_status == 'Selesai') ? 'Belum Bayar' : 'Selesai';
        $transaction->save();
        
        return redirect()->back()->with('success', 'Status Pembayaran Berhasil Diperbarui!');
    }
    return redirect()->back()->with('error', 'Data tidak ditemukan.');
}
public function cetak(Request $request)
{
    $dari = $request->dari_tanggal;
    $sampai = $request->sampai_tanggal;

    $query = Transaction::with(['customer', 'details.service']);

    if ($dari && $sampai) {
        $query->whereBetween('created_at', [
            Carbon::parse($dari)->startOfDay(),
            Carbon::parse($sampai)->endOfDay()
        ]);
    }

    $transactions = $query->latest()->get();
    $totalOmzet = $transactions->sum('total_price');

    return view('pages.laporan_cetak', compact('transactions', 'totalOmzet', 'dari', 'sampai'));
}
    public function index(Request $request)
    {
        // Ambil input tanggal dari filter
        $dari = $request->dari_tanggal;
        $sampai = $request->sampai_tanggal;

        // Query dasar: kita ambil transaksi yang sudah selesai/dibayar (tergantung kebijakanmu)
        $query = Transaction::with(['customer', 'details.service']);

        if ($dari && $sampai) {
            $query->whereBetween('created_at', [
                Carbon::parse($dari)->startOfDay(),
                Carbon::parse($sampai)->endOfDay()
            ]);
        }

        $transactions = $query->latest()->get();

        // Hitung Ringkasan Statistik
        $totalOmzet = $transactions->sum('total_price');
        $totalTransaksi = $transactions->count();
        $rataRata = $totalTransaksi > 0 ? $totalOmzet / $totalTransaksi : 0;
        
        // Hitung Berat Total (Hanya yang unitnya Kg)
        $totalBerat = 0;
        foreach($transactions as $tr) {
            foreach($tr->details as $dt) {
                if(strtolower($dt->service->unit ?? '') == 'kg') {
                    $totalBerat += $dt->qty;
                }
            }
        }

        return view('pages.laporan', compact(
            'transactions', 'totalOmzet', 'totalTransaksi', 
            'rataRata', 'totalBerat', 'dari', 'sampai'
        ));
    }
}