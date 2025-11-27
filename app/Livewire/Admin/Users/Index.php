<?php

namespace App\Livewire\Admin\Users;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;
use App\Models\City;
use App\Models\Registration;
use App\Models\Rating;

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
    public $role = 'customer';
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
            'role' => 'required|in:super_admin,admin,customer,mitra',
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
        $query = User::query()
            ->leftJoin('registrations', 'registrations.email', '=', 'users.email')
            ->leftJoin('cities', 'users.city_id', '=', 'cities.id')
            ->select('users.*', 'registrations.status as registration_status', 'registrations.ktp_photo_path as registration_ktp_path', 'cities.name as city_name');

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

        // Because we joined registrations, ordering by latest users.created_at
        $users = $query->with('city')->orderBy('users.created_at', 'desc')->paginate(15);

        // Enrich each user row with the latest registration (if any) and compute rating/counts
        foreach ($users as $user) {
            $reg = Registration::where('email', $user->email)->latest()->first();
            if ($reg) {
                $user->registration_status = $reg->status;
                $user->registration_ktp_path = $reg->ktp_photo_path ?? $reg->ktp_path ?? null;
            } else {
                $user->registration_status = null;
                $user->registration_ktp_path = null;
            }

            // Average rating for mitra (if any)
            try {
                $avg = $user->ratings()->avg('rating');
            } catch (\Throwable $e) {
                $avg = null;
            }
            $user->average_rating = is_null($avg) ? null : round($avg, 1);

            // Helpful counts used in view
            try {
                $user->helps_count = $user->helps()->count();
            } catch (\Throwable $e) {
                $user->helps_count = 0;
            }

            try {
                $user->partner_reports_count = $user->partnerReports()->count();
            } catch (\Throwable $e) {
                $user->partner_reports_count = 0;
            }

            $user->is_blocked = ($user->status === 'blocked');
        }

        return view('livewire.admin.users.index', [
            'users' => $users,
            'cities' => City::where('is_active', true)->get(),
        ]);
    }
}
