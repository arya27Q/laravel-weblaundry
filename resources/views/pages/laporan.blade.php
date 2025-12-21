@extends('layouts.dashboard')

@section('title', 'Laporan Keuangan')

@section('content')

<div class="card" style="margin-bottom: 24px;">
    <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 16px;">
        <div style="display: flex; gap: 12px; align-items: center;">
            <div>
                <label style="display: block; font-size: 12px; color: #6b7280; margin-bottom: 4px;">Dari Tanggal</label>
                <input type="date" class="form-control" style="padding: 8px; border-radius: 8px; border: 1px solid #ddd;">
            </div>
            <div>
                <label style="display: block; font-size: 12px; color: #6b7280; margin-bottom: 4px;">Sampai Tanggal</label>
                <input type="date" class="form-control" style="padding: 8px; border-radius: 8px; border: 1px solid #ddd;">
            </div>
            <button style="background: #f97316; color: white; border: none; padding: 10px 20px; border-radius: 8px; font-weight: 600; cursor: pointer; margin-top: 20px;">
                <i class="fa-solid fa-magnifying-glass"></i> Filter
            </button>
        </div>
        
        <div style="margin-top: 20px;">
            <button style="background: #22c55e; color: white; border: none; padding: 10px 20px; border-radius: 8px; font-weight: 600; cursor: pointer;">
                <i class="fa-solid fa-file-excel"></i> Export Excel
            </button>
            <button style="background: #ef4444; color: white; border: none; padding: 10px 20px; border-radius: 8px; font-weight: 600; cursor: pointer; margin-left: 8px;">
                <i class="fa-solid fa-file-pdf"></i> Cetak PDF
            </button>
        </div>
    </div>
</div>

<div style="display:grid; grid-template-columns: repeat(4, 1fr); gap:20px; margin-bottom: 32px;">
    
    <div class="card" style="background: linear-gradient(135deg, #f97316, #fb923c); color: white;">
        <div style="display: flex; justify-content: space-between; align-items: flex-start;">
            <div>
                <div style="font-size: 14px; opacity: 0.9;">Total Omzet</div>
                <div style="font-size: 24px; font-weight: 700; margin-top: 8px;">Rp 0</div>
            </div>
            <i class="fa-solid fa-money-bill-trend-up" style="font-size: 24px; opacity: 0.5;"></i>
        </div>
    </div>

    <div class="card">
        <div style="display: flex; justify-content: space-between; align-items: flex-start;">
            <div>
                <div style="font-size: 14px; color: #6b7280;">Total Transaksi</div>
                <div style="font-size: 24px; font-weight: 700; margin-top: 8px; color: #1f2937;">0</div>
            </div>
            <i class="fa-solid fa-receipt" style="font-size: 24px; color: #f97316; opacity: 0.3;"></i>
        </div>
    </div>

    <div class="card">
        <div style="display: flex; justify-content: space-between; align-items: flex-start;">
            <div>
                <div style="font-size: 14px; color: #6b7280;">Rata-rata/Order</div>
                <div style="font-size: 24px; font-weight: 700; margin-top: 8px; color: #1f2937;">Rp 0</div>
            </div>
            <i class="fa-solid fa-calculator" style="font-size: 24px; color: #f97316; opacity: 0.3;"></i>
        </div>
    </div>

    <div class="card">
        <div style="display: flex; justify-content: space-between; align-items: flex-start;">
            <div>
                <div style="font-size: 14px; color: #6b7280;">Berat Total (Kg)</div>
                <div style="font-size: 24px; font-weight: 700; margin-top: 8px; color: #1f2937;">0 Kg</div>
            </div>
            <i class="fa-solid fa-weight-hanging" style="font-size: 24px; color: #f97316; opacity: 0.3;"></i>
        </div>
    </div>
</div>

<h3 style="font-weight:600; margin-bottom: 20px;">Detail Laporan Transaksi</h3>
<div class="card" style="padding: 0; overflow: hidden;">
    <table class="table" style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr style="text-align: left; background: #f8fafc; border-bottom: 1px solid #e2e8f0;">
                <th style="padding: 15px; color: #64748b; font-weight: 600;">Tanggal</th>
                <th style="color: #64748b; font-weight: 600;">No. Transaksi</th>
                <th style="color: #64748b; font-weight: 600;">Pelanggan</th>
                <th style="color: #64748b; font-weight: 600;">Layanan</th>
                <th style="color: #64748b; font-weight: 600;">Berat/Qty</th>
                <th style="color: #64748b; font-weight: 600;">Total Harga</th>
                <th style="color: #64748b; font-weight: 600;">Status Bayar</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td colspan="7" style="text-align:center; padding: 60px; color: #9ca3af;">
                    <i class="fa-solid fa-chart-line" style="font-size: 48px; margin-bottom: 15px; display: block; opacity: 0.5;"></i>
                    <span style="font-size: 14px;">Silakan pilih filter tanggal untuk melihat laporan</span>
                </td>
            </tr>
        </tbody>
    </table>
</div>

@endsection