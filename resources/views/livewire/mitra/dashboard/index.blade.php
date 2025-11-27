<!-- Mitra Dashboard — Enhanced UI with improved visual hierarchy -->
<div class="min-h-screen bg-white">
    <!-- Header Section with subtle gradient overlay -->
    <div
        class="px-5 pt-6 pb-5 bg-gradient-to-br from-primary-400 via-primary-500 to-primary-600 rounded-b-3xl relative overflow-hidden">
        <!-- Decorative background elements -->
        <div class="absolute inset-0 opacity-10">
            <div
                class="absolute top-0 right-0 w-64 h-64 bg-white rounded-full blur-3xl transform translate-x-1/2 -translate-y-1/2">
            </div>
            <div
                class="absolute bottom-0 left-0 w-48 h-48 bg-white rounded-full blur-3xl transform -translate-x-1/2 translate-y-1/2">
            </div>
        </div>

        <div class="relative z-10">
            <div class="flex items-center justify-between mb-5 gap-3">
                <div class="flex items-center gap-3">
                    @php
                        $__avatar = optional(auth()->user())->selfie_photo ?? optional(auth()->user())->photo ?? null;
                    @endphp
                    <div
                        class="w-14 h-14 rounded-2xl bg-white/20 backdrop-blur-sm flex items-center justify-center overflow-hidden ring-2 ring-white/30 shadow-lg flex-shrink-0">
                        <img src="{{ $__avatar ? asset('storage/' . $__avatar) : asset('images/avatar-placeholder.svg') }}"
                            alt="Avatar" class="w-full h-full object-cover">
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-white drop-shadow-sm">Halo, Mitra</h1>
                        <p class="text-sm text-white/90 mt-0.5 drop-shadow-sm">Selamat datang kembali — kelola pekerjaan
                            dan saldo Anda</p>
                    </div>
                </div>

                <div class="flex items-center gap-2">
                    <a href="{{ route('customer.notifications.index') }}" title="Notifications"
                        aria-label="Notifications"
                        class="bg-white/95 backdrop-blur-sm p-2.5 rounded-xl shadow-lg hover:shadow-xl hover:scale-105 transition-all duration-200">
                        <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                    </a>
                </div>
            </div>

            <!-- Balance & stats with improved cards -->
            <div class="mt-4 grid grid-cols-1 sm:grid-cols-3 gap-3">
                <div class="col-span-2 bg-white/15 backdrop-blur-md rounded-2xl p-4 shadow-lg border border-white/20">
                    <div class="flex items-center justify-between">
                        <div>
                            <div class="text-xs text-white/90 font-medium tracking-wide uppercase mb-1">Saldo Tersedia
                            </div>
                            <div class="text-xl font-bold text-white mt-1 drop-shadow-sm">Rp
                                {{ number_format($balance ?? 0, 0, ',', '.') }}
                            </div>
                        </div>
                        <div class="ml-4 flex-shrink-0">
                            <a href="{{ route('mitra.withdraw.form') }}"
                                class="inline-block bg-white/95 backdrop-blur-sm text-gray-800 font-semibold px-4 py-2.5 rounded-xl shadow-lg hover:shadow-xl hover:scale-105 transition-all duration-200">
                                Tarik Saldo
                            </a>
                        </div>
                    </div>

                    <div class="mt-2 h-1 bg-white/20 rounded-full overflow-hidden">
                        <div class="h-full bg-white/40 rounded-full" style="width: 65%"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Card with enhanced spacing -->
    <div class="bg-gray-50 rounded-t-3xl px-4 pt-6 pb-24 min-h-[60vh] -mt-2 relative z-20">
        <!-- Promo Banner with enhanced visual appeal -->
        <div class="mb-5">
            <div id="promo-banner" class="rounded-2xl overflow-hidden shadow-lg">
                <div id="promo-banner-slide"
                    class="h-36 rounded-2xl p-5 flex items-center justify-center text-white bg-gradient-to-br from-indigo-400 to-indigo-500 transition-all duration-500 relative overflow-hidden">
                    <!-- Decorative circles -->
                    <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full blur-2xl"></div>
                    <div class="absolute bottom-0 left-0 w-24 h-24 bg-white/10 rounded-full blur-2xl"></div>

                    <div class="text-center relative z-10">
                        <div id="promo-title" class="font-bold text-xl mb-1 drop-shadow-md">Promo Spesial</div>
                        <div id="promo-desc" class="text-sm opacity-90 drop-shadow-sm">Dapatkan bonus saldo dan insentif
                            khusus.</div>
                    </div>
                </div>
            </div>
            <div id="promo-dots" class="flex justify-center mt-3 gap-2">
                <button data-dot="0"
                    class="w-2.5 h-2.5 rounded-full bg-primary-600 transition-all duration-300 hover:scale-125"></button>
                <button data-dot="1"
                    class="w-2.5 h-2.5 rounded-full bg-gray-300 transition-all duration-300 hover:scale-125"></button>
                <button data-dot="2"
                    class="w-2.5 h-2.5 rounded-full bg-gray-300 transition-all duration-300 hover:scale-125"></button>
            </div>
        </div>



        <!-- Section Header with refined typography -->
        <div class="mb-4 px-2">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <h3 class="text-lg font-bold text-gray-900">Rekomendasi</h3>
                    <div class="w-1 h-1 rounded-full bg-primary-500"></div>
                    <span class="text-xs text-gray-500 font-medium">Pilihan Terbaik</span>
                </div>
            </div>
        </div>

        <style>
            .hide-scrollbar {
                -ms-overflow-style: none;
                scrollbar-width: none;
            }

            .hide-scrollbar::-webkit-scrollbar {
                display: none;
            }

            /* Card hover animation */
            .help-card {
                transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            }

            .help-card:hover {
                transform: translateY(-4px);
                box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            }
        </style>

        <!-- Horizontal cards container (Rekomendasi) -->
        <div class="overflow-x-auto -mx-4 px-4 hide-scrollbar">
            <div class="flex gap-4 snap-x snap-mandatory touch-pan-x pb-2">
                @forelse($recommendedHelps as $help)
                    @include('livewire.mitra._help_card', ['help' => $help])
                    @if($loop->iteration === 5)
                        <a href="{{ url('/mitra/helps') }}"
                            class="relative block shrink-0 w-48 sm:w-52 h-44 bg-gradient-to-br from-gray-50 to-white rounded-2xl border-2 border-dashed border-gray-200 shadow-md flex items-center justify-center snap-start hover:border-primary-300 hover:bg-primary-50/30 transition-all duration-300">
                            <div class="text-center px-4">
                                <div class="w-12 h-12 mx-auto mb-3 rounded-xl bg-primary-50 flex items-center justify-center">
                                    <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                    </svg>
                                </div>
                                <div class="text-sm font-bold text-gray-800 mb-1">Lihat Semua Bantuan</div>
                                <div class="text-xs text-gray-500">Tampilkan daftar lengkap dan filter</div>
                                <div class="mt-3">
                                    <span
                                        class="inline-block px-3 py-1.5 rounded-lg bg-primary-500 text-white text-xs font-semibold shadow-sm">
                                        Buka Halaman
                                    </span>
                                </div>
                            </div>
                        </a>
                        @break
                    @endif
                @empty
                    <div class="w-full text-center py-12">
                        <svg class="w-16 h-16 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        <p class="text-gray-500 text-sm">Belum ada bantuan untuk ditampilkan</p>
                    </div>
                @endforelse
            </div>
        </div>

        <div class="h-6"></div>

        <!-- Section Header - Terbaru -->
        <div class="mb-4 px-2">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <h3 class="text-lg font-bold text-gray-900">Terbaru</h3>
                    <div class="w-1 h-1 rounded-full bg-green-500"></div>
                    <span class="text-xs text-gray-500 font-medium">Update Hari Ini</span>
                </div>
            </div>
        </div>

        <!-- Horizontal cards container (Terbaru) -->
        <div class="overflow-x-auto -mx-4 px-4 hide-scrollbar">
            <div class="flex gap-4 snap-x snap-mandatory touch-pan-x pb-2">
                @forelse($latestHelps as $help)
                    @include('livewire.mitra._help_card', ['help' => $help])
                    @if($loop->iteration === 5)
                        <a href="{{ url('/mitra/helps') }}"
                            class="relative block shrink-0 w-48 sm:w-52 h-44 bg-gradient-to-br from-gray-50 to-white rounded-2xl border-2 border-dashed border-gray-200 shadow-md flex items-center justify-center snap-start hover:border-primary-300 hover:bg-primary-50/30 transition-all duration-300">
                            <div class="text-center px-4">
                                <div class="w-12 h-12 mx-auto mb-3 rounded-xl bg-primary-50 flex items-center justify-center">
                                    <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                    </svg>
                                </div>
                                <div class="text-sm font-bold text-gray-800 mb-1">Lihat Semua Bantuan</div>
                                <div class="text-xs text-gray-500">Tampilkan daftar lengkap dan filter</div>
                                <div class="mt-3">
                                    <span
                                        class="inline-block px-3 py-1.5 rounded-lg bg-primary-500 text-white text-xs font-semibold shadow-sm">
                                        Buka Halaman
                                    </span>
                                </div>
                            </div>
                        </a>
                        @break
                    @endif
                @empty
                    <div class="w-full text-center py-12">
                        <svg class="w-16 h-16 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        <p class="text-gray-500 text-sm">Belum ada bantuan untuk ditampilkan</p>
                    </div>
                @endforelse
            </div>
        </div>

        <div class="h-6"></div>

        <!-- Section Header - Terdekat -->
        <div class="mb-4 px-2">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <h3 class="text-lg font-bold text-gray-900">Terdekat</h3>
                    <div class="w-1 h-1 rounded-full bg-blue-500"></div>
                    <span class="text-xs text-gray-500 font-medium">Di Sekitar Anda</span>
                </div>
            </div>
        </div>

        <!-- Horizontal cards container (Terdekat) -->
        <div class="overflow-x-auto -mx-4 px-4 hide-scrollbar">
            <div class="flex gap-4 snap-x snap-mandatory touch-pan-x pb-2">
                @forelse($nearbyHelps as $help)
                    @include('livewire.mitra._help_card', ['help' => $help])
                    @if($loop->iteration === 5)
                        <a href="{{ url('/mitra/helps') }}"
                            class="relative block shrink-0 w-48 sm:w-52 h-44 bg-gradient-to-br from-gray-50 to-white rounded-2xl border-2 border-dashed border-gray-200 shadow-md flex items-center justify-center snap-start hover:border-primary-300 hover:bg-primary-50/30 transition-all duration-300">
                            <div class="text-center px-4">
                                <div class="w-12 h-12 mx-auto mb-3 rounded-xl bg-primary-50 flex items-center justify-center">
                                    <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                    </svg>
                                </div>
                                <div class="text-sm font-bold text-gray-800 mb-1">Lihat Semua Bantuan</div>
                                <div class="text-xs text-gray-500">Tampilkan daftar lengkap dan filter</div>
                                <div class="mt-3">
                                    <span
                                        class="inline-block px-3 py-1.5 rounded-lg bg-primary-500 text-white text-xs font-semibold shadow-sm">
                                        Buka Halaman
                                    </span>
                                </div>
                            </div>
                        </a>
                        @break
                    @endif
                @empty
                    <div class="w-full text-center py-12">
                        <svg class="w-16 h-16 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        <p class="text-gray-500 text-sm">Belum ada bantuan untuk ditampilkan</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<script>
    (function () {
        const banners = [
            { title: 'Promo Spesial', desc: 'Dapatkan diskon layanan untuk bantuan pertama Anda.', bg: 'from-indigo-400 to-indigo-500' },
            { title: 'Insentif Mitra', desc: 'Selesaikan lebih banyak bantuan, dapatkan insentif.', bg: 'from-green-400 to-green-500' },
            { title: 'Badge Aktif', desc: 'Selesaikan 5 bantuan dan dapatkan badge Mitra Aktif.', bg: 'from-yellow-400 to-yellow-500' }
        ];

        let idx = 0;
        const titleEl = document.getElementById('promo-title');
        const descEl = document.getElementById('promo-desc');
        const slideEl = document.getElementById('promo-banner-slide');
        const dotsContainer = document.getElementById('promo-dots');
        const dots = dotsContainer ? Array.from(dotsContainer.querySelectorAll('button')) : [];

        function show(i) {
            idx = i % banners.length;
            const b = banners[idx];
            if (titleEl) titleEl.textContent = b.title;
            if (descEl) descEl.textContent = b.desc;
            if (slideEl) {
                slideEl.className = 'h-36 rounded-2xl p-5 flex items-center justify-center text-white bg-gradient-to-br ' + b.bg + ' transition-all duration-500 relative overflow-hidden';
            }
            if (dots.length) {
                dots.forEach((d, k) => {
                    d.classList.toggle('bg-primary-600', k === idx);
                    d.classList.toggle('bg-gray-300', k !== idx);
                    d.classList.toggle('scale-125', k === idx);
                });
            }
        }

        if (slideEl) {
            show(0);
            let timer = setInterval(() => show((idx + 1) % banners.length), 4000);
            if (dotsContainer) {
                dotsContainer.addEventListener('click', function (e) {
                    const dot = e.target.closest('button[data-dot]');
                    if (!dot) return;
                    const i = parseInt(dot.dataset.dot);
                    show(i);
                    clearInterval(timer);
                    timer = setInterval(() => show((idx + 1) % banners.length), 4000);
                });
            }
        }
    })();
</script>