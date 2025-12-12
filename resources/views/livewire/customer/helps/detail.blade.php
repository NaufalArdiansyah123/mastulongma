<div class="min-h-screen bg-gray-50" 
    wire:poll.5s="{{ in_array($help->status, ['memperoleh_mitra', 'taken', 'partner_on_the_way', 'partner_arrived', 'in_progress', 'sedang_diproses']) ? 'loadHelp' : '' }}"
    x-data="{ 
        showNotification: false, 
        notificationMessage: '' 
    }"
    @show-status-notification.window="
        notificationMessage = $event.detail.message;
        showNotification = true;
        setTimeout(() => showNotification = false, 5000);
    "
>
    {{-- Status Notification --}}
    <div x-show="showNotification" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 transform translate-y-2"
         x-transition:enter-end="opacity-100 transform translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed top-20 left-1/2 transform -translate-x-1/2 z-50 max-w-sm w-full px-4"
         style="display: none;">
        <div class="bg-white rounded-xl shadow-2xl border border-gray-200 p-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="flex-1">
                    <p class="text-sm font-semibold text-gray-900" x-text="notificationMessage"></p>
                    <p class="text-xs text-gray-500 mt-0.5">Status pesanan diperbarui</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Header - match other customer pages (gradient BRImo style) --}}
    <div class="px-5 pt-5 pb-8 relative overflow-hidden" style="background: linear-gradient(to bottom right, #0098e7, #0077cc, #0060b0);">
        <div class="absolute top-0 right-0 w-40 h-40 bg-white/5 rounded-full -mr-20 -mt-20"></div>
        <div class="absolute bottom-0 left-0 w-32 h-32 bg-white/5 rounded-full -ml-16 -mb-16"></div>

        <div class="relative z-10 max-w-md mx-auto">
            <div class="flex items-center justify-between text-white mb-6">
                <button onclick="window.history.back()" aria-label="Kembali" class="p-2 hover:bg-white/20 rounded-lg transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>

                <div class="text-center flex-1 px-2">
                    <h1 class="text-lg font-bold">Detail Pesanan</h1>
                    <p class="text-xs text-white/90 mt-0.5">Detail permintaan bantuan Anda</p>
                </div>

                <div class="w-9">
                    <button class="p-2 hover:bg-white/20 rounded-lg transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

            <!-- Curved separator (SVG) to create non-flat divider into content -->
            <svg class="absolute bottom-0 left-0 w-full" viewBox="0 0 1440 72" preserveAspectRatio="none" aria-hidden="true">
                <path d="M0,32 C360,72 1080,0 1440,40 L1440,72 L0,72 Z" fill="#ffffff"></path>
            </svg>
    </div>

    <!-- Content -->
    <div class="bg-white rounded-t-3xl -mt-6 px-5 pt-6 pb-8 max-w-md mx-auto">
        {{-- Order ID --}}
        <div class="bg-white px-4 py-3 flex items-center justify-between rounded-xl shadow-sm border border-gray-100">
            <span class="text-sm text-gray-600">ID Pesanan: <span class="font-semibold text-gray-900">{{ $help->order_id }}</span></span>
            <button wire:click="copyOrderId" class="text-blue-500 text-sm font-semibold flex items-center gap-1">
                Salin
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                </svg>
            </button>
        </div>

        {{-- Service Info --}}
        <div class="bg-white mt-2 px-4 py-4 rounded-xl shadow-sm border border-gray-100">
            <div class="flex items-start gap-3">
                <div class="w-12 h-12 rounded-lg bg-pink-100 flex items-center justify-center flex-shrink-0">
                    @if($help->photo)
                        <img src="{{ asset('storage/' . $help->photo) }}" alt="{{ $help->title }}" class="w-full h-full object-cover rounded-lg">
                    @else
                        <svg class="w-6 h-6 text-pink-500" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z"/>
                        </svg>
                    @endif
                </div>
                <div class="flex-1">
                    <h2 class="font-semibold text-base text-gray-900">{{ $help->title }}</h2>
                    <p class="text-sm text-gray-600 mt-0.5">Sesi Layanan: {{ $help->equipment_provided ?? 'Layanan 1 Unit' }}</p>
                </div>
            </div>

                {{-- Partner Info --}}
            @if($help->mitra)
                <div class="mt-4 p-3 bg-white rounded-xl flex items-center justify-between shadow-sm border border-gray-100">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-blue-600 flex items-center justify-center text-white font-bold">
                            {{ strtoupper(substr($help->mitra->name ?? 'M', 0, 1)) }}
                        </div>
                        <div>
                            <h3 class="font-semibold text-sm text-gray-900">{{ $help->mitra->name ?? 'Mitra' }}</h3>
                            <div class="flex items-center gap-1 mt-0.5">
                                <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                                <span class="text-sm font-semibold text-gray-900">{{ number_format($help->mitra->rating ?? 4.86, 2) }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        <a href="tel:{{ $help->mitra->phone ?? '' }}" class="w-10 h-10 rounded-full bg-white border border-gray-200 flex items-center justify-center hover:bg-gray-50 transition">
                            <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                        </a>
                        <a href="{{ route('customer.chat', $help->id) }}" class="w-10 h-10 rounded-full bg-white border border-gray-200 flex items-center justify-center hover:bg-gray-50 transition">
                            <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                            </svg>
                        </a>
                    </div>
                </div>

                <button class="w-full mt-3 py-2.5 bg-teal-600 text-white rounded-lg font-semibold text-sm hover:bg-teal-700 transition flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                    Menunggu Rekan Jasa berangkat
                </button>
            @endif
        </div>

        {{-- Warning Info --}}
        <div class="bg-yellow-50 mt-2 px-4 py-3 rounded-lg shadow-sm border border-yellow-100">
            <div class="flex gap-3">
                <div class="w-9 h-9 rounded-md bg-yellow-100 flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-yellow-600" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="flex-1">
                    <h3 class="font-bold text-sm text-gray-900 mb-1">Selalu jaga keamanan pesananmu</h3>
                    <p class="text-xs text-gray-700 leading-relaxed">Pastikan hanya transaksi di aplikasi agar pesananmu terlindungi asuransi. Laporkan Rekan Jasa yang meminta pembayaran di luar aplikasi untuk dapatkan pengembalian dana atau layanan gratis.</p>
                </div>
            </div>
        </div>

        {{-- Location --}}
        <div class="bg-white mt-2 px-4 py-4 rounded-lg shadow-sm border border-gray-100">
            <div class="flex items-start gap-3">
                <svg class="w-5 h-5 text-gray-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                <div class="flex-1">
                    <h3 class="font-bold text-sm text-gray-900 mb-1">Lokasi</h3>
                    <p class="text-sm text-gray-700">{{ $help->location ?? $help->full_address ?? 'Rumah warna coklat' }}</p>
                    @if($help->full_address)
                        <p class="text-xs text-gray-500 mt-1"><span class="font-semibold">Detail :</span> {{ $help->full_address }}</p>
                    @endif
                </div>
            </div>
        </div>

        {{-- Schedule --}}
        <div class="bg-white mt-2 px-4 py-4 rounded-lg shadow-sm border border-gray-100">
            <div class="flex items-start gap-3">
                <svg class="w-5 h-5 text-gray-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                <div class="flex-1">
                    <h3 class="font-bold text-sm text-gray-900 mb-1">Jadwal Pesanan</h3>
                    <p class="text-sm text-gray-700">
                        {{ \Carbon\Carbon::parse($help->scheduled_at ?? $help->created_at)->translatedFormat('l, d F Y') }} 
                        (Jam {{ \Carbon\Carbon::parse($help->scheduled_at ?? $help->created_at)->format('H:i') }} - 
                        {{ \Carbon\Carbon::parse($help->scheduled_at ?? $help->created_at)->addHour()->format('H:i') }} WIB)*
                    </p>
                    <p class="text-xs text-gray-500 mt-1">*Jadwal tertera dalam WIB</p>
                </div>
            </div>
        </div>

        {{-- Status Timeline - Simplified Version --}}
        <div class="bg-white mt-2 px-4 py-4 rounded-lg shadow-sm border border-gray-100">
            <h3 class="font-bold text-sm text-gray-900 mb-4">Status Pesanan</h3>
            
            <div class="space-y-3">
                @php
                    $statuses = [
                        [
                            'key' => 'payment',
                            'title' => 'Pembayaran',
                            'time' => $help->created_at,
                            'active' => in_array($help->status, ['menunggu_pembayaran', 'mencari_mitra', 'menunggu_mitra', 'memperoleh_mitra', 'taken', 'partner_on_the_way', 'partner_arrived', 'in_progress', 'sedang_diproses', 'selesai', 'completed']),
                            'current' => $help->status === 'menunggu_pembayaran'
                        ],
                        [
                            'key' => 'searching',
                            'title' => 'Mencari Rekan Jasa',
                            // show time when mitra assigned or when taken
                            'time' => $help->mitra_assigned_at ?? $help->taken_at,
                            // not active while still waiting for mitra; becomes active once a mitra is assigned/taken
                            'active' => !in_array($help->status, ['menunggu_mitra']),
                            'current' => in_array($help->status, ['mencari_mitra', 'memperoleh_mitra', 'taken'])
                        ],
                        [
                            'key' => 'accepted',
                            'title' => 'Pesanan Diterima',
                            'time' => $help->taken_at,
                            'active' => in_array($help->status, ['menunggu_mitra', 'memperoleh_mitra', 'taken', 'partner_on_the_way', 'partner_arrived', 'in_progress', 'sedang_diproses', 'selesai', 'completed']),
                            'current' => in_array($help->status, ['menunggu_mitra', 'memperoleh_mitra', 'taken'])
                        ],
                        [
                            'key' => 'on_the_way',
                            'title' => 'Menuju Lokasi',
                            'time' => $help->partner_started_moving_at,
                            'active' => in_array($help->status, ['partner_on_the_way', 'partner_arrived', 'in_progress', 'sedang_diproses', 'selesai', 'completed']),
                            'current' => $help->status === 'partner_on_the_way'
                        ],
                        [
                            'key' => 'arrived',
                            'title' => 'Tiba di Lokasi',
                            'time' => $help->partner_arrived_at,
                            'active' => in_array($help->status, ['partner_arrived', 'in_progress', 'sedang_diproses', 'selesai', 'completed']),
                            'current' => $help->status === 'partner_arrived'
                        ],
                        [
                            'key' => 'in_progress',
                            'title' => 'Sedang Dikerjakan',
                            'time' => $help->service_started_at,
                            'active' => in_array($help->status, ['in_progress', 'sedang_diproses', 'selesai', 'completed']),
                            'current' => in_array($help->status, ['in_progress', 'sedang_diproses'])
                        ],
                        [
                            'key' => 'completed',
                            'title' => 'Selesai',
                            'time' => $help->service_completed_at ?? $help->completed_at,
                            'active' => in_array($help->status, ['selesai', 'completed']),
                            'current' => in_array($help->status, ['selesai', 'completed'])
                        ]
                    ];
                @endphp

                @foreach($statuses as $status)
                    <div class="flex items-center gap-3 py-2">
                        {{-- Icon --}}
                        <div class="flex-shrink-0">
                            @if($status['active'])
                                <div class="w-7 h-7 rounded-full {{ $status['current'] ? 'bg-blue-500 ring-4 ring-blue-100' : 'bg-green-500' }} flex items-center justify-center">
                                    @if($status['current'])
                                        <div class="w-2 h-2 bg-white rounded-full animate-pulse"></div>
                                    @else
                                        <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                        </svg>
                                    @endif
                                </div>
                            @else
                                <div class="w-7 h-7 rounded-full bg-gray-200 flex items-center justify-center">
                                    <div class="w-2.5 h-2.5 rounded-full border-2 border-gray-400"></div>
                                </div>
                            @endif
                        </div>

                        {{-- Content --}}
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center justify-between gap-2">
                                <h4 class="text-sm font-semibold {{ $status['active'] ? 'text-gray-900' : 'text-gray-400' }}">
                                    {{ $status['title'] }}
                                </h4>
                                <span class="text-xs {{ $status['active'] ? 'text-gray-600' : 'text-gray-400' }} whitespace-nowrap">
                                    @if($status['time'])
                                        {{ \Carbon\Carbon::parse($status['time'])->format('H:i') }}
                                    @else
                                        -
                                    @endif
                                </span>
                            </div>
                            
                            {{-- Additional info for current status --}}
                            @if($status['current'])
                                <div class="mt-1">
                                    @if($status['key'] === 'on_the_way' && $help->partner_current_lat && $help->latitude)
                                        @php
                                            $earthRadius = 6371000;
                                            $lat1 = deg2rad($help->partner_current_lat);
                                            $lat2 = deg2rad($help->latitude);
                                            $latDiff = deg2rad($help->latitude - $help->partner_current_lat);
                                            $lngDiff = deg2rad($help->longitude - $help->partner_current_lng);
                                            $a = sin($latDiff / 2) * sin($latDiff / 2) + cos($lat1) * cos($lat2) * sin($lngDiff / 2) * sin($lngDiff / 2);
                                            $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
                                            $distance = round($earthRadius * $c);
                                        @endphp
                                        <p class="text-xs text-blue-600 flex items-center gap-1">
                                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                                            </svg>
                                            Jarak: {{ $distance > 1000 ? number_format($distance/1000, 1) . ' km' : $distance . ' m' }}
                                        </p>
                                    @elseif($status['key'] === 'accepted')
                                        <p class="text-xs text-blue-600">GPS tracking aktif</p>
                                    @elseif($status['key'] === 'arrived')
                                        <p class="text-xs text-green-600">Rekan jasa sudah sampai</p>
                                    @elseif($status['key'] === 'in_progress')
                                        <p class="text-xs text-blue-600">Pekerjaan sedang berlangsung</p>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- Divider (except for last item) --}}
                    @if(!$loop->last)
                        <div class="border-t border-gray-100 -mx-4 px-4"></div>
                    @endif
                @endforeach
            </div>
        </div>

        {{-- Satisfaction Guarantee --}}
        @if($help->status === 'selesai')
            <div class="bg-gradient-to-r from-blue-50 to-cyan-50 mt-2 px-4 py-4 border border-blue-100 rounded-lg">
                <div class="flex items-start gap-3">
                    <div class="w-12 h-12 rounded-full bg-blue-500 flex items-center justify-center flex-shrink-0">
                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <h3 class="font-bold text-sm text-gray-900 mb-1">Tidak puas? Pengerjaan ulang gratis!</h3>
                        <p class="text-xs text-gray-700 mb-3 leading-relaxed">Klaim garansi 1x24 jam setelah layanan selesai</p>
                        <a href="#" class="text-blue-600 text-sm font-semibold">Lihat Selengkapnya →</a>
                    </div>
                </div>
            </div>
        @endif

        {{-- Payment Details --}}
        <div class="bg-white mt-2 px-4 py-4">
            <h3 class="font-bold text-sm text-gray-900 mb-4">Detail Pesanan</h3>
            
            <div class="space-y-3">
                <div class="flex items-center justify-between text-sm">
                    <span class="text-gray-700">{{ $help->title }}</span>
                    <span class="font-semibold text-gray-900">Rp{{ number_format($help->amount, 0, ',', '.') }}</span>
                </div>
                
                <div class="flex items-center justify-between text-sm">
                    <span class="text-gray-700">{{ $help->equipment_provided ?? 'Layanan 1 Unit' }}</span>
                    <span class="font-semibold text-gray-900"></span>
                </div>

                <div class="flex items-center justify-between text-sm">
                    <span class="text-gray-700">Biaya Pemesanan</span>
                    <span class="font-semibold text-gray-900">Rp{{ number_format($help->booking_fee ?? 3500, 0, ',', '.') }}</span>
                </div>

                @if($help->voucher_code)
                    <div class="flex items-center justify-between text-sm">
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5 2a1 1 0 011 1v1h1a1 1 0 010 2H6v1a1 1 0 01-2 0V6H3a1 1 0 010-2h1V3a1 1 0 011-1zm0 10a1 1 0 011 1v1h1a1 1 0 110 2H6v1a1 1 0 11-2 0v-1H3a1 1 0 110-2h1v-1a1 1 0 011-1zM12 2a1 1 0 01.967.744L14.146 7.2 17.5 9.134a1 1 0 010 1.732l-3.354 1.935-1.18 4.455a1 1 0 01-1.933 0L9.854 12.8 6.5 10.866a1 1 0 010-1.732l3.354-1.935 1.18-4.455A1 1 0 0112 2z" clip-rule="evenodd"/>
                            </svg>
                            <span class="text-red-500 font-semibold">{{ $help->voucher_code }}</span>
                        </div>
                        <span class="font-semibold text-red-500">-Rp{{ number_format($help->discount_amount ?? 30000, 0, ',', '.') }}</span>
                    </div>
                @endif

                <div class="border-t pt-3 flex items-center justify-between">
                    <span class="font-bold text-gray-900">Total Pembayaran</span>
                    <span class="font-bold text-gray-900">Rp{{ number_format($help->total_amount ?? ($help->amount + ($help->booking_fee ?? 3500) - ($help->discount_amount ?? 0)), 0, ',', '.') }}</span>
                </div>
            </div>

            <div class="mt-4 p-3 bg-blue-50 rounded-lg">
                <p class="text-xs text-gray-700 leading-relaxed">
                    Kamu bisa meminta tindakan tambahan pada unit AC saat sesi layanan berlangsung. Pastikan hanya transaksi di aplikasi agar pesananmu terlindungi asuransi.
                </p>
            </div>
        </div>

        {{-- Cancel Button --}}
        @if(in_array($help->status, ['menunggu_pembayaran', 'mencari_mitra', 'menunggu_mitra']))
            <div class="bg-white mt-2 px-4 py-4">
                <button wire:click="confirmCancel" class="w-full py-3 border-2 border-red-500 text-red-500 rounded-lg font-semibold text-sm hover:bg-red-50 transition">
                    Batalkan Pesanan
                </button>
            </div>
        @endif

        {{-- Help Section --}}
        <div class="bg-white mt-2 px-4 py-4 mb-2">
            <div class="flex items-center justify-between">
                <span class="text-sm text-gray-700">Butuh bantuan atau ada keluhan atas Rekan Jasa?</span>
                <a href="{{ route('customer.help-support') }}" class="text-blue-500 text-sm font-semibold whitespace-nowrap ml-2">
                    Hubungi Kami
                </a>
            </div>
        </div>
    </div>

    {{-- Cancel Confirmation Modal --}}
    @if($showCancelConfirm)
        <div class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center px-4" wire:click="closeModal">
            <div class="bg-white rounded-2xl max-w-sm w-full p-6" wire:click.stop>
                <div class="text-center">
                    <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Batalkan Pesanan?</h3>
                    <p class="text-sm text-gray-600 mb-6">Apakah Anda yakin ingin membatalkan pesanan ini? Tindakan ini tidak dapat dibatalkan.</p>
                    
                    <div class="flex gap-3">
                        <button wire:click="closeModal" class="flex-1 py-2.5 border border-gray-300 text-gray-700 rounded-lg font-semibold hover:bg-gray-50 transition">
                            Tidak
                        </button>
                        <button wire:click="cancelHelp" class="flex-1 py-2.5 bg-red-500 text-white rounded-lg font-semibold hover:bg-red-600 transition">
                            Ya, Batalkan
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- Toast notification for copy --}}
    <script>
        document.addEventListener('livewire:init', () => {
            Livewire.on('copied', (event) => {
                // Show toast notification
                const toast = document.createElement('div');
                toast.className = 'fixed top-20 left-1/2 transform -translate-x-1/2 bg-gray-900 text-white px-4 py-2 rounded-lg shadow-lg z-50 text-sm';
                toast.textContent = 'ID Pesanan disalin: ' + event.orderId;
                document.body.appendChild(toast);
                
                setTimeout(() => {
                    toast.remove();
                }, 2000);
            });
        });
    </script>

    {{-- Flash Messages --}}
    @if(session()->has('success'))
        <div class="fixed top-20 left-1/2 transform -translate-x-1/2 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50 animate-fade-in-down">
            {{ session('success') }}
        </div>
    @endif

    @if(session()->has('error'))
        <div class="fixed top-20 left-1/2 transform -translate-x-1/2 bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg z-50 animate-fade-in-down">
            {{ session('error') }}
        </div>
    @endif
</div>
