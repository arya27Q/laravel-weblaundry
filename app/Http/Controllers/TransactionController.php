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
            'service_id'  => 'required|exists:services,id', 
            'qty'         => 'required|numeric|min:0.1',    
            'total_price' => 'required|numeric',
        ]);

        return DB::transaction(function () use ($request) {
            
           
            $today = now()->format('Ymd');
            $lastTransaction = Transaction::whereDate('created_at', now())
                ->orderBy('id', 'desc')
                ->first();

            $nextNumber = 1;
            if ($lastTransaction) {
                $lastNumber = (int)substr($lastTransaction->invoice_code, -3);
                $nextNumber = $lastNumber + 1;
            }

            $invoice = 'LND-' . $today . '-' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
            
            while (Transaction::where('invoice_code', $invoice)->exists()) {
                $nextNumber++;
                $invoice = 'LND-' . $today . '-' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
            }

            $transaction = Transaction::create([
                'customer_id'    => $request->customer_id,
                'invoice_code'   => $invoice,
                'total_price'    => $request->total_price,
                'status_order'   => 'Menunggu',
                'payment_status' => 'Belum Bayar',
                'payment_method' => 'Cash',
            ]);

            $service = Service::find($request->service_id);
            TransactionDetail::create([
                'transaction_id' => $transaction->id,
                'service_id'     => $service->id, 
                'qty'            => $request->qty,
                'price_at_time'  => $service->price, 
                'subtotal'       => $request->total_price,
            ]);

            return redirect()->back()->with('success', 'Transaksi #' . $invoice . ' Berhasil Disimpan!');
        });
    }
}