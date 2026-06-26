<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Responses\ApiResponse;
use App\Models\Campaign;
use App\Models\Hiring;
use App\Models\KolProfile;
use App\Services\Campaign\HiringService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class HiringController extends Controller
{
    public function __construct(
        private readonly HiringService $hiringService,
    ) {}

    public function index(Request $request): JsonResponse
    {
        $user = $request->user();
        $status = $request->status;

        if ($user->isBrand()) {
            $brandProfile = $user->brandProfile;
            if (! $brandProfile) {
                return ApiResponse::error('Profil brand tidak ditemukan.', 400);
            }
            $hirings = $this->hiringService->getBrandHirings($brandProfile, $status);
        } elseif ($user->isKol()) {
            $kolProfile = $user->kolProfile;
            if (! $kolProfile) {
                return ApiResponse::error('Profil KOL tidak ditemukan.', 400);
            }
            $hirings = $this->hiringService->getKolHirings($kolProfile, $status);
        } else {
            return ApiResponse::error('Tipe pengguna tidak valid.', 403);
        }

        return ApiResponse::success($hirings, 'Daftar hiring berhasil diambil.');
    }

    public function store(Request $request): JsonResponse
    {
        $user = $request->user();

        if (! $user->isBrand()) {
            return ApiResponse::error('Hanya brand yang dapat melakukan hiring.', 403);
        }

        $brandProfile = $user->brandProfile;
        if (! $brandProfile) {
            return ApiResponse::error('Profil brand tidak ditemukan.', 400);
        }

        $validated = $request->validate([
            'campaign_id' => 'required|exists:campaigns,id',
            'kol_profile_id' => 'required|exists:kol_profiles,id',
            'message' => 'nullable|string|max:1000',
            'proposed_budget' => 'nullable|numeric|min:0',
        ]);

        $campaign = Campaign::findOrFail($validated['campaign_id']);
        $kolProfile = KolProfile::findOrFail($validated['kol_profile_id']);

        if ($campaign->brandProfile->user_id !== $user->id) {
            return ApiResponse::error('Anda tidak memiliki akses ke campaign ini.', 403);
        }

        try {
            $hiring = $this->hiringService->brandHire($campaign, $brandProfile, $kolProfile, $validated);

            return ApiResponse::success($hiring, 'Undangan kerja sama berhasil dikirim.', 201);
        } catch (\RuntimeException $e) {
            return ApiResponse::error($e->getMessage(), 400);
        }
    }

    public function accept(Request $request, Hiring $hiring): JsonResponse
    {
        $user = $request->user();

        if (! $user->isKol() || ! $user->kolProfile || $hiring->kol_profile_id !== $user->kolProfile->id) {
            return ApiResponse::error('Anda tidak memiliki akses ke hiring ini.', 403);
        }

        try {
            $hiring = $this->hiringService->accept($hiring);

            return ApiResponse::success($hiring, 'Undangan kerja sama diterima.');
        } catch (\RuntimeException $e) {
            return ApiResponse::error($e->getMessage(), 400);
        }
    }

    public function reject(Request $request, Hiring $hiring): JsonResponse
    {
        $user = $request->user();

        if (! $user->isKol() || ! $user->kolProfile || $hiring->kol_profile_id !== $user->kolProfile->id) {
            return ApiResponse::error('Anda tidak memiliki akses ke hiring ini.', 403);
        }

        $reason = $request->input('reason');

        try {
            $hiring = $this->hiringService->reject($hiring, $reason);

            return ApiResponse::success($hiring, 'Undangan kerja sama ditolak.');
        } catch (\RuntimeException $e) {
            return ApiResponse::error($e->getMessage(), 400);
        }
    }
}
