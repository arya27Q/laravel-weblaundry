<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'service_name',
        'unit',
        'price',
        'estimation'
    ];

    public function details()
    {
        return $this->hasMany(TransactionDetail::class);
    }
}