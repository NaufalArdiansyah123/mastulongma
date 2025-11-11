<?php

use Livewire\Volt\Component;
use Livewire\WithPagination;
use App\Models\Help;

new class extends Component {
    use WithPagination;

    public $search = '';
    public $statusFilter = '';

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedStatusFilter()
    {
        $this->resetPage();
    }

    public function approveHelp($id)
    {
        $help = Help::findOrFail($id);
        $help->update(['status' => 'active']);
    }

    public function rejectHelp($id)
    {
        $help = Help::findOrFail($id);
        $help->update(['status' => 'rejected']);
    }

    public function completeHelp($id)
    {
        $help = Help::findOrFail($id);
        $help->update(['status' => 'completed']);
    }

    public function with(): array
    {
        $query = Help::with(['user', 'category', 'city']);

        // Filter by city if user is admin (not super_admin)
        if (auth()->user()->role === 'admin') {
            $query->where('city_id', auth()->user()->city_id);
        }

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('title', 'like', '%' . $this->search . '%')
                    ->orWhere('description', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->statusFilter) {
            $query->where('status', $this->statusFilter);
        }

        return [
            'helps' => $query->latest()->paginate(15),
        ];
    }
}; ?>

<div class="min-h-screen bg-gray-50 pb-20">
    <!-- Header -->
    <div class="bg-white border-b border-gray-200 sticky top-0 z-10">
        <div
            class="h-6 bg-gradient-to-r from-primary-400 via-primary-500 to-primary-600 flex items-center justify-between px-4 text-white text-xs">
            <span>{{ now()->format('H:i') }}</span>
            <span>Moderasi Bantuan</span>
            <span>●●●●</span>
        </div>

        <div class="px-4 py-3 flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <a href="{{ route('admin.dashboard') }}" class="text-gray-600 hover:text-gray-900">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </a>
                <h1 class="text-xl font-bold text-gray-900">Moderasi Bantuan</h1>
            </div>
        </div>

        <div class="px-4 pb-3 space-y-2">
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari judul atau deskripsi..."
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500" />

            <select wire:model.live="statusFilter"
                class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-primary-500">
                <option value="">Semua Status</option>
                <option value="pending">Pending</option>
                <option value="active">Aktif</option>
                <option value="in_progress">Dalam Proses</option>
                <option value="completed">Selesai</option>
                <option value="rejected">Ditolak</option>
                <option value="cancelled">Dibatalkan</option>
            </select>
        </div>
    </div>

    <!-- Helps List -->
    <div class="p-4 space-y-3">
        @forelse($helps as $help)
            <div class="bg-white rounded-xl border border-gray-200 p-4 shadow-sm">
                <div class="mb-3">
                    <div class="flex items-start justify-between mb-2">
                        <h3 class="font-semibold text-gray-900 flex-1">{{ $help->title }}</h3>
                        <span class="px-2 py-1 text-xs rounded-full ml-2
                            @if($help->status === 'pending') bg-amber-100 text-amber-700
                            @elseif($help->status === 'active') bg-blue-100 text-blue-700
                            @elseif($help->status === 'in_progress') bg-purple-100 text-purple-700
                            @elseif($help->status === 'completed') bg-green-100 text-green-700
                            @elseif($help->status === 'rejected') bg-red-100 text-red-700
                            @else bg-gray-100 text-gray-700
                            @endif
                        ">
                            {{ ucfirst($help->status) }}
                        </span>
                    </div>

                    <p class="text-sm text-gray-600 mb-2 line-clamp-2">{{ $help->description }}</p>

                    <div class="flex flex-wrap gap-2 text-xs text-gray-600">
                        <span class="flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            {{ $help->user->name }}
                        </span>

                        <span class="flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                            </svg>
                            {{ $help->category->name }}
                        </span>

                        <span class="flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            </svg>
                            {{ $help->city->name }}
                        </span>

                        <span class="flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            {{ $help->created_at->diffForHumans() }}
                        </span>
                    </div>
                </div>

                @if($help->status === 'pending')
                    <div class="flex space-x-2 pt-3 border-t border-gray-200">
                        <button wire:click="approveHelp({{ $help->id }})"
                            class="flex-1 px-4 py-2 bg-green-600 text-white rounded-lg text-sm font-medium hover:bg-green-700">
                            Setujui
                        </button>
                        <button wire:click="rejectHelp({{ $help->id }})"
                            wire:confirm="Apakah Anda yakin ingin menolak permintaan bantuan ini?"
                            class="flex-1 px-4 py-2 bg-red-600 text-white rounded-lg text-sm font-medium hover:bg-red-700">
                            Tolak
                        </button>
                    </div>
                @elseif($help->status === 'in_progress')
                    <div class="pt-3 border-t border-gray-200">
                        <button wire:click="completeHelp({{ $help->id }})"
                            class="w-full px-4 py-2 bg-primary-600 text-white rounded-lg text-sm font-medium hover:bg-primary-700">
                            Tandai Selesai
                        </button>
                    </div>
                @endif
            </div>
        @empty
            <div class="text-center py-12">
                <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                </svg>
                <p class="text-gray-600">Tidak ada data bantuan</p>
            </div>
        @endforelse

        <div class="mt-4">
            {{ $helps->links() }}
        </div>
    </div>

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

            <a href="{{ route('admin.helps') }}" class="flex flex-col items-center py-2 px-4 text-primary-600">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                    <path
                        d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                </svg>
                <span class="text-xs mt-1 font-medium">Bantuan</span>
            </a>

            <a href="{{ route('admin.verifications') }}" class="flex flex-col items-center py-2 px-4 text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                </svg>
                <span class="text-xs mt-1">Verifikasi</span>
            </a>
        </div>
    </div>
</div>