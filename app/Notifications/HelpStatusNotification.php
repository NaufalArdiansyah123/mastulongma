<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;

class HelpStatusNotification extends Notification
{
    use Queueable;

    protected $help;
    protected $oldStatus;
    protected $newStatus;
    protected $mitra;

    public function __construct($help, $oldStatus = null, $newStatus = null, $mitra = null)
    {
        $this->help = $help;
        $this->oldStatus = $oldStatus;
        $this->newStatus = $newStatus ?? $help->status;
        $this->mitra = $mitra ?? $help->mitra;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        $mitraName = $this->mitra?->name ?? 'Mitra';

        $message = match (strtolower($this->newStatus)) {
            'partner_on_the_way' => "$mitraName sedang menuju lokasi Anda",
            'partner_arrived' => "$mitraName telah tiba di lokasi Anda",
            default => "Status bantuan diperbarui: {$this->newStatus}"
        };

        return [
            'type' => 'help_status',
            'help_id' => $this->help->id ?? null,
            'help_title' => $this->help->title ?? null,
            'mitra_id' => $this->mitra?->id ?? null,
            'mitra_name' => $mitraName,
            'old_status' => $this->oldStatus,
            'new_status' => $this->newStatus,
            'message' => $message,
        ];
    }
}
