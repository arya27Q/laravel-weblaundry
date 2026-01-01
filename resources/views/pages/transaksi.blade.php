@extends('layouts.dashboard')

@section('title', 'Transaksi')

@section('content')

<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:32px;">
    <h2 style="font-size:22px; font-weight:600;">Data Transaksi</h2>

    <button class="btn-primary" id="btnTambahTransaksi" style="background:#f97316; color:#fff; border:none; padding:12px 20px; border-radius:10px; font-weight:600; cursor:pointer;">
        + Tambah Transaksi
    </button>
</div>

{{-- MODAL TRANSAKSI --}}
<div id="modalTransaksi" class="modal-overlay" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); justify-content:center; align-items:center; z-index:1000;">
    <div class="modal-content" style="background:#fff; padding:30px; border-radius:15px; width:500px; position:relative;">
        <button id="btnCloseModal" style="position:absolute; top:15px; right:15px; border:none; background:none; font-size:20px; cursor:pointer;">✕</button>
        <h3 style="margin-bottom: 20px; font-weight: 700;">Buat Transaksi Baru</h3>
        
        <form id="formTransaksi" action="{{ route('transaksi.store') }}" method="POST">
            @csrf
            <div class="form-group" style="margin-bottom:15px;">
                <label style="display:block; margin-bottom:5px;">Pilih Pelanggan</label>
                <select name="customer_id" class="form-input" style="width:100%; padding:10px; border-radius:8px; border:1px solid #ddd;" required>
                    <option value="">-- Pilih Pelanggan --</option>
                    @foreach($customers as $c)
                        <option value="{{ $c->id }}">{{ $c->name }} ({{ $c->phone }})</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group" style="margin-bottom:15px;">
                <label style="display:block; margin-bottom:5px;">Pilih Layanan</label>
                {{-- Dropdown Layanan Dinamis dari Database --}}
                <select id="service_id" name="service_id" class="form-input" style="width:100%; padding:10px; border-radius:8px; border:1px solid #ddd;" required>
                    <option value="" data-price="0" data-unit="">-- Pilih Layanan --</option>
                    @foreach($services as $s)
                        <option value="{{ $s->id }}" data-price="{{ $s->price }}" data-unit="{{ $s->unit }}">
                            {{ $s->service_name }} (Rp {{ number_format($s->price, 0, ',', '.') }}/{{ $s->unit }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div style="display: flex; gap: 12px; margin-bottom:15px;">
                <div class="form-group" style="flex: 1;">
                    <label id="labelInput">Jumlah/Berat</label>
                    {{-- Satu input qty untuk semua jenis layanan --}}
                    <input type="number" step="0.01" name="qty" class="form-input" id="inputQty" placeholder="0" style="width:100%; padding:10px; border-radius:8px; border:1px solid #ddd;" required>
                </div>
                
                <div class="form-group" style="flex: 1;">
                    <label>Total Harga</label>
                    <input type="text" id="hargaOtomatis" class="form-input" style="width:100%; padding:10px; border-radius:8px; border:1px solid #ddd; background:#f3f4f6; font-weight: bold; color: #f97316;" readonly placeholder="Rp 0">
                    <input type="hidden" name="total_price" id="totalPriceHidden">
                </div>
            </div>

            <div class="form-group" style="margin-bottom:20px;">
                <label style="display:block; margin-bottom:5px;">Status</label>
                <input type="text" class="form-input" style="width:100%; padding:10px; border-radius:8px; border:1px solid #ddd; background:#f3f4f6;" value="Menunggu" readonly>
            </div>

            <button type="submit" style="width:100%; background:#f97316; color:#fff; border:none; padding:12px; border-radius:10px; font-weight:600; cursor:pointer;">
                Simpan Transaksi
            </button>
        </form>
    </div>
</div>

<h3 style="font-weight:600; margin-bottom:16px;">Daftar Transaksi</h3>
<div class="card" style="background:#fff; padding:20px; border-radius:12px; border:1px solid #eee;">
    <table style="width:100%; border-collapse: collapse;">
        <thead>
            <tr style="text-align:left; border-bottom:1px solid #eee;">
                <th style="padding:12px;">Kode</th>
                <th>Pelanggan</th>
                <th>Tanggal</th>
                <th>Status</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @forelse($transactions as $t)
            <tr style="border-bottom:1px solid #eee;">
                <td style="padding:12px;">{{ $t->invoice_code }}</td>
                <td>{{ $t->customer->name ?? 'N/A' }}</td>
                <td>{{ $t->created_at->format('d/m/Y') }}</td>
                <td>
                    <span style="padding:4px 8px; border-radius:6px; font-size:12px; background:#fef3c7; color:#92400e;">
                        {{ $t->status_order }}
                    </span>
                </td>
                <td><strong>Rp {{ number_format($t->total_price, 0, ',', '.') }}</strong></td>
            </tr>
            @empty
            <tr>
                <td colspan="5" style="text-align:center; padding:20px; color:#999;">Belum ada data transaksi</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<script>
    const modal = document.getElementById('modalTransaksi');
    const btnTambah = document.getElementById('btnTambahTransaksi');
    const btnClose = document.getElementById('btnCloseModal');
    
    const serviceSelect = document.getElementById('service_id');
    const inputQty = document.getElementById('inputQty');
    const hargaOtomatis = document.getElementById('hargaOtomatis');
    const totalPriceHidden = document.getElementById('totalPriceHidden');
    const labelInput = document.getElementById('labelInput');

    btnTambah.onclick = () => modal.style.display = 'flex';
    btnClose.onclick = () => modal.style.display = 'none';

    function hitungTotalOtomatis() {
        const selectedOption = serviceSelect.options[serviceSelect.selectedIndex];
        const hargaSatuan = parseFloat(selectedOption.getAttribute('data-price')) || 0;
        const unit = selectedOption.getAttribute('data-unit') || "";
        const qty = parseFloat(inputQty.value) || 0;

        if(unit !== "") {
            labelInput.innerText = unit === "Kg" ? "Berat (Kg)" : "Jumlah (Pcs)";
        }

        const total = hargaSatuan * qty;

      
        hargaOtomatis.value = total ? "Rp " + total.toLocaleString('id-ID') : "Rp 0";
        totalPriceHidden.value = total;
    }

    
    serviceSelect.onchange = hitungTotalOtomatis;
    inputQty.oninput = hitungTotalOtomatis;

    window.onclick = (event) => {
        if (event.target == modal) modal.style.display = "none";
    }
</script>

@endsection