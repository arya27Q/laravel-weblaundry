<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Service;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class LaundrySeeder extends Seeder
{
    public function run(): void
    {
        // 1. Buat Data Pelanggan
        $customer = Customer::create([
            'name' => 'Budi Santoso',
            'phone' => '081234567890',
            'address' => 'Jl. Raya Gubeng No. 123, Surabaya'
        ]);

        // 2. Buat Data Layanan
        $service1 = Service::create([
            'service_name' => 'Cuci Kiloan Reguler',
            'unit' => 'Kg',
            'price' => 7000,
            'estimation' => '2-3 Hari'
        ]);

        $service2 = Service::create([
            'service_name' => 'Cuci Setrika',
            'unit' => 'Kg',
            'price' => 10000,
            'estimation' => '1 Hari'
        ]);

        // 3. Buat Data Transaksi (Contoh: Menunggu)
        $transaction = Transaction::create([
            'customer_id' => $customer->id,
            'invoice_code' => 'INV-' . strtoupper(Str::random(6)),
            'total_price' => 35000, // 5kg x 7000
            'status_order' => 'Menunggu',
            'payment_status' => 'Belum Bayar',
            'payment_method' => 'Cash',
            'notes' => 'Baju warna putih dipisah'
        ]);

        // 4. Buat Detail Transaksi
        TransactionDetail::create([
            'transaction_id' => $transaction->id,
            'service_id' => $service1->id,
            'qty' => 5,
            'price_at_time' => 7000,
            'subtotal' => 35000
        ]);
    }
}