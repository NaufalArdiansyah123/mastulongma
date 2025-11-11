<?php

use Livewire\Volt\Component;
use Livewire\WithPagination;
use App\Models\Category;

new class extends Component {
    use WithPagination;

    public $search = '';
    public $showModal = false;
    public $editMode = false;
    public $categoryId;

    // Form fields
    public $name = '';
    public $description = '';
    public $icon = '';
    public $color = '#3B82F6';
    public $is_active = true;

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function openCreateModal()
    {
        $this->reset(['name', 'description', 'icon', 'color', 'is_active', 'categoryId', 'editMode']);
        $this->color = '#3B82F6';
        $this->is_active = true;
        $this->showModal = true;
    }

    public function openEditModal($id)
    {
        $category = Category::findOrFail($id);
        $this->categoryId = $category->id;
        $this->name = $category->name;
        $this->description = $category->description;
        $this->icon = $category->icon;
        $this->color = $category->color;
        $this->is_active = $category->is_active;
        $this->editMode = true;
        $this->showModal = true;
    }

    public function save()
    {
        $validated = $this->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'icon' => 'nullable|string|max:100',
            'color' => 'required|string|max:7',
            'is_active' => 'boolean',
        ]);

        if ($this->editMode) {
            Category::findOrFail($this->categoryId)->update($validated);
        } else {
            Category::create($validated);
        }

        $this->showModal = false;
        $this->reset(['name', 'description', 'icon', 'color', 'is_active', 'categoryId', 'editMode']);
    }

    public function deleteCategory($id)
    {
        Category::findOrFail($id)->delete();
    }

    public function with(): array
    {
        $query = Category::query();

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('description', 'like', '%' . $this->search . '%');
            });
        }

        return [
            'categories' => $query->latest()->paginate(15),
        ];
    }
}; ?>

<div class="min-h-screen bg-gray-50 pb-20">
    <!-- Header -->
    <div class="bg-white border-b border-gray-200 sticky top-0 z-10">
        <div
            class="h-6 bg-gradient-to-r from-primary-400 via-primary-500 to-primary-600 flex items-center justify-between px-4 text-white text-xs">
            <span>{{ now()->format('H:i') }}</span>
            <span>Manajemen Kategori</span>
            <span>●●●●</span>
        </div>

        <div class="px-4 py-3 flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <a href="{{ route('admin.dashboard') }}" class="text-gray-600 hover:text-gray-900">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </a>
                <h1 class="text-xl font-bold text-gray-900">Kategori Bantuan</h1>
            </div>
            <button wire:click="openCreateModal"
                class="px-4 py-2 bg-primary-600 text-white rounded-lg text-sm font-medium hover:bg-primary-700">
                + Tambah
            </button>
        </div>

        <div class="px-4 pb-3">
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari kategori..."
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent" />
        </div>
    </div>

    <!-- Categories List -->
    <div class="p-4 space-y-3">
        @forelse($categories as $category)
            <div class="bg-white rounded-xl border border-gray-200 p-4 shadow-sm">
                <div class="flex items-start justify-between">
                    <div class="flex-1">
                        <div class="flex items-center space-x-2 mb-2">
                            @if($category->icon)
                                <div class="w-8 h-8 rounded-full flex items-center justify-center"
                                    style="background-color: {{ $category->color }}20;">
                                    <span style="color: {{ $category->color }};">●</span>
                                </div>
                            @endif
                            <h3 class="font-semibold text-gray-900">{{ $category->name }}</h3>
                        </div>

                        @if($category->description)
                            <p class="text-sm text-gray-600 mb-2">{{ $category->description }}</p>
                        @endif

                        <div class="flex flex-wrap gap-2">
                            @if($category->icon)
                                <span class="px-2 py-1 text-xs rounded-full bg-gray-100 text-gray-700">
                                    {{ $category->icon }}
                                </span>
                            @endif

                            <span class="px-2 py-1 text-xs rounded-full"
                                style="background-color: {{ $category->color }}20; color: {{ $category->color }};">
                                {{ $category->color }}
                            </span>

                            <span
                                class="px-2 py-1 text-xs rounded-full {{ $category->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                {{ $category->is_active ? 'Aktif' : 'Tidak Aktif' }}
                            </span>
                        </div>
                    </div>

                    <div class="flex flex-col space-y-2 ml-3">
                        <button wire:click="openEditModal({{ $category->id }})"
                            class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                        </button>
                        <button wire:click="deleteCategory({{ $category->id }})"
                            wire:confirm="Apakah Anda yakin ingin menghapus kategori ini?"
                            class="p-2 text-red-600 hover:bg-red-50 rounded-lg">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center py-12">
                <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                </svg>
                <p class="text-gray-600">Tidak ada data kategori</p>
            </div>
        @endforelse

        <div class="mt-4">
            {{ $categories->links() }}
        </div>
    </div>

    <!-- Modal -->
    @if($showModal)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-end justify-center z-50">
            <div class="bg-white rounded-t-3xl w-full max-w-md max-h-[90vh] overflow-y-auto">
                <div class="sticky top-0 bg-white border-b border-gray-200 px-4 py-3 flex items-center justify-between">
                    <h2 class="text-lg font-bold text-gray-900">{{ $editMode ? 'Edit Kategori' : 'Tambah Kategori' }}</h2>
                    <button wire:click="$set('showModal', false)" class="text-gray-600 hover:text-gray-900">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <form wire:submit="save" class="p-4 space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Kategori *</label>
                        <input type="text" wire:model="name" placeholder="Contoh: Rumah Tangga, Bencana, Sosial..."
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500"
                            required>
                        @error('name') <span class="text-xs text-red-600">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                        <textarea wire:model="description" rows="3" placeholder="Deskripsi singkat tentang kategori..."
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500"></textarea>
                        @error('description') <span class="text-xs text-red-600">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Icon (Heroicon)</label>
                        <input type="text" wire:model="icon" placeholder="heroicon-o-home"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500">
                        <p class="text-xs text-gray-500 mt-1">Contoh: heroicon-o-home, heroicon-o-fire, heroicon-o-heart</p>
                        @error('icon') <span class="text-xs text-red-600">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Warna *</label>
                        <div class="flex space-x-2">
                            <input type="color" wire:model="color"
                                class="w-16 h-10 border border-gray-300 rounded-lg cursor-pointer">
                            <input type="text" wire:model="color" placeholder="#3B82F6"
                                class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500">
                        </div>
                        @error('color') <span class="text-xs text-red-600">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex items-center">
                        <input type="checkbox" wire:model="is_active" id="is_active"
                            class="w-4 h-4 text-primary-600 rounded focus:ring-primary-500">
                        <label for="is_active" class="ml-2 text-sm text-gray-700">Kategori Aktif</label>
                    </div>

                    <div class="flex space-x-3 pt-4">
                        <button type="button" wire:click="$set('showModal', false)"
                            class="flex-1 px-4 py-3 border border-gray-300 text-gray-700 rounded-lg font-medium hover:bg-gray-50">
                            Batal
                        </button>
                        <button type="submit"
                            class="flex-1 px-4 py-3 bg-primary-600 text-white rounded-lg font-medium hover:bg-primary-700">
                            {{ $editMode ? 'Update' : 'Simpan' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    <!-- Bottom Navigation -->
    <div class="fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 px-4 py-2">
        <div class="flex justify-around items-center max-w-md mx-auto">
            <a href="{{ route('admin.dashboard') }}" class="flex flex-col items-center py-2 px-4 text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 13h8V3H3v10zm0 8h8v-6H3v6zm10 0h8V11h-8v10zm0-18v6h8V3h-8z" />
                </svg>
                <span class="text-xs mt-1">Dashboard</span>
            </a>

            <a href="{{ route('admin.users') }}" class="flex flex-col items-center py-2 px-4 text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
                <span class="text-xs mt-1">Users</span>
            </a>

            <a href="{{ route('admin.cities') }}" class="flex flex-col items-center py-2 px-4 text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                <span class="text-xs mt-1">Kota</span>
            </a>

            <a href="{{ route('admin.categories') }}" class="flex flex-col items-center py-2 px-4 text-primary-600">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                    <path
                        d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                </svg>
                <span class="text-xs mt-1 font-medium">Kategori</span>
            </a>
        </div>
    </div>
</div>