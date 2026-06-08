<?php

namespace App\Livewire\Kol\Content;

use App\Enums\ContentStatus;
use App\Models\Content;
use App\Services\Content\ContentService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class Show extends Component
{
    use AuthorizesRequests;

    public Content $content;

    public function mount(Content $content): void
    {
        $this->authorize('view', $content);
        $content->load(['agreement.hiring.campaign', 'revisions.requester', 'media']);
        $this->content = $content;
    }

    public function render()
    {
        return view('livewire.kol.content.show', [
            'content' => $this->content,
        ])->layout('layouts.app');
    }

    public function submit(ContentService $contentService): void
    {
        $this->authorize('update', $this->content);

        $contentService->submit($this->content);
        $this->content->refresh();

        session()->flash('success', 'Konten berhasil dikirim untuk review.');
    }
}
