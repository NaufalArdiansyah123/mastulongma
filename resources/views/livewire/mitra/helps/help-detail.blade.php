<div class="min-h-screen bg-gray-50">
    {{-- Header - BRImo Style --}}
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
                    <p class="text-xs text-white/90 mt-0.5">Informasi lengkap pesanan Anda</p>
                </div>

                <div class="w-9"></div>
            </div>
        </div>

        <!-- Curved separator -->
        <svg class="absolute bottom-0 left-0 w-full" viewBox="0 0 1440 72" preserveAspectRatio="none" aria-hidden="true">
            <path d="M0,32 C360,72 1080,0 1440,40 L1440,72 L0,72 Z" fill="#f9fafb"></path>
        </svg>
    </div>

    <!-- Content -->
    <div class="bg-gray-50 -mt-6 px-5 pt-6 pb-20 max-w-md mx-auto">
        {{-- GPS Tracker - Auto tracking untuk status aktif --}}
        @if(in_array($help->status, ['memperoleh_mitra', 'taken', 'partner_on_the_way', 'partner_arrived']))
            <div class="mb-3">
                <livewire:mitra.gps-tracker :helpId="$help->id" :key="'gps-tracker-'.$help->id" />
            </div>
        @endif

        @if(session('message'))
            <div class="mb-4 p-3 bg-green-50 border border-green-100 rounded-lg text-green-700 text-sm flex items-center gap-2">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                {{ session('message') }}
            </div>
        @endif

        {{-- Service Info --}}
        <div class="bg-white px-4 py-4 rounded-xl shadow-sm border border-gray-100 mb-3">
            <div class="flex items-start gap-3">
                <div class="w-14 h-14 rounded-lg bg-pink-100 flex items-center justify-center flex-shrink-0">
                    @if($help->photo)
                        <img src="{{ asset('storage/' . $help->photo) }}" alt="{{ $help->title }}" class="w-full h-full object-cover rounded-lg">
                    @else
                        <svg class="w-7 h-7 text-pink-500" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z"/>
                        </svg>
                    @endif
                </div>
                <div class="flex-1">
                    <h2 class="font-semibold text-base text-gray-900">{{ $help->title }}</h2>
                    <p class="text-sm text-gray-600 mt-0.5">{{ $help->equipment_provided ?? 'Layanan 1 Unit' }}</p>
                    <p class="text-lg font-bold text-blue-600 mt-2">Rp {{ number_format($help->amount, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>

        {{-- Customer Info --}}
        <div class="bg-white px-4 py-4 rounded-xl shadow-sm border border-gray-100 mb-3">
            <div class="flex items-center justify-between mb-3">
                <h3 class="font-semibold text-sm text-gray-900">Informasi Customer</h3>
            </div>
            <div class="flex items-center gap-3 mb-3">
                <div class="w-12 h-12 rounded-full bg-blue-600 flex items-center justify-center text-white font-bold text-lg">
                    {{ strtoupper(substr($help->user->name ?? 'C', 0, 1)) }}
                </div>
                <div class="flex-1">
                    <h4 class="font-semibold text-sm text-gray-900">{{ $help->user->name }}</h4>
                    @if($help->user->phone)
                        <p class="text-sm text-gray-600 mt-0.5">{{ $help->user->phone }}</p>
                    @endif
                    <p class="text-sm text-gray-600">{{ $help->city->name ?? '-' }}</p>
                </div>
            </div>
            <div class="flex items-center gap-2">
                @if($help->user->phone)
                    <a href="tel:{{ $help->user->phone }}" class="flex-1 flex items-center justify-center gap-2 py-2.5 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 transition">
                        <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                        </svg>
                        <span class="text-sm font-semibold text-gray-700">Telepon</span>
                    </a>
                @endif
                <a href="{{ route('mitra.chat', ['help' => $help->id]) }}" class="flex-1 flex items-center justify-center gap-2 py-2.5 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 transition">
                    <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                    </svg>
                    <span class="text-sm font-semibold text-gray-700">Chat</span>
                </a>
            </div>
        </div>

        {{-- Description --}}
        <div class="bg-white px-4 py-4 rounded-xl shadow-sm border border-gray-100 mb-3">
            <h3 class="font-semibold text-sm text-gray-900 mb-2 flex items-center gap-2">
                <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"/>
                </svg>
                Deskripsi Bantuan
            </h3>
            <p class="text-sm text-gray-600 leading-relaxed">{{ $help->description }}</p>
        </div>

        {{-- Location --}}
        <div class="bg-white px-4 py-4 rounded-xl shadow-sm border border-gray-100 mb-3">
            <h3 class="font-semibold text-sm text-gray-900 mb-3 flex items-center gap-2">
                <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                Lokasi
            </h3>
            <div class="space-y-2 text-sm">
                @if($help->location)
                    <p class="font-medium text-gray-900">{{ $help->location }}</p>
                @endif
                @if($help->full_address)
                    <p class="text-gray-600">{{ $help->full_address }}</p>
                @endif
                @if($help->latitude && $help->longitude)
                    <a href="https://www.google.com/maps?q={{ $help->latitude }},{{ $help->longitude }}" target="_blank" 
                        class="inline-flex items-center gap-2 mt-2 bg-green-600 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-green-700 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                        </svg>
                        Buka Peta
                    </a>
                @endif
            </div>
        </div>

        {{-- GPS Simulator (Only in non-production) --}}
        @if(config('app.env') !== 'production' && $help->mitra_id === auth()->id() && !in_array($help->status, ['selesai', 'dibatalkan']))
            <div class="mb-3">
                <livewire:mitra.gps-simulator :help-id="$help->id" :key="'gps-simulator-'.$help->id" />
            </div>
        @endif

        {{-- Update Status Section --}}


        {{-- Action Buttons --}}
        @if($help->status === 'partner_arrived')
            <div class="bg-white px-4 py-4 rounded-xl shadow-sm border border-gray-100 mb-3">
                <button wire:click="startService" 
                    class="w-full py-3 bg-green-600 text-white rounded-lg font-semibold text-sm hover:bg-green-700 transition flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Mulai Pekerjaan
                </button>
                <p class="text-xs text-gray-500 text-center mt-2">Klik tombol ini setelah Anda sampai di lokasi dan siap memulai pekerjaan</p>
            </div>
        @endif

        @if($help->status === 'in_progress' || $help->status === 'sedang_diproses')
            <div class="bg-white px-4 py-4 rounded-xl shadow-sm border border-gray-100 mb-3">
                <button wire:click="markCompleted" 
                    class="w-full py-3 bg-blue-600 text-white rounded-lg font-semibold text-sm hover:bg-blue-700 transition flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Selesai
                </button>
                <p class="text-xs text-gray-500 text-center mt-2">Klik tombol ini setelah pekerjaan selesai dikerjakan</p>
            </div>
        @endif

        @if($help->status === 'waiting_customer_confirmation')
            <div class="bg-orange-50 px-4 py-3 rounded-xl border border-orange-100 mb-3">
                <div class="flex items-start gap-3">
                    <div class="w-10 h-10 rounded-full bg-orange-500 flex items-center justify-center text-white">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <h4 class="font-semibold text-sm text-gray-900">Menunggu konfirmasi customer</h4>
                        <p class="text-xs text-gray-600 mt-1">Anda telah menandai pekerjaan selesai. Tunggu konfirmasi dari customer sebelum pesanan dianggap final.</p>
                    </div>
                </div>
            </div>
        @endif

        {{-- Status Timeline --}}
        @if($help->partner_started_at || $help->partner_arrived_at || $help->service_started_at || $help->service_completed_at || $help->completed_at)
            <div class="bg-white px-4 py-4 rounded-xl shadow-sm border border-gray-100">
                <h3 class="font-semibold text-sm text-gray-900 mb-3 flex items-center gap-2">
                    <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Riwayat Timeline
                </h3>
                <div class="space-y-2 text-xs">
                    @if($help->partner_started_at)
                        <div class="flex items-center justify-between text-gray-600 py-1">
                            <div class="flex items-center gap-2">
                                <div class="w-1.5 h-1.5 rounded-full bg-green-500"></div>
                                <span>Mulai Perjalanan</span>
                            </div>
                            <span class="text-gray-500">{{ \Carbon\Carbon::parse($help->partner_started_at)->format('d M, H:i') }}</span>
                        </div>
                    @endif
                    @if($help->partner_arrived_at)
                        <div class="flex items-center justify-between text-gray-600 py-1">
                            <div class="flex items-center gap-2">
                                <div class="w-1.5 h-1.5 rounded-full bg-green-500"></div>
                                <span>Tiba di Lokasi</span>
                            </div>
                            <span class="text-gray-500">{{ \Carbon\Carbon::parse($help->partner_arrived_at)->format('d M, H:i') }}</span>
                        </div>
                    @endif
                    @if($help->service_started_at)
                        <div class="flex items-center justify-between text-gray-600 py-1">
                            <div class="flex items-center gap-2">
                                <div class="w-1.5 h-1.5 rounded-full bg-green-500"></div>
                                <span>Mulai Pengerjaan</span>
                            </div>
                            <span class="text-gray-500">{{ \Carbon\Carbon::parse($help->service_started_at)->format('d M, H:i') }}</span>
                        </div>
                    @endif
                    @if($help->service_completed_at)
                        <div class="flex items-center justify-between text-gray-600 py-1">
                            <div class="flex items-center gap-2">
                                <div class="w-1.5 h-1.5 rounded-full bg-green-500"></div>
                                <span>Selesai Pengerjaan</span>
                            </div>
                            <span class="text-gray-500">{{ \Carbon\Carbon::parse($help->service_completed_at)->format('d M, H:i') }}</span>
                        </div>
                    @endif
                    @if($help->status === 'waiting_customer_confirmation')
                        <div class="flex items-center justify-between text-orange-700 font-semibold py-1">
                            <div class="flex items-center gap-2">
                                <div class="w-1.5 h-1.5 rounded-full bg-orange-500"></div>
                                <span>Menunggu Konfirmasi Customer</span>
                            </div>
                            <span class="text-orange-600">{{ \Carbon\Carbon::parse($help->service_completed_at ?? now())->format('d M, H:i') }}</span>
                        </div>
                    @endif
                    @if($help->completed_at)
                        <div class="flex items-center justify-between text-green-700 font-semibold py-1">
                            <div class="flex items-center gap-2">
                                <div class="w-1.5 h-1.5 rounded-full bg-green-600"></div>
                                <span>Pesanan Selesai</span>
                            </div>
                            <span class="text-green-600">{{ \Carbon\Carbon::parse($help->completed_at)->format('d M, H:i') }}</span>
                        </div>
                    @endif
                </div>
            </div>
        @endif

        {{-- Rating Customer Form --}}
        @if(in_array($help->status, ['selesai', 'completed']))
            @php
                $mitraRating = \App\Models\Rating::where('help_id', $help->id)
                    ->where('rater_id', auth()->id())
                    ->where('type', 'mitra_to_customer')
                    ->first();
            @endphp

            @if($mitraRating)
                {{-- Already Rated Customer --}}
                <div class="bg-gradient-to-r from-green-50 to-emerald-50 mt-3 px-4 py-4 border border-green-200 rounded-lg">
                    <div class="flex items-start gap-3">
                        <div class="w-12 h-12 rounded-full bg-green-500 flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h3 class="font-bold text-sm text-gray-900 mb-2">Rating untuk Customer</h3>
                            <div class="flex items-center gap-1 mb-2">
                                @for($i = 1; $i <= 5; $i++)
                                    <svg class="w-5 h-5 {{ $i <= $mitraRating->rating ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                @endfor
                                <span class="ml-2 text-sm font-semibold text-gray-900">{{ $mitraRating->rating }}/5</span>
                            </div>
                            @if($mitraRating->review)
                                    <p class="text-sm text-gray-700 italic">"{{ $mitraRating->review }}"</p>
                            @endif
                            <p class="text-xs text-gray-500 mt-2">{{ $mitraRating->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                </div>
            @else
                {{-- Rating Form for Customer --}}
                <div class="bg-gradient-to-r from-blue-50 to-cyan-50 mt-3 px-4 py-4 border border-blue-200 rounded-lg">
                    <div class="flex items-start gap-3 mb-4">
                        <div class="w-12 h-12 rounded-full bg-blue-500 flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h3 class="font-bold text-sm text-gray-900 mb-1">Beri Rating untuk Customer</h3>
                            <p class="text-xs text-gray-700">Bagaimana pengalaman Anda dengan {{ $help->user->name ?? 'customer ini' }}?</p>
                        </div>
                    </div>

                    {{-- Star Rating --}}
                    <div class="mb-4">
                        <label class="block text-sm font-semibold text-gray-900 mb-2">Rating</label>
                        <div class="flex items-center gap-2">
                            @for($i = 1; $i <= 5; $i++)
                                <button 
                                    type="button"
                                    wire:click="setRating({{ $i }})"
                                    class="focus:outline-none transition-transform hover:scale-110">
                                    <svg class="w-10 h-10 {{ $rating >= $i ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                </button>
                            @endfor
                            @if($rating > 0)
                                <span class="ml-2 text-sm font-semibold text-gray-900">{{ $rating }}/5</span>
                            @endif
                        </div>
                        @error('rating')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Review Text --}}
                    <div class="mb-4">
                        <label class="block text-sm font-semibold text-gray-900 mb-2">Ulasan (Opsional)</label>
                        <textarea 
                            wire:model="review"
                            rows="3"
                            placeholder="Bagikan pengalaman Anda dengan customer ini..."
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm"
                            maxlength="500"></textarea>
                        <div class="flex justify-between items-center mt-1">
                            @error('review')
                                <p class="text-xs text-red-600">{{ $message }}</p>
                            @else
                                <p class="text-xs text-gray-500">Maksimal 500 karakter</p>
                            @enderror
                            <p class="text-xs text-gray-500">{{ strlen($review ?? '') }}/500</p>
                        </div>
                    </div>

                    {{-- Submit Button --}}
                    <button 
                        wire:click="submitCustomerRating"
                        wire:loading.attr="disabled"
                        class="w-full bg-gradient-to-r from-blue-500 to-cyan-500 text-white font-semibold py-3 px-4 rounded-lg hover:from-blue-600 hover:to-cyan-600 transition-all duration-200 shadow-md flex items-center justify-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed">
                        <span wire:loading.remove>Kirim Rating</span>
                        <span wire:loading>Mengirim...</span>
                    </button>
                </div>
            @endif
        @endif
    </div>
</div>
