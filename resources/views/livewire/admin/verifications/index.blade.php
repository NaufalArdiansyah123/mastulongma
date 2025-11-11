<div class="min-h-screen bg-gray-50 pb-20">
    <!-- Header -->
    <div class="bg-white border-b border-gray-200 sticky top-0 z-10">
        <div
            class="h-6 bg-gradient-to-r from-primary-400 via-primary-500 to-primary-600 flex items-center justify-between px-4 text-white text-xs">
            <span>{{ now()->format('H:i') }}</span>
            <span>Verifikasi KTP</span>
            <span>●●●●</span>
        </div>

        <div class="px-4 py-3">
            <div class="flex items-center space-x-3">
                <a href="{{ route('admin.dashboard') }}" class="text-gray-600 hover:text-gray-900">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </a>
                <h1 class="text-xl font-bold text-gray-900">Verifikasi KTP</h1>
            </div>
        </div>

        <div class="px-4 pb-3 space-y-2">
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari nama, email, atau telepon..."
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500" />

            <select wire:model.live="verifiedFilter"
                class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-primary-500">
                <option value="">Semua Status</option>
                <option value="0">Belum Terverifikasi</option>
                <option value="1">Terverifikasi</option>
            </select>
        </div>
    </div>

    <!-- Users List -->
    <div class="p-4 space-y-3">
        @forelse($users as $user)
            <div class="bg-white rounded-xl border border-gray-200 p-4 shadow-sm">
                <div class="flex items-start justify-between">
                    <div class="flex-1">
                        <div class="flex items-center space-x-2 mb-1">
                            <h3 class="font-semibold text-gray-900">{{ $user->name }}</h3>
                            @if($user->verified)
                                <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                </svg>
                            @endif
                        </div>

                        <p class="text-sm text-gray-600 mb-1">{{ $user->email }}</p>
                        @if($user->phone)
                            <p class="text-sm text-gray-600 mb-2">{{ $user->phone }}</p>
                        @endif

                        <div class="flex flex-wrap gap-2">
                            <span
                                class="px-2 py-1 text-xs rounded-full {{ $user->role === 'mitra' ? 'bg-green-100 text-green-700' : 'bg-blue-100 text-blue-700' }}">
                                {{ ucfirst($user->role) }}
                            </span>

                            <span
                                class="px-2 py-1 text-xs rounded-full {{ $user->verified ? 'bg-green-100 text-green-700' : 'bg-amber-100 text-amber-700' }}">
                                {{ $user->verified ? 'Terverifikasi' : 'Belum Verifikasi' }}
                            </span>

                            @if($user->city)
                                <span class="px-2 py-1 text-xs rounded-full bg-indigo-100 text-indigo-700">
                                    {{ $user->city->name }}
                                </span>
                            @endif
                        </div>

                        @if($user->ktp_path)
                            <div class="mt-3">
                                <button wire:click="showKTP({{ $user->id }})"
                                    class="text-sm text-primary-600 hover:text-primary-700 font-medium flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    Lihat KTP
                                </button>
                            </div>
                        @else
                            <p class="text-xs text-gray-500 mt-2">Belum upload KTP</p>
                        @endif
                    </div>

                    @if(!$user->verified && $user->ktp_path)
                        <div class="ml-3">
                            <button wire:click="verifyUser({{ $user->id }})"
                                class="px-3 py-1.5 bg-green-600 text-white rounded-lg text-sm font-medium hover:bg-green-700">
                                Verifikasi
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        @empty
            <div class="text-center py-12">
                <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                </svg>
                <p class="text-gray-600">Tidak ada pengguna untuk diverifikasi</p>
            </div>
        @endforelse

        <div class="mt-4">
            {{ $users->links() }}
        </div>
    </div>

    <!-- KTP Modal -->
    @if($showModal && $selectedUser)
        <div class="fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center z-50 p-4">
            <div class="bg-white rounded-2xl w-full max-w-md overflow-hidden">
                <div class="bg-white border-b border-gray-200 px-4 py-3 flex items-center justify-between">
                    <h2 class="text-lg font-bold text-gray-900">KTP - {{ $selectedUser->name }}</h2>
                    <button wire:click="$set('showModal', false)" class="text-gray-600 hover:text-gray-900">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <div class="p-4">
                    @if($selectedUser->ktp_path)
                        <div class="mb-4">
                            <img src="{{ Storage::url($selectedUser->ktp_path) }}" alt="KTP {{ $selectedUser->name }}"
                                class="w-full rounded-lg border border-gray-200" />
                        </div>

                        <div class="space-y-2 mb-4 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Nama:</span>
                                <span class="font-medium">{{ $selectedUser->name }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Email:</span>
                                <span class="font-medium">{{ $selectedUser->email }}</span>
                            </div>
                            @if($selectedUser->phone)
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Telepon:</span>
                                    <span class="font-medium">{{ $selectedUser->phone }}</span>
                                </div>
                            @endif
                            <div class="flex justify-between">
                                <span class="text-gray-600">Role:</span>
                                <span class="font-medium">{{ ucfirst($selectedUser->role) }}</span>
                            </div>
                        </div>

                        @if(!$selectedUser->verified)
                            <div class="flex space-x-3">
                                <button wire:click="rejectUser({{ $selectedUser->id }})"
                                    wire:confirm="Apakah Anda yakin ingin menolak verifikasi ini?"
                                    class="flex-1 px-4 py-3 border border-gray-300 text-gray-700 rounded-lg font-medium hover:bg-gray-50">
                                    Tolak
                                </button>
                                <button wire:click="verifyUser({{ $selectedUser->id }})"
                                    class="flex-1 px-4 py-3 bg-green-600 text-white rounded-lg font-medium hover:bg-green-700">
                                    Verifikasi
                                </button>
                            </div>
                        @else
                            <div class="p-3 bg-green-50 border border-green-200 rounded-lg text-center">
                                <p class="text-green-700 font-medium">User sudah terverifikasi</p>
                            </div>
                        @endif
                    @else
                        <div class="text-center py-8">
                            <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <p class="text-gray-600">KTP belum diupload</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @endif

    <!-- Bottom Navigation -->
    <div class="fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 px-4 py-2">
        <div class="flex justify-around items-center max-w-md mx-auto">
            <a href="{{ route('admin.dashboard') }}" class="flex flex-col items-center py-2 px-4 text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 13h8V3H3v10zm0 8h8v-6H3v6zm10 0h8V11h-8v10zm0-18v6h8V3h-8z" />
                </svg>
                <span class="text-xs mt-1">Dashboard</span>
            </a>

            <a href="{{ route('admin.helps') }}" class="flex flex-col items-center py-2 px-4 text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                </svg>
                <span class="text-xs mt-1">Bantuan</span>
            </a>

            <a href="{{ route('admin.verifications') }}" class="flex flex-col items-center py-2 px-4 text-primary-600">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                    <path
                        d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                </svg>
                <span class="text-xs mt-1 font-medium">Verifikasi</span>
            </a>
        </div>
    </div>
</div>