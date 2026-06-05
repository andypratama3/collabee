<?php

use App\Enums\HiringStatus;
use App\Models\BrandProfile;
use App\Models\Campaign;
use App\Models\Hiring;
use App\Models\KolProfile;
use App\Models\Rating;
use App\Models\User;
use App\Services\Rating\RatingService;

beforeEach(function () {
    $this->ratingService = app(RatingService::class);

    $this->brandUser = User::factory()->brand()->create();
    $this->kolUser = User::factory()->kol()->create();
    $brandProfile = BrandProfile::factory()->create(['user_id' => $this->brandUser->id]);
    $this->kolProfile = KolProfile::factory()->create(['user_id' => $this->kolUser->id]);
    $campaign = Campaign::factory()->create(['brand_profile_id' => $brandProfile->id]);
    $this->hiring = Hiring::factory()->create([
        'campaign_id' => $campaign->id,
        'brand_profile_id' => $brandProfile->id,
        'kol_profile_id' => $this->kolProfile->id,
        'status' => HiringStatus::COMPLETED,
    ]);
});

test('rateKol creates rating with correct dimensions', function () {
    $data = [
        'communication' => 5,
        'professionalism' => 4,
        'quality' => 5,
        'timeliness' => 4,
        'review' => 'Great work!',
    ];

    $rating = $this->ratingService->rateKol($this->hiring, $this->brandUser, $data);

    expect($rating)->toBeInstanceOf(Rating::class)
        ->and($rating->hiring_id)->toBe($this->hiring->id)
        ->and($rating->rater_id)->toBe($this->brandUser->id)
        ->and($rating->rated_id)->toBe($this->kolUser->id)
        ->and($rating->type)->toBe('kol')
        ->and($rating->communication)->toBe(5)
        ->and($rating->professionalism)->toBe(4)
        ->and($rating->quality)->toBe(5)
        ->and($rating->timeliness)->toBe(4)
        ->and($rating->review)->toBe('Great work!');
});

test('auto-calculates overall rating correctly', function () {
    $rating = $this->ratingService->rateKol($this->hiring, $this->brandUser, [
        'communication' => 5,
        'professionalism' => 4,
        'quality' => 5,
        'timeliness' => 4,
    ]);

    expect($rating->overall)->toEqual(4.5);
});

test('getProfileRating returns stats', function () {
    $this->ratingService->rateKol($this->hiring, $this->brandUser, [
        'communication' => 5,
        'professionalism' => 4,
        'quality' => 5,
        'timeliness' => 4,
    ]);

    $stats = $this->ratingService->getProfileRating($this->kolProfile);

    expect($stats)->toHaveKeys(['average', 'count', 'dimensions'])
        ->and($stats['average'])->toEqual(4.5)
        ->and($stats['count'])->toBe(1)
        ->and($stats['dimensions'])->toHaveKeys(['communication', 'professionalism', 'quality', 'timeliness'])
        ->and($stats['dimensions']['communication'])->toEqual(5.0);
});
