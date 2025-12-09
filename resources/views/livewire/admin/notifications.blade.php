<div class="relative" 
     x-data="{ 
         open: false,
         toggle() {
             this.open = !this.open;
             if(this.open) {
                 console.log('Dropdown opened');
                 @this.call('loadNotifications');
             }
         }
     }" 
     @click.away="open = false">
    <!-- Notification Bell Button -->
    <button 
        @click="toggle()"
        type="button"
        class="relative p-2 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg transition"
        wire:poll.30s="refreshNotifications"
    >
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
        </svg>
        @if($unreadCount > 0)
            <span class="absolute top-1 right-1 flex items-center justify-center w-5 h-5 text-xs font-bold text-white bg-red-500 rounded-full">
                {{ $unreadCount > 9 ? '9+' : $unreadCount }}
            </span>
        @endif
    </button>
    <!-- Notification Dropdown -->
    <div 
        x-show="open"
        x-cloak
        @click.stop
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        class="absolute right-0 mt-2 w-96 bg-white rounded-xl shadow-2xl border border-gray-200 z-50"
    >
        <!-- Header -->
        <div class="px-4 py-3 border-b border-gray-200 flex items-center justify-between">
            <div>
                <h3 class="text-lg font-bold text-gray-900">Notifikasi</h3>
                @if($unreadCount > 0)
                    <p class="text-xs text-gray-500">{{ $unreadCount }} belum dibaca</p>
                @endif
            </div>
            @if($unreadCount > 0)
                <button 
                    wire:click="markAllAsRead"
                    class="text-xs text-primary-600 hover:text-primary-700 font-semibold"
                >
                    Tandai Semua Dibaca
                </button>
            @endif
        </div>

        <!-- Notifications List -->
        <div class="max-h-96 overflow-y-auto">
            @forelse($notifications as $notification)
                @php
                    $data = $notification->data;
                    $isUnread = is_null($notification->read_at);
                @endphp
                <div 
                    class="px-4 py-3 border-b border-gray-100 hover:bg-gray-50 transition {{ $isUnread ? 'bg-blue-50' : '' }}"
                >
                    <div class="flex items-start gap-3">
                        <!-- Icon based on notification type -->
                        <div class="flex-shrink-0 mt-1">
                            @if(isset($data['type']))
                                @if($data['type'] === 'new_topup_request')
                                    <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                @elseif($data['type'] === 'help_taken')
                                    <div class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center">
                                        <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                        </svg>
                                    </div>
                                @elseif($data['type'] === 'new_registration')
                                    <div class="w-10 h-10 bg-yellow-100 rounded-full flex items-center justify-center">
                                        <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                                        </svg>
                                    </div>
                                @else
                                    <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                @endif
                            @else
                                <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                            @endif
                        </div>

                        <!-- Content -->
                        <div class="flex-1 min-w-0">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    @if(isset($data['type']))
                                        @if($data['type'] === 'new_topup_request')
                                            <p class="text-sm font-semibold text-gray-900">💰 Request Top-Up Baru</p>
                                            <p class="text-xs text-gray-600 mt-1">
                                                {{ $data['customer_name'] ?? 'Customer' }} mengajukan top-up sebesar 
                                                <span class="font-semibold text-green-600">Rp {{ number_format($data['amount'] ?? 0, 0, ',', '.') }}</span>
                                            </p>
                                            @if(isset($data['request_code']))
                                                <p class="text-xs text-gray-500 mt-1">Kode: <span class="font-mono">{{ $data['request_code'] }}</span></p>
                                            @endif
                                        @elseif($data['type'] === 'help_taken')
                                            <p class="text-sm font-semibold text-gray-900">🤝 Bantuan Diambil</p>
                                            <p class="text-xs text-gray-600 mt-1">
                                                {{ $data['message'] ?? 'Mitra telah mengambil bantuan' }}
                                            </p>
                                        @else
                                            <p class="text-sm font-semibold text-gray-900">📢 Notifikasi</p>
                                            <p class="text-xs text-gray-600 mt-1">{{ $data['message'] ?? 'Notifikasi baru' }}</p>
                                        @endif
                                    @else
                                        <p class="text-sm text-gray-900">{{ $data['message'] ?? 'Notifikasi baru' }}</p>
                                    @endif
                                    
                                    <p class="text-xs text-gray-400 mt-1">
                                        {{ $notification->created_at->diffForHumans() }}
                                    </p>
                                </div>

                                <!-- Actions -->
                                <div class="flex items-center gap-1 ml-2">
                                    @if($isUnread)
                                        <button 
                                            wire:click="markAsRead('{{ $notification->id }}')"
                                            class="p-1 text-blue-600 hover:bg-blue-100 rounded"
                                            title="Tandai dibaca"
                                        >
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                            </svg>
                                        </button>
                                    @endif
                                    <button 
                                        wire:click="deleteNotification('{{ $notification->id }}')"
                                        class="p-1 text-red-600 hover:bg-red-100 rounded"
                                        title="Hapus"
                                    >
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="px-4 py-8 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada notifikasi</h3>
                    <p class="mt-1 text-xs text-gray-500">Anda akan menerima notifikasi di sini</p>
                </div>
            @endforelse
        </div>

        <!-- Footer - View All -->
        @if($notifications->count() > 0)
            <div class="px-4 py-3 border-t border-gray-200 text-center">
                <a 
                    href="{{ route('admin.dashboard') }}" 
                    class="text-sm text-primary-600 hover:text-primary-700 font-semibold"
                >
                    Lihat Semua Notifikasi
                </a>
            </div>
        @endif
    </div>
</div>
