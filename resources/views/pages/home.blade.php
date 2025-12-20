@extends('layouts.dashboard')

@section('title', 'Dashboard')

@section('content')

<!-- SUMMARY -->
<div style="display:grid; grid-template-columns: repeat(4, 1fr); gap:24px;">

    <div class="card">
      
        <div class="card-title">
        <i class="fa-solid fa-users card-icon"></i>
            Pelanggan
        </div>
        <div class="card-value">0</div>
    </div>

    <div class="card">

        <div class="card-title">
        <i class="fa-solid fa-receipt card-icon"></i>
             Transaksi
        </div>
        <div class="card-value">0</div>
    </div>

    <div class="card">
       
        <div class="card-title">
             <i class="fa-solid fa-money-bill-wave card-icon"></i>
             Pendapatan
            </div>
        <div class="card-value">Rp 0</div>
    </div>

    <div class="card">
       
        <div class="card-title">
             <i class="fa-solid fa-spinner card-icon"></i>
            Dalam Proses
        </div>
        <div class="card-value">0</div>
    </div>

</div>

<!-- AKTIVITAS -->
<div class="card" style="margin-top:40px;">
    <h3 style="font-weight:600; margin-bottom:16px;">Aktivitas Terbaru</h3>

    <table class="table">
        <tr>
            <th>Pelanggan</th>
            <th>Status</th>
            <th>Total</th>
        </tr>
        <tr>
            <td colspan="3" style="text-align:center; color:#999; padding:20px;">
                Belum ada transaksi
            </td>
        </tr>
    </table>
</div>

<!-- STATUS CUCIAN -->
<h3 style="margin:40px 0 16px; font-weight:600;">Status Cucian</h3>

<div style="display:grid; grid-template-columns: repeat(5, 1fr); gap:16px;">
    <div class="card">
        <div class="card-title">
        <i class="fa-solid fa-clock card-icon"></i>
            Menunggu
        </div>
        <div class="card-value">0</div>
    </div>

    <div class="card">
        <div class="card-title">
            <i class="fa-solid fa-soap card-icon"></i>
            Dicuci
    </div>
        <div class="card-value">0</div>
    </div>

    <div class="card">
        <div class="card-title">
             <i class="fa-solid fa-shirt card-icon"></i>
            Disetrika
        </div>
        <div class="card-value">0</div>
    </div>

    <div class="card">
        <div class="card-title">
            <i class="fa-solid fa-box-open card-icon"></i>
            Siap Diambil
        </div>
        <div class="card-value">0</div>
    </div>

    <div class="card">
        <div class="card-title">
         <i class="fa-solid fa-circle-check card-icon"></i>
            Selesai
        </div>
        <div class="card-value">0</div>
    </div>
</div>

<!-- RINGKASAN -->
<h3 style="margin:40px 0 16px; font-weight:600;">Ringkasan Hari Ini</h3>

<div style="display:grid; grid-template-columns: repeat(2, 1fr); gap:24px;">
    <div class="card">
        <div class="card-title">
            <i class="fa-solid fa-calendar-day card-icon"></i>
            Transaksi Hari Ini
        </div>
        <div class="card-value">0</div>
    </div>

    <div class="card">
        <div class="card-title">
           <i class="fa-solid fa-coins card-icon"></i>
            Pendapatan Hari Ini
        </div>
        <div class="card-value">Rp 0</div>
    </div>
</div>

<!-- PEMBAYARAN -->
<h3 style="margin:40px 0 16px; font-weight:600;">Metode Pembayaran</h3>

<div style="display:grid; grid-template-columns: repeat(2, 1fr); gap:24px;">
    <div class="card">
        <div class="card-title">
            <i class="fa-solid fa-money-bill card-icon"></i>
               Cash
            </div>
        <div class="card-value">0</div>
    </div>

    <div class="card">
        <div class="card-title">
            <i class="fa-solid fa-credit-card card-icon"></i>
            Non Tunai'
        </div>
        <div class="card-value">0</div>
    </div>
</div>

@endsection
