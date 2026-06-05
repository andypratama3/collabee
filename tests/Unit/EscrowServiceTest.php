<?php

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
use App\Models\Payment;
use App\Models\User;
use App\Services\Payment\EscrowService;

beforeEach(function () {
    $this->escrowService = app(EscrowService::class);

    $brandUser = User::factory()->brand()->create();
    $kolUser = User::factory()->kol()->create();
    $brandProfile = BrandProfile::factory()->create(['user_id' => $brandUser->id]);
    $kolProfile = KolProfile::factory()->create(['user_id' => $kolUser->id]);
    $campaign = Campaign::factory()->create(['brand_profile_id' => $brandProfile->id]);
    $hiring = Hiring::factory()->create([
        'campaign_id' => $campaign->id,
        'brand_profile_id' => $brandProfile->id,
        'kol_profile_id' => $kolProfile->id,
        'status' => HiringStatus::ACCEPTED,
    ]);
    $agreement = Agreement::factory()->create([
        'hiring_id' => $hiring->id,
        'total_amount' => 1000000,
    ]);
    $this->payment = Payment::factory()->create([
        'agreement_id' => $agreement->id,
        'amount' => 1000000,
        'total_amount' => 1100000,
        'status' => PaymentStatus::PAID,
    ]);
});

test('holdFunds creates escrow transaction with correct amounts', function () {
    $escrow = $this->escrowService->holdFunds($this->payment);

    expect($escrow)->toBeInstanceOf(EscrowTransaction::class)
        ->and($escrow->payment_id)->toBe($this->payment->id)
        ->and($escrow->amount_held)->toEqual(1000000.00)
        ->and($escrow->platform_fee)->toEqual(100000.00)
        ->and($escrow->kol_amount)->toEqual(900000.00)
        ->and($escrow->status)->toBe(EscrowStatus::HELD)
        ->and($escrow->held_at)->not->toBeNull();

    $this->payment->refresh();
    expect($this->payment->status)->toBe(PaymentStatus::HELD);
});

test('releaseEscrow updates status and adds to KOL wallet', function () {
    $escrow = $this->escrowService->holdFunds($this->payment);

    $this->escrowService->releaseEscrow($escrow, 'content_approved');

    $escrow->refresh();
    expect($escrow->status)->toBe(EscrowStatus::RELEASED)
        ->and($escrow->release_trigger)->toBe('content_approved')
        ->and($escrow->released_at)->not->toBeNull();

    $kolProfile = $escrow->payment->agreement->hiring->kolProfile;
    expect($kolProfile->wallet_balance)->toEqual(900000.00);

    $this->payment->refresh();
    expect($this->payment->status)->toBe(PaymentStatus::RELEASED);
});

test('autoReleaseEscrow releases escrows older than 7 days with approved content', function () {
    $escrow = $this->escrowService->holdFunds($this->payment);

    EscrowTransaction::where('id', $escrow->id)->update([
        'held_at' => now()->subDays(8),
    ]);

    $agreement = $this->payment->agreement;
    Content::factory()->create([
        'agreement_id' => $agreement->id,
        'kol_profile_id' => $agreement->hiring->kol_profile_id,
        'brand_profile_id' => $agreement->hiring->brand_profile_id,
        'status' => 'approved',
    ]);

    $this->escrowService->autoReleaseEscrow();

    $escrow->refresh();
    expect($escrow->status)->toBe(EscrowStatus::RELEASED)
        ->and($escrow->release_trigger)->toBe('auto_release');
});
