<!-- Mitra All Helps Page (grouped) -->
<!-- Migrated content from resources/views/livewire/mitra/all-helps.blade.php -->
<div class="max-w-md mx-auto min-h-screen bg-gray-50">
    <!-- Header -->
    <div class="bg-gradient-to-br from-blue-400 via-blue-500 to-blue-600 px-6 pt-6 pb-24">
        <div class="flex items-center justify-between mb-6">
            <a href="{{ route('mitra.dashboard') }}" class="text-white">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
            <h1 class="text-xl font-bold text-white">Semua Bantuan</h1>
            <div class="w-6"></div>
        </div>
        <style>
            /* hide scrollbar for the horizontal cards container */
            .hide-scrollbar {
                -ms-overflow-style: none;
                scrollbar-width: none;
            }

            .hide-scrollbar::-webkit-scrollbar {
                display: none;
            }
        </style>
        <!-- Search Bar -->
        <div class="relative">
            <input type="text" wire:model.debounce.400ms="search" placeholder="Cari nama, lokasi, atau bantuan..."
                class="w-full px-4 py-3 rounded-xl bg-white bg-opacity-90 text-gray-900 placeholder-gray-500 focus:bg-opacity-100 focus:ring-2 focus:ring-blue-300 outline-none transition">
            <svg class="absolute right-4 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" fill="none"
                stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
        </div>
    </div>

    <!-- Filters Card -->
    <div class="px-6 -mt-16 mb-6 relative z-10">
        <div class="bg-white rounded-2xl shadow-lg p-4 space-y-4">
            <!-- Improved Filters: chips with icons and horizontal scroll -->
            <div>
                <label class="text-xs font-semibold text-gray-700 block mb-3">Filter</label>
                <div class="overflow-x-auto hide-scrollbar -mx-4 px-4">
                    <div class="flex gap-3 items-center">
                        <button wire:click="$set('filterStatus', 'all')"
                            aria-pressed="{{ $filterStatus === 'all' ? 'true' : 'false' }}"
                            class="flex items-center gap-2 shrink-0 px-4 py-2 rounded-full text-sm font-medium transition shadow-sm {{ $filterStatus === 'all' ? 'bg-primary-500 text-white' : 'bg-white text-gray-700 border border-gray-100 hover:shadow' }}">
                            <span>Semua</span>
                        </button>

                        <button wire:click="$set('filterStatus', 'menunggu_mitra')"
                            aria-pressed="{{ $filterStatus === 'menunggu_mitra' ? 'true' : 'false' }}"
                            class="flex items-center gap-2 shrink-0 px-4 py-2 rounded-full text-sm font-medium transition shadow-sm {{ $filterStatus === 'menunggu_mitra' ? 'bg-primary-500 text-white' : 'bg-white text-gray-700 border border-gray-100 hover:shadow' }}">
                            <span>Menunggu Mitra</span>
                        </button>

                        <div class="ml-2 flex items-center gap-2">
                            <label class="text-xs text-gray-500 mr-2">Sort:</label>
                            <select wire:model="sortBy" class="px-3 py-2 rounded-lg border bg-white text-sm">
                                <option value="latest">Terbaru</option>
                                <option value="oldest">Terlama</option>
                                <option value="nearby">Terdekat</option>
                                <option value="price_high">Harga Tertinggi</option>
                                <option value="price_low">Harga Terendah</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Help List (single-column cards matching screenshot) -->
    <div class="px-6 pb-24">
        @if($helps->count() > 0)
            <div class="space-y-3">
                        @foreach($helps as $help)
                    <div class="relative bg-white rounded-xl border border-gray-100 shadow-sm p-3 flex items-start justify-between">
                        <a href="{{ route('mitra.help.detail', $help->id) }}" class="flex items-start gap-2 w-full">
                            <div class="w-12 h-12 flex-shrink-0 overflow-hidden rounded-xl bg-gray-100">
                                @if(!empty($help->photo))
                                    <img src="{{ asset('storage/' . $help->photo) }}" alt="Foto bantuan" class="w-full h-full object-cover">
                                @elseif(optional($help->user)->photo)
                                    <img src="{{ asset('storage/' . optional($help->user)->photo) }}" alt="Avatar" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-white text-base font-bold bg-gradient-to-br from-orange-300 to-orange-400">
                                        {{ strtoupper(substr($help->user->name ?? 'U', 0, 1)) }}
                                    </div>
                                @endif
                            </div>

                            <div class="flex-1 min-w-0">
                                <div class="flex items-start justify-between">
                                    <div class="text-sm font-medium text-gray-900 truncate">{{ $help->user->name ?? 'Unknown' }}</div>
                                    <div class="text-[11px] text-gray-400 ml-2">{{ $help->created_at->diffForHumans() }}</div>
                                </div>

                                <div class="text-sm text-gray-600 mt-1 leading-tight line-clamp-2">{{ Str::limit($help->description, 120) }}</div>

                                <div class="mt-2 flex items-center justify-between">
                                    <div class="flex items-center gap-2">
                                        <span class="text-xs px-2 py-1 rounded-md bg-green-50 text-green-700 font-semibold">Rp {{ number_format($help->amount ?? 0, 0, ',', '.') }}</span>
                                        <div class="text-xs text-gray-500 flex items-center gap-1">
                                            <svg class="w-3 h-3 text-pink-500" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5S10.62 6.5 12 6.5s2.5 1.12 2.5 2.5S13.38 11.5 12 11.5z" />
                                            </svg>
                                            <span class="truncate">{{ $help->city->name ?? '-' }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>

                        <div class="ml-3 flex-shrink-0 self-start flex flex-col items-end gap-2">
                            <a href="{{ route('mitra.help.detail', $help->id) }}" aria-label="Lihat detail bantuan {{ $help->id }}" class="text-sm font-medium text-primary-600 bg-white border border-gray-100 px-3 py-1 rounded-md hover:bg-gray-50">Lihat</a>
                            @if(is_null($help->mitra_id))
                                <button wire:click.stop="takeHelp({{ $help->id }})" class="text-sm font-medium bg-primary-600 text-white px-3 py-1 rounded-md hover:bg-primary-700">Ambil</button>
                            @else
                                <span class="text-xs text-gray-500">Diambil</span>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-4">
                {{ $helps->links('pagination::tailwind') }}
            </div>
        @else
            <!-- Empty State -->
            <div class="flex flex-col items-center justify-center py-20 text-center">
                <div class="bg-gray-100 rounded-full w-16 h-16 flex items-center justify-center mb-4">
                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                    </svg>
                </div>
                <p class="text-gray-600 font-medium text-base mb-1">Tidak ada bantuan ditemukan</p>
                <p class="text-gray-400 text-sm">
                    {{ $search ? 'Coba cari dengan kata kunci lain' : 'Belum ada permintaan bantuan tersedia' }}
                </p>
            </div>
        @endif
    </div>
</div>