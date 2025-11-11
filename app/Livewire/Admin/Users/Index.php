<?php

namespace App\Livewire\Admin\Users;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;
use App\Models\City;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $roleFilter = '';
    public $statusFilter = '';
    public $showModal = false;
    public $editMode = false;
    public $userId;

    // Form fields
    public $name = '';
    public $email = '';
    public $phone = '';
    public $role = 'kustomer';
    public $city_id = '';
    public $status = 'active';
    public $password = '';

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedRoleFilter()
    {
        $this->resetPage();
    }

    public function updatedStatusFilter()
    {
        $this->resetPage();
    }

    public function openCreateModal()
    {
        $this->reset(['name', 'email', 'phone', 'role', 'city_id', 'status', 'password', 'userId', 'editMode']);
        $this->showModal = true;
    }

    public function openEditModal($id)
    {
        $user = User::findOrFail($id);
        $this->userId = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->phone = $user->phone;
        $this->role = $user->role;
        $this->city_id = $user->city_id;
        $this->status = $user->status;
        $this->editMode = true;
        $this->showModal = true;
    }

    public function save()
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . ($this->userId ?? 'NULL'),
            'phone' => 'nullable|string|max:20',
            'role' => 'required|in:super_admin,admin,kustomer,mitra',
            'city_id' => 'nullable|exists:cities,id',
            'status' => 'required|in:active,inactive,blocked',
        ];

        if (!$this->editMode || $this->password) {
            $rules['password'] = 'required|min:8';
        }

        $validated = $this->validate($rules);

        if ($this->editMode) {
            $user = User::findOrFail($this->userId);
            $user->update(array_filter([
                'name' => $this->name,
                'email' => $this->email,
                'phone' => $this->phone,
                'role' => $this->role,
                'city_id' => $this->city_id,
                'status' => $this->status,
                'password' => $this->password ? bcrypt($this->password) : null,
            ]));
        } else {
            User::create([
                'name' => $this->name,
                'email' => $this->email,
                'phone' => $this->phone,
                'role' => $this->role,
                'city_id' => $this->city_id,
                'status' => $this->status,
                'password' => bcrypt($this->password),
                'verified' => true,
                'email_verified_at' => now(),
            ]);
        }

        $this->showModal = false;
        $this->reset(['name', 'email', 'phone', 'role', 'city_id', 'status', 'password', 'userId', 'editMode']);
    }

    public function deleteUser($id)
    {
        User::findOrFail($id)->delete();
    }

    public function render()
    {
        $query = User::query();

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%')
                    ->orWhere('phone', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->roleFilter) {
            $query->where('role', $this->roleFilter);
        }

        if ($this->statusFilter) {
            $query->where('status', $this->statusFilter);
        }

        return view('livewire.admin.users.index', [
            'users' => $query->with('city')->latest()->paginate(15),
            'cities' => City::where('is_active', true)->get(),
        ]);
    }
}
