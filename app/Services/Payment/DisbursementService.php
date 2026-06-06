<?php

namespace App\Services\Payment;

use App\Models\KolWithdrawal;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class DisbursementService
{
    private string $apiKey;
    private string $baseUrl;

    public function __construct()
    {
        $this->apiKey = config('xendit.api_key', '');
        $this->baseUrl = 'https://api.xendit.co';
    }

    /**
     * Create a disbursement via Xendit API
     */
    public function createDisbursement(KolWithdrawal $withdrawal): array
    {
        $externalId = 'WD-' . now()->format('Ymd') . '-' . str_pad($withdrawal->id, 5, '0', STR_PAD_LEFT);

        $payload = [
            'external_id' => $externalId,
            'amount' => (float) $withdrawal->net_amount,
            'bank_code' => $this->mapBankCode($withdrawal->bank_name),
            'account_holder_name' => $withdrawal->bank_account_name,
            'account_number' => $withdrawal->bank_account_number,
            'description' => 'Collabee Withdrawal #' . $withdrawal->id . ' - ' . ($withdrawal->kolProfile?->user?->name ?? 'KOL'),
        ];

        try {
            $response = Http::withBasicAuth($this->apiKey, '')
                ->post($this->baseUrl . '/disbursements', $payload);

            if ($response->successful()) {
                $data = $response->json();

                $withdrawal->update([
                    'status' => 'completed',
                    'processed_at' => now(),
                    'admin_note' => 'Disbursement via Xendit: ' . ($data['id'] ?? $externalId),
                ]);

                Log::info('Xendit disbursement created', [
                    'withdrawal_id' => $withdrawal->id,
                    'xendit_id' => $data['id'] ?? null,
                    'amount' => $withdrawal->net_amount,
                ]);

                return [
                    'success' => true,
                    'data' => $data,
                    'message' => 'Disbursement berhasil dikirim ke Xendit.',
                ];
            }

            $errorData = $response->json();
            Log::error('Xendit disbursement failed', [
                'withdrawal_id' => $withdrawal->id,
                'status' => $response->status(),
                'response' => $errorData,
            ]);

            return [
                'success' => false,
                'message' => $errorData['message'] ?? 'Gagal membuat disbursement. Status: ' . $response->status(),
            ];
        } catch (\Exception $e) {
            Log::error('Xendit disbursement exception', [
                'withdrawal_id' => $withdrawal->id,
                'error' => $e->getMessage(),
            ]);

            return [
                'success' => false,
                'message' => 'Koneksi ke Xendit gagal: ' . $e->getMessage(),
            ];
        }
    }

    /**
     * Map bank name to Xendit bank code
     */
    private function mapBankCode(string $bankName): string
    {
        $bankMap = [
            'bca' => 'BCA',
            'bni' => 'BNI',
            'bri' => 'BRI',
            'mandiri' => 'MANDIRI',
            'cimb' => 'CIMB',
            'permata' => 'PERMATA',
            'danamon' => 'DANAMON',
            'bsi' => 'BSI',
            'btpn' => 'BTPN',
            'mega' => 'MEGA',
            'ocbc' => 'OCBC_NISP',
            'panin' => 'PANIN',
            'btn' => 'BTN',
            'maybank' => 'MAYBANK',
            'hsbc' => 'HSBC',
            'gopay' => 'GOPAY',
            'ovo' => 'OVO',
            'dana' => 'DANA',
            'shopeepay' => 'SHOPEEPAY',
        ];

        $normalized = strtolower(trim($bankName));

        foreach ($bankMap as $key => $code) {
            if (str_contains($normalized, $key)) {
                return $code;
            }
        }

        // Default: return uppercase version
        return strtoupper(preg_replace('/[^a-zA-Z]/', '', $bankName));
    }

    /**
     * Get available bank list for disbursement
     */
    public function getAvailableBanks(): array
    {
        try {
            $response = Http::withBasicAuth($this->apiKey, '')
                ->get($this->baseUrl . '/available_disbursements_banks');

            if ($response->successful()) {
                return $response->json();
            }
        } catch (\Exception $e) {
            Log::error('Failed to fetch Xendit banks', ['error' => $e->getMessage()]);
        }

        return [];
    }
}
