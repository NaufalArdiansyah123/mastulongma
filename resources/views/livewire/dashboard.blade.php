<div class="min-h-screen bg-gradient-to-br from-primary-400 via-primary-500 to-primary-600">
    <!-- Header Section -->
    <div class="px-5 pt-6 pb-4">
        <div class="flex items-start justify-between mb-6">
            <div>
                <h1 class="text-xl font-bold text-gray-900">Hi, Welcome Back</h1>
                <p class="text-sm text-gray-700">
                    @php
                        $hour = date('H');
                        if ($hour < 12)
                            echo 'Good Morning';
                        elseif ($hour < 18)
                            echo 'Good Afternoon';
                        else
                            echo 'Good Evening';
                    @endphp
                </p>
            </div>
            <button class="bg-white p-2.5 rounded-full shadow-md">
                <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                </svg>
            </button>
        </div>

        <!-- Balance Cards -->
        <div class="grid grid-cols-2 gap-3 mb-4">
            <!-- Total Balance -->
            <div>
                <div class="flex items-center text-gray-700 mb-1">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                    </svg>
                    <span class="text-xs font-medium">Total Balance</span>
                </div>
                <div class="text-2xl font-bold text-white">$7,783.00</div>
            </div>

            <!-- Total Expense -->
            <div>
                <div class="flex items-center text-gray-700 mb-1">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <span class="text-xs font-medium">Total Expense</span>
                </div>
                <div class="text-2xl font-bold text-white">$10,187.40</div>
            </div>
        </div>

        <!-- Progress Bar -->
        <div class="bg-gray-900 rounded-full h-8 flex items-center px-1 mb-3">
            <div class="bg-white rounded-full px-3 py-1 text-xs font-bold text-gray-900">30%</div>
            <div class="flex-1"></div>
            <div class="text-white text-xs font-semibold pr-2">$20,000.00</div>
        </div>

        <!-- Expense Message -->
        <div class="flex items-center text-gray-800">
            <svg class="w-4 h-4 mr-1.5 text-gray-700" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd"
                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                    clip-rule="evenodd" />
            </svg>
            <span class="text-xs font-medium">30% Of Your Expenses, Looks Good.</span>
        </div>
    </div>

    <!-- Main Content Card -->
    <div class="bg-gray-50 rounded-t-3xl px-4 pt-6 pb-24 min-h-[60vh]">
        <!-- Info Card -->
        <div class="bg-gradient-to-br from-primary-400 to-primary-500 rounded-3xl p-5 mb-4 shadow-lg">
            <div class="flex items-center justify-between">
                <!-- Left Side - Help Icon -->
                <div class="flex flex-col items-center">
                    <div class="bg-primary-300 bg-opacity-40 p-4 rounded-full mb-2">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                    <span class="text-white text-xs font-semibold">Bantuan</span>
                    <span class="text-white text-xs">Tersedia</span>
                </div>

                <!-- Divider -->
                <div class="w-px h-20 bg-white bg-opacity-30 mx-3"></div>

                <!-- Right Side - Stats -->
                <div class="flex-1 space-y-3">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-white mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            <div>
                                <div class="text-white text-xs opacity-90">Total Butuh Bantuan</div>
                                <div class="text-white font-bold">{{ $availableHelps->count() }} Orang</div>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-white mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                            </svg>
                            <div>
                                <div class="text-white text-xs opacity-90">Menunggu Mitra</div>
                                <div class="text-white font-bold">{{ $availableHelps->count() }} Bantuan</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Period Tabs -->
        <div class="flex bg-primary-50 rounded-2xl p-1 mb-4">
            <button class="flex-1 py-2.5 text-sm font-medium text-gray-600 rounded-xl transition">Terbaru</button>
            <button class="flex-1 py-2.5 text-sm font-medium text-gray-600 rounded-xl transition">Kategori</button>
            <button
                class="flex-1 py-2.5 text-sm font-medium bg-primary-400 text-white rounded-xl shadow-md transition">Semua</button>
        </div>

        <!-- People Who Need Help List -->
        <div class="space-y-3">
            @forelse($availableHelps as $help)
                <div
                    class="flex items-center justify-between bg-white rounded-2xl p-4 shadow-sm hover:shadow-md transition">
                    <div class="flex items-center space-x-3">
                        <div class="p-3 rounded-2xl" style="background-color: {{ $help->category->color }}20;">
                            <span class="text-2xl">{{ $help->category->icon }}</span>
                        </div>
                        <div class="flex-1">
                            <div class="font-semibold text-gray-900">{{ $help->user->name }}</div>
                            <div class="text-xs text-gray-500 mb-1">{{ $help->title }}</div>
                            <div class="flex items-center gap-2">
                                <span class="text-xs px-2 py-0.5 rounded-full"
                                    style="background-color: {{ $help->category->color }}20; color: {{ $help->category->color }}">
                                    {{ $help->category->name }}
                                </span>
                                <span class="text-xs text-gray-500">📍 {{ $help->city->name }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="text-right">
                        <div class="text-xs text-gray-500 mb-1">{{ $help->created_at->diffForHumans() }}</div>
                        @if(auth()->user()->isMitra())
                            <a href="{{ route('helps.available') }}"
                                class="inline-block text-xs font-semibold text-primary-600 hover:text-primary-700">
                                Lihat →
                            </a>
                        @else
                            <span class="text-xs text-gray-400">Butuh Bantuan</span>
                        @endif
                    </div>
                </div>
            @empty
                <div class="text-center py-8">
                    <svg class="w-16 h-16 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    <p class="text-gray-500 text-sm">Belum ada yang membutuhkan bantuan</p>
                </div>
            @endforelse
        </div>
    </div>
</div>