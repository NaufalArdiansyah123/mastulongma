<div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <div class="bg-gradient-to-br from-primary-400 via-primary-500 to-primary-600 text-white px-5 pt-6 pb-8">
        <div class="flex items-center justify-between mb-2">
            <a href="{{ route('dashboard') }}" class="text-white">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
            <h2 class="text-xl font-bold text-gray-900">
                @if(request()->routeIs('helps.available'))
                    Bantuan Tersedia
                @elseif(auth()->user()->isKustomer())
                    Permintaan Saya
                @else
                    Bantuan Saya
                @endif
            </h2>
            <div class="w-6"></div>
        </div>
        <p class="text-sm text-gray-700 text-center">
            @if(request()->routeIs('helps.available'))
                Pilih bantuan yang ingin Anda berikan
            @elseif(auth()->user()->isKustomer())
                Kelola permintaan bantuan Anda
            @else
                Pantau status bantuan
            @endif
        </p>
    </div>

    <!-- Flash Messages -->
    @if (session()->has('message'))
        <div class="mx-4 mt-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-2xl">
            {{ session('message') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="mx-4 mt-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-2xl">
            {{ session('error') }}
        </div>
    @endif

    <!-- Filter -->
    @if(!request()->routeIs('helps.available'))
        <div class="px-4 py-4 bg-white border-b">
            <div class="flex gap-2 overflow-x-auto">
                <button wire:click="$set('statusFilter', 'all')"
                    class="px-4 py-2 rounded-full text-sm font-medium whitespace-nowrap transition {{ $statusFilter === 'all' ? 'bg-primary-400 text-white shadow-md' : 'bg-gray-100 text-gray-700' }}">
                    Semua
                </button>
                <button wire:click="$set('statusFilter', 'pending')"
                    class="px-4 py-2 rounded-full text-sm font-medium whitespace-nowrap transition {{ $statusFilter === 'pending' ? 'bg-yellow-500 text-white shadow-md' : 'bg-gray-100 text-gray-700' }}">
                    Pending
                </button>
                <button wire:click="$set('statusFilter', 'approved')"
                    class="px-4 py-2 rounded-full text-sm font-medium whitespace-nowrap transition {{ $statusFilter === 'approved' ? 'bg-blue-500 text-white shadow-md' : 'bg-gray-100 text-gray-700' }}">
                    Disetujui
                </button>
                <button wire:click="$set('statusFilter', 'taken')"
                    class="px-4 py-2 rounded-full text-sm font-medium whitespace-nowrap transition {{ $statusFilter === 'taken' ? 'bg-purple-500 text-white shadow-md' : 'bg-gray-100 text-gray-700' }}">
                    Diambil
                </button>
                <button wire:click="$set('statusFilter', 'completed')"
                    class="px-4 py-2 rounded-full text-sm font-medium whitespace-nowrap transition {{ $statusFilter === 'completed' ? 'bg-green-500 text-white shadow-md' : 'bg-gray-100 text-gray-700' }}">
                    Selesai
                </button>
            </div>
        </div>
    @endif

    <!-- Helps List -->
    <div class="px-4 py-4 pb-24 space-y-4">
        @forelse($helps as $help)
            <div class="bg-white rounded-2xl shadow-md overflow-hidden border border-gray-100">
                @if($help->photo)
                    <img src="{{ Storage::url($help->photo) }}" alt="{{ $help->title }}" class="w-full h-40 object-cover">
                @endif

                <div class="p-4">
                    <div class="flex items-start justify-between mb-2">
                        <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold"
                            style="background-color: {{ $help->category->color }}20; color: {{ $help->category->color }}">
                            {{ $help->category->icon }} {{ $help->category->name }}
                        </span>
                        <span class="px-2 py-1 rounded-full text-xs font-semibold
                                    @if($help->status == 'pending') bg-yellow-100 text-yellow-800
                                    @elseif($help->status == 'approved') bg-blue-100 text-blue-800
                                    @elseif($help->status == 'taken' || $help->status == 'in_progress') bg-purple-100 text-purple-800
                                    @elseif($help->status == 'completed') bg-green-100 text-green-800
                                    @else bg-gray-100 text-gray-800
                                    @endif">
                            {{ ucfirst($help->status) }}
                        </span>
                    </div>

                    <h3 class="font-bold text-lg text-gray-900 mb-2">{{ $help->title }}</h3>
                    <p class="text-gray-600 text-sm mb-3 line-clamp-2">{{ $help->description }}</p>

                    <div class="flex items-center justify-between text-sm mb-3">
                        <div class="flex items-center space-x-3 text-gray-500">
                            @if(auth()->user()->isMitra() || request()->routeIs('helps.available'))
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    {{ $help->user->name }}
                                </span>
                            @endif
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z"
                                        clip-rule="evenodd" />
                                </svg>
                                {{ $help->city->name }}
                            </span>
                        </div>
                        <span class="text-xs text-gray-500">{{ $help->created_at->diffForHumans() }}</span>
                    </div>

                    @if($help->location)
                        <div class="text-sm text-gray-600 mb-3">
                            📍 {{ $help->location }}
                        </div>
                    @endif

                    @if($help->mitra && auth()->user()->isKustomer())
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-3 mb-3">
                            <p class="text-sm text-blue-800 font-semibold mb-1">Mitra yang Membantu:</p>
                            <p class="text-sm text-blue-700">{{ $help->mitra->name }}</p>
                            <p class="text-xs text-blue-600">{{ $help->mitra->phone }}</p>
                        </div>
                    @endif

                    <!-- Actions -->
                    @if(auth()->user()->isMitra())
                        @if(request()->routeIs('helps.available'))
                            <button wire:click="takeHelp({{ $help->id }})"
                                wire:confirm="Apakah Anda yakin ingin mengambil bantuan ini?"
                                class="w-full bg-gradient-to-r from-primary-400 to-primary-500 text-white px-6 py-3 rounded-2xl font-semibold shadow-md hover:shadow-lg transition">
                                🤝 Ambil Bantuan
                            </button>
                        @elseif($help->status == 'taken' || $help->status == 'in_progress')
                            <button wire:click="completeHelp({{ $help->id }})"
                                wire:confirm="Apakah bantuan sudah selesai diberikan?"
                                class="w-full bg-gradient-to-r from-green-400 to-green-500 text-white px-6 py-3 rounded-2xl font-semibold shadow-md hover:shadow-lg transition">
                                ✅ Tandai Selesai
                            </button>
                        @endif
                    @endif
                </div>
            </div>
        @empty
            <div class="text-center py-12">
                <svg class="w-20 h-20 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <p class="text-gray-500 text-lg font-medium">Belum ada data</p>
                @if(auth()->user()->isKustomer())
                    <p class="text-gray-400 text-sm mb-4">Mulai dengan membuat permintaan bantuan</p>
                    <a href="{{ route('helps.create') }}"
                        class="inline-block bg-primary-400 text-white px-6 py-3 rounded-2xl font-semibold shadow-md hover:shadow-lg transition">
                        + Buat Permintaan
                    </a>
                @endif
            </div>
        @endforelse

        <!-- Pagination -->
        <div class="mt-6">
            {{ $helps->links() }}
        </div>
    </div>
</div>