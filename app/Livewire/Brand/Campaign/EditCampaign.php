<?php

namespace App\Livewire\Brand\Campaign;

use App\Models\Campaign;
use App\Services\Campaign\CampaignService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class EditCampaign extends Component
{
    use AuthorizesRequests;

    public Campaign $campaign;
    public string $title = '';
    public string $description = '';
    public ?string $objectives = null;
    public array $platforms = [];
    public array $content_types = [];
    public ?string $kol_category = null;
    public ?int $min_followers = null;
    public ?int $max_followers = null;
    public ?float $min_engagement = null;
    public string $target_gender = 'all';
    public ?string $location = null;
    public ?string $brief = null;
    public float $budget_total = 0;
    public ?float $budget_per_kol = null;
    public int $kol_slots = 1;
    public string $start_date = '';
    public string $end_date = '';
    public string $deadline_apply = '';

    public function mount(Campaign $campaign): void
    {
        $this->authorize('update', $campaign);
        $this->campaign = $campaign;
        $this->title = $campaign->title;
        $this->description = $campaign->description;
        $this->objectives = $campaign->objectives ? implode("\n", $campaign->objectives) : null;
        $this->platforms = $campaign->platforms ?? [];
        $this->content_types = $campaign->content_types ?? [];
        $this->kol_category = $campaign->kol_category;
        $this->min_followers = $campaign->min_followers;
        $this->max_followers = $campaign->max_followers;
        $this->min_engagement = $campaign->min_engagement;
        $this->target_gender = $campaign->target_gender;
        $this->location = $campaign->location;
        $this->brief = $campaign->brief;
        $this->budget_total = (float) $campaign->budget_total;
        $this->budget_per_kol = $campaign->budget_per_kol ? (float) $campaign->budget_per_kol : null;
        $this->kol_slots = $campaign->kol_slots;
        $this->start_date = $campaign->start_date->format('Y-m-d');
        $this->end_date = $campaign->end_date->format('Y-m-d');
        $this->deadline_apply = $campaign->deadline_apply->format('Y-m-d');
    }

    public function render()
    {
        return view('livewire.brand.campaign.edit-campaign')
            ->layout('layouts.app');
    }

    public function save(CampaignService $campaignService): void
    {
        $this->validate();

        $data = [
            'title' => $this->title,
            'description' => $this->description,
            'objectives' => $this->objectives ? array_map('trim', explode("\n", $this->objectives)) : null,
            'platforms' => $this->platforms,
            'content_types' => $this->content_types,
            'kol_category' => $this->kol_category,
            'min_followers' => $this->min_followers,
            'max_followers' => $this->max_followers,
            'min_engagement' => $this->min_engagement,
            'target_gender' => $this->target_gender,
            'location' => $this->location,
            'brief' => $this->brief,
            'budget_total' => $this->budget_total,
            'budget_per_kol' => $this->budget_per_kol,
            'kol_slots' => $this->kol_slots,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'deadline_apply' => $this->deadline_apply,
        ];

        $campaignService->update($this->campaign, $data);

        session()->flash('success', 'Campaign updated successfully.');
        $this->redirectRoute('brand.campaign.index', navigate: true);
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:500',
            'description' => 'required|string|min:50',
            'platforms' => 'required|array|min:1',
            'platforms.*' => 'string',
            'content_types' => 'required|array|min:1',
            'content_types.*' => 'string',
            'kol_category' => 'nullable|string|max:100',
            'min_followers' => 'nullable|integer|min:0',
            'max_followers' => 'nullable|integer|min:0|gte:min_followers',
            'min_engagement' => 'nullable|numeric|min:0|max:100',
            'target_gender' => 'required|string|in:all,male,female',
            'location' => 'nullable|string|max:255',
            'brief' => 'nullable|string',
            'budget_total' => 'required|numeric|min:0',
            'budget_per_kol' => 'nullable|numeric|min:0|lte:budget_total',
            'kol_slots' => 'required|integer|min:1|max:100',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'deadline_apply' => 'required|date|before_or_equal:start_date',
        ];
    }

    public function togglePlatform(string $platform): void
    {
        if (in_array($platform, $this->platforms)) {
            $this->platforms = array_values(array_filter($this->platforms, fn($p) => $p !== $platform));
        } else {
            $this->platforms[] = $platform;
        }
    }

    public function toggleContentType(string $type): void
    {
        if (in_array($type, $this->content_types)) {
            $this->content_types = array_values(array_filter($this->content_types, fn($t) => $t !== $type));
        } else {
            $this->content_types[] = $type;
        }
    }
}
