<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use Carbon\Carbon;
use App\Exports\LaporanExport;
use Maatwebsite\Excel\Facades\Excel;

class LaporanController extends Controller
{
  public function updateStatus(Request $request, $id)
{
    $transaction = \App\Models\Transaction::find($id);
    if ($transaction) {
        
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
public function exportExcel(Request $request)
{
    $dari =$request->dari_tanggal;
    $sampai = $request->sampai_tanggal;
    $query = Transaction::with(['customer','details.service']);

    if ($dari && $sampai) {
        $query->whereBetween('created_at', [
            Carbon::parse($dari)->startOfDay(),
            Carbon::parse($sampai)->endOfDay()
        ]);
    }
    $transactions = $query->latest()->get();
    return Excel::download(new LaporanExport($transactions), 'laporan_transaksi.xlsx');
}
    public function index(Request $request)
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
        $totalTransaksi = $transactions->count();
        $rataRata = $totalTransaksi > 0 ? $totalOmzet / $totalTransaksi : 0;
        
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