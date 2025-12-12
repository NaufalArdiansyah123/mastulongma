<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Mastulongmas') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <style>
        [x-cloak] { display: none !important; }
        
        /* Bottom Navigation Animations */
        @keyframes slideUp {
            from {
                transform: translate(-50%, 100%);
                opacity: 0;
            }
            to {
                transform: translate(-50%, 0);
                opacity: 1;
            }
        }

        @keyframes ripple {
            0% {
                transform: scale(0);
                opacity: 0.6;
            }
            100% {
                transform: scale(4);
                opacity: 0;
            }
        }

        @keyframes bounce-in {
            0% {
                transform: scale(0.3);
                opacity: 0;
            }
            50% {
                transform: scale(1.05);
            }
            70% {
                transform: scale(0.9);
            }
            100% {
                transform: scale(1);
                opacity: 1;
            }
        }

        #bottom-nav {
            animation: slideUp 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .nav-item {
            position: relative;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .nav-item::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: rgba(0, 152, 231, 0.15);
            transform: translate(-50%, -50%);
            transition: width 0.4s, height 0.4s;
        }

        .nav-item:active::before {
            width: 60px;
            height: 60px;
        }

        .nav-item:hover {
            transform: translateY(-3px);
        }

        .nav-item:active {
            transform: translateY(-1px) scale(0.95);
        }

        .nav-item svg {
            transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        .nav-item:hover svg {
            transform: scale(1.15);
        }

        .nav-item:active svg {
            transform: scale(0.9);
        }

        .nav-item.active svg {
            animation: bounce-in 0.6s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        .nav-item .nav-label {
            transition: all 0.2s ease;
        }

        .nav-item:hover .nav-label {
            transform: scale(1.05);
        }

        .nav-fab {
            position: relative;
            transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        .nav-fab::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 100%;
            height: 100%;
            border-radius: 50%;
            background: linear-gradient(135deg, #0098e7 0%, #0077cc 100%);
            transform: translate(-50%, -50%);
            z-index: -1;
            transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        .nav-fab:hover {
            transform: translateY(-4px) rotate(90deg);
        }

        .nav-fab:hover::after {
            transform: translate(-50%, -50%) scale(1.2);
            box-shadow: 0 8px 20px rgba(0, 152, 231, 0.4);
        }

        .nav-fab:active {
            transform: translateY(-2px) rotate(90deg) scale(0.9);
        }

        .nav-fab svg {
            transition: transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        .nav-fab:hover svg {
            transform: rotate(-90deg);
        }

        @keyframes float {
            0%, 100% {
                transform: translateY(0px);
            }
            50% {
                transform: translateY(-2px);
            }
        }

        .nav-item.active {
            animation: float 2s ease-in-out infinite;
        }

        /* Indicator dot for active state */
        .nav-item.active::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 50%;
            transform: translateX(-50%);
            width: 4px;
            height: 4px;
            border-radius: 50%;
            background: currentColor;
            animation: bounce-in 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
        }
    </style>
</head>

<body class="font-sans antialiased bg-gray-50">
    <!-- Centered Container -->
    <div class="min-h-screen flex items-start justify-center bg-gray-100">
        <!-- Mobile Width Container -->
        <div class="w-full max-w-md bg-gray-50 relative shadow-2xl">
            <!-- Content -->
            <main class="pb-20">
                @if($__env->hasSection('content'))
                    @yield('content')
                @else
                    {{ $slot ?? '' }}
                @endif
            </main>

            <!-- Bottom Navigation (styled like mitra layout) -->
            @auth
                <nav id="bottom-nav" class="fixed bottom-0 left-1/2 transform -translate-x-1/2 bg-white border-t border-gray-200 shadow-2xl z-50"
                    style="max-width: 448px; width: 100vw;">
                    <div class="max-w-md mx-auto flex items-center justify-around px-4 py-2.5">
                        <a href="{{ route('customer.dashboard') }}"
                            class="nav-item flex flex-col items-center py-1.5 {{ request()->routeIs('customer.dashboard') ? 'text-primary-600 active' : 'text-gray-400 hover:text-primary-600' }}">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z" />
                            </svg>
                            <span class="nav-label text-xs font-bold mt-0.5">Beranda</span>
                        </a>

                        <a href="{{ route('customer.helps.index') }}"
                            class="nav-item flex flex-col items-center py-1.5 {{ request()->routeIs('customer.helps.*') && !request()->routeIs('customer.helps.create') ? 'text-primary-600 active' : 'text-gray-400 hover:text-primary-600' }}">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-5 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z" />
                            </svg>
                            <span class="nav-label text-xs font-bold mt-0.5">Bantuan</span>
                        </a>

                        <a href="{{ route('customer.helps.create') }}"
                            class="flex flex-col items-center py-1.5 blur-on-modal {{ request()->routeIs('customer.helps.create') ? 'text-primary-600' : 'text-gray-400 hover:text-primary-600' }}">
                            <div
                                class="nav-fab w-9 h-9 rounded-full bg-gradient-to-br from-primary-400 to-primary-500 flex items-center justify-center shadow-lg">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                        d="M12 4v16m8-8H4" />
                                </svg>
                            </div>
                            <span class="nav-label text-xs font-bold mt-0.5">Tambah</span>
                        </a>

                        <a href="{{ route('customer.transactions.index') }}"
                            class="nav-item flex flex-col items-center py-1.5 {{ request()->routeIs('customer.transactions.*') ? 'text-primary-600 active' : 'text-gray-400 hover:text-primary-600' }}">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M3 3h18v2H3V3zm0 4h18v14H3V7zm5 3v8h2v-8H8zm4 0v8h2v-8h-2z" />
                            </svg>
                            <span class="nav-label text-xs font-bold mt-0.5">Transaksi</span>
                        </a>

                        <a href="{{ route('profile') }}"
                            class="nav-item flex flex-col items-center py-1.5 {{ request()->routeIs('profile.*') || request()->routeIs('profile') ? 'text-primary-600 active' : 'text-gray-400 hover:text-primary-600' }}">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 3c1.66 0 3 1.34 3 3s-1.34 3-3 3-3-1.34-3-3 1.34-3 3-3zm0 14.2c-2.5 0-4.71-1.28-6-3.22.03-1.99 4-3.08 6-3.08 1.99 0 5.97 1.09 6 3.08-1.29 1.94-3.5 3.22-6 3.22z" />
                            </svg>
                            <span class="nav-label text-xs font-bold mt-0.5">Profil</span>
                        </a>
                    </div>
                </nav>
            @endauth
        </div>
    </div>

    @livewireScripts
    <script>
        // Listen for Livewire dispatch to open Midtrans Snap
        window.addEventListener('openMidtransSnap', function (e) {
            try {
                var token = e.detail?.snapToken || e.detail?.detail?.snapToken || e.detail;
                if (!token && e?.detail?.snapToken) token = e.detail.snapToken;

                if (!token) {
                    console.warn('openMidtransSnap called without snap token', e);
                    return;
                }

                if (typeof snap === 'undefined' || !snap.pay) {
                    console.warn('Midtrans snap.js not loaded. Cannot open snap.pay.');
                    return;
                }

                snap.pay(token, {
                    onSuccess: function (result) {
                        console.info('Snap success callback', result);
                        // send a quick client callback to server so we can update status immediately
                        fetch("{{ route('topup.client-callback') }}", {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            },
                            body: JSON.stringify({ order_id: result.order_id, result: result })
                        }).then(function (resp) {
                            return resp.json();
                        }).then(function (json) {
                            console.info('Client callback response', json);
                            // Optionally reload or notify Livewire to refresh
                            if (window.Livewire) {
                                try { window.Livewire.emit('balance-updated'); } catch (e) { }
                            }

                            // Redirect user to success page (include order_id)
                            try {
                                var successUrl = "{{ route('topup.success') }}" + '?order_id=' + encodeURIComponent(result.order_id);
                                // small delay to give server a moment to process queued job
                                setTimeout(function () {
                                    window.location.href = successUrl;
                                }, 800);
                            } catch (e) {
                                console.warn('Failed to redirect to success page', e);
                            }
                        }).catch(function (err) {
                            console.warn('Client callback failed', err);
                            // still redirect to success page as fallback
                            try {
                                window.location.href = "{{ route('topup.success') }}" + '?order_id=' + encodeURIComponent(result.order_id);
                            } catch (e) { }
                        });
                    },
                    onPending: function (result) {
                        console.info('Snap pending callback', result);
                    },
                    onError: function (result) {
                        console.error('Snap error callback', result);
                    },
                    onClose: function () {
                        console.info('Snap widget closed by user');
                    }
                });
            } catch (err) {
                console.error('Failed to open Midtrans snap', err);
            }
        });
    </script>
    <script>
        // Toggle blur on bottom nav and any elements with `.blur-on-modal` when a modal is present in DOM.
        function checkConfirmModalAndToggleBlur() {
            try {
                var modal = document.querySelector('[data-confirm-modal], [data-transaction-modal]');
                var nav = document.querySelector('#bottom-nav');
                var extras = document.querySelectorAll('.blur-on-modal');

                if (nav) {
                    if (modal) {
                        nav.classList.add('filter', 'blur-sm');
                    } else {
                        nav.classList.remove('filter', 'blur-sm');
                    }
                }

                if (extras && extras.length) {
                    extras.forEach(function (el) {
                        if (modal) {
                            el.classList.add('filter', 'blur-sm');
                        } else {
                            el.classList.remove('filter', 'blur-sm');
                        }
                    });
                }
            } catch (e) {
                console.warn('checkConfirmModalAndToggleBlur error', e);
            }
        }

        document.addEventListener('DOMContentLoaded', function () {
            checkConfirmModalAndToggleBlur();
        });

        // Livewire fires these events after DOM updates
        window.addEventListener('livewire:load', function () {
            checkConfirmModalAndToggleBlur();
        });

        window.addEventListener('livewire:update', function () {
            checkConfirmModalAndToggleBlur();
        });

        // Also observe mutations to catch cases where Livewire doesn't trigger events
        try {
            var observer = new MutationObserver(function () { checkConfirmModalAndToggleBlur(); });
            observer.observe(document.body, { childList: true, subtree: true });
        } catch (e) {
            // ignore
        }
    </script>
</body>

</html>