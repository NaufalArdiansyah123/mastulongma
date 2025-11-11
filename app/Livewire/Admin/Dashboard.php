<?php

namespace App\Livewire\Admin;

use App\Models\Help;
use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.admin')]
class Dashboard extends Component
{
    public function render()
    {
        return view('admin.dashboard', [
            'totalHelps' => Help::count(),
            'pendingHelps' => Help::where('status', 'pending')->count(),
            'activeHelps' => Help::where('status', 'active')->count(),
            'completedHelps' => Help::where('status', 'completed')->count(),
            'pendingVerifications' => 0, // Will be implemented when KTP verification is ready
            'verifiedMitras' => User::where('role', 'mitra')->count(),
        ]);
    }
}
