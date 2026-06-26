<?php

namespace App\Livewire\Admin;

use App\Models\Dispute;
use Livewire\Component;
use Livewire\WithPagination;

class DisputeManagement extends Component
{
    use WithPagination;

    public string $statusFilter = '';

    public ?int $selectedDisputeId = null;

    public bool $showResolveModal = false;

    public string $resolution = '';

    public bool $showNoteModal = false;

    public string $note = '';

    protected $queryString = ['statusFilter'];

    protected $rules = [
        'resolution' => 'required|string|min:10',
        'note' => 'required|string|min:5',
    ];

    public function updatingStatusFilter(): void
    {
        $this->resetPage();
    }

    public function confirmResolve(Dispute $dispute): void
    {
        $this->selectedDisputeId = $dispute->id;
        $this->resolution = '';
        $this->showResolveModal = true;
    }

    public function resolve(): void
    {
        $this->validate(['resolution' => 'required|string|min:10']);

        $dispute = Dispute::findOrFail($this->selectedDisputeId);
        $existingNotes = $dispute->admin_notes ? json_decode($dispute->admin_notes, true) : [];
        $existingNotes[] = [
            'type' => 'resolution',
            'message' => $this->resolution,
            'admin_id' => auth()->id(),
            'created_at' => now()->toISOString(),
        ];

        $dispute->update([
            'status' => 'resolved',
            'admin_notes' => json_encode($existingNotes),
            'resolved_at' => now(),
        ]);

        $this->showResolveModal = false;
        $this->selectedDisputeId = null;
        $this->resolution = '';

        session()->flash('success', 'Dispute berhasil diselesaikan.');
    }

    public function confirmAddNote(Dispute $dispute): void
    {
        $this->selectedDisputeId = $dispute->id;
        $this->note = '';
        $this->showNoteModal = true;
    }

    public function addNote(): void
    {
        $this->validate(['note' => 'required|string|min:5']);

        $dispute = Dispute::findOrFail($this->selectedDisputeId);
        $existingNotes = $dispute->admin_notes ? json_decode($dispute->admin_notes, true) : [];
        $existingNotes[] = [
            'type' => 'note',
            'message' => $this->note,
            'admin_id' => auth()->id(),
            'created_at' => now()->toISOString(),
        ];

        $dispute->update([
            'admin_notes' => json_encode($existingNotes),
        ]);

        $this->showNoteModal = false;
        $this->selectedDisputeId = null;
        $this->note = '';

        session()->flash('success', 'Catatan berhasil ditambahkan.');
    }

    public function render()
    {
        $query = Dispute::with(['hiring.campaign.brandProfile.user', 'raisedBy', 'against']);

        if ($this->statusFilter) {
            $query->where('status', $this->statusFilter);
        }

        return view('admin.disputes', [
            'disputes' => $query->latest()->paginate(15),
        ])->layout('layouts.app');
    }
}
