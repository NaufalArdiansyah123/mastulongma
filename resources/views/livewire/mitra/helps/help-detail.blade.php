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

            @php
                // Check if current mitra has taken this help
                $isTakenByCurrentMitra = $help->mitra_id === auth()->id();
                $showFullDetails = $isTakenByCurrentMitra;
            @endphp

            @if($showFullDetails)
                <!-- FULL DETAILS - Only shown after mitra takes the help -->

                <!-- Description -->
                <div class="bg-gray-50 rounded-xl p-4 mb-4">
                    <p class="text-xs font-semibold text-gray-600 mb-2">📝 Deskripsi</p>
                    <p class="text-sm text-gray-700 leading-relaxed">{{ $help->description }}</p>
                </div>

                <!-- Peralatan yang Sudah Disediakan -->
                @if($help->equipment_provided)
                    <div class="bg-amber-50 border border-amber-200 rounded-xl p-4 mb-4">
                        <p class="text-xs font-semibold text-amber-800 mb-2">🛠️ Peralatan yang Sudah Disediakan</p>
                        <p class="text-sm text-amber-900 leading-relaxed">{{ $help->equipment_provided }}</p>
                    </div>
                @endif

                <!-- Alamat Lengkap (Manual) -->
                @if($help->full_address)
                    <div class="bg-blue-50 rounded-xl p-4 mb-4">
                        <p class="text-xs font-semibold text-blue-800 mb-2">📍 Alamat Lengkap</p>
                        <p class="text-sm text-blue-900 leading-relaxed">{{ $help->full_address }}</p>
                    </div>
                @endif

                <!-- Google Maps Location -->
                @if($help->latitude && $help->longitude)
                    <div class="mb-4">
                        <p class="text-xs font-semibold text-gray-700 mb-2">🗺️ Lokasi di Peta</p>
                        <div id="detailMap" class="w-full h-64 rounded-xl overflow-hidden border-2 border-gray-200 mb-2"></div>

                        <div class="bg-gray-50 border border-gray-200 rounded-lg p-3 mt-2">
                            <p class="text-xs font-semibold text-gray-700 mb-1">Koordinat:</p>
                            <p class="text-xs text-gray-600 font-mono">
                                Lat: {{ number_format($help->latitude, 6) }},
                                Lng: {{ number_format($help->longitude, 6) }}
                            </p>
                            <a href="https://www.google.com/maps?q={{ $help->latitude }},{{ $help->longitude }}" target="_blank"
                                class="inline-flex items-center gap-1 text-xs text-primary-600 hover:text-primary-700 font-semibold mt-2">
                                Buka di Peta
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                </svg>
                            </a>
                        </div>
                    </div>
                @endif

                <!-- Lokasi Tambahan (jika ada field location yang lama) -->
                @if($help->location)
                    <div class="bg-purple-50 rounded-xl p-3 mb-4">
                        <p class="text-xs text-gray-600 font-semibold mb-1">📌 Lokasi Singkat</p>
                        <p class="text-sm font-bold text-gray-900">{{ $help->location }}</p>
                    </div>
                @endif

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
                </div>

                <!-- Photos Section -->
                @if($help->photo)
                    <div class="mb-6">
                        <p class="text-sm font-semibold text-gray-700 mb-2">📷 Foto Bukti</p>
                        <img src="{{ asset('storage/' . $help->photo) }}" alt="Help photo"
                            class="w-full rounded-xl object-cover h-48">
                    </div>
                @endif

                @if(optional($help->user)->phone || optional($help->user)->email)
                    <!-- Requester Contact Section -->
                    <div class="bg-gradient-to-br from-primary-50 to-blue-50 rounded-xl p-4 mb-6">
                        <p class="text-xs font-semibold text-gray-700 mb-3">📞 Hubungi Pemohon Bantuan</p>
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
                                </a>
                            @endif
                        </div>
                    </div>
                @endif

            @else
                <!-- LIMITED INFO - Before taking the help -->

            @endif

            <!-- Rating Section for Completed Helps -->
            @if($showFullDetails && in_array($help->status, ['completed', 'selesai']))
                <div id="rating-section" class="mt-8 mb-8 pt-6 border-t-2 border-gray-300">
                    <h3 class="text-sm font-bold text-gray-900 mb-4">📊 Penilaian Customer</h3>
                    <p class="text-xs text-gray-500 mb-4">Bagaimana pengalaman Anda dengan customer ini?</p>
                    <livewire:mitra.rate-customer :helpId="$help->id" :key="'rate-customer-'.$help->id" />
                </div>
            @endif

            <!-- Action Buttons -->
            <div class="flex gap-3">
                @if($help->status === 'menunggu_mitra' && !$showFullDetails)
                    <!-- Open confirmation modal instead of calling takeHelp directly -->
                    <button id="openConfirmTakeBtn" type="button"
                        class="flex-1 bg-primary-500 text-white px-4 py-3 rounded-xl font-bold text-sm hover:bg-primary-600 transition disabled:opacity-50">
                        Ambil Bantuan Ini
                    </button>
                    <button onclick="history.back()"
                        class="flex-1 bg-gray-100 text-gray-700 px-4 py-3 rounded-xl font-bold text-sm hover:bg-gray-200 transition">
                        Batal
                    </button>
                @elseif($showFullDetails)
                    <a href="{{ route('chat.show', ['help' => $help->id]) }}"
                        class="flex-1 bg-primary-500 text-white px-4 py-3 rounded-xl font-bold text-sm hover:bg-primary-600 transition text-center">
                        Chat
                    </a>
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
                    <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-2 text-gray-900">Berhasil! 🎉</h3>
                    <p class="text-sm text-gray-700 mb-6">Bantuan berhasil diambil. Silakan lanjutkan ke halaman
                        pemrosesan bantuan.</p>
                    <div class="flex flex-col gap-3">
                        <a href="{{ route('mitra.helps.processing') }}"
                            class="w-full bg-primary-500 text-white px-4 py-3 rounded-xl font-bold hover:bg-primary-600 transition">
                            Lihat Bantuan yang Diproses
                        </a>
                        <button id="successTakeClose" type="button"
                            class="w-full bg-gray-100 text-gray-700 px-4 py-3 rounded-xl font-bold hover:bg-gray-200 transition">
                            Tetap di Halaman Ini
                        </button>
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
                        // Reload page to show full details after taking
                        setTimeout(function () {
                            location.reload();
                        }, 500);
                    });

                    // Also listen for Livewire client event if emitted via Livewire.on
                    if (window.livewire) {
                        try {
                            window.livewire.on('help-taken', function () {
                                show(successModal);
                                setTimeout(function () {
                                    location.reload();
                                }, 500);
                            });
                        } catch (e) { /* ignore */ }
                    }

                    if (successClose) {
                        successClose.addEventListener('click', function () {
                            hide(successModal);
                            location.reload(); // Reload to show full details
                        });
                    }
                })();
            </script>

            <!-- Leaflet CSS & JS for Detail View -->
            @if($showFullDetails && $help->latitude && $help->longitude)
                <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
                    integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />

                <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
                    integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

                <script>
                    document.addEventListener('DOMContentLoaded', function () {
                        const location = [{{ $help->latitude }}, {{ $help->longitude }}];

                        // Initialize map
                        const detailMap = L.map('detailMap').setView(location, 15);

                        // Add OpenStreetMap tiles
                        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                            attribution: '© <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
                            maxZoom: 19,
                        }).addTo(detailMap);

                        // Add marker
                        L.marker(location).addTo(detailMap)
                            .bindPopup('{{ addslashes($help->title) }}')
                            .openPopup();
                    });
                </script>
            @endif
        </div>
    </div>
</div>