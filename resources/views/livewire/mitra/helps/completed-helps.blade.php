<!-- Mitra Completed Helps Page (grouped) -->
<!-- Migrated content from resources/views/livewire/mitra/completed-helps.blade.php -->
<div class="max-w-md mx-auto min-h-screen bg-gray-50">
    <!-- Header -->
    <div class="bg-gradient-to-br from-blue-400 via-blue-500 to-blue-600 px-6 pt-6 pb-24">
        <div class="flex items-center justify-between mb-6">
            <a href="{{ route('mitra.dashboard') }}" class="text-white">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
            <h1 class="text-xl font-bold text-white">Bantuan Selesai</h1>
            <div class="w-6"></div>
        </div>

        <!-- Search Bar -->
        <div class="relative">
            <input type="text" wire:model.debounce.400ms="search" placeholder="Cari judul atau deskripsi..."
                class="w-full px-4 py-3 rounded-xl bg-white bg-opacity-90 text-gray-900 placeholder-gray-500 focus:bg-opacity-100 focus:ring-2 focus:ring-blue-300 outline-none transition">
            <svg class="absolute right-4 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" fill="none"
                stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
        </div>
    </div>

    <!-- List -->
    <div class="px-6 pb-24 space-y-3 -mt-16 relative z-10">
        @if($helps->count() > 0)
            @foreach($helps as $help)
                <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100 hover:shadow-md transition-shadow">
                    <div class="flex items-start justify-between gap-3">
                        <div class="flex-shrink-0">
                            @if($help->photo)
                                <div class="w-12 h-12 rounded-md overflow-hidden">
                                    <img src="{{ asset('storage/' . $help->photo) }}" alt="{{ $help->title }}"
                                        class="w-full h-full object-cover">
                                </div>
                            @else
                                <div
                                    class="w-12 h-12 rounded-md bg-gradient-to-br from-orange-300 to-orange-400 flex items-center justify-center text-white font-semibold text-sm">
                                    {{ strtoupper(substr($help->user->name ?? 'U', 0, 1)) }}
                                </div>
                            @endif
                        </div>

                        <div class="flex-1 min-w-0">
                            <div class="flex items-start justify-between gap-2 mb-1">
                                <h3 class="font-semibold text-gray-900 text-sm">
                                    {{ $help->title ?? ($help->description ? Str::limit($help->description, 40) : 'Bantuan') }}
                                </h3>
                                <span
                                    class="text-xs text-gray-500 flex-shrink-0">{{ $help->completed_at ? $help->completed_at->diffForHumans() : $help->created_at->diffForHumans() }}</span>
                            </div>
                            <p class="text-xs text-gray-600 mb-2 line-clamp-2">{{ $help->description }}</p>

                            <div class="flex items-center gap-3 flex-wrap">
                                <span class="text-sm font-bold text-green-600">Rp
                                    {{ number_format($help->amount ?? $help->estimated_price ?? 0, 0, ',', '.') }}</span>
                                @if($help->city)
                                    <span class="text-xs text-gray-500 flex items-center gap-0.5">
                                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 24 24">
                                            <path
                                                d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z" />
                                        </svg>
                                        {{ $help->city->name ?? 'Lokasi' }}
                                    </span>
                                @endif
                            </div>
                            <div class="mt-2 flex items-center gap-3 flex-wrap">
                                {{-- Rating summary if exists --}}
                                @if(optional($help->rating)->rating)
                                    <div
                                        class="ml-2 bg-amber-50 px-2 py-1 rounded-md text-amber-800 text-xs flex items-center gap-1">
                                        @for($i = 1; $i <= 5; $i++)
                                            <svg class="w-3 h-3 {{ $i <= ($help->rating->rating ?? 0) ? 'text-amber-400' : 'text-gray-200' }}"
                                                fill="currentColor" viewBox="0 0 20 20">
                                                <path
                                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                            </svg>
                                        @endfor
                                        <span class="ml-1 font-medium">{{ $help->rating->rating ?? 0 }}</span>
                                    </div>
                                @endif
                                
                                {{-- Rating customer button --}}
                                @php
                                    $customerRated = \App\Models\Rating::hasRated($help->id, auth()->id(), 'mitra_to_customer');
                                @endphp
                                @if($customerRated)
                                    <span class="text-xs bg-green-100 text-green-700 px-2 py-1 rounded-md">✓ Customer telah dinilai</span>
                                @else
                                    <button 
                                        onclick="window.location.href='{{ route('mitra.help.detail', $help->id) }}#rating-section'"
                                        class="text-xs bg-yellow-100 text-yellow-700 px-2 py-1 rounded-md hover:bg-yellow-200 transition">
                                        ⭐ Beri rating customer
                                    </button>
                                @endif
                            </div>
                        </div>

                        <a href="{{ route('mitra.help.detail', $help->id) }}"
                            class="flex-shrink-0 text-blue-600 hover:text-blue-800 text-sm font-semibold">Lihat</a>
                    </div>
                </div>
            @endforeach

            <div class="mt-6 mb-6">
                {{ $helps->links('pagination::tailwind') }}
            </div>
        @else
            <div class="flex flex-col items-center justify-center py-20 text-center">
                <div class="bg-gray-100 rounded-full w-16 h-16 flex items-center justify-center mb-4">
                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                    </svg>
                </div>
                <p class="text-gray-600 font-medium text-base mb-1">Belum ada bantuan yang diambil</p>
                <p class="text-gray-400 text-sm">Ambil beberapa permintaan bantuan untuk melihat daftar ini.</p>
            </div>
        @endif
    </div>
</div>