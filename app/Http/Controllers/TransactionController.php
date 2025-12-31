<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Customer;
use App\Models\Service;
use App\Models\Transaction;
use App\Models\TransactionDetail;

class TransactionController extends Controller
{
    public function index()
    {
        $customers = Customer::orderBy('name', 'asc')->get();
        $services = Service::all();
        
        // Eager loading 'customer' agar tidak berat saat loading halaman
        $transactions = Transaction::with('customer')->latest()->get();

        return view('pages.transaksi', compact('customers', 'services', 'transactions'));
    }

    public function store(Request $request)
    {
        // Tambahkan validasi agar data yang masuk pasti benar
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'service_type' => 'required|in:kg,pcs',
            'total_price' => 'required|numeric',
        ]);

        return DB::transaction(function () use ($request) {
            // 1. Buat Invoice Otomatis
            $count = Transaction::whereDate('created_at', now())->count() + 1;
            $invoice = 'LND-' . date('Ymd') . '-' . str_pad($count, 3, '0', STR_PAD_LEFT);

            // 2. Simpan Header (Tabel Transactions)
            $transaction = Transaction::create([
                'customer_id'    => $request->customer_id,
                'invoice_code'   => $invoice,
                'total_price'    => $request->total_price,
                'status_order'   => 'Menunggu',
                'payment_status' => 'Belum Bayar',
            ]);

            // 3. Simpan Detail (Tabel TransactionDetails)
            // Pastikan qty tidak nol atau null untuk menghindari error Division by Zero
            $qty = ($request->service_type == 'kg') ? $request->qty_kg : $request->qty_pcs;
            $qty = (float)($qty > 0 ? $qty : 1); 
            
            // Asumsi service_id: 1 untuk Kiloan, 2 untuk Satuan (sesuaikan database kamu)
            $service_id = ($request->service_type == 'kg') ? 1 : 2;

            TransactionDetail::create([
                'transaction_id' => $transaction->id,
                'service_id'     => $service_id, 
                'qty'            => $qty,
                'price_at_time'  => $request->total_price / $qty,
                'subtotal'       => $request->total_price,
            ]);

            return redirect()->back()->with('success', 'Transaksi #' . $invoice . ' Berhasil Disimpan!');
        });
    }
}