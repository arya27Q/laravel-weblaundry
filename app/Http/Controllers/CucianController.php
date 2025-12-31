<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class CucianController extends Controller
{
    public function index()
    {
        // Ambil data transaksi aktif beserta relasi customer dan detail layanannya
        $cucian_aktif = Transaction::with(['customer', 'details.service'])
                        ->whereIn('status_order', ['Menunggu', 'Dicuci', 'Disetrika', 'Siap Diambil'])
                        ->orderBy('created_at', 'asc')
                        ->get();

        // Ringkasan data
        $total_cucian = Transaction::count();
        $proses = Transaction::whereIn('status_order', ['Dicuci', 'Disetrika'])->count();
        $selesai = Transaction::where('status_order', 'Selesai')->count();
        
        // Data tambahan untuk Metode Pembayaran
        $cash_count = Transaction::where('payment_method', 'Cash')->count();
        $non_tunai_count = Transaction::where('payment_method', 'Non Tunai')->count();

        // PERBAIKAN: Diarahkan ke folder 'pages'
        return view('pages.cucian', compact(
            'cucian_aktif', 
            'total_cucian', 
            'proses', 
            'selesai', 
            'cash_count', 
            'non_tunai_count'
        ));
    }

    public function updateStatus(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:transactions,id',
            'status' => 'required'
        ]);

        $transaction = Transaction::find($request->id);
        $transaction->status_order = $request->status;
        $transaction->save();

        return response()->json([
            'success' => true,
            'message' => 'Status berhasil diperbarui!'
        ]);
    }
}