<?php

namespace App\Livewire\Admin\Verifications;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use App\Models\Registration;
use App\Models\User;
use Illuminate\Support\Facades\Log;

#[Layout('layouts.admin')]
class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $statusFilter = '';
    public $perPage = 10;
    public $selectedRegistration = null;
    public $previewPhoto = null;
    public $showModal = false;
    public $selectedUser = null;
    public $rejectReason = '';

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedStatusFilter()
    {
        $this->resetPage();
    }

    public function updatedPerPage()
    {
        $this->resetPage();
    }

    public function viewKtp($id)
    {
        Log::info('Livewire: viewKtp called', ['id' => $id, 'user_id' => auth()->id()]);
        $this->selectedRegistration = Registration::find($id);
        if (!$this->selectedRegistration) {
            Log::warning('Livewire: viewKtp - registration not found', ['id' => $id]);
            session()->flash('message', 'Registrasi tidak ditemukan');
            return;
        }

        // Try to find a User associated with this registration (by email)
        $user = User::where('email', $this->selectedRegistration->email)->first();

        if ($user) {
            // Ensure we provide ktp_path property expected by the view
            $user->ktp_path = $this->selectedRegistration->ktp_photo_path ?? $this->selectedRegistration->ktp_path ?? null;
            $this->selectedUser = $user;
        } else {
            // Create a lightweight object to represent the registration in the modal
            $this->selectedUser = (object) [
                'id' => $this->selectedRegistration->id,
                'name' => $this->selectedRegistration->full_name,
                'email' => $this->selectedRegistration->email,
                'phone' => null,
                'status' => $this->selectedRegistration->status ?? 'pending',
                'verified' => ($this->selectedRegistration->status ?? '') === 'approved',
                'ktp_path' => $this->selectedRegistration->ktp_photo_path ?? null,
            ];
        }

        $this->showModal = true;
    }

    public function showPhoto($url)
    {
        Log::info('Livewire: showPhoto called', ['url' => $url, 'user_id' => auth()->id()]);
        $this->previewPhoto = $url;
    }

    public function closePreview()
    {
        Log::info('Livewire: closePreview called', ['user_id' => auth()->id()]);
        $this->previewPhoto = null;
    }

    public function closeModal()
    {
        Log::info('Livewire: closeModal called', ['user_id' => auth()->id()]);
        $this->selectedRegistration = null;
        $this->selectedUser = null;
        $this->showModal = false;
        $this->rejectReason = '';
    }

    public function approveKtp($id)
    {
        Log::info('Livewire: approveKtp called', ['id' => $id, 'user_id' => auth()->id()]);
        // Accept either registration id or user id
        $reg = Registration::find($id);
        if (!$reg) {
            // try resolving by user id
            $user = User::find($id);
            if ($user) {
                $reg = Registration::where('email', $user->email)->first();
            }
        }

        if (!$reg) {
            session()->flash('message', 'Registrasi tidak ditemukan');
            return;
        }

        $user = User::where('email', $reg->email)->first();
        if ($user) {
            $user->update([
                'status' => 'active',
                'verified' => true,
                'email_verified_at' => now(),
            ]);

            Log::info('User approved and activated', ['user_id' => $user->id, 'email' => $user->email]);
        }

        $reg->update(['status' => 'approved']);

        session()->flash('message', 'Registrasi disetujui. User sekarang dapat login.');
        $this->closeModal();
    }

    public function rejectKtp($id)
    {
        Log::info('Livewire: rejectKtp called', ['id' => $id, 'user_id' => auth()->id()]);
        // Accept either registration id or user id
        $reg = Registration::find($id);
        if (!$reg) {
            $user = User::find($id);
            if ($user) {
                $reg = Registration::where('email', $user->email)->first();
            }
        }

        if (!$reg) {
            session()->flash('message', 'Registrasi tidak ditemukan');
            return;
        }

        $user = User::where('email', $reg->email)->first();
        if ($user) {
            $user->update(['status' => 'blocked']);

            Log::info('User rejected and blocked', ['user_id' => $user->id, 'email' => $user->email]);
        }

        $reg->update(['status' => 'rejected']);

        session()->flash('message', 'Registrasi ditolak. User tidak dapat login.');
        $this->closeModal();
    }

    public function render()
    {
        $verifications = Registration::query()
            ->when($this->statusFilter, function ($q) {
                if ($this->statusFilter === 'pending') {
                    $q->where('status', 'pending_verification');
                } elseif ($this->statusFilter === 'verified') {
                    $q->where('status', 'approved');
                }
            })
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('full_name', 'like', '%' . $this->search . '%')
                        ->orWhere('email', 'like', '%' . $this->search . '%')
                        ->orWhere('nik', 'like', '%' . $this->search . '%');
                });
            })
            ->latest()
            ->paginate($this->perPage);

        return view('admin.verifications', compact('verifications'));
    }
}
