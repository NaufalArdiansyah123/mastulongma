<?php

namespace App\Livewire\Mitra;

use App\Models\Help;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

#[Layout('layouts.mitra')]
class AllHelps extends Component
{
    use WithPagination;

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

}