<?php

namespace App\Livewire;

use App\Models\Help;
use Livewire\Component;

class Dashboard extends Component
{
    public function render()
    {
        $user = auth()->user();

        $stats = [];

        // Ambil bantuan yang tersedia (untuk ditampilkan di dashboard)
        $availableHelps = Help::where('status', 'approved')
            ->whereNull('mitra_id')
            ->with(['user', 'category', 'city'])
            ->latest()
            ->take(10)
            ->get();

        if ($user->isKustomer()) {
            $stats = [
                'total_helps' => Help::where('user_id', $user->id)->count(),
                'pending_helps' => Help::where('user_id', $user->id)->where('status', 'pending')->count(),
                'completed_helps' => Help::where('user_id', $user->id)->where('status', 'completed')->count(),
            ];

            $myHelps = Help::where('user_id', $user->id)
                ->with(['category', 'city', 'mitra'])
                ->latest()
                ->take(5)
                ->get();
        } elseif ($user->isMitra()) {
            $stats = [
                'total_helped' => Help::where('mitra_id', $user->id)->count(),
                'in_progress' => Help::where('mitra_id', $user->id)->whereIn('status', ['taken', 'in_progress'])->count(),
                'completed' => Help::where('mitra_id', $user->id)->where('status', 'completed')->count(),
            ];

            $myHelps = Help::where('mitra_id', $user->id)
                ->with(['user', 'category', 'city'])
                ->latest()
                ->take(5)
                ->get();
        } else {
            $myHelps = collect();
        }

        return view('livewire.dashboard', [
            'stats' => $stats,
            'myHelps' => $myHelps,
            'availableHelps' => $availableHelps,
        ]);
    }
}
