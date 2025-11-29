<?php

namespace App\Livewire\SuperAdmin\Settings;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\AppSetting;
use App\Models\Help;
use Carbon\Carbon;

#[Layout('layouts.superadmin')]
class HelpSettings extends Component
{
    public $min_help_nominal;
    public $admin_fee;

    protected function rules()
    {
        return [
            'min_help_nominal' => 'required|numeric|min:0',
            'admin_fee' => 'required|numeric|min:0',
        ];
    }

    public function mount()
    {
        $this->min_help_nominal = (int) AppSetting::get('min_help_nominal', 10000);
        $this->admin_fee = (float) AppSetting::get('admin_fee', 0);
    }

    public function save()
    {
        $this->validate();

        AppSetting::set('min_help_nominal', (string) $this->min_help_nominal);
        AppSetting::set('admin_fee', (string) $this->admin_fee);

        session()->flash('message', 'Pengaturan bantuan berhasil disimpan.');
    }

    public function render()
    {
        // Prepare admin fee revenue chart data: daily (30 days), monthly (12 months), yearly (5 years)
        $adminFeeChart = [
            'daily' => ['labels' => [], 'data' => []],
            'monthly' => ['labels' => [], 'data' => []],
            'yearly' => ['labels' => [], 'data' => []],
        ];

        // Daily - last 30 days
        $days = 30;
        $startDay = Carbon::today()->subDays($days - 1);
        for ($i = 0; $i < $days; $i++) {
            $d = $startDay->copy()->addDays($i);
            $label = $d->format('d M');
            $sum = (float) Help::whereDate('created_at', $d->toDateString())->sum('admin_fee');
            $adminFeeChart['daily']['labels'][] = $label;
            $adminFeeChart['daily']['data'][] = $sum;
        }

        // Monthly - last 12 months
        $months = 12;
        $startMonth = Carbon::now()->startOfMonth()->subMonths($months - 1);
        for ($i = 0; $i < $months; $i++) {
            $m = $startMonth->copy()->addMonths($i);
            $label = $m->format('M Y');
            $sum = (float) Help::whereYear('created_at', $m->year)->whereMonth('created_at', $m->month)->sum('admin_fee');
            $adminFeeChart['monthly']['labels'][] = $label;
            $adminFeeChart['monthly']['data'][] = $sum;
        }

        // Yearly - last 5 years
        $years = 5;
        $startYear = Carbon::now()->startOfYear()->subYears($years - 1);
        for ($i = 0; $i < $years; $i++) {
            $y = $startYear->copy()->addYears($i);
            $label = (string) $y->year;
            $sum = (float) Help::whereYear('created_at', $y->year)->sum('admin_fee');
            $adminFeeChart['yearly']['labels'][] = $label;
            $adminFeeChart['yearly']['data'][] = $sum;
        }

        // Summary stats
        $totalAll = (float) Help::sum('admin_fee');
        $total30 = (float) Help::whereDate('created_at', '>=', Carbon::today()->subDays(29))->sum('admin_fee');
        $totalMonth = (float) Help::whereYear('created_at', Carbon::now()->year)->whereMonth('created_at', Carbon::now()->month)->sum('admin_fee');
        $helpsWithFee = (int) Help::where('admin_fee', '>', 0)->count();
        $avgAdmin = $helpsWithFee ? ($totalAll / $helpsWithFee) : 0;

        return view('superadmin.help-settings', compact('adminFeeChart', 'totalAll', 'total30', 'totalMonth', 'helpsWithFee', 'avgAdmin'));
    }
}
