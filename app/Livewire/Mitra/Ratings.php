<?php

namespace App\Livewire\Mitra;

use App\Models\Rating;
use Livewire\WithPagination;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.mitra')]
class Ratings extends Component
{
    use WithPagination;

    public $ratings;
    public $averageRating = 0;
    public $totalRatings = 0;

    public function mount()
    {
        $this->loadRatings();
    }

    public function loadRatings()
    {
        $this->ratings = Rating::where('mitra_id', auth()->id())
            ->with('help.customer')
            ->latest()
            ->paginate(10);

        $allRatings = Rating::where('mitra_id', auth()->id())->get();
        $this->totalRatings = $allRatings->count();
        $this->averageRating = $this->totalRatings > 0 ? round($allRatings->avg('rating'), 1) : 0;
    }

    public function render()
    {
        return view('livewire.mitra.ratings.index');
    }
}
