@extends('layouts.dashboard')

@section('title', 'Pembayaran')

@section('content')

<div style="display:grid; grid-template-columns: repeat(3, 1fr); gap:24px; margin-bottom: 40px;">
    <div class="card">
        <div class="card-title">
            <i class="fa-solid fa-wallet card-icon"></i>
            Total Tagihan
        </div>
        <div class="card-value">Rp 0</div>
    </div>

    <div class="card" style="border-left: 5px solid #ef4444;">
        <div class="card-title">
            <i class="fa-solid fa-hand-holding-dollar card-icon" style="color: #ef4444;"></i>
            Belum Bayar
        </div>
        <div class="card-value" style="color: #ef4444;">0</div>
    </div>

    <div class="card" style="border-left: 5px solid #22c55e;">
        <div class="card-title">
            <i class="fa-solid fa-circle-check card-icon" style="color: #22c55e;"></i>
            Sudah Lunas
        </div>
        <div class="card-value" style="color: #22c55e;">0</div>
    </div>
</div>

<div class="card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h3 style="font-weight:600;">Riwayat Pembayaran</h3>
        <button style="background: #f97316; color: white; border: none; padding: 10px 20px; border-radius: 8px; font-weight: 600; cursor: pointer;">
            <i class="fa-solid fa-plus"></i> Catat Bayar
        </button>
    </div>

    <table class="table">
        <thead>
            <tr style="text-align: left; border-bottom: 2px solid #f3f4f6;">
                <th style="padding: 12px;">No. Transaksi</th>
                <th>Pelanggan</th>
                <th>Tanggal</th>
                <th>Metode</th>
                <th>Total Tagihan</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td colspan="7" style="text-align:center; color:#999; padding:40px;">
                    <i class="fa-solid fa-folder-open" style="font-size: 40px; display: block; margin-bottom: 10px;"></i>
                    Belum ada data pembayaran
                </td>
            </tr>
        </tbody>
    </table>
</div>

<div id="modalBayar" class="modal-overlay" style="display: none;">
    <div class="modal-content">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h3 style="font-weight:700; color: #1f2937;">Catat Pembayaran Baru</h3>
            <i class="fa-solid fa-xmark" id="closeModal" style="cursor:pointer; color: #9ca3af; font-size: 20px;"></i>
        </div>

        <form action="#">
            <div class="form-group" style="margin-bottom: 15px; text-align: left;">
                <label style="display:block; font-size: 14px; font-weight:600; margin-bottom: 5px;">Pilih Transaksi / Pelanggan</label>
                <select class="form-control" style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #ddd;">
                    <option value="">-- Cari No. Transaksi --</option>
                    <option value="1">TRX-001 - Budi (Rp 50.000)</option>
                    <option value="2">TRX-002 - Ani (Rp 35.000)</option>
                </select>
            </div>

            <div class="form-group" style="margin-bottom: 15px; text-align: left;">
                <label style="display:block; font-size: 14px; font-weight:600; margin-bottom: 5px;">Jumlah Bayar (Rp)</label>
                <input type="number" class="form-control" placeholder="Masukkan nominal" style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #ddd;">
            </div>

            <div class="form-group" style="margin-bottom: 20px; text-align: left;">
                <label style="display:block; font-size: 14px; font-weight:600; margin-bottom: 5px;">Metode Pembayaran</label>
                <div style="display: flex; gap: 10px;">
                    <label style="flex:1; border: 1px solid #dcd6d6ff; padding: 10px; border-radius: 8px; cursor: pointer; text-align: center;">
                        <input type="radio" name="metode" value="cash" checked> Cash
                    </label>
                    <label style="flex:1; border: 1px solid #dbd4d4ff; padding: 10px; border-radius: 8px; cursor: pointer; text-align: center;">
                        <input type="radio" name="metode" value="qris"> Non-Tunai
                    </label>
                </div>
            </div>

            <button type="submit" style="width: 100%; background: #f97316; color: white; border: none; padding: 12px; border-radius: 8px; font-weight: 700; cursor: pointer;">
                Konfirmasi Pembayaran
            </button>
        </form>
    </div>
</div>

<script>
    const modal = document.getElementById('modalBayar');
    const btnOpen = document.querySelector('button[style*="background: #f97316"]'); // Tombol Catat Bayar
    const btnClose = document.getElementById('closeModal');

    // Buka Modal
    btnOpen.onclick = function() {
        modal.style.display = 'flex';
    }

    // Tutup Modal (Klik X)
    btnClose.onclick = function() {
        modal.style.display = 'none';
    }

    // Tutup Modal (Klik di luar kotak)
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = 'none';
        }
    }
</script>
@endsection