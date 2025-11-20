<x-app-layout>
    <x-slot name="title">Profile</x-slot>

    <div class="min-h-screen bg-gray-50">
        <!-- Profile Header & Avatar -->
        <div class="bg-gradient-to-br from-primary-400 via-primary-500 to-primary-600 px-6 pt-4 pb-24">
            <!-- Navigation Bar -->
            <div class="flex items-center justify-between mb-8">
                <a href="{{ route('dashboard') }}" class="text-white">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </a>
                <h1 class="text-xl font-bold text-white">Profile</h1>
                <a href="{{ route('customer.notifications.index') }}" class="text-white">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                </a>
            </div>

            <!-- Avatar & User Info -->
            <div class="flex flex-col items-center">
                @livewire('customer.update-profile-photo')

                <div class="relative mb-6">
                    <div class="w-36 h-36 rounded-full bg-white p-1.5 shadow-xl">
                        <div
                            class="w-full h-full rounded-full bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center overflow-hidden">
                            @php
                                $profilePhoto = auth()->user()->selfie_photo ?? auth()->user()->photo ?? null;
                            @endphp

                            @if($profilePhoto)
                                <img src="{{ asset('storage/' . $profilePhoto) }}" alt="Profile Photo"
                                    class="w-full h-full object-cover" id="profilePhotoImg">
                            @else
                                <svg class="w-24 h-24 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                        clip-rule="evenodd" />
                                </svg>
                            @endif
                        </div>
                    </div>

                    <!-- Edit Photo Button -->
                    <button onclick="Livewire.dispatch('openModal')"
                        class="absolute bottom-1 right-1 w-10 h-10 bg-primary-600 hover:bg-primary-700 rounded-full flex items-center justify-center shadow-lg transition transform hover:scale-110">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </button>

                    @if($profilePhoto)
                        <!-- Remove Photo Button -->
                        <button onclick="if(confirm('Hapus foto profil?')) Livewire.dispatch('removePhoto')"
                            class="absolute top-1 right-1 w-8 h-8 bg-red-600 hover:bg-red-700 rounded-full flex items-center justify-center shadow-lg transition transform hover:scale-110">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    @endif
                </div>

                <h2 class="text-2xl font-bold text-white mb-2">{{ auth()->user()->name }}</h2>
                <p class="text-sm text-white/90 font-medium">ID: {{ str_pad(auth()->user()->id, 8, '0', STR_PAD_LEFT) }}
                </p>
            </div>
        </div>

        <!-- Menu Items -->
        <div class="px-6 -mt-16 pb-24 space-y-4">
            <!-- Flash Messages -->
            @if(session('status'))
                <div
                    class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl flex items-center gap-2 shadow-sm">
                    <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                            clip-rule="evenodd" />
                    </svg>
                    <span class="text-sm font-medium">{{ session('status') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div
                    class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl flex items-center gap-2 shadow-sm">
                    <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                            clip-rule="evenodd" />
                    </svg>
                    <span class="text-sm font-medium">{{ session('error') }}</span>
                </div>
            @endif

            <!-- Edit Profile -->
            <a href="{{ route('profile.edit') }}"
                class="bg-white rounded-2xl shadow-sm p-4 flex items-center space-x-4 hover:bg-gray-50 transition">
                <div class="bg-blue-500 text-white p-3 rounded-full">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                </div>
                <span class="flex-1 font-medium text-gray-900">Edit Profile</span>
            </a>

            <!-- Settings -->
            <a href="{{ route('profile.settings') }}"
                class="bg-white rounded-2xl shadow-sm p-4 flex items-center space-x-4 hover:bg-gray-50 transition">
                <div class="bg-blue-500 text-white p-3 rounded-full">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </div>
                <span class="flex-1 font-medium text-gray-900">Setting</span>
            </a>

            <!-- Logout -->
            <button onclick="document.getElementById('logout-modal').classList.remove('hidden')"
                class="w-full bg-white rounded-2xl shadow-sm p-4 flex items-center space-x-4 hover:bg-gray-50 transition">
                <div class="bg-blue-500 text-white p-3 rounded-full">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                </div>
                <span class="flex-1 font-medium text-gray-900 text-left">Logout</span>
            </button>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                @csrf
            </form>
        </div>
    </div>

    <!-- Logout Confirmation Modal (Outside main content for full-screen coverage) -->
    <div id="logout-modal"
        class="hidden fixed inset-0 bg-gray-900/70 backdrop-blur-md z-[100] flex items-center justify-center px-6"
        style="backdrop-filter: blur(8px); -webkit-backdrop-filter: blur(8px);">
        <div class="w-full max-w-sm bg-white rounded-3xl p-5 animate-slide-up shadow-2xl relative z-[101]">
            <!-- Header -->
            <div class="mb-4 text-center">
                <h3 class="text-lg font-bold text-gray-900 mb-3">End Session</h3>
                <p class="text-sm text-gray-700 mb-3 font-medium">Are you sure you want to log out?</p>
                <p class="text-xs text-gray-600 leading-relaxed">You will be redirected to the login page and need to
                    sign in again to access your account.</p>
            </div>

            <!-- Buttons -->
            <div class="space-y-2">
                <!-- Confirm Logout Button -->
                <button onclick="document.getElementById('logout-form').submit()"
                    class="w-full bg-gradient-to-r from-primary-400 to-primary-600 text-white font-semibold py-2.5 rounded-xl hover:shadow-lg transition text-sm">
                    Yes, End Session
                </button>

                <!-- Cancel Button -->
                <button onclick="document.getElementById('logout-modal').classList.add('hidden')"
                    class="w-full bg-primary-50 text-gray-700 font-semibold py-2.5 rounded-xl hover:bg-primary-100 transition text-sm">
                    Cancel
                </button>
            </div>
        </div>
    </div>
</x-app-layout>