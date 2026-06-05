<?php

namespace App\Services\Rating;

use App\Models\Hiring;
use App\Models\KolProfile;
use App\Models\PlatformReview;
use App\Models\Rating;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class RatingService
{
    public function rateKol(Hiring $hiring, User $rater, array $data): Rating
    {
        return DB::transaction(function () use ($hiring, $rater, $data) {
            $overall = round((
                $data['communication'] +
                $data['professionalism'] +
                $data['quality'] +
                $data['timeliness']
            ) / 4, 2);

            $rating = Rating::create([
                'hiring_id' => $hiring->id,
                'rater_id' => $rater->id,
                'rated_id' => $hiring->kolProfile->user_id,
                'type' => 'kol',
                'communication' => $data['communication'],
                'professionalism' => $data['professionalism'],
                'quality' => $data['quality'],
                'timeliness' => $data['timeliness'],
                'overall' => $overall,
                'review' => $data['review'] ?? null,
            ]);

            $profile = $hiring->kolProfile;
            $profile->update([
                'rating_avg' => Rating::where('rated_id', $profile->user_id)
                    ->where('type', 'kol')
                    ->avg('overall'),
                'rating_count' => Rating::where('rated_id', $profile->user_id)
                    ->where('type', 'kol')
                    ->count(),
            ]);

            return $rating;
        });
    }

    public function rateBrand(Hiring $hiring, User $rater, array $data): Rating
    {
        return DB::transaction(function () use ($hiring, $rater, $data) {
            $overall = round((
                $data['communication'] +
                $data['professionalism'] +
                $data['quality'] +
                $data['timeliness']
            ) / 4, 2);

            $rating = Rating::create([
                'hiring_id' => $hiring->id,
                'rater_id' => $rater->id,
                'rated_id' => $hiring->brandProfile->user_id,
                'type' => 'brand',
                'communication' => $data['communication'],
                'professionalism' => $data['professionalism'],
                'quality' => $data['quality'],
                'timeliness' => $data['timeliness'],
                'overall' => $overall,
                'review' => $data['review'] ?? null,
            ]);

            $profile = $hiring->brandProfile;
            $profile->update([
                'rating_avg' => Rating::where('rated_id', $profile->user_id)
                    ->where('type', 'brand')
                    ->avg('overall'),
                'rating_count' => Rating::where('rated_id', $profile->user_id)
                    ->where('type', 'brand')
                    ->count(),
            ]);

            return $rating;
        });
    }

    public function submitPlatformReview(User $user, array $data): PlatformReview
    {
        return DB::transaction(function () use ($user, $data) {
            return PlatformReview::create([
                'user_id' => $user->id,
                'rating' => $data['rating'],
                'review' => $data['review'] ?? null,
            ]);
        });
    }

    public function getProfileRating(KolProfile $kolProfile): array
    {
        $ratings = Rating::whereHas('hiring', function ($q) use ($kolProfile) {
            $q->where('kol_profile_id', $kolProfile->id);
        })->where('type', 'kol');

        return [
            'average' => round($ratings->avg('overall'), 2),
            'count' => $ratings->count(),
            'dimensions' => [
                'communication' => round($ratings->avg('communication'), 2),
                'professionalism' => round($ratings->avg('professionalism'), 2),
                'quality' => round($ratings->avg('quality'), 2),
                'timeliness' => round($ratings->avg('timeliness'), 2),
            ],
        ];
    }
}
