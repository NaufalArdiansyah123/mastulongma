<div class="max-w-md mx-auto min-h-screen bg-gray-50">
    <!-- Header -->
    <div class="bg-gradient-to-br from-primary-400 via-primary-500 to-primary-600 px-5 pt-6 pb-6 shadow-lg">
        <div class="flex items-center justify-between mb-3">
            <a href="{{ route('dashboard') }}" class="text-white">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
            <h2 class="text-lg font-bold text-white absolute left-1/2 transform -translate-x-1/2">Buat Permintaan</h2>
            <div class="w-5"></div>
        </div>
        <p class="text-xs text-white/90 text-center font-medium">Jelaskan kebutuhan bantuan Anda</p>
    </div>

    <!-- Form Content -->
    <div class="bg-gray-50 rounded-t-3xl -mt-4 px-5 pt-6 pb-24">
        <div class="bg-white rounded-2xl p-4 shadow-sm">
            <form wire:submit.prevent="save" enctype="multipart/form-data" class="space-y-3">
                <!-- Title -->
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1.5">
                        <span class="flex items-center">
                            <svg class="w-3.5 h-3.5 mr-1.5 text-primary-500" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z" />
                                <path fill-rule="evenodd"
                                    d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z"
                                    clip-rule="evenodd" />
                            </svg>
                            Judul Bantuan
                            <span class="text-red-500 ml-1">*</span>
                        </span>
                    </label>
                    <input type="text" wire:model="title" placeholder="Contoh: Butuh Bantuan Makanan untuk Keluarga"
                        class="w-full px-3.5 py-2.5 text-sm rounded-xl border-2 border-gray-200 focus:border-primary-400 focus:ring-2 focus:ring-primary-200 transition bg-white shadow-sm">
                    @error('title')
                        <span class="text-red-500 text-xs mt-1.5 block flex items-center">
                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                    clip-rule="evenodd" />
                            </svg>
                            {{ $message }}
                        </span>
                    @enderror
                </div>

                <!-- Amount (Nominal Uang) -->
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1.5">
                        <span class="flex items-center">
                            <svg class="w-3.5 h-3.5 mr-1.5 text-primary-500" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z" />
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z"
                                    clip-rule="evenodd" />
                            </svg>
                            Nominal Uang untuk Mitra
                            <span class="text-red-500 ml-1">*</span>
                        </span>
                    </label>
                    <div class="relative">
                        <span
                            class="absolute left-3.5 top-1/2 transform -translate-y-1/2 text-gray-500 font-bold text-sm">Rp</span>
                        <input type="number" wire:model="amount" placeholder="50000" min="10000" step="1000"
                            class="w-full pl-12 pr-3.5 py-2.5 text-sm rounded-xl border-2 border-gray-200 focus:border-primary-400 focus:ring-2 focus:ring-primary-200 transition bg-white shadow-sm">
                    </div>
                    <p class="text-xs text-gray-500 mt-1.5 flex items-center">
                        <svg class="w-3 h-3 mr-1 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                clip-rule="evenodd" />
                        </svg>
                        Minimal Rp 10.000 - Maksimal Rp 100.000.000
                    </p>
                    @error('amount')
                        <span class="text-red-500 text-xs mt-1.5 block flex items-center">
                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                    clip-rule="evenodd" />
                            </svg>
                            {{ $message }}
                        </span>
                    @enderror
                </div>

                <!-- City -->
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1.5">
                        <span class="flex items-center">
                            <svg class="w-3.5 h-3.5 mr-1.5 text-primary-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z"
                                    clip-rule="evenodd" />
                            </svg>
                            Kota
                            <span class="text-red-500 ml-1">*</span>
                        </span>
                    </label>
                    <select wire:model="city_id"
                        class="w-full px-3.5 py-2.5 text-sm rounded-xl border-2 border-gray-200 focus:border-primary-400 focus:ring-2 focus:ring-primary-200 transition bg-white shadow-sm">
                        <option value="">-- Pilih Kota --</option>
                        @foreach($cities as $city)
                            <option value="{{ $city->id }}">📍 {{ $city->name }}, {{ $city->province }}</option>
                        @endforeach
                    </select>
                    @error('city_id')
                        <span class="text-red-500 text-xs mt-1.5 block flex items-center">
                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                    clip-rule="evenodd" />
                            </svg>
                            {{ $message }}
                        </span>
                    @enderror
                </div>

                <!-- Location -->
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1.5">
                        <span class="flex items-center">
                            <svg class="w-3.5 h-3.5 mr-1.5 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z"
                                    clip-rule="evenodd" />
                            </svg>
                            Alamat Lengkap
                            <span class="text-gray-400 text-xs ml-1">(Opsional)</span>
                        </span>
                    </label>
                    <input type="text" wire:model="location" placeholder="Contoh: Jl. Merdeka No. 123, RT 01/RW 05"
                        class="w-full px-3.5 py-2.5 text-sm rounded-xl border-2 border-gray-200 focus:border-primary-400 focus:ring-2 focus:ring-primary-200 transition bg-white shadow-sm">
                    @error('location')
                        <span class="text-red-500 text-xs mt-1.5 block flex items-center">
                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                    clip-rule="evenodd" />
                            </svg>
                            {{ $message }}
                        </span>
                    @enderror
                </div>

                <!-- Description -->
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1.5">
                        <span class="flex items-center">
                            <svg class="w-3.5 h-3.5 mr-1.5 text-primary-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                    clip-rule="evenodd" />
                            </svg>
                            Deskripsi Bantuan
                            <span class="text-red-500 ml-1">*</span>
                        </span>
                    </label>
                    <textarea wire:model="description" rows="4"
                        placeholder="Jelaskan detail kebutuhan bantuan Anda secara lengkap..."
                        class="w-full px-3.5 py-2.5 text-sm rounded-xl border-2 border-gray-200 focus:border-primary-400 focus:ring-2 focus:ring-primary-200 transition resize-none bg-white shadow-sm"></textarea>
                    @error('description')
                        <span class="text-red-500 text-xs mt-1.5 block flex items-center">
                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                    clip-rule="evenodd" />
                            </svg>
                            {{ $message }}
                        </span>
                    @enderror
                </div>

                <!-- Photo -->
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1.5">
                        <span class="flex items-center">
                            <svg class="w-3.5 h-3.5 mr-1.5 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z"
                                    clip-rule="evenodd" />
                            </svg>
                            Foto Pendukung
                            <span class="text-gray-400 text-xs ml-1">(Opsional)</span>
                        </span>
                    </label>
                    <div class="relative">
                        <input type="file" wire:model="photo" accept="image/*" id="photo-input" class="hidden">
                        <label for="photo-input"
                            class="flex flex-col items-center justify-center w-full h-36 rounded-xl border-2 border-dashed border-gray-300 hover:border-primary-400 cursor-pointer transition bg-white shadow-sm hover:bg-gray-50">
                            <svg class="w-6 h-6 text-gray-400 mb-2" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4v16m8-8H4" />
                            </svg>
                            <span class="text-sm font-medium text-gray-600">Pilih atau ambil foto</span>
                            <span class="text-xs text-gray-400 mt-1">Klik untuk upload gambar</span>
                        </label>
                    </div>
                    <p class="text-xs text-gray-500 mt-1.5 flex items-center">
                        <svg class="w-3 h-3 mr-1 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                clip-rule="evenodd" />
                        </svg>
                        Maksimal 2MB. Format: JPG, PNG, JPEG
                    </p>
                    @error('photo')
                        <span class="text-red-500 text-xs mt-1.5 block flex items-center">
                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                    clip-rule="evenodd" />
                            </svg>
                            {{ $message }}
                        </span>
                    @enderror

                    @if ($photo)
                        <div class="mt-3 relative">
                            <img src="{{ $photo->temporaryUrl() }}" class="w-full h-48 object-cover rounded-xl shadow-md">
                            <button type="button" wire:click="$set('photo', null)"
                                class="absolute top-2 right-2 bg-red-500 text-white p-1.5 rounded-full shadow-lg hover:bg-red-600 transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    @endif
                </div>

                <!-- Submit Button -->
                <div class="flex gap-3 pt-4">
                    <a href="{{ route('dashboard') }}"
                        class="flex-1 inline-flex items-center justify-center bg-white border border-gray-300 text-gray-700 px-4 py-2.5 text-sm rounded-lg font-semibold hover:bg-gray-50 transition">
                        Batal
                    </a>
                    <button type="submit" wire:loading.attr="disabled"
                        class="flex-1 inline-flex items-center justify-center bg-primary-500 text-white px-4 py-2.5 text-sm rounded-lg font-semibold shadow hover:shadow-md transition disabled:opacity-50 disabled:cursor-not-allowed hover:bg-primary-600">
                        <span wire:loading.remove wire:target="save">Kirim Permintaan</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Global submit overlay shown only while Livewire 'save' is processing (kept inside component root) -->
    <div wire:loading.class.remove="hidden" wire:target="save"
        class="hidden fixed inset-0 z-50 flex items-end md:items-center justify-center pointer-events-none">
        <div
            class="pointer-events-auto mb-6 md:mb-0 bg-white bg-opacity-95 rounded-lg px-4 py-3 flex items-center gap-3 shadow-lg">
            <svg class="animate-spin h-5 w-5 text-primary-500" xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
            </svg>
            <div class="text-sm font-medium text-gray-800">Mengirim...</div>
        </div>
    </div>

    <!-- Insufficient Balance Modal -->
    @if($showInsufficientModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center px-4">
            <div class="absolute inset-0 bg-black/50" wire:click="closeInsufficientModal"></div>
            <div class="relative bg-white rounded-2xl w-full max-w-sm p-6 shadow-xl">
                <div class="flex items-start justify-between">
                    <h3 class="text-lg font-bold">Saldo Tidak Cukup</h3>
                    <button wire:click="closeInsufficientModal" class="text-gray-500 hover:text-gray-700">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <p class="mt-4 text-sm text-gray-700">{{ $insufficientMessage }}</p>

                <div class="mt-6 flex gap-3">
                    <button wire:click="closeInsufficientModal"
                        class="flex-1 px-4 py-2 rounded-lg border border-gray-200">Tutup</button>
                    <a href="{{ route('customer.topup') }}"
                        class="flex-1 px-4 py-2 rounded-lg bg-primary-500 text-white text-center">Top Up Saldo</a>
                </div>
            </div>
        </div>
    @endif
</div>