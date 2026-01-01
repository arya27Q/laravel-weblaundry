<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class LaporanExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    protected $transactions;

    public function __construct($transactions)
    {
        $this->transactions = $transactions;
    }

    public function collection()
    {
        return $this->transactions;
    }

    public function headings(): array
    {
        return ["Tanggal", "Invoice", "Pelanggan", "Layanan", "Total Harga", "Status"];
    }

    public function map($t): array
    {
        return [
            $t->created_at->format('d/m/Y'),
            $t->invoice_code,
            $t->customer->name ?? 'N/A',
            $t->details->first()->service->service_name ?? '-',
            $t->total_price,
            $t->payment_status
        ];
    }
}