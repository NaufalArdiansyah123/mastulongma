<?php

namespace App\Livewire\Helps;

use App\Models\Help;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $statusFilter = 'all';

    public function takeHelp($helpId)
    {
        $help = Help::findOrFail($helpId);

        if ($help->mitra_id) {
            session()->flash('error', 'Bantuan ini sudah diambil oleh mitra lain.');
            return;
        }

        $help->update([
            'mitra_id' => auth()->id(),
            'status' => 'taken',
            'taken_at' => now(),
        ]);

        session()->flash('message', 'Bantuan berhasil diambil! Segera hubungi yang membutuhkan.');
    }

    public function completeHelp($helpId)
    {
        $help = Help::where('id', $helpId)
            ->where('mitra_id', auth()->id())
            ->firstOrFail();

        $help->update([
            'status' => 'completed',
            'completed_at' => now(),
        ]);

        session()->flash('message', 'Bantuan berhasil diselesaikan! Terima kasih atas kebaikan Anda.');
    }

    public function render()
    {
        $user = auth()->user();

        if ($user->isKustomer()) {
            $helps = Help::where('user_id', $user->id)
                ->with(['category', 'city', 'mitra'])
                ->when($this->statusFilter != 'all', function ($query) {
                    $query->where('status', $this->statusFilter);
                })
                ->latest()
                ->paginate(10);
        } elseif ($user->isMitra()) {
            if (request()->routeIs('helps.available')) {
                // Mitra melihat bantuan yang available
                $helps = Help::where('status', 'approved')
                    ->whereNull('mitra_id')
                    ->with(['user', 'category', 'city'])
                    ->latest()
                    ->paginate(10);
            } else {
                // Mitra melihat bantuan yang sudah diambil
                $helps = Help::where('mitra_id', $user->id)
                    ->with(['user', 'category', 'city'])
                    ->when($this->statusFilter != 'all', function ($query) {
                        $query->where('status', $this->statusFilter);
                    })
                    ->latest()
                    ->paginate(10);
            }
        } else {
            $helps = collect();
        }

        return view('livewire.helps.index', [
            'helps' => $helps,
        ]);
    }
}
