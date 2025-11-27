<?php

namespace App\Livewire\SuperAdmin;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use App\Models\City;
use App\Models\User;

#[Layout('layouts.superadmin')]
class Cities extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 10;
    public $showModal = false;
    public $showDeleteModal = false;
    public $editMode = false;
    public $cityId;

    // form fields
    public $name = '';
    public $province = '';
    public $admin_id = null;
    public $is_active = true;
    public $deleteId = null;

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
        $this->reset(['name', 'province', 'admin_id', 'is_active', 'cityId', 'editMode']);
        $this->is_active = true;
        $this->showModal = true;
    }

    public function editCity($id)
    {
        $city = City::findOrFail($id);
        $this->cityId = $city->id;
        $this->name = $city->name;
        $this->province = $city->province;
        $this->admin_id = $city->admin_id;
        $this->is_active = $city->is_active;
        $this->editMode = true;
        $this->showModal = true;
    }

    public function confirmDelete($id)
    {
        $this->deleteId = $id;
        $this->showDeleteModal = true;
    }

    public function toggleStatus($id)
    {
        $city = City::findOrFail($id);
        $city->update(['is_active' => !$city->is_active]);
        session()->flash('message', 'Status kota berhasil diubah');
    }

    public function save()
    {
        $validated = $this->validate([
            'name' => 'required|string|max:255',
            'province' => 'required|string|max:255',
            'admin_id' => 'nullable|exists:users,id',
            'is_active' => 'boolean',
        ]);

        if ($this->editMode && $this->cityId) {
            City::findOrFail($this->cityId)->update($validated);
            session()->flash('message', 'Kota berhasil diperbarui');
        } else {
            City::create($validated);
            session()->flash('message', 'Kota berhasil dibuat');
        }

        $this->showModal = false;
        $this->reset(['name', 'province', 'admin_id', 'is_active', 'cityId', 'editMode']);
    }

    public function deleteCity()
    {
        if ($this->deleteId) {
            City::findOrFail($this->deleteId)->delete();
            session()->flash('message', 'Kota berhasil dihapus');
        }

        $this->showDeleteModal = false;
        $this->deleteId = null;
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

        $admins = User::where('role', 'admin')->get();
        return view('superadmin.cities', compact('cities', 'admins'));
    }
}
