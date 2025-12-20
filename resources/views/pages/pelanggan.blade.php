@extends('layouts.dashboard')

@section('title', 'Pelanggan')

@section('content')

<!-- HEADER -->
<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:24px;">
    <h2 style="font-size:20px; font-weight:600;">Data Pelanggan</h2>

    <button style="
        background:#f97316;
        color:#fff;
        border:none;
        padding:10px 16px;
        border-radius:8px;
        cursor:pointer;
    ">
        + Tambah Pelanggan
    </button>
</div>

<!-- SEARCH -->
<div class="card" style="margin-bottom:24px;">
    <input 
        type="text" 
        placeholder="Cari nama / nomor HP..."
        style="
            width:100%;
            padding:10px 12px;
            border-radius:8px;
            border:1px solid #ddd;
        "
    >
</div>

<!-- TABLE -->
<div class="card">
    <table class="table">
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>No. HP</th>
            <th>Alamat</th>
            <th>Aksi</th>
        </tr>

        <!-- KOSONG DULU -->
        <tr>
            <td colspan="5" style="text-align:center; padding:24px; color:#999;">
                Belum ada data pelanggan
            </td>
        </tr>
    </table>
</div>

@endsection
