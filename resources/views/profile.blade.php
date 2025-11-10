<x-app-layout>
    <x-slot name="title">Profil Saya</x-slot>

    <div class="min-h-screen bg-gray-50">
        <!-- Profile Header -->
        <div class="bg-gradient-to-br from-primary-400 via-primary-500 to-primary-600 text-white px-5 pt-6 pb-8">
            <div class="flex items-center space-x-4">
                <div class="bg-white/30 rounded-full p-4">
                    <svg class="w-12 h-12" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                            clip-rule="evenodd" />
                    </svg>
                </div>
                <div>
                    <h2 class="text-xl font-bold text-gray-900">{{ auth()->user()->name }}</h2>
                    <p class="text-sm text-gray-700">{{ ucfirst(auth()->user()->role) }}</p>
                </div>
            </div>
        </div>

        <!-- Profile Info -->
        <div class="px-4 py-6 pb-24 space-y-4">
            <!-- Email -->
            <div class="bg-white rounded-2xl shadow-md p-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="bg-blue-100 text-blue-600 p-3 rounded-2xl">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">Email</p>
                            <p class="font-semibold text-gray-900">{{ auth()->user()->email }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Phone -->
            @if(auth()->user()->phone)
                <div class="bg-white rounded-2xl shadow-md p-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="bg-green-100 text-green-600 p-3 rounded-2xl">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500">Telepon</p>
                                <p class="font-semibold text-gray-900">{{ auth()->user()->phone }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- City -->
            @if(auth()->user()->city)
                <div class="bg-white rounded-2xl shadow-md p-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="bg-purple-100 text-purple-600 p-3 rounded-2xl">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500">Kota</p>
                                <p class="font-semibold text-gray-900">{{ auth()->user()->city->name }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Address -->
            @if(auth()->user()->address)
                <div class="bg-white rounded-2xl shadow-md p-4">
                    <div class="flex items-start space-x-3">
                        <div class="bg-orange-100 text-orange-600 p-3 rounded-2xl">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">Alamat</p>
                            <p class="font-semibold text-gray-900">{{ auth()->user()->address }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Status -->
            <div class="bg-white rounded-2xl shadow-md p-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div
                            class="bg-{{ auth()->user()->verified ? 'green' : 'yellow' }}-100 text-{{ auth()->user()->verified ? 'green' : 'yellow' }}-600 p-3 rounded-2xl">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                @if(auth()->user()->verified)
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                @else
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                @endif
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">Status Verifikasi</p>
                            <p class="font-semibold text-gray-900">
                                @if(auth()->user()->verified)
                                    Terverifikasi ✓
                                @else
                                    Belum Terverifikasi
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Update Profile Form -->
            <div class="bg-white rounded-2xl shadow-md p-4">
                <livewire:profile.update-profile-information-form />
            </div>

            <!-- Update Password -->
            <div class="bg-white rounded-2xl shadow-md p-4">
                <livewire:profile.update-password-form />
            </div>

            <!-- Logout Button -->
            <livewire:logout-button />
        </div>
    </div>
</x-app-layout>