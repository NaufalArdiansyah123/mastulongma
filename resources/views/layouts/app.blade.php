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
</head>

<body class="font-sans antialiased bg-gray-50">
    <!-- Mobile Container -->
    <div class="max-w-mobile mx-auto min-h-screen bg-gray-50 relative shadow-2xl">
        <!-- Content -->
        <main class="pb-20">
            {{ $slot }}
        </main>

        <!-- Bottom Navigation -->
        @auth
            <nav
                class="fixed bottom-0 left-0 right-0 max-w-mobile mx-auto bg-primary-50 rounded-t-3xl shadow-2xl z-50 border-t border-primary-100">
                <div class="flex justify-around items-center py-4 px-2">
                    <a href="{{ route('dashboard') }}"
                        class="flex flex-col items-center space-y-1 {{ request()->routeIs('dashboard') ? 'text-primary-600' : 'text-gray-600' }}">
                        <div
                            class="{{ request()->routeIs('dashboard') ? 'bg-primary-400 text-white' : 'bg-transparent' }} p-2 rounded-2xl transition-all">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z" />
                            </svg>
                        </div>
                    </a>

                    <a href="{{ route('helps.index') }}"
                        class="flex flex-col items-center space-y-1 {{ request()->routeIs('helps.*') ? 'text-primary-600' : 'text-gray-600' }}">
                        <div
                            class="{{ request()->routeIs('helps.*') ? 'bg-primary-400 text-white' : 'bg-transparent' }} p-2 rounded-2xl transition-all">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z" />
                            </svg>
                        </div>
                    </a>

                    <a href="#" class="flex flex-col items-center space-y-1 text-gray-600">
                        <div class="bg-transparent p-2 rounded-2xl transition-all">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M7.5 6.5C7.5 8.981 9.519 11 12 11s4.5-2.019 4.5-4.5S14.481 2 12 2 7.5 4.019 7.5 6.5zM20 21h1v-1c0-3.859-3.141-7-7-7h-4c-3.86 0-7 3.141-7 7v1h17z" />
                            </svg>
                        </div>
                    </a>

                    <a href="#" class="flex flex-col items-center space-y-1 text-gray-600">
                        <div class="bg-transparent p-2 rounded-2xl transition-all">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-5 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z" />
                            </svg>
                        </div>
                    </a>

                    <a href="{{ route('profile.edit') }}"
                        class="flex flex-col items-center space-y-1 {{ request()->routeIs('profile.*') ? 'text-primary-600' : 'text-gray-600' }}">
                        <div
                            class="{{ request()->routeIs('profile.*') ? 'bg-primary-400 text-white' : 'bg-transparent' }} p-2 rounded-2xl transition-all">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 3c1.66 0 3 1.34 3 3s-1.34 3-3 3-3-1.34-3-3 1.34-3 3-3zm0 14.2c-2.5 0-4.71-1.28-6-3.22.03-1.99 4-3.08 6-3.08 1.99 0 5.97 1.09 6 3.08-1.29 1.94-3.5 3.22-6 3.22z" />
                            </svg>
                        </div>
                    </a>
                </div>
            </nav>
        @endauth
    </div>
</body>

</html>