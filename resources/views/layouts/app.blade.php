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
                <nav class="fixed bottom-0 left-1/2 transform -translate-x-1/2 bg-white border-t border-gray-200 shadow-2xl z-50"
                    style="max-width: 448px; width: 100vw;">
                    <div class="max-w-md mx-auto flex items-center justify-around px-4 py-2.5">
                        <a href="{{ route('customer.dashboard') }}"
                            class="flex flex-col items-center py-1.5 {{ request()->routeIs('customer.dashboard') ? 'text-primary-600' : 'text-gray-400 hover:text-primary-600' }} transition">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z" />
                            </svg>
                            <span class="text-xs font-bold mt-0.5">Beranda</span>
                        </a>

                        <a href="{{ route('customer.helps.index') }}"
                            class="flex flex-col items-center py-1.5 {{ request()->routeIs('customer.helps.*') ? 'text-primary-600' : 'text-gray-400 hover:text-primary-600' }} transition">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-5 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z" />
                            </svg>
                            <span class="text-xs font-bold mt-0.5">Bantuan</span>
                        </a>

                        <a href="{{ route('customer.helps.create') }}"
                            class="flex flex-col items-center py-1.5 {{ request()->routeIs('customer.helps.create') ? 'text-primary-600' : 'text-gray-400 hover:text-primary-600' }} transition">
                            <div
                                class="w-9 h-9 rounded-full bg-gradient-to-br from-primary-400 to-primary-500 flex items-center justify-center shadow">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                        d="M12 4v16m8-8H4" />
                                </svg>
                            </div>
                            <span class="text-xs font-bold mt-0.5">Tambah</span>
                        </a>

                        <a href="{{ route('customer.transactions.index') }}"
                            class="flex flex-col items-center py-1.5 {{ request()->routeIs('customer.transactions.*') ? 'text-primary-600' : 'text-gray-400 hover:text-primary-600' }} transition">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M3 3h18v2H3V3zm0 4h18v14H3V7zm5 3v8h2v-8H8zm4 0v8h2v-8h-2z" />
                            </svg>
                            <span class="text-xs font-bold mt-0.5">Transaksi</span>
                        </a>

                        <a href="{{ route('profile') }}"
                            class="flex flex-col items-center py-1.5 {{ request()->routeIs('profile.*') ? 'text-primary-600' : 'text-gray-400 hover:text-primary-600' }} transition">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 3c1.66 0 3 1.34 3 3s-1.34 3-3 3-3-1.34-3-3 1.34-3 3-3zm0 14.2c-2.5 0-4.71-1.28-6-3.22.03-1.99 4-3.08 6-3.08 1.99 0 5.97 1.09 6 3.08-1.29 1.94-3.5 3.22-6 3.22z" />
                            </svg>
                            <span class="text-xs font-bold mt-0.5">Profil</span>
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
        // Toggle blur on bottom nav when any confirmation modal is present in DOM.
        function checkConfirmModalAndToggleBlur() {
            try {
                var modal = document.querySelector('[data-confirm-modal]');
                var nav = document.querySelector('nav');
                if (!nav) return;

                if (modal) {
                    nav.classList.add('filter', 'blur-sm');
                } else {
                    nav.classList.remove('filter', 'blur-sm');
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