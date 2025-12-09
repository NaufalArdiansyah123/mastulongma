<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Illuminate\Notifications\DatabaseNotification;

class Notifications extends Component
{
    public $notifications;
    public $unreadCount = 0;

    protected $listeners = [
        'topupRequestCreated' => 'refreshNotifications',
        'notificationRead' => 'refreshNotifications'
    ];

    public function mount()
    {
        $this->loadNotifications();
    }

    public function loadNotifications()
    {
        $this->notifications = auth()->user()
            ->notifications()
            ->latest()
            ->take(10)
            ->get();
        
        $this->unreadCount = auth()->user()
            ->unreadNotifications()
            ->count();
    }

    public function refreshNotifications()
    {
        $this->loadNotifications();
    }

    public function markAsRead($notificationId)
    {
        $notification = DatabaseNotification::find($notificationId);
        
        if ($notification && $notification->notifiable_id === auth()->id()) {
            $notification->markAsRead();
            $this->loadNotifications();
            
            // Redirect based on notification type
            $data = $notification->data;
            if (isset($data['type'])) {
                switch ($data['type']) {
                    case 'new_topup_request':
                        return redirect()->route('admin.topup.approvals');
                    default:
                        break;
                }
            }
        }
    }

    public function markAllAsRead()
    {
        auth()->user()->unreadNotifications->markAsRead();
        $this->loadNotifications();
        session()->flash('notification-success', 'Semua notifikasi telah ditandai sebagai dibaca');
    }

    public function deleteNotification($notificationId)
    {
        $notification = DatabaseNotification::find($notificationId);
        
        if ($notification && $notification->notifiable_id === auth()->id()) {
            $notification->delete();
            $this->loadNotifications();
        }
    }

    public function render()
    {
        return view('livewire.admin.notifications');
    }
}
