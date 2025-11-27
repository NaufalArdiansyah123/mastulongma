<?php

namespace App\Livewire\SuperAdmin;

use App\Models\User;
use App\Models\City;
use App\Models\Category;
use App\Models\Help;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Carbon\Carbon;

#[Layout('layouts.superadmin')]
class Dashboard extends Component
{
    public function render()
    {
        $stats = [
            'total_users' => User::count(),
            'total_customers' => User::where('role', 'customer')->count(),
            'total_mitras' => User::where('role', 'mitra')->count(),
            'total_admins' => User::whereIn('role', ['admin', 'super_admin'])->count(),
            'total_cities' => City::count(),
            'total_categories' => Category::count(),
            'pending_helps' => Help::where('status', 'pending')->count(),
            'active_helps' => Help::where('status', 'active')->count(),
        ];

        // Recent items for quick view
        $recentUsers = User::orderByDesc('created_at')->limit(6)->get(['id', 'name', 'email', 'role', 'created_at']);
        $recentHelps = Help::with('user')->orderByDesc('created_at')->limit(6)->get(['id', 'title', 'status', 'created_at', 'user_id']);

        // Prepare user registration charts: daily (last 30 days), monthly (last 12 months), yearly (last 5 years)
        // Daily
        $days = 30;
        $startDay = Carbon::today()->subDays($days - 1);
        $dailyLabels = [];
        $dailyData = [];
        for ($i = 0; $i < $days; $i++) {
            $date = $startDay->copy()->addDays($i);
            $dailyLabels[] = $date->format('d M');
            $dailyData[] = User::whereDate('created_at', $date->toDateString())->count();
        }

        // Monthly (last 12 months)
        $months = 12;
        $startMonth = Carbon::now()->startOfMonth()->subMonths($months - 1);
        $monthlyLabels = [];
        $monthlyData = [];
        for ($i = 0; $i < $months; $i++) {
            $m = $startMonth->copy()->addMonths($i);
            $monthlyLabels[] = $m->format('M Y');
            $monthlyData[] = User::whereYear('created_at', $m->year)->whereMonth('created_at', $m->month)->count();
        }

        // Yearly (last 5 years)
        $years = 5;
        $startYear = Carbon::now()->startOfYear()->subYears($years - 1);
        $yearlyLabels = [];
        $yearlyData = [];
        for ($i = 0; $i < $years; $i++) {
            $y = $startYear->copy()->addYears($i);
            $yearlyLabels[] = (string) $y->year;
            $yearlyData[] = User::whereYear('created_at', $y->year)->count();
        }

        $userChart = [
            'daily' => ['labels' => $dailyLabels, 'data' => $dailyData],
            'monthly' => ['labels' => $monthlyLabels, 'data' => $monthlyData],
            'yearly' => ['labels' => $yearlyLabels, 'data' => $yearlyData],
        ];

        return view('superadmin.dashboard', compact('stats', 'recentUsers', 'recentHelps', 'userChart'));
    }
}
