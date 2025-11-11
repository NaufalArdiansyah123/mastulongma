<?php

namespace App\Livewire\SuperAdmin;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use App\Models\City;

#[Layout('layouts.superadmin')]
class Cities extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 10;

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedPerPage()
    {
        $this->resetPage();
    }

    public function openCreateModal()
    {
        session()->flash('message', 'Create new city');
    }

    public function editCity($id)
    {
        session()->flash('message', 'Edit city #' . $id);
    }

    public function confirmDelete($id)
    {
        session()->flash('message', 'Delete city #' . $id);
    }

    public function toggleStatus($id)
    {
        $city = City::findOrFail($id);
        $city->update(['is_active' => !$city->is_active]);
        session()->flash('message', 'Status kota berhasil diubah');
    }

    public function render()
    {
        $cities = City::query()
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                        ->orWhere('province', 'like', '%' . $this->search . '%');
                });
            })
            ->withCount('users')
            ->latest()
            ->paginate($this->perPage);

        return view('superadmin.cities', compact('cities'));
    }
}
