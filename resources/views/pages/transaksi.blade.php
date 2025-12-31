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
                <label style="display:block; margin-bottom:5px;">Jenis Layanan</label>
                <select id="jenisLayanan" name="service_type" class="form-input" style="width:100%; padding:10px; border-radius:8px; border:1px solid #ddd;" required>
                    <option value="kg">Cuci Kiloan (Kg)</option>
                    <option value="pcs">Cuci Satuan (Pcs)</option>
                </select>
            </div>

            <div style="display: flex; gap: 12px; margin-bottom:15px;">
                <div class="form-group" style="flex: 1;">
                    <label id="labelInput">Berat (Kg)</label>
                    {{-- Dropdown untuk KG --}}
                    <select name="qty_kg" class="form-input" id="beratDropdown" style="width:100%; padding:10px; border-radius:8px; border:1px solid #ddd;">
                        <option value="">Pilih Berat</option>
                        <option value="4">4 kg</option>
                        <option value="7">7 kg</option>
                        <option value="9">9 kg</option>
                        <option value="12">12 kg</option>
                        <option value="15">15 kg</option>
                        <option value="20">20 kg</option>
                    </select>
                    {{-- Input manual untuk PCS --}}
                    <input type="number" name="qty_pcs" class="form-input" id="beratBebas" placeholder="Masukan jumlah pcs..." style="display: none; width:100%; padding:10px; border-radius:8px; border:1px solid #ddd;">
                </div>
                
                <div class="form-group" style="flex: 1;">
                    <label>Total Harga</label>
                    <input type="text" id="hargaOtomatis" class="form-input" style="width:100%; padding:10px; border-radius:8px; border:1px solid #ddd; background:#f3f4f6;" readonly placeholder="Rp 0">
                    <input type="hidden" name="total_price" id="totalPriceHidden">
                </div>
            </div>

            <div class="form-group" style="margin-bottom:20px;">
                <label style="display:block; margin-bottom:5px;">Status</label>
                <input type="text" name="status" class="form-input" style="width:100%; padding:10px; border-radius:8px; border:1px solid #ddd; background:#f3f4f6;" value="Menunggu" readonly>
            </div>

            <button type="submit" style="width:100%; background:#f97316; color:#fff; border:none; padding:12px; border-radius:10px; font-weight:600; cursor:pointer;">
                Simpan Transaksi
            </button>
        </form>
    </div>
</div>

{{-- DAFTAR TRANSAKSI --}}
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
    
    const jenisLayanan = document.getElementById('jenisLayanan');
    const beratDropdown = document.getElementById('beratDropdown');
    const beratBebas = document.getElementById('beratBebas');
    const hargaOtomatis = document.getElementById('hargaOtomatis');
    const totalPriceHidden = document.getElementById('totalPriceHidden');
    const labelInput = document.getElementById('labelInput');

    btnTambah.onclick = () => modal.style.display = 'flex';
    btnClose.onclick = () => modal.style.display = 'none';

    // Harga paket Kiloan
    const priceKg = { "4": 28000, "7": 45000, "9": 60000, "12": 80000, "15": 100000, "20": 130000 };
    // Harga per PCS
    const HARGA_PER_PCS = 15000;

    function updateTampilanDanHarga() {
        const jenis = jenisLayanan.value;
        let total = 0;
        
        if (jenis === 'kg') {
            labelInput.innerText = "Berat (Kg)";
            beratDropdown.style.display = 'block';
            beratBebas.style.display = 'none';
            
            // Reset input PCS agar tidak dikirim ke server saat pilih KG
            beratBebas.value = ""; 
            total = priceKg[beratDropdown.value] || 0;
        } else {
            labelInput.innerText = "Jumlah (Pcs)";
            beratDropdown.style.display = 'none';
            beratBebas.style.display = 'block';
            
            // Reset dropdown KG agar tidak dikirim ke server saat pilih PCS
            beratDropdown.value = "";
            total = (parseFloat(beratBebas.value) || 0) * HARGA_PER_PCS;
        }

        hargaOtomatis.value = total ? "Rp " + total.toLocaleString('id-ID') : "Rp 0";
        totalPriceHidden.value = total;
    }

    // Jalankan fungsi setiap ada perubahan
    jenisLayanan.onchange = updateTampilanDanHarga;
    beratDropdown.onchange = updateTampilanDanHarga;
    beratBebas.oninput = updateTampilanDanHarga;

    // Tutup modal jika klik di luar area modal
    window.onclick = (event) => {
        if (event.target == modal) modal.style.display = "none";
    }
</script>

@endsection