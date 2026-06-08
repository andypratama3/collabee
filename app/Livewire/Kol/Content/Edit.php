<?php

namespace App\Livewire\Kol\Content;

use App\Models\Content;
use App\Services\Content\ContentService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use Livewire\WithFileUploads;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Edit extends Component
{
    use AuthorizesRequests, WithFileUploads;

    public Content $content;
    public string $title = '';
    public string $caption = '';
    public array $files = [];
    public array $deletedMediaIds = [];

    public function mount(Content $content): void
    {
        $this->authorize('update', $content);
        $content->load(['agreement.hiring.campaign', 'revisions.requester', 'media']);
        $this->content = $content;
        $this->title = $content->title;
        $this->caption = $content->caption ?? '';
    }

    public function render()
    {
        return view('livewire.kol.content.edit', [
            'content' => $this->content,
            'mediaItems' => $this->content->getMedia('content_files'),
        ])->layout('layouts.app');
    }

    public function removeMedia(int $mediaId): void
    {
        $media = Media::find($mediaId);
        if ($media && $media->model_type === Content::class && $media->model_id === $this->content->id) {
            $this->deletedMediaIds[] = $mediaId;
        }
    }

    public function save(ContentService $contentService): void
    {
        $this->authorize('update', $this->content);

        $this->validate([
            'title' => 'required|string|max:255',
            'caption' => 'nullable|string',
            'files.*' => 'nullable|file|mimes:jpg,jpeg,png,gif,webp,mp4,mov,avi,pdf,doc,docx|max:51200',
        ]);

        $this->content->update([
            'title' => $this->title,
            'caption' => $this->caption,
        ]);

        foreach ($this->deletedMediaIds as $mediaId) {
            $media = Media::find($mediaId);
            if ($media && $media->model_type === Content::class && $media->model_id === $this->content->id) {
                $media->delete();
            }
        }

        foreach ($this->files as $file) {
            $this->content->addMedia($file)->toMediaCollection('content_files');
        }

        $wasRevisionRequested = $this->content->status->value === 'revision_requested';

        $this->content->refresh();

        if ($wasRevisionRequested) {
            $contentService->submit($this->content);
            session()->flash('success', 'Konten berhasil diperbarui dan dikirim ulang untuk review.');
        } else {
            session()->flash('success', 'Konten berhasil diperbarui.');
        }

        $this->redirect(route('kol.content.show', $this->content), navigate: true);
    }
}
