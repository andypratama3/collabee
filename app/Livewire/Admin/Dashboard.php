<?php

namespace App\Livewire\Admin;

use App\Models\User;
use App\Models\Campaign;
use App\Models\Payment;
use App\Models\KolWithdrawal;
use App\Models\Dispute;
use App\Enums\PaymentStatus;
use Livewire\Component;

class Dashboard extends Component
{
    public array $stats = [];
    public array $revenueChart = [];
    public array $registrationChart = [];

    public function mount(): void
    {
        $this->stats = [
            'totalUsers' => User::count(),
            'brandCount' => User::where('user_type', 'brand')->count(),
            'kolCount' => User::where('user_type', 'kol')->count(),
            'totalCampaigns' => Campaign::count(),
            'totalRevenue' => Payment::where('status', PaymentStatus::PAID)->sum('total_amount'),
            'pendingWithdrawals' => KolWithdrawal::where('status', 'pending')->count(),
            'openDisputes' => Dispute::where('status', 'open')->count(),
        ];

        $this->revenueChart = $this->getRevenueOverTime();
        $this->registrationChart = $this->getRegistrationOverTime();
    }

    private function monthExpression(string $column): string
    {
        $driver = \Illuminate\Support\Facades\DB::connection()->getDriverName();

        return match ($driver) {
            'mysql', 'mariadb' => "DATE_FORMAT($column, '%Y-%m')",
            'pgsql' => "to_char($column, 'YYYY-MM')",
            default => "strftime('%Y-%m', $column)", // sqlite
        };
    }

    private function getRevenueOverTime(): array
    {
        $months = collect(range(5, 0))->map(fn($i) => now()->subMonths($i)->format('Y-m'));
        $expr = $this->monthExpression('paid_at');

        $grouped = Payment::where('status', PaymentStatus::PAID)
            ->where('paid_at', '>=', now()->subMonths(6)->startOfMonth())
            ->selectRaw("$expr as ym, SUM(total_amount) as total")
            ->groupBy('ym')
            ->pluck('total', 'ym');

        return [
            'categories' => $months->map(fn($m) => $this->monthLabel($m))->toArray(),
            'data' => $months->map(fn($m) => (float) ($grouped[$m] ?? 0))->toArray(),
        ];
    }

    private function getRegistrationOverTime(): array
    {
        $months = collect(range(5, 0))->map(fn($i) => now()->subMonths($i)->format('Y-m'));
        $expr = $this->monthExpression('created_at');

        $grouped = User::where('created_at', '>=', now()->subMonths(6)->startOfMonth())
            ->selectRaw("$expr as ym, COUNT(*) as total")
            ->groupBy('ym')
            ->pluck('total', 'ym');

        return [
            'categories' => $months->map(fn($m) => $this->monthLabel($m))->toArray(),
            'data' => $months->map(fn($m) => (int) ($grouped[$m] ?? 0))->toArray(),
        ];
    }

    private function monthLabel(string $ym): string
    {
        $monthsMap = [
            '01' => 'Jan', '02' => 'Feb', '03' => 'Mar', '04' => 'Apr',
            '05' => 'Mei', '06' => 'Jun', '07' => 'Jul', '08' => 'Ags',
            '09' => 'Sep', '10' => 'Okt', '11' => 'Nov', '12' => 'Des',
        ];
        return $monthsMap[explode('-', $ym)[1]] ?? $ym;
    }

    public function render()
    {
        return view('admin.dashboard')->layout('layouts.app');
    }
}
