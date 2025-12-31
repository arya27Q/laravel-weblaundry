<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_id', 
        'service_id', 
        'qty', 
        'price_at_time', 
        'subtotal'
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}