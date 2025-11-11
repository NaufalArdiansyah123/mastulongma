<?php

namespace App\Livewire\SuperAdmin;

use App\Models\User;
use App\Models\City;
use App\Models\Category;
use App\Models\Help;
use Livewire\Component;
use Livewire\Attributes\Layout;

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

        return view('superadmin.dashboard', compact('stats'));
    }
}
