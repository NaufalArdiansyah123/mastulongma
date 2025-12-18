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
    public $rating = 0;
    public $review = '';
    public $showPartnerCancelModal = false;
    public $partnerCancelReason = '';

    public function mount($id)
    {
        $this->helpId = $id;
        $this->help = Help::with(['user', 'city', 'rating'])->findOrFail($id);
        
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

    public function openPartnerCancelModal()
    {
        $this->partnerCancelReason = '';
        $this->showPartnerCancelModal = true;
    }

    public function requestPartnerCancel()
    {
        // Only allow partner assigned mitra to request cancel and only for certain statuses
        if ($this->help->mitra_id !== auth()->id()) {
            session()->flash('error', 'Anda tidak memiliki izin untuk membatalkan bantuan ini.');
            return;
        }

        if (!in_array($this->help->status, ['memperoleh_mitra', 'taken', 'partner_on_the_way', 'partner_arrived'])) {
            session()->flash('error', 'Pembatalan tidak dapat diminta pada status ini.');
            return;
        }

        $oldStatus = $this->help->status;

        $this->help->update([
            'partner_cancel_prev_status' => $oldStatus,
            'status' => 'partner_cancel_requested',
            'partner_cancel_requested_at' => now(),
            'partner_cancel_reason' => $this->partnerCancelReason ?: null,
        ]);

        // Notify customer
        try {
            $this->help->user->notify(new \App\Notifications\HelpStatusNotification($this->help, $oldStatus, 'partner_cancel_requested', $this->help->mitra));
        } catch (\Exception $e) {
            // silent fail for notification
        }

        $this->showPartnerCancelModal = false;
        $this->help->refresh();
        $this->currentStatus = $this->help->status;

        session()->flash('message', 'Permintaan pembatalan telah dikirim ke customer. Menunggu konfirmasi.');
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

    public function startService()
    {
        // Ubah status ke in_progress dan set service_started_at
        $this->help->update([
            'status' => 'in_progress',
            'service_started_at' => now(),
        ]);

        $this->currentStatus = 'in_progress';
        $this->help->refresh();

        session()->flash('message', 'Pekerjaan telah dimulai!');
    }

    public function markCompleted()
    {
        $this->help->update([
            'status' => 'waiting_customer_confirmation',
        ]);

        // If service_completed_at is not set, set it now
        if (!$this->help->service_completed_at) {
            $this->help->update(['service_completed_at' => now()]);
        }

        $this->currentStatus = 'waiting_customer_confirmation';
        $this->help->refresh();

        session()->flash('message', 'Menunggu konfirmasi dari customer!');
    }

    public function submitCustomerRating()
    {
        $this->validate([
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'nullable|string|max:500',
        ], [
            'rating.required' => 'Rating harus diisi',
            'rating.min' => 'Rating minimal 1 bintang',
            'rating.max' => 'Rating maksimal 5 bintang',
            'review.max' => 'Review maksimal 500 karakter',
        ]);

        // Check if already rated
        $existingRating = \App\Models\Rating::where('help_id', $this->help->id)
            ->where('rater_id', auth()->id())
            ->where('type', 'mitra_to_customer')
            ->first();

        if ($existingRating) {
            session()->flash('error', 'Anda sudah memberikan rating untuk customer ini.');
            return;
        }

        // Check if order is completed
        if (!in_array($this->help->status, ['selesai', 'completed'])) {
            session()->flash('error', 'Rating hanya bisa diberikan untuk pesanan yang sudah selesai.');
            return;
        }

        // Create rating
        \App\Models\Rating::create([
            'help_id' => $this->help->id,
            'user_id' => $this->help->user_id, // Legacy: customer being rated
            'mitra_id' => auth()->id(), // Legacy: mitra giving rating
            'rater_id' => auth()->id(), // New: mitra giving rating
            'ratee_id' => $this->help->user_id, // New: customer receiving rating
            'type' => 'mitra_to_customer',
            'rating' => $this->rating,
            'review' => $this->review,
        ]);

        // Reset form
        $this->rating = 0;
        $this->review = '';

        // Reload help
        $this->help->refresh();
        $this->help->load('rating');

        session()->flash('message', 'Terima kasih atas rating Anda!');
    }

    public function setRating($value)
    {
        $this->rating = $value;
    }

    public function render()
    {
        return view('livewire.mitra.helps.help-detail');
    }
}
