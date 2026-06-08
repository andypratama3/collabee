<?php

namespace App\Services\Campaign;

use App\Enums\CampaignStatus;
use App\Enums\HiringStatus;
use App\Models\BrandProfile;
use App\Models\Campaign;
use App\Models\ChatRoom;
use App\Models\Hiring;
use App\Models\HiringApplication;
use App\Models\KolProfile;
use App\Services\Campaign\AgreementService;
use App\Services\Notification\NotificationService;
use Illuminate\Support\Facades\DB;

class HiringService
{
    public function __construct(
        private readonly NotificationService $notificationService,
        private readonly AgreementService $agreementService,
    ) {}

    public function apply(Campaign $campaign, KolProfile $kolProfile, array $data): HiringApplication
    {
        $application = DB::transaction(function () use ($campaign, $kolProfile, $data) {
            if ($campaign->status !== CampaignStatus::OPEN) {
                throw new \RuntimeException('This campaign is not accepting applications.');
            }

            if ($campaign->applications_count >= $campaign->kol_slots * 5) {
                throw new \RuntimeException('This campaign has reached maximum applications.');
            }

            $application = HiringApplication::create([
                'campaign_id' => $campaign->id,
                'kol_profile_id' => $kolProfile->id,
                'proposed_budget' => $data['proposed_budget'] ?? null,
                'message' => $data['message'] ?? null,
                'status' => 'pending',
            ]);

            $campaign->increment('applications_count');

            return $application;
        });

        $this->notificationService->send(
            $campaign->brandProfile->user,
            'hiring',
            'Ada lamaran baru',
            "KOL {$kolProfile->display_name} melamar campaign {$campaign->title}.",
            ['hiring' => $application],
            route('brand.hiring.index')
        );

        return $application;
    }

    public function brandHire(Campaign $campaign, BrandProfile $brandProfile, KolProfile $kolProfile, array $data): Hiring
    {
        $hiring = DB::transaction(function () use ($campaign, $brandProfile, $kolProfile, $data) {
            $existing = Hiring::where('campaign_id', $campaign->id)
                ->where('kol_profile_id', $kolProfile->id)
                ->first();

            if ($existing) {
                throw new \RuntimeException('A hiring record for this KOL already exists.');
            }

            if ($campaign->kol_filled >= $campaign->kol_slots) {
                throw new \RuntimeException('All KOL slots for this campaign are filled.');
            }

            return Hiring::create([
                'campaign_id' => $campaign->id,
                'brand_profile_id' => $brandProfile->id,
                'kol_profile_id' => $kolProfile->id,
                'initiated_by' => 'brand',
                'status' => HiringStatus::PENDING,
                'message' => $data['message'] ?? null,
                'proposed_budget' => $data['proposed_budget'] ?? $campaign->budget_per_kol,
                'expires_at' => now()->addDays(7),
            ]);
        });

        $this->notificationService->send(
            $kolProfile->user,
            'hiring',
            'Tawaran hiring baru',
            "Brand {$brandProfile->brand_name} ingin merekrut Anda untuk campaign {$campaign->title}.",
            ['hiring' => $hiring],
            route('kol.hiring.index')
        );

        return $hiring;
    }

    public function accept(Hiring $hiring): Hiring
    {
        $result = DB::transaction(function () use ($hiring) {
            if ($hiring->status !== HiringStatus::PENDING) {
                throw new \RuntimeException('Only pending hirings can be accepted.');
            }

            $hiring->update([
                'status' => HiringStatus::ACCEPTED,
                'accepted_at' => now(),
                'agreed_budget' => $hiring->proposed_budget,
            ]);

            $hiring->campaign->increment('kol_filled');

            ChatRoom::firstOrCreate([
                'hiring_id' => $hiring->id,
            ], [
                'brand_user_id' => $hiring->campaign->brandProfile->user->id,
                'kol_user_id' => $hiring->kolProfile->user->id,
            ]);

            return $hiring->fresh();
        });

        // Auto-generate agreement after acceptance (idempotent — safe to call even if already exists)
        $this->agreementService->generate($result);

        $this->notificationService->send(
            $result->campaign->brandProfile->user,
            'hiring',
            'KOL menerima tawaran',
            "{$result->kolProfile->display_name} telah menerima tawaran hiring untuk campaign {$result->campaign->title}.",
            ['hiring' => $result],
            route('brand.hiring.index')
        );

        return $result;
    }

    public function reject(Hiring $hiring, ?string $reason = null): Hiring
    {
        $result = DB::transaction(function () use ($hiring, $reason) {
            if ($hiring->status !== HiringStatus::PENDING) {
                throw new \RuntimeException('Only pending hirings can be rejected.');
            }

            $hiring->update([
                'status' => HiringStatus::REJECTED,
                'rejected_reason' => $reason,
            ]);

            return $hiring->fresh();
        });

        $this->notificationService->send(
            $result->campaign->brandProfile->user,
            'hiring',
            'KOL menolak tawaran',
            "{$result->kolProfile->display_name} menolak tawaran untuk campaign {$result->campaign->title}." . ($reason ? " Alasan: {$reason}" : ''),
            ['hiring' => $result],
            route('brand.hiring.index')
        );

        return $result;
    }

    public function cancel(Hiring $hiring, ?string $reason = null): Hiring
    {
        return DB::transaction(function () use ($hiring, $reason) {
            if ($hiring->status === HiringStatus::COMPLETED) {
                throw new \RuntimeException('This hiring cannot be cancelled.');
            }

            $wasAccepted = $hiring->status === HiringStatus::ACCEPTED;
            $hiring->update([
                'status' => HiringStatus::CANCELLED,
                'note' => $reason,
            ]);

            if ($wasAccepted) {
                $hiring->campaign->decrement('kol_filled');
            }

            return $hiring->fresh();
        });
    }

    /**
     * Brand accepts a KOL application and converts it into a formal Hiring
     */
    public function acceptApplication(HiringApplication $application, BrandProfile $brandProfile): Hiring
    {
        $hiring = DB::transaction(function () use ($application, $brandProfile) {
            if ($application->status !== 'pending') {
                throw new \RuntimeException('This application has already been processed.');
            }

            $campaign = $application->campaign;

            if ($campaign->kol_filled >= $campaign->kol_slots) {
                throw new \RuntimeException('All KOL slots for this campaign are filled.');
            }

            // Mark application as accepted
            $application->update(['status' => 'accepted']);

            // Create formal Hiring record
            $hiring = Hiring::create([
                'campaign_id' => $campaign->id,
                'brand_profile_id' => $brandProfile->id,
                'kol_profile_id' => $application->kol_profile_id,
                'initiated_by' => 'kol',
                'status' => HiringStatus::ACCEPTED,
                'message' => $application->message,
                'proposed_budget' => $application->proposed_budget ?? $campaign->budget_per_kol,
                'agreed_budget' => $application->proposed_budget ?? $campaign->budget_per_kol,
                'accepted_at' => now(),
                'expires_at' => now()->addDays(7),
            ]);

            $campaign->increment('kol_filled');

            ChatRoom::firstOrCreate([
                'hiring_id' => $hiring->id,
            ], [
                'brand_user_id' => $campaign->brandProfile->user->id,
                'kol_user_id' => $application->kolProfile->user->id,
            ]);

            return $hiring;
        });

        // Auto-generate agreement
        $this->agreementService->generate($hiring);

        $this->notificationService->send(
            $hiring->kolProfile->user,
            'hiring',
            'Lamaran Anda diterima',
            "Brand {$hiring->brandProfile->brand_name} menerima lamaran Anda untuk campaign {$hiring->campaign->title}.",
            ['hiring' => $hiring],
            route('kol.hiring.index')
        );

        return $hiring;
    }

    /**
     * Brand rejects a KOL application
     */
    public function rejectApplication(HiringApplication $application, ?string $reason = null): HiringApplication
    {
        if ($application->status !== 'pending') {
            throw new \RuntimeException('This application has already been processed.');
        }

        $application->update([
            'status' => 'rejected',
        ]);

        $this->notificationService->send(
            $application->kolProfile->user,
            'hiring',
            'Lamaran Anda ditolak',
            "Brand telah menolak lamaran Anda untuk campaign {$application->campaign->title}." . ($reason ? " Alasan: {$reason}" : ''),
            ['application' => $application],
            route('kol.hiring.index')
        );

        return $application->fresh();
    }

    public function getBrandHirings(BrandProfile $brandProfile, ?string $status = null)
    {
        $query = Hiring::where('brand_profile_id', $brandProfile->id)
            ->with(['campaign', 'kolProfile.user'])
            ->orderBy('created_at', 'desc');

        if ($status) {
            $query->where('status', $status);
        }

        return $query->get();
    }

    public function getKolHirings(KolProfile $kolProfile, ?string $status = null)
    {
        $query = Hiring::where('kol_profile_id', $kolProfile->id)
            ->with(['campaign.brandProfile.user', 'campaign'])
            ->orderBy('created_at', 'desc');

        if ($status) {
            $query->where('status', $status);
        }

        return $query->get();
    }
}
