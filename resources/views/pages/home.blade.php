@extends('layouts.dashboard')

@section('title', 'Dashboard')

@section('content')

<div style="display:grid; grid-template-columns: repeat(4, 1fr); gap:24px;">
    <div class="card">
        <div class="card-title">
            <i class="fa-solid fa-users card-icon"></i> Pelanggan
        </div>
        <div class="card-value">{{ number_format($total_pelanggan ?? 0) }}</div>
    </div>

    <div class="card">
        <div class="card-title">
            <i class="fa-solid fa-receipt card-icon"></i> Transaksi
        </div>
        <div class="card-value">{{ number_format($total_transaksi ?? 0) }}</div>
    </div>

    <div class="card">
        <div class="card-title">
            <i class="fa-solid fa-money-bill-wave card-icon"></i> Pendapatan
        </div>
        <div class="card-value">Rp {{ number_format($pendapatan_total ?? 0, 0, ',', '.') }}</div>
    </div>

    <div class="card">
        <div class="card-title">
            <i class="fa-solid fa-spinner card-icon"></i> Dalam Proses
        </div>
        <div class="card-value">{{ $cucian_proses ?? 0 }}</div>
    </div>
</div>

<div class="card" style="margin-top:40px;">
    <h3 style="font-weight:600; margin-bottom:16px;">Aktivitas Terbaru</h3>
    <table class="table" style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr style="text-align: left; border-bottom: 1px solid #eee;">
                <th style="padding: 12px;">Pelanggan</th>
                <th style="padding: 12px;">Status</th>
                <th style="padding: 12px;">Total</th>
            </tr>
        </thead>
        <tbody>
            @forelse($transaksi_terbaru ?? [] as $ts)
            <tr style="border-bottom: 1px solid #fafafa;">
                <td style="padding: 12px;">{{ $ts->customer->name ?? 'Umum' }}</td>
                <td style="padding: 12px;">
                    <span class="badge" style="background: #fef3c7; color: #92400e; padding: 4px 10px; border-radius: 20px; font-size: 11px;">
                        {{ $ts->status_order }}
                    </span>
                </td>
                <td style="padding: 12px;">Rp {{ number_format($ts->total_price, 0, ',', '.') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="3" style="text-align:center; color:#999; padding:20px;">Belum ada transaksi terbaru</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<h3 style="margin:40px 0 16px; font-weight:600;">Status Cucian</h3>
<div style="display:grid; grid-template-columns: repeat(5, 1fr); gap:16px;">
    @php
        $statuses = [
            ['Menunggu', 'fa-clock'], ['Dicuci', 'fa-soap'], ['Disetrika', 'fa-shirt'], 
            ['Siap Diambil', 'fa-box-open'], ['Selesai', 'fa-circle-check']
        ];
    @endphp
    @foreach($statuses as $st)
    <div class="card">
        <div class="card-title">
            <i class="fa-solid {{ $st[1] }} card-icon"></i> {{ $st[0] }}
        </div>
        <div class="card-value">{{ $status_counts[$st[0]] ?? 0 }}</div>
    </div>
    @endforeach
</div>

<h3 style="margin:40px 0 16px; font-weight:600;">Ringkasan Hari Ini</h3>
<div style="display:grid; grid-template-columns: repeat(2, 1fr); gap:24px;">
    <div class="card">
        <div class="card-title"><i class="fa-solid fa-calendar-day card-icon"></i> Transaksi Hari Ini</div>
        <div class="card-value">{{ $transaksi_hari_ini ?? 0 }}</div>
    </div>
    <div class="card">
        <div class="card-title"><i class="fa-solid fa-coins card-icon"></i> Pendapatan Hari Ini</div>
        <div class="card-value">Rp {{ number_format($pendapatan_hari_ini ?? 0, 0, ',', '.') }}</div>
    </div>
</div>

<h3 style="margin:40px 0 16px; font-weight:600;">Metode Pembayaran</h3>
<div style="display:grid; grid-template-columns: repeat(2, 1fr); gap:24px;">
    <div class="card">
        <div class="card-title"><i class="fa-solid fa-money-bill card-icon"></i> Cash</div>
        <div class="card-value">{{ $pembayaran_counts['Cash'] ?? 0 }}</div>
    </div>
    <div class="card">
        <div class="card-title"><i class="fa-solid fa-credit-card card-icon"></i> Non Tunai</div>
        <div class="card-value">{{ ($pembayaran_counts['Transfer'] ?? 0) + ($pembayaran_counts['QRIS'] ?? 0) }}</div>
    </div>
</div>

<h3 style="margin:40px 0 16px; font-weight:600;">Statistik Pendapatan Mingguan</h3>
<div class="card" style="padding: 24px; margin-bottom: 32px;">
    <canvas id="incomeChart" style="width: 100%; max-height: 300px;"></canvas>
</div>

<h3 style="margin:40px 0 16px; font-weight:600;">Statistik Pendapatan Bulanan </h3>
<div class="card" style="padding: 24px; margin-bottom: 40px;">
    <canvas id="monthlyChart" style="width: 100%; max-height: 300px;"></canvas>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    
    const wData = JSON.parse('{!! json_encode($chart_weekly_data ?? [0,0,0,0,0,0,0]) !!}');
    const mData = JSON.parse('{!! json_encode($chart_monthly_data ?? array_fill(0, 12, 0)) !!}');

    const ctxW = document.getElementById('incomeChart').getContext('2d');
    new Chart(ctxW, {
        type: 'line',
        data: {
            labels: ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'],
            datasets: [{
                label: 'Pendapatan',
                data: wData,
                backgroundColor: 'rgba(249, 115, 22, 0.2)',
                borderColor: '#f97316',
                borderWidth: 3,
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            plugins: { legend: { display: false } },
            scales: { y: { beginAtZero: true } }
        }
    });

    const ctxM = document.getElementById('monthlyChart').getContext('2d');
    new Chart(ctxM, {
        type: 'bar', 
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
            datasets: [{
                label: 'Pendapatan',
                data: mData,
                backgroundColor: '#f97316',
                borderRadius: 8
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(v) { return 'Rp ' + v.toLocaleString('id-ID'); }
                    }
                }
            }
        }
    });
</script>
@endsection