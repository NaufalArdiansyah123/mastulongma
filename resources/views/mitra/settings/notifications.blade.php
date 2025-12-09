<x-app-layout>
    <x-slot name="title">Notification Settings</x-slot>

    <div class="min-h-screen bg-gray-50">
        <!-- Header -->
        <div class="bg-gradient-to-br from-primary-400 via-primary-500 to-primary-600 px-6 py-4">
            <div class="flex items-center justify-between">
                <a href="{{ route('mitra.settings') }}" class="text-white">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </a>
                <h1 class="text-xl font-bold text-white">Notification Settings</h1>
                <a href="{{ route('customer.notifications.index') }}" class="text-white">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                </a>
            </div>
        </div>

        <!-- Notification Settings -->
        <div class="px-6 py-6 pb-24">
            <div class="bg-white rounded-3xl shadow-lg p-6 space-y-4">
                <livewire:profile.notification-settings />
            </div>
        </div>
    </div>
</x-app-layout>
