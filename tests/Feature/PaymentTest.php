<?php

use App\Enums\ContentStatus;
use App\Enums\EscrowStatus;
use App\Enums\HiringStatus;
use App\Enums\PaymentStatus;
use App\Models\Agreement;
use App\Models\BrandProfile;
use App\Models\Campaign;
use App\Models\Content;
use App\Models\EscrowTransaction;
use App\Models\Hiring;
use App\Models\KolProfile;
use App\Models\KolWithdrawal;
use App\Models\Payment;
use App\Models\User;
use App\Services\Payment\EscrowService;
use App\Services\Payment\WithdrawalService;

beforeEach(function () {
    $this->brandUser = User::factory()->brand()->create();
    $this->kolUser = User::factory()->kol()->create();
    $this->brandProfile = BrandProfile::factory()->create(['user_id' => $this->brandUser->id]);
    $this->kolProfile = KolProfile::factory()->create(['user_id' => $this->kolUser->id]);
    $this->campaign = Campaign::factory()->create(['brand_profile_id' => $this->brandProfile->id]);
    $this->hiring = Hiring::factory()->create([
        'campaign_id' => $this->campaign->id,
        'brand_profile_id' => $this->brandProfile->id,
        'kol_profile_id' => $this->kolProfile->id,
        'status' => HiringStatus::ACCEPTED,
    ]);
    $this->agreement = Agreement::factory()->create([
        'hiring_id' => $this->hiring->id,
        'total_amount' => 1000000,
    ]);
});

test('payment creation via invoice service', function () {
    $invoiceService = app(\App\Services\Payment\InvoiceService::class);
    $payment = $invoiceService->createPayment($this->agreement);

    expect($payment)->toBeInstanceOf(Payment::class)
        ->and($payment->agreement_id)->toBe($this->agreement->id)
        ->and($payment->amount)->toEqual(1000000.00)
        ->and($payment->platform_fee)->toEqual(100000.00)
        ->and($payment->total_amount)->toEqual(1100000.00)
        ->and($payment->status)->toBe(PaymentStatus::PENDING)
        ->and($payment->invoice_number)->toStartWith('INV-');
});

test('escrow hold on payment', function () {
    $invoiceService = app(\App\Services\Payment\InvoiceService::class);
    $payment = $invoiceService->createPayment($this->agreement);
    $payment->update(['status' => PaymentStatus::PAID]);

    $escrowService = app(EscrowService::class);
    $escrow = $escrowService->holdFunds($payment);

    expect($escrow)->toBeInstanceOf(EscrowTransaction::class)
        ->and($escrow->status)->toBe(EscrowStatus::HELD);

    $payment->refresh();
    expect($payment->status)->toBe(PaymentStatus::HELD);
});

test('escrow release on content approval', function () {
    $invoiceService = app(\App\Services\Payment\InvoiceService::class);
    $payment = $invoiceService->createPayment($this->agreement);
    $payment->update(['status' => PaymentStatus::PAID]);

    $escrowService = app(EscrowService::class);
    $escrow = $escrowService->holdFunds($payment);

    Content::factory()->create([
        'agreement_id' => $this->agreement->id,
        'kol_profile_id' => $this->kolProfile->id,
        'brand_profile_id' => $this->brandProfile->id,
        'status' => 'approved',
    ]);

    $escrowService->releaseEscrow($escrow, 'content_approved');

    $escrow->refresh();
    expect($escrow->status)->toBe(EscrowStatus::RELEASED);

    $this->kolProfile->refresh();
    expect($this->kolProfile->wallet_balance)->toEqual(900000.00);
});

test('withdrawal request and approval', function () {
    $this->kolProfile->update(['wallet_balance' => 500000]);

    $withdrawalService = app(WithdrawalService::class);

    $bankAccount = \App\Models\KolBankAccount::factory()->create([
        'kol_profile_id' => $this->kolProfile->id,
    ]);

    $withdrawal = $withdrawalService->requestWithdrawal(
        $this->kolProfile,
        200000,
        $bankAccount->id
    );

    expect($withdrawal)->toBeInstanceOf(KolWithdrawal::class)
        ->and($withdrawal->status)->toBe('pending')
        ->and($withdrawal->amount)->toEqual(200000.00);

    $this->kolProfile->refresh();
    expect($this->kolProfile->wallet_balance)->toEqual(300000.00)
        ->and($this->kolProfile->pending_balance)->toEqual(200000.00);

    $withdrawalService->approveWithdrawal($withdrawal);

    $withdrawal->refresh();
    expect($withdrawal->status)->toBe('completed')
        ->and($withdrawal->processed_at)->not->toBeNull();

    $this->kolProfile->refresh();
    expect($this->kolProfile->pending_balance)->toEqual(0.00);
});

test('xendit webhook handling', function () {
    $webhookToken = 'test-webhook-token';
    config(['xendit.webhook_token' => $webhookToken]);

    $invoiceService = app(\App\Services\Payment\InvoiceService::class);
    $payment = $invoiceService->createPayment($this->agreement);

    $payload = [
        'event' => 'paid',
        'external_id' => $payment->invoice_number,
        'id' => 'xendit-payment-id-123',
    ];
    $payloadBody = json_encode($payload);
    $signature = hash_hmac('sha256', $payloadBody, $webhookToken);

    $response = $this->postJson(
        '/api/v1/webhooks/xendit',
        $payload,
        ['x-callback-token' => $signature]
    );

    $response->assertOk();

    $payment->refresh();
    expect($payment->status)->toBe(PaymentStatus::HELD);
});
