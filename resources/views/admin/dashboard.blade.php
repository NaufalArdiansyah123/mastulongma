<div>
    <header class="bg-white shadow-sm border-b border-gray-200 sticky top-0 z-10">
        <div class="px-8 py-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Dashboard Admin</h1>
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
        <div class="grid grid-cols-3 gap-8 mb-8">
            <!-- Total Helps -->
            <div class="bg-white rounded-2xl shadow-lg p-10 border-l-4 border-primary-600">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-semibold text-gray-600 uppercase tracking-wider">Total Bantuan</p>
                        <p class="text-5xl font-bold text-gray-900 mt-4">{{ number_format($totalHelps) }}</p>
                        <p class="text-sm text-gray-500 mt-2">Semua permintaan bantuan</p>
                    </div>
                    <div class="bg-primary-100 rounded-full p-6">
                        <svg class="w-20 h-20 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Pending Helps -->
            <div class="bg-white rounded-2xl shadow-lg p-10 border-l-4 border-yellow-600">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-semibold text-gray-600 uppercase tracking-wider">Pending</p>
                        <p class="text-5xl font-bold text-gray-900 mt-4">{{ number_format($pendingHelps) }}</p>
                        <p class="text-sm text-gray-500 mt-2">Menunggu moderasi</p>
                    </div>
                    <div class="bg-yellow-100 rounded-full p-6">
                        <svg class="w-20 h-20 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Active Helps -->
            <div class="bg-white rounded-2xl shadow-lg p-10 border-l-4 border-green-600">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-semibold text-gray-600 uppercase tracking-wider">Aktif</p>
                        <p class="text-5xl font-bold text-gray-900 mt-4">{{ number_format($activeHelps) }}</p>
                        <p class="text-sm text-gray-500 mt-2">Sedang berjalan</p>
                    </div>
                    <div class="bg-green-100 rounded-full p-6">
                        <svg class="w-20 h-20 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Second Row Stats -->
        <div class="grid grid-cols-3 gap-8 mb-8">
            <!-- Completed Helps -->
            <div class="bg-white rounded-2xl shadow-lg p-10 border-l-4 border-blue-600">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-semibold text-gray-600 uppercase tracking-wider">Selesai</p>
                        <p class="text-5xl font-bold text-gray-900 mt-4">{{ number_format($completedHelps) }}</p>
                        <p class="text-sm text-gray-500 mt-2">Bantuan selesai</p>
                    </div>
                    <div class="bg-blue-100 rounded-full p-6">
                        <svg class="w-20 h-20 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Pending Verifications -->
            <div class="bg-white rounded-2xl shadow-lg p-10 border-l-4 border-orange-600">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-semibold text-gray-600 uppercase tracking-wider">KTP Pending</p>
                        <p class="text-5xl font-bold text-gray-900 mt-4">{{ number_format($pendingVerifications) }}</p>
                        <p class="text-sm text-gray-500 mt-2">Menunggu verifikasi</p>
                    </div>
                    <div class="bg-orange-100 rounded-full p-6">
                        <svg class="w-20 h-20 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Verified Mitras -->
            <div class="bg-white rounded-2xl shadow-lg p-10 border-l-4 border-teal-600">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-semibold text-gray-600 uppercase tracking-wider">Mitra Terverifikasi</p>
                        <p class="text-5xl font-bold text-gray-900 mt-4">{{ number_format($verifiedMitras) }}</p>
                        <p class="text-sm text-gray-500 mt-2">KTP sudah diverifikasi</p>
                    </div>
                    <div class="bg-teal-100 rounded-full p-6">
                        <svg class="w-20 h-20 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white rounded-2xl shadow-lg p-10">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Aksi Cepat</h2>
            <div class="grid grid-cols-2 gap-6">
                <a href="{{ route('admin.helps') }}"
                    class="bg-gradient-to-br from-primary-500 to-primary-600 rounded-xl p-8 text-white hover:shadow-xl transition transform hover:-translate-y-1">
                    <svg class="w-16 h-16 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <h3 class="text-xl font-bold">Moderasi Bantuan</h3>
                    <p class="text-sm opacity-90 mt-2">Review dan setujui permintaan bantuan</p>
                </a>

                <a href="{{ route('admin.verifications') }}"
                    class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl p-8 text-white hover:shadow-xl transition transform hover:-translate-y-1">
                    <svg class="w-16 h-16 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                    <h3 class="text-xl font-bold">Verifikasi KTP</h3>
                    <p class="text-sm opacity-90 mt-2">Verifikasi identitas mitra</p>
                </a>
            </div>
        </div>
    </div>
</div>