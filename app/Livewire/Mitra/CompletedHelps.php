<?php

namespace App\Livewire\Mitra;

use App\Models\Help;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

#[Layout('layouts.mitra')]
class CompletedHelps extends Component
{
    use WithPagination;

    public $search = '';
    public $sortBy = 'latest';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $user = auth()->user();

        // Show only helps assigned to this mitra that are completed
        $query = Help::query()->where('mitra_id', $user->id)->where('status', 'selesai');

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('title', 'like', '%' . $this->search . '%')
                    ->orWhere('description', 'like', '%' . $this->search . '%')
                    ->orWhereHas('user', function ($u) {
                        $u->where('name', 'like', '%' . $this->search . '%');
                    });
            });
        }

        if ($this->sortBy === 'latest') {
            $query->latest();
        } elseif ($this->sortBy === 'oldest') {
            $query->oldest();
        }

        $helps = $query->with(['user', 'city'])->paginate(15);

        return view('livewire.mitra.helps.completed-helps', [
            'helps' => $helps,
        ]);
    }
}
