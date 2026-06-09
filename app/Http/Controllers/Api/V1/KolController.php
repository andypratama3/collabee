<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Responses\ApiResponse;
use App\Models\KolProfile;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class KolController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = KolProfile::query()
            ->with(['user', 'socialAccounts'])
            ->withCount('portfolios', 'hirings')
            ->where('is_open_for_work', true);

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->filled('sub_category')) {
            $query->whereJsonContains('sub_categories', $request->sub_category);
        }

        if ($request->filled('location')) {
            $query->where('location', 'like', '%' . $request->location . '%');
        }

        if ($request->filled('followers_min')) {
            $query->where('total_followers', '>=', (int) $request->followers_min);
        }

        if ($request->filled('followers_max')) {
            $query->where('total_followers', '<=', (int) $request->followers_max);
        }

        if ($request->filled('engagement_min')) {
            $query->where('avg_engagement_rate', '>=', (float) $request->engagement_min);
        }

        if ($request->filled('budget_max')) {
            $query->where('min_budget', '<=', (float) $request->budget_max);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('display_name', 'like', '%' . $search . '%')
                    ->orWhere('bio', 'like', '%' . $search . '%');
            });
        }

        $sortField = $request->sort ?? 'total_followers';
        $sortDir = $request->direction ?? 'desc';
        $allowedSorts = ['total_followers', 'avg_engagement_rate', 'rating_avg', 'total_campaigns_done', 'min_budget'];
        $query->orderBy(in_array($sortField, $allowedSorts) ? $sortField : 'total_followers', $sortDir === 'asc' ? 'asc' : 'desc');

        $perPage = min((int) $request->per_page, 50) ?: 15;
        $kols = $query->paginate($perPage);

        return ApiResponse::paginated($kols, 'Daftar KOL berhasil diambil.');
    }

    public function show(KolProfile $kolProfile): JsonResponse
    {
        $kolProfile->load([
            'user',
            'socialAccounts',
            'portfolios',
            'rateCards' => fn($q) => $q->where('is_active', true),
            'bankAccount',
        ]);

        $kolProfile->loadCount(['hirings as completed_hirings_count' => fn($q) => $q->where('status', \App\Enums\HiringStatus::COMPLETED)]);

        return ApiResponse::success($kolProfile, 'Detail KOL berhasil diambil.');
    }

    public function portfolio(KolProfile $kolProfile): JsonResponse
    {
        $portfolios = $kolProfile->portfolios()->orderBy('sort_order')->get();

        return ApiResponse::success($portfolios, 'Portfolio KOL berhasil diambil.');
    }
}
