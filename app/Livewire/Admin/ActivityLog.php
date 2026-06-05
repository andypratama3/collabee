<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Activitylog\Models\Activity;

class ActivityLog extends Component
{
    use WithPagination;

    public string $search = '';
    public string $eventFilter = '';
    public string $dateFrom = '';
    public string $dateTo = '';
    public ?int $expandedId = null;

    protected $queryString = ['search', 'eventFilter', 'dateFrom', 'dateTo'];

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingEventFilter(): void
    {
        $this->resetPage();
    }

    public function updatingDateFrom(): void
    {
        $this->resetPage();
    }

    public function updatingDateTo(): void
    {
        $this->resetPage();
    }

    public function toggleExpand(int $id): void
    {
        $this->expandedId = $this->expandedId === $id ? null : $id;
    }

    public function render()
    {
        $query = Activity::query()->with('causer', 'subject');

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('description', 'like', '%' . $this->search . '%')
                    ->orWhereHas('causer', fn($q) => $q->where('name', 'like', '%' . $this->search . '%'))
                    ->orWhereHas('subject', fn($q) => $q->where('name', 'like', '%' . $this->search . '%'));
            });
        }

        if ($this->eventFilter) {
            $query->where('event', $this->eventFilter);
        }

        if ($this->dateFrom) {
            $query->whereDate('created_at', '>=', $this->dateFrom);
        }

        if ($this->dateTo) {
            $query->whereDate('created_at', '<=', $this->dateTo);
        }

        $events = Activity::query()
            ->whereNotNull('event')
            ->select('event')
            ->distinct()
            ->pluck('event')
            ->toArray();

        return view('livewire.admin.activity-log', [
            'activities' => $query->latest()->paginate(20),
            'events' => $events,
        ])->layout('layouts.app');
    }
}
