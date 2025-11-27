@extends('layouts.admin')

@section('content')
    @php
        // Collect stats server-side. Adjust model/column names if your app differs.
        $totalHelps = class_exists(\App\Models\Help::class) ? \App\Models\Help::count() : 0;
        $pendingHelps = class_exists(\App\Models\Help::class) ? \App\Models\Help::where('status', 'pending')->count() : 0;
        $activeHelps = class_exists(\App\Models\Help::class) ? \App\Models\Help::where('status', 'active')->count() : 0;
        $completedHelps = class_exists(\App\Models\Help::class) ? \App\Models\Help::where('status', 'completed')->count() : 0;

        // KTP verification fields may vary; this is a best-effort guess.
        if (class_exists(\App\Models\User::class)) {
            try {
                $pendingVerifications = \App\Models\User::whereNull('ktp_verified_at')->count();
                $verifiedMitras = \App\Models\User::whereNotNull('ktp_verified_at')->count();
            } catch (\Throwable $e) {
                $pendingVerifications = 0;
                $verifiedMitras = 0;
            }
        } else {
            $pendingVerifications = 0;
            $verifiedMitras = 0;
        }

        $latestHelps = class_exists(\App\Models\Help::class) ? \App\Models\Help::latest()->take(6)->get() : collect();

        // prepare chart data for last 7 days
        $chartLabels = [];
        $chartData = [];
        for ($i = 6; $i >= 0; $i--) {
            $day = now()->subDays($i);
            $chartLabels[] = $day->format('j M');
            if (class_exists(\App\Models\Help::class)) {
                $chartData[] = \App\Models\Help::whereDate('created_at', $day->toDateString())->count();
            } else {
                $chartData[] = 0;
            }
        }
    @endphp

    <div class="min-h-screen bg-gray-50">
        <div class="px-6 py-8">
            <!-- Header -->
            <div class="flex items-start justify-between mb-6">
                <div>
                    <h1 class="text-3xl font-extrabold text-gray-900">Admin Dashboard</h1>
                    <p class="text-sm text-gray-600 mt-1">Halo, {{ auth()->user()->name }} — berikut ringkasan sistem hari
                        ini.</p>
                </div>

                <div class="flex items-center gap-4">
                    <div class="text-sm text-gray-500">{{ now()->isoFormat('dddd, D MMMM Y') }}</div>
                    <div class="relative">
                        @php
                            $unreadNotifications = auth()->check() ? auth()->user()->unreadNotifications()->count() : 0;
                        @endphp
                        <a href="{{ route('customer.notifications.index') }}"
                            class="text-gray-600 hover:text-gray-800 flex items-center" aria-label="Notifications">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                            </svg>
                            @if($unreadNotifications > 0)
                                <span
                                    class="absolute -top-1 -right-1 inline-flex items-center justify-center px-1.5 py-0.5 text-xs font-semibold text-white bg-red-600 rounded-full">{{ $unreadNotifications > 99 ? '99+' : $unreadNotifications }}</span>
                            @endif
                        </a>
                    </div>
                </div>
            </div>

            <!-- Top Stat Cards (compact) -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-4 mb-6">
                <div class="bg-white rounded-lg shadow p-4 flex items-center gap-4">
                    <div class="w-12 h-12 rounded-lg flex items-center justify-center shadow-sm"
                        style="background: linear-gradient(135deg,#eef2ff,#e0f2fe);">
                        <svg class="w-6 h-6 text-black" fill="none" stroke="currentColor" stroke-width="1.6"
                            stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                            <path d="M21 16V8a2 2 0 0 0-2-2h-3l-2-2H10L8 6H5a2 2 0 0 0-2 2v8" />
                            <rect x="3" y="8" width="18" height="10" rx="2" ry="2" fill="none" />
                        </svg>
                    </div>
                    <div>
                        <div class="text-xs text-gray-500">Total Bantuan</div>
                        <div class="text-lg font-bold text-gray-900">{{ number_format($totalHelps) }}</div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow p-4 flex items-center gap-4">
                    <div class="w-12 h-12 rounded-lg flex items-center justify-center shadow-sm"
                        style="background: linear-gradient(135deg,#fff7ed,#ffedd5);">
                        <svg class="w-6 h-6 text-black" fill="none" stroke="currentColor" stroke-width="1.6"
                            stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                            <path d="M12 8v4l3 3" />
                            <circle cx="12" cy="12" r="9" fill="none" />
                        </svg>
                    </div>
                    <div>
                        <div class="text-xs text-gray-500">Pending</div>
                        <div class="text-lg font-bold text-yellow-600">{{ number_format($pendingHelps) }}</div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow p-4 flex items-center gap-4">
                    <div class="w-12 h-12 rounded-lg flex items-center justify-center shadow-sm"
                        style="background: linear-gradient(135deg,#ecfdf5,#bbf7d0);">
                        <svg class="w-6 h-6 text-black" fill="none" stroke="currentColor" stroke-width="1.6"
                            stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                            <path d="M20 6L9 17l-5-5" />
                        </svg>
                    </div>
                    <div>
                        <div class="text-xs text-gray-500">Aktif</div>
                        <div class="text-lg font-bold text-green-600">{{ number_format($activeHelps) }}</div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow p-4 flex items-center gap-4">
                    <div class="w-12 h-12 rounded-lg flex items-center justify-center shadow-sm"
                        style="background: linear-gradient(135deg,#eff6ff,#dbeafe);">
                        <svg class="w-6 h-6 text-black" fill="none" stroke="currentColor" stroke-width="1.6"
                            stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                            <path d="M20 6L9 17l-5-5" />
                        </svg>
                    </div>
                    <div>
                        <div class="text-xs text-gray-500">Selesai</div>
                        <div class="text-lg font-bold text-gray-900">{{ number_format($completedHelps) }}</div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow p-4 flex items-center gap-4">
                    <div class="w-12 h-12 rounded-lg flex items-center justify-center shadow-sm"
                        style="background: linear-gradient(135deg,#fff7ed,#ffedd5);">
                        <svg class="w-6 h-6 text-black" fill="none" stroke="currentColor" stroke-width="1.6"
                            stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                            <path d="M12 8v4l3 3" />
                            <rect x="3" y="3" width="18" height="18" rx="2" ry="2" fill="none" />
                        </svg>
                    </div>
                    <div>
                        <div class="text-xs text-gray-500">KTP Pending</div>
                        <div class="text-lg font-bold text-orange-600">{{ number_format($pendingVerifications) }}</div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow p-4 flex items-center gap-4">
                    <div class="w-12 h-12 rounded-lg flex items-center justify-center shadow-sm"
                        style="background: linear-gradient(135deg,#ecfeff,#bbf7d0);">
                        <svg class="w-6 h-6 text-black" fill="none" stroke="currentColor" stroke-width="1.6"
                            stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                            <path d="M20 6L9 17l-5-5" />
                        </svg>
                    </div>
                    <div>
                        <div class="text-xs text-gray-500">Mitra Terverifikasi</div>
                        <div class="text-lg font-bold text-teal-600">{{ number_format($verifiedMitras) }}</div>
                    </div>
                </div>
            </div>

            <!-- Stats + Chart -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
                <div class="lg:col-span-2 bg-white rounded-2xl shadow p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-lg font-semibold text-gray-800">Aktivitas Terakhir</h2>
                        <div class="text-xs text-gray-500">Update otomatis</div>
                    </div>

                    <div class="h-56 bg-gray-50 rounded-md border border-dashed border-gray-100 p-4">
                        <canvas id="activityChart" class="w-full h-full"></canvas>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow p-6">
                    <h3 class="text-sm font-semibold text-gray-600 uppercase tracking-wide">Ringkasan</h3>
                    <div class="mt-4 space-y-3">
                        <div class="flex items-center justify-between">
                            <div class="text-sm text-gray-600">Total Bantuan</div>
                            <div class="text-xl font-bold text-gray-900">{{ number_format($totalHelps) }}</div>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="text-sm text-gray-600">Pending</div>
                            <div class="text-xl font-bold text-yellow-600">{{ number_format($pendingHelps) }}</div>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="text-sm text-gray-600">Aktif</div>
                            <div class="text-xl font-bold text-green-600">{{ number_format($activeHelps) }}</div>
                        </div>
                        <hr class="my-2" />
                        <div class="flex items-center justify-between text-sm text-gray-600">
                            <span>Verifikasi KTP Pending</span>
                            <span class="font-medium">{{ number_format($pendingVerifications) }}</span>
                        </div>
                        <div class="flex items-center justify-between text-sm text-gray-600">
                            <span>Mitra Terverifikasi</span>
                            <span class="font-medium">{{ number_format($verifiedMitras) }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Real-time cards (Livewire) -->
            <div class="mb-6">
                <livewire:admin.dashboard-cards />
            </div>

            <!-- Recent Helps + Health -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mt-6 mb-6">
                <div class="lg:col-span-3 bg-white rounded-2xl shadow p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-gray-800">Permintaan Bantuan Terbaru</h3>
                        <a href="{{ route('admin.helps') }}" class="text-sm text-primary-600">Lihat semua</a>
                    </div>

                    @if(isset($latestHelps) && $latestHelps->count())
                        <div class="overflow-x-auto">
                            <table class="w-full text-left text-sm">
                                <thead class="text-xs text-gray-500 uppercase">
                                    <tr>
                                        <th class="pb-3">Order ID</th>
                                        <th class="pb-3">User</th>
                                        <th class="pb-3">Status</th>
                                        <th class="pb-3">Jumlah</th>
                                        <th class="pb-3">Waktu</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y">
                                    @foreach($latestHelps as $help)
                                        <tr class="align-top">
                                            <td class="py-3 text-gray-800">{{ $help->order_id ?? $help->id }}</td>
                                            <td class="py-3 text-gray-600">{{ optional($help->user)->name ?? '-' }}</td>
                                            <td class="py-3"><span
                                                    class="px-2 py-1 text-xs rounded {{ $help->status === 'pending' ? 'bg-yellow-100 text-yellow-700' : ($help->status === 'completed' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-700') }}">{{ ucfirst($help->status) }}</span>
                                            </td>
                                            <td class="py-3 text-gray-800">Rp {{ number_format($help->amount ?? 0, 0, ',', '.') }}
                                            </td>
                                            <td class="py-3 text-gray-500">{{ $help->created_at->diffForHumans() }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-8 text-gray-500">Belum ada permintaan bantuan terbaru.</div>
                    @endif
                </div>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            (function () {
                const ctx = document.getElementById('activityChart');
                if (!ctx) return;

                const data = {
                    labels: @json($chartLabels),
                    datasets: [{
                        label: 'Permintaan Bantuan',
                        backgroundColor: 'rgba(59,130,246,0.08)',
                        borderColor: 'rgba(59,130,246,1)',
                        pointBackgroundColor: 'rgba(59,130,246,1)',
                        data: @json($chartData),
                        fill: true,
                        tension: 0.3,
                    }]
                };

                new Chart(ctx.getContext('2d'), {
                    type: 'line',
                    data: data,
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { display: false }
                        },
                        scales: {
                            x: { grid: { display: false }, ticks: { color: '#6B7280' } },
                            y: { grid: { color: 'rgba(203,213,225,0.3)' }, ticks: { color: '#6B7280' } }
                        }
                    }
                });
            })();

            // Carousel for banner
            (function () {
                const carousel = document.getElementById('dashboardCarousel');
                if (!carousel) return;

                const track = carousel.querySelector('div.flex.transition-transform');
                const slides = Array.from(track.children).filter(el => el.classList);
                const indicators = Array.from(carousel.querySelectorAll('.carousel-indicator'));
                const prevBtn = carousel.querySelector('#carouselPrev');
                const nextBtn = carousel.querySelector('#carouselNext');
                let current = 0;
                const total = slides.length;
                let interval = null;

                function updateIndicators() {
                    indicators.forEach((b, idx) => {
                        if (idx === current) {
                            b.classList.remove('bg-white/40');
                            b.classList.add('bg-white/80');
                        } else {
                            b.classList.remove('bg-white/80');
                            b.classList.add('bg-white/40');
                        }
                    });
                }

                function go(index) {
                    current = (index + total) % total;
                    track.style.transform = `translateX(${-100 * current}%)`;
                    updateIndicators();
                }

                function resetInterval() {
                    if (interval) clearInterval(interval);
                    interval = setInterval(() => go(current + 1), 4200);
                }

                prevBtn.addEventListener('click', () => { go(current - 1); resetInterval(); });
                nextBtn.addEventListener('click', () => { go(current + 1); resetInterval(); });

                indicators.forEach(btn => {
                    btn.addEventListener('click', () => { go(parseInt(btn.dataset.index)); resetInterval(); });
                });

                go(0);
                resetInterval();
            })();
        </script>
    </div>
@endsection