<?php

namespace App\Console\Commands;

use App\Enums\ContentStatus;
use App\Models\Content;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CheckContentDeadlines extends Command
{
    protected $signature = 'content:check-deadlines';
    protected $description = 'Auto-escalate content submissions past deadline for escalation';

    public function handle(): int
    {
        $now = Carbon::now();

        $overdue = Content::query()
            ->whereNull('approved_at')
            ->whereIn('status', [ContentStatus::SUBMITTED, ContentStatus::UNDER_REVIEW, ContentStatus::REVISION_REQUESTED])
            ->where('deadline_at', '<', $now)
            ->whereHas('agreement', fn($q) => $q->where('content_approval_deadline', '<', $now))
            ->get();

        $count = 0;

        foreach ($overdue as $content) {
            activity()
                ->performedOn($content)
                ->withProperties([
                    'content_id' => $content->id,
                    'agreement_id' => $content->agreement_id,
                    'status' => $content->status->value,
                    'deadline_at' => $content->deadline_at?->toDateTimeString(),
                    'submitted_at' => $content->submitted_at?->toDateTimeString(),
                ])
                ->log('Konten melewati batas waktu persetujuan, perlu eskalasi');

            $count++;
        }

        $this->info("Checked {$count} overdue content(s) for escalation.");

        return Command::SUCCESS;
    }
}
