<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Keuangan - Laundry Jaya</title>
    <style>
        * { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; box-sizing: border-box; }
        body { padding: 40px; color: #334155; line-height: 1.5; background: #fff; }
        
        /* Header Style */
        .header { display: flex; justify-content: space-between; align-items: flex-start; border-bottom: 3px solid #f1f5f9; padding-bottom: 20px; margin-bottom: 30px; }
        .brand h1 { margin: 0; color: #f97316; font-size: 28px; letter-spacing: -1px; }
        .brand p { margin: 5px 0 0; color: #64748b; font-size: 14px; }
        .report-info { text-align: right; }
        .report-info h2 { margin: 0; font-size: 18px; color: #1e293b; }
        .report-info p { margin: 5px 0 0; font-size: 13px; color: #64748b; }

        /* Statistics Summary */
        .summary-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px; margin-bottom: 30px; }
        .summary-box { padding: 15px; background: #f8fafc; border-radius: 8px; border: 1px solid #e2e8f0; }
        .summary-box label { display: block; font-size: 12px; color: #64748b; text-transform: uppercase; font-weight: bold; }
        .summary-box span { font-size: 20px; font-weight: 700; color: #0f172a; }

        /* Table Style */
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th { background-color: #f1f5f9; color: #475569; font-weight: 600; font-size: 12px; text-transform: uppercase; padding: 12px 15px; text-align: left; border: 1px solid #e2e8f0; }
        td { padding: 12px 15px; border: 1px solid #e2e8f0; font-size: 13px; }
        tr:nth-child(even) { background-color: #f8fafc; }

        /* Badge Style */
        .badge { padding: 4px 8px; border-radius: 4px; font-size: 11px; font-weight: bold; }
        .bg-success { background: #dcfce7; color: #166534; }
        .bg-danger { background: #fee2e2; color: #991b1b; }

        /* Footer & Signature Section */
        .footer { margin-top: 50px; display: flex; justify-content: space-between; align-items: flex-end; }
        .signature-container { text-align: center; width: 220px; }
        .signature-container p { margin-bottom: 10px; font-size: 13px; color: #334155; }
        
        .canvas-wrapper { 
            position: relative; 
            border-bottom: 1px solid #334155; 
            margin-bottom: 5px; 
            background: #fdfdfd;
        }
        
        canvas#signature-pad { 
            cursor: crosshair; 
            display: block;
        }

        .clear-btn {
            position: absolute;
            top: -10px;
            right: -10px;
            background: #ef4444;
            color: white;
            border: none;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            font-size: 10px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        /* Print Settings */
        @media print {
            body { padding: 0; }
            .no-print { display: none; }
            .summary-box { background: #f8fafc !important; -webkit-print-color-adjust: exact; border-left: 4px solid #f97316 !important; }
            .canvas-wrapper { border-bottom: 1px solid #000 !important; }
        }
    </style>
</head>
<body>
    {{-- Tombol Navigasi (Hanya muncul di Layar) --}}
    <div class="no-print" style="margin-bottom: 30px; text-align: center; background: #f1f5f9; padding: 20px; border-radius: 12px;">
        <p style="margin-top: 0; font-size: 13px; color: #64748b;"><b>Tips:</b> Silakan tanda tangan di kotak bawah sebelum menekan tombol Cetak.</p>
        <button onclick="window.history.back()" style="padding: 10px 20px; cursor: pointer; background: #64748b; color: white; border: none; border-radius: 6px; font-weight: 600;">← Kembali</button>
        <button onclick="window.print()" style="padding: 10px 20px; cursor: pointer; background: #f97316; color: white; border: none; border-radius: 6px; font-weight: 600; margin-left: 10px;">Cetak Sekarang</button>
    </div>

    <div class="header">
        <div class="brand">
            <h1>LAUNDRY JAYA</h1>
            <p>Jl. Merdeka No. 123, Surabaya | Telp: 0812-3456-7890</p>
        </div>
        <div class="report-info">
            <h2>LAPORAN KEUANGAN</h2>
            <p>Periode: <b>{{ $dari ? date('d M Y', strtotime($dari)) : '-' }}</b> s/d <b>{{ $sampai ? date('d M Y', strtotime($sampai)) : '-' }}</b></p>
        </div>
    </div>

    <div class="summary-grid">
        <div class="summary-box">
            <label>Total Transaksi</label>
            <span>{{ $transactions->count() }} Order</span>
        </div>
        <div class="summary-box" style="border-left: 4px solid #f97316;">
            <label>Total Omzet</label>
            <span>Rp {{ number_format($totalOmzet, 0, ',', '.') }}</span>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th width="50">No</th>
                <th>Tanggal</th>
                <th>No. Transaksi</th>
                <th>Pelanggan</th>
                <th>Layanan</th>
                <th>Qty</th>
                <th>Status</th>
                <th>Total Harga</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transactions as $index => $t)
            <tr>
                <td style="text-align: center;">{{ $index + 1 }}</td>
                <td>{{ $t->created_at->format('d/m/Y') }}</td>
                <td style="font-weight: 600; color: #f97316;">{{ $t->invoice_code }}</td>
                <td>{{ $t->customer->name ?? 'N/A' }}</td>
                <td>{{ $t->details->first()->service->service_name ?? '-' }}</td>
                <td>{{ $t->details->first()->qty ?? 0 }} {{ $t->details->first()->service->unit ?? '' }}</td>
                <td>
                    <span class="badge {{ $t->payment_status == 'Selesai' ? 'bg-success' : 'bg-danger' }}">
                        {{ $t->payment_status }}
                    </span>
                </td>
                <td style="font-weight: 600;">Rp {{ number_format($t->total_price, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <div style="font-size: 11px; color: #94a3b8;">
            Dicetak otomatis oleh Sistem Laundry Jaya pada: {{ date('d/m/Y H:i') }}
        </div>
        
        <div class="signature-container">
            <p>Admin Kasir,</p>
            <div class="canvas-wrapper">
                <canvas id="signature-pad" width="220" height="90"></canvas>
                <button type="button" class="clear-btn no-print" onclick="clearSignature()" title="Hapus TTD">✕</button>
            </div>
            <b style="font-size: 14px;">( {{ auth()->user()->name ?? 'Admin Laundry' }} )</b>
        </div>
    </div>

    <script>
        const canvas = document.getElementById('signature-pad');
        const ctx = canvas.getContext('2d');
        let writingMode = false;

        ctx.lineWidth = 2.5;
        ctx.lineJoin = 'round';
        ctx.lineCap = 'round';
        ctx.strokeStyle = '#000';

        const handlePointerDown = (event) => {
            writingMode = true;
            ctx.beginPath();
            const [positionX, positionY] = getCursorPosition(event);
            ctx.moveTo(positionX, positionY);
        }

        const handlePointerUp = () => {
            writingMode = false;
        }

        const handlePointerMove = (event) => {
            if (!writingMode) return;
            const [positionX, positionY] = getCursorPosition(event);
            ctx.lineTo(positionX, positionY);
            ctx.stroke();
        }

        const getCursorPosition = (event) => {
            const rect = canvas.getBoundingClientRect();
            const clientX = event.clientX || (event.touches ? event.touches[0].clientX : 0);
            const clientY = event.clientY || (event.touches ? event.touches[0].clientY : 0);
            const x = clientX - rect.left;
            const y = clientY - rect.top;
            return [x, y];
        }

        canvas.addEventListener('mousedown', handlePointerDown);
        canvas.addEventListener('mouseup', handlePointerUp);
        canvas.addEventListener('mousemove', handlePointerMove);
        
        canvas.addEventListener('touchstart', (e) => { handlePointerDown(e); e.preventDefault(); }, {passive: false});
        canvas.addEventListener('touchend', handlePointerUp);
        canvas.addEventListener('touchmove', (e) => { handlePointerMove(e); e.preventDefault(); }, {passive: false});

        function clearSignature() {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
        }
    </script>
</body>
</html>