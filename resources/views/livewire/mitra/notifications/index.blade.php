<div class="min-h-screen bg-white">
    <div class="max-w-md mx-auto">
        <!-- Header -->
        <div class="px-5 pt-5 pb-8 relative overflow-hidden" style="background: linear-gradient(to bottom right, #0098e7, #0077cc, #0060b0);">
            <div class="absolute top-0 right-0 w-40 h-40 bg-white/5 rounded-full -mr-20 -mt-20"></div>
            <div class="absolute bottom-0 left-0 w-32 h-32 bg-white/5 rounded-full -ml-16 -mb-16"></div>

            <div class="relative z-10">
                <div class="flex items-center justify-between text-white mb-3">
                    <button onclick="window.history.back()" class="p-2 hover:bg-white/20 rounded-lg transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                    </button>
                    <div class="text-center flex-1">
                        <h1 class="text-lg font-bold">Notifikasi</h1>
                        <p class="text-xs text-white/90 mt-0.5">Pemberitahuan terbaru untuk akun Anda</p>
                    </div>
                    <div class="w-8"></div>
                </div>
            </div>

            <svg class="absolute bottom-0 left-0 w-full" viewBox="0 0 1440 72" preserveAspectRatio="none" aria-hidden="true">
                <path d="M0,32 C360,72 1080,0 1440,40 L1440,72 L0,72 Z" fill="#ffffff"></path>
            </svg>
        </div>

        <div class="bg-white rounded-t-3xl -mt-6 px-5 pt-6 pb-24 min-h-[60vh]">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-sm font-semibold text-gray-700">Semua Notifikasi</h2>
                <div class="flex items-center gap-2">
                    <button wire:click="markAllRead" class="text-xs text-blue-600 hover:underline">Tandai semua dibaca</button>
                </div>
            </div>

            <div class="space-y-3">
                @forelse($notifications as $notification)
                    @php
                        // default shape for Laravel notifications
                        $data = is_array($notification->data) ? $notification->data : (array) $notification->data;
                        $title = $data['title'] ?? ($data['message'] ?? 'Notifikasi');
                        $body = $data['body'] ?? ($data['description'] ?? null);
                        $time = optional($notification->created_at)->diffForHumans();
                        $unread = !$notification->read_at;
                    @endphp

                    <div class="p-3 rounded-lg border {{ $unread ? 'border-blue-100 bg-blue-50' : 'border-gray-100 bg-white' }} shadow-sm flex items-start gap-3">
                        <div class="w-10 h-10 rounded-full bg-white flex items-center justify-center text-blue-600 font-semibold">🔔</div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-start justify-between">
                                <div>
                                    <div class="text-sm font-semibold text-gray-900">{{ $title }}</div>
                                    @if($body)
                                        <div class="text-xs text-gray-600 mt-1">{{ Str::limit($body, 120) }}</div>
                                    @endif
                                </div>
                                <div class="text-xs text-gray-400 ml-2">{{ $time }}</div>
                            </div>
                            <div class="mt-3 flex items-center gap-2">
                                @if($unread)
                                    <button wire:click="markRead('{{ $notification->id }}')" class="text-xs px-2 py-1 bg-blue-600 text-white rounded-md">Tandai dibaca</button>
                                @endif
                                <a href="{{ $data['url'] ?? 'javascript:void(0)' }}" class="text-xs text-gray-500 hover:underline">Lihat</a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-12">
                        <svg class="w-16 h-16 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6 6 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                        <p class="text-sm font-semibold text-gray-700">Belum ada notifikasi</p>
                        <p class="text-xs text-gray-500 mt-1">Notifikasi akan muncul saat ada update terkait akun atau pesanan Anda</p>
                    </div>
                @endforelse
            </div>

        </div>
    </div>
</div>
