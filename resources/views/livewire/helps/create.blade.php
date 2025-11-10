<div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <div class="bg-gradient-to-br from-primary-400 via-primary-500 to-primary-600 text-white px-5 pt-6 pb-8">
        <div class="flex items-center justify-between mb-2">
            <a href="{{ route('helps.index') }}" class="text-white">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
            <h2 class="text-xl font-bold text-gray-900">Buat Permintaan</h2>
            <div class="w-6"></div>
        </div>
        <p class="text-sm text-gray-700 text-center">Jelaskan kebutuhan bantuan Anda</p>
    </div>

    <!-- Form -->
    <div class="px-4 py-6 pb-24">
        <form wire:submit="save" class="space-y-5">
            <!-- Title -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Judul Bantuan *</label>
                <input type="text" wire:model="title" placeholder="Contoh: Butuh Bantuan Makanan"
                    class="w-full px-4 py-3 rounded-2xl border-2 border-gray-200 focus:border-primary-400 focus:ring-2 focus:ring-primary-200 transition">
                @error('title')
                    <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                @enderror
            </div>

            <!-- Category -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Kategori *</label>
                <select wire:model="category_id"
                    class="w-full px-4 py-3 rounded-2xl border-2 border-gray-200 focus:border-primary-400 focus:ring-2 focus:ring-primary-200 transition">
                    <option value="">Pilih Kategori</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->icon }} {{ $category->name }}</option>
                    @endforeach
                </select>
                @error('category_id')
                    <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                @enderror
            </div>

            <!-- City -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Kota *</label>
                <select wire:model="city_id"
                    class="w-full px-4 py-3 rounded-2xl border-2 border-gray-200 focus:border-primary-400 focus:ring-2 focus:ring-primary-200 transition">
                    <option value="">Pilih Kota</option>
                    @foreach($cities as $city)
                        <option value="{{ $city->id }}">{{ $city->name }}, {{ $city->province }}</option>
                    @endforeach
                </select>
                @error('city_id')
                    <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                @enderror
            </div>

            <!-- Location -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Lokasi Detail (Opsional)</label>
                <input type="text" wire:model="location" placeholder="Contoh: Jl. Merdeka No. 123"
                    class="w-full px-4 py-3 rounded-2xl border-2 border-gray-200 focus:border-primary-400 focus:ring-2 focus:ring-primary-200 transition">
                @error('location')
                    <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                @enderror
            </div>

            <!-- Description -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Deskripsi Bantuan *</label>
                <textarea wire:model="description" rows="5" placeholder="Jelaskan kebutuhan bantuan Anda..."
                    class="w-full px-4 py-3 rounded-2xl border-2 border-gray-200 focus:border-primary-400 focus:ring-2 focus:ring-primary-200 transition resize-none"></textarea>
                @error('description')
                    <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                @enderror
            </div>

            <!-- Photo -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Foto (Opsional)</label>
                <input type="file" wire:model="photo" accept="image/*"
                    class="w-full px-4 py-3 rounded-2xl border-2 border-gray-200 focus:border-primary-400 focus:ring-2 focus:ring-primary-200 transition">
                <p class="text-xs text-gray-500 mt-1">Max 2MB. Format: JPG, PNG</p>
                @error('photo')
                    <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                @enderror

                @if ($photo)
                    <div class="mt-3">
                        <img src="{{ $photo->temporaryUrl() }}" class="w-full h-48 object-cover rounded-2xl">
                    </div>
                @endif
            </div>

            <!-- Submit Button -->
            <div class="flex gap-3 pt-4">
                <a href="{{ route('dashboard') }}"
                    class="flex-1 bg-gray-200 text-gray-700 px-6 py-4 rounded-2xl font-semibold text-center hover:bg-gray-300 transition">
                    Batal
                </a>
                <button type="submit" wire:loading.attr="disabled"
                    class="flex-1 bg-gradient-to-r from-primary-400 to-primary-500 text-white px-6 py-4 rounded-2xl font-semibold shadow-md hover:shadow-lg transition disabled:opacity-50">
                    class="flex-1 bg-gradient-to-r from-primary-500 to-primary-600 text-white px-6 py-4 rounded-xl
                    font-semibold shadow-lg hover:shadow-xl transition disabled:opacity-50">
                    <span wire:loading.remove>Kirim Permintaan</span>
                    <span wire:loading>Mengirim...</span>
                </button>
            </div>
        </form>
    </div>
</div>