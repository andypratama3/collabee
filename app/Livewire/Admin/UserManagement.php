<?php

namespace App\Livewire\Admin;

use App\Models\User;
use App\Enums\UserRole;
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

    public function render()
    {
        $query = User::query();

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%');
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
