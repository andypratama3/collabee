<?php

namespace App\Http\Controllers\Api\V1;

use App\Enums\CampaignStatus;
use App\Http\Controllers\Controller;
use App\Http\Responses\ApiResponse;
use App\Models\Campaign;
use App\Models\HiringApplication;
use App\Services\Campaign\CampaignService;
use App\Services\Campaign\HiringService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CampaignController extends Controller
{
    public function __construct(
        private readonly CampaignService $campaignService,
        private readonly HiringService $hiringService,
    ) {}

    public function index(Request $request): JsonResponse
    {
        $filters = $request->only(['platforms', 'kol_category', 'budget_min', 'budget_max', 'search']);
        $campaigns = $this->campaignService->getExploreCampaigns($filters);

        return ApiResponse::paginated($campaigns, 'Daftar campaign berhasil diambil.');
    }

    public function show(Campaign $campaign): JsonResponse
    {
        $campaign->load([
            'brandProfile.user',
            'hirings.kolProfile.user',
            'hiringApplications.kolProfile.user',
        ]);

        $campaign->loadCount('hirings', 'hiringApplications');

        return ApiResponse::success($campaign, 'Detail campaign berhasil diambil.');
    }

    public function store(Request $request): JsonResponse
    {
        $user = $request->user();

        if (!$user->isBrand()) {
            return ApiResponse::error('Hanya brand yang dapat membuat campaign.', 403);
        }

        $brandProfile = $user->brandProfile;

        if (!$brandProfile) {
            return ApiResponse::error('Lengkapi profil brand terlebih dahulu.', 400);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'brief' => 'nullable|string',
            'objectives' => 'nullable|array',
            'platforms' => 'required|array',
            'platforms.*' => 'string',
            'content_types' => 'nullable|array',
            'content_types.*' => 'string',
            'kol_category' => 'nullable|string|max:255',
            'min_followers' => 'nullable|integer|min:0',
            'max_followers' => 'nullable|integer|min:0',
            'min_engagement' => 'nullable|numeric|min:0|max:100',
            'location' => 'nullable|string|max:255',
            'budget_total' => 'required|numeric|min:0',
            'budget_per_kol' => 'required|numeric|min:0',
            'kol_slots' => 'required|integer|min:1',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'deadline_apply' => 'nullable|date|before_or_equal:end_date',
        ]);

        $validated['status'] = CampaignStatus::DRAFT;

        $campaign = $this->campaignService->create($brandProfile, $validated);

        return ApiResponse::success($campaign, 'Campaign berhasil dibuat.', 201);
    }

    public function update(Request $request, Campaign $campaign): JsonResponse
    {
        $user = $request->user();

        if (!$user->isBrand()) {
            return ApiResponse::error('Hanya brand yang dapat mengubah campaign.', 403);
        }

        if ($campaign->brandProfile->user_id !== $user->id) {
            return ApiResponse::error('Anda tidak memiliki akses ke campaign ini.', 403);
        }

        $validated = $request->validate([
            'title' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'brief' => 'nullable|string',
            'objectives' => 'nullable|array',
            'platforms' => 'sometimes|array',
            'platforms.*' => 'string',
            'content_types' => 'nullable|array',
            'content_types.*' => 'string',
            'kol_category' => 'nullable|string|max:255',
            'min_followers' => 'nullable|integer|min:0',
            'max_followers' => 'nullable|integer|min:0',
            'min_engagement' => 'nullable|numeric|min:0|max:100',
            'location' => 'nullable|string|max:255',
            'budget_total' => 'sometimes|numeric|min:0',
            'budget_per_kol' => 'sometimes|numeric|min:0',
            'kol_slots' => 'sometimes|integer|min:1',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'deadline_apply' => 'nullable|date|before_or_equal:end_date',
        ]);

        $campaign = $this->campaignService->update($campaign, $validated);

        return ApiResponse::success($campaign, 'Campaign berhasil diperbarui.');
    }

    public function apply(Request $request, Campaign $campaign): JsonResponse
    {
        $user = $request->user();

        if (!$user->isKol()) {
            return ApiResponse::error('Hanya KOL yang dapat melamar campaign.', 403);
        }

        $kolProfile = $user->kolProfile;

        if (!$kolProfile) {
            return ApiResponse::error('Lengkapi profil KOL terlebih dahulu.', 400);
        }

        $validated = $request->validate([
            'proposed_budget' => 'nullable|numeric|min:0',
            'message' => 'nullable|string|max:1000',
        ]);

        try {
            $application = $this->hiringService->apply($campaign, $kolProfile, $validated);
            return ApiResponse::success($application, 'Lamaran berhasil dikirim.', 201);
        } catch (\RuntimeException $e) {
            return ApiResponse::error($e->getMessage(), 400);
        }
    }
}
