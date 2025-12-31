<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    // Kolom yang boleh diisi (mass assignment)
    protected $fillable = [
        'name',
        'phone',
        'address'
    ];

    /**
     * Relasi ke tabel Transactions
     * Satu Customer bisa memiliki banyak Transaksi (One to Many)
     */
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}