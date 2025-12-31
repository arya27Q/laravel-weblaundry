<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CucianController extends Controller
{
    public function index()
    {
        // 1. Ambil data transaksi aktif beserta relasi customer dan detail layanannya
        $cucian_aktif = Transaction::with(['customer', 'details.service'])
                        ->whereIn('status_order', ['Menunggu', 'Dicuci', 'Disetrika', 'Siap Diambil'])
                        ->orderBy('created_at', 'asc')
                        ->get();

        // 2. Ringkasan data (Dibatasi hanya untuk hari ini agar performa lebih cepat)
        $total_cucian = Transaction::whereDate('created_at', now())->count();
        $proses = Transaction::whereIn('status_order', ['Dicuci', 'Disetrika'])->count();
        $selesai = Transaction::where('status_order', 'Selesai')
                                ->whereDate('created_at', now())
                                ->count();
        
        // 3. Data tambahan untuk Metode Pembayaran (Hanya hari ini)
        $cash_count = Transaction::where('payment_method', 'Cash')
                                ->whereDate('created_at', now())
                                ->count();
        $non_tunai_count = Transaction::where('payment_method', 'Non Tunai')
                                ->whereDate('created_at', now())
                                ->count();

        // 4. Return view ke folder 'pages'
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
        // Validasi input
        $request->validate([
            'id' => 'required|exists:transactions,id',
            'status' => 'required'
        ]);

        try {
            $transaction = Transaction::findOrFail($request->id);
            $transaction->status_order = $request->status;
            
            // Logika tambahan: Jika status diubah ke Selesai, bisa set payment_status otomatis
            if ($request->status == 'Selesai') {
                $transaction->payment_status = 'Lunas';
            }

            $transaction->save();

            return response()->json([
                'success' => true,
                'message' => 'Status berhasil diperbarui menjadi ' . $request->status
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui status: ' . $e->getMessage()
            ], 500);
        }
    }
}