<?php

namespace App\Livewire\Kol\Content;

use App\Models\Agreement;
use App\Services\Content\ContentService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Collection;
use Livewire\Component;
use Livewire\WithFileUploads;

class Create extends Component
{
    use AuthorizesRequests, WithFileUploads;

    public string $title = '';
    public string $caption = '';
    public array $files = [];
    public ?int $agreement_id = null;

    public function render()
    {
        $user = auth()->user();
        $profile = $user->kolProfile;

        $agreements = Agreement::whereHas('hiring', function ($q) use ($profile) {
            $q->where('kol_profile_id', $profile->id);
        })->where('status', 'signed')->with('hiring.campaign')->get();

        return view('livewire.kol.content.create', [
            'agreements' => $agreements,
        ])->layout('layouts.app');
    }

    public function save(ContentService $contentService): void
    {
        $this->validate([
            'title' => 'required|string|max:255',
            'caption' => 'nullable|string',
            'files.*' => 'nullable|file|mimes:jpg,jpeg,png,gif,webp,mp4,mov,avi,pdf,doc,docx|max:51200',
            'agreement_id' => 'required|exists:agreements,id',
        ]);

        $user = auth()->user();
        $profile = $user->kolProfile;
        $agreement = Agreement::findOrFail($this->agreement_id);

        $contentService->upload(
            $profile,
            $agreement,
            [
                'title' => $this->title,
                'caption' => $this->caption,
            ],
            collect($this->files)
        );

        session()->flash('success', 'Konten berhasil diupload.');
        $this->redirect(route('kol.content.index'), navigate: true);
    }
}
