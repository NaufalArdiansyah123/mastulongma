<div class="min-h-screen bg-gradient-to-b from-blue-500 to-blue-600">
    <!-- Mobile Container -->
    <div class="max-w-md mx-auto min-h-screen pb-24">

        <!-- Header -->
        <div class="bg-blue-500 px-6 pt-8 pb-6">
            <div class="flex items-center justify-between text-white mb-6">
                <button onclick="window.history.back()" class="p-2 -ml-2">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>
                <div class="flex-1 text-center">
                    <h1 class="text-xl font-bold">Permintaan Saya</h1>
                    <p class="text-sm text-blue-100 mt-1">Kelola permintaan bantuan Anda</p>
                </div>
                <div class="w-10"></div>
            </div>

            <!-- Filter Tabs -->
            <div class="flex gap-2 overflow-x-auto pb-2 scrollbar-hide">
                <button wire:click="$set('statusFilter', '')"
                    class="px-5 py-2 rounded-full text-sm font-semibold whitespace-nowrap transition-all
                    {{ $statusFilter === '' ? 'bg-white text-blue-600 shadow-lg' : 'bg-blue-400 bg-opacity-40 text-white' }}">
                    Semua
                </button>
                <button wire:click="$set('statusFilter', 'pending')"
                    class="px-5 py-2 rounded-full text-sm font-semibold whitespace-nowrap transition-all
                    {{ $statusFilter === 'pending' ? 'bg-white text-blue-600 shadow-lg' : 'bg-blue-400 bg-opacity-40 text-white' }}">
                    Pending
                </button>
                <button wire:click="$set('statusFilter', 'active')"
                    class="px-5 py-2 rounded-full text-sm font-semibold whitespace-nowrap transition-all
                    {{ $statusFilter === 'active' ? 'bg-white text-blue-600 shadow-lg' : 'bg-blue-400 bg-opacity-40 text-white' }}">
                    Disetujui
                </button>
                <button wire:click="$set('statusFilter', 'completed')"
                    class="px-5 py-2 rounded-full text-sm font-semibold whitespace-nowrap transition-all
                    {{ $statusFilter === 'completed' ? 'bg-white text-blue-600 shadow-lg' : 'bg-blue-400 bg-opacity-40 text-white' }}">
                    Selesai
                </button>
            </div>
        </div>

        <!-- Content Area -->
        <div class="bg-gray-50 min-h-screen px-6 pt-6 -mt-4 rounded-t-3xl">

            <!-- Helps List -->
            <div class="space-y-4">
                @forelse($helps as $help)
                    <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
                        <!-- Category Badge & Status -->
                        <div class="flex items-start justify-between mb-3">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold
                                    {{ $help->category_id == 1 ? 'bg-orange-100 text-orange-700' : '' }}
                                    {{ $help->category_id == 2 ? 'bg-pink-100 text-pink-700' : '' }}
                                    {{ $help->category_id == 3 ? 'bg-purple-100 text-purple-700' : '' }}
                                    {{ !in_array($help->category_id, [1, 2, 3]) ? 'bg-blue-100 text-blue-700' : '' }}">
                                <svg class="w-3.5 h-3.5 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M2 5a2 2 0 012-2h7a2 2 0 012 2v4a2 2 0 01-2 2H9l-3 3v-3H4a2 2 0 01-2-2V5z" />
                                    <path
                                        d="M15 7v2a4 4 0 01-4 4H9.828l-1.766 1.767c.28.149.599.233.938.233h2l3 3v-3h2a2 2 0 002-2V9a2 2 0 00-2-2h-1z" />
                                </svg>
                                {{ $help->category->name ?? 'Umum' }}
                            </span>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold
                                    {{ $help->status === 'pending' ? 'bg-gray-100 text-gray-700' : '' }}
                                    {{ $help->status === 'active' ? 'bg-blue-100 text-blue-700' : '' }}
                                    {{ $help->status === 'completed' ? 'bg-green-100 text-green-700' : '' }}
                                    {{ $help->status === 'rejected' ? 'bg-red-100 text-red-700' : '' }}">
                                {{ $help->status === 'active' ? 'Approved' : ucfirst($help->status) }}
                            </span>
                        </div>

                        <!-- Title -->
                        <h3 class="font-bold text-gray-900 text-base leading-tight mb-2">
                            {{ $help->title }}
                        </h3>

                        <!-- Description -->
                        <p class="text-sm text-gray-600 leading-relaxed mb-4 line-clamp-2">
                            {{ $help->description }}
                        </p>

                        <!-- Location & Date -->
                        <div class="space-y-2 text-xs text-gray-500">
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-2 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z"
                                        clip-rule="evenodd" />
                                </svg>
                                {{ $help->city->name ?? 'Jakarta' }}
                            </div>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    {{ $help->address ?? 'Alamat lengkap bantuan' }}
                                </div>
                                <span class="text-gray-400">{{ $help->created_at->diffForHumans() }}</span>
                            </div>
                        </div>

                        <!-- Action Buttons for Pending -->
                        @if($help->status === 'pending')
                            <div class="flex gap-2 mt-4 pt-4 border-t border-gray-100">
                                <button wire:click="approveHelp({{ $help->id }})"
                                    class="flex-1 px-4 py-2.5 bg-blue-500 text-white text-sm font-semibold rounded-xl hover:bg-blue-600 transition">
                                    Setujui
                                </button>
                                <button wire:click="rejectHelp({{ $help->id }})"
                                    class="px-4 py-2.5 bg-gray-100 text-gray-700 text-sm font-semibold rounded-xl hover:bg-gray-200 transition">
                                    Tolak
                                </button>
                            </div>
                        @endif
                    </div>
                @empty
                    <div class="bg-white rounded-2xl p-12 text-center shadow-sm">
                        <svg class="w-20 h-20 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                        </svg>
                        <p class="text-gray-500 font-medium text-base">Tidak ada permintaan</p>
                        <p class="text-gray-400 text-sm mt-1">Belum ada permintaan bantuan yang masuk</p>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if ($helps->hasPages())
                <div class="mt-6 pb-4">
                    {{ $helps->links() }}
                </div>
            @endif
        </div>

        <!-- Bottom Navigation -->
        <div class="fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 shadow-2xl">
            <div class="max-w-md mx-auto flex items-center justify-around px-4 py-3">
                <a href="{{ route('admin.dashboard') }}"
                    class="flex flex-col items-center py-2 text-gray-400 hover:text-blue-600 transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                </a>
                <a href="{{ route('admin.helps') }}" class="flex flex-col items-center py-2 relative">
                    <div class="absolute -top-6 bg-blue-500 rounded-full p-4 shadow-xl">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                </a>
                <a href="#" class="flex flex-col items-center py-2 text-gray-400 hover:text-blue-600 transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                </a>
                <a href="#" class="flex flex-col items-center py-2 text-gray-400 hover:text-blue-600 transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                </a>
            </div>
        </div>
    </div>

    <style>
        .scrollbar-hide::-webkit-scrollbar {
            display: none;
        }

        .scrollbar-hide {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
</div>