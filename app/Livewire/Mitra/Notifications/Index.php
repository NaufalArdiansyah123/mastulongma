<?php

namespace App\Livewire\Mitra\Notifications;

use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.mitra')]
class Index extends Component
{
    public $notifications = [];

    public function mount()
    {
        $user = auth()->user();
        if ($user && method_exists($user, 'notifications')) {
            $this->notifications = $user->notifications()->latest()->limit(50)->get();
        } else {
            $this->notifications = [];
        }
    }

    public function markRead($id)
    {
        $user = auth()->user();
        if (!$user || !method_exists($user, 'notifications')) return;

        $notif = $user->notifications()->where('id', $id)->first();
        if ($notif) {
            $notif->markAsRead();
            $this->mount();
        }
    }

    public function markAllRead()
    {
        $user = auth()->user();
        if (!$user || !method_exists($user, 'unreadNotifications')) return;

        foreach ($user->unreadNotifications as $n) {
            $n->markAsRead();
        }

        $this->mount();
    }

    public function render()
    {
        return view('livewire.mitra.notifications.index');
    }
}
