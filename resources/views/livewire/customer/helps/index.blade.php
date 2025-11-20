<div>
    <div class="min-h-screen {{ $helps->isEmpty() ? 'h-screen max-h-screen overflow-hidden' : '' }} bg-gray-50">
        <!-- Mobile Container -->
        <div class="max-w-md mx-auto min-h-screen pb-24">

            <!-- Header -->
            <div class="bg-gradient-to-br from-primary-400 via-primary-500 to-primary-600 px-5 pt-6 pb-5 shadow-lg">
                <div class="flex items-center justify-between text-white mb-4">
                    <button onclick="window.history.back()" class="p-1.5 -ml-1.5">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M15 19l-7-7 7-7" />
                        </svg>
                    </button>
                    <div class="flex-1 text-center">
                        <h1 class="text-lg font-bold">Permintaan Saya</h1>
                        <p class="text-xs text-white/90 mt-0.5">Kelola permintaan bantuan Anda</p>
                    </div>
                    <div class="w-8"></div>
                </div>

                <!-- Filter Tabs -->
                <div class="flex gap-2 overflow-x-auto pb-2 scrollbar-hide">
                    <button wire:click="$set('statusFilter', '')" class="px-4 py-1.5 rounded-full text-xs font-semibold whitespace-nowrap transition-all
                    {{ $statusFilter === '' ? 'bg-white text-primary-600 shadow-md' : 'bg-white/30 text-white' }}">
                        Semua
                    </button>
                    <button wire:click="$set('statusFilter', 'menunggu_mitra')"
                        class="px-4 py-1.5 rounded-full text-xs font-semibold whitespace-nowrap transition-all
                    {{ $statusFilter === 'menunggu_mitra' ? 'bg-white text-primary-600 shadow-md' : 'bg-white/30 text-white' }}">
                        Menunggu Mitra
                    </button>
                    <button wire:click="$set('statusFilter', 'memperoleh_mitra')"
                        class="px-4 py-1.5 rounded-full text-xs font-semibold whitespace-nowrap transition-all
                    {{ $statusFilter === 'memperoleh_mitra' ? 'bg-white text-primary-600 shadow-md' : 'bg-white/30 text-white' }}">
                        Memperoleh Mitra
                    </button>
                    <button wire:click="$set('statusFilter', 'selesai')"
                        class="px-4 py-1.5 rounded-full text-xs font-semibold whitespace-nowrap transition-all
                    {{ $statusFilter === 'selesai' ? 'bg-white text-primary-600 shadow-md' : 'bg-white/30 text-white' }}">
                        Selesai
                    </button>
                </div>
            </div>

            <!-- Content Area -->
            <div class="bg-gray-50 min-h-screen px-5 pt-5 -mt-4 rounded-t-3xl">

                <!-- DEBUG: test ping (remove after debugging) -->


                <!-- Helps List (NEW layouts per statusFilter) -->
                <div class="space-y-4">
                    @php
                        $waiting = $helps->where('status', 'menunggu_mitra');
                        $processing = $helps->where('status', 'memperoleh_mitra');
                        $finished = $helps->where('status', 'selesai');
                    @endphp

                    {{-- View: single-mode "Menunggu Mitra" (large friendly hero + card) --}}
                    @if($statusFilter === 'menunggu_mitra')
                        <div
                            class="bg-gradient-to-br from-primary-400 via-primary-500 to-primary-600 text-white rounded-2xl p-5 shadow-md">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h2 class="text-2xl font-bold">Menunggu Mitra</h2>
                                    <p class="text-sm mt-1">Permintaan bantuan Anda menunggu mitra yang bersedia mengambil.
                                    </p>
                                </div>
                                <div class="hidden sm:block opacity-90">
                                    <img src="" alt="illustration" class="w-24 h-24 object-contain">
                                </div>
                            </div>
                        </div>

                        {{-- Notice + explanatory block (like the mockup) --}}
                        <div class="mt-4 bg-white rounded-2xl p-4 shadow-sm">
                            <div class="flex items-start gap-3">
                                <div class="w-12 h-12 rounded-full bg-gray-100 flex items-center justify-center">
                                    <svg class="w-6 h-6 text-gray-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 14l9-5-9-5-9 5 9 5z" />
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <div class="font-semibold text-gray-900">Belum ada mitra yang mengambil permintaan Anda.
                                    </div>
                                    <div class="text-sm text-gray-600 mt-1">Mohon tunggu sebentar...</div>
                                </div>
                            </div>
                        </div>

                        @forelse($waiting as $help)
                            <div class="bg-white rounded-2xl p-4 sm:p-5 shadow-md overflow-hidden">
                                {{-- Mobile: Vertical Stack --}}
                                <div class="sm:hidden">
                                    <div class="flex gap-3">
                                        <div class="w-24 h-24 rounded-md overflow-hidden flex-shrink-0">
                                            <img src="{{ $help->photo ? asset('storage/' . $help->photo) : asset('images/placeholder-help.svg') }}"
                                                alt="{{ $help->title }}" class="w-full h-full object-cover">
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <h3 class="text-base font-bold text-gray-900 leading-tight line-clamp-2">
                                                {{ $help->title }}</h3>
                                            <div class="mt-2 text-primary-700 font-semibold text-sm">Rp
                                                {{ number_format($help->amount, 0, ',', '.') }}</div>
                                            <div class="mt-1 inline-flex items-center gap-1 text-xs text-gray-600">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                                </svg>
                                                {{ optional($help->category)->name ?? 'Kategori' }}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mt-3 text-sm text-gray-700">{{ \Illuminate\Support\Str::limit($help->description, 140) }}</div>

                                    <div class="mt-2 space-y-1.5 text-sm">
                                        <div class="flex items-start gap-2">
                                            <svg class="w-4 h-4 text-primary-500 flex-shrink-0 mt-0.5" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                            <div class="text-gray-700 text-xs leading-tight flex-1">
                                                <div class="font-semibold">Alamat:</div>
                                                <div class="mt-0.5">{{ $help->location ?? '-' }}</div>
                                            </div>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <svg class="w-4 h-4 text-primary-500 flex-shrink-0" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                            <span
                                                class="text-gray-700 text-xs">{{ optional($help->created_at)->format('d M Y') }}</span>
                                        </div>
                                    </div>

                                    <div class="mt-4 grid grid-cols-2 gap-3">
                                        <a href="#" wire:click.prevent="editHelp({{ $help->id }})"
                                            class="inline-flex items-center justify-center bg-primary-500 text-white rounded-lg py-2.5 text-sm">Edit
                                            permintaan</a>
                                        <button wire:click="deleteHelp({{ $help->id }})"
                                            class="inline-flex items-center justify-center bg-red-500 text-white rounded-lg py-2.5 text-sm">Batalkan
                                            permintaan</button>
                                    </div>

                                    <div class="mt-3 bg-gray-50 p-3 rounded-md text-sm">
                                        <div class="font-semibold text-gray-700 mb-2">Aktivitas Terbaru:</div>
                                        <ul class="text-xs text-gray-600 space-y-1">
                                            <li>• Mitra Anda belum mengambil permintaan (status menunggu).</li>
                                            <li>• Terakhir diperbarui: {{ optional($help->updated_at)->format('d M Y H:i') }}
                                            </li>
                                        </ul>
                                    </div>

                                    <div class="mt-3 flex items-center justify-between">
                                        <button wire:click="refreshHelp({{ $help->id }})"
                                            class="flex items-center gap-2 px-3 py-2 bg-white border rounded-full text-sm">
                                            <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                            </svg>
                                            Perbarui
                                        </button>
                                        <div class="inline-flex items-center gap-2">
                                            <span class="text-sm text-gray-600">Notifikasi</span>
                                            <label class="relative inline-flex items-center cursor-pointer">
                                                <input type="checkbox" class="sr-only peer" checked>
                                                <div class="w-9 h-5 bg-gray-200 rounded-full peer-checked:bg-primary-500"></div>
                                                <div
                                                    class="absolute left-0.5 top-0.5 w-4 h-4 bg-white rounded-full shadow peer-checked:translate-x-4 transition-transform">
                                                </div>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                {{-- Desktop: Horizontal Layout --}}
                                <div class="hidden sm:flex gap-4">
                                    <div class="flex-shrink-0">
                                        <div class="w-36 h-36 rounded-md overflow-hidden">
                                            <img src="{{ $help->photo ? asset('storage/' . $help->photo) : asset('images/placeholder-help.svg') }}"
                                                alt="{{ $help->title }}" class="w-full h-full object-cover block">
                                        </div>
                                    </div>

                                    <div class="flex-1 flex flex-col">
                                        <div class="flex-1">
                                            <div class="flex items-start justify-between">
                                                <div class="pr-3">
                                                    <h3 class="text-lg font-bold text-gray-900 leading-tight line-clamp-2">
                                                        {{ $help->title }}</h3>
                                                    <div class="mt-2 flex items-center gap-3">
                                                        <div class="text-primary-700 font-semibold text-base">Rp
                                                            {{ number_format($help->amount, 0, ',', '.') }}</div>
                                                        <span
                                                            class="inline-flex items-center gap-2 bg-gray-100 text-gray-700 px-2 py-1 rounded-full text-xs">
                                                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor"
                                                                viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2" d="M9 12l2 2 4-4" />
                                                            </svg>
                                                            <span
                                                                class="font-medium text-xs">{{ optional($help->category)->name ?? 'Kategori' }}</span>
                                                        </span>
                                                    </div>
                                                    <div class="text-sm text-gray-600 mt-3 leading-relaxed line-clamp-3">
                                                        {{ Str::limit($help->description, 120) }}</div>
                                                </div>
                                                <div class="text-right">
                                                    <div class="text-xs text-gray-500">Status</div>
                                                    <div
                                                        class="mt-2 inline-block bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-sm">
                                                        Menunggu Mitra</div>
                                                </div>
                                            </div>

                                            <div class="mt-4 text-sm text-gray-600">
                                                <div class="flex items-center gap-2"><svg class="w-4 h-4 text-primary-500"
                                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M9 12l2 2 4-4" />
                                                    </svg>
                                                    <span>Alat sudah disediakan</span>
                                                </div>
                                                <div class="mt-2"><strong>Alamat:</strong>
                                                    <div class="text-gray-700">{{ $help->location ?? '-' }}</div>
                                                </div>
                                            </div>


                                            <div class="mt-4 grid grid-cols-2 gap-3">
                                                <a href="#" wire:click.prevent="editHelp({{ $help->id }})"
                                                    class="inline-flex items-center justify-center bg-primary-500 text-white rounded-lg py-3">Edit
                                                    permintaan</a>
                                                <button wire:click="deleteHelp({{ $help->id }})"
                                                    class="inline-flex items-center justify-center bg-red-500 text-white rounded-lg py-3">Batalkan
                                                    permintaan</button>
                                            </div>

                                            <div class="mt-3 bg-gray-50 p-3 rounded-md text-sm">
                                                <div class="font-semibold text-gray-700 mb-2">Aktivitas Terbaru:</div>
                                                <ul class="list-disc list-inside text-gray-600">
                                                    <li>Mitra Anda belum mengambil permintaan (status menunggu).</li>
                                                    <li>Terakhir diperbarui:
                                                        {{ optional($help->updated_at)->format('d M Y H:i') }}</li>
                                                </ul>
                                            </div>

                                            <div class="mt-3 flex items-center gap-3">
                                                <button wire:click="refreshHelp({{ $help->id }})"
                                                    class="flex items-center gap-2 px-3 py-2 bg-white border rounded-full text-sm">
                                                    <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                                    </svg>
                                                    Perbarui
                                                </button>
                                                <div class="ml-auto inline-flex items-center gap-3">
                                                    <div class="text-sm text-gray-600">Notifikasi</div>
                                                    <label class="relative inline-flex items-center cursor-pointer">
                                                        <input type="checkbox" class="sr-only peer" checked>
                                                        <div
                                                            class="w-10 h-5 bg-gray-200 rounded-full peer-checked:bg-primary-500">
                                                        </div>
                                                        <div
                                                            class="absolute left-0.5 top-0.5 w-4 h-4 bg-white rounded-full shadow peer-checked:translate-x-5 transition-transform">
                                                        </div>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        @empty
                                <div class="bg-white rounded-2xl p-8 text-center shadow-md">
                                    <p class="text-gray-900 font-semibold text-base">Belum ada permintaan Menunggu Mitra</p>
                                    <p class="text-gray-500 text-sm mt-2">Coba buat permintaan baru atau ubah filter.</p>
                                </div>
                            @endforelse

                            {{-- View: single-mode "Memperoleh Mitra" / diproses (detailed partner card) --}}
                    @elseif($statusFilter === 'memperoleh_mitra')
                            @forelse($processing as $help)
                                <div class="bg-white rounded-2xl p-4 shadow-md overflow-hidden">
                                    <div class="flex items-start justify-between mb-3">
                                        <h2 class="text-xl font-bold text-gray-900">{{ $help->title }}</h2>
                                        <div
                                            class="bg-primary-500 text-white text-sm font-semibold px-3 py-1 rounded-full whitespace-nowrap ml-2">
                                            Rp {{ number_format($help->amount, 0, ',', '.') }}
                                        </div>
                                    </div>

                                    <div class="flex items-center gap-2 mb-3">
                                        <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                        </svg>
                                        <span
                                            class="text-sm text-gray-700">{{ optional($help->category)->name ?? 'Perbaikan Rumah' }}</span>
                                    </div>

                                    <div
                                        class="inline-block bg-yellow-400 text-gray-900 text-sm font-semibold px-4 py-2 rounded-lg mb-4">
                                        Diproses Mitra
                                    </div>

                                    <div class="w-full h-52 rounded-xl overflow-hidden mb-4">
                                        <img src="{{ $help->photo ? asset('storage/' . $help->photo) : asset('images/placeholder-help.svg') }}"
                                            alt="{{ $help->title }}" class="w-full h-full object-cover">
                                    </div>

                                    <div class="space-y-3 mb-4">
                                        <div class="flex items-start gap-2">
                                            <svg class="w-5 h-5 text-primary-500 flex-shrink-0 mt-0.5" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 12l2 2 4-4" />
                                            </svg>
                                            <span class="text-sm text-gray-700">{{ \Illuminate\Support\Str::limit($help->description, 180) }}</span>
                                        </div>

                                        <div class="flex items-start gap-2">
                                            <svg class="w-5 h-5 text-primary-500 flex-shrink-0 mt-0.5" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                            <span
                                                class="text-sm text-gray-700">{{ $help->location ?? 'Alamat tidak tersedia' }}</span>
                                        </div>

                                        <div wire:poll.5s class="flex items-center gap-2">
                                            <svg class="w-5 h-5 text-primary-500" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                            <span class="text-sm text-gray-600">Dibuat:
                                                {{ optional($help->created_at)->format('d M Y • H:i') }}</span>
                                        </div>

                                        <div wire:poll.5s class="flex items-center gap-2">
                                            <svg class="w-5 h-5 text-primary-500" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                            <span class="text-sm text-gray-600">Dilihat oleh {{ $help->views ?? $help->views_count ?? 0 }} mitra</span>
                                        </div>
                                    </div>

                                    <div class="border-t pt-4 mt-4">
                                        <h3 class="font-bold text-gray-900 mb-3">Diambil oleh:</h3>
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center gap-3">
                                                <div class="w-12 h-12 rounded-full bg-gray-200 overflow-hidden">
                                                    <img src="{{ optional($help->mitra)->selfie_photo ? asset('storage/' . optional($help->mitra)->selfie_photo) : asset('images/avatar-placeholder.svg') }}"
                                                        alt="Mitra" class="w-full h-full object-cover">
                                                </div>
                                                <div>
                                                    <div class="font-semibold text-gray-900">
                                                        {{ optional($help->mitra)->name ?? 'Nama Mitra' }}</div>
                                                    <div class="text-xs text-gray-500">Diambil: {{ optional($help->taken_at)->format('d M Y • H:i') ?? '-' }}</div>
                                                    <div class="flex items-center gap-1">
                                                        <svg class="w-4 h-4 text-yellow-400" fill="currentColor"
                                                            viewBox="0 0 20 20">
                                                            <path
                                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                        </svg>
                                                        <span
                                                            class="text-sm font-medium">{{ number_format(optional($help->mitra)->rating ?? optional($help->mitra)->ratings()->avg('rating') ?? 0, 1) }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="flex gap-2">
                                                <a href="{{ route('customer.chat', ['help' => $help->id]) }}" class="p-2.5 bg-primary-500 text-white rounded-lg hover:bg-primary-600 flex items-center justify-center" title="Buka Chat">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                                    </svg>
                                                </a>
                                               
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-4 bg-gray-50 rounded-lg p-3">
                                        <div class="flex items-center justify-between text-sm">
                                            <div class="flex items-center gap-2">
                                                <div class="w-2 h-2 bg-blue-500 rounded-full"></div>
                                                <span class="text-gray-700">Dibuat</span>
                                            </div>
                                            <span class="text-gray-600">{{ optional($help->created_at)->format('H:i') ?? '-' }}</span>
                                        </div>
                                        <div class="flex items-center justify-between text-sm mt-2">
                                            <div wire:poll.5s class="flex items-center gap-2">
                                                    <div class="w-2 h-2 bg-blue-500 rounded-full"></div>
                                                    <span class="text-gray-700">Dilihat {{ $help->views ?? $help->views_count ?? 0 }} mitra</span>
                                                </div>
                                                <span class="text-gray-600">{{ optional($help->updated_at)->format('H:i') ?? '-' }}</span>
                                        </div>
                                        <div class="flex items-center justify-between text-sm mt-2">
                                            <div class="flex items-center gap-2">
                                                <div class="w-2 h-2 bg-blue-500 rounded-full"></div>
                                                <span class="text-gray-700">Diambil</span>
                                            </div>
                                            <span class="text-gray-600">{{ optional($help->taken_at)->format('H:i') ?? '-' }}</span>
                                        </div>
                                    </div>
                                    {{-- Tombol Selesai (hanya tampil untuk pemilik permintaan ketika mitra telah melakukan tugasnya) --}}
                                    @if($help->status === 'memperoleh_mitra' && $help->mitra_id)
                                        <div class="mt-4">
                                            <button wire:click="confirmCompletion({{ $help->id }})"
                                                class="w-full sm:w-auto bg-green-500 hover:bg-green-600 text-white font-semibold py-3 px-4 rounded-lg transition">
                                                Selesai
                                            </button>
                                        </div>
                                    @endif
                                </div>
                            @empty
                                <div class="bg-white rounded-2xl p-8 text-center shadow-md">
                                    <p class="text-gray-900 font-semibold text-base">Tidak ada permintaan yang diproses</p>
                                </div>
                            @endforelse

                            {{-- View: single-mode "Selesai" (completed with rating) --}}
                        @elseif($statusFilter === 'selesai')
                            @forelse($finished as $help)
                                <div class="bg-white rounded-2xl p-4 shadow-md overflow-hidden">
                                    <div class="flex items-start justify-between mb-3">
                                        <h2 class="text-xl font-bold text-gray-900">{{ $help->title }}</h2>
                                        <div
                                            class="bg-green-500 text-white text-sm font-semibold px-3 py-1 rounded-full whitespace-nowrap ml-2">
                                            Rp {{ number_format($help->amount, 0, ',', '.') }}
                                        </div>
                                    </div>

                                    <div class="flex items-center gap-2 mb-3">
                                        <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                        </svg>
                                        <span
                                            class="text-sm text-gray-700">{{ optional($help->category)->name ?? 'Kategori' }}</span>
                                    </div>

                                    <div
                                        class="inline-flex items-center gap-2 bg-green-100 text-green-800 text-sm font-semibold px-4 py-2 rounded-lg mb-4">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        Selesai
                                    </div>

                                    <div class="w-full h-52 rounded-xl overflow-hidden mb-4">
                                        <img src="{{ $help->photo ? asset('storage/' . $help->photo) : asset('images/placeholder-help.svg') }}"
                                            alt="{{ $help->title }}" class="w-full h-full object-cover">
                                    </div>

                                    <div class="space-y-3 mb-4">
                                        <div class="flex items-start gap-2">
                                            <svg class="w-5 h-5 text-green-500 flex-shrink-0 mt-0.5" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                            <span
                                                class="text-sm text-gray-700">{{ $help->location ?? 'Alamat tidak tersedia' }}</span>
                                        </div>

                                        <div class="flex items-center gap-2">
                                            <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                            <span class="text-sm text-gray-600">Selesai:
                                                {{ optional($help->updated_at)->format('d M Y • H:i') }}</span>
                                        </div>
                                    </div>

                                    <div class="border-t pt-4 mt-4">
                                        <h3 class="font-bold text-gray-900 mb-3">Dikerjakan oleh:</h3>
                                        <div class="flex items-center justify-between mb-4">
                                            <div class="flex items-center gap-3">
                                                <div class="w-12 h-12 rounded-full bg-gray-200 overflow-hidden">
                                                    <img src="{{ optional($help->mitra)->selfie_photo ? asset('storage/' . optional($help->mitra)->selfie_photo) : asset('images/avatar-placeholder.svg') }}"
                                                        alt="Mitra" class="w-full h-full object-cover">
                                                </div>
                                                <div>
                                                    <div class="font-semibold text-gray-900">
                                                        {{ optional($help->mitra)->name ?? 'Nama Mitra' }}</div>
                                                    <div class="flex items-center gap-1">
                                                        <svg class="w-4 h-4 text-yellow-400" fill="currentColor"
                                                            viewBox="0 0 20 20">
                                                            <path
                                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                        </svg>
                                                        <span
                                                            class="text-sm font-medium">{{ number_format(optional($help->mitra)->rating ?? optional($help->mitra)->ratings()->avg('rating') ?? 0, 1) }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="flex gap-2">
                                                <button class="p-2.5 bg-green-500 text-white rounded-lg hover:bg-green-600">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                                    </svg>
                                                </button>
                                                <button class="p-2.5 bg-green-500 text-white rounded-lg hover:bg-green-600">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Rating Section --}}
                                    <div
                                        class="border-t pt-4 mt-4 bg-gradient-to-br from-amber-50 to-orange-50 -mx-4 -mb-4 px-4 pb-4 rounded-b-2xl">
                                        <h3 class="font-bold text-gray-900 mb-3 flex items-center gap-2">
                                            <svg class="w-5 h-5 text-amber-500" fill="currentColor" viewBox="0 0 20 20">
                                                <path
                                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                            </svg>
                                            Beri Rating untuk Mitra
                                        </h3>

                                        @if($help->rating)
                                            {{-- Already rated --}}
                                            <div class="bg-white rounded-lg p-4 border-2 border-green-200">
                                                <div class="flex items-center gap-2 mb-2">
                                                    <span class="text-sm text-gray-600">Rating Anda:</span>
                                                    <div class="flex items-center gap-1">
                                                        @for($i = 1; $i <= 5; $i++)
                                                            <svg class="w-5 h-5 {{ $i <= ($help->rating->rating ?? 0) ? 'text-yellow-400' : 'text-gray-300' }}"
                                                                fill="currentColor" viewBox="0 0 20 20">
                                                                <path
                                                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                            </svg>
                                                        @endfor
                                                        <span
                                                            class="ml-2 font-semibold text-gray-900">{{ $help->rating->rating ?? 0 }}/5</span>
                                                    </div>
                                                </div>
                                                @if(!empty($help->rating->review))
                                                    <p class="text-sm text-gray-700 italic">"{{ $help->rating->review }}"</p>
                                                @endif
                                                <div class="flex items-center gap-2 mt-3">
                                                    <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                    <span class="text-sm text-green-600 font-medium">Terima kasih atas rating
                                                        Anda!</span>
                                                </div>
                                            </div>
                                        @else
                                            {{-- Not rated yet --}}
                                            <div class="bg-white rounded-lg p-4">
                                                <p class="text-sm text-gray-600 mb-3">Bagaimana pengalaman Anda dengan mitra ini?
                                                </p>

                                                <div class="flex items-center justify-center gap-2 mb-4">
                                                    @for($i = 1; $i <= 5; $i++)
                                                        <button wire:click="setRating({{ $help->id }}, {{ $i }})"
                                                            class="rating-star hover:scale-110 transition-transform">
                                                            <svg class="w-10 h-10 text-gray-300 hover:text-yellow-400 cursor-pointer"
                                                                fill="currentColor" viewBox="0 0 20 20">
                                                                <path
                                                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                            </svg>
                                                        </button>
                                                    @endfor
                                                </div>

                                                <textarea wire:model="ratingComment" rows="3"
                                                    placeholder="Tuliskan ulasan Anda (opsional)..."
                                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-amber-500 focus:border-transparent resize-none"></textarea>

                                                <button wire:click="submitRating({{ $help->id }})"
                                                    class="w-full mt-3 bg-gradient-to-r from-amber-500 to-orange-500 hover:from-amber-600 hover:to-orange-600 text-white font-semibold py-3 rounded-lg transition-all duration-200 flex items-center justify-center gap-2">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M5 13l4 4L19 7" />
                                                    </svg>
                                                    Kirim Rating
                                                </button>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @empty
                                <div class="bg-white rounded-2xl p-8 text-center shadow-md">
                                    <p class="text-gray-900 font-semibold text-base">Belum ada permintaan selesai</p>
                                    <p class="text-gray-500 text-sm mt-2">Permintaan yang sudah selesai akan muncul di sini.</p>
                                </div>
                            @endforelse

                            {{-- View: all helps grouped by status (main page) --}}
                        @else
                            <div class="space-y-5">
                                {{-- Menunggu Mitra --}}
                                <div
                                    class="bg-gradient-to-br from-yellow-50 to-amber-50 rounded-2xl p-4 shadow-md border border-yellow-100">
                                    <div class="flex items-center justify-between mb-4">
                                        <div class="flex items-center gap-2">
                                            <div
                                                class="w-10 h-10 bg-yellow-500 rounded-xl flex items-center justify-center shadow-lg">
                                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                            </div>
                                            <div>
                                                <h3 class="text-base font-bold text-gray-900">Menunggu Mitra</h3>
                                                <p class="text-xs text-gray-600">{{ $waiting->count() }} permintaan</p>
                                            </div>
                                        </div>
                                        <div class="bg-yellow-500 text-white text-xs font-bold px-3 py-1.5 rounded-full">
                                            Aktif
                                        </div>
                                    </div>

                                    @forelse($waiting as $help)
                                        <div
                                            class="bg-white rounded-xl p-4 mb-3 last:mb-0 shadow-lg hover:shadow-xl transition-shadow duration-200 border border-gray-100">
                                            <div class="flex gap-3">
                                                <div class="w-24 h-24 rounded-xl overflow-hidden flex-shrink-0 shadow-md">
                                                    <img src="{{ $help->photo ? asset('storage/' . $help->photo) : asset('images/placeholder-help.svg') }}"
                                                        alt="{{ $help->title }}" class="w-full h-full object-cover">
                                                </div>
                                                <div class="flex-1 min-w-0">
                                                    <div class="flex items-start justify-between gap-2 mb-2">
                                                        <h4
                                                            class="font-bold text-base text-gray-900 leading-tight line-clamp-2 flex-1">
                                                            {{ $help->title }}</h4>
                                                        <div
                                                            class="bg-yellow-500 text-white text-xs font-bold px-2.5 py-1 rounded-lg whitespace-nowrap">
                                                            Rp {{ number_format($help->amount, 0, ',', '.') }}
                                                        </div>
                                                    </div>

                                                    <div class="flex items-center gap-1.5 mb-2">
                                                        <svg class="w-3.5 h-3.5 text-yellow-600" fill="none"
                                                            stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                                        </svg>
                                                        <span
                                                            class="text-xs font-medium text-gray-700">{{ optional($help->category)->name ?? 'Kategori' }}</span>
                                                    </div>

                                                    <div class="flex items-start gap-1.5 mb-2">
                                                        <svg class="w-3.5 h-3.5 text-gray-500 flex-shrink-0 mt-0.5" fill="none"
                                                            stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                                        </svg>
                                                        <span
                                                            class="text-xs text-gray-600 line-clamp-1">{{ $help->location }}</span>
                                                    </div>

                                                    <div class="flex items-center gap-3 text-[10px] text-gray-500 mt-2">
                                                        <div class="flex items-center gap-1 bg-gray-50 px-2 py-1 rounded-md">
                                                            <svg class="w-3 h-3" fill="none" stroke="currentColor"
                                                                viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                            </svg>
                                                            <span>{{ $help->views ?? 0 }} dilihat</span>
                                                        </div>
                                                        <div class="flex items-center gap-1 bg-gray-50 px-2 py-1 rounded-md">
                                                            <svg class="w-3 h-3" fill="none" stroke="currentColor"
                                                                viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                            </svg>
                                                            <span>{{ optional($help->created_at)->format('d M') }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="bg-white rounded-xl p-6 text-center shadow-md">
                                            <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                            </svg>
                                            <p class="text-sm font-medium text-gray-500">Tidak ada permintaan menunggu mitra</p>
                                        </div>
                                    @endforelse
                                </div>

                                {{-- Diproses Mitra --}}
                                <div
                                    class="bg-gradient-to-br from-blue-50 to-cyan-50 rounded-2xl p-4 shadow-md border border-blue-100">
                                    <div class="flex items-center justify-between mb-4">
                                        <div class="flex items-center gap-2">
                                            <div
                                                class="w-10 h-10 bg-blue-500 rounded-xl flex items-center justify-center shadow-lg">
                                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                            </div>
                                            <div>
                                                <h3 class="text-base font-bold text-gray-900">Diproses Mitra</h3>
                                                <p class="text-xs text-gray-600">{{ $processing->count() }} sedang
                                                    dikerjakan</p>
                                            </div>
                                        </div>
                                        <div
                                            class="bg-blue-500 text-white text-xs font-bold px-3 py-1.5 rounded-full animate-pulse">
                                            Progress
                                        </div>
                                    </div>

                                    @forelse($processing as $help)
                                        <div
                                            class="bg-white rounded-xl p-4 mb-3 last:mb-0 shadow-lg hover:shadow-xl transition-shadow duration-200 border border-gray-100">
                                            <div class="flex gap-3 mb-3">
                                                <div class="w-20 h-20 rounded-xl overflow-hidden flex-shrink-0 shadow-md">
                                                    <img src="{{ $help->photo ? asset('storage/' . $help->photo) : asset('images/placeholder-help.svg') }}"
                                                        alt="{{ $help->title }}" class="w-full h-full object-cover">
                                                </div>
                                                <div class="flex-1 min-w-0">
                                                    <h4 class="font-bold text-sm text-gray-900 leading-tight line-clamp-2 mb-2">
                                                        {{ $help->title }}</h4>
                                                    <div class="flex items-center gap-2 mb-1.5">
                                                        <div
                                                            class="bg-blue-500 text-white text-xs font-bold px-2.5 py-1 rounded-lg">
                                                            Rp {{ number_format($help->amount, 0, ',', '.') }}
                                                        </div>
                                                    </div>
                                                    <div class="flex items-center gap-1.5 text-xs text-gray-600">
                                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                                        </svg>
                                                        {{ optional($help->category)->name ?? 'Kategori' }}
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="border-t pt-3 mt-3">
                                                <div class="flex items-center justify-between">
                                                    <div class="flex items-center gap-2">
                                                        <div class="w-8 h-8 rounded-full bg-gray-200 overflow-hidden">
                                                            <img src="{{ optional($help->mitra)->selfie_photo ? asset('storage/' . optional($help->mitra)->selfie_photo) : asset('images/avatar-placeholder.svg') }}"
                                                                alt="Mitra" class="w-full h-full object-cover">
                                                        </div>
                                                        <div>
                                                            <p class="text-xs font-semibold text-gray-900">
                                                                {{ optional($help->mitra)->name ?? 'Nama Mitra' }}</p>
                                                            <div class="flex items-center gap-1">
                                                                <svg class="w-3 h-3 text-yellow-400" fill="currentColor"
                                                                    viewBox="0 0 20 20">
                                                                    <path
                                                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                                </svg>
                                                                <span
                                                                    class="text-[10px] font-medium text-gray-600">{{ number_format(optional($help->mitra)->rating ?? optional($help->mitra)->ratings()->avg('rating') ?? 0, 1) }}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="flex gap-1.5">
                                                        <!-- chat -->

                                                        <a href="{{ route('customer.chat', ['help' => $help->id]) }}" class="p-2.5 bg-primary-500 text-white rounded-lg hover:bg-primary-600 flex items-center justify-center" title="Buka Chat">
                                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                    d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                                            </svg>
                                                        </a>
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="bg-white rounded-xl p-6 text-center shadow-md">
                                            <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                                            </svg>
                                            <p class="text-sm font-medium text-gray-500">Tidak ada permintaan yang diproses</p>
                                        </div>
                                    @endforelse
                                </div>

                                {{-- Selesai --}}
                                <div
                                    class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-2xl p-4 shadow-md border border-green-100">
                                    <div class="flex items-center justify-between mb-4">
                                        <div class="flex items-center gap-2">
                                            <div
                                                class="w-10 h-10 bg-green-500 rounded-xl flex items-center justify-center shadow-lg">
                                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                            </div>
                                            <div>
                                                <h3 class="text-base font-bold text-gray-900">Selesai</h3>
                                                <p class="text-xs text-gray-600">{{ $finished->count() }} telah diselesaikan
                                                </p>
                                            </div>
                                        </div>
                                        <div class="bg-green-500 text-white text-xs font-bold px-3 py-1.5 rounded-full">
                                            Done
                                        </div>
                                    </div>

                                    @forelse($finished as $help)
                                        <div
                                            class="bg-white rounded-xl p-4 mb-3 last:mb-0 shadow-lg hover:shadow-xl transition-shadow duration-200 border border-gray-100">
                                            <div class="flex gap-3">
                                                <div
                                                    class="w-20 h-20 rounded-xl overflow-hidden flex-shrink-0 shadow-md relative">
                                                    <img src="{{ $help->photo ? asset('storage/' . $help->photo) : asset('images/placeholder-help.svg') }}"
                                                        alt="{{ $help->title }}" class="w-full h-full object-cover">
                                                    <div class="absolute top-1 right-1 bg-green-500 rounded-full p-1">
                                                        <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="3" d="M5 13l4 4L19 7" />
                                                        </svg>
                                                    </div>
                                                </div>
                                                <div class="flex-1 min-w-0">
                                                    <h4 class="font-bold text-sm text-gray-900 leading-tight line-clamp-2 mb-2">
                                                        {{ $help->title }}</h4>
                                                    <div class="flex items-center gap-2 mb-2">
                                                        <div
                                                            class="bg-green-500 text-white text-xs font-bold px-2.5 py-1 rounded-lg">
                                                            Rp {{ number_format($help->amount, 0, ',', '.') }}
                                                        </div>
                                                    </div>
                                                    <div class="flex items-center gap-1.5 mb-2">
                                                        <svg class="w-3.5 h-3.5 text-green-600" fill="none"
                                                            stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                                        </svg>
                                                        <span
                                                            class="text-xs font-medium text-gray-700">{{ optional($help->category)->name ?? 'Kategori' }}</span>
                                                    </div>

                                                    @if($help->rating)
                                                        <div class="flex items-center gap-1 bg-amber-50 px-2 py-1 rounded-lg w-fit">
                                                            @for($i = 1; $i <= 5; $i++)
                                                                <svg class="w-3 h-3 {{ $i <= ($help->rating->rating ?? 0) ? 'text-yellow-400' : 'text-gray-300' }}"
                                                                    fill="currentColor" viewBox="0 0 20 20">
                                                                    <path
                                                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                                </svg>
                                                            @endfor
                                                            <span
                                                                class="text-xs font-bold text-gray-700 ml-1">{{ $help->rating->rating ?? 0 }}</span>
                                                        </div>
                                                    @else
                                                        <div
                                                            class="text-[10px] text-amber-600 font-medium bg-amber-50 px-2 py-1 rounded-md w-fit">
                                                            ⭐ Belum dirating
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="bg-white rounded-xl p-6 text-center shadow-md">
                                            <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            <p class="text-sm font-medium text-gray-500">Belum ada permintaan selesai</p>
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Pagination -->
                    @if ($helps->hasPages())
                        <div class="mt-8 pb-4">
                            {{ $helps->links() }}
                        </div>
                    @endif
                </div>

                <!-- Bottom Navigation -->
                <div class="fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 shadow-2xl z-50">
                    <div class="max-w-md mx-auto flex items-center justify-around px-4 py-2.5">
                        <a href="{{ route('admin.dashboard') }}"
                            class="flex flex-col items-center py-1.5 text-gray-400 hover:text-primary-600 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>
                        </a>
                        <a href="{{ route('admin.helps') }}" class="flex flex-col items-center py-1.5 relative">
                            <div class="absolute -top-5 bg-primary-500 rounded-full p-3 shadow-xl">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                            </div>
                        </a>
                        <a href="#"
                            class="flex flex-col items-center py-1.5 text-gray-400 hover:text-primary-600 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                            </svg>
                        </a>
                        <a href="#"
                            class="flex flex-col items-center py-1.5 text-gray-400 hover:text-primary-600 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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

                .line-clamp-1 {
                    display: -webkit-box;
                    -webkit-line-clamp: 1;
                    -webkit-box-orient: vertical;
                    overflow: hidden;
                }

                .line-clamp-2 {
                    display: -webkit-box;
                    -webkit-line-clamp: 2;
                    -webkit-box-orient: vertical;
                    overflow: hidden;
                }
            </style>
            <!-- Edit Modal -->
            @if($editingHelp)
                <div id="help-edit-modal" role="dialog" aria-modal="true"
                    class="fixed inset-0 z-[99999] flex items-center justify-center px-4">
                    <div wire:click="closeEdit" class="absolute inset-0 bg-black/60 backdrop-blur-sm transition-opacity">
                    </div>

                    <!-- Mobile-sized card: limit width and height so it doesn't fill the whole screen -->
                    <div class="relative w-full max-w-md mx-auto" style="max-height:86vh;">
                        <form wire:submit.prevent="saveEdit"
                            class="bg-white rounded-2xl overflow-hidden shadow-2xl p-5 sm:p-6"
                            style="max-height:86vh; overflow:auto;">
                            <div class="flex items-start justify-between mb-4">
                                <h3 class="text-lg font-semibold">Edit Permintaan Bantuan</h3>
                                <button type="button" wire:click="closeEdit" class="modal-close-btn">
                                    <svg class="w-4 h-4 text-gray-700" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>

                            <div class="grid grid-cols-1 gap-3">
                                <div>
                                    <label class="text-xs font-semibold text-gray-600">Judul</label>
                                    <input type="text" wire:model.defer="editTitle"
                                        class="mt-1 block w-full rounded border-gray-200 shadow-sm" />
                                    @error('editTitle') <div class="text-red-600 text-xs mt-1">{{ $message }}
                                    </div> @enderror
                                </div>

                                <div>
                                    <label class="text-xs font-semibold text-gray-600">Deskripsi</label>
                                    <textarea wire:model.defer="editDescription" rows="3"
                                        class="mt-1 block w-full rounded border-gray-200 shadow-sm"></textarea>
                                    @error('editDescription') <div class="text-red-600 text-xs mt-1">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="sm:flex sm:items-center sm:gap-3">
                                    <div class="sm:flex-1">
                                        <label class="text-xs font-semibold text-gray-600">Nominal (Rp)</label>
                                        <input type="number" wire:model.defer="editAmount"
                                            class="mt-1 block w-full rounded border-gray-200 shadow-sm" />
                                        @error('editAmount') <div class="text-red-600 text-xs mt-1">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="sm:w-60">
                                        <label class="text-xs font-semibold text-gray-600">Kota</label>
                                        <select wire:model.defer="editCityId"
                                            class="mt-1 block w-full rounded border-gray-200 shadow-sm">
                                            <option value="">Pilih Kota</option>
                                            @foreach($cities as $city)
                                                <option value="{{ $city->id }}">{{ $city->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('editCityId') <div class="text-red-600 text-xs mt-1">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <div>
                                    <label class="text-xs font-semibold text-gray-600">Alamat</label>
                                    <input type="text" wire:model.defer="editLocation"
                                        class="mt-1 block w-full rounded border-gray-200 shadow-sm" />
                                    @error('editLocation') <div class="text-red-600 text-xs mt-1">{{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="flex gap-2 mt-4">
                                <button type="submit"
                                    class="flex-1 py-2 bg-primary-500 text-white rounded-lg">Simpan</button>
                                <button type="button" wire:click="closeEdit"
                                    class="flex-1 py-2 bg-gray-100 rounded-lg">Batal</button>
                            </div>
                        </form>
                    </div>
                </div>
                <style>
                    .modal-close-btn {
                        display: inline-flex;
                        align-items: center;
                        justify-content: center;
                        width: 36px;
                        height: 36px;
                        border-radius: 9999px;
                        background: #ffffff;
                        border: 1px solid rgba(15, 23, 42, 0.06);
                        box-shadow: 0 6px 18px rgba(2, 6, 23, 0.08);
                        cursor: pointer
                    }

                    .modal-close-btn:hover {
                        transform: translateY(-1px);
                        background: #f8fafc
                    }
                </style>
            @endif

            <!-- Completion Confirmation Modal -->
            @if($showConfirmModal)
                <div id="help-complete-confirm-modal" role="dialog" aria-modal="true"
                    class="fixed inset-0 z-[99999] flex items-center justify-center px-4">
                    <div wire:click="\$set('showConfirmModal', false)" class="absolute inset-0 bg-black/60 backdrop-blur-sm transition-opacity">
                    </div>

                    <div class="relative w-full max-w-md mx-auto bg-white rounded-2xl overflow-hidden shadow-2xl p-5 sm:p-6">
                        <div class="flex items-start justify-between mb-4">
                            <h3 class="text-lg font-semibold">Konfirmasi Penyelesaian</h3>
                            <button type="button" wire:click="$set('showConfirmModal', false)" class="modal-close-btn">
                                <svg class="w-4 h-4 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>

                        <p class="text-sm text-gray-700">Apakah Anda yakin pekerjaan ini sudah selesai? Setelah dikonfirmasi, status akan berubah menjadi <strong>selesai</strong> dan mitra akan menerima pembayaran.</p>

                        <div class="flex gap-2 mt-4">
                            <button type="button" wire:click="$set('showConfirmModal', false)" class="flex-1 py-2 bg-gray-100 rounded-lg">Batal</button>
                            <button type="button" wire:click="completeConfirmed" class="flex-1 py-2 bg-green-500 text-white rounded-lg">Konfirmasi</button>
                        </div>
                    </div>
                </div>
            @endif

            @if($helps->isEmpty())
                <script>
                    document.body.style.overflow = 'hidden';
                    document.documentElement.style.overflow = 'hidden';
                </script>
            @endif
        </div>
    </div>