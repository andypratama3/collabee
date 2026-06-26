<?php

namespace App\Livewire\Admin;

use App\Enums\PaymentStatus;
use App\Models\Campaign;
use App\Models\Dispute;
use App\Models\KolWithdrawal;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Support\Facades\DB;
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
        $driver = DB::connection()->getDriverName();

        if (in_array($driver, ['mysql', 'mariadb', 'percona'])) {
            return "DATE_FORMAT($column, '%Y-%m')";
        }

        if ($driver === 'pgsql') {
            return "to_char($column, 'YYYY-MM')";
        }

        // SQLite fallback
        return "strftime('%Y-%m', $column)";
    }

    private function getRevenueOverTime(): array
    {
        $months = collect(range(5, 0))->map(fn ($i) => now()->subMonths($i)->format('Y-m'));
        $expr = $this->monthExpression('paid_at');

        $grouped = Payment::where('status', PaymentStatus::PAID)
            ->where('paid_at', '>=', now()->subMonths(6)->startOfMonth())
            ->selectRaw("$expr as ym, SUM(total_amount) as total")
            ->groupBy('ym')
            ->pluck('total', 'ym');

        return [
            'categories' => $months->map(fn ($m) => $this->monthLabel($m))->toArray(),
            'data' => $months->map(fn ($m) => (float) ($grouped[$m] ?? 0))->toArray(),
        ];
    }

    private function getRegistrationOverTime(): array
    {
        $months = collect(range(5, 0))->map(fn ($i) => now()->subMonths($i)->format('Y-m'));
        $expr = $this->monthExpression('created_at');

        $grouped = User::where('created_at', '>=', now()->subMonths(6)->startOfMonth())
            ->selectRaw("$expr as ym, COUNT(*) as total")
            ->groupBy('ym')
            ->pluck('total', 'ym');

        return [
            'categories' => $months->map(fn ($m) => $this->monthLabel($m))->toArray(),
            'data' => $months->map(fn ($m) => (int) ($grouped[$m] ?? 0))->toArray(),
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
