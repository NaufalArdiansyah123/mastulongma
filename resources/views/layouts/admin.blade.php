<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Admin Panel' }} - MastuLongmas</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>

<body class="antialiased">
    <div class="min-h-screen bg-gray-100 flex">
        <!-- Sidebar -->
        <aside class="w-64 bg-white shadow-lg fixed h-full overflow-y-auto">
            <div class="p-6 border-b border-gray-200">
                <h1 class="text-2xl font-bold text-primary-600">MastuLongmas</h1>
                <p class="text-xs text-gray-500 mt-1">Admin Panel</p>
            </div>

            <nav class="p-4">
                <a href="{{ route('admin.dashboard') }}"
                    class="flex items-center px-4 py-3 mb-2 {{ request()->routeIs('admin.dashboard') ? 'text-white bg-primary-600' : 'text-gray-700 hover:bg-gray-100' }} rounded-lg transition">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    Dashboard
                </a>

                <div class="mt-6 mb-2">
                    <p class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Moderasi</p>
                </div>

                <a href="{{ route('admin.verifications') }}"
                    class="flex items-center px-4 py-3 mb-2 {{ request()->routeIs('admin.verifications*') ? 'text-white bg-primary-600' : 'text-gray-700 hover:bg-gray-100' }} rounded-lg transition">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                    Verifikasi KTP
                </a>

                <a href="{{ route('admin.users.index') }}"
                    class="flex items-center px-4 py-3 mb-2 {{ request()->routeIs('admin.users.*') ? 'text-white bg-primary-600' : 'text-gray-700 hover:bg-gray-100' }} rounded-lg transition">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 20h5V10l-5-5m-5 15h5V10l-5-5m0 15H7a2 2 0 01-2-2V7a2 2 0 012-2h5" />
                    </svg>
                    Kelola Pengguna
                </a>

                <a href="{{ route('admin.partners.activity') }}"
                    class="flex items-center px-4 py-3 mb-2 {{ request()->routeIs('admin.partners.activity') ? 'text-white bg-primary-600' : 'text-gray-700 hover:bg-gray-100' }} rounded-lg transition">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M5 13l4 4L19 7M9 5a3 3 0 00-3 3v10h12V8a3 3 0 00-3-3H9z" />
                    </svg>
                    Aktivitas Mitra
                </a>

                <a href="{{ route('admin.partners.report') }}"
                    class="flex items-center px-4 py-3 mb-2 {{ request()->routeIs('admin.partners.report') || request()->routeIs('admin.partners.reports.*') ? 'text-white bg-primary-600' : 'text-gray-700 hover:bg-gray-100' }} rounded-lg transition">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    Manajemen Laporan Aduan
                </a>

                <a href="{{ route('admin.partners.blocked') }}"
                    class="flex items-center px-4 py-3 mb-2 {{ request()->routeIs('admin.partners.blocked') ? 'text-white bg-primary-600' : 'text-gray-700 hover:bg-gray-100' }} rounded-lg transition">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M18.364 5.636l-12.728 12.728M6.343 6.343l11.314 11.314M9 5h6a2 2 0 012 2v10a2 2 0 01-2 2H9a2 2 0 01-2-2V7a2 2 0 012-2z" />
                    </svg>
                    Blokir Mitra
                </a>

                <div class="mt-6 mb-2">
                    <p class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Keuangan</p>
                </div>

                <a href="{{ route('admin.withdraws.index') }}"
                    class="flex items-center px-4 py-3 mb-2 {{ request()->routeIs('admin.withdraws.*') ? 'text-white bg-primary-600' : 'text-gray-700 hover:bg-gray-100' }} rounded-lg transition">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8v8" />
                    </svg>
                    Manajemen Withdraw
                </a>

                <a href="{{ route('admin.topup.approvals') }}"
                    class="flex items-center px-4 py-3 mb-2 {{ request()->routeIs('admin.topup.approvals*') ? 'text-white bg-primary-600' : 'text-gray-700 hover:bg-gray-100' }} rounded-lg transition">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7 7h.01M7 11h.01M7 15h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Manajemen Approval
                </a>
            </nav>

            <div class="absolute bottom-0 w-64 p-4 border-t border-gray-200 bg-white">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div
                            class="w-10 h-10 bg-primary-600 rounded-full flex items-center justify-center text-white font-semibold">
                            {{ substr(auth()->user()->name, 0, 1) }}
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-semibold text-gray-900">{{ auth()->user()->name }}</p>
                            <p class="text-xs text-gray-500">Admin</p>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-gray-400 hover:text-red-600 transition" title="Logout">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 ml-64 overflow-y-auto min-h-screen">
            <!-- Topbar -->
            <div class="sticky top-0 z-20 bg-white border-b border-gray-100">
                <div class="px-6 py-3 flex items-center justify-between">
                    <div class="flex items-center gap-4 min-w-0">
                        <div class="hidden sm:flex items-center text-xs text-gray-400 gap-2">
                            <a href="{{ route('admin.dashboard') }}" class="hover:underline">Admin</a>
                            <svg class="w-3 h-3 text-gray-300" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            <span class="font-medium text-gray-700">@yield('page-title', 'Dashboard')</span>
                        </div>

                        <div class="min-w-0">
                            @hasSection('page-title')
                                <div>
                                    <h2 class="text-lg font-semibold text-gray-800 truncate">@yield('page-title')</h2>
                                    @hasSection('page-description')
                                        <div class="text-sm text-gray-500 mt-0.5 truncate">@yield('page-description')</div>
                                    @endif
                                </div>
                            @else
                                <div></div>
                            @endif
                        </div>
                    </div>

                    <div class="flex items-center gap-3">
                        @php
                            $notes = collect($notifications ?? []);
                            $unread = $notes->where('read', false)->count();
                        @endphp

                        <!-- Quick actions (only Refresh) -->
                        <div class="hidden sm:flex items-center gap-2">
                            <button onclick="location.reload()" class="inline-flex items-center gap-2 px-3 py-1.5 bg-gray-50 border border-gray-200 text-sm text-gray-700 rounded hover:bg-gray-100">
                                <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v6h6"/></svg>
                                Refresh
                            </button>
                        </div>

                        <!-- Notifications -->
                        <div x-data="{ open: false }" class="relative">
                            <button @click.prevent="open = !open" class="p-2 rounded-full hover:bg-gray-100 transition" aria-haspopup="true" :aria-expanded="open">
                                <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6 6 0 10-12 0v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                                </svg>
                                @if($unread)
                                    <span class="absolute -top-0.5 -right-0.5 inline-flex items-center justify-center px-1.5 py-0.5 text-xs font-bold leading-none text-white bg-red-600 rounded-full">{{ $unread }}</span>
                                @endif
                            </button>

                            <div x-show="open" x-cloak x-transition class="origin-top-right absolute right-0 mt-2 w-80 bg-white border border-gray-100 rounded-lg shadow-lg overflow-hidden">
                                <div class="p-3 border-b border-gray-100 text-sm font-semibold">Notifikasi</div>
                                <div class="max-h-64 overflow-auto">
                                    @if($notes->isEmpty())
                                        <div class="p-4 text-sm text-gray-500">Tidak ada notifikasi.</div>
                                    @else
                                        @foreach($notes->take(20) as $note)
                                            <a href="{{ $note['link'] ?? '#' }}" class="flex items-start gap-3 px-4 py-3 hover:bg-gray-50 transition">
                                                <div class="flex-shrink-0">
                                                    <div class="w-9 h-9 rounded-full bg-gray-100 flex items-center justify-center text-gray-600"> 
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1"/></svg>
                                                    </div>
                                                </div>
                                                <div class="flex-1">
                                                    <div class="text-sm text-gray-800">{{ $note['title'] ?? ($note['message'] ?? 'Notifikasi') }}</div>
                                                    @if(!empty($note['time']))
                                                        <div class="text-xs text-gray-400 mt-1">{{ $note['time'] }}</div>
                                                    @endif
                                                </div>
                                            </a>
                                        @endforeach
                                    @endif
                                </div>
                                <div class="p-2 border-t border-gray-100 text-center">
                                    @if(Route::has('admin.notifications.index'))
                                        <a href="{{ route('admin.notifications.index') }}" class="text-sm text-primary-600 hover:underline">Lihat semua</a>
                                    @else
                                        <a href="#" class="text-sm text-primary-600 hover:underline">Lihat semua</a>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- User -->
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-full bg-primary-600 text-white flex items-center justify-center font-semibold">{{ strtoupper(substr(auth()->user()->name ?? 'A',0,1)) }}</div>
                            <div class="hidden sm:block">
                                <div class="text-sm font-medium text-gray-800">{{ auth()->user()->name ?? 'Admin' }}</div>
                                <div class="text-xs text-gray-400">Admin</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="p-4">
                @hasSection('content')
                    @yield('content')
                @elseif(isset($slot))
                    {{ $slot }}
                @endif
            </div>
        </main>
    </div>

    @livewireScripts
    @stack('scripts')
</body>

</html>