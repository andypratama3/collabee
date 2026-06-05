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
            $existing = Agreement::where('hiring_id', $hiring->id)->first();
            if ($existing) {
                return $existing;
            }

            $campaign = $hiring->campaign;
            $agreedBudget = $hiring->agreed_budget ?? $hiring->proposed_budget;
            $platformFeePercent = 5.00;
            $platformFee = $agreedBudget * ($platformFeePercent / 100);
            $totalAmount = $agreedBudget;

            $agreement = Agreement::create([
                'hiring_id' => $hiring->id,
                'agreement_number' => $this->generateNumber($hiring),
                'total_amount' => $totalAmount,
                'platform_fee_percent' => $platformFeePercent,
                'terms' => $this->generateTerms($campaign, $agreedBudget, $platformFeePercent),
                'status' => 'pending',
                'expires_at' => now()->addDays(30),
            ]);

            return $agreement;
        });
    }

    public function signAsBrand(Agreement $agreement): Agreement
    {
        return DB::transaction(function () use ($agreement) {
            if ($agreement->brand_signed_at) {
                throw new \RuntimeException('Agreement already signed by brand.');
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
                throw new \RuntimeException('Agreement already signed by KOL.');
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

        $filename = 'agreements/agreement-' . $agreement->agreement_number . '.pdf';

        $pdf->save(storage_path('app/public/' . $filename));

        $agreement->update(['pdf_path' => $filename]);

        return $filename;
    }

    protected function generateNumber(Hiring $hiring): string
    {
        $prefix = 'AGR';
        $date = now()->format('Ymd');
        $random = strtoupper(Str::random(6));

        return "{$prefix}/{$date}/{$random}";
    }

    protected function generateTerms($campaign, float $budget, float $platformFeePercent = 5.00): string
    {
        return collect([
            "1. Scope of Work: KOL agrees to create and publish content for the campaign \"{$campaign->title}\" as per the campaign brief and specifications.",
            "2. Platforms: Content to be published on the agreed platforms as specified in the campaign.",
            "3. Compensation: The total compensation for this agreement is Rp " . number_format($budget, 0, ',', '.') . " (including platform fee).",
            "4. Payment Terms: Payment will be held in escrow and released upon content approval by the Brand.",
            "5. Content Deadline: KOL must submit content for review before the campaign end date.",
            "6. Content Ownership: Upon full payment, Brand has the right to use the content for marketing purposes.",
            "7. Confidentiality: Both parties agree to keep campaign details confidential until official launch.",
            "8. Platform Fee: A {$platformFeePercent}% platform fee is applied to the total agreement amount.",
            "9. Dispute Resolution: Any disputes will be resolved through the platform's dispute resolution process.",
            "10. Governing Law: This agreement is governed by the laws of the Republic of Indonesia.",
        ])->implode("\n\n");
    }
}
