<!-- Mitra Chat Page (WhatsApp-like UI adjusted to project colors) -->
<div class="min-h-screen bg-gradient-to-b from-gray-50 to-white pb-24">
    @if(!$selected_help_id)
        <!-- Conversations List -->
        <div class="max-w-md mx-auto px-4 pt-6">
            <div class="flex items-center justify-between mb-4">
                <h1 class="text-2xl font-bold text-gray-900">Chat</h1>
                <div class="w-8"></div>
            </div>

            <div class="relative mb-4">
                <input type="text" wire:model.live="search" placeholder="Cari percakapan..."
                    class="w-full px-4 py-2.5 rounded-full bg-white text-gray-900 placeholder-gray-400 border border-gray-200 focus:ring-2 focus:ring-primary-500 outline-none text-sm shadow-sm">
                <svg class="absolute right-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>

            <!-- Conversations List -->
            <div class="px-6">
                @if($conversations && $conversations->count() > 0)
                    <div class="space-y-3">
                        @foreach($conversations as $conversation)
                            <button wire:click="selectHelp({{ $conversation->id }})"
                                class="w-full px-4 py-3 rounded-xl hover:bg-gray-100 transition text-left {{ $selected_help_id === $conversation->id ? 'bg-primary-50 border border-primary-200' : 'bg-white border border-gray-200' }}">
                                <div class="flex items-start gap-3">
                                    <!-- Avatar -->
                                    <div
                                        class="w-12 h-12 rounded-full bg-gradient-to-br from-orange-300 to-orange-400 flex items-center justify-center flex-shrink-0 text-white font-semibold text-sm">
                                        {{ strtoupper(substr($conversation->user->name ?? 'U', 0, 1)) }}
                                    </div>

                                    <!-- Content -->
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-start justify-between gap-2 mb-1">
                                            <h3 class="font-semibold text-gray-900 text-sm truncate">
                                                {{ $conversation->user->name ?? 'Unknown' }}
                                            </h3>
                                            <span
                                                class="text-xs text-gray-500 flex-shrink-0">{{ $conversation->updated_at->format('H:i') }}</span>
                                        </div>
                                        <p class="text-xs text-gray-600 truncate">
                                            {{ $conversation->chatMessages->first()?->message ?? 'Mulai percakapan...' }}
                                        </p>
                                        <p class="text-xs text-gray-500 mt-0.5">{{ $conversation->description }}</p>
                                    </div>

                                    <!-- Unread Badge -->
                                    @if($conversation->chatMessages->first()?->sender_type === 'customer' && !$conversation->chatMessages->first()?->read_at)
                                        <div class="w-2 h-2 rounded-full bg-primary-500 flex-shrink-0 mt-2"></div>
                                    @endif
                                </div>
                            </button>
                        @endforeach
                    </div>
                @else
                    <!-- Empty State -->
                    <div class="flex flex-col items-center justify-center py-12 text-center">
                        <svg class="w-16 h-16 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                        </svg>
                        <p class="text-gray-600 font-medium mb-1">Tidak ada percakapan</p>
                        <p class="text-gray-400 text-sm">Percakapan akan muncul saat Anda mulai membantu customer</p>
                    </div>
                @endif
            </div>
    @else
        <!-- Chat detail (WhatsApp-like) -->
        <div class="max-w-md mx-auto h-screen flex flex-col relative">
            <!-- Header (sticky) -->
            <div class="sticky top-0 z-30 bg-white border-b border-gray-200">
                <div class="flex items-center gap-3 px-4 py-3">
                    <button wire:click="$set('selected_help_id', null)" class="p-1.5">
                        <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                    </button>
                    <div class="w-10 h-10 rounded-full bg-primary-600 text-white flex items-center justify-center font-semibold">{{ strtoupper(substr($selected_help->user->name ?? 'U',0,1)) }}</div>
                    <div class="flex-1 min-w-0">
                        <div class="font-semibold text-gray-900 truncate">{{ $selected_help->user->name ?? 'Customer' }}</div>
                        <div class="text-xs text-gray-500 truncate">{{ $selected_help->description }}</div>
                    </div>
                    @if(optional($selected_help->user)->id)
                        <a href="{{ auth()->user() && auth()->user()->role === 'mitra' ? route('mitra.reports.create.user', optional($selected_help->user)->id) : route('customer.reports.create.user', optional($selected_help->user)->id) }}"
                            class="ml-2 p-2 text-sm text-red-600 rounded-lg hover:bg-red-50">Laporkan</a>
                    @endif
                </div>
            </div>

            <!-- Messages wrapper -->
            <div id="mitraMessagesWrapper" class="flex-1 overflow-auto px-4 py-4 bg-gradient-to-b from-gray-50 to-white" tabindex="0">
                <div class="space-y-3 max-w-full">
                    @if($messages && $messages->count() > 0)
                        @foreach($messages as $msg)
                            <div class="flex {{ $msg->sender_type === 'mitra' ? 'justify-end' : 'justify-start' }}">
                                <div class="whatsapp-bubble {{ $msg->sender_type === 'mitra' ? 'sent' : 'received' }}">
                                    <p class="text-sm leading-snug break-words">{{ $msg->message }}</p>
                                    <div class="text-xs mt-1 text-gray-300 text-right">{{ $msg->created_at->format('H:i') }}</div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="text-center text-gray-500 py-12">Mulai percakapan dengan customer</div>
                    @endif
                </div>
            </div>

            <!-- Input (fixed on mobile, sticky on desktop) -->
            <form wire:submit.prevent="sendMessage" class="chat-input-container px-4"> 
                <div class="max-w-md mx-auto flex items-center gap-3">
                    <input type="text" wire:model.defer="message" placeholder="Tulis pesan..."
                        class="flex-1 px-4 py-3 rounded-full bg-white border border-gray-200 shadow-sm focus:ring-2 focus:ring-primary-500 outline-none text-sm">
                    <button type="submit" class="bg-primary-600 hover:bg-primary-700 text-white rounded-full p-3">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M3.5 20.5l17-8.5L3.5 3.5v6l10 2-10 2v6z" />
                        </svg>
                    </button>
                </div>
            </form>
        </div>
    @endif

    <style>
        /* WhatsApp-like bubbles adjusted to project colors */
        .whatsapp-bubble {
            max-width: 72%;
            padding: .6rem .9rem;
            border-radius: 18px;
            box-shadow: 0 2px 6px rgba(2,6,23,0.04);
        }

        .whatsapp-bubble.received {
            background: #f7fafc; /* light */
            color: #111827;
            border-bottom-left-radius: 6px;
        }

        .whatsapp-bubble.sent {
            background: linear-gradient(180deg,#0ea5e9,#0ea5e9); /* primary-ish */
            color: white;
            border-bottom-right-radius: 6px;
        }

        /* Input container fixed on small screens */
        .chat-input-container {
            position: fixed;
            left: 0;
            right: 0;
            bottom: calc(env(safe-area-inset-bottom, 0px) + 12px);
            padding-left: 16px;
            padding-right: 16px;
            z-index: 40;
            background: transparent;
        }

        @media (min-width: 768px) {
            .chat-input-container {
                position: sticky;
                bottom: 0;
                background: white;
                padding: 12px 16px;
            }
        }

        /* make sure messages area has room for the fixed input */
        #mitraMessagesWrapper { padding-bottom: 120px; }

    </style>
</div>