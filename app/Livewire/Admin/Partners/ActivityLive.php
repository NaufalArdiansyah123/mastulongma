<?php

namespace App\Livewire\Admin\Partners;

use Livewire\Component;
use App\Models\Help;
use App\Models\User;
use App\Models\PartnerActivity;

class ActivityLive extends Component
{
    public $mitraActive = 0;
    public $pendingHelps = 0;
    public $inProgress = 0;
    public $feed = [];

    public function mount()
    {
        $this->loadData();
    }

    public function loadData()
    {
        $this->mitraActive = User::where('role', 'mitra')->where('status', 'active')->count();
        $this->pendingHelps = Help::available()->count();
        $this->inProgress = Help::taken()->count();

        $this->feed = PartnerActivity::with('user')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get()
            ->map(function ($a) {
                return [
                    'id' => $a->id,
                    'user' => $a->user ? $a->user->name : '-',
                    'type' => $a->activity_type,
                    'desc' => $a->description,
                    'time' => $a->created_at->diffForHumans(),
                ];
            })
            ->toArray();
    }

    public function render()
    {
        return view('livewire.admin.partners.activity-live');
    }
}
