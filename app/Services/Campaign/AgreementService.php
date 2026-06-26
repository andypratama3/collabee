<?php

namespace App\Services\Campaign;

use App\Models\Agreement;
use App\Models\Hiring;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AgreementService
{
    public function generate(Hiring $hiring): Agreement
    {
        return DB::transaction(function () use ($hiring) {
            $campaign = $hiring->campaign;
            $agreedBudget = $hiring->agreed_budget ?? $hiring->proposed_budget;
            $platformFeePercent = 10.00;
            $platformFee = $agreedBudget * ($platformFeePercent / 100);
            $totalAmount = $agreedBudget;

            $existing = Agreement::where('hiring_id', $hiring->id)->first();
            if ($existing) {
                if ($existing->total_amount == $totalAmount) {
                    return $existing;
                }

                $existing->update([
                    'total_amount' => $totalAmount,
                    'platform_fee_percent' => $platformFeePercent,
                    'terms' => $this->generateTerms($campaign, $agreedBudget, $platformFeePercent),
                ]);

                return $existing->fresh();
            }

            $agreement = Agreement::create([
                'hiring_id' => $hiring->id,
                'agreement_number' => $this->generateNumber($hiring),
                'total_amount' => $totalAmount,
                'platform_fee_percent' => $platformFeePercent,
                'terms' => $this->generateTerms($campaign, $agreedBudget, $platformFeePercent),
                'status' => 'draft',
                'expires_at' => now()->addDays(30),
            ]);

            return $agreement;
        });
    }

    public function signAsBrand(Agreement $agreement): Agreement
    {
        return DB::transaction(function () use ($agreement) {
            if ($agreement->brand_signed_at) {
                throw new \RuntimeException('Perjanjian sudah ditandatangani oleh Brand.');
            }

            $agreement->update([
                'brand_signed_at' => now(),
                'brand_signed_ip' => request()->ip(),
            ]);

            $this->checkFullySigned($agreement);

            return $agreement->fresh();
        });
    }

    public function signAsKol(Agreement $agreement): Agreement
    {
        return DB::transaction(function () use ($agreement) {
            if ($agreement->kol_signed_at) {
                throw new \RuntimeException('Perjanjian sudah ditandatangani oleh KOL.');
            }

            $agreement->update([
                'kol_signed_at' => now(),
                'kol_signed_ip' => request()->ip(),
            ]);

            $this->checkFullySigned($agreement);

            return $agreement->fresh();
        });
    }

    protected function checkFullySigned(Agreement $agreement): void
    {
        if ($agreement->fresh()->brand_signed_at && $agreement->fresh()->kol_signed_at) {
            $agreement->update([
                'status' => 'signed',
                'signed_at' => now(),
            ]);

            $this->generatePdf($agreement);
        }
    }

    public function generatePdf(Agreement $agreement): string
    {
        $agreement->load('hiring.campaign.brandProfile.user', 'hiring.kolProfile.user');

        $pdf = Pdf::loadView('pdfs.agreement', [
            'agreement' => $agreement,
        ]);

        $filename = 'agreements/agreement-'.$agreement->agreement_number.'.pdf';
        $path = storage_path('app/public/'.$filename);

        $directory = dirname($path);
        if (! is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        $pdf->save($path);

        $agreement->update(['pdf_path' => $filename]);

        return $filename;
    }

    public function getPdfUrl(Agreement $agreement): ?string
    {
        if (! $agreement->pdf_path) {
            return null;
        }

        return url('storage/'.$agreement->pdf_path);
    }

    protected function generateNumber(Hiring $hiring): string
    {
        $year = now()->format('Y');
        $random = strtoupper(Str::random(5));

        return "AGR-{$year}-{$random}";
    }

    protected function generateTerms($campaign, float $budget, float $platformFeePercent = 10.00): string
    {
        return collect([
            "1. Ruang Lingkup Pekerjaan: KOL setuju untuk membuat dan mempublikasikan konten untuk kampanye \"{$campaign->title}\" sesuai dengan brief kampanye dan spesifikasi yang telah disepakati.",
            '2. Platform: Konten akan dipublikasikan di platform yang telah disepakati sebagaimana tercantum dalam kampanye.',
            '3. Kompensasi: Total kompensasi untuk perjanjian ini adalah Rp '.number_format($budget, 0, ',', '.').' (termasuk biaya platform).',
            '4. Ketentuan Pembayaran: Pembayaran akan ditahan dalam escrow dan dicairkan setelah konten disetujui oleh Brand.',
            '5. Batas Waktu Konten: KOL harus menyerahkan konten untuk ditinjau sebelum tanggal berakhirnya kampanye.',
            '6. Kepemilikan Konten: Setelah pembayaran penuh, Brand memiliki hak untuk menggunakan konten untuk tujuan pemasaran.',
            '7. Kerahasiaan: Kedua belah pihak setuju untuk menjaga kerahasiaan detail kampanye hingga peluncuran resmi.',
            "8. Biaya Platform: Biaya platform sebesar {$platformFeePercent}% diterapkan dari total jumlah perjanjian.",
            '9. Penyelesaian Sengketa: Setiap sengketa akan diselesaikan melalui proses penyelesaian sengketa platform.',
            '10. Hukum yang Berlaku: Perjanjian ini diatur oleh hukum Republik Indonesia.',
        ])->implode("\n\n");
    }
}
