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
            'rating'
        ])->findOrFail($this->helpId);

        // Check authorization
        if ($this->help->user_id !== auth()->id()) {
            abort(403, 'Unauthorized access');
        }

        // Log untuk debug
        Log::info('Customer Help Detail - Data Refreshed', [
            'help_id' => $this->help->id,
            'status' => $this->help->status,
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
