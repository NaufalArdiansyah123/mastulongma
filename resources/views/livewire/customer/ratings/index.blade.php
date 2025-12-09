<div class="min-h-screen bg-gray-50">
    <!-- Header Section -->
    <div class="px-5 pt-6 pb-4 bg-gradient-to-br from-primary-400 via-primary-500 to-primary-600 rounded-b-3xl">
        <div class="flex items-center justify-between mb-6">
            <a href="{{ route('profile') }}" class="bg-white p-2.5 rounded-full shadow-md hover:shadow-lg transition">
                <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
            <h1 class="text-xl font-bold text-white flex-1 text-center">Rating & Ulasan</h1>
            <div class="w-9"></div>
        </div>

        <!-- Rating Summary Card -->
        <div class="bg-white bg-opacity-20 backdrop-blur-sm rounded-2xl px-6 py-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-white opacity-90 text-sm">Rating Rata-rata</p>
                    <div class="flex items-center mt-1">
                        <span class="text-3xl font-bold text-white">{{ $averageRating }}</span>
                        <span class="text-white opacity-75 ml-2">/5.0</span>
                    </div>
                </div>
                <div class="text-right">
                    <div class="flex justify-end gap-1 mb-2">
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= $averageRating)
                                <svg class="w-5 h-5 text-yellow-300" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                            @else
                                <svg class="w-5 h-5 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                            @endif
                        @endfor
                    </div>
                    <p class="text-white opacity-90 text-sm">{{ $totalRatings }} ulasan</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Ratings List -->
    <div class="px-5 pt-6 pb-24">
        @if($ratings->count() > 0)
            <div class="space-y-4">
                @foreach($ratings as $rating)
                    <div class="bg-white rounded-2xl shadow-md p-5 hover:shadow-lg transition">
                        <div class="flex items-start justify-between mb-3">
                            <div>
                                <h3 class="font-bold text-gray-900">{{ optional($rating->rater)->name ?? 'Pengguna' }}</h3>
                                <p class="text-xs text-gray-500">{{ $rating->created_at->diffForHumans() }}</p>
                            </div>
                            <div class="flex gap-1">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= $rating->rating)
                                        <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                    @else
                                        <svg class="w-4 h-4 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                    @endif
                                @endfor
                            </div>
                        </div>

                        <p class="text-sm font-semibold text-gray-700 mb-2">{{ optional($rating->help)->title ?? '-' }}</p>

                        @if($rating->review)
                            <p class="text-sm text-gray-600 leading-relaxed mb-3">{{ $rating->review }}</p>
                        @endif

                        <div class="flex gap-2">
                            <span class="inline-block bg-primary-100 text-primary-700 px-3 py-1 rounded-full text-xs font-semibold">{{ $rating->rating }}.0 dari 5</span>
                            @if($rating->rating >= 4)
                                <span class="inline-block bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-semibold">✓ Puas</span>
                            @elseif($rating->rating >= 3)
                                <span class="inline-block bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-xs font-semibold">➜ Biasa</span>
                            @else
                                <span class="inline-block bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs font-semibold">✗ Kurang Puas</span>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            @if($ratings->hasPages())
                <div class="mt-8 pb-4">
                    {{ $ratings->links() }}
                </div>
            @endif
        @else
            <div class="bg-white rounded-2xl p-10 text-center shadow-md">
                <div class="text-5xl mb-3">⭐</div>
                <h3 class="text-lg font-bold text-gray-900 mb-2">Belum Ada Rating</h3>
                <p class="text-sm text-gray-600">Belum ada ulasan untuk profil Anda.</p>
            </div>
        @endif
    </div>
</div>
