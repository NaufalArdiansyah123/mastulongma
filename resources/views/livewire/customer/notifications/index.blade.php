<div class="min-h-screen bg-white">
    <div class="max-w-md mx-auto">
        <!-- Header - BRImo Style -->
        <div class="px-5 pt-5 pb-8 relative overflow-hidden" style="background: linear-gradient(to bottom right, #0098e7, #0077cc, #0060b0);">
            <div class="absolute top-0 right-0 w-40 h-40 bg-white/5 rounded-full -mr-20 -mt-20"></div>
            <div class="absolute bottom-0 left-0 w-32 h-32 bg-white/5 rounded-full -ml-16 -mb-16"></div>
            
            <div class="relative z-10">
                <div class="flex items-center justify-between text-white mb-3">
                    <button onclick="window.history.back()" aria-label="Kembali" class="p-2 hover:bg-white/20 rounded-lg transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                    </button>

                    <div class="text-center flex-1">
                        <h1 class="text-lg font-bold">Notifikasi</h1>
                        @if($unreadCount > 0)
                            <p class="text-xs text-white/90 mt-0.5">{{ $unreadCount }} belum dibaca</p>
                        @else
                            <p class="text-xs text-white/90 mt-0.5">Semua sudah dibaca</p>
                        @endif
                    </div>

                    @if($unreadCount > 0)
                        <button wire:click="markAllAsRead" aria-label="Tandai Semua" class="p-2 hover:bg-white/20 rounded-lg transition">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                        </button>
                    @else
                        <div class="w-9"></div>
                    @endif
                </div>
            </div>

            <!-- Curved separator -->
            <svg class="absolute bottom-0 left-0 w-full" viewBox="0 0 1440 72" preserveAspectRatio="none" aria-hidden="true">
                <path d="M0,32 C360,72 1080,0 1440,40 L1440,72 L0,72 Z" fill="#ffffff"></path>
            </svg>
        </div>

        <!-- Content -->
        <div class="bg-white rounded-t-3xl -mt-6 px-5 pt-6 pb-8">
            @if($notifications->count() > 0)
                <!-- Filter Tabs -->
                <div class="flex gap-2 mb-4">
                    <button id="tab-all" data-mode="all" class="tab-btn flex-1 px-4 py-2.5 rounded-xl text-sm font-semibold transition bg-primary-600 text-white">
                        Semua
                    </button>
                    <button id="tab-unread" data-mode="unread" class="tab-btn flex-1 px-4 py-2.5 rounded-xl text-sm font-semibold transition bg-gray-100 text-gray-700">
                        Belum Dibaca
                        @if($unreadCount > 0)
                            <span class="ml-1.5 inline-flex items-center justify-center bg-primary-600 text-white text-xs font-bold px-2 py-0.5 rounded-full">{{ $unreadCount }}</span>
                        @endif
                    </button>
                    @if($unreadCount > 0)
                        <button wire:click="markAllAsRead" class="px-4 py-2.5 rounded-xl text-sm font-semibold transition bg-green-600 text-white hover:bg-green-700 whitespace-nowrap flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            Tandai Semua
                        </button>
                    @endif
                </div>

                <!-- Notifications List -->
                <div id="notifications-list" class="space-y-3">
                    @foreach($notifications as $notification)
                        @php
                            $data = $notification->data;
                            $isUnread = is_null($notification->read_at);
                        @endphp

                        <div wire:key="notification-{{ $notification->id }}" 
                            class="notification-item relative bg-white rounded-xl border transition-all {{ $isUnread ? 'unread border-primary-200 bg-primary-50/30' : 'border-gray-200' }} hover:shadow-md">
                            
                            <!-- Unread indicator -->
                            @if($isUnread)
                                <div class="absolute left-0 top-4 bottom-4 w-1 bg-primary-600 rounded-r-full"></div>
                            @endif

                            <div class="p-4 {{ $isUnread ? 'pl-5' : 'pl-4' }}">
                                <div class="flex items-start gap-3">
                                    <!-- Icon -->
                                    <div class="flex-shrink-0 w-11 h-11 rounded-full flex items-center justify-center {{ $isUnread ? 'bg-gradient-to-br from-primary-400 to-primary-600' : 'bg-gray-100' }}">
                                        @if(isset($data['type']) && $data['type'] === 'help_taken')
                                            <svg class="w-6 h-6 {{ $isUnread ? 'text-white' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        @else
                                            <svg class="w-6 h-6 {{ $isUnread ? 'text-white' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                            </svg>
                                        @endif
                                    </div>

                                    <!-- Content -->
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-start justify-between gap-2 mb-1">
                                            <h3 class="text-sm font-bold text-gray-900">
                                                @if(isset($data['type']) && $data['type'] === 'help_taken')
                                                    Bantuan Diambil
                                                @else
                                                    Notifikasi
                                                @endif
                                            </h3>
                                            <span class="text-xs text-gray-500 whitespace-nowrap">{{ $notification->created_at->diffForHumans() }}</span>
                                        </div>

                                        <p class="text-sm text-gray-700 leading-relaxed mb-2">{{ $data['message'] ?? 'Notifikasi baru' }}</p>

                                        @if(isset($data['help_amount']))
                                            <div class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-primary-50 rounded-lg mb-2">
                                                <svg class="w-4 h-4 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                <span class="text-sm font-bold text-primary-700">Rp {{ number_format($data['help_amount'], 0, ',', '.') }}</span>
                                            </div>
                                        @endif

                                        <!-- Actions -->
                                        <div class="flex items-center gap-3 pt-3 border-t border-gray-100">
                                            @if($isUnread)
                                                <button wire:click="markAsRead('{{ $notification->id }}')" class="text-xs font-semibold text-primary-600 hover:text-primary-700 transition">
                                                    Tandai Dibaca
                                                </button>
                                            @endif
                                            <button wire:click="deleteNotification('{{ $notification->id }}')" class="text-xs font-semibold text-red-500 hover:text-red-600 transition {{ $isUnread ? '' : 'ml-0' }}">
                                                Hapus
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                @if($notifications->hasPages())
                    <div class="mt-6">
                        {{ $notifications->links() }}
                    </div>
                @endif
            @else
                <!-- Empty State -->
                <div class="text-center py-16">
                    <div class="w-20 h-20 mx-auto mb-4 rounded-full bg-gray-100 flex items-center justify-center">
                        <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-800 mb-2">Belum Ada Notifikasi</h3>
                    <p class="text-sm text-gray-500">Notifikasi Anda akan muncul di sini</p>
                </div>
            @endif
        </div>
    </div>


<style>
    .notifications-list.show-only-unread .notification-item:not(.unread) {
        display: none;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const tabAll = document.getElementById('tab-all');
        const tabUnread = document.getElementById('tab-unread');
        const list = document.getElementById('notifications-list');
        
        if (!tabAll || !tabUnread || !list) return;

        function setActive(mode) {
            if (mode === 'unread') {
                tabUnread.classList.remove('bg-gray-100', 'text-gray-700');
                tabUnread.classList.add('bg-primary-600', 'text-white');
                tabAll.classList.remove('bg-primary-600', 'text-white');
                tabAll.classList.add('bg-gray-100', 'text-gray-700');
                list.classList.add('show-only-unread');
            } else {
                tabAll.classList.remove('bg-gray-100', 'text-gray-700');
                tabAll.classList.add('bg-primary-600', 'text-white');
                tabUnread.classList.remove('bg-primary-600', 'text-white');
                tabUnread.classList.add('bg-gray-100', 'text-gray-700');
                list.classList.remove('show-only-unread');
            }
        }

        tabAll.addEventListener('click', () => setActive('all'));
        tabUnread.addEventListener('click', () => setActive('unread'));
    });
</script>
</div>