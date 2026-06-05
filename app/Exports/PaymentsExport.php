<?php

namespace App\Exports;

use App\Models\Payment;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PaymentsExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Payment::with(['agreement.hiring.campaign.brandProfile.user'])
            ->latest()
            ->get();
    }

    public function headings(): array
    {
        return [
            'Invoice',
            'Brand',
            'Amount',
            'Platform Fee',
            'Total',
            'Status',
            'Paid At',
        ];
    }

    public function map($payment): array
    {
        return [
            $payment->invoice_number,
            $payment->agreement?->hiring?->campaign?->brandProfile?->brand_name ?? '-',
            (float) $payment->amount,
            (float) $payment->platform_fee,
            (float) $payment->total_amount,
            $payment->status->value,
            $payment->paid_at?->format('d/m/Y H:i') ?? '-',
        ];
    }
}
