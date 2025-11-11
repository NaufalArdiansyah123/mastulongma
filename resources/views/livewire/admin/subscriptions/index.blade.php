<div class="min-h-screen bg-gray-50 pb-20">
    <!-- Header with Status Bar -->
    <div class="bg-white border-b border-gray-200 sticky top-0 z-10">
        <!-- Status Bar -->
        <div
            class="h-6 bg-gradient-to-r from-primary-400 via-primary-500 to-primary-600 flex items-center justify-between px-4 text-white text-xs">
            <span>{{ now()->format('H:i') }}</span>
            <span>Manajemen Langganan</span>
            <span>●●●●</span>
        </div>

        <!-- Header -->
        <div class="px-4 py-3 flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <a href="{{ route('admin.dashboard') }}" class="text-gray-600 hover:text-gray-900">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </a>
                <h1 class="text-xl font-bold text-gray-900">Manajemen Langganan</h1>
            </div>
        </div>
    </div>

    <!-- Content -->
    <div class="p-4">
        <div class="bg-white rounded-xl border border-gray-200 p-6 text-center">
            <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <h3 class="text-lg font-semibold text-gray-900 mb-2">Fitur Langganan</h3>
            <p class="text-gray-600 mb-4">Halaman manajemen langganan mitra akan segera tersedia.</p>
            <p class="text-sm text-gray-500">Fitur ini akan digunakan untuk mengelola paket langganan dan pembayaran
                mitra.</p>
        </div>
    </div>

    <!-- Bottom Navigation -->
    <div class="fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 px-4 py-2">
        <div class="flex justify-around items-center max-w-md mx-auto">
            <a href="{{ route('admin.dashboard') }}" class="flex flex-col items-center py-2 px-4 text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 13h8V3H3v10zm0 8h8v-6H3v6zm10 0h8V11h-8v10zm0-18v6h8V3h-8z" />
                </svg>
                <span class="text-xs mt-1">Dashboard</span>
            </a>

            <a href="{{ route('admin.users') }}" class="flex flex-col items-center py-2 px-4 text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
                <span class="text-xs mt-1">Users</span>
            </a>

            <a href="{{ route('admin.cities') }}" class="flex flex-col items-center py-2 px-4 text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                <span class="text-xs mt-1">Kota</span>
            </a>

            <a href="{{ route('admin.categories') }}" class="flex flex-col items-center py-2 px-4 text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                </svg>
                <span class="text-xs mt-1">Kategori</span>
            </a>
        </div>
    </div>
</div>