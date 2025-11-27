<!-- Mitra Help Detail Page (grouped) -->
<!-- Migrated content from resources/views/livewire/mitra/help-detail.blade.php -->
<div class="min-h-screen bg-gray-50">
    <!-- Header Section -->
    <div class="px-5 pt-6 pb-4 bg-gradient-to-br from-primary-400 via-primary-500 to-primary-600 rounded-b-3xl">
        <div class="flex items-center justify-between mb-6">
            <a href="{{ route('mitra.dashboard') }}"
                class="bg-white p-2.5 rounded-full shadow-md hover:shadow-lg transition">
                <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
            <h1 class="text-xl font-bold text-white flex-1 text-center">Detail Bantuan</h1>
            <div class="w-9"></div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="px-5 pt-6 pb-24">
        <!-- Help Card -->
        <div id="helpCard" class="bg-white rounded-2xl shadow-lg p-6 mb-6">
            <!-- Status Badge -->
            <div class="flex items-center justify-between mb-4">
                <span class="text-sm font-semibold text-gray-600">
                    @if($help->status === 'menunggu_mitra')
                        <span class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-xs font-bold">Menunggu
                            Mitra</span>
                    @elseif($help->status === 'memperoleh_mitra')
                        <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-xs font-bold">Sedang
                            Diproses</span>
                    @else
                        <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-xs font-bold">Selesai</span>
                    @endif
                </span>
                <span class="text-xs text-gray-500">{{ $help->created_at->format('d M Y H:i') }}</span>
            </div>

            <!-- Help Title -->
            <h2 class="text-lg font-bold text-gray-900 mb-2">{{ $help->title }}</h2>

            <!-- Amount Badge -->
            <div class="inline-block bg-green-100 text-green-700 px-3 py-1.5 rounded-lg font-bold text-sm mb-4">
                💰 Rp {{ number_format($help->amount, 0, ',', '.') }}
            </div>

            <!-- Description -->
            <div class="bg-gray-50 rounded-xl p-4 mb-4">
                <p class="text-sm text-gray-700 leading-relaxed">{{ $help->description }}</p>
            </div>

            <!-- Details Grid: only fields that belong to the `helps` table -->
            <div class="grid grid-cols-2 gap-3 mb-6">
                <!-- City (city_id exists on helps) -->
                <div class="bg-purple-50 rounded-xl p-3">
                    <p class="text-xs text-gray-600 font-semibold mb-1">Kota</p>
                    <p class="text-sm font-bold text-gray-900">{{ optional($help->city)->name ?? '-' }}</p>
                </div>

                <!-- Requester (user_id on helps) -->
                <div class="bg-indigo-50 rounded-xl p-3">
                    <p class="text-xs text-gray-600 font-semibold mb-1">Pemohon</p>
                    <p class="text-sm font-bold text-gray-900">{{ optional($help->user)->name ?? '-' }}</p>
                </div>

                <!-- Location (free-text on helps) -->
                <div class="bg-blue-50 rounded-xl p-3">
                    <p class="text-xs text-gray-600 font-semibold mb-1">Lokasi Terperinci</p>
                    <p class="text-sm font-bold text-gray-900">{{ $help->location ?? '-' }}</p>
                </div>

                <!-- Timestamps -->
                <div class="bg-gray-50 rounded-xl p-3">
                    <p class="text-xs text-gray-600 font-semibold mb-1">Waktu</p>
                    <p class="text-sm font-bold text-gray-900">
                        Dibuat: {{ optional($help->created_at)->format('d M Y H:i') ?? '-' }}
                        @if($help->taken_at)
                            <br>Taken: {{ optional($help->taken_at)->format('d M Y H:i') }}
                        @endif
                        @if($help->completed_at)
                            <br>Completed: {{ optional($help->completed_at)->format('d M Y H:i') }}
                        @endif
                    </p>
                </div>
            </div>

            <!-- Photos Section -->
            @if($help->photo)
                <div class="mb-6">
                    <p class="text-sm font-semibold text-gray-700 mb-2">Foto Bukti</p>
                    <img src="{{ asset('storage/' . $help->photo) }}" alt="Help photo"
                        class="w-full rounded-xl object-cover h-48">
                </div>
            @endif

            @if(optional($help->user)->phone || optional($help->user)->email)
                <!-- Requester Contact Section -->
                <div class="bg-gradient-to-br from-primary-50 to-blue-50 rounded-xl p-4 mb-6">
                    <p class="text-xs font-semibold text-gray-700 mb-3">Hubungi Pemohon Bantuan</p>
                    <div class="space-y-2">
                        @if(optional($help->user)->phone)
                            <a href="tel:{{ optional($help->user)->phone }}"
                                class="flex items-center space-x-3 bg-white rounded-lg p-3 hover:shadow-md transition">
                                <svg class="w-5 h-5 text-primary-500" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                </svg>
                                <div class="flex-1">
                                    <p class="text-xs text-gray-600">Telepon</p>
                                    <p class="text-sm font-semibold text-gray-900">{{ optional($help->user)->phone }}</p>
                                </div>
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </a>
                        @endif

                        @if(optional($help->user)->email)
                            <a href="mailto:{{ optional($help->user)->email }}"
                                class="flex items-center space-x-3 bg-white rounded-lg p-3 hover:shadow-md transition">
                                <svg class="w-5 h-5 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                                <div class="flex-1">
                                    <p class="text-xs text-gray-600">Email</p>
                                    <p class="text-sm font-semibold text-gray-900">{{ optional($help->user)->email }}</p>
                                </div>
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </a>
                        @endif
                    </div>
                </div>
            @endif

            <!-- Action Buttons -->
            <div class="flex gap-3">
                @if($help->status === 'menunggu_mitra')
                    <!-- Open confirmation modal instead of calling takeHelp directly -->
                    <button id="openConfirmTakeBtn" type="button"
                        class="flex-1 bg-primary-500 text-white px-4 py-3 rounded-xl font-bold text-sm hover:bg-primary-600 transition disabled:opacity-50">
                        Ambil Bantuan Ini
                    </button>
                    <button onclick="history.back()"
                        class="flex-1 bg-gray-100 text-gray-700 px-4 py-3 rounded-xl font-bold text-sm hover:bg-gray-200 transition">
                        Batal
                    </button>
                @elseif($help->status === 'memperoleh_mitra')
                    <a href="{{ route('chat.show', ['help' => $help->id]) }}"
                        class="flex-1 bg-primary-500 text-white px-4 py-3 rounded-xl font-bold text-sm hover:bg-primary-600 transition text-center">Chat</a>
                    <button onclick="history.back()"
                        class="flex-1 bg-gray-100 text-gray-700 px-4 py-3 rounded-xl font-bold text-sm hover:bg-gray-200 transition">
                        Kembali
                    </button>
                @else
                    <a href="{{ route('chat.show', ['help' => $help->id]) }}"
                        class="flex-1 bg-primary-500 text-white px-4 py-3 rounded-xl font-bold text-sm hover:bg-primary-600 transition text-center">Chat</a>
                    <button onclick="history.back()"
                        class="flex-1 bg-gray-100 text-gray-700 px-4 py-3 rounded-xl font-bold text-sm hover:bg-gray-200 transition">
                        Kembali
                    </button>
                @endif
            </div>

            <!-- Report links -->
            <div class="mt-3 flex gap-2">
                <a href="{{ auth()->user() && auth()->user()->role === 'mitra' ? route('mitra.reports.create.help', $help->id) : route('customer.reports.create.help', $help->id) }}"
                    class="flex-1 text-center bg-red-500 text-white px-3 py-2 rounded-lg hover:bg-red-600 transition text-sm font-semibold">
                    Laporkan Bantuan
                </a>

                @if(optional($help->user)->id)
                    <a href="{{ auth()->user() && auth()->user()->role === 'mitra' ? route('mitra.reports.create.user', optional($help->user)->id) : route('customer.reports.create.user', optional($help->user)->id) }}"
                        class="flex-1 text-center bg-red-100 text-red-700 px-3 py-2 rounded-lg hover:bg-red-200 transition text-sm font-semibold">
                        Laporkan Pengguna
                    </a>
                @endif
            </div>

            <!-- Confirmation Modal -->
            <div id="confirmTakeModal"
                class="fixed inset-0 z-[9999] flex items-center justify-center bg-black/40 hidden">
                <div class="bg-white rounded-xl w-11/12 max-w-md p-6">
                    <h3 class="text-lg font-bold mb-2">Konfirmasi</h3>
                    <p class="text-sm text-gray-700 mb-4">Apakah Anda yakin ingin mengambil bantuan ini?</p>
                    <div class="flex gap-3">
                        <button id="confirmTakeYes" wire:click="takeHelp" wire:loading.attr="disabled" type="button"
                            class="flex-1 bg-primary-500 text-white px-4 py-2 rounded-lg font-bold hover:bg-primary-600 transition">
                            Ya, Ambil
                        </button>
                        <button id="confirmTakeNo" type="button"
                            class="flex-1 bg-gray-100 text-gray-700 px-4 py-2 rounded-lg font-bold hover:bg-gray-200 transition">
                            Batal
                        </button>
                    </div>
                </div>
            </div>

            <!-- Success Modal -->
            <div id="successTakeModal"
                class="fixed inset-0 z-[10000] flex items-center justify-center bg-black/30 hidden">
                <div class="bg-white rounded-xl w-11/12 max-w-sm p-6 text-center">
                    <h3 class="text-lg font-bold mb-2">Berhasil</h3>
                    <p class="text-sm text-gray-700 mb-4">Bantuan berhasil diambil.</p>
                    <div class="mt-3">
                        <button id="successTakeClose" type="button"
                            class="bg-primary-500 text-white px-4 py-2 rounded-lg font-bold hover:bg-primary-600 transition">Tutup</button>
                    </div>
                </div>
            </div>

            <script>
                (function () {
                    const openBtn = document.getElementById('openConfirmTakeBtn');
                    const confirmModal = document.getElementById('confirmTakeModal');
                    const successModal = document.getElementById('successTakeModal');
                    const confirmNo = document.getElementById('confirmTakeNo');
                    const confirmYes = document.getElementById('confirmTakeYes');
                    const successClose = document.getElementById('successTakeClose');

                    function show(el) { el.classList.remove('hidden'); }
                    function hide(el) { el.classList.add('hidden'); }

                    if (openBtn) {
                        openBtn.addEventListener('click', function () {
                            show(confirmModal);
                        });
                    }

                    if (confirmNo) {
                        confirmNo.addEventListener('click', function () { hide(confirmModal); });
                    }

                    // On confirm: call Livewire method and close confirm modal
                    if (confirmYes) {
                        confirmYes.addEventListener('click', function () {
                            // Close the confirmation modal; Livewire's wire:click handles the server call.
                            hide(confirmModal);
                            // Immediately hide the help card to avoid intermediate UI state
                            const helpCard = document.getElementById('helpCard');
                            if (helpCard) helpCard.style.display = 'none';
                        });
                    }

                    // Listen for Livewire dispatched event (server sent)
                    window.addEventListener('help-taken', function () {
                        show(successModal);
                        // After a short delay, redirect to processing helps page
                        setTimeout(function () {
                            window.location.href = '{{ route('mitra.helps.processing') }}';
                        }, 1400);
                    });

                    // Also listen for Livewire client event if emitted via Livewire.on
                    if (window.livewire) {
                        try {
                            window.livewire.on('help-taken', function () {
                                show(successModal);
                                setTimeout(function () { window.location.href = '{{ route('mitra.helps.processing') }}'; }, 1400);
                            });
                        } catch (e) { /* ignore */ }
                    }

                    if (successClose) {
                        successClose.addEventListener('click', function () { hide(successModal); });
                    }
                })();
            </script>
        </div>
    </div>
</div>