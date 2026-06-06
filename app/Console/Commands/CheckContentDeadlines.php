<?php

namespace App\Console\Commands;

use App\Enums\ContentStatus;
use App\Models\Content;
use App\Services\Notification\NotificationService;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CheckContentDeadlines extends Command
{
    protected $signature = 'content:check-deadlines';
    protected $description = 'Auto-escalate content submissions past deadline';

    public function __construct(
        private readonly NotificationService $notificationService
    ) {
        parent::__construct();
    }

    public function handle(): int
    {
        $now = Carbon::now();

        $overdue = Content::query()
            ->with(['brandProfile.user', 'kolProfile.user'])
            ->whereNull('approved_at')
            ->whereIn('status', [ContentStatus::SUBMITTED, ContentStatus::UNDER_REVIEW, ContentStatus::REVISION_REQUESTED])
            ->whereNotNull('deadline_at')
            ->where('deadline_at', '<', $now)
            ->get();

        $count = 0;

        foreach ($overdue as $content) {
            $content->update(['status' => ContentStatus::ESCALATED]);

            $brandUser = $content->brandProfile?->user;
            $kolUser = $content->kolProfile?->user;

            if ($brandUser) {
                $this->notificationService->send(
                    $brandUser,
                    'content_reminder',
                    'Konten melewati batas waktu',
                    "Konten untuk campaign telah melewati batas waktu persetujuan dan otomatis dieskalasi.",
                    ['content' => $content]
                );
            }

            if ($kolUser) {
                $this->notificationService->send(
                    $kolUser,
                    'content_reminder',
                    'Konten dieskalasi',
                    "Konten Anda telah dieskalasi karena melewati batas waktu. Segera hubungi brand untuk tindak lanjut.",
                    ['content' => $content]
                );
            }

            activity()
                ->performedOn($content)
                ->withProperties([
                    'content_id' => $content->id,
                    'agreement_id' => $content->agreement_id,
                    'status' => ContentStatus::ESCALATED->value,
                    'deadline_at' => $content->deadline_at?->toDateTimeString(),
                ])
                ->log('Konten dieskalasi karena melewati batas waktu');

            $count++;
        }

        $this->info("Escalated {$count} overdue content(s).");

        return Command::SUCCESS;
    }
}
