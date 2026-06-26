<?php

namespace App\Services\Content;

use App\Models\Content;
use Illuminate\Support\Str;

class SocialPostService
{
    public function generateTrackingUrl(Content $content): string
    {
        if (! $content->tracking_code) {
            $content->update([
                'tracking_code' => Str::random(12),
                'click_count' => 0,
            ]);
        }

        return route('track.click', ['trackingCode' => $content->tracking_code]);
    }

    public function recordClick(string $trackingCode): ?Content
    {
        $content = Content::query()->where('tracking_code', $trackingCode)->first();

        if (! $content) {
            return null;
        }

        $content->increment('click_count');

        activity()
            ->performedOn($content)
            ->withProperties(['tracking_code' => $trackingCode, 'click_count' => $content->click_count])
            ->log('Tracking URL diklik');

        return $content;
    }

    public function getStats(Content $content): array
    {
        return [
            'tracking_code' => $content->tracking_code,
            'click_count' => $content->click_count ?? 0,
            'tracking_url' => $content->tracking_code
                ? route('track.click', ['trackingCode' => $content->tracking_code])
                : null,
            'post_url' => $content->post_url,
        ];
    }
}
