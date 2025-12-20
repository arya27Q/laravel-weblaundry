@extends('layouts.dashboard')

@section('title', 'Transaksi')

@section('content')


  

<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:32px; ">
    <h2 style="font-size:22px; font-weight:600;">Data Transaksi</h2>

    <button class="btn-primary" id="btnTambahTransaksi">
        + Tambah Transaksi
    </button>
</div>

<div id="modalTransaksi" class="modal-overlay">
    <div class="modal-content">
        <button id="btnCloseModal">✕</button>
        <h3 style="margin-bottom: 20px; font-weight: 700;">Buat Transaksi Baru</h3>
        
        <form id="formTransaksi">
            <div class="form-group">
                <label>Nama Pelanggan</label>
                <select class="form-input" required>
                    <option value="">-- Pilih Pelanggan --</option>
                    <option>Budi Santoso</option>
                    <option>Siti Aminah</option>
                </select>
            </div>

            <div class="form-group">
                <label>Tanggal Masuk</label>
                <input type="date" class="form-input" required value="{{ date('Y-m-d') }}">
            </div>

            <div style="display: flex; gap: 12px;">
                <div class="form-group" style="flex: 1;">
                    <label>Berat (Kg)</label>
                    <select class="form-input" id="beratInput" required>
                        <option value="">Pilih Berat</option>
                        <option value="4">4 kg</option>
                        <option value="7">7 kg</option>
                        <option value="9">9 kg</option>
                        <option value="12">12 kg</option>
                        <option value="15">15 kg</option>
                        <option value="20">20 kg</option>
                    </select>
                </div>
                <div class="form-group" style="flex: 1;">
                    <label>Harga (Otomatis)</label>
                    <input type="text" id="hargaOtomatis" class="form-input input-readonly" readonly placeholder="Rp 0">
                </div>
            </div>

            <div class="form-group">
                <label>Status</label>
                <input type="text" class="form-input input-readonly" value="Menunggu" readonly>
            </div>

            <button type="submit" style="width:100%; background:#f97316; color:#fff; border:none; padding:12px; border-radius:10px; font-weight:600; cursor:pointer;">
                Simpan Transaksi
            </button>
        </form>
    </div>
</div>

<div class="card" style="margin-bottom:32px;">
    <div class="filter-grid">
        <div class="input-icon">
            <i class="fa-solid fa-magnifying-glass"></i>
            <input type="text" placeholder="Cari pelanggan..." class="input with-icon">
        </div>
        <select class="input">
            <option value="">Status</option>
            <option>Menunggu</option>
            <option>Dicuci</option>
            <option>Disetrika</option>
            <option>Selesai</option>
        </select>
        <div class="input-icon">
            <i class="fa-regular fa-calendar"></i>
            <input type="date" class="input with-icon">
        </div>
        <button class="btn-secondary btn-click">
            <i class="fa-solid fa-filter" style="margin-right:6px;"></i>
            Filter
        </button>
    </div>
</div>

<div style="display:grid; grid-template-columns: repeat(4, 1fr); gap:24px; margin-bottom:40px;">
    <div class="card">
        <div class="card-title"><i class="fa-solid fa-receipt icon orange"></i> Total Transaksi</div>
        <div class="card-value">0</div>
    </div>
    <div class="card">
        <div class="card-title"><i class="fa-solid fa-clock icon warning"></i> Belum Selesai</div>
        <div class="card-value">0</div>
    </div>
    <div class="card">
        <div class="card-title"><i class="fa-solid fa-circle-check icon success"></i> Selesai</div>
        <div class="card-value">0</div>
    </div>
    <div class="card">
        <div class="card-title"><i class="fa-solid fa-wallet icon green"></i> Pendapatan</div>
        <div class="card-value">Rp 0</div>
    </div>
</div>

<h3 style="font-weight:600; margin-left:7px;">Daftar Transaksi</h3>
<div class="card">
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

<script>
    const modal = document.getElementById('modalTransaksi');
    const btnTambah = document.getElementById('btnTambahTransaksi');
    const btnClose = document.getElementById('btnCloseModal');
    const beratInput = document.getElementById('beratInput');
    const hargaOtomatis = document.getElementById('hargaOtomatis');

    
    btnTambah.onclick = () => modal.style.display = 'flex';
    btnClose.onclick = () => modal.style.display = 'none';
    window.onclick = (event) => { if (event.target == modal) modal.style.display = 'none'; }


    const priceMapping = { "4": 5000, "7": 8000, "9": 11000, "12": 15000, "15": 18000, "20": 25000 };

    beratInput.onchange = function() {
        const val = this.value;
        const total = priceMapping[val] || 0;
        hargaOtomatis.value = total ? "Rp " + total.toLocaleString('id-ID') : "Rp 0";
    };
</script>

@endsection