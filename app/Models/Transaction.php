<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'invoice_code',
        'total_price',
        'status_order',
        'payment_status',
        'payment_method',
        'notes'
    ];

    // Relasi balik ke Pelanggan
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    // Relasi ke detail item laundry
    public function details()
    {
        return $this->hasMany(TransactionDetail::class);
    }
}