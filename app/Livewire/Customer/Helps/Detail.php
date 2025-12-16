<?php

namespace App\Livewire\Customer\Helps;

use App\Models\Help;
use Livewire\Component;
use Illuminate\Support\Facades\Log;

class Detail extends Component
{
    public $help;
    public $helpId;
    public $showCancelConfirm = false;
    public $showMapModal = false;
    public $showRatingForm = false;
    public $rating = 0;
    public $review = '';

    protected $listeners = [
        'refreshHelp' => '$refresh',
        'status-changed' => 'handleStatusChanged'
    ];

    public function mount($id)
    {
        $this->helpId = $id;
        $this->loadHelp();
    }

    public function loadHelp()
    {
        $this->help = Help::with([
            'user',
            'mitra',
            'city',
            'category',
            'ratings'
        ])->findOrFail($this->helpId);

        // Check authorization
        if ($this->help->user_id !== auth()->id()) {
            abort(403, 'Unauthorized access');
        }

        // Dispatch event untuk update tracking data
        if ($this->showMapModal && in_array($this->help->status, ['taken', 'partner_on_the_way', 'partner_arrived'])) {
            $this->dispatch('tracking-data-updated', [
                'partnerLat' => $this->help->partner_current_lat ?? ($this->help->mitra->latitude ?? ($this->help->latitude ? $this->help->latitude - 0.01 : -6.2088)),
                'partnerLng' => $this->help->partner_current_lng ?? ($this->help->mitra->longitude ?? ($this->help->longitude ? $this->help->longitude - 0.01 : 106.8456)),
                'customerLat' => $this->help->latitude ?? -6.2088,
                'customerLng' => $this->help->longitude ?? 106.8456,
            ]);
        }

        // Log untuk debug
        Log::info('Customer Help Detail - Data Refreshed', [
            'help_id' => $this->help->id,
            'status' => $this->help->status,
            'partner_current_lat' => $this->help->partner_current_lat,
            'partner_current_lng' => $this->help->partner_current_lng,
            'partner_on_the_way' => $this->help->status === 'partner_on_the_way',
            'partner_started_moving_at' => $this->help->partner_started_moving_at,
            'partner_arrived_at' => $this->help->partner_arrived_at
        ]);
    }

    public function copyOrderId()
    {
        $this->dispatch('copied', orderId: $this->help->order_id);
    }

    public function confirmCancel()
    {
        $this->showCancelConfirm = true;
    }

    public function cancelHelp()
    {
        try {
            // Only allow cancel if status is pending or waiting for partner
            if (!in_array($this->help->status, ['menunggu_pembayaran', 'menunggu_mitra', 'mencari_mitra'])) {
                session()->flash('error', 'Bantuan tidak dapat dibatalkan pada status ini.');
                return;
            }

            $this->help->update([
                'status' => 'dibatalkan',
            ]);

            // Log activity
            Log::info('Help cancelled by customer', [
                'help_id' => $this->help->id,
                'user_id' => auth()->id(),
            ]);

            session()->flash('success', 'Permintaan bantuan berhasil dibatalkan.');
            $this->showCancelConfirm = false;
            
            // Redirect to helps index
            return redirect()->route('customer.helps.index');
        } catch (\Exception $e) {
            Log::error('Error cancelling help: ' . $e->getMessage());
            session()->flash('error', 'Terjadi kesalahan saat membatalkan bantuan.');
        }
    }

    public function closeModal()
    {
        $this->showCancelConfirm = false;
    }

    public function showTrackingMap()
    {
        // Check if partner is on the way or at nearby statuses
        if (!in_array($this->help->status, ['taken', 'partner_on_the_way', 'partner_arrived'])) {
            session()->flash('error', 'Tracking hanya tersedia saat mitra sedang menuju lokasi.');
            return;
        }

        // Reload help data to get latest coordinates
        $this->loadHelp();

        // Validate coordinates exist
        if (!$this->help->latitude || !$this->help->longitude) {
            session()->flash('error', 'Lokasi customer tidak tersedia.');
            return;
        }

        // Check if we have partner location
        $partnerLat = $this->help->partner_current_lat ?? $this->help->mitra->latitude ?? null;
        $partnerLng = $this->help->partner_current_lng ?? $this->help->mitra->longitude ?? null;

        if (!$partnerLat || !$partnerLng) {
            session()->flash('error', 'Lokasi mitra belum tersedia. Mitra mungkin belum mengaktifkan GPS tracking.');
            return;
        }

        $this->showMapModal = true;
        
        // Dispatch event to frontend to initialize map
        $this->dispatch('mapModalOpened');
    }

    public function closeMapModal()
    {
        $this->showMapModal = false;
    }

    public function submitRating()
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

        // Check if this user already rated this help (prevent duplicate from same user)
        if (\App\Models\Rating::hasRated($this->help->id, auth()->id(), 'customer_to_mitra')) {
            session()->flash('error', 'Anda sudah memberikan rating untuk pesanan ini.');
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
            'user_id' => auth()->id(), // Legacy field
            'mitra_id' => $this->help->mitra_id, // Legacy field
            'rater_id' => auth()->id(), // New field: who gives rating (customer)
            'ratee_id' => $this->help->mitra_id, // New field: who receives rating (mitra)
            'type' => 'customer_to_mitra',
            'rating' => $this->rating,
            'review' => $this->review,
        ]);

        // Reset form
        $this->rating = 0;
        $this->review = '';
        $this->showRatingForm = false;

        // Reload help
        $this->loadHelp();

        session()->flash('success', 'Terima kasih atas rating Anda!');
    }

    public function setRating($value)
    {
        $this->rating = $value;
    }

    public function confirmCompletion()
    {
        // Only allow confirmation if status is waiting_customer_confirmation
        if ($this->help->status !== 'waiting_customer_confirmation') {
            session()->flash('error', 'Status pesanan tidak valid untuk konfirmasi.');
            return;
        }

        $this->help->update([
            'status' => 'selesai',
            'completed_at' => now(),
        ]);

        $this->loadHelp();

        session()->flash('success', 'Pesanan telah dikonfirmasi selesai!');
    }

    public function handleStatusChanged($data)
    {
        // Reload help data saat status berubah dari GPS tracking
        if (isset($data['helpId']) && $data['helpId'] == $this->helpId) {
            $this->loadHelp();
            
            // Dispatch notification ke frontend
            $this->dispatch('show-status-notification', [
                'message' => $this->getStatusNotificationMessage($data['newStatus'])
            ]);
        }
    }

    private function getStatusNotificationMessage($status)
    {
        return match($status) {
            'partner_on_the_way' => '🚗 Rekan jasa sedang menuju lokasi Anda',
            'partner_arrived' => '📍 Rekan jasa telah tiba di lokasi',
            'in_progress' => '⚙️ Pekerjaan sedang dikerjakan',
            'waiting_customer_confirmation' => '✋ Menunggu konfirmasi Anda untuk menyelesaikan pesanan',
            'completed', 'selesai' => '✅ Pesanan telah selesai',
            default => 'Status pesanan diperbarui'
        };
    }

    public function getStatusColorProperty()
    {
        return match($this->help->status) {
            'menunggu_pembayaran' => 'bg-yellow-100 text-yellow-700',
            'mencari_mitra', 'menunggu_mitra' => 'bg-blue-100 text-blue-700',
            'taken' => 'bg-blue-100 text-blue-700',
            'partner_on_the_way' => 'bg-blue-100 text-blue-700',
            'partner_arrived' => 'bg-green-100 text-green-700',
            'in_progress', 'sedang_diproses' => 'bg-cyan-100 text-cyan-700',
            'waiting_customer_confirmation' => 'bg-orange-100 text-orange-700',
            'completed', 'selesai' => 'bg-green-100 text-green-700',
            'dibatalkan', 'cancelled' => 'bg-red-100 text-red-700',
            default => 'bg-gray-100 text-gray-700',
        };
    }

    public function getStatusTextProperty()
    {
        return match($this->help->status) {
            'menunggu_pembayaran' => 'Menunggu Pembayaran',
            'mencari_mitra' => 'Mencari Rekan Jasa terdekat',
            'menunggu_mitra', 'memperoleh_mitra' => 'Menunggu Rekan Jasa berangkat',
            'taken' => 'Rekan Jasa mengambil pesanan',
            'partner_on_the_way' => 'Rekan Jasa menuju lokasi',
            'partner_arrived' => 'Rekan Jasa tiba di lokasi',
            'in_progress', 'sedang_diproses' => 'Pelayanan dalam proses',
            'waiting_customer_confirmation' => 'Menunggu konfirmasi customer',
            'completed', 'selesai' => 'Pesanan selesai',
            'dibatalkan', 'cancelled' => 'Dibatalkan',
            default => ucfirst(str_replace('_', ' ', $this->help->status)),
        };
    }

    public function render()
    {
        return view('livewire.customer.helps.detail')
            ->layout('layouts.app', ['title' => 'Detail Pesanan']);
    }
}
