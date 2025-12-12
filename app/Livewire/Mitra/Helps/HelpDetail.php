<?php

namespace App\Livewire\Mitra\Helps;

use App\Models\Help;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Carbon\Carbon;

#[Layout('layouts.mitra')]
class HelpDetail extends Component
{
    public $helpId;
    public $help;
    public $currentStatus;

    public function mount($id)
    {
        $this->helpId = $id;
        $this->help = Help::with(['user', 'city'])->findOrFail($id);
        
        // Verify this help belongs to the authenticated mitra
        if ($this->help->mitra_id !== auth()->id()) {
            abort(403, 'Anda tidak memiliki akses ke bantuan ini.');
        }

        $this->currentStatus = $this->help->status;
    }

    public function updateStatus($status, $timestampField = null)
    {
        $this->help->update([
            'status' => $status,
        ]);

        // Update timestamp field if provided
        if ($timestampField && !$this->help->$timestampField) {
            $this->help->update([
                $timestampField => now(),
            ]);
        }

        $this->currentStatus = $status;
        $this->help->refresh();

        session()->flash('message', 'Status berhasil diperbarui!');
    }

    public function markPartnerStarted()
    {
        $this->updateStatus('sedang_diproses', 'partner_started_at');
    }

    public function markPartnerArrived()
    {
        $this->updateStatus('sedang_diproses', 'partner_arrived_at');
    }

    public function markServiceStarted()
    {
        $this->updateStatus('sedang_diproses', 'service_started_at');
    }

    public function markServiceCompleted()
    {
        $this->updateStatus('sedang_diproses', 'service_completed_at');
    }

    public function markCompleted()
    {
        $this->help->update([
            'status' => 'selesai',
            'completed_at' => now(),
        ]);

        // If service_completed_at is not set, set it now
        if (!$this->help->service_completed_at) {
            $this->help->update(['service_completed_at' => now()]);
        }

        $this->currentStatus = 'selesai';
        $this->help->refresh();

        session()->flash('message', 'Pesanan telah diselesaikan!');
    }

    public function render()
    {
        return view('livewire.mitra.helps.help-detail');
    }
}
