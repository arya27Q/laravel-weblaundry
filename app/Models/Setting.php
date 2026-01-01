<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    // Tanpa ini, perintah $setting->update() akan diblokir oleh Laravel (Mass Assignment)
    protected $fillable = [
        'nama_laundry', 
        'whatsapp', 
        'alamat', 
        'harga_kiloan', 
        'harga_setrika'
    ];
}