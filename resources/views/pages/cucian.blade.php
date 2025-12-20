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

<!-- STATUS CUCIAN PER BERAT -->
<div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap:16px; margin-bottom:40px;">
    @foreach([4,7,9,12,15,20] as $kg)
    <div class="card" style="padding: 16px;">
        <div class="card-title">
            <i class="fa-solid fa-weight-hanging" style="margin-right:6px;"></i>
            {{ $kg }} kg
        </div>
        <div class="card-value">
           <select onchange="updateStatus('{{ $kg }}', this.value)" style="width:100%; padding:6px; border-radius:4px;">
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

<!-- RINGKASAN HARI INI -->
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

<!-- METODE PEMBAYARAN -->
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
function updateStatus(kg, status) {
    fetch(`/cucian/update-status`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ kg: kg, status: status })
    })
    .then(res => res.json())
    .then(data => {
        if(data.success){
            alert('Status ' + kg + ' kg berhasil diubah ke ' + status);
        }
    });
}
</script>

@endsection
