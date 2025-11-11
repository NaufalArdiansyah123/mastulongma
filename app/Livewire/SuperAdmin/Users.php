<?php

namespace App\Livewire\SuperAdmin;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use App\Models\User;

#[Layout('layouts.superadmin')]
class Users extends Component
{
    use WithPagination;

    public $search = '';
    public $roleFilter = '';
    public $perPage = 10;

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedRoleFilter()
    {
        $this->resetPage();
    }

    public function updatedPerPage()
    {
        $this->resetPage();
    }

    public function viewUser($id)
    {
        // TODO: Implement view user detail
        session()->flash('message', 'View user #' . $id);
    }

    public function editUser($id)
    {
        // TODO: Implement edit user
        session()->flash('message', 'Edit user #' . $id);
    }

    public function confirmDelete($id)
    {
        // TODO: Implement delete confirmation
        session()->flash('message', 'Delete user #' . $id);
    }

    public function openCreateModal()
    {
        // TODO: Implement create user modal
        session()->flash('message', 'Create new user');
    }

    public function render()
    {
        $users = User::query()
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                        ->orWhere('email', 'like', '%' . $this->search . '%')
                        ->orWhere('phone', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->roleFilter, function ($query) {
                $query->where('role', $this->roleFilter);
            })
            ->latest()
            ->paginate($this->perPage);

        return view('superadmin.users', compact('users'));
    }
}
