<?php

namespace App\Http\Controllers;

use App\Services\Content\SocialPostService;
use Illuminate\Http\RedirectResponse;

class TrackingController extends Controller
{
    public function __construct(
        private readonly SocialPostService $socialPostService
    ) {}

    public function click(string $trackingCode): RedirectResponse
    {
        $content = $this->socialPostService->recordClick($trackingCode);

        if (!$content) {
            abort(404, 'Tracking code tidak valid.');
        }

        if ($content->post_url) {
            return redirect()->away($content->post_url);
        }

        return redirect()->route('home');
    }
}
