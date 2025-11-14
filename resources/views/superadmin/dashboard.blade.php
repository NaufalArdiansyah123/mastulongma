<div>
    <header class="bg-white shadow-sm border-b border-gray-200 sticky top-0 z-10">
        <div class="px-8 py-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Dashboard Super Admin</h1>
                    <p class="text-sm text-gray-600 mt-1">Selamat datang, {{ auth()->user()->name }}</p>
                </div>
                <div class="text-sm text-gray-500">
                    {{ now()->isoFormat('dddd, D MMMM Y') }}
                </div>
            </div>
        </div>
    </header>

    <div class="p-12">
        <!-- Stats Grid -->
        <div class="grid grid-cols-5 gap-4 mb-8">
            <!-- Total Users -->
            <div class="bg-white rounded-lg shadow-sm p-4 border border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-semibold text-gray-600 uppercase tracking-wider">Total User</p>
                        <p class="text-4xl font-bold text-gray-900 mt-2">{{ number_format($stats['total_users']) }}</p>
                        <p class="text-sm text-gray-500 mt-1">Semua pengguna</p>
                    </div>
                    <div class="bg-gray-100 rounded-full p-3">
                        <svg class="w-10 h-10 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Total Customers -->
            <div class="bg-white rounded-lg shadow-sm p-4 border border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-semibold text-gray-600 uppercase tracking-wider">Customer</p>
                        <p class="text-4xl font-bold text-gray-900 mt-2">{{ number_format($stats['total_customers']) }}
                        </p>
                        <p class="text-sm text-gray-500 mt-1">Pengguna customer</p>
                    </div>
                    <div class="bg-gray-100 rounded-full p-3">
                        <svg class="w-10 h-10 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Total Cities -->
            <div class="bg-white rounded-lg shadow-sm p-4 border border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-semibold text-gray-600 uppercase tracking-wider">Total Kota</p>
                        <p class="text-4xl font-bold text-gray-900 mt-2">{{ number_format($stats['total_cities']) }}</p>
                        <p class="text-sm text-gray-500 mt-1">Kota terdaftar</p>
                    </div>
                    <div class="bg-gray-100 rounded-full p-3">
                        <svg class="w-10 h-10 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Total Mitras -->
            <div class="bg-white rounded-lg shadow-sm p-4 border border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-semibold text-gray-600 uppercase tracking-wider">Mitra</p>
                        <p class="text-4xl font-bold text-gray-900 mt-2">{{ number_format($stats['total_mitras']) }}</p>
                        <p class="text-sm text-gray-500 mt-1">Pengguna mitra</p>
                    </div>
                    <div class="bg-gray-100 rounded-full p-3">
                        <svg class="w-10 h-10 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Total Admins -->
            <div class="bg-white rounded-lg shadow-sm p-4 border border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-semibold text-gray-600 uppercase tracking-wider">Admin</p>
                        <p class="text-4xl font-bold text-gray-900 mt-2">{{ number_format($stats['total_admins']) }}</p>
                        <p class="text-sm text-gray-500 mt-1">Admin & Super Admin</p>
                    </div>
                    <div class="bg-gray-100 rounded-full p-3">
                        <svg class="w-10 h-10 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Aksi Cepat</h2>
            <div class="grid grid-cols-4 gap-6">
                <a href="{{ route('superadmin.users') }}"
                    class="bg-white rounded-lg p-6 text-gray-900 border border-gray-200 hover:shadow-sm transition">
                    <svg class="w-12 h-12 mb-4 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    <h3 class="text-xl font-bold">Kelola User</h3>
                    <p class="text-sm text-gray-500 mt-2">Manajemen semua pengguna</p>
                </a>

                <a href="{{ route('superadmin.cities') }}"
                    class="bg-white rounded-lg p-6 text-gray-900 border border-gray-200 hover:shadow-sm transition">
                    <svg class="w-12 h-12 mb-4 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                    </svg>
                    <h3 class="text-xl font-bold">Kelola Kota</h3>
                    <p class="text-sm text-gray-500 mt-2">Manajemen kota layanan</p>
                </a>

                <a href="{{ route('superadmin.categories') }}"
                    class="bg-white rounded-lg p-6 text-gray-900 border border-gray-200 hover:shadow-sm transition">
                    <svg class="w-12 h-12 mb-4 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                    </svg>
                    <h3 class="text-xl font-bold">Kelola Kategori</h3>
                    <p class="text-sm text-gray-500 mt-2">Manajemen kategori</p>
                </a>

                <a href="{{ route('superadmin.verifications') }}"
                    class="bg-white rounded-lg p-6 text-gray-900 border border-gray-200 hover:shadow-sm transition">
                    <svg class="w-12 h-12 mb-4 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                    <h3 class="text-xl font-bold">Verifikasi KTP</h3>
                    <p class="text-sm text-gray-500 mt-2">Verifikasi identitas mitra</p>
                </a>
            </div>
        </div>
    </div>
</div>