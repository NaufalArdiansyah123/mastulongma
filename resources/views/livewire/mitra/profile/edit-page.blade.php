<div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <div class="bg-gradient-to-br from-primary-400 via-primary-500 to-primary-600 px-6 py-4">
        <div class="flex items-center justify-between">
            <a href="{{ route('mitra.profile') }}" class="text-white">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
            <h1 class="text-xl font-bold text-white">Edit Profil Mitra</h1>
            <div class="w-6"></div>
        </div>
    </div>

    <div class="px-6 py-6 pb-24">
        <div class="bg-white rounded-3xl shadow-lg p-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
               

                <div class="md:col-span-2 p-3">
                    @if(session()->has('message'))
                        <div
                            class="mb-3 p-2.5 bg-green-50 border border-green-200 rounded-lg text-xs text-green-600 flex items-center">
                            <svg class="w-4 h-4 mr-1.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd" />
                            </svg>
                            {{ session('message') }}
                        </div>
                    @endif

                    <form wire:submit.prevent="save" class="space-y-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1.5">
                                <span class="flex items-center">
                                    <svg class="w-3.5 h-3.5 mr-1.5 text-primary-500" fill="currentColor"
                                        viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    Nama
                                    <span class="text-red-500 ml-1">*</span>
                                </span>
                            </label>
                            <input type="text" wire:model="name" required
                                class="w-full px-3.5 py-3 text-sm rounded-xl border-2 border-gray-200 focus:border-primary-400 focus:ring-2 focus:ring-primary-200 transition bg-white shadow-sm"
                                placeholder="Nama">
                            @error('name')
                                <p class="mt-1.5 text-xs text-red-600 flex items-center">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1.5">
                                <span class="flex items-center">
                                    <svg class="w-3.5 h-3.5 mr-1.5 text-primary-500" fill="currentColor"
                                        viewBox="0 0 20 20">
                                        <path
                                            d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                                        <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                                    </svg>
                                    Email
                                    <span class="text-red-500 ml-1">*</span>
                                </span>
                            </label>
                            <input type="email" wire:model="email" required
                                class="w-full px-3.5 py-3 text-sm rounded-xl border-2 border-gray-200 focus:border-primary-400 focus:ring-2 focus:ring-primary-200 transition bg-white shadow-sm"
                                placeholder="email@contoh.com">
                            @error('email')
                                <p class="mt-1.5 text-xs text-red-600 flex items-center">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1.5">
                                <span class="flex items-center">
                                    <svg class="w-3.5 h-3.5 mr-1.5 text-gray-500" fill="currentColor"
                                        viewBox="0 0 20 20">
                                        <path
                                            d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z" />
                                    </svg>
                                    Telepon
                                    <span class="text-gray-400 text-xs ml-1">(Opsional)</span>
                                </span>
                            </label>
                            <input type="tel" wire:model="phone"
                                class="w-full px-3.5 py-3 text-sm rounded-xl border-2 border-gray-200 focus:border-primary-400 focus:ring-2 focus:ring-primary-200 transition bg-white shadow-sm"
                                placeholder="08xxxxxxxxxx">
                            @error('phone')
                                <p class="mt-1.5 text-xs text-red-600 flex items-center">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1.5">
                                <span class="flex items-center">
                                    <svg class="w-3.5 h-3.5 mr-1.5 text-gray-500" fill="currentColor"
                                        viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    Kota
                                    <span class="text-gray-400 text-xs ml-1">(Opsional)</span>
                                </span>
                            </label>
                            <select wire:model="city_id"
                                class="w-full px-3.5 py-3 text-sm rounded-xl border-2 border-gray-200 focus:border-primary-400 focus:ring-2 focus:ring-primary-200 transition bg-white shadow-sm">
                                <option value="">-- Pilih Kota --</option>
                                @foreach($cities as $city)
                                    <option value="{{ $city->id }}">{{ $city->name }}</option>
                                @endforeach
                            </select>
                            @error('city_id')
                                <p class="mt-1.5 text-xs text-red-600 flex items-center">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-xs font-bold text-gray-700 mb-1.5">
                                <span class="flex items-center">
                                    <svg class="w-3.5 h-3.5 mr-1.5 text-gray-500" fill="currentColor"
                                        viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    Alamat
                                    <span class="text-gray-400 text-xs ml-1">(Opsional)</span>
                                </span>
                            </label>
                            <textarea wire:model="address" rows="3"
                                class="w-full px-3.5 py-3 text-sm rounded-xl border-2 border-gray-200 focus:border-primary-400 focus:ring-2 focus:ring-primary-200 transition resize-none bg-white shadow-sm"
                                placeholder="Alamat lengkap"></textarea>
                            @error('address')
                                <p class="mt-1.5 text-xs text-red-600 flex items-center">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-xs font-bold text-gray-700 mb-1.5">Bio / Deskripsi singkat</label>
                            <textarea wire:model="bio" rows="3"
                                class="w-full px-3.5 py-3 text-sm rounded-xl border-2 border-gray-200 focus:border-primary-400 focus:ring-2 focus:ring-primary-200 transition resize-none bg-white shadow-sm"
                                placeholder="Deskripsikan singkat tentang Anda (opsional)"></textarea>
                            @error('bio')
                                <p class="mt-1.5 text-xs text-red-600 flex items-center">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="md:col-span-2">
                            <button type="submit" wire:loading.attr="disabled"
                                class="w-full bg-gradient-to-r from-primary-400 to-primary-600 text-white font-bold text-sm py-3.5 rounded-xl hover:shadow-lg transition disabled:opacity-50 disabled:cursor-not-allowed shadow-md">
                                <span wire:loading.remove wire:target="save" class="flex items-center justify-center">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                    Update Profile
                                </span>
                                <span wire:loading wire:target="save" class="flex items-center justify-center">
                                    <svg class="animate-spin h-4 w-4 mr-2 text-white" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                            stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor"
                                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                        </path>
                                    </svg>
                                    Updating...
                                </span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>