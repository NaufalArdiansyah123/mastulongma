<x-app-layout>
    <x-slot name="title">Settings</x-slot>

    <div class="min-h-screen bg-gray-50">
        <!-- Header -->
        <div class="bg-gradient-to-br from-primary-400 via-primary-500 to-primary-600 px-6 py-4">
            <div class="flex items-center justify-between">
                <a href="{{ route('profile') }}" class="text-white">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </a>
                <h1 class="text-xl font-bold text-white">Settings</h1>
                <a href="{{ route('customer.notifications.index') }}" class="text-white">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                </a>
            </div>
        </div>

        <!-- Settings Menu -->
        <div class="px-6 py-6 pb-24 space-y-3">
            <!-- Notification Settings -->
            <a href="{{ route('profile.settings.notifications') }}"
                class="bg-white rounded-2xl shadow-md p-4 flex items-center space-x-4 hover:shadow-lg transition">
                <div class="bg-gradient-to-br from-primary-400 to-primary-600 text-white p-3 rounded-full">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                </div>
                <span class="flex-1 font-semibold text-gray-900">Notification Settings</span>
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </a>

            <!-- Password Settings -->
            <a href="{{ route('profile.settings.password') }}"
                class="bg-white rounded-2xl shadow-md p-4 flex items-center space-x-4 hover:shadow-lg transition">
                <div class="bg-gradient-to-br from-primary-400 to-primary-600 text-white p-3 rounded-full">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                </div>
                <span class="flex-1 font-semibold text-gray-900">Password Settings</span>
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </a>

            <!-- Delete Account -->
            <button onclick="confirmDelete()"
                class="w-full bg-white rounded-2xl shadow-md p-4 flex items-center space-x-4 hover:shadow-lg transition">
                <div class="bg-gradient-to-br from-primary-400 to-primary-600 text-white p-3 rounded-full">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                </div>
                <span class="flex-1 font-semibold text-gray-900 text-left">Delete Account</span>
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </button>
        </div>
    </div>

    <!-- Delete Account Modal (Outside main content for full-screen coverage) -->
    <div id="deleteModal"
        class="hidden fixed inset-0 bg-gray-900/70 backdrop-blur-md z-[100] flex items-center justify-center p-4"
        style="backdrop-filter: blur(8px); -webkit-backdrop-filter: blur(8px);">
        <div class="bg-white rounded-3xl shadow-2xl max-w-sm w-full p-5 relative z-[101]">
            <h2 class="text-lg font-bold text-gray-900 mb-3 text-center">Delete Account</h2>
            <p class="text-sm text-gray-700 mb-3 font-medium text-center">Are You Sure You Want To Log Out?</p>

            <p class="text-xs text-gray-600 mb-4 text-center leading-relaxed">By deleting your account, you agree that
                you understand the consequences of this action and that you agree to permanently delete your account and
                all associated data.</p>

            <form action="{{ route('profile.delete') }}" method="POST" class="space-y-2">
                @csrf
                @method('DELETE')

                <button type="submit"
                    class="w-full bg-gradient-to-r from-primary-400 to-primary-600 text-white font-semibold py-2.5 rounded-xl hover:shadow-lg transition text-sm">
                    Yes, Delete Account
                </button>

                <button type="button" onclick="closeDeleteModal()"
                    class="w-full bg-primary-50 text-gray-700 font-semibold py-2.5 rounded-xl hover:bg-primary-100 transition text-sm">
                    Cancel
                </button>
            </form>
        </div>
    </div>

    <script>
        function confirmDelete() {
            document.getElementById('deleteModal').classList.remove('hidden');
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.add('hidden');
        }
    </script>
</x-app-layout>