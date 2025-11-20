<div class="min-h-screen bg-gray-50">
    <div class="px-5 pt-6 pb-4 bg-gradient-to-br from-primary-400 via-primary-500 to-primary-600 rounded-b-3xl">
        <div class="flex items-center justify-between mb-6">
            <a href="{{ route('mitra.dashboard') }}"
                class="bg-white p-2.5 rounded-full shadow-md hover:shadow-lg transition">
                <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
            <h1 class="text-xl font-bold text-white flex-1 text-center">Bantuan Sedang Diproses</h1>
            <div class="w-9"></div>
        </div>
    </div>

    <div class="px-5 pt-6 pb-24">
        @if(session('success'))
            <div class="mb-4 p-3 bg-green-50 border border-green-100 rounded-lg text-green-700">{{ session('success') }}
            </div>
        @endif

        @if(count($helps) === 0)
            <div class="bg-white rounded-2xl shadow-lg p-6 text-center">
                <p class="text-gray-600">Tidak ada bantuan yang sedang Anda proses saat ini.</p>
            </div>
        @else
            <div class="space-y-4">
                @foreach($helps as $help)
                    <div class="bg-white rounded-2xl shadow p-4">
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <div class="flex items-start justify-between gap-3">
                                    <div class="flex-1">
                                        <h3 class="font-bold text-gray-900 text-lg">{{ $help->title }}</h3>
                                        @if(optional($help->category)->name)
                                            <div class="text-xs text-gray-500 mt-1">{{ optional($help->category)->name }}</div>
                                        @endif
                                    </div>

                                    <div class="text-right">
                                        <div class="inline-block bg-blue-50 text-blue-700 px-3 py-1 rounded-lg font-bold">Rp {{ number_format($help->amount, 0, ',', '.') }}</div>
                                    </div>
                                </div>

                                <div class="mt-3">
                                    @if($help->photo)
                                        <img src="{{ asset('storage/' . $help->photo) }}" alt="Foto bantuan" class="w-full rounded-xl object-cover h-44">
                                    @else
                                        <div class="w-full rounded-xl bg-gray-100 h-44 flex items-center justify-center text-gray-400">Tidak ada foto</div>
                                    @endif
                                </div>

                                <div class="mt-4 grid grid-cols-2 gap-3 text-sm text-gray-700">
                                    <div class="bg-gray-50 rounded-lg p-3">
                                        <div class="font-semibold">Lokasi</div>
                                        <div class="text-xs text-gray-500">{{ $help->location ?? '-' }}</div>
                                    </div>
                                    <div class="bg-gray-50 rounded-lg p-3">
                                        <div class="font-semibold">Waktu</div>
                                        <div class="text-xs text-gray-500">Dibuat: {{ optional($help->created_at)->format('d M Y H:i') ?? '-' }}</div>
                                        @if($help->taken_at)
                                            <div class="text-xs text-gray-500">Diambil: {{ optional($help->taken_at)->format('d M Y H:i') }}</div>
                                        @endif
                                    </div>
                                </div>

                                <div class="mt-4">
                                    <div class="font-semibold mb-2">Nama Customer</div>
                                    <div class="flex items-center bg-white p-3 rounded-lg shadow-sm">
                                        @php
                                            $name = optional($help->user)->name ?? 'Pengguna';
                                            $parts = explode(' ', $name);
                                            $initials = '';
                                            foreach($parts as $p){ $initials .= strtoupper(substr($p,0,1)); }
                                        @endphp
                                        <div class="w-12 h-12 rounded-md bg-gray-100 flex items-center justify-center text-gray-700 font-bold mr-3">{{ $initials }}</div>
                                        <div class="flex-1">
                                            <div class="font-semibold text-gray-900">{{ $name }}</div>
                                            <div class="text-xs text-gray-500">{{ optional($help->user)->city?->name ?? '' }}</div>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            @if(optional($help->user)->phone)
                                                <a href="tel:{{ optional($help->user)->phone }}" class="bg-blue-50 p-2 rounded-full text-blue-600">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                                                </a>
                                            @endif
                                            <a href="{{ route('mitra.chat', ['help' => $help->id]) }}" class="bg-blue-500 p-2 rounded-full text-white">
                                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M20 2H4c-1.1 0-2 .9-2 2v18l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2z"/></svg>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4 flex items-center justify-between">
                            <div></div>
                            <div class="flex items-center gap-3">
                                <a href="{{ route('mitra.help.detail', $help->id) }}" class="text-sm text-primary-600 font-semibold">Lihat</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>