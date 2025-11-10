<div class="min-h-screen bg-gray-50">
    <!-- Hero Section -->
    <div class="bg-gradient-to-br from-primary-400 via-primary-500 to-primary-600 text-white px-5 pt-6 pb-8">
        <div class="flex items-start justify-between mb-6">
            <div>
                <h1 class="text-xl font-bold text-gray-900">Platform Bantuan</h1>
                <p class="text-sm text-gray-700">Saling membantu sesama</p>
            </div>
            @auth
                <a href="{{ route('profile.edit') }}" class="bg-white p-2.5 rounded-full shadow-md">
                    <svg class="w-5 h-5 text-gray-700" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 3c1.66 0 3 1.34 3 3s-1.34 3-3 3-3-1.34-3-3 1.34-3 3-3zm0 14.2c-2.5 0-4.71-1.28-6-3.22.03-1.99 4-3.08 6-3.08 1.99 0 5.97 1.09 6 3.08-1.29 1.94-3.5 3.22-6 3.22z" />
                    </svg>
                </a>
            @else
                <a href="{{ route('login') }}" class="bg-white p-2.5 rounded-full shadow-md">
                    <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                    </svg>
                </a>
            @endauth
        </div>

        <div class="text-center">
            <div class="flex gap-3 mb-4">
                @auth
                    @if(auth()->user()->isKustomer())
                        <a href="{{ route('helps.create') }}"
                            class="flex-1 bg-white text-primary-600 px-6 py-3 rounded-2xl font-semibold shadow-lg hover:shadow-xl transition">
                            📝 Butuh Bantuan
                        </a>
                    @endif

                    @if(auth()->user()->isMitra())
                        <a href="{{ route('helps.available') }}"
                            class="flex-1 bg-white text-primary-600 px-6 py-3 rounded-2xl font-semibold shadow-lg hover:shadow-xl transition">
                            🤝 Mau Bantu
                        </a>
                    @endif
                @else
                    <a href="{{ route('login') }}"
                        class="flex-1 bg-white text-primary-600 px-6 py-3 rounded-2xl font-semibold shadow-lg hover:shadow-xl transition">
                        📝 Butuh Bantuan
                    </a>
                    <a href="{{ route('login') }}"
                        class="flex-1 bg-white text-primary-600 px-6 py-3 rounded-2xl font-semibold shadow-lg hover:shadow-xl transition">
                        🤝 Mau Bantu
                    </a>
                @endauth
            </div>
        </div>
    </div>

    <!-- Search & Filter -->
    <div class="px-4 py-4 bg-white shadow-sm sticky top-0 z-30">
        <input type="text" wire:model.live.debounce.300ms="search" placeholder="🔍 Cari bantuan..."
            class="w-full px-4 py-3 rounded-2xl border-2 border-gray-200 focus:border-primary-400 focus:ring-2 focus:ring-primary-200 transition">

        <div class="flex gap-2 mt-3 overflow-x-auto pb-2">
            <button wire:click="$set('selectedCategory', null)"
                class="px-4 py-2 rounded-full text-sm font-medium whitespace-nowrap transition {{ $selectedCategory === null ? 'bg-primary-400 text-white shadow-md' : 'bg-gray-100 text-gray-700' }}">
                Semua
            </button>
            @foreach($categories as $category)
                <button wire:click="$set('selectedCategory', {{ $category->id }})"
                    class="px-4 py-2 rounded-full text-sm font-medium whitespace-nowrap transition {{ $selectedCategory == $category->id ? 'bg-primary-400 text-white shadow-md' : 'bg-gray-100 text-gray-700' }}">
                    {{ $category->icon }} {{ $category->name }}
                </button>
            @endforeach
        </div>

        <select wire:model.live="selectedCity"
            class="w-full mt-3 px-4 py-3 rounded-2xl border-2 border-gray-200 focus:border-primary-400 focus:ring-2 focus:ring-primary-200 transition">
            <option value="">📍 Semua Kota</option>
            @foreach($cities as $city)
                <option value="{{ $city->id }}">{{ $city->name }}</option>
            @endforeach
        </select>
    </div>

    <!-- Helps List -->
    <div class="px-4 py-4 pb-24 space-y-4">
        @forelse($helps as $help)
            <div class="bg-white rounded-2xl shadow-md overflow-hidden border border-gray-100 hover:shadow-lg transition">
                @if($help->photo)
                    <img src="{{ Storage::url($help->photo) }}" alt="{{ $help->title }}" class="w-full h-40 object-cover">
                @endif

                <div class="p-4">
                    <div class="flex items-start justify-between mb-2">
                        <div>
                            <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold"
                                style="background-color: {{ $help->category->color }}20; color: {{ $help->category->color }}">
                                {{ $help->category->icon }} {{ $help->category->name }}
                            </span>
                        </div>
                        <span class="text-xs text-gray-500">{{ $help->created_at->diffForHumans() }}</span>
                    </div>

                    <h3 class="font-bold text-lg text-gray-900 mb-2">{{ $help->title }}</h3>
                    <p class="text-gray-600 text-sm mb-3 line-clamp-2">{{ $help->description }}</p>

                    <div class="flex items-center justify-between text-sm">
                        <div class="flex items-center space-x-3 text-gray-500">
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                        clip-rule="evenodd" />
                                </svg>
                                {{ $help->user->name }}
                            </span>
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z"
                                        clip-rule="evenodd" />
                                </svg>
                                {{ $help->city->name }}
                            </span>
                        </div>
                    </div>

                    @auth
                        @if(auth()->user()->isMitra())
                            <button wire:click="takeHelp({{ $help->id }})"
                                class="w-full mt-4 bg-gradient-to-r from-primary-400 to-primary-500 text-white px-6 py-3 rounded-2xl font-semibold shadow-md hover:shadow-lg transition">
                                🤝 Ambil Bantuan
                            </button>
                        @endif
                    @else
                        <a href="{{ route('login') }}"
                            class="block w-full mt-4 bg-gradient-to-r from-primary-400 to-primary-500 text-white px-6 py-3 rounded-2xl font-semibold shadow-md hover:shadow-lg transition text-center">
                            Login untuk Membantu
                        </a>
                    @endauth
                </div>
            </div>
        @empty
            <div class="text-center py-12">
                <svg class="w-20 h-20 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <p class="text-gray-500 text-lg font-medium">Tidak ada bantuan tersedia</p>
                <p class="text-gray-400 text-sm">Coba ubah filter pencarian Anda</p>
            </div>
        @endforelse

        <!-- Pagination -->
        <div class="mt-6">
            {{ $helps->links() }}
        </div>
    </div>
</div>