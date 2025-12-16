<?php

namespace App\Livewire\Mitra;

use Livewire\Component;
use App\Models\Chat as ChatModel;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class RealtimeNotifications extends Component
{
    public $last_chat_id = 0;

    public function mount()
    {
        if (auth()->check()) {
            $this->last_chat_id = ChatModel::where('mitra_id', auth()->id())->max('id') ?? 0;
        }
    }

    public function poll()
    {
        if (!auth()->check()) {
            Log::info('[RealtimeNotifications] poll called but no auth user.');
            return;
        }

        Log::info('[RealtimeNotifications] polling for mitra_id=' . auth()->id() . ' last_chat_id=' . $this->last_chat_id);

        $new = ChatModel::where('mitra_id', auth()->id())
            ->where('sender_type', 'customer')
            ->where('id', '>', $this->last_chat_id)
            ->orderBy('id', 'asc')
            ->first();

        if ($new) {
            Log::info('[RealtimeNotifications] found new chat id=' . $new->id . ' help_id=' . $new->help_id . ' message=' . Str::limit($new->message, 120));

            $this->last_chat_id = $new->id;

            // Dispatch with named parameters so Livewire exposes them as event detail in the browser
            $this->dispatch(
                'help-new-message',
                helpId: $new->help_id,
                message: Str::limit($new->message, 150),
                from: optional($new->customer)->name ?? 'Customer'
            );
        }
    }

    public function render()
    {
        // render nothing visible; the view simply contains a poll directive
        return view('livewire.mitra.realtime-notifications');
    }
}
