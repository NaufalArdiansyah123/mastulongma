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

    // helper for delete modal display
    public $deletingCityName = null;

    // form fields
    public $name = '';
    public $province = '';
    public $admin_id = null;
    public $is_active = true;
    public $deleteId = null;
    // detail modal + chart data
    public $showDetailModal = false;
    public $detailCityName = null;
    public $chartLabels = [];
    public $chartCustomerData = [];
    public $chartMitraData = [];

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
        $city = City::find($id);
        $this->deletingCityName = $city ? $city->name : null;
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
            'admin_id' => 'required|exists:users,id',
            'is_active' => 'boolean',
        ]);

        // Ensure selected user is actually an admin
        $admin = User::find($validated['admin_id']);
        if (!$admin || $admin->role !== 'admin') {
            $this->addError('admin_id', 'Pilih user dengan role admin sebagai pengelola kota');
            return;
        }

        if ($this->editMode && $this->cityId) {
            $city = City::findOrFail($this->cityId);
            $oldAdminId = $city->admin_id;
            $city->update($validated);

            // If admin changed, clear old admin's city_id
            if ($oldAdminId && $oldAdminId !== $city->admin_id) {
                $oldAdmin = User::find($oldAdminId);
                if ($oldAdmin) {
                    $oldAdmin->city_id = null;
                    $oldAdmin->save();
                }
            }

            // assign new admin's city_id
            $admin->city_id = $city->id;
            $admin->save();

            session()->flash('message', 'Kota berhasil diperbarui');
        } else {
            $city = City::create($validated);

            // assign admin to this new city
            $admin->city_id = $city->id;
            $admin->save();

            session()->flash('message', 'Kota berhasil dibuat dan admin ditetapkan');
        }

        $this->showModal = false;
        $this->reset(['name', 'province', 'admin_id', 'is_active', 'cityId', 'editMode']);
    }

    public function deleteCity()
    {
        if ($this->deleteId) {
            $city = City::findOrFail($this->deleteId);
            // unset admin's city relationship if set
            if ($city->admin_id) {
                $admin = User::find($city->admin_id);
                if ($admin) {
                    $admin->city_id = null;
                    $admin->save();
                }
            }
            $city->delete();
            session()->flash('message', 'Kota berhasil dihapus');
        }

        // reset delete helpers
        $this->showDeleteModal = false;
        $this->deleteId = null;
        $this->deletingCityName = null;
    }

    /**
     * Open detail modal for a city and prepare last-30-days chart data
     */
    public function openDetailModal($cityId)
    {
        $city = City::find($cityId);
        if (!$city) {
            session()->flash('error', 'Kota tidak ditemukan');
            return;
        }

        $this->detailCityName = $city->name;
        $this->chartLabels = [];
        $this->chartCustomerData = [];
        $this->chartMitraData = [];

        $days = 30;
        $today = now()->startOfDay();

        for ($i = $days - 1; $i >= 0; $i--) {
            $date = $today->copy()->subDays($i);
            $this->chartLabels[] = $date->format('d M');

            $customerCount = User::where('role', 'customer')
                ->where('status', 'active')
                ->where('city_id', $cityId)
                ->whereDate('created_at', $date->toDateString())
                ->count();

            $mitraCount = User::where('role', 'mitra')
                ->where('status', 'active')
                ->where('city_id', $cityId)
                ->whereDate('created_at', $date->toDateString())
                ->count();

            $this->chartCustomerData[] = $customerCount;
            $this->chartMitraData[] = $mitraCount;
        }

        $this->showDetailModal = true;
        // Do not call emit/dispatch here to avoid compatibility issues with Livewire versions.
        // The client will read the prepared arrays from the rendered DOM after Livewire updates.
    }

    public function closeDetailModal()
    {
        $this->showDetailModal = false;
        $this->detailCityName = null;
        $this->chartLabels = [];
        $this->chartCustomerData = [];
        $this->chartMitraData = [];
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

        // Show all admins in dropdown (superadmin can reassign any admin)
        $admins = User::where('role', 'admin')->get();

        return view('superadmin.cities', compact('cities', 'admins'));
    }
}
