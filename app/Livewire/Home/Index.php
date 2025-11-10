<?php

namespace App\Livewire\Home;

use App\Models\Category;
use App\Models\City;
use App\Models\Help;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $selectedCategory = null;
    public $selectedCity = null;
    public $search = '';

    public function render()
    {
        $helps = Help::with(['user', 'category', 'city', 'mitra'])
            ->where('status', 'approved')
            ->whereNull('mitra_id')
            ->when($this->selectedCategory, function ($query) {
                $query->where('category_id', $this->selectedCategory);
            })
            ->when($this->selectedCity, function ($query) {
                $query->where('city_id', $this->selectedCity);
            })
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('title', 'like', '%' . $this->search . '%')
                        ->orWhere('description', 'like', '%' . $this->search . '%');
                });
            })
            ->latest()
            ->paginate(10);

        $categories = Category::where('is_active', true)->get();
        $cities = City::where('is_active', true)->get();

        return view('livewire.home.index', [
            'helps' => $helps,
            'categories' => $categories,
            'cities' => $cities,
        ]);
    }

    public function updatedSelectedCategory()
    {
        $this->resetPage();
    }

    public function updatedSelectedCity()
    {
        $this->resetPage();
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function takeHelp($helpId)
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        if (!auth()->user()->isMitra()) {
            session()->flash('error', 'Hanya mitra yang dapat mengambil bantuan.');
            return;
        }

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

        session()->flash('message', 'Bantuan berhasil diambil! Segera hubungi yang membutuhkan.');
        return redirect()->route('helps.index');
    }
}
