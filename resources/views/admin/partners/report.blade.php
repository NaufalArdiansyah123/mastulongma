@extends('layouts.admin')

@section('content')
    <div class="bg-white shadow-sm border-b border-gray-200">
        <div class="px-8 py-6">
            <h1 class="text-3xl font-bold text-gray-900">Laporan Mitra</h1>
            <p class="text-sm text-gray-600 mt-1">Pantau aktivitas dan performa mitra berdasarkan rentang tanggal.</p>
        </div>
    </div>

    <div class="p-8">
        <!-- Filter & Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <!-- Periode Filter Card -->
            <div class="bg-white rounded-2xl shadow-md p-6 border border-gray-200">
                <label class="block text-sm font-semibold text-gray-700 mb-3">
                    <svg class="w-5 h-5 inline mr-2 text-primary-600" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    Periode Laporan
                </label>

                <form method="GET" action="{{ route('admin.partners.report') }}" class="space-y-3">
                    <div>
                        <label for="start_date" class="block text-xs font-medium text-gray-600 mb-1">Tanggal Mulai</label>
                        <input type="date" id="start_date" name="start_date" value="{{ $start }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                    </div>
                    <div>
                        <label for="end_date" class="block text-xs font-medium text-gray-600 mb-1">Tanggal Selesai</label>
                        <input type="date" id="end_date" name="end_date" value="{{ $end }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                    </div>
                    <button type="submit"
                        class="w-full inline-flex justify-center items-center px-4 py-2 bg-primary-600 text-white text-sm font-semibold rounded-xl shadow-sm hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                        Terapkan Filter
                    </button>
                </form>

                <div class="mt-4 text-xs text-gray-500">
                    <div>Periode aktif:</div>
                    <div class="font-semibold">{{ $start }} s/d {{ $end }}</div>
                </div>
            </div>

            <!-- Aktivitas Summary Card -->
            <div class="bg-white rounded-2xl shadow-md p-6 border border-gray-200 flex flex-col justify-between">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-3">
                        <svg class="w-5 h-5 inline mr-2 text-primary-600" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 11V3a1 1 0 012 0v8h3l-4 4-4-4h3z" />
                        </svg>
                        Ringkasan Aktivitas
                    </label>
                    <div class="space-y-2 text-sm">
                        <div class="flex items-center justify-between">
                            <span class="text-gray-500">Total Login</span>
                            <div class="text-right">
                                <div class="font-semibold text-gray-900 text-lg">{{ $totalLogins }}</div>
                                <div class="text-[11px] mt-0.5">
                                    @if ($loginTrend['direction'] === 'up')
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full bg-green-100 text-green-700 font-semibold">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7 7 7" />
                                            </svg>
                                            +{{ $loginTrend['percent'] }}%
                                        </span>
                                    @elseif ($loginTrend['direction'] === 'down')
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full bg-red-100 text-red-700 font-semibold">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7-7-7" />
                                            </svg>
                                            {{ $loginTrend['percent'] }}%
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full bg-gray-100 text-gray-600">
                                            Stabil
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-gray-500">Total Aktivitas</span>
                            <div class="text-right">
                                <div class="font-semibold text-gray-900 text-lg">{{ $totalActivities }}</div>
                                <div class="text-[11px] mt-0.5">
                                    @if ($activityTrend['direction'] === 'up')
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full bg-green-100 text-green-700 font-semibold">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7 7 7" />
                                            </svg>
                                            +{{ $activityTrend['percent'] }}%
                                        </span>
                                    @elseif ($activityTrend['direction'] === 'down')
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full bg-red-100 text-red-700 font-semibold">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7-7-7" />
                                            </svg>
                                            {{ $activityTrend['percent'] }}%
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full bg-gray-100 text-gray-600">
                                            Stabil
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <p class="mt-4 text-xs text-gray-400">Aktivitas dihitung dari tabel <code>partner_activities</code> dalam
                    periode terpilih.</p>
            </div>

            <!-- Mitra Summary Card -->
            <div class="bg-white rounded-2xl shadow-md p-6 border border-gray-200 flex flex-col justify-between">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-3">
                        <svg class="w-5 h-5 inline mr-2 text-primary-600" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 20h5v-2a4 4 0 00-5-4M9 20H4v-2a4 4 0 015-4m4-6a4 4 0 11-8 0 4 4 0 018 0zm6 0a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        Ringkasan Mitra
                    </label>
                    <div class="space-y-2 text-sm">
                        <div class="flex items-center justify-between">
                            <span class="text-gray-500">Mitra Aktif</span>
                            <span class="font-semibold text-gray-900 text-lg">{{ $activePartners }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-gray-500">Mitra Terblokir</span>
                            <span class="font-semibold text-gray-900 text-lg">{{ $blockedPartners }}</span>
                        </div>
                    </div>
                </div>
                <p class="mt-4 text-xs text-gray-400">Status diambil dari field <code>is_blocked</code> pada tabel
                    <code>users</code>.</p>
            </div>
        </div>

        <!-- Chart Card -->
        <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-200">
            <div class="flex items-center justify-between mb-4 flex-wrap gap-2">
                <div>
                    <h2 class="text-lg font-semibold text-gray-900">Grafik Aktivitas Mitra</h2>
                    <p class="text-xs text-gray-500 mt-1">Perbandingan total aktivitas dan login mitra per hari.</p>
                </div>
                <div class="flex items-center space-x-3 text-xs text-gray-500">
                    <span class="inline-flex items-center"><span
                            class="w-3 h-3 rounded-full bg-teal-400 mr-1"></span>Total Aktivitas</span>
                    <span class="inline-flex items-center"><span
                            class="w-3 h-3 rounded-full bg-amber-400 mr-1"></span>Login</span>
                </div>
            </div>

            <!-- Daily summary table -->
            <div class="mb-4 border border-gray-100 rounded-xl overflow-hidden">
                <div class="flex items-center justify-between px-3 py-2 bg-gray-50">
                    <h3 class="text-sm font-semibold text-gray-800">Ringkasan Harian</h3>
                    <p class="text-[11px] text-gray-500">Periode sekarang: {{ $start }} s/d {{ $end }}</p>
                </div>

                @if ($chartData->isEmpty())
                    <p class="px-3 py-3 text-xs text-gray-500">Belum ada aktivitas pada periode ini.</p>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-xs">
                            <thead>
                                <tr class="bg-gray-50 text-gray-500">
                                    <th class="px-3 py-2 text-left font-semibold">Tanggal</th>
                                    <th class="px-3 py-2 text-right font-semibold">Total Aktivitas</th>
                                    <th class="px-3 py-2 text-right font-semibold">Login</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 bg-white">
                                @foreach ($chartData as $row)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-3 py-2 text-gray-700">
                                            <a href="{{ route('admin.partners.activity', ['start_date' => $row->date, 'end_date' => $row->date]) }}"
                                                class="text-primary-600 hover:text-primary-700 hover:underline">
                                                {{ $row->date }}
                                            </a>
                                        </td>
                                        <td class="px-3 py-2 text-right text-gray-800 font-medium">{{ $row->total }}</td>
                                        <td class="px-3 py-2 text-right text-gray-800 font-medium">{{ $row->logins }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>

            <div class="h-80 relative">
                @if ($chartData->isEmpty())
                    <div class="absolute inset-0 flex items-center justify-center text-xs text-gray-400">
                        Belum ada data aktivitas untuk periode ini.
                    </div>
                @endif
                <canvas id="activityChart"></canvas>
            </div>
        </div>

        <div class="mt-6 bg-white rounded-2xl shadow-lg p-6 border border-gray-200">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h2 class="text-lg font-semibold text-gray-900">Top Mitra pada Periode Ini</h2>
                    <p class="text-xs text-gray-500 mt-1">Mitra dengan jumlah aktivitas terbanyak antara {{ $start }} s/d
                        {{ $end }}.</p>
                </div>
            </div>

            @if ($topPartners->isEmpty())
                <p class="text-xs text-gray-500">Belum ada aktivitas mitra pada periode ini.</p>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full text-xs">
                        <thead>
                            <tr class="bg-gray-50 text-gray-500">
                                <th class="px-3 py-2 text-left font-semibold">Mitra</th>
                                <th class="px-3 py-2 text-left font-semibold">Kota</th>
                                <th class="px-3 py-2 text-right font-semibold">Total Aktivitas</th>
                                <th class="px-3 py-2 text-right font-semibold">Login</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @foreach ($topPartners as $partner)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-3 py-2 text-gray-800 font-medium">
                                        @if ($partner->user)
                                            <a href="{{ route('admin.users.show', $partner->user) }}"
                                                class="text-primary-600 hover:text-primary-700 hover:underline">
                                                {{ $partner->user->name }}
                                            </a>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td class="px-3 py-2 text-gray-700">
                                        {{ optional($partner->user->city ?? null)->name ?? '-' }}
                                    </td>
                                    <td class="px-3 py-2 text-right text-gray-800 font-semibold">
                                        {{ $partner->total_activities }}
                                    </td>
                                    <td class="px-3 py-2 text-right text-gray-800 font-semibold">
                                        {{ $partner->login_count }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const chartRaw = @json($chartData);

        if (chartRaw.length > 0) {
            const labels = chartRaw.map(item => item.date);
            const totalData = chartRaw.map(item => item.total);
            const loginData = chartRaw.map(item => item.logins);

            const ctx = document.getElementById('activityChart').getContext('2d');
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [
                        {
                            label: 'Total Aktivitas',
                            data: totalData,
                            borderColor: 'rgba(75, 192, 192, 1)',
                            backgroundColor: 'rgba(75, 192, 192, 0.15)',
                            tension: 0.3,
                            fill: true,
                        },
                        {
                            label: 'Login',
                            data: loginData,
                            borderColor: 'rgba(255, 159, 64, 1)',
                            backgroundColor: 'rgba(255, 159, 64, 0.15)',
                            tension: 0.3,
                            fill: false,
                        }
                    ]
                },
                options: {
                    responsive: true,
                    interaction: {
                        mode: 'index',
                        intersect: false,
                    },
                    stacked: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            precision: 0
                        }
                    }
                }
            });
        }
    </script>
@endpush
