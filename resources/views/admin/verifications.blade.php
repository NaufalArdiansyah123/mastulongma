<div>
    <header class="bg-white shadow-sm border-b border-gray-200 sticky top-0 z-10">
        <div class="px-8 py-6">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Verifikasi KTP Mitra</h1>
                <p class="text-sm text-gray-600 mt-1">Verifikasi identitas mitra untuk keamanan platform</p>
            </div>
        </div>
    </header>

    <div class="p-12">
        <!-- Filter Cards -->
        <div class="grid grid-cols-3 gap-6 mb-8">
            <div class="bg-white rounded-2xl shadow-md p-6 border border-gray-200">
                <label class="block text-sm font-semibold text-gray-700 mb-3">
                    <svg class="w-5 h-5 inline mr-2 text-primary-600" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    Cari Mitra
                </label>
                <input type="text" wire:model.live="search" placeholder="Cari nama, email, atau NIK..."
                    class="w-full px-4 py-3 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
            </div>

            <div class="bg-white rounded-2xl shadow-md p-6 border border-gray-200">
                <label class="block text-sm font-semibold text-gray-700 mb-3">
                    <svg class="w-5 h-5 inline mr-2 text-primary-600" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                    </svg>
                    Filter Status
                </label>
                <select wire:model.live="statusFilter"
                    class="w-full px-4 py-3 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                    <option value="">Semua Status</option>
                    <option value="pending">Pending</option>
                    <option value="verified">Terverifikasi</option>
                </select>
            </div>

            <div class="bg-white rounded-2xl shadow-md p-6 border border-gray-200">
                <label class="block text-sm font-semibold text-gray-700 mb-3">
                    <svg class="w-5 h-5 inline mr-2 text-primary-600" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    Per Halaman
                </label>
                <select wire:model.live="perPage"
                    class="w-full px-4 py-3 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                    <option value="10">10 Data</option>
                    <option value="25">25 Data</option>
                    <option value="50">50 Data</option>
                    <option value="100">100 Data</option>
                </select>
            </div>
        </div>

        <!-- Table Card -->
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-5 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">ID
                            </th>
                            <th class="px-6 py-5 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                Nama Mitra</th>
                            <th class="px-6 py-5 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                NIK</th>
                            <th class="px-6 py-5 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                No. HP</th>
                            <th class="px-6 py-5 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                Foto KTP</th>
                            <th class="px-6 py-5 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                Status</th>
                            <th class="px-6 py-5 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                Upload</th>
                            <th class="px-6 py-5 text-center text-xs font-bold text-gray-700 uppercase tracking-wider">
                                Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($verifications as $mitra)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-5 whitespace-nowrap text-sm font-medium text-gray-900">
                                    #{{ $mitra->id }}
                                </td>
                                <td class="px-6 py-5">
                                    <div class="flex items-center">
                                        <div class="h-12 w-12 flex-shrink-0">
                                            <div
                                                class="h-12 w-12 rounded-full bg-green-600 flex items-center justify-center text-white font-bold text-lg">
                                                {{ substr($mitra->name, 0, 1) }}
                                            </div>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-semibold text-gray-900">{{ $mitra->name }}</div>
                                            <div class="text-sm text-gray-500">{{ $mitra->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-5 whitespace-nowrap">
                                    <div class="text-sm text-gray-900 font-mono">{{ $mitra->nik ?? '-' }}</div>
                                </td>
                                <td class="px-6 py-5 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $mitra->phone ?? '-' }}</div>
                                </td>
                                <td class="px-6 py-5 whitespace-nowrap">
                                    @if ($mitra->ktp_path)
                                        <button wire:click="viewKtp({{ $mitra->id }})"
                                            class="text-blue-600 hover:text-blue-900 text-sm font-medium flex items-center space-x-1">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                            <span>Lihat</span>
                                        </button>
                                    @else
                                        <span class="text-gray-400 text-sm">-</span>
                                    @endif
                                </td>
                                <td class="px-6 py-5 whitespace-nowrap">
                                    <span
                                        class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $mitra->verified ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                        {{ $mitra->verified ? 'Terverifikasi' : 'Pending' }}
                                    </span>
                                </td>
                                <td class="px-6 py-5 whitespace-nowrap text-sm text-gray-500">
                                    {{ $mitra->created_at->format('d M Y') }}
                                </td>
                                <td class="px-6 py-5 whitespace-nowrap text-center text-sm font-medium">
                                    <div class="flex items-center justify-center space-x-2">
                                        <button wire:click="viewKtp({{ $mitra->id }})"
                                            class="text-blue-600 hover:text-blue-900 p-2 hover:bg-blue-50 rounded-lg transition"
                                            title="Lihat KTP">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </button>
                                        @if (!$mitra->verified)
                                            <button wire:click="approveKtp({{ $mitra->id }})"
                                                class="text-green-600 hover:text-green-900 p-2 hover:bg-green-50 rounded-lg transition"
                                                title="Verifikasi">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                                </svg>
                                            </button>
                                        @endif
                                        @if ($mitra->verified)
                                            <button wire:click="rejectKtp({{ $mitra->id }})"
                                                class="text-red-600 hover:text-red-900 p-2 hover:bg-red-50 rounded-lg transition"
                                                title="Batalkan Verifikasi">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <svg class="w-20 h-20 text-gray-300 mb-4" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                        <p class="text-gray-500 text-lg font-medium">Tidak ada data verifikasi</p>
                                        <p class="text-gray-400 text-sm mt-1">Belum ada mitra yang upload KTP</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if ($verifications->hasPages())
                <div class="bg-gray-50 px-6 py-5 border-t border-gray-200">
                    {{ $verifications->links() }}
                </div>
            @endif
        </div>
    </div>

    @if ($showModal && $selectedUser)
        <div class="fixed inset-0 bg-transparent backdrop-blur-sm flex items-center justify-center z-50 p-4">
            <div class="bg-white rounded-2xl shadow-2xl w-full max-w-3xl overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                    <div>
                        <h2 class="text-xl font-bold text-gray-900">Detail KTP Mitra</h2>
                        <p class="text-sm text-gray-500 mt-1">Periksa kecocokan data sebelum memverifikasi.</p>
                    </div>
                    <button wire:click="$set('showModal', false)" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <div class="grid grid-cols-2 gap-6 p-6">
                    <div>
                        <h3 class="text-sm font-semibold text-gray-700 mb-3">Data Mitra</h3>
                        <dl class="space-y-3 text-sm">
                            <div class="flex justify-between">
                                <dt class="text-gray-500">Nama</dt>
                                <dd class="font-medium text-gray-900">{{ $selectedUser->name }}</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-gray-500">Email</dt>
                                <dd class="font-medium text-gray-900">{{ $selectedUser->email }}</dd>
                            </div>
                            @if ($selectedUser->phone)
                                <div class="flex justify-between">
                                    <dt class="text-gray-500">No. HP</dt>
                                    <dd class="font-medium text-gray-900">{{ $selectedUser->phone }}</dd>
                                </div>
                            @endif
                            <div class="flex justify-between">
                                <dt class="text-gray-500">Status Akun</dt>
                                <dd>
                                    <span
                                        class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $selectedUser->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-700' }}">
                                        {{ ucfirst($selectedUser->status) }}
                                    </span>
                                </dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-gray-500">Status KTP</dt>
                                <dd>
                                    <span
                                        class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $selectedUser->verified ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                        {{ $selectedUser->verified ? 'Terverifikasi' : 'Pending' }}
                                    </span>
                                </dd>
                            </div>
                        </dl>

                        <div class="mt-6">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Alasan penolakan
                                (opsional)</label>
                            <textarea wire:model.live="rejectReason" rows="3"
                                class="w-full px-3 py-2 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-red-500 focus:border-red-500"
                                placeholder="Tuliskan alasan jika Anda menolak verifikasi KTP ini..."></textarea>
                        </div>
                    </div>

                    <div>
                        <h3 class="text-sm font-semibold text-gray-700 mb-3">Foto KTP</h3>
                        @if ($selectedUser->ktp_path)
                            <div class="border border-gray-200 rounded-xl overflow-hidden bg-gray-50">
                                <img src="{{ Storage::url($selectedUser->ktp_path) }}" alt="KTP {{ $selectedUser->name }}"
                                    class="w-full max-h-[420px] object-contain bg-black" />
                            </div>
                        @else
                            <div
                                class="border border-dashed border-gray-300 rounded-xl h-64 flex items-center justify-center text-gray-400 text-sm">
                                Mitra belum mengunggah foto KTP.
                            </div>
                        @endif
                    </div>
                </div>

                <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex items-center justify-between">
                    <div class="text-xs text-gray-500">Tinjau dengan teliti sebelum menyetujui demi keamanan platform.</div>
                    <div class="flex space-x-3">
                        @if (!$selectedUser->verified)
                            <button wire:click="rejectKtp({{ $selectedUser->id }})"
                                class="px-4 py-2 border border-gray-300 text-gray-700 rounded-xl text-sm font-medium hover:bg-gray-100">
                                Tolak
                            </button>
                            <button wire:click="approveKtp({{ $selectedUser->id }})"
                                class="px-4 py-2 bg-green-600 text-white rounded-xl text-sm font-medium hover:bg-green-700">
                                Verifikasi
                            </button>
                        @else
                            <button wire:click="rejectKtp({{ $selectedUser->id }})"
                                class="px-4 py-2 border border-red-300 text-red-700 rounded-xl text-sm font-medium hover:bg-red-50">
                                Batalkan Verifikasi
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>