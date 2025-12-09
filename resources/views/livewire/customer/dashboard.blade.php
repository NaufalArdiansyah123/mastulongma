<div class="min-h-screen bg-gradient-to-b from-gray-50 to-white">
    <style>
        @keyframes modalIn {
            from {
                opacity: 0;
                transform: translateY(8px) scale(.98);
            }

            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        @keyframes pulse {

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.05);
            }
        }

        .modal-enter {
            animation: modalIn 180ms ease-out forwards;
        }

        .slide-up {
            animation: slideUp 0.5s ease-out forwards;
        }

        .fade-in {
            animation: fadeIn 0.6s ease-out forwards;
        }

        .hover-lift {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .hover-lift:hover {
            transform: translateY(-4px);
        }

        .card-shadow {
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
        }

        .card-shadow-hover {
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.08), 0 4px 6px -2px rgba(0, 0, 0, 0.04);
        }
    </style>

    <!-- Header Section (adapted from Mitra dashboard) -->
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
                        $__avatar = optional(auth()->user())->selfie_photo ?? optional(auth()->user())->photo ?? optional(auth()->user())->profile_photo_path ?? null;
                    @endphp
                    <div
                        class="w-14 h-14 rounded-2xl bg-white/20 backdrop-blur-sm flex items-center justify-center overflow-hidden ring-2 ring-white/30 shadow-lg flex-shrink-0">
                        <img src="{{ $__avatar ? asset('storage/' . $__avatar) : asset('images/avatar-placeholder.svg') }}"
                            alt="Avatar" class="w-full h-full object-cover">
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-white drop-shadow-sm">Halo,
                            {{ optional(auth()->user())->name ?? 'Pengguna' }}
                        </h1>
                        <p class="text-sm text-white/90 mt-0.5 drop-shadow-sm">Selamat datang kembali — jelajahi bantuan
                            dan tambah saldo</p>
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

            <!-- Balance & actions card -->
            <div class="mt-4 grid grid-cols-1 sm:grid-cols-3 gap-3">
                <div class="col-span-2 bg-white/15 backdrop-blur-md rounded-2xl p-4 shadow-lg border border-white/20">
                    <div class="flex items-center justify-between">
                        <div>
                            <div class="text-xs text-white/90 font-medium tracking-wide uppercase mb-1">Saldo Anda
                            </div>
                            <div class="text-xl font-bold text-white mt-1 drop-shadow-sm">Rp
                                {{ number_format($balance ?? 0, 0, ',', '.') }}
                            </div>
                        </div>
                        <div class="ml-4 flex-shrink-0">
                            <a href="{{ route('customer.topup.request') }}"
                                class="bg-white/95 backdrop-blur-sm text-gray-800 font-semibold px-4 py-2.5 rounded-xl shadow-lg hover:shadow-xl hover:scale-105 transition-all duration-200">
                                Tambah Saldo
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

    <!-- Main Content Card -->
    <div
        class="bg-gradient-to-b from-gray-50 to-white rounded-t-[32px] px-5 pt-8 pb-24 min-h-[60vh] -mt-4 relative z-10">
        <!-- Promo Banner (sliding carousel) or custom banner if uploaded -->
        @php
            $customerBanners = json_decode((string) \App\Models\AppSetting::get('banner_customer', '[]'), true) ?: [];
        @endphp
        <div class="mb-6 slide-up">
            @if(!empty($customerBanners) && count($customerBanners))
                <div class="rounded-3xl overflow-hidden shadow-lg hover:shadow-xl transition-shadow duration-300">
                    <div class="relative h-36 rounded-3xl overflow-hidden bg-gray-100">
                        <div class="w-full h-full">
                            <div class="flex h-full will-change-transform customer-banner-slides"
                                style="transition: transform 700ms cubic-bezier(.2,.9,.2,1);">
                                @foreach($customerBanners as $b)
                                    <div class="flex-shrink-0 w-full h-full">
                                        <img src="{{ asset('storage/' . $b) }}" alt="Banner Customer"
                                            class="w-full h-full object-cover" />
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div id="promo-banner"
                    class="rounded-3xl overflow-hidden shadow-lg hover:shadow-xl transition-shadow duration-300">
                    <div class="relative h-36 rounded-3xl overflow-hidden">
                        <div id="promo-track" class="flex h-full transition-transform duration-700 ease-in-out"></div>
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
            @endif
        </div>

        <!-- Quick Actions -->
        <div class="mb-8 fade-in">
            <h2 class="text-base font-bold text-gray-900 mb-4 px-1">Quick Actions</h2>
            <div class="grid grid-cols-2 sm:grid-cols-4 md:grid-cols-6 lg:grid-cols-8 gap-3">
                <a href="{{ route('customer.helps.create') }}" role="button" aria-label="Buat Bantuan"
                    class="relative flex flex-col items-center text-center bg-white p-3 sm:p-4 rounded-2xl shadow-sm hover:shadow-md transition-transform duration-200 transform hover:-translate-y-1 focus:outline-none focus:ring-2 focus:ring-primary-400">
                    <div
                        class="w-14 h-14 rounded-2xl flex items-center justify-center mb-2 bg-gradient-to-br from-primary-500 to-primary-400 text-white shadow-md">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                    </div>
                    <div class="text-sm font-semibold text-gray-800">Buat</div>
                    <div class="text-xs text-gray-500 mt-1 hidden sm:block">Ajukan permintaan bantuan</div>
                </a>

                <a href="{{ route('customer.helps.index') }}" role="button" aria-label="Lihat Bantuan"
                    class="relative flex flex-col items-center text-center bg-white p-3 sm:p-4 rounded-2xl shadow-sm hover:shadow-md transition-transform duration-200 transform hover:-translate-y-1 focus:outline-none focus:ring-2 focus:ring-primary-400">
                    <div
                        class="w-14 h-14 rounded-2xl flex items-center justify-center mb-2 bg-gradient-to-br from-indigo-400 to-indigo-500 text-white shadow-md">
                        <svg class="w-6 h-6" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M3 3h14v2H3V3zm0 4h14v10H3V7z" />
                        </svg>
                    </div>
                    <div class="text-sm font-semibold text-gray-800">Lihat Bantuan</div>
                    <div class="text-xs text-gray-500 mt-1 hidden sm:block">Semua permintaan bantuan</div>
                </a>

                {{-- <a href="{{ route('customer.helps.history') }}" 
                   role="button" 
                   aria-label="Riwayat Bantuan"
                    class="relative flex flex-col items-center text-center bg-white p-3 sm:p-4 rounded-2xl shadow-sm hover:shadow-md transition-transform duration-200 transform hover:-translate-y-1 focus:outline-none focus:ring-2 focus:ring-primary-400">
                    <div
                        class="w-14 h-14 rounded-2xl flex items-center justify-center mb-2 bg-gradient-to-br from-emerald-400 to-emerald-500 text-white shadow-md">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="text-sm font-semibold text-gray-800">Riwayat</div>
                    <div class="text-xs text-gray-500 mt-1 hidden sm:block">Bantuan selesai</div>
                </a> --}}

                <a href="{{ route('customer.transactions.index') }}" role="button" aria-label="Transaksi"
                    class="relative flex flex-col items-center text-center bg-white p-3 sm:p-4 rounded-2xl shadow-sm hover:shadow-md transition-transform duration-200 transform hover:-translate-y-1 focus:outline-none focus:ring-2 focus:ring-primary-400">
                    <div
                        class="w-14 h-14 rounded-2xl flex items-center justify-center mb-2 bg-gradient-to-br from-green-400 to-teal-400 text-white shadow-md">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 10h18M7 6h10M7 14h10M7 18h10" />
                        </svg>
                    </div>
                    <div class="text-sm font-semibold text-gray-800">Transaksi</div>
                    <div class="text-xs text-gray-500 mt-1 hidden sm:block">Riwayat pembayaran</div>
                </a>

                <a href="{{ route('profile') }}" role="button" aria-label="Profil Saya"
                    class="relative flex flex-col items-center text-center bg-white p-3 sm:p-4 rounded-2xl shadow-sm hover:shadow-md transition-transform duration-200 transform hover:-translate-y-1 focus:outline-none focus:ring-2 focus:ring-primary-400">
                    <div
                        class="w-14 h-14 rounded-2xl flex items-center justify-center mb-2 bg-gradient-to-br from-yellow-400 to-orange-400 text-white shadow-md">
                        <svg class="w-6 h-6" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M10 2a4 4 0 110 8 4 4 0 010-8zm0 10c-4 0-8 2-8 4v2h16v-2c0-2-4-4-8-4z" />
                        </svg>
                    </div>
                    <div class="text-sm font-semibold text-gray-800">Profil</div>
                    <div class="text-xs text-gray-500 mt-1 hidden sm:block">Lihat dan sunting profil</div>
                </a>
            </div>
        </div>

        <!-- People Who Need Help List -->
        @if($activeTab !== 'history')
            <div>
                <h2 class="text-base font-bold text-gray-900 mb-4 px-1">Bantuan Saya</h2>
                <div class="space-y-4">
                    @forelse($availableHelps as $help)
                        <div
                            class="bg-white rounded-3xl p-5 card-shadow hover:card-shadow-hover transition-all duration-300 hover-lift group">
                            <div class="flex items-start gap-4">
                                <div wire:click="showHelp({{ $help->id }})" style="cursor:pointer" class="flex-shrink-0">
                                    <div
                                        class="w-16 h-16 rounded-2xl bg-gradient-to-br from-primary-100 to-primary-200 overflow-hidden flex items-center justify-center shadow-md group-hover:scale-110 transition-transform duration-300">
                                        @if($help->photo)
                                            <img src="{{ asset('storage/' . $help->photo) }}" alt="Foto bantuan"
                                                class="w-full h-full object-cover" loading="lazy">
                                        @else
                                            <span class="text-3xl">💰</span>
                                        @endif
                                    </div>
                                </div>
                                
                                <div class="flex-1 min-w-0" wire:click="showHelp({{ $help->id }})" style="cursor:pointer">
                                    <div class="font-bold text-gray-900 text-base mb-1 truncate">{{ $help->user->name }}</div>
                                    <div class="text-sm text-gray-600 mb-2 line-clamp-2 font-medium leading-relaxed">{{ $help->title }}</div>
                                    <div class="flex items-center gap-2 flex-wrap">
                                        <span
                                            class="text-xs px-3 py-1 rounded-full bg-green-100 text-green-700 font-bold shadow-sm whitespace-nowrap">
                                            Rp {{ number_format($help->amount, 0, ',', '.') }}
                                        </span>
                                        <span class="text-xs text-gray-500 font-medium truncate">📍 {{ $help->city->name }}</span>
                                    </div>
                                </div>
                                
                                <div class="text-right flex-shrink-0">
                                    <div class="text-xs text-gray-500 mb-2 font-medium whitespace-nowrap">{{ $help->created_at->diffForHumans() }}
                                    </div>
                                    @if(auth()->user()->isMitra())
                                        <a href="{{ route('helps.available') }}"
                                            class="inline-flex items-center text-xs font-bold text-primary-600 hover:text-primary-700 hover:underline transition-all whitespace-nowrap">
                                            Lihat →
                                        </a>
                                    @else
                                        <span class="text-xs text-gray-400 font-medium whitespace-nowrap">Butuh Bantuan</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-12 bg-white rounded-3xl card-shadow">
                            <svg class="w-20 h-20 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                            <p class="text-gray-500 font-semibold">Belum ada bantuan yang Anda posting</p>
                            <p class="text-gray-400 text-sm mt-1">Klik "Buat Bantuan" untuk memulai</p>
                        </div>
                    @endforelse
                    @if(method_exists($availableHelps, 'links'))
                        <div class="mt-4">
                            {{ $availableHelps->links() }}
                        </div>
                    @endif
                </div>
            </div>
        @endif

        <!-- Transaction History Component -->
        @if($activeTab === 'history')
            @livewire('customer.balance-transaction-history')
        @endif

        <!-- Help Detail Modal -->
        @if($selectedHelpData)
            <div class="fixed inset-0 z-[9999] flex items-center justify-center p-4">
                <div class="absolute inset-0 bg-black/60 backdrop-blur-md" wire:click="closeHelp"></div>
                <div class="relative bg-white rounded-3xl w-full max-w-md p-6 shadow-2xl modal-enter">
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex-1 pr-4">
                            <h3 class="font-extrabold text-xl text-gray-900 mb-1 leading-tight">
                                {{ data_get($selectedHelpData, 'title') }}
                            </h3>
                            <p class="text-sm text-gray-600 font-medium">
                                {{ data_get($selectedHelpData, 'user_name') }}
                                @if(data_get($selectedHelpData, 'city_name'))
                                    • {{ data_get($selectedHelpData, 'city_name') }}
                                @endif
                            </p>
                        </div>
                        <button wire:click="closeHelp"
                            class="text-gray-400 hover:text-gray-700 hover:bg-gray-100 p-2 rounded-xl transition-all duration-200">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    @if(data_get($selectedHelpData, 'photo'))
                        <div class="mb-5">
                            <img src="{{ asset('storage/' . data_get($selectedHelpData, 'photo')) }}" alt="Foto bantuan"
                                class="w-full h-64 object-cover rounded-2xl shadow-md" loading="lazy">
                        </div>
                    @endif

                    <div class="text-sm text-gray-700 mb-5 space-y-3">
                        <p class="leading-relaxed">{{ data_get($selectedHelpData, 'description') }}</p>
                        <div class="bg-green-50 border-2 border-green-200 rounded-2xl p-4">
                            <p class="font-extrabold text-green-800 text-lg">
                                Rp {{ number_format(data_get($selectedHelpData, 'amount', 0), 0, ',', '.') }}
                            </p>
                        </div>
                        @if(data_get($selectedHelpData, 'location'))
                            <div class="flex items-start gap-2 text-gray-600">
                                <svg class="w-5 h-5 text-gray-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z"
                                        clip-rule="evenodd" />
                                </svg>
                                <span class="font-medium">{{ data_get($selectedHelpData, 'location') }}</span>
                            </div>
                        @endif
                        <p class="text-xs text-gray-500 font-medium">
                            📅 Dibuat {{ data_get($selectedHelpData, 'created_at_human') }}
                        </p>
                    </div>

                    <div class="flex gap-3">
                        <button wire:click="closeHelp"
                            class="flex-1 px-5 py-3 bg-gray-100 hover:bg-gray-200 rounded-2xl text-sm font-bold text-gray-800 transition-all duration-200 hover:scale-105">
                            Tutup
                        </button>
                        @if(auth()->user()->isMitra())
                            <a href="{{ route('mitra.helps.all') }}"
                                class="flex-1 px-5 py-3 bg-primary-500 hover:bg-primary-600 text-white rounded-2xl text-sm font-bold text-center transition-all duration-200 hover:scale-105 shadow-lg hover:shadow-xl">
                                Lihat Daftar
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

@if(empty($customerBanners) || !count($customerBanners))
    <script>
        (function () {
            const banners = [
                { title: 'Promo Spesial', desc: 'Dapatkan diskon layanan untuk bantuan pertama Anda.', bgCss: 'linear-gradient(135deg,#6366f1,#4f46e5)' },
                { title: 'Gratis Ongkir', desc: 'Pengiriman gratis untuk bantuan di kota yang sama.', bgCss: 'linear-gradient(135deg,#10b981,#059669)' },
                { title: 'Dapatkan Badge', desc: 'Selesaikan 5 bantuan dan dapatkan badge Mitra Aktif.', bgCss: 'linear-gradient(135deg,#f59e0b,#f97316)' }
            ];

            const track = document.getElementById('promo-track');
            const dotsContainer = document.getElementById('promo-dots');
            const dots = dotsContainer ? Array.from(dotsContainer.querySelectorAll('button')) : [];
            let idx = 0;
            let timer = null;

            // build slides (create DOM nodes and use inline background to avoid Tailwind purge issues)
            if (track) {
                track.innerHTML = '';
                const frag = document.createDocumentFragment();
                banners.forEach(b => {
                    const slide = document.createElement('div');
                    slide.className = 'w-full flex-shrink-0 p-6 flex items-center justify-center text-white';
                    slide.style.background = b.bgCss;
                    const inner = document.createElement('div');
                    inner.className = 'text-center';
                    const title = document.createElement('div');
                    title.className = 'font-extrabold text-xl mb-1 tracking-tight';
                    title.textContent = b.title;
                    const desc = document.createElement('div');
                    desc.className = 'text-sm opacity-90 font-medium';
                    desc.textContent = b.desc;
                    inner.appendChild(title);
                    inner.appendChild(desc);
                    slide.appendChild(inner);
                    frag.appendChild(slide);
                });
                track.appendChild(frag);
            }

            function update() {
                if (track) {
                    const percent = (idx * 100) / banners.length;
                    track.style.transform = `translateX(${-percent}%)`;
                }
                if (dots.length) {
                    dots.forEach((d, k) => {
                        d.classList.toggle('bg-primary-600', k === idx);
                        d.classList.toggle('bg-gray-300', k !== idx);
                    });
                }
            }

            function go(i) {
                idx = (i + banners.length) % banners.length;
                update();
            }

            function resetTimer() {
                if (timer) clearInterval(timer);
                timer = setInterval(() => go(idx + 1), 4200);
            }

            // dot clicks
            if (dotsContainer) {
                dotsContainer.addEventListener('click', function (e) {
                    const dot = e.target.closest('button[data-dot]');
                    if (!dot) return;
                    const i = parseInt(dot.dataset.dot);
                    go(i);
                    resetTimer();
                });
            }

            // init
            if (track) {
                // ensure track has width for transform to work correctly
                track.style.width = `${banners.length * 100}%`;
                Array.from(track.children).forEach(child => child.style.width = `${100 / banners.length}%`);
                update();
                resetTimer();
            }
        })();
    </script>
@endif

<script>
    document.addEventListener('DOMContentLoaded', function () {
        function initBannerSlider(wrapperSelector) {
            const wrapper = document.querySelector(wrapperSelector);
            if (!wrapper) return;
            const container = wrapper.parentElement; // expected visible container
            const slides = Array.from(wrapper.children || []);
            if (!slides.length || slides.length <= 1) return;

            function setup() {
                const cw = container.clientWidth || container.getBoundingClientRect().width;
                wrapper.style.width = (cw * slides.length) + 'px';
                wrapper.style.display = 'flex';
                wrapper.style.transition = 'transform 700ms cubic-bezier(.2,.9,.2,1)';
                slides.forEach(s => {
                    s.style.width = cw + 'px';
                    s.style.flex = '0 0 auto';
                });
            }

            let idx = 0;
            let timer = null;

            function go(i) {
                idx = (i + slides.length) % slides.length;
                const shift = -(idx * (container.clientWidth || container.getBoundingClientRect().width));
                wrapper.style.transform = 'translateX(' + shift + 'px)';
            }

            setup();
            window.addEventListener('resize', setup);

            timer = setInterval(function () { go(idx + 1); }, 3500);

            container.addEventListener('mouseenter', function () { if (timer) clearInterval(timer); });
            container.addEventListener('mouseleave', function () { if (timer) clearInterval(timer); timer = setInterval(function () { go(idx + 1); }, 3500); });
        }

        try { initBannerSlider('.customer-banner-slides'); } catch (e) { console.warn('customer slider init', e); }
        try { initBannerSlider('.mitra-banner-slides'); } catch (e) { /* ignore */ }
    });
</script>