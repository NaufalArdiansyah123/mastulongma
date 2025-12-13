<div class="min-h-screen bg-white">
    <style>
        :root{
            --brand-500: #0ea5a4;
            --brand-600: #08979a;
            --muted-600: #6b7280;
        }

        .card-shadow { box-shadow: 0 2px 8px rgba(0,0,0,0.08); }
        .focus-ring:focus { outline: none; box-shadow: 0 0 0 3px rgba(14,165,164,0.2); }
        
        .header-pattern {
            position: relative;
            overflow: hidden;
        }
        
        .header-pattern::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -10%;
            width: 300px;
            height: 300px;
            background: radial-gradient(circle, rgba(255,255,255,0.15) 0%, transparent 70%);
            border-radius: 50%;
        }
        
        .header-pattern::after {
            content: '';
            position: absolute;
            bottom: -30%;
            left: -5%;
            width: 250px;
            height: 250px;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
            border-radius: 50%;
        }
    </style>

    <div class="max-w-md mx-auto">
        <!-- Header - BRImo Style (sama seperti index) -->
        <div class="px-5 pt-5 pb-8 relative overflow-hidden header-pattern" style="background: linear-gradient(to bottom right, #0098e7, #0077cc, #0060b0);">
            <div class="absolute top-0 right-0 w-40 h-40 bg-white/5 rounded-full -mr-20 -mt-20"></div>
            <div class="absolute bottom-0 left-0 w-32 h-32 bg-white/5 rounded-full -ml-16 -mb-16"></div>
            
            <div class="relative z-10">
                <div class="flex items-center justify-between text-white mb-3">
                    <button onclick="window.history.back()" aria-label="Kembali" class="p-2 hover:bg-white/20 rounded-lg transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                    </button>

                    <div class="text-center flex-1">
                        <h1 class="text-lg font-bold">Buat Permintaan Baru</h1>
                        <p class="text-xs text-white/90 mt-0.5">Isi form di bawah untuk membuat permintaan</p>
                    </div>

                    <div class="w-9"></div>
                </div>
            </div>

            <!-- Curved separator -->
            <svg class="absolute bottom-0 left-0 w-full" viewBox="0 0 1440 72" preserveAspectRatio="none" aria-hidden="true">
                <path d="M0,32 C360,72 1080,0 1440,40 L1440,72 L0,72 Z" fill="#ffffff"></path>
            </svg>
        </div>

        <!-- Content -->
        <div class="bg-white rounded-t-3xl -mt-6 px-5 pt-6 pb-8"> 
            <form wire:submit.prevent="prepareConfirm" enctype="multipart/form-data" class="space-y-4">
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
                        class="w-full px-4 py-3 text-sm rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition bg-white">
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
                            class="w-full pl-12 pr-4 py-3 text-sm rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition bg-white">
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
                        class="w-full px-4 py-3 text-sm rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition bg-white">
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
                            Lokasi Singkat
                            <span class="text-gray-400 text-xs ml-1">(Opsional)</span>
                        </span>
                    </label>
                    <input type="text" wire:model="location" placeholder="Contoh: Jl. Merdeka No. 123, RT 01/RW 05"
                        class="w-full px-4 py-3 text-sm rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition bg-white">
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

                <!-- Alamat Lengkap (Manual Input) -->
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1.5">
                        <span class="flex items-center">
                            <svg class="w-3.5 h-3.5 mr-1.5 text-primary-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z"
                                    clip-rule="evenodd" />
                            </svg>
                            Alamat Lengkap
                            <span class="text-gray-400 text-xs ml-1">(Opsional)</span>
                        </span>
                    </label>
                    <textarea wire:model="full_address" rows="3"
                        placeholder="Contoh: Dukuh Sabet, Desa Sumberejo, Kecamatan Balong, Kabupaten Ponorogo, Jawa Timur"
                        class="w-full px-4 py-3 text-sm rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition resize-none bg-white"></textarea>
                    <p class="text-xs text-gray-500 mt-1.5 flex items-center">
                        <svg class="w-3 h-3 mr-1 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                clip-rule="evenodd" />
                        </svg>
                        Tulis alamat lengkap termasuk desa, kecamatan, kabupaten, provinsi
                    </p>
                    @error('full_address')
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

                <!-- Tandai Lokasi di Peta -->
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1.5">
                        <span class="flex items-center">
                            <svg class="w-3.5 h-3.5 mr-1.5 text-primary-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z"
                                    clip-rule="evenodd" />
                            </svg>
                            Tandai Lokasi di Peta
                            <span class="text-gray-400 text-xs ml-1">(Opsional)</span>
                        </span>
                    </label>

                    <!-- Map Container -->
                    <div wire:ignore id="map" class="w-full h-56 rounded-lg border border-gray-300 mb-2 bg-gray-50"></div>

                    <!-- Koordinat Display -->
                    <div id="coordinates-display"
                        class="bg-green-50 border border-green-200 rounded-lg p-3 mb-2 hidden">
                        <p class="text-xs font-semibold text-green-800 mb-1">✅ Lokasi Ditandai:</p>
                        <p class="text-xs text-green-900">
                            Latitude: <span id="lat-display" class="font-mono">-</span>,
                            Longitude: <span id="lng-display" class="font-mono">-</span>
                        </p>
                    </div>

                    <!-- Hidden inputs for Livewire -->
                    <input type="hidden" wire:model="latitude" id="latitude-input">
                    <input type="hidden" wire:model="longitude" id="longitude-input">

                    <p class="text-xs text-gray-500 mt-1.5 flex items-center">
                        <svg class="w-3 h-3 mr-1 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                clip-rule="evenodd" />
                        </svg>
                        Klik pada peta untuk menandai titik lokasi bantuan
                    </p>

                    @error('latitude')
                        <span class="text-red-500 text-xs mt-1.5 block">{{ $message }}</span>
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
                        class="w-full px-4 py-3 text-sm rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition resize-none bg-white"></textarea>
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

                <!-- Peralatan yang Sudah Disediakan -->
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1.5">
                        <span class="flex items-center">
                            <svg class="w-3.5 h-3.5 mr-1.5 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M7 3a1 1 0 000 2h6a1 1 0 100-2H7zM4 7a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1zM2 11a2 2 0 012-2h12a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4z"/>
                            </svg>
                            Peralatan yang Sudah Disediakan
                            <span class="text-gray-400 text-xs ml-1">(Opsional)</span>
                        </span>
                    </label>
                    <textarea wire:model="equipment_provided" rows="3"
                        placeholder="Contoh: Sudah ada gerobak dorong, ember besar 2 buah, timbangan digital"
                        class="w-full px-4 py-3 text-sm rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition resize-none bg-white"></textarea>
                    <p class="text-xs text-gray-500 mt-1.5 flex items-center">
                        <svg class="w-3 h-3 mr-1 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                clip-rule="evenodd" />
                        </svg>
                        Tuliskan alat atau peralatan yang sudah Anda sediakan untuk membantu mitra
                    </p>
                    @error('equipment_provided')
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
                            class="flex items-center justify-center w-full h-32 rounded-lg border-2 border-dashed border-gray-300 hover:border-blue-400 cursor-pointer transition bg-gray-50 hover:bg-blue-50 overflow-hidden relative">
                            @if ($photo)
                                <img src="{{ $photo->temporaryUrl() }}" alt="preview" class="w-full h-full object-cover">

                                <button type="button" onclick="event.stopPropagation()" wire:click="$set('photo', null)"
                                    class="absolute top-2 right-2 bg-red-500 text-white p-1.5 rounded-full shadow-lg hover:bg-red-600 transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            @else
                                <div class="flex flex-col items-center justify-center w-full">
                                    <svg class="w-6 h-6 text-gray-400 mb-2" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 4v16m8-8H4" />
                                    </svg>
                                    <span class="text-sm font-medium text-gray-600">Pilih atau ambil foto</span>
                                    <span class="text-xs text-gray-400 mt-1">Klik untuk upload gambar</span>
                                </div>
                            @endif
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

                    {{-- Preview is rendered inside the upload box above --}}
                </div>

                <!-- Submit Button -->
                <div class="flex gap-3 pt-6">
                    <a href="{{ route('dashboard') }}"
                        class="flex-1 inline-flex items-center justify-center bg-white border border-gray-300 text-gray-700 px-5 py-3 text-sm rounded-lg font-semibold hover:bg-gray-50 transition">
                        Batal
                    </a>
                    <button type="submit" wire:loading.attr="disabled"
                        class="flex-1 inline-flex items-center justify-center bg-gradient-to-r from-blue-500 to-blue-600 text-white px-5 py-3 text-sm rounded-lg font-semibold hover:from-blue-600 hover:to-blue-700 transition disabled:opacity-50 disabled:cursor-not-allowed">
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

    <!-- Insufficient Balance Modal - Simplified -->
    @if($showInsufficientModal)
        <div class="fixed inset-0 bg-black/40 flex items-center justify-center z-50 p-4">
            <div class="bg-white rounded-lg w-full max-w-sm p-5">
                <h3 class="text-lg font-semibold text-gray-800 mb-2">Saldo Tidak Cukup</h3>
                <p class="text-sm text-gray-600 mb-5">{{ $insufficientMessage }}</p>

                <div class="flex gap-3">
                    <button wire:click="closeInsufficientModal"
                        class="flex-1 px-4 py-2 rounded-lg border border-gray-200 text-gray-700 hover:bg-gray-50 transition">
                        Tutup
                    </button>
                    <a href="{{ route('customer.topup') }}"
                        class="flex-1 px-4 py-2 rounded-lg bg-gradient-to-r from-blue-500 to-cyan-500 text-white text-center hover:from-blue-600 hover:to-cyan-600 transition">
                        Top Up Saldo
                    </a>
                </div>
            </div>
        </div>
    @endif

    <!-- Confirmation Modal - Simplified -->
    @if($showConfirmModal)
        <div class="fixed inset-0 bg-black/40 flex items-center justify-center z-50 p-4" wire:click="closeConfirmModal">
            <div class="bg-white rounded-lg shadow-md max-w-sm w-full p-5" wire:click.stop>
                <h3 class="text-lg font-semibold text-gray-800 mb-1">Konfirmasi Permintaan</h3>
                <p class="text-xs text-gray-500 mb-4">Pastikan detail permintaan sudah benar</p>

                <div class="space-y-2 text-sm mb-5">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Saldo Saat Ini</span>
                        <span class="font-medium">Rp {{ number_format($currentBalance ?? 0, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Nominal Bantuan</span>
                        <span class="font-medium">Rp {{ number_format($confirmAmount ?? 0, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Biaya Admin</span>
                        <span class="font-medium">Rp {{ number_format($confirmAdminFee ?? 0, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between pt-2 border-t">
                        <span class="font-semibold text-gray-800">Total</span>
                        <span class="font-bold text-blue-600">Rp {{ number_format($confirmTotal ?? 0, 0, ',', '.') }}</span>
                    </div>
                </div>

                <div class="flex gap-3">
                    <button wire:click="closeConfirmModal" type="button"
                        class="flex-1 px-4 py-2 border border-gray-200 text-gray-700 rounded-lg hover:bg-gray-50 transition">
                        Kembali
                    </button>
                    <button wire:click="save" type="button" wire:loading.attr="disabled"
                        class="flex-1 px-4 py-2 bg-gradient-to-r from-blue-500 to-cyan-500 text-white rounded-lg hover:from-blue-600 hover:to-cyan-600 transition">
                        Konfirmasi
                    </button>
                </div>
            </div>
        </div>
    @endif

    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />

    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

    <!-- OpenStreetMap Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Default location (Ponorogo, Jawa Timur)
            const defaultLocation = [-7.8664, 111.4620];

            // Initialize map
            const map = L.map('map').setView(defaultLocation, 13);

            // Add OpenStreetMap tiles
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
                maxZoom: 19,
            }).addTo(map);

            // Initialize marker variable
            let marker = null;

            // Click event on map to place marker
            map.on('click', function (e) {
                const lat = e.latlng.lat;
                const lng = e.latlng.lng;

                // Remove old marker if exists
                if (marker) {
                    map.removeLayer(marker);
                }

                // Add new marker
                marker = L.marker([lat, lng], {
                    draggable: true
                }).addTo(map);

                // Update coordinates
                updateCoordinates(lat, lng);

                // Marker drag event
                marker.on('dragend', function (event) {
                    const position = event.target.getLatLng();
                    updateCoordinates(position.lat, position.lng);
                });
            });

            // Try to get user's current location
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    (position) => {
                        const pos = [position.coords.latitude, position.coords.longitude];
                        map.setView(pos, 13);
                    },
                    () => {
                        console.log('Geolocation not available, using default location');
                    }
                );
            }

            function updateCoordinates(lat, lng) {
                // Update display
                document.getElementById('coordinates-display').classList.remove('hidden');
                document.getElementById('lat-display').textContent = lat.toFixed(6);
                document.getElementById('lng-display').textContent = lng.toFixed(6);

                // Update Livewire properties
                document.getElementById('latitude-input').value = lat;
                document.getElementById('latitude-input').dispatchEvent(new Event('input'));

                document.getElementById('longitude-input').value = lng;
                document.getElementById('longitude-input').dispatchEvent(new Event('input'));
            }
        });
    </script>
</div>