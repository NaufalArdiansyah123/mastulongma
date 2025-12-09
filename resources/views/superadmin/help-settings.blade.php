@php
    $title = 'Pengaturan Bantuan';
    $breadcrumb = 'Super Admin / Pengaturan / Bantuan';
@endphp

<div class="min-h-screen bg-gray-50">
    <div class="px-4 sm:px-6 py-8 sm:py-12 w-full">
        <!-- Description -->
        <div class="mb-6">
            <p class="text-sm text-gray-600">Kelola nominal minimal dan biaya admin untuk sistem bantuan</p>
        </div>

        <!-- Admin Fee Revenue Chart Section -->
        <div class="mb-8">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                <!-- Chart Header -->
                <div class="border-b border-gray-200 px-4 sm:px-8 py-6 bg-gray-50">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        <div>
                            <h2 class="text-lg sm:text-xl font-bold text-gray-900">Pendapatan Biaya Admin</h2>
                            <p class="text-sm text-gray-600 mt-1">Grafik pendapatan dari biaya admin (tidak termasuk nominal transaksi)</p>
                        </div>
                        <div class="bg-white rounded-lg px-4 py-2.5 border border-gray-200 shadow-sm sm:flex-shrink-0">
                            <p class="text-xs text-gray-600 font-medium">Total 30 Hari</p>
                            <p class="text-lg font-bold text-gray-900 mt-0.5">Rp
                                {{ number_format(collect($adminFeeChart['daily']['data'] ?? [])->sum(), 0, ',', '.') }}
                            </p>
                            <p class="text-xs text-green-600 font-medium mt-0.5">Hanya biaya admin</p>
                        </div>
                    </div>
                </div>

                <div class="p-4 sm:p-8">
                    <!-- Summary Cards -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-5 mb-6 sm:mb-8">
                        <div
                            class="bg-white rounded-xl p-4 sm:p-5 border border-gray-200 shadow-sm hover:shadow-md transition-all duration-200">
                            <div class="flex items-center gap-3 sm:gap-4">
                                <div
                                    class="w-10 h-10 sm:w-12 sm:h-12 rounded-lg flex items-center justify-center bg-gray-100 flex-shrink-0">
                                    <svg class="w-5 h-5 sm:w-6 sm:h-6 text-gray-700" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1" />
                                    </svg>
                                </div>
                                <div class="min-w-0">
                                    <div class="text-xs text-gray-600 font-medium mb-1">Total Biaya Admin</div>
                                    <div class="text-lg sm:text-xl font-bold text-gray-900 truncate">Rp
                                        {{ number_format($totalAll ?? 0, 0, ',', '.') }}
                                    </div>
                                    <div class="text-xs text-green-600 font-medium mt-0.5">Fee saja</div>
                                </div>
                            </div>
                        </div>

                        <div
                            class="bg-white rounded-xl p-4 sm:p-5 border border-gray-200 shadow-sm hover:shadow-md transition-all duration-200">
                            <div class="flex items-center gap-3 sm:gap-4">
                                <div
                                    class="w-10 h-10 sm:w-12 sm:h-12 rounded-lg flex items-center justify-center bg-gray-100 flex-shrink-0">
                                    <svg class="w-5 h-5 sm:w-6 sm:h-6 text-gray-700" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <div class="min-w-0">
                                    <div class="text-xs text-gray-600 font-medium mb-1">Biaya Admin 30 Hari</div>
                                    <div class="text-lg sm:text-xl font-bold text-gray-900 truncate">Rp
                                        {{ number_format($total30 ?? 0, 0, ',', '.') }}
                                    </div>
                                    <div class="text-xs text-green-600 font-medium mt-0.5">Fee saja</div>
                                </div>
                            </div>
                        </div>

                        <div
                            class="bg-white rounded-xl p-4 sm:p-5 border border-gray-200 shadow-sm hover:shadow-md transition-all duration-200">
                            <div class="flex items-center gap-3 sm:gap-4">
                                <div
                                    class="w-10 h-10 sm:w-12 sm:h-12 rounded-lg flex items-center justify-center bg-gray-100 flex-shrink-0">
                                    <svg class="w-5 h-5 sm:w-6 sm:h-6 text-gray-700" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                    </svg>
                                </div>
                                <div class="min-w-0">
                                    <div class="text-xs text-gray-600 font-medium mb-1">Biaya Admin Bulan Ini</div>
                                    <div class="text-lg sm:text-xl font-bold text-gray-900 truncate">Rp
                                        {{ number_format($totalMonth ?? 0, 0, ',', '.') }}
                                    </div>
                                    <div class="text-xs text-green-600 font-medium mt-0.5">Fee saja</div>
                                </div>
                            </div>
                        </div>

                        <div
                            class="bg-white rounded-xl p-4 sm:p-5 border border-gray-200 shadow-sm hover:shadow-md transition-all duration-200">
                            <div class="flex items-center gap-3 sm:gap-4">
                                <div
                                    class="w-10 h-10 sm:w-12 sm:h-12 rounded-lg flex items-center justify-center bg-gray-100 flex-shrink-0">
                                    <svg class="w-5 h-5 sm:w-6 sm:h-6 text-gray-700" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                    </svg>
                                </div>
                                <div class="min-w-0">
                                    <div class="text-xs text-gray-600 font-medium mb-1">Rata-rata Admin Fee</div>
                                    <div class="text-lg sm:text-xl font-bold text-gray-900">
                                        Rp {{ number_format($avgAdmin ?? 0, 0, ',', '.') }}
                                    </div>
                                    <div class="text-xs text-gray-500 mt-0.5">Per transaksi</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Chart Tabs -->
                    <div class="mb-6 overflow-x-auto">
                        <div id="adminFeeChartTabs" class="inline-flex bg-gray-100 rounded-lg p-1 min-w-max">
                            <button type="button" data-range="daily"
                                class="chart-range-tab px-4 sm:px-5 py-2 text-sm font-medium rounded-md transition-all duration-200 whitespace-nowrap">
                                Harian
                            </button>
                            <button type="button" data-range="monthly"
                                class="chart-range-tab px-4 sm:px-5 py-2 text-sm font-medium rounded-md transition-all duration-200 whitespace-nowrap">
                                Bulanan
                            </button>
                            <button type="button" data-range="yearly"
                                class="chart-range-tab px-4 sm:px-5 py-2 text-sm font-medium rounded-md transition-all duration-200 whitespace-nowrap">
                                Tahunan
                            </button>
                        </div>
                    </div>

                    <!-- Chart Container -->
                    <div class="w-full transition-all duration-500 ease-out bg-gray-50 rounded-xl p-4 sm:p-6 border border-gray-200"
                        id="adminFeeChartContainer">
                        <canvas id="adminFeeChart" height="140"></canvas>
                    </div>

                    <!-- Breakdown by Source -->
                    <div class="mt-6">
                        <h3 class="text-base font-bold text-gray-900 mb-4">Breakdown Sumber Biaya Admin</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Help (Bantuan) Breakdown -->
                            <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl p-5 border border-blue-200">
                                <div class="flex items-start justify-between mb-3">
                                    <div class="flex items-center gap-2">
                                        <div class="w-10 h-10 rounded-lg bg-blue-500 flex items-center justify-center">
                                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                    d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                            </svg>
                                        </div>
                                        <div>
                                            <h4 class="font-bold text-gray-900">Bantuan</h4>
                                            <p class="text-xs text-gray-600">Fee dari pembuatan bantuan</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="space-y-2">
                                    <div class="flex justify-between items-center">
                                        <span class="text-sm text-gray-700">Total Fee:</span>
                                        <span class="text-lg font-bold text-blue-700">
                                            Rp {{ number_format($breakdown['help']['total'] ?? 0, 0, ',', '.') }}
                                        </span>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <span class="text-sm text-gray-700">Jumlah Transaksi:</span>
                                        <span class="font-semibold text-gray-900">
                                            {{ number_format($breakdown['help']['count'] ?? 0, 0, ',', '.') }} bantuan
                                        </span>
                                    </div>
                                    <div class="flex justify-between items-center pt-2 border-t border-blue-200">
                                        <span class="text-sm text-gray-700">Rata-rata Fee:</span>
                                        <span class="font-semibold text-gray-900">
                                            Rp {{ number_format($breakdown['help']['avg'] ?? 0, 0, ',', '.') }}
                                        </span>
                                    </div>
                                    <div class="mt-3 pt-3 border-t border-blue-200">
                                        <div class="flex items-center justify-between text-xs text-gray-600">
                                            <span>Kontribusi terhadap total:</span>
                                            <span class="font-bold text-blue-700">
                                                {{ $totalAll > 0 ? number_format(($breakdown['help']['total'] / $totalAll) * 100, 1) : 0 }}%
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Top-up Breakdown -->
                            <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-xl p-5 border border-green-200">
                                <div class="flex items-start justify-between mb-3">
                                    <div class="flex items-center gap-2">
                                        <div class="w-10 h-10 rounded-lg bg-green-500 flex items-center justify-center">
                                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1" />
                                            </svg>
                                        </div>
                                        <div>
                                            <h4 class="font-bold text-gray-900">Top-up Saldo</h4>
                                            <p class="text-xs text-gray-600">Fee dari pengisian saldo</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="space-y-2">
                                    <div class="flex justify-between items-center">
                                        <span class="text-sm text-gray-700">Total Fee:</span>
                                        <span class="text-lg font-bold text-green-700">
                                            Rp {{ number_format($breakdown['topup']['total'] ?? 0, 0, ',', '.') }}
                                        </span>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <span class="text-sm text-gray-700">Jumlah Transaksi:</span>
                                        <span class="font-semibold text-gray-900">
                                            {{ number_format($breakdown['topup']['count'] ?? 0, 0, ',', '.') }} top-up
                                        </span>
                                    </div>
                                    <div class="flex justify-between items-center pt-2 border-t border-green-200">
                                        <span class="text-sm text-gray-700">Rata-rata Fee:</span>
                                        <span class="font-semibold text-gray-900">
                                            Rp {{ number_format($breakdown['topup']['avg'] ?? 0, 0, ',', '.') }}
                                        </span>
                                    </div>
                                    <div class="mt-3 pt-3 border-t border-green-200">
                                        <div class="flex items-center justify-between text-xs text-gray-600">
                                            <span>Kontribusi terhadap total:</span>
                                            <span class="font-bold text-green-700">
                                                {{ $totalAll > 0 ? number_format(($breakdown['topup']['total'] / $totalAll) * 100, 1) : 0 }}%
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Settings Form Section -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="border-b border-gray-200 px-4 sm:px-8 py-6 bg-gray-50">
                <h2 class="text-lg sm:text-xl font-bold text-gray-900">Konfigurasi Bantuan</h2>
                <p class="text-sm text-gray-600 mt-1">Atur nominal minimal dan biaya admin untuk sistem bantuan</p>
            </div>

            <div class="p-4 sm:p-8">
                @if(session()->has('message'))
                    <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg">
                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-green-600 flex-shrink-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span class="text-green-800 font-medium text-sm">{{ session('message') }}</span>
                        </div>
                    </div>
                @endif

                <form wire:submit.prevent="save" class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-900 mb-2">Nominal Minimal (Rp)</label>
                        <input type="number" wire:model.defer="min_help_nominal" placeholder="10000"
                            class="w-full px-4 py-3 bg-white border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-gray-900 focus:border-gray-900 transition-all" />
                        @error('min_help_nominal')
                            <div class="flex items-center gap-2 mt-2 text-red-600 text-sm">
                                <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                        clip-rule="evenodd" />
                                </svg>
                                {{ $message }}
                            </div>
                        @enderror
                        <p class="text-xs text-gray-500 mt-2">Customer tidak bisa membuat bantuan dengan nominal di
                            bawah nilai ini</p>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-900 mb-2">Biaya Admin (Rp)</label>
                        <input type="number" wire:model.defer="admin_fee" placeholder="0"
                            class="w-full px-4 py-3 bg-white border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-gray-900 focus:border-gray-900 transition-all" />
                        @error('admin_fee')
                            <div class="flex items-center gap-2 mt-2 text-red-600 text-sm">
                                <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                        clip-rule="evenodd" />
                                </svg>
                                {{ $message }}
                            </div>
                        @enderror
                        <p class="text-xs text-gray-500 mt-2">Biaya tambahan yang dikenakan ke customer saat membuat
                            bantuan</p>
                    </div>

                    <div class="lg:col-span-2 pt-2">
                        <button type="submit"
                            class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-gray-900 text-white rounded-lg text-sm font-semibold hover:bg-gray-800 transition-all shadow-sm hover:shadow w-full sm:w-auto">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            Simpan Pengaturan
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Top-Up Fees Settings Section -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden mt-8">
            <div class="border-b border-gray-200 px-4 sm:px-8 py-6 bg-gray-50">
                <h2 class="text-lg sm:text-xl font-bold text-gray-900">Konfigurasi Biaya Admin Top-Up</h2>
                <p class="text-sm text-gray-600 mt-1">Atur biaya admin berdasarkan nominal top-up (3 tier)</p>
            </div>

            <div class="p-4 sm:p-8">
                <!-- Info Box -->
                {{-- <div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                    <div class="flex gap-3">
                        <svg class="w-5 h-5 text-blue-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                clip-rule="evenodd" />
                        </svg>
                        <div>
                            <h3 class="text-sm font-semibold text-blue-900 mb-1">Logika Perhitungan:</h3>
                            <ul class="text-sm text-blue-800 space-y-1">
                                <li>• <strong>Tier 1:</strong> Nominal &lt; Tier 1 Limit → Biaya = Tier 1 Fee</li>
                                <li>• <strong>Tier 2:</strong> Tier 1 Limit ≤ Nominal &lt; Tier 2 Limit → Biaya = Tier 2 Fee</li>
                                <li>• <strong>Tier 3:</strong> Nominal ≥ Tier 2 Limit → Biaya = Nominal × (Tier 3 % / 100), maksimal Tier 3 Max</li>
                            </ul>
                        </div>
                    </div>
                </div> --}}

                <form wire:submit.prevent="save" class="space-y-6">
                    <!-- Tier 1 Settings -->
                    <div class="border border-gray-200 rounded-lg p-4 sm:p-6 bg-gray-50">
                        <h3 class="text-md font-bold text-gray-900 mb-4 flex items-center gap-2">
                            <span class="bg-gray-900 text-white w-7 h-7 rounded-full flex items-center justify-center text-sm">1</span>
                            Tier 1 - Nominal Kecil
                        </h3>
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-gray-900 mb-2">Batas Maksimal Tier 1 (Rp)</label>
                                <input type="number" wire:model.defer="tier1_limit" placeholder="50000"
                                    class="w-full px-4 py-3 bg-white border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-gray-900 focus:border-gray-900 transition-all" />
                                @error('tier1_limit')
                                    <div class="flex items-center gap-2 mt-2 text-red-600 text-sm">
                                        <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        {{ $message }}
                                    </div>
                                @enderror
                                <p class="text-xs text-gray-500 mt-2">Nominal top-up di bawah nilai ini menggunakan biaya tier 1</p>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-900 mb-2">Biaya Admin Tier 1 (Rp)</label>
                                <input type="number" wire:model.defer="tier1_fee" placeholder="5000"
                                    class="w-full px-4 py-3 bg-white border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-gray-900 focus:border-gray-900 transition-all" />
                                @error('tier1_fee')
                                    <div class="flex items-center gap-2 mt-2 text-red-600 text-sm">
                                        <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        {{ $message }}
                                    </div>
                                @enderror
                                <p class="text-xs text-gray-500 mt-2">Biaya tetap untuk nominal di bawah Rp {{ number_format($tier1_limit ?? 50000, 0, ',', '.') }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Tier 2 Settings -->
                    <div class="border border-gray-200 rounded-lg p-4 sm:p-6 bg-gray-50">
                        <h3 class="text-md font-bold text-gray-900 mb-4 flex items-center gap-2">
                            <span class="bg-gray-900 text-white w-7 h-7 rounded-full flex items-center justify-center text-sm">2</span>
                            Tier 2 - Nominal Menengah
                        </h3>
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-gray-900 mb-2">Batas Maksimal Tier 2 (Rp)</label>
                                <input type="number" wire:model.defer="tier2_limit" placeholder="100000"
                                    class="w-full px-4 py-3 bg-white border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-gray-900 focus:border-gray-900 transition-all" />
                                @error('tier2_limit')
                                    <div class="flex items-center gap-2 mt-2 text-red-600 text-sm">
                                        <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        {{ $message }}
                                    </div>
                                @enderror
                                <p class="text-xs text-gray-500 mt-2">Nominal top-up di bawah nilai ini menggunakan biaya tier 2</p>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-900 mb-2">Biaya Admin Tier 2 (Rp)</label>
                                <input type="number" wire:model.defer="tier2_fee" placeholder="7500"
                                    class="w-full px-4 py-3 bg-white border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-gray-900 focus:border-gray-900 transition-all" />
                                @error('tier2_fee')
                                    <div class="flex items-center gap-2 mt-2 text-red-600 text-sm">
                                        <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        {{ $message }}
                                    </div>
                                @enderror
                                <p class="text-xs text-gray-500 mt-2">Biaya tetap untuk nominal Rp {{ number_format($tier1_limit ?? 50000, 0, ',', '.') }} - Rp {{ number_format($tier2_limit ?? 100000, 0, ',', '.') }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Tier 3 Settings -->
                    <div class="border border-gray-200 rounded-lg p-4 sm:p-6 bg-gray-50">
                        <h3 class="text-md font-bold text-gray-900 mb-4 flex items-center gap-2">
                            <span class="bg-gray-900 text-white w-7 h-7 rounded-full flex items-center justify-center text-sm">3</span>
                            Tier 3 - Nominal Besar (Persentase)
                        </h3>
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-gray-900 mb-2">Persentase Biaya Admin (%)</label>
                                <input type="number" step="0.01" wire:model.defer="tier3_percentage" placeholder="3"
                                    class="w-full px-4 py-3 bg-white border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-gray-900 focus:border-gray-900 transition-all" />
                                @error('tier3_percentage')
                                    <div class="flex items-center gap-2 mt-2 text-red-600 text-sm">
                                        <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        {{ $message }}
                                    </div>
                                @enderror
                                <p class="text-xs text-gray-500 mt-2">Persentase dari nominal top-up (untuk nominal ≥ Rp {{ number_format($tier2_limit ?? 100000, 0, ',', '.') }})</p>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-900 mb-2">Biaya Maksimal Tier 3 (Rp)</label>
                                <input type="number" wire:model.defer="tier3_max" placeholder="15000"
                                    class="w-full px-4 py-3 bg-white border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-gray-900 focus:border-gray-900 transition-all" />
                                @error('tier3_max')
                                    <div class="flex items-center gap-2 mt-2 text-red-600 text-sm">
                                        <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        {{ $message }}
                                    </div>
                                @enderror
                                <p class="text-xs text-gray-500 mt-2">Batas maksimal biaya admin untuk tier 3 (cap)</p>
                            </div>
                        </div>
                    </div>
                    <!-- Submit Button -->
                    <div class="pt-2">
                        <button type="submit"
                            class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-gray-900 text-white rounded-lg text-sm font-semibold hover:bg-gray-800 transition-all shadow-sm hover:shadow w-full sm:w-auto">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            Simpan Semua Pengaturan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js -->
@php
    $adminFeeChartJson = json_encode($adminFeeChart ?? ['daily' => ['labels' => [], 'data' => []], 'monthly' => ['labels' => [], 'data' => []], 'yearly' => ['labels' => [], 'data' => []]]);
@endphp
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const chartData = {!! $adminFeeChartJson !!};

        const ctx = document.getElementById('adminFeeChart').getContext('2d');
        let adminChart = null;

        function renderRange(range) {
            const container = document.getElementById('adminFeeChartContainer');
            container.style.opacity = '0';
            container.style.transform = 'translateY(10px) scale(0.99)';

            setTimeout(() => {
                const labels = chartData[range].labels || [];
                const data = chartData[range].data || [];

                const gradient = ctx.createLinearGradient(0, 0, 0, 200);
                gradient.addColorStop(0, 'rgba(17, 24, 39, 0.9)');
                gradient.addColorStop(1, 'rgba(55, 65, 81, 0.7)');

                const cfg = {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Pendapatan Biaya Admin',
                            data: data,
                            backgroundColor: gradient,
                            borderColor: 'rgba(17, 24, 39, 1)',
                            borderWidth: 1,
                            borderRadius: 6,
                            maxBarThickness: 40
                        }]
                    },
                    options: {
                        plugins: {
                            legend: { display: false },
                            tooltip: {
                                backgroundColor: 'rgba(17, 24, 39, 0.95)',
                                padding: 12,
                                titleColor: '#fff',
                                bodyColor: '#e5e7eb',
                                borderColor: 'rgba(55, 65, 81, 0.3)',
                                borderWidth: 1,
                                cornerRadius: 6,
                                callbacks: {
                                    label: function (ctx) {
                                        const v = ctx.raw ?? ctx.parsed?.y ?? 0;
                                        return 'Rp ' + Number(v).toLocaleString();
                                    }
                                }
                            }
                        },
                        scales: {
                            x: {
                                grid: { display: false },
                                ticks: {
                                    autoSkip: true,
                                    maxRotation: 45,
                                    font: { size: 11 },
                                    color: '#6b7280'
                                }
                            },
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    callback: function (v) { return 'Rp ' + Number(v).toLocaleString(); },
                                    font: { size: 11 },
                                    color: '#6b7280'
                                },
                                grid: { color: 'rgba(156, 163, 175, 0.15)' }
                            }
                        },
                        responsive: true,
                        maintainAspectRatio: false,
                    }
                };

                if (adminChart) adminChart.destroy();
                adminChart = new Chart(ctx, cfg);

                setTimeout(() => {
                    container.style.opacity = '1';
                    container.style.transform = 'translateY(0) scale(1)';
                }, 120);
            }, 100);
        }

        const tabs = document.querySelectorAll('.chart-range-tab');
        const valid = ['daily', 'monthly', 'yearly'];
        let initial = 'daily';
        const saved = localStorage.getItem('superadmin.adminFeeChart.range');
        if (saved && valid.includes(saved)) initial = saved;

        function setActive(r) {
            tabs.forEach(t => {
                if (t.dataset.range === r) {
                    t.classList.add('bg-white', 'text-gray-900', 'shadow-sm');
                    t.classList.remove('text-gray-600');
                } else {
                    t.classList.remove('bg-white', 'text-gray-900', 'shadow-sm');
                    t.classList.add('text-gray-600');
                }
            });
        }

        if (tabs.length) {
            tabs.forEach(t => t.addEventListener('click', function () {
                const r = t.dataset.range;
                if (!valid.includes(r)) return;
                setActive(r);
                localStorage.setItem('superadmin.adminFeeChart.range', r);
                renderRange(r);
            }));
            setActive(initial);
            renderRange(initial);
        } else {
            renderRange('daily');
        }
    });
</script>