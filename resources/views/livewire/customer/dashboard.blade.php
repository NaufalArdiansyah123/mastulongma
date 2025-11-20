<div
    class="min-h-screen {{ $availableHelps->isEmpty() ? 'h-screen max-h-screen overflow-hidden' : '' }} bg-gradient-to-b from-gray-50 to-white">
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

    <!-- Header Section -->
    <div
        class="px-6 pt-8 pb-6 bg-gradient-to-br from-primary-400 via-primary-500 to-primary-600 rounded-b-[32px] shadow-xl">
        <div class="flex items-start justify-between mb-8 fade-in">
            <div class="flex items-center gap-3">
                @php
                    $__avatar = optional(auth()->user())->selfie_photo ?? optional(auth()->user())->photo ?? optional(auth()->user())->profile_photo_path ?? null;
                @endphp
                <div class="w-12 h-12 rounded-full overflow-hidden bg-white/20 flex-shrink-0">
                    <img src="{{ $__avatar ? asset('storage/' . $__avatar) : asset('images/avatar-placeholder.svg') }}"
                        alt="Avatar" class="w-full h-full object-cover">
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-white mb-1 tracking-tight">Hi, Welcome Back</h1>
                    <p class="text-sm text-white opacity-90 font-medium">
                        @php
                            $hour = date('H');
                            if ($hour < 12)
                                echo 'Good Morning';
                            elseif ($hour < 18)
                                echo 'Good Afternoon';
                            else
                                echo 'Good Evening';
                        @endphp
                    </p>
                </div>
            </div>
            <button
                class="bg-white p-3 rounded-2xl shadow-lg hover:shadow-xl hover:scale-110 transition-all duration-300">
                <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                </svg>
            </button>
        </div>

        <!-- Balance Cards Row -->
        <div class="grid grid-cols-2 gap-4 items-center slide-up">
            <!-- Total Balance -->
            <div class="flex flex-col">
                <div class="flex items-center text-white opacity-90 mb-2">
                    <svg class="w-4 h-4 mr-2 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                    </svg>
                    <span class="text-xs font-bold text-white tracking-wide">Total Balance</span>
                </div>
                <div class="text-3xl font-extrabold text-white drop-shadow-2xl tracking-tight"
                    wire:poll.visible.30s="refreshBalance">
                    Rp {{ number_format($balance, 0, ',', '.') }}
                </div>
            </div>

            <!-- Tambah Saldo Button (links to top-up page) -->
            <a href="{{ route('customer.topup') }}"
                class="rounded-2xl bg-white text-gray-800 font-bold px-5 py-3 shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105 flex items-center justify-center gap-2 h-fit">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
                </svg>
                <span class="text-sm font-bold">Tambah Saldo</span>
            </a>
        </div>
    </div>

    <!-- Main Content Card -->
    <div
        class="bg-gradient-to-b from-gray-50 to-white rounded-t-[32px] px-5 pt-8 pb-24 min-h-[60vh] -mt-4 relative z-10">
        <!-- Promo Banner (rotating) -->
        <div class="mb-6 slide-up">
            <div id="promo-banner"
                class="rounded-3xl overflow-hidden shadow-lg hover:shadow-xl transition-shadow duration-300">
                <div id="promo-banner-slide"
                    class="h-36 rounded-3xl p-6 flex items-center justify-center text-white bg-gradient-to-br from-indigo-400 to-indigo-500 transition-all duration-500">
                    <div class="text-center">
                        <div id="promo-title" class="font-extrabold text-xl mb-1 tracking-tight">Promo Spesial</div>
                        <div id="promo-desc" class="text-sm opacity-90 font-medium">Dapatkan diskon layanan untuk
                            bantuan pertama Anda.</div>
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

        <!-- Quick Actions -->
        <div class="mb-8 fade-in">
            <h2 class="text-base font-bold text-gray-900 mb-4 px-1">Quick Actions</h2>
            <div class="grid grid-cols-4 gap-4 md:grid-cols-6 lg:grid-cols-8">
                <a href="{{ route('customer.helps.create') }}"
                    class="flex flex-col items-center text-center bg-white p-4 rounded-3xl card-shadow hover:card-shadow-hover transition-all duration-300 hover:-translate-y-1 hover:scale-105 group">
                    <div
                        class="w-12 h-12 rounded-2xl bg-gradient-to-br from-primary-100 to-primary-200 flex items-center justify-center mb-3 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M12 4v16m8-8H4" />
                        </svg>
                    </div>
                    <span class="text-xs font-bold text-gray-800 whitespace-normal">Buat</span>
                </a>

                <a href="{{ route('customer.helps.index') }}"
                    class="flex flex-col items-center text-center bg-white p-4 rounded-3xl card-shadow hover:card-shadow-hover transition-all duration-300 hover:-translate-y-1 hover:scale-105 group">
                    <div
                        class="w-12 h-12 rounded-2xl bg-gradient-to-br from-primary-100 to-primary-200 flex items-center justify-center mb-3 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-6 h-6 text-primary-600" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M3 3h14v2H3V3zm0 4h14v10H3V7z" />
                        </svg>
                    </div>
                    <span class="text-xs font-bold text-gray-800 truncate w-full">Lihat Bantuan</span>
                </a>

                <a href="{{ route('customer.transactions.index') }}"
                    class="flex flex-col items-center text-center bg-white p-4 rounded-3xl card-shadow hover:card-shadow-hover transition-all duration-300 hover:-translate-y-1 hover:scale-105 group">
                    <div
                        class="w-12 h-12 rounded-2xl bg-gradient-to-br from-primary-100 to-primary-200 flex items-center justify-center mb-3 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 10h18M7 6h10M7 14h10M7 18h10" />
                        </svg>
                    </div>
                    <span class="text-xs font-bold text-gray-800 truncate w-full">Transaksi</span>
                </a>

                <a href="{{ route('profile') }}"
                    class="flex flex-col items-center text-center bg-white p-4 rounded-3xl card-shadow hover:card-shadow-hover transition-all duration-300 hover:-translate-y-1 hover:scale-105 group">
                    <div
                        class="w-12 h-12 rounded-2xl bg-gradient-to-br from-primary-100 to-primary-200 flex items-center justify-center mb-3 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-6 h-6 text-primary-600" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 2a4 4 0 110 8 4 4 0 010-8zm0 10c-4 0-8 2-8 4v2h16v-2c0-2-4-4-8-4z" />
                        </svg>
                    </div>
                    <span class="text-xs font-bold text-gray-800 truncate w-full">Profil</span>
                </a>
            </div>
        </div>

        <!-- People Who Need Help List -->
        @if($activeTab !== 'history')
            <div>
                <h2 class="text-base font-bold text-gray-900 mb-4 px-1">Orang yang Membutuhkan Bantuan</h2>
                <div class="space-y-4">
                    @forelse($availableHelps as $help)
                        <div
                            class="flex items-center justify-between bg-white rounded-3xl p-5 card-shadow hover:card-shadow-hover transition-all duration-300 hover-lift group">
                            <div class="flex items-center space-x-4 flex-1" wire:click="showHelp({{ $help->id }})"
                                style="cursor:pointer">
                                <div
                                    class="w-16 h-16 rounded-2xl bg-gradient-to-br from-primary-100 to-primary-200 overflow-hidden flex items-center justify-center shadow-md group-hover:scale-110 transition-transform duration-300">
                                    @if($help->photo)
                                        <img src="{{ asset('storage/' . $help->photo) }}" alt="Foto bantuan"
                                            class="w-full h-full object-cover" loading="lazy">
                                    @else
                                        <span class="text-3xl">💰</span>
                                    @endif
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="font-bold text-gray-900 text-base mb-1 truncate">{{ $help->user->name }}</div>
                                    <div class="text-xs text-gray-600 mb-2 truncate font-medium">{{ $help->title }}</div>
                                    <div class="flex items-center gap-2 flex-wrap">
                                        <span
                                            class="text-xs px-3 py-1 rounded-full bg-green-100 text-green-700 font-bold shadow-sm">
                                            Rp {{ number_format($help->amount, 0, ',', '.') }}
                                        </span>
                                        <span class="text-xs text-gray-500 font-medium">📍 {{ $help->city->name }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="text-right ml-4">
                                <div class="text-xs text-gray-500 mb-2 font-medium">{{ $help->created_at->diffForHumans() }}
                                </div>
                                @if(auth()->user()->isMitra())
                                    <a href="{{ route('helps.available') }}"
                                        class="inline-flex items-center text-xs font-bold text-primary-600 hover:text-primary-700 hover:underline transition-all">
                                        Lihat →
                                    </a>
                                @else
                                    <span class="text-xs text-gray-400 font-medium">Butuh Bantuan</span>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-12 bg-white rounded-3xl card-shadow">
                            <svg class="w-20 h-20 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                            <p class="text-gray-500 font-semibold">Belum ada yang membutuhkan bantuan</p>
                            <p class="text-gray-400 text-sm mt-1">Cek kembali nanti</p>
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

@if($availableHelps->isEmpty())
    <script>
        document.body.style.overflow = 'hidden';
        document.documentElement.style.overflow = 'hidden';
    </script>
@endif

<script>
    (function () {
        const banners = [
            { title: 'Promo Spesial', desc: 'Dapatkan diskon layanan untuk bantuan pertama Anda.', bg: 'from-indigo-400 to-indigo-500' },
            { title: 'Gratis Ongkir', desc: 'Pengiriman gratis untuk bantuan di kota yang sama.', bg: 'from-green-400 to-green-500' },
            { title: 'Dapatkan Badge', desc: 'Selesaikan 5 bantuan dan dapatkan badge Mitra Aktif.', bg: 'from-yellow-400 to-yellow-500' }
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
                slideEl.className = 'h-36 rounded-3xl p-6 flex items-center justify-center text-white bg-gradient-to-br ' + b.bg + ' transition-all duration-500';
            }
            if (dots.length) {
                dots.forEach((d, k) => {
                    d.classList.toggle('bg-primary-600', k === idx);
                    d.classList.toggle('bg-gray-300', k !== idx);
                });
            }
        }

        // init
        if (slideEl) {
            show(0);
            let timer = setInterval(() => show((idx + 1) % banners.length), 4000);

            // allow manual dot click
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