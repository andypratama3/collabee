<?php

namespace App\Services\Content;

use App\Enums\ContentStatus;
use App\Events\ContentUploaded;
use App\Models\Agreement;
use App\Models\BrandProfile;
use App\Models\Content;
use App\Models\ContentRevision;
use App\Models\KolProfile;
use App\Services\Notification\NotificationService;
use App\Services\Payment\EscrowService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection as BaseCollection;
use Illuminate\Support\Facades\DB;

class ContentService
{
    public function __construct(
        private readonly NotificationService $notificationService,
        private readonly EscrowService $escrowService,
    ) {}

    public function upload(KolProfile $kolProfile, Agreement $agreement, array $data, BaseCollection $files): Content
    {
        return DB::transaction(function () use ($kolProfile, $agreement, $data, $files) {
            $content = Content::create([
                'agreement_id' => $agreement->id,
                'kol_profile_id' => $kolProfile->id,
                'brand_profile_id' => $agreement->hiring->brand_profile_id,
                'title' => $data['title'],
                'caption' => $data['caption'] ?? null,
                'status' => ContentStatus::DRAFT,
            ]);

            foreach ($files as $file) {
                if ($file instanceof UploadedFile) {
                    $content->addMedia($file)->toMediaCollection('content_files');
                }
            }

            return $content->fresh();
        });
    }

    public function submit(Content $content): Content
    {
        $result = DB::transaction(function () use ($content) {
            $content->update([
                'status' => ContentStatus::SUBMITTED,
                'submitted_at' => now(),
            ]);

            ContentUploaded::dispatch($content);

            return $content->fresh()->load('brandProfile.user', 'kolProfile');
        });

        // Guard: skip notification if brandProfile has no user
        if ($result->brandProfile?->user) {
            $this->notificationService->send(
                $result->brandProfile->user,
                'content_reminder',
                'Konten baru siap direview',
                "KOL {$result->kolProfile?->display_name} telah mengirimkan konten untuk ditinjau.",
                ['content' => $result],
                route('brand.content.show', $result)
            );
        }

        return $result;
    }

    public function approve(Content $content): Content
    {
        $result = DB::transaction(function () use ($content) {
            $content->update([
                'status' => ContentStatus::APPROVED,
                'approved_at' => now(),
            ]);

            // Release escrow when content is approved
            $payment = $content->agreement?->payment;
            if ($payment && $payment->escrowTransaction) {
                $this->escrowService->releaseEscrow($payment->escrowTransaction, 'content_approved');
            }

            return $content->fresh()->load('kolProfile.user', 'brandProfile');
        });

        // Guard: skip notification if kolProfile has no user
        if ($result->kolProfile?->user) {
            $this->notificationService->send(
                $result->kolProfile->user,
                'content_reminder',
                'Konten disetujui',
                "Konten Anda telah disetujui oleh brand {$result->brandProfile?->brand_name}. Dana escrow telah dirilis ke wallet Anda.",
                ['content' => $result],
                route('kol.content.show', $result)
            );
        }

        return $result;
    }

    public function requestRevision(Content $content, string $notes): Content
    {
        $result = DB::transaction(function () use ($content, $notes) {
            $content->update([
                'status' => ContentStatus::REVISION_REQUESTED,
            ]);

            ContentRevision::create([
                'content_id' => $content->id,
                'requested_by' => auth()->id(),
                'note' => $notes,
                'status' => 'pending',
            ]);

            return $content->fresh()->load('kolProfile.user', 'brandProfile');
        });

        if ($result->kolProfile?->user) {
            $this->notificationService->send(
                $result->kolProfile->user,
                'content_reminder',
                'Revisi konten diminta',
                "Brand {$result->brandProfile?->brand_name} meminta revisi untuk konten Anda.",
                ['content' => $result],
                route('kol.content.show', $result)
            );
        }

        return $result;
    }

    public function reject(Content $content, string $reason): Content
    {
        $result = DB::transaction(function () use ($content, $reason) {
            $content->update([
                'status' => ContentStatus::REJECTED,
                'notes' => $reason,
            ]);

            return $content->fresh()->load('kolProfile.user', 'brandProfile');
        });

        if ($result->kolProfile?->user) {
            $this->notificationService->send(
                $result->kolProfile->user,
                'content_reminder',
                'Konten ditolak',
                "Konten Anda ditolak oleh brand {$result->brandProfile?->brand_name}.",
                ['content' => $result],
                route('kol.content.show', $result)
            );
        }

        return $result;
    }

    public function getKolContents(KolProfile $kolProfile, ?string $status = null): Collection
    {
        $query = Content::with(['agreement.hiring.campaign', 'brandProfile.user'])
            ->where('kol_profile_id', $kolProfile->id);

        if ($status) {
            $query->where('status', $status);
        }

        return $query->orderBy('created_at', 'desc')->get();
    }

    public function getBrandContents(BrandProfile $brandProfile, ?string $status = null): Collection
    {
        $query = Content::with(['agreement.hiring.campaign', 'kolProfile.user'])
            ->where('brand_profile_id', $brandProfile->id);

        if ($status) {
            $query->where('status', $status);
        }

        return $query->orderBy('created_at', 'desc')->get();
    }
}
