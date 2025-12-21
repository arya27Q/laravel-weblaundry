@extends('layouts.dashboard')

@section('title', 'Cucian')

@section('content')

<h2 style="margin-bottom:24px;">Status Cucian</h2>

@php
    $statusCucian = [
        'Menunggu' => 'fa-clock',
        'Dicuci' => 'fa-soap',
        'Disetrika' => 'fa-shirt',
        'Siap Diambil' => 'fa-box-open',
        'Selesai' => 'fa-circle-check'
    ];
@endphp

<h3 style="margin-bottom:16px; font-size: 16px; color: #64748b;">Layanan Kiloan</h3>
<div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap:16px; margin-bottom:30px;">
    @foreach([4,7,9,12,15,20] as $kg)
    <div class="card" style="padding: 16px; border-top: 4px solid #f97316;">
        <div class="card-title">
            <i class="fa-solid fa-weight-hanging" style="margin-right:6px; color: #f97316;"></i>
            {{ $kg }} kg
        </div>
        <div class="card-value">
           <select onchange="updateStatus('{{ $kg }} kg', this.value)" style="width:100%; padding:6px; border-radius:4px; border: 1px solid #e5e7eb;">
                @foreach($statusCucian as $status => $icon)
                    <option value="{{ $status }}">
                        {{ $status }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>
    @endforeach
</div>

<h3 style="margin-bottom:16px; font-size: 16px; color: #64748b;">Layanan Satuan (Transaksi Aktif)</h3>
<div style="display: flex; gap: 16px; overflow-x: auto; padding-bottom: 15px; margin-bottom: 40px; scrollbar-width: thin;">
    
    @foreach([23, 1, 10] as $pcs)
    <div class="card" style="min-width: 170px; flex-shrink: 0; padding: 16px; border-top: 4px solid #3b82f6;">
        <div class="card-title">
            <i class="fa-solid fa-shirt" style="margin-right:6px; color: #3b82f6;"></i>
            {{ $pcs }} Pcs
        </div>
        <div style="font-size: 11px; color: #94a3b8; margin-bottom: 8px;">Pelanggan: Aktif</div>
        
        <div class="card-value">
           <select onchange="updateStatus('{{ $pcs }} Pcs', this.value)" style="width:100%; padding:6px; border-radius:4px; border: 1px solid #e5e7eb; font-size: 13px;">
                @foreach($statusCucian as $status => $icon)
                    <option value="{{ $status }}">
                        {{ $status }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>
    @endforeach

    @if(false) <div style="color: #94a3b8; font-style: italic; font-size: 13px; padding: 20px;">Tidak ada cucian satuan aktif.</div>
    @endif
</div>

<h3 style="margin-bottom:16px;">Ringkasan Hari Ini</h3>
<div style="display:grid; grid-template-columns: repeat(3, 1fr); gap:24px; margin-bottom:40px;">
    <div class="card">
        <div class="card-title">
            <i class="fa-solid fa-clipboard-list card-icon"></i>
            Total Cucian
        </div>
        <div class="card-value">0</div>
    </div>
    <div class="card">
        <div class="card-title">
            <i class="fa-solid fa-spinner card-icon"></i>
            Cucian Dalam Proses
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

<h3 style="margin-bottom:16px;">Metode Pembayaran</h3>
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
            Non Tunai
        </div>
        <div class="card-value">0</div>
    </div>
</div>

<script>
function updateStatus(label, status) {
    fetch(`/cucian/update-status`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ label: label, status: status })
    })
    .then(res => res.json())
    .then(data => {
        if(data.success){
            alert('Status ' + label + ' berhasil diubah ke ' + status);
        }
    });
}
</script>

@endsection