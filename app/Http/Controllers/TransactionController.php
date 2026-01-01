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
        $transactions = Transaction::with('customer')->latest()->get();

        return view('pages.transaksi', compact('customers', 'services', 'transactions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'service_type' => 'required|in:kg,pcs',
            'total_price' => 'required|numeric',
        ]);

        return DB::transaction(function () use ($request) {
            
            $lastTransaction = Transaction::whereDate('created_at', now())
                ->orderBy('id', 'desc')
                ->first();

            $nextNumber = 1;
            if ($lastTransaction) {
                $lastNumber = (int)substr($lastTransaction->invoice_code, -3);
                $nextNumber = $lastNumber + 1;
            }

            $invoice = 'LND-' . date('Ymd') . '-' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
            
            
            while (Transaction::where('invoice_code', $invoice)->exists()) {
                $nextNumber++;
                $invoice = 'LND-' . date('Ymd') . '-' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
            }

            $transaction = Transaction::create([
                'customer_id'    => $request->customer_id,
                'invoice_code'   => $invoice,
                'total_price'    => $request->total_price,
                'status_order'   => 'Menunggu',
                'payment_status' => 'Belum Bayar',
                'payment_method' => 'Cash',
            ]);

           
            if ($request->service_type == 'kg') {
                $qty = (float) $request->qty_kg;
               
                $service = Service::where('unit', 'Kg')->first();
                $service_id = $service ? $service->id : 1; 
            } else {
                $qty = (float) $request->qty_pcs;
                
                $service = Service::where('unit', 'Pcs')->first();
                $service_id = $service ? $service->id : 2;
            }

           
            TransactionDetail::create([
                'transaction_id' => $transaction->id,
                'service_id'     => $service_id, 
                'qty'            => $qty,
                'price_at_time'  => $request->total_price / ($qty > 0 ? $qty : 1),
                'subtotal'       => $request->total_price,
            ]);

            return redirect()->back()->with('success', 'Transaksi #' . $invoice . ' Berhasil Disimpan!');
        });
    }
}