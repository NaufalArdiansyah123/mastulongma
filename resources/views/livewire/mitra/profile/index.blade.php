<!-- Mitra Profile Page (grouped) -->
<!-- Migrated content from resources/views/livewire/mitra/profile.blade.php -->
<div class="min-h-screen bg-gray-50">
    <!-- Header Section -->
    <div class="px-5 pt-6 pb-6 bg-gradient-to-br from-primary-400 via-primary-500 to-primary-600 rounded-b-3xl">
        <div class="flex items-start justify-between mb-4">
            <a href="#" class="text-white">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
            <h2 class="text-lg font-bold text-white">Profil</h2>
            <div class="w-6"></div>
        </div>

        <!-- Profile Card -->
        <div class="bg-white rounded-2xl p-4 shadow-lg">
            <!-- Avatar & Name -->
            <div class="flex items-center mb-4">
                <div class="relative">
                    @if($user->selfie_photo)
                        <img src="{{ asset('storage/' . $user->selfie_photo) }}" alt="Avatar"
                            class="w-16 h-16 rounded-full object-cover shadow-md">
                    @else
                        <div
                            class="w-16 h-16 rounded-full bg-gradient-to-br from-primary-400 to-primary-600 flex items-center justify-center text-white text-2xl font-bold shadow-md">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                    @endif

                    <button onclick="openMitraPhotoModal()"
                        class="absolute -bottom-1 -right-1 bg-white p-1 rounded-full shadow-md border">
                        <svg class="w-4 h-4 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                    </button>
                </div>
                <div class="ml-4 flex-1">
                    <h3 class="font-bold text-gray-900">{{ $user->name }}</h3>
                    <p class="text-xs text-gray-500">{{ $user->email }}</p>
                    <div class="mt-2">
                        <a href="{{ route('chat.start', ['user_id' => $user->id]) }}"
                            class="inline-flex items-center gap-2 bg-primary-500 text-white px-3 py-1.5 rounded-lg text-sm font-semibold hover:bg-primary-600 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 10h.01M12 10h.01M16 10h.01M21 10c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                            </svg>
                            Chat
                        </a>
                        <a href="{{ auth()->user() && auth()->user()->role === 'mitra' ? route('mitra.reports.create.user', $user->id) : route('customer.reports.create.user', $user->id) }}"
                            class="inline-flex items-center gap-2 ml-2 bg-red-50 text-red-700 px-3 py-1.5 rounded-lg text-sm font-semibold hover:bg-red-100 transition">
                            Laporkan
                        </a>
                    </div>
                    @if($user->is_verified)
                        <span
                            class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-bold bg-green-100 text-green-700 mt-1">
                            ✅ Terverifikasi
                        </span>
                    @else
                        <span
                            class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-bold bg-yellow-100 text-yellow-700 mt-1">
                            ⏳ Belum Verifikasi
                        </span>
                    @endif
                </div>
            </div>

            <!-- Stats -->
            <div class="grid grid-cols-3 gap-3 pt-4 border-t border-gray-100">
                <div class="text-center">
                    <div class="text-xl font-bold text-primary-600">{{ $totalHelped }}</div>
                    <p class="text-xs text-gray-600 mt-1">Total Bantuan</p>
                </div>
                <div class="text-center">
                    <div class="text-xl font-bold text-green-600">{{ $completedHelps }}</div>
                    <p class="text-xs text-gray-600 mt-1">Selesai</p>
                </div>
                <div class="text-center">
                    <div class="text-xl font-bold text-yellow-600">{{ $averageRating }}</div>
                    <p class="text-xs text-gray-600 mt-1">Rating ({{ $totalRatings }})</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Menu Items -->
    <div class="px-5 pt-6 pb-24">
        <div class="space-y-3">
            {{-- Mount the update-photo Livewire component so it can be used to change avatar --}}
            <livewire:mitra.update-profile-photo />

            <!-- Edit Profil (go to full edit page) -->
            <a href="{{ route('mitra.profile.edit') }}"
                class="bg-white rounded-2xl shadow-md p-4 flex items-center space-x-4 hover:shadow-lg transition">
                <div class="bg-gradient-to-br from-blue-400 to-blue-600 text-white p-3 rounded-full">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                </div>
                <span class="flex-1 font-semibold text-gray-900">Edit Profil</span>
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </a>

            <!-- Riwayat Bantuan -->
            <a href="#"
                class="bg-white rounded-2xl shadow-md p-4 flex items-center space-x-4 hover:shadow-lg transition">
                <div class="bg-gradient-to-br from-primary-400 to-primary-600 text-white p-3 rounded-full">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <span class="flex-1 font-semibold text-gray-900">Riwayat Bantuan</span>
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </a>

            <!-- Rating & Ulasan -->
            <a href="{{ route('mitra.ratings') }}"
                class="bg-white rounded-2xl shadow-md p-4 flex items-center space-x-4 hover:shadow-lg transition">
                <div class="bg-gradient-to-br from-yellow-400 to-yellow-600 text-white p-3 rounded-full">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                    </svg>
                </div>
                <span class="flex-1 font-semibold text-gray-900">Rating & Ulasan</span>
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </a>

            <!-- Pengaturan -->
            <a href="#"
                class="bg-white rounded-2xl shadow-md p-4 flex items-center space-x-4 hover:shadow-lg transition">
                <div class="bg-gradient-to-br from-gray-400 to-gray-600 text-white p-3 rounded-full">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </div>
                <span class="flex-1 font-semibold text-gray-900">Pengaturan</span>
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </a>

            <!-- Bantuan & Dukungan -->
            <a href="#"
                class="bg-white rounded-2xl shadow-md p-4 flex items-center space-x-4 hover:shadow-lg transition">
                <div class="bg-gradient-to-br from-purple-400 to-purple-600 text-white p-3 rounded-full">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <span class="flex-1 font-semibold text-gray-900">Bantuan & Dukungan</span>
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </a>

            <!-- Logout -->
            <button onclick="confirmLogout()"
                class="w-full bg-white rounded-2xl shadow-md p-4 flex items-center space-x-4 hover:shadow-lg transition hover:bg-red-50">
                <div class="bg-gradient-to-br from-red-400 to-red-600 text-white p-3 rounded-full">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                </div>
                <span class="flex-1 font-semibold text-gray-900 text-left">Logout</span>
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </button>
        </div>
    </div>

    <!-- Logout Modal -->
    <div id="logoutModal"
        class="hidden fixed inset-0 bg-gray-900/70 backdrop-blur-md z-[100] flex items-center justify-center p-4"
        style="backdrop-filter: blur(8px); -webkit-backdrop-filter: blur(8px);">
        <div class="bg-white rounded-3xl shadow-2xl max-w-sm w-full p-6 relative z-[101]">
            <h2 class="text-lg font-bold text-gray-900 mb-3 text-center">Logout</h2>
            <p class="text-sm text-gray-600 mb-6 text-center">Apakah Anda yakin ingin keluar dari aplikasi?</p>

            <form action="{{ route('logout') }}" method="POST" class="space-y-3">
                @csrf
                <button type="submit"
                    class="w-full bg-red-500 text-white font-semibold py-3 rounded-xl hover:bg-red-600 transition">
                    Logout
                </button>
                <button type="button" onclick="closeLogoutModal()"
                    class="w-full bg-gray-100 text-gray-700 font-semibold py-3 rounded-xl hover:bg-gray-200 transition">
                    Batal
                </button>
            </form>
        </div>
    </div>

    <script>
        function confirmLogout() {
            document.getElementById('logoutModal').classList.remove('hidden');
        }

        function closeLogoutModal() {
            document.getElementById('logoutModal').classList.add('hidden');
        }
    </script>
    <script>
        // Expose robust helpers on the window so onclick handlers can call them reliably.
        window.openMitraPhotoModal = function () {
            const tryEmit = () => {
                if (window.livewire && typeof window.livewire.emit === 'function') {
                    window.livewire.emit('openModal');
                    return true;
                }
                if (window.Livewire) {
                    if (typeof window.Livewire.emit === 'function') {
                        window.Livewire.emit('openModal');
                        return true;
                    }
                    if (typeof window.Livewire.dispatch === 'function') {
                        window.Livewire.dispatch('openModal');
                        return true;
                    }
                }
                return false;
            };

            if (tryEmit()) return;

            let attempts = 0;
            const interval = setInterval(() => {
                attempts++;
                if (tryEmit()) {
                    clearInterval(interval);
                    return;
                }
                if (attempts >= 10) {
                    clearInterval(interval);
                    console.warn('openMitraPhotoModal: Livewire emit not available.');
                }
            }, 200);
        };

        // Helper to open mitra profile edit modal by emitting 'openEditProfile'
        window.openMitraEditProfile = function () {
            const tryEmit = () => {
                if (window.livewire && typeof window.livewire.emit === 'function') {
                    window.livewire.emit('openEditProfile');
                    return true;
                }
                if (window.Livewire) {
                    if (typeof window.Livewire.emit === 'function') {
                        window.Livewire.emit('openEditProfile');
                        return true;
                    }
                    if (typeof window.Livewire.dispatch === 'function') {
                        window.Livewire.dispatch('openEditProfile');
                        return true;
                    }
                }
                return false;
            };

            if (tryEmit()) return;

            let attempts = 0;
            const interval = setInterval(() => {
                attempts++;
                if (tryEmit()) {
                    clearInterval(interval);
                    return;
                }
                if (attempts >= 10) {
                    clearInterval(interval);
                    console.warn('openMitraEditProfile: Livewire emit not available.');
                }
            }, 200);
        };
    </script>
</div>