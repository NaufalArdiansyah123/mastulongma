<?php

namespace App\Livewire\Admin\Verifications;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use App\Models\Registration;
use App\Models\User;

#[Layout('layouts.admin')]
class Index extends Component
{
    use WithPagination;

    public $perPage = 10;
    public $showModal = false;
    public $selected = null;

    public function viewKtp($id)
    {
        $this->selected = Registration::find($id);
        if (!$this->selected) {
            session()->flash('message', 'Data tidak ditemukan.');
            return;
        }
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->selected = null;
        $this->showModal = false;
    }

    public function approveKtp($id)
    {
        $reg = Registration::find($id);
        if (!$reg) {
            session()->flash('message', 'Registrasi tidak ditemukan');
            return;
        }
        $reg->update(['status' => 'approved']);

        // Jika ada user terkait (dibuat saat registrasi step4), update status dan verifikasi
        try {
            if (!empty($reg->email)) {
                $user = User::where('email', $reg->email)->first();
                if ($user) {
                    $user->verified = true;
                    $user->status = 'active';
                    // Mark email_verified_at as now if column exists
                    if (array_key_exists('email_verified_at', $user->getAttributes())) {
                        $user->email_verified_at = now();
                    }
                    $user->save();
                }
            }
        } catch (\Exception $e) {
            // do not block admin action if user update fails
        }

        session()->flash('message', 'Registrasi disetujui.');
        $this->closeModal();
    }

    public function rejectKtp($id)
    {
        $reg = Registration::find($id);
        if (!$reg) {
            session()->flash('message', 'Registrasi tidak ditemukan');
            return;
        }
        $reg->update(['status' => 'rejected']);

        // Jika ada user terkait, pastikan tetap non-aktif / tidak terverifikasi
        try {
            if (!empty($reg->email)) {
                $user = User::where('email', $reg->email)->first();
                if ($user) {
                    $user->verified = false;
                    $user->status = 'inactive';
                    $user->save();
                }
            }
        } catch (\Exception $e) {
            // ignore
        }

        session()->flash('message', 'Registrasi ditolak.');
        $this->closeModal();
    }

    public function render()
    {
        $query = Registration::query();
        
        // Filter by admin's city if user is admin
        if (auth()->user() && auth()->user()->role === 'admin' && auth()->user()->city_id) {
            $query->where('city_id', auth()->user()->city_id);
        }
        
        $verifications = $query->latest()->paginate($this->perPage);
        return view('admin.verifications', compact('verifications'));
    }
}