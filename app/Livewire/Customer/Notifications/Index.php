<?php

namespace App\Livewire\Customer\Notifications;

use Livewire\Component;
use Illuminate\Notifications\DatabaseNotification;

class Index extends Component
{
    public function markAsRead($notificationId)
    {
        $notification = DatabaseNotification::find($notificationId);
        if ($notification && $notification->notifiable_id === auth()->id()) {
            $notification->markAsRead();
        }
    }

    public function markAllAsRead()
    {
        auth()->user()->unreadNotifications->markAsRead();
        session()->flash('message', 'Semua notifikasi telah ditandai sebagai dibaca');
    }

    public function deleteNotification($notificationId)
    {
        $notification = DatabaseNotification::find($notificationId);
        if ($notification && $notification->notifiable_id === auth()->id()) {
            $notification->delete();
        }
    }

    public function render()
    {
        $notifications = auth()->user()->notifications()->paginate(20);
        $unreadCount = auth()->user()->unreadNotifications->count();

        return view('livewire.customer.notifications.index', [
            'notifications' => $notifications,
            'unreadCount' => $unreadCount,
        ]);
    }
}
