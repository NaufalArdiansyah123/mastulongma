<x-app-layout>
    <x-slot name="title">Edit Profile</x-slot>

    <div class="min-h-screen bg-gray-50">
        <!-- Header -->
        <div class="bg-gradient-to-br from-primary-400 via-primary-500 to-primary-600 px-6 py-4">
            <div class="flex items-center justify-between">
                <a href="{{ route('profile') }}" class="text-white">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </a>
                <h1 class="text-xl font-bold text-white">Edit Profile</h1>
                <div class="w-6"></div>
            </div>
        </div>

        <!-- Form -->
        <div class="px-6 py-6 pb-24">
            <div class="bg-white rounded-3xl shadow-lg p-6">
                <livewire:profile.update-profile-information-form />
            </div>
        </div>
    </div>
</x-app-layout>