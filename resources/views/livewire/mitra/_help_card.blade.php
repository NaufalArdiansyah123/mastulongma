@php
    // Prefer user's selfie_photo or photo fields (legacy 'avatar' not present)
    $avatar = $help->user->selfie_photo ?? $help->user->photo ?? null;
    $name = $help->user->name ?? 'User';
    // Prefer showing the help's photo as the card image when available,
    // otherwise fall back to user's avatar/selfie photo.
    $cardImage = $help->photo ?? $avatar;
@endphp

<a href="{{ route('mitra.help.detail', $help->id) }}"
    class="relative block shrink-0 w-44 sm:w-48 h-40 bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-lg transform hover:-translate-y-1 transition overflow-hidden snap-start">
    <div class="h-full flex flex-col p-3">
        <div class="flex items-center justify-between mb-1">
            <div class="flex items-center gap-3">
                @if($cardImage)
                    <img src="{{ asset('storage/' . $cardImage) }}" alt="image"
                        class="w-10 h-10 rounded-xl object-cover ring-1 ring-white shadow-sm">
                @else
                    <div class="w-9 h-9 rounded-full bg-primary-100 flex items-center justify-center text-lg">💰</div>
                @endif
                <div class="flex flex-col">
                    <div class="text-sm font-semibold text-gray-900 truncate max-w-[150px]">{{ $name }}</div>
                    <div class="text-[11px] text-gray-400">{{ $help->created_at->diffForHumans() }}</div>
                </div>
            </div>
            <div class="text-[11px] text-gray-500 px-2 py-0.5 rounded-md bg-gray-50">
                {{ $help->category->name ?? '' }}
            </div>
        </div>

        <div class="flex-1 mt-1">
            <div class="text-sm text-gray-700 font-medium leading-snug truncate">
                {{ $help->title ?? Str::limit($help->description, 80) }}
            </div>
            <div class="text-xs text-gray-500 mt-1 truncate">{{ Str::limit($help->description, 80) }}</div>
        </div>

        <div class="mt-3 flex items-center justify-between">
            <div class="inline-flex items-center gap-2">
                <span class="text-sm px-2 py-1 rounded-full bg-green-50 text-green-700 font-semibold">Rp
                    {{ number_format($help->estimated_price ?? $help->amount ?? 0, 0, ',', '.') }}</span>
                @if(isset($help->rating) && $help->rating)
                    <span class="text-xs text-yellow-500">★ {{ number_format($help->rating, 1) }}</span>
                @endif
            </div>
            <div class="text-xs text-gray-500">{{ $help->city->name ?? '-' }}</div>
        </div>
    </div>
</a>