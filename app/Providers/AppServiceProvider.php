<?php

namespace App\Providers;

use App\Models\Agreement;
use App\Models\Campaign;
use App\Models\ChatRoom;
use App\Models\Content;
use App\Models\Hiring;
use App\Policies\AgreementPolicy;
use App\Policies\CampaignPolicy;
use App\Policies\ChatPolicy;
use App\Policies\ContentPolicy;
use App\Policies\HiringPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Gate::policy(Campaign::class, CampaignPolicy::class);
        Gate::policy(Hiring::class, HiringPolicy::class);
        Gate::policy(Content::class, ContentPolicy::class);
        Gate::policy(ChatRoom::class, ChatPolicy::class);
        Gate::policy(Agreement::class, AgreementPolicy::class);
    }
}
