<?php

namespace App\Livewire\Mitra;

use App\Models\Help;
use App\Models\User;
use App\Notifications\HelpTakenNotification;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

#[Layout('layouts.mitra')]
class AllHelps extends Component
{
    use WithPagination;

    protected $queryString = [
        'search' => ['except' => ''],
        'filterStatus' => ['except' => 'all'],
        'sortBy' => ['except' => 'latest'],
    ];

    public $search = '';
    public $filterStatus = 'all'; // all, menunggu_mitra
    public $sortBy = 'latest'; // latest, oldest, price_high, price_low

    public function updatingSearch()
    {
        $this->resetPage();
    }


    public function render()
    {
        $user = auth()->user();

        $query = Help::query();

        // Default behavior: show helps from the same city as the authenticated mitra
        // if the mitra has a city set. This narrows the list to relevant cards.
        if ($user && !empty($user->city_id)) {
            $query->where('city_id', $user->city_id);
        }

        // Filter berdasarkan status
        if ($this->filterStatus === 'menunggu_mitra') {
            $query->where('status', 'menunggu_mitra')->whereNull('mitra_id');
        } else {
            // Tampilkan semua bantuan dari semua customer
            $query->where('status', 'menunggu_mitra')->whereNull('mitra_id');
        }

        // Search berdasarkan nama, deskripsi, atau lokasi
        if ($this->search) {
            $query->where(function ($q) {
                $q->whereHas('user', function ($userQuery) {
                    $userQuery->where('name', 'like', '%' . $this->search . '%');
                })
                    ->orWhere('description', 'like', '%' . $this->search . '%')
                    ->orWhereHas('city', function ($cityQuery) {
                        $cityQuery->where('name', 'like', '%' . $this->search . '%');
                    });
            });
        }

        // Sort
        if ($this->sortBy === 'nearby') {
            // Try to prioritize helps from the same city as the authenticated user.
            $userCityId = optional($user)->city_id;
            if ($userCityId) {
                // Order by a boolean match first, then by latest
                $query->orderByRaw("(city_id = ?) DESC", [$userCityId])->latest();
            } else {
                // fallback to latest if we don't have user's city
                $query->latest();
            }
        } elseif ($this->sortBy === 'latest') {
            $query->latest();
        } elseif ($this->sortBy === 'oldest') {
            $query->oldest();
        } elseif ($this->sortBy === 'price_high') {
            $query->orderByDesc('estimated_price');
        } elseif ($this->sortBy === 'price_low') {
            $query->orderBy('estimated_price');
        }

        $helps = $query->with(['user', 'city'])
            ->paginate(15);

        return view('livewire.mitra.helps.all-helps', [
            'helps' => $helps,
        ]);
    }

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

        session()->flash('message', 'Bantuan berhasil diambil. Silakan hubungi pengguna.');

        // Create a notification for the customer so it appears in their notifications page
        try {
            $customer = User::find($help->user_id);
            if ($customer) {
                $customer->notify(new HelpTakenNotification($helpId, auth()->id(), optional(auth()->user())->name));
            }
        } catch (\Throwable $e) {
            // ignore notification failures
        }

        // Emit event untuk redirect ke detail page
        $this->dispatch('help-taken', helpId: $helpId);

        // refresh pagination and query so the help disappears from the list
        $this->resetPage();
    }

}