<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Mastulongmas') }} - Mitra</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>

<body class="font-sans antialiased bg-gray-50">
    <!-- Centered Container -->
    <div class="min-h-screen flex items-start justify-center bg-gray-100">
        <!-- Mobile Width Container -->
        <div class="w-full max-w-md bg-gray-50 relative shadow-2xl">
            <!-- Content -->
            <div class="flex flex-col min-h-screen">
                <!-- Livewire -->
                <div class="flex-1">
                    @isset($slot)
                        {{ $slot }}
                    @else
                        @yield('content')
                    @endisset
                </div>

                <!-- Bottom Navigation Bar -->
                <div class="fixed bottom-0 left-1/2 transform -translate-x-1/2 bg-white border-t border-gray-200 shadow-2xl z-50"
                    style="max-width: 448px; width: 100vw;">
                    <div class="max-w-md mx-auto flex items-center justify-around px-4 py-2.5">
                        <a href="{{ route('mitra.dashboard') }}"
                            class="flex flex-col items-center py-1.5 {{ request()->routeIs('mitra.dashboard') && !request()->has('tab') ? 'text-primary-600' : 'text-gray-400 hover:text-primary-600' }} transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>
                            <span class="text-xs font-bold mt-0.5">Beranda</span>
                        </a>
                        <a href="{{ route('mitra.helps.all') }}"
                            class="flex flex-col items-center py-1.5 {{ request()->routeIs('mitra.helps.all') ? 'text-primary-600' : 'text-gray-400 hover:text-primary-600' }} transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                            <span class="text-xs font-bold mt-0.5">Bantuan</span>
                        </a>
                        <a href="{{ route('mitra.helps.processing') }}"
                            class="flex flex-col items-center py-1.5 {{ request()->routeIs('mitra.helps.processing') ? 'text-primary-600' : 'text-gray-400 hover:text-primary-600' }} transition">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M3 5h18v2H3V5zm0 6h12v2H3v-2zm0 6h8v2H3v-2z" />
                            </svg>
                            <span class="text-xs font-bold mt-0.5">Diproses</span>
                        </a>
                        <a href="{{ route('mitra.helps.completed') }}"
                            class="flex flex-col items-center py-1.5 {{ request()->routeIs('mitra.helps.completed') ? 'text-primary-600' : 'text-gray-400 hover:text-primary-600' }} transition">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                            <span class="text-xs font-bold mt-0.5">Riwayat</span>
                        </a>
                        <a href="{{ route('mitra.profile') }}"
                            class="flex flex-col items-center py-1.5 {{ request()->routeIs('mitra.profile') ? 'text-primary-600' : 'text-gray-400 hover:text-primary-600' }} transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            <span class="text-xs font-bold mt-0.5">Profil</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @livewireScripts
    @include('partials.help-modal')

    <script>
        function togglePassword(fieldId) {
            const field = document.getElementById(fieldId);
            if (field.type === 'password') {
                field.type = 'text';
            } else {
                field.type = 'password';
            }
        }
    </script>
</body>

</html>