<?php

namespace App\Livewire\Brand\Content;

use App\Models\Content;
use App\Services\Content\ContentService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class Show extends Component
{
    use AuthorizesRequests;

    public Content $content;
    public string $revisionNotes = '';
    public string $rejectReason = '';

    public function mount(Content $content): void
    {
        $this->authorize('review', $content);
        $content->load(['agreement.hiring.campaign', 'kolProfile.user', 'revisions.requester', 'media']);
        $this->content = $content;
    }

    public function render()
    {
        return view('livewire.brand.content.show', [
            'content' => $this->content,
        ])->layout('layouts.app');
    }

    public function approve(ContentService $contentService): void
    {
        $this->authorize('review', $this->content);

        $contentService->approve($this->content);
        $this->content->refresh();

        session()->flash('success', 'Konten berhasil disetujui. Dana escrow telah dirilis ke KOL.');
        $this->redirect(route('shared.rating.create', [
            'hiring' => $this->content->agreement->hiring_id,
            'type' => 'kol',
        ]), navigate: true);
    }

    public function requestRevision(ContentService $contentService): void
    {
        $this->authorize('review', $this->content);

        $this->validate([
            'revisionNotes' => 'required|string|min:10',
        ]);

        $contentService->requestRevision($this->content, $this->revisionNotes);
        $this->content->refresh();
        $this->revisionNotes = '';

        session()->flash('success', 'Revisi berhasil diminta.');
    }

    public function reject(ContentService $contentService): void
    {
        $this->authorize('review', $this->content);

        $this->validate([
            'rejectReason' => 'required|string|min:10',
        ]);

        $contentService->reject($this->content, $this->rejectReason);
        $this->content->refresh();
        $this->rejectReason = '';

        session()->flash('success', 'Konten berhasil ditolak.');
    }
}
