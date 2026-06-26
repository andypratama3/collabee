<?php

namespace App\Livewire\Admin;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class UserManagement extends Component
{
    use WithPagination;

    public string $search = '';

    public string $roleFilter = '';

    public string $statusFilter = '';

    protected $queryString = ['search', 'roleFilter', 'statusFilter'];

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingRoleFilter(): void
    {
        $this->resetPage();
    }

    public function updatingStatusFilter(): void
    {
        $this->resetPage();
    }

    public function activate(User $user): void
    {
        $user->update(['is_active' => true]);
        session()->flash('success', 'User berhasil diaktifkan.');
    }

    public function ban(User $user): void
    {
        $user->update(['is_active' => false]);
        session()->flash('success', 'User berhasil dinonaktifkan.');
    }

    public function verify(User $user): void
    {
        $user->update(['is_verified' => true]);
        session()->flash('success', 'User berhasil diverifikasi.');
    }

    public function impersonate(User $user): void
    {
        if (! auth()->user()->isAdmin()) {
            session()->flash('error', 'Anda tidak memiliki izin untuk melakukan impersonasi.');

            return;
        }

        if ($user->isAdmin()) {
            session()->flash('error', 'Tidak dapat melakukan impersonasi ke admin lain.');

            return;
        }

        session()->put('original_admin_id', auth()->id());

        activity()
            ->performedOn($user)
            ->causedBy(auth()->user())
            ->withProperties(['impersonated_user_id' => $user->id, 'impersonated_user_email' => $user->email])
            ->log('Admin melakukan impersonasi ke user');

        Auth::login($user);

        session()->flash('success', 'Anda sekarang login sebagai '.$user->name);

        if ($user->isBrand()) {
            $this->redirect(route('brand.dashboard'), navigate: true);
        } elseif ($user->isKol()) {
            $this->redirect(route('kol.dashboard'), navigate: true);
        } else {
            $this->redirect(route('home'), navigate: true);
        }
    }

    public function render()
    {
        $query = User::query();

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('name', 'like', '%'.$this->search.'%')
                    ->orWhere('email', 'like', '%'.$this->search.'%');
            });
        }

        if ($this->roleFilter) {
            $query->where('user_type', $this->roleFilter);
        }

        if ($this->statusFilter === 'active') {
            $query->where('is_active', true);
        } elseif ($this->statusFilter === 'inactive') {
            $query->where('is_active', false);
        } elseif ($this->statusFilter === 'verified') {
            $query->where('is_verified', true);
        } elseif ($this->statusFilter === 'unverified') {
            $query->where('is_verified', false);
        }

        return view('admin.users', [
            'users' => $query->latest()->paginate(15),
            'roles' => UserRole::cases(),
        ])->layout('layouts.app');
    }
}
