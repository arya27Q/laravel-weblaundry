<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction; 

class PembayaranController extends Controller
{
    public function index()
    {
        $transactions = Transaction::with('customer')->latest()->get();
        
        $totalTagihan = $transactions->where('payment_status', 'Belum Bayar')->sum('total_price');
        $belumBayar = $transactions->where('payment_status', 'Belum Bayar')->count();
        $sudahLunas = $transactions->where('payment_status', 'Lunas')->count();

        return view('pages.pembayaran', compact('transactions', 'totalTagihan', 'belumBayar', 'sudahLunas'));
    }

    public function update(Request $request)
    {
       
        $request->validate([
            'transaction_id' => 'required|exists:transactions,id',
            'payment_method' => 'required'
        ]);

        $trx = Transaction::findOrFail($request->transaction_id);
        
        $trx->update([
            'payment_status' => 'Lunas',
            'payment_method' => $request->payment_method
        ]);

        return redirect()->back()->with('success', 'Pembayaran berhasil dikonfirmasi!');
    }
}