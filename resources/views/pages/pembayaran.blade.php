@extends('layouts.dashboard')

@section('title', 'Pembayaran')

@section('content')

{{-- STATISTIC CARDS --}}
<div style="display:grid; grid-template-columns: repeat(3, 1fr); gap:24px; margin-bottom: 40px;">
    <div class="card">
        <div class="card-title">
            <i class="fa-solid fa-wallet card-icon"></i>
            Total Tagihan (Belum Bayar)
        </div>
        <div class="card-value">Rp {{ number_format($totalTagihan ?? 0, 0, ',', '.') }}</div>
    </div>

    <div class="card" style="border-left: 5px solid #ef4444;">
        <div class="card-title">
            <i class="fa-solid fa-hand-holding-dollar card-icon" style="color: #ef4444;"></i>
            Belum Bayar
        </div>
        <div class="card-value" style="color: #ef4444;">{{ $belumBayar ?? 0 }}</div>
    </div>

    <div class="card" style="border-left: 5px solid #22c55e;">
        <div class="card-title">
            <i class="fa-solid fa-circle-check card-icon" style="color: #22c55e;"></i>
            Sudah Lunas
        </div>
        <div class="card-value" style="color: #22c55e;">{{ $sudahLunas ?? 0 }}</div>
    </div>
</div>

{{-- HEADER TABEL --}}
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <h3 style="font-weight:600; margin: 0; color: #1f2937;">Riwayat Pembayaran</h3>
    <button id="btnCatatBayar" style="background: #f97316; color: white; border: none; padding: 10px 20px; border-radius: 8px; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 8px;">
        <i class="fa-solid fa-plus"></i> Catat Bayar
    </button>
</div>

{{-- TABEL DATA --}}
<div class="card" style="padding: 0; overflow: hidden;">
    <table class="table" style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr style="text-align: left; background: #f8fafc; border-bottom: 1px solid #e2e8f0;">
                <th style="padding: 15px 20px; color: #64748b; font-size: 14px;">No. Transaksi</th>
                <th style="padding: 15px 20px; color: #64748b; font-size: 14px;">Pelanggan</th>
                <th style="padding: 15px 20px; color: #64748b; font-size: 14px;">Tanggal</th>
                <th style="padding: 15px 20px; color: #64748b; font-size: 14px;">Metode</th>
                <th style="padding: 15px 20px; color: #64748b; font-size: 14px;">Total Tagihan</th>
                <th style="padding: 15px 20px; color: #64748b; font-size: 14px;">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($transactions ?? [] as $t)
            <tr style="border-bottom: 1px solid #f1f5f9;">
                <td style="padding: 15px 20px; font-weight: 600;">{{ $t->invoice_code }}</td>
                <td style="padding: 15px 20px;">{{ $t->customer->name ?? 'N/A' }}</td>
                <td style="padding: 15px 20px;">{{ $t->created_at->format('d/m/Y') }}</td>
                <td style="padding: 15px 20px;">{{ $t->payment_method ?? '-' }}</td>
                <td style="padding: 15px 20px;">Rp {{ number_format($t->total_price, 0, ',', '.') }}</td>
                <td style="padding: 15px 20px;">
                    <span style="padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 600; {{ $t->payment_status == 'Lunas' ? 'background:#dcfce7; color:#15803d;' : 'background:#fee2e2; color:#b91c1c;' }}">
                        {{ $t->payment_status }}
                    </span>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align:center; color:#94a3b8; padding: 60px 20px;">
                    <i class="fa-solid fa-folder-open" style="font-size: 48px; display: block; margin-bottom: 15px; opacity: 0.3;"></i>
                    <span style="font-size: 14px;">Belum ada data pembayaran untuk ditampilkan</span>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- MODAL BAYAR --}}
<div id="modalBayar" class="modal-overlay" style="display: none;">
    <div class="modal-content">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h3 style="font-weight:700; color: #1f2937;">Konfirmasi Pembayaran</h3>
            <i class="fa-solid fa-xmark" id="closeModal" style="cursor:pointer; color: #9ca3af; font-size: 20px;"></i>
        </div>

        <form action="{{ route('pembayaran.update') }}" method="POST">
            @csrf
            <div class="form-group" style="margin-bottom: 15px; text-align: left;">
                <label style="display:block; font-size: 14px; font-weight:600; margin-bottom: 5px;">Pilih Transaksi (Belum Bayar)</label>
                <select name="transaction_id" class="form-control" style="width: 100%; padding: 12px; border-radius: 8px; border: 1px solid #ddd;" required>
                    <option value="">-- Cari No. Transaksi --</option>
                    @foreach(($transactions ?? collect())->where('payment_status', 'Belum Bayar') as $trx)
                        <option value="{{ $trx->id }}">{{ $trx->invoice_code }} - {{ $trx->customer->name }} (Rp {{ number_format($trx->total_price, 0, ',', '.') }})</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group" style="margin-bottom: 25px; text-align: left;">
                <label style="display:block; font-size: 14px; font-weight:600; margin-bottom: 10px;">Metode Pembayaran</label>
                <div style="display: flex; gap: 12px;">
                    <label style="flex:1; border: 1px solid #ddd; padding: 12px; border-radius: 8px; cursor: pointer; text-align: center; display: flex; align-items: center; justify-content: center; gap: 8px;">
                        <input type="radio" name="payment_method" value="Cash" checked> 
                        <span>Cash</span>
                    </label>
                    <label style="flex:1; border: 1px solid #ddd; padding: 12px; border-radius: 8px; cursor: pointer; text-align: center; display: flex; align-items: center; justify-content: center; gap: 8px;">
                        <input type="radio" name="payment_method" value="QRIS"> 
                        <span>Non-Tunai</span>
                    </label>
                </div>
            </div>

            <button type="submit" style="width: 100%; background: #f97316; color: white; border: none; padding: 14px; border-radius: 8px; font-weight: 700; cursor: pointer; font-size: 15px;">
                Konfirmasi Pembayaran
            </button>
        </form>
    </div>
</div>

<style>
    .modal-overlay {
        position: fixed; top: 0; left: 0; width: 100%; height: 100%;
        background: rgba(0,0,0,0.4); display: none; justify-content: center; align-items: center;
        z-index: 9999; backdrop-filter: blur(4px);
    }
    .modal-content {
        background: white; padding: 32px; border-radius: 20px; width: 90%; max-width: 450px;
        box-shadow: 0 25px 50px -12px rgba(0,0,0,0.25); animation: modalFadeIn 0.3s ease-out;
    }
    @keyframes modalFadeIn {
        from { transform: translateY(-20px); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    }
</style>

<script>
    const modal = document.getElementById('modalBayar');
    const btnOpen = document.getElementById('btnCatatBayar');
    const btnClose = document.getElementById('closeModal');

    btnOpen.onclick = () => { modal.style.display = 'flex'; document.body.style.overflow = 'hidden'; }
    btnClose.onclick = () => { modal.style.display = 'none'; document.body.style.overflow = 'auto'; }
    window.onclick = (e) => { if (e.target == modal) { modal.style.display = 'none'; document.body.style.overflow = 'auto'; } }
</script>
@endsection