<div
    class="{{ $selected_help_id ? 'h-screen flex flex-col overflow-hidden' : 'pb-20 bg-gradient-to-br from-gray-50 to-gray-100 min-h-screen' }}">
    <div
        class="{{ $selected_help_id ? 'flex-1 flex flex-col overflow-hidden max-w-md mx-auto w-full' : 'max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8' }}">
        @unless($selected_help_id)
            <h1 class="text-3xl font-bold text-gray-900 mb-8 tracking-tight">Chat</h1>
        @endunless

        <div class="bg-white shadow-xl {{ $selected_help_id ? '' : 'rounded-2xl' }} overflow-hidden border border-gray-200 h-full">
            <!-- Chat panel (full width) -->
            <div class="flex flex-col h-full overflow-hidden relative">
                @if(!$selected_help_id)
                    <div class="p-8 flex-1 flex items-center justify-center bg-gradient-to-br from-gray-50 to-white">
                        <div class="text-center">
                            <div
                                class="w-24 h-24 rounded-full bg-gradient-to-br from-primary-100 to-primary-200 flex items-center justify-center mb-6 mx-auto">
                                <svg class="w-12 h-12 text-primary-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                </svg>
                            </div>
                            <h2 class="text-xl font-semibold text-gray-900 mb-2">Pilih percakapan</h2>
                            <p class="text-sm text-gray-500">Pilih percakapan di sebelah kiri untuk mulai mengobrol.</p>
                        </div>
                    </div>
                @else
                    <div
                        class="fixed top-0 left-1/2 -translate-x-1/2 max-w-md w-full z-30 border-b border-gray-200 px-4 py-3 flex items-center gap-3 bg-white shadow-sm">
                        <div class="flex items-center gap-3 flex-1">
                            <div
                                class="w-10 h-10 rounded-full bg-gradient-to-br from-primary-400 to-primary-600 overflow-hidden">
                                @if(optional($selected_help->mitra)->selfie_photo)
                                    <img src="{{ asset('storage/' . optional($selected_help->mitra)->selfie_photo) }}"
                                        alt="Mitra" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-white font-bold text-sm">
                                        {{ strtoupper(substr(optional($selected_help->mitra)->name ?? 'M', 0, 1)) }}
                                    </div>
                                @endif
                            </div>
                            <div class="flex-1 min-w-0">
                                <h3 class="font-semibold text-gray-900 text-base truncate">
                                    {{ $selected_help->mitra->name ?? 'Mitra' }}
                                </h3>
                                <p class="text-xs text-gray-500 truncate">{{ $selected_help->description }}</p>
                            </div>
                            @if(optional($selected_help->mitra)->id)
                                <a href="{{ auth()->user() && auth()->user()->role === 'mitra' ? route('mitra.reports.create.user', optional($selected_help->mitra)->id) : route('customer.reports.create.user', optional($selected_help->mitra)->id) }}"
                                    class="ml-2 p-2 text-sm text-red-600 rounded-lg hover:bg-red-50">Laporkan</a>
                            @endif
                        </div>
                    </div>

                    <div id="messagesWrapper" class="flex-1 overflow-auto wa-chat-bg" tabindex="0">
                        <div id="messagesContainer" class="px-4 pt-20 pb-32 space-y-2">
                            @if($messages && $messages->count() > 0)
                                @foreach($messages as $msg)
                                    <div
                                        class="flex {{ $msg->sender_type === 'customer' ? 'justify-end' : 'justify-start' }} animate-fade-in">
                                        <div
                                            class="relative max-w-[80%] px-3 py-2 {{ $msg->sender_type === 'customer' ? 'bg-gradient-to-br from-primary-500 to-primary-600 text-white rounded-tl-lg rounded-tr-lg rounded-bl-lg' : 'bg-white text-gray-900 rounded-tl-lg rounded-tr-lg rounded-br-lg shadow-sm' }}">
                                            <!-- WhatsApp-style tail -->
                                            @if($msg->sender_type === 'customer')
                                                <div class="absolute -right-2 bottom-0 w-0 h-0 border-l-[10px] border-l-primary-600 border-t-[10px] border-t-transparent"></div>
                                            @else
                                                <div class="absolute -left-2 bottom-0 w-0 h-0 border-r-[10px] border-r-white border-t-[10px] border-t-transparent"></div>
                                            @endif
                                            
                                            <p class="text-sm break-words leading-relaxed mb-1">{{ $msg->message }}</p>
                                            <div class="flex items-center justify-end gap-1">
                                                <p class="text-[10px] {{ $msg->sender_type === 'customer' ? 'text-primary-100' : 'text-gray-400' }}">
                                                    {{ $msg->created_at->format('H:i') }}
                                                </p>
                                                @if($msg->sender_type === 'customer')
                                                    <svg class="w-4 h-4 text-primary-100" fill="currentColor" viewBox="0 0 16 16">
                                                        <path d="M12.354 4.354a.5.5 0 0 0-.708-.708L5 10.293 1.854 7.146a.5.5 0 1 0-.708.708l3.5 3.5a.5.5 0 0 0 .708 0l7-7zm-4.208 7-.896-.897.707-.707.543.543 6.646-6.647a.5.5 0 0 1 .708.708l-7 7a.5.5 0 0 1-.708 0z"/>
                                                        <path d="m5.354 7.146.896.897-.707.707-.897-.896a.5.5 0 1 1 .708-.708z"/>
                                                    </svg>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="flex flex-col items-center justify-center py-16 text-center">
                                    <div
                                        class="w-16 h-16 rounded-full bg-gradient-to-br from-primary-100 to-primary-200 flex items-center justify-center mb-4">
                                        <svg class="w-8 h-8 text-primary-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                        </svg>
                                    </div>
                                    <p class="text-gray-600 text-sm font-medium">Mulai percakapan dengan mitra</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <form wire:submit.prevent="sendMessage"
                        class="px-3 py-2 bg-white shadow-lg sticky z-20 chat-input">
                        <div class="flex gap-2 items-end">
                            <input type="text" wire:model.defer="message" placeholder="Tulis pesan..."
                                class="flex-1 px-4 py-2.5 rounded-full bg-gray-100 text-gray-900 placeholder-gray-500 border-0 focus:bg-white focus:ring-2 focus:ring-primary-500 outline-none transition-all text-sm">
                            <button type="submit"
                                class="bg-gradient-to-r from-primary-600 to-primary-700 hover:from-primary-700 hover:to-primary-800 text-white rounded-full w-11 h-11 flex-shrink-0 transition-all shadow-md hover:shadow-lg active:scale-95 flex items-center justify-center">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                        d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                                </svg>
                            </button>
                        </div>
                    </form>
                @endif
            </div>
        </div>
    </div>

    <style>
        @keyframes fade-in {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in {
            animation: fade-in 0.3s ease-out;
        }

        /* WhatsApp-style chat background */
        .wa-chat-bg {
            background-color: #f0f2f5;
            background-image: 
                repeating-linear-gradient(45deg, transparent, transparent 35px, rgba(255,255,255,.05) 35px, rgba(255,255,255,.05) 70px);
        }

        /* Custom scrollbar */
        #messagesWrapper::-webkit-scrollbar,
        .overflow-auto::-webkit-scrollbar {
            width: 6px;
        }

        #messagesWrapper::-webkit-scrollbar-track,
        .overflow-auto::-webkit-scrollbar-track {
            background: transparent;
        }

        #messagesWrapper::-webkit-scrollbar-thumb,
        .overflow-auto::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }

        #messagesWrapper::-webkit-scrollbar-thumb:hover,
        .overflow-auto::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        /* Make chat input fixed on small screens so it's always above bottom nav */
        .chat-input {
            position: fixed;
            left: 50%;
            transform: translateX(-50%);
            bottom: calc(env(safe-area-inset-bottom, 0px) + 80px);
            width: calc(100% - 16px);
            max-width: 28rem;
            border-radius: 0;
            box-shadow: none;
            border-top: 1px solid #e5e7eb;
        }

        /* On larger screens, keep the form sticky inside the panel */
        @media (min-width: 768px) {
            .chat-input {
                position: sticky;
                left: auto;
                right: auto;
                margin: 0;
                bottom: 0;
                width: auto;
                max-width: none;
                border-radius: 0;
                box-shadow: none;
            }
        }
    </style>



    <script>
        (function () {
            function scrollToBottom() {
                const wrapper = document.getElementById('messagesWrapper');
                if (!wrapper) return;
                wrapper.scrollTop = wrapper.scrollHeight;
            }

            // Scroll on initial load
            document.addEventListener('DOMContentLoaded', scrollToBottom);

            // Livewire: scroll after updates (works for both v2/v3)
            if (window.Livewire) {
                window.Livewire.hook('message.processed', (message, component) => {
                    // small timeout to ensure DOM updated
                    setTimeout(scrollToBottom, 50);
                });
            } else {
                // Fallback: observe changes in the messages container and scroll wrapper
                const container = document.getElementById('messagesContainer');
                const wrapper = document.getElementById('messagesWrapper');
                if (container && wrapper) {
                    const obs = new MutationObserver(() => setTimeout(scrollToBottom, 50));
                    obs.observe(container, { childList: true, subtree: true });
                }
            }
        })();

    </script>
</div>
@if(isset($availableHelps) && $availableHelps->isEmpty())
    <script>
        document.body.style.overflow = 'hidden';
        document.documentElement.style.overflow = 'hidden';
    </script>
@endif