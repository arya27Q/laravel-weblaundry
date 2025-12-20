@extends('layouts.dashboard')

@section('title', 'Pelanggan')

@section('content')

<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:24px;">
    <h2 style="font-size:24px; font-weight:700; color: #1f2937;">Data Pelanggan</h2>

    <button id="btnShowForm" style="
        background:#f97316;
        color:#fff;
        border:none;
        padding:15px 20px;
        border-radius:10px;
        cursor:pointer;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 8px;
    ">
        <span>+</span> Tambah Pelanggan
    </button>
</div>

<div id="modalOverlay" class="modal-overlay">
    <div class="modal-content">
        <button id="btnCloseForm">✕</button>
        <h3 style="margin-bottom: 24px; font-size: 20px; font-weight: 700;">Tambah Pelanggan Baru</h3>

        <form id="pelangganForm">
            <div class="form-group">
                <label>Nama Lengkap</label>
                <input type="text" id="namaPelanggan" class="form-control" placeholder="Contoh: Budi Santoso" required>
            </div>

            <div class="form-group">
                <label>No. WhatsApp / HP</label>
                <input type="text" id="noHP" class="form-control" placeholder="0812xxxx" required>
            </div>

            <div class="form-group">
                <label>Alamat Lengkap</label>
                <textarea id="alamat" class="form-control" rows="3" placeholder="Jl. Raya No. 123..." required></textarea>
            </div>

            <button type="submit" class="btn-save">Simpan Data Pelanggan</button>
        </form>
    </div>
</div>

<div class="card" style="margin-bottom:24px;">
    <input 
        type="text" 
        placeholder="Cari nama atau nomor HP pelanggan..."
        style="
            width:97%;
            padding:12px 16px;
            border-radius:10px;
            border:1px solid #e5e7eb;
            background: #f9fafb;
        "
    >
</div>
 <h3 style="font-weight:650; color:#1f2937; margin-left:7px;">Daftar Pelanggan</h3>
<div class="card">
    <table class="table">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>No. HP</th>
                <th>Alamat</th>
                <th style="text-align: center;">Aksi</th>
            </tr>
        </thead>
        <tbody id="tableBody">
            <tr id="emptyRow">
                <td colspan="5" style="text-align:center; padding:40px; color:#9ca3af;">
                    <p style="margin-bottom: 0;">Belum ada data pelanggan</p>
                </td>
            </tr>
        </tbody>
    </table>
</div>

<script>
    const btnShowForm = document.getElementById('btnShowForm');
    const btnCloseForm = document.getElementById('btnCloseForm');
    const modalOverlay = document.getElementById('modalOverlay');
    const pelangganForm = document.getElementById('pelangganForm');
    const tableBody = document.getElementById('tableBody');

    btnShowForm.addEventListener('click', () => {
        modalOverlay.style.display = 'flex';
    });

    btnCloseForm.addEventListener('click', () => {
        modalOverlay.style.display = 'none';
    });

    window.addEventListener('click', (e) => {
        if (e.target == modalOverlay) {
            modalOverlay.style.display = 'none';
        }
    });

    pelangganForm.addEventListener('submit', function(e) {
        e.preventDefault();

        const nama = document.getElementById('namaPelanggan').value;
        const noHP = document.getElementById('noHP').value;
        const alamat = document.getElementById('alamat').value;

        const emptyRow = document.getElementById('emptyRow');
        if (emptyRow) emptyRow.remove();

        const rowCount = tableBody.rows.length + 1;
        const row = `
            <tr>
                <td>${rowCount}</td>
                <td><strong>${nama}</strong></td>
                <td>${noHP}</td>
                <td>${alamat}</td>
                <td style="text-align: center;">
                    <button style="background:#fef3c7; color:#d97706; border:none; padding:6px 12px; border-radius:6px; cursor:pointer; font-size:12px; margin-right:4px;">Edit</button>
                    <button style="background:#fee2e2; color:#dc2626; border:none; padding:6px 12px; border-radius:6px; cursor:pointer; font-size:12px;">Hapus</button>
                </td>
            </tr>
        `;
        
        tableBody.insertAdjacentHTML('beforeend', row);

        pelangganForm.reset();
        modalOverlay.style.display = 'none';
    });
</script>
@endsection