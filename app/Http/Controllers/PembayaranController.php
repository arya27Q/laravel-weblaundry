<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction; // Wajib ada agar tidak merah

class PembayaranController extends Controller
{
    public function index()
    {
        // Ambil data transaksi beserta nama pelanggannya
        $transactions = Transaction::with('customer')->latest()->get();
        
        // Logika untuk mengisi kotak-kotak statistik di atas (Gambar 6 & 3)
        $totalTagihan = $transactions->where('payment_status', 'Belum Bayar')->sum('total_price');
        $belumBayar = $transactions->where('payment_status', 'Belum Bayar')->count();
        $sudahLunas = $transactions->where('payment_status', 'Lunas')->count();

        return view('pages.pembayaran', compact('transactions', 'totalTagihan', 'belumBayar', 'sudahLunas'));
    }

    public function update(Request $request)
    {
        // Validasi input dari modal pembayaran
        $request->validate([
            'transaction_id' => 'required|exists:transactions,id',
            'payment_method' => 'required'
        ]);

        // Cari transaksi berdasarkan ID yang dipilih di dropdown modal
        $trx = Transaction::findOrFail($request->transaction_id);
        
        // Update status transaksi menjadi lunas
        $trx->update([
            'payment_status' => 'Lunas',
            'payment_method' => $request->payment_method
        ]);

        return redirect()->back()->with('success', 'Pembayaran berhasil dikonfirmasi!');
    }
}