<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PartnerActivity;
use App\Models\PartnerReport;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PartnerReportController extends Controller
{
    public function index()
    {
        $start = request('start_date') ?? Carbon::now()->subDays(7)->toDateString();
        $end = request('end_date') ?? Carbon::now()->toDateString();

        $rangeDays = Carbon::parse($start)->diffInDays(Carbon::parse($end)) + 1;

        // Current period stats
        $totalLogins = PartnerActivity::where('activity_type', 'login')
            ->whereBetween('created_at', [$start, $end])
            ->count();

        $totalActivities = PartnerActivity::whereBetween('created_at', [$start, $end])
            ->count();

        // Previous period (same length, immediately before current start)
        $prevEnd = Carbon::parse($start)->subDay();
        $prevStart = (clone $prevEnd)->subDays($rangeDays - 1)->toDateString();
        $prevEndStr = $prevEnd->toDateString();

        $prevLogins = PartnerActivity::where('activity_type', 'login')
            ->whereBetween('created_at', [$prevStart, $prevEndStr])
            ->count();

        $prevActivities = PartnerActivity::whereBetween('created_at', [$prevStart, $prevEndStr])
            ->count();

        // Some installations use a `status` column with values like 'active'/'blocked'.
        // Fall back to checking `status` since `is_blocked` column may not exist.
        $activePartners = User::where('status', 'active')->count();
        $blockedPartners = User::where('status', 'blocked')->count();

        $chartData = PartnerActivity::selectRaw('DATE(created_at) as date, COUNT(*) as total, SUM(CASE WHEN activity_type = "login" THEN 1 ELSE 0 END) as logins')
            ->whereBetween('created_at', [$start, $end])
            ->groupBy('date')
            ->orderBy('date', 'ASC')
            ->get();

        $topPartners = PartnerActivity::selectRaw('user_id, COUNT(*) as total_activities, SUM(CASE WHEN activity_type = "login" THEN 1 ELSE 0 END) as login_count')
            ->whereBetween('created_at', [$start, $end])
            ->groupBy('user_id')
            ->orderByDesc('total_activities')
            ->with('user')
            ->take(5)
            ->get();

        $loginTrend = $this->buildTrendData($totalLogins, $prevLogins);
        $activityTrend = $this->buildTrendData($totalActivities, $prevActivities);

        return view('admin.partners.report', compact(
            'start',
            'end',
            'totalLogins',
            'totalActivities',
            'activePartners',
            'blockedPartners',
            'chartData',
            'topPartners',
            'loginTrend',
            'activityTrend',
            'prevStart',
            'prevEndStr'
        ));
    }

    protected function buildTrendData(int $current, int $previous): array
    {
        if ($previous === 0) {
            return [
                'direction' => $current > 0 ? 'up' : 'same',
                'diff' => $current,
                'percent' => $current > 0 ? 100 : 0,
            ];
        }

        $diff = $current - $previous;
        $percent = round(($diff / max($previous, 1)) * 100);

        return [
            'direction' => $diff > 0 ? 'up' : ($diff < 0 ? 'down' : 'same'),
            'diff' => $diff,
            'percent' => $percent,
        ];
    }

    public function reportsIndex()
    {
        $reports = PartnerReport::with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.partners.reports', compact('reports'));
    }

    public function updateStatus(PartnerReport $report)
    {
        $report->update([
            'status' => request('status'),
        ]);

        return back()->with('success', 'Status laporan diperbarui.');
    }
}
