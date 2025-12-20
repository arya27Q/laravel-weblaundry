@extends('layouts.dashboard')

@section('title', 'Transaksi')

@section('content')

<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:32px;">
    <h2 style="font-size:22px; font-weight:600;">Data Transaksi</h2>

    <button class="btn-primary">
        + Tambah Transaksi
    </button>
</div>


<!-- FILTER -->

<div class="card" style="margin-bottom:32px;">
    <div class="filter-grid">

        <!-- SEARCH -->
        <div class="input-icon">
            <i class="fa-solid fa-magnifying-glass"></i>
            <input
                type="text"
                placeholder="Cari pelanggan..."
                class="input with-icon"
            >
        </div>

        <!-- STATUS -->
        <select class="input">
            <option value="">Status</option>
            <option>Menunggu</option>
            <option>Dicuci</option>
            <option>Disetrika</option>
            <option>Selesai</option>
        </select>

        <!-- DATE -->
        <div class="input-icon">
            <i class="fa-regular fa-calendar"></i>
            <input type="date" class="input with-icon">
        </div>

        <!-- BUTTON -->
        <button class="btn-secondary btn-click">
            <i class="fa-solid fa-filter" style="margin-right:6px;"></i>
            Filter
        </button>
    </div>
</div>




<!-- RINGKASAN TRANSAKSI -->
<div style="display:grid; grid-template-columns: repeat(4, 1fr); gap:24px; margin-bottom:40px;">

    <div class="card">
        <div class="card-title">
            <i class="fa-solid fa-receipt icon orange"></i>
            Total Transaksi
        </div>
        <div class="card-value">0</div>
    </div>

    <div class="card">
        <div class="card-title">
            <i class="fa-solid fa-clock icon warning"></i>
            Belum Selesai
        </div>
        <div class="card-value">0</div>
    </div>

    <div class="card">
        <div class="card-title">
            <i class="fa-solid fa-circle-check icon success"></i>
            Selesai
        </div>
        <div class="card-value">0</div>
    </div>

    <div class="card">
        <div class="card-title">
            <i class="fa-solid fa-wallet icon green"></i>
            Pendapatan
        </div>
        <div class="card-value">Rp 0</div>
    </div>

</div>


<!-- TABEL TRANSAKSI -->
<div class="card">
    <h3 style="font-weight:600; margin-bottom:16px;">Daftar Transaksi</h3>

    <table class="table">
        <thead>
            <tr>
                <th>Kode</th>
                <th>Pelanggan</th>
                <th>Tanggal</th>
                <th>Status</th>
                <th>Total</th>
                <th>Aksi</th>
            </tr>
        </thead>

        <tbody>
            <tr>
                <td colspan="6" style="text-align:center; color:#999; padding:24px;">
                    Belum ada transaksi
                </td>
            </tr>
        </tbody>
    </table>
</div>

@endsection
