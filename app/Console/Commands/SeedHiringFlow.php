<?php

namespace App\Console\Commands;

use App\Enums\CampaignStatus;
use App\Enums\HiringStatus;
use App\Models\Campaign;
use App\Models\Hiring;
use App\Models\KolProfile;
use App\Models\User;
use App\Services\Campaign\HiringService;
use Illuminate\Console\Command;

class SeedHiringFlow extends Command
{
    protected $signature = 'app:seed-hiring
        {action : apply | hire | accept}
        {--kol= : KOL ID or email}
        {--campaign= : Campaign ID}
        {--budget= : Proposed budget amount}
        {--message= : Optional message}
        {--diff-budget : Jika hire, gunakan budget berbeda dari campaign.budget_per_kol}';

    protected $description = 'Seed apply/hire flow untuk testing tanpa web UI';

    public function handle(HiringService $hiringService): int
    {
        $action = $this->argument('action');

        $available = ['apply', 'hire', 'accept'];
        if (! in_array($action, $available)) {
            $this->error('Action must be one of: '.implode(', ', $available));

            return Command::FAILURE;
        }

        return match ($action) {
            'apply' => $this->apply($hiringService),
            'hire' => $this->hire($hiringService),
            'accept' => $this->accept($hiringService),
        };
    }

    protected function apply(HiringService $hiringService): int
    {
        $kol = $this->resolveKol();
        if (! $kol) {
            return Command::FAILURE;
        }

        $campaign = $this->resolveCampaign();
        if (! $campaign) {
            return Command::FAILURE;
        }

        $budget = $this->option('budget')
            ? (int) $this->option('budget')
            : (int) $campaign->budget_per_kol;

        $message = $this->option('message') ?? 'Halo, saya tertarik untuk bergabung di campaign ini!';

        try {
            $application = $hiringService->apply($campaign, $kol, [
                'proposed_budget' => $budget,
                'message' => $message,
            ]);

            $this->info("✅ {$kol->display_name} applied to campaign \"{$campaign->title}\"");
            $this->line("   Application ID: {$application->id}");
            $this->line('   Budget: Rp '.number_format($budget, 0, ',', '.'));
        } catch (\RuntimeException $e) {
            $this->error($e->getMessage());

            return Command::FAILURE;
        }

        return Command::SUCCESS;
    }

    protected function hire(HiringService $hiringService): int
    {
        $brandUser = User::role('brand')->first();
        if (! $brandUser || ! $brandUser->brandProfile) {
            $this->error('No brand user found. Run DemoDataSeeder first.');

            return Command::FAILURE;
        }

        $kol = $this->resolveKol();
        if (! $kol) {
            return Command::FAILURE;
        }

        $campaign = $this->resolveCampaign();
        if (! $campaign) {
            return Command::FAILURE;
        }

        $proposedBudget = $this->option('budget')
            ? (int) $this->option('budget')
            : (int) $campaign->budget_per_kol;

        if ($this->option('diff-budget')) {
            $proposedBudget = (int) ($campaign->budget_per_kol * 0.8);
            $this->line('   (Using different budget: Rp '.number_format($proposedBudget, 0, ',', '.').')');
        }

        $message = $this->option('message') ?? 'Hai! Kami tertarik untuk mengajak Anda collaborate. Tertarik?';

        try {
            $hiring = $hiringService->brandHire($campaign, $brandUser->brandProfile, $kol, [
                'proposed_budget' => $proposedBudget,
                'message' => $message,
            ]);

            $this->info("✅ {$brandUser->brandProfile->brand_name} hired {$kol->display_name}");
            $this->line("   Hiring ID: {$hiring->id}");
            $this->line('   Budget: Rp '.number_format($proposedBudget, 0, ',', '.'));
            $this->line("   Status: {$hiring->status->value}");
        } catch (\RuntimeException $e) {
            $this->error($e->getMessage());

            return Command::FAILURE;
        }

        return Command::SUCCESS;
    }

    protected function accept(HiringService $hiringService): int
    {
        $kol = $this->resolveKol();
        if (! $kol) {
            return Command::FAILURE;
        }

        $hirings = Hiring::where('kol_profile_id', $kol->id)
            ->where('status', HiringStatus::PENDING)
            ->with('campaign')
            ->get();

        if ($hirings->isEmpty()) {
            $this->error("No pending hirings for {$kol->display_name}.");

            return Command::FAILURE;
        }

        if ($this->option('campaign')) {
            $hiring = $hirings->firstWhere('campaign_id', (int) $this->option('campaign'));
            if (! $hiring) {
                $this->error("No pending hiring for campaign ID {$this->option('campaign')}.");

                return Command::FAILURE;
            }
        } elseif ($hirings->count() > 1) {
            $this->table(['ID', 'Campaign', 'Budget'], $hirings->map(fn ($h) => [
                $h->id,
                $h->campaign?->title,
                'Rp '.number_format($h->proposed_budget ?? 0, 0, ',', '.'),
            ]));
            $id = $this->ask('Multiple pending hirings. Enter Hiring ID to accept');
            $hiring = $hirings->firstWhere('id', (int) $id);
            if (! $hiring) {
                $this->error('Invalid Hiring ID.');

                return Command::FAILURE;
            }
        } else {
            $hiring = $hirings->first();
        }

        $budget = $this->option('budget')
            ? (int) $this->option('budget')
            : null;

        try {
            $result = $hiringService->accept($hiring, $budget);
            $this->info("✅ {$kol->display_name} accepted hiring for \"{$result->campaign->title}\"");
            $this->line('   Agreed budget: Rp '.number_format($result->agreed_budget ?? 0, 0, ',', '.'));
            $this->line('   Agreement auto-generated.');
        } catch (\RuntimeException $e) {
            $this->error($e->getMessage());

            return Command::FAILURE;
        }

        return Command::SUCCESS;
    }

    protected function resolveKol(): ?KolProfile
    {
        $kolOption = $this->option('kol');

        if ($kolOption) {
            if (is_numeric($kolOption)) {
                $kol = KolProfile::find((int) $kolOption);
            } else {
                $user = User::where('email', $kolOption)->first();
                $kol = $user?->kolProfile;
            }

            if ($kol) {
                return $kol;
            }

            $this->warn("KOL '{$kolOption}' not found. Showing available KOLs:");
        }

        $kols = KolProfile::with('user')->get();
        if ($kols->isEmpty()) {
            $this->error('No KOL profiles found. Run DemoDataSeeder first.');

            return null;
        }

        $this->table(
            ['ID', 'Name', 'Email', 'Category', 'Location'],
            $kols->map(fn ($k) => [
                $k->id,
                $k->display_name,
                $k->user?->email,
                $k->category,
                $k->location,
            ])
        );

        $id = $this->ask('Enter KOL ID');
        $kol = $kols->firstWhere('id', (int) $id);

        if (! $kol) {
            $this->error('Invalid KOL ID.');

            return null;
        }

        return $kol;
    }

    protected function resolveCampaign(): ?Campaign
    {
        $campOption = $this->option('campaign');

        if ($campOption) {
            $campaign = Campaign::find((int) $campOption);
            if ($campaign) {
                return $campaign;
            }
            $this->warn("Campaign ID '{$campOption}' not found. Showing available campaigns:");
        }

        $campaigns = Campaign::whereIn('status', [CampaignStatus::OPEN, CampaignStatus::IN_PROGRESS])
            ->with('brandProfile')
            ->get();

        if ($campaigns->isEmpty()) {
            $this->error('No open campaigns found. Run DemoDataSeeder first.');

            return null;
        }

        $this->table(
            ['ID', 'Title', 'Brand', 'Budget/KOL', 'Slots'],
            $campaigns->map(fn ($c) => [
                $c->id,
                \Str::limit($c->title, 40),
                $c->brandProfile?->brand_name,
                'Rp '.number_format($c->budget_per_kol ?? 0, 0, ',', '.'),
                $c->kol_filled.'/'.$c->kol_slots,
            ])
        );

        $id = $this->ask('Enter Campaign ID');
        $campaign = $campaigns->firstWhere('id', (int) $id);

        if (! $campaign) {
            $this->error('Invalid Campaign ID.');

            return null;
        }

        return $campaign;
    }
}
