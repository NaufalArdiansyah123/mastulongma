<div class="min-h-screen bg-gray-50">
    <!-- Header with Blue Background -->
    <div class="bg-gradient-to-br from-primary-400 via-primary-500 to-primary-600 px-6 pt-8 pb-24">
        <div class="flex items-center justify-between mb-4">
            <a href="{{ route('dashboard') }}" class="text-white">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
            <h2 class="text-xl font-bold text-white absolute left-1/2 transform -translate-x-1/2">Notification</h2>
            <button class="bg-white p-2 rounded-full">
                <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                </svg>
            </button>
        </div>
    </div>

    <!-- Flash Message -->
    @if (session()->has('message'))
        <div class="px-6 -mt-20 mb-4 relative z-10">
            <div
                class="bg-gradient-to-r from-blue-500 to-blue-600 text-white px-5 py-3 rounded-2xl shadow-lg flex items-center gap-3">
                <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                        clip-rule="evenodd" />
                </svg>
                <span class="font-medium text-sm">{{ session('message') }}</span>
            </div>
        </div>
    @endif

    <!-- Notifications List with White Background Card -->
    <div class="px-6 -mt-16 pb-24">
        <div class="bg-gray-50 rounded-t-3xl min-h-[75vh] p-6">
            @if($notifications->count() > 0)
                @php
                    $groupedNotifications = $notifications->groupBy(function ($notification) {
                        $date = $notification->created_at;
                        if ($date->isToday()) {
                            return 'Today';
                        } elseif ($date->isYesterday()) {
                            return 'Yesterday';
                        } elseif ($date->isCurrentWeek()) {
                            return 'This Week';
                        } else {
                            return 'Older';
                        }
                    });
                @endphp

                @foreach(['Today', 'Yesterday', 'This Week', 'Older'] as $period)
                    @if(isset($groupedNotifications[$period]))
                        <div class="mb-6">
                            <h3 class="text-sm font-semibold text-gray-600 mb-3">{{ $period }}</h3>
                            <div class="space-y-3">
                                @foreach($groupedNotifications[$period] as $notification)
                                    @php
                                        $data = $notification->data;
                                        $isUnread = is_null($notification->read_at);
                                    @endphp

                                    <div wire:key="notification-{{ $notification->id }}"
                                        class="flex items-start gap-3 p-3 hover:bg-gray-100/30 rounded-xl transition-colors cursor-pointer {{ $isUnread ? 'bg-blue-50/30' : '' }}">
                                        <!-- Icon -->
                                        <div
                                            class="w-12 h-12 rounded-xl flex items-center justify-center flex-shrink-0 {{ $isUnread ? 'bg-gradient-to-br from-primary-400 to-primary-600' : 'bg-gray-100' }}">
                                            <span class="text-xl">
                                                @if($data['type'] === 'help_taken')
                                                    🎉
                                                @else
                                                    🔔
                                                @endif
                                            </span>
                                        </div>

                                        <!-- Content -->
                                        <div class="flex-1 min-w-0">
                                            <div class="flex items-start justify-between mb-1">
                                                <h4 class="font-semibold text-gray-900 text-sm">
                                                    @if($data['type'] === 'help_taken')
                                                        Bantuan Diambil!
                                                    @else
                                                        Notifikasi Baru
                                                    @endif
                                                </h4>
                                                @if($isUnread)
                                                    <span class="bg-primary-500 h-2 w-2 rounded-full flex-shrink-0 ml-2 mt-1"></span>
                                                @endif
                                            </div>

                                            <p class="text-xs text-gray-600 mb-2 leading-relaxed">{{ $data['message'] }}</p>

                                            <!-- Details -->
                                            <div class="flex items-center justify-between">
                                                <div class="flex items-center gap-2 text-xs">
                                                    @if(isset($data['help_amount']))
                                                        <span class="text-primary-600 font-bold">
                                                            Rp {{ number_format($data['help_amount'], 0, ',', '.') }}
                                                        </span>
                                                        <span class="text-gray-400">•</span>
                                                    @endif
                                                </div>
                                                <span
                                                    class="text-xs text-primary-500 font-medium">{{ $notification->created_at->format('H:i - M d') }}</span>
                                            </div>

                                            <!-- Actions -->
                                            <div class="flex items-center gap-3 mt-3">
                                                @if($isUnread)
                                                    <button wire:click="markAsRead('{{ $notification->id }}')"
                                                        class="text-xs font-semibold text-primary-600 hover:text-primary-700">
                                                        Tandai Dibaca
                                                    </button>
                                                @endif
                                                <button wire:click="deleteNotification('{{ $notification->id }}')"
                                                    class="text-xs font-semibold text-red-500 hover:text-red-600">
                                                    Hapus
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    @if(!$loop->last)
                                        <div class="border-t-2 border-gray-300"></div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    @endif
                @endforeach

                <!-- Mark All as Read Button -->
                @if($unreadCount > 0)
                    <div class="mt-6 text-center">
                        <button wire:click="markAllAsRead"
                            class="text-sm font-semibold text-primary-600 hover:text-primary-700 px-6 py-2 rounded-full hover:bg-primary-50 transition-all">
                            Tandai Semua Dibaca ({{ $unreadCount }})
                        </button>
                    </div>
                @endif

                <!-- Pagination -->
                @if($notifications->hasPages())
                    <div class="mt-8">
                        {{ $notifications->links() }}
                    </div>
                @endif
            @else
                <!-- Empty State -->
                <div class="text-center py-20">
                    <div
                        class="bg-gradient-to-br from-gray-100 to-gray-200 w-24 h-24 rounded-3xl flex items-center justify-center mx-auto mb-6">
                        <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-800 mb-2">Belum Ada Notifikasi</h3>
                    <p class="text-sm text-gray-500 max-w-xs mx-auto">Notifikasi Anda akan muncul di sini</p>
                </div>
            @endif
        </div>
    </div>
</div>