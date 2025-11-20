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
                                Nama</th>
                            <th class="px-6 py-5 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                Email</th>
                            <th class="px-6 py-5 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">NIK
                            </th>
                            <th class="px-6 py-5 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">TTL
                            </th>
                            <th class="px-6 py-5 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                Lokasi</th>
                            <th class="px-6 py-5 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                Role</th>
                            <th class="px-6 py-5 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                Status</th>
                            <th class="px-6 py-5 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                Dibuat</th>
                            <th class="px-6 py-5 text-center text-xs font-bold text-gray-700 uppercase tracking-wider">
                                Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($verifications as $reg)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-5 whitespace-nowrap text-sm font-medium text-gray-900">{{ $reg->id }}
                                </td>
                                <td class="px-6 py-5">
                                    <div class="text-sm font-semibold text-gray-900">{{ $reg->full_name }}</div>
                                </td>
                                <td class="px-6 py-5 text-sm text-gray-500">{{ $reg->email }}</td>
                                <td class="px-6 py-5 text-sm font-mono">{{ $reg->nik ?? '-' }}</td>
                                <td class="px-6 py-5 text-sm">{{ $reg->place_of_birth ?? '-' }},
                                    {{ $reg->date_of_birth ? date('d/m/Y', strtotime($reg->date_of_birth)) : '-' }}
                                </td>
                                <td class="px-6 py-5 text-sm">{{ $reg->city ?? '-' }}, {{ $reg->province ?? '-' }}</td>
                                <td class="px-6 py-5 text-sm">{{ $reg->role ?? 'customer' }}</td>
                                <td class="px-6 py-5 text-sm">
                                    <span
                                        class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $reg->status === 'approved' ? 'bg-green-100 text-green-800' : ($reg->status === 'pending_verification' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                        {{ $reg->status === 'approved' ? 'Terverifikasi' : ($reg->status === 'pending_verification' ? 'Pending' : 'Ditolak') }}
                                    </span>
                                </td>
                                <td class="px-6 py-5 text-sm text-gray-500">
                                    {{ optional($reg->created_at)->format('d M Y') }}
                                </td>
                                <td class="px-6 py-5 text-center text-sm font-medium">
                                    <div class="flex items-center justify-center space-x-2">
                                        <button type="button" wire:click.prevent="viewKtp({{ $reg->id }})"
                                            class="js-view-detail text-blue-600 hover:text-blue-900 p-2 hover:bg-blue-50 rounded-lg transition"
                                            title="Lihat Detail" data-id="{{ $reg->id }}"
                                            data-name="{{ htmlspecialchars($reg->full_name, ENT_QUOTES) }}"
                                            data-email="{{ htmlspecialchars($reg->email, ENT_QUOTES) }}"
                                            data-nik="{{ htmlspecialchars($reg->nik ?? '-', ENT_QUOTES) }}"
                                            data-address="{{ htmlspecialchars($reg->address ?? '-', ENT_QUOTES) }}"
                                            data-status="{{ $reg->status }}"
                                            data-ktp="{{ $reg->ktp_photo_path ? Storage::url($reg->ktp_photo_path) : '' }}"
                                            data-selfie="{{ $reg->selfie_photo_path ? Storage::url($reg->selfie_photo_path) : '' }}">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </button>
                                        @if ($reg->status === 'pending_verification')
                                            <button type="button" wire:click.prevent="approveKtp({{ $reg->id }})"
                                                class="text-green-600 hover:text-green-900 p-2 hover:bg-green-50 rounded-lg transition"
                                                title="Setujui">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M9 12l2 2 4-4" />
                                                </svg>
                                            </button>
                                            <button type="button" wire:click.prevent="rejectKtp({{ $reg->id }})"
                                                class="text-red-600 hover:text-red-900 p-2 hover:bg-red-50 rounded-lg transition"
                                                title="Tolak">
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

    @if(isset($selectedRegistration) && $selectedRegistration)
        <div class="fixed inset-0 z-50 flex items-center justify-center">
            <div class="fixed inset-0 bg-black/50" wire:click="closeModal"></div>

            <div class="bg-white max-w-3xl w-full rounded-xl shadow-xl z-10 overflow-hidden">
                <div class="p-6">
                    <div class="flex items-start justify-between">
                        <div>
                            <h3 class="text-lg font-bold">Detail Registrasi: {{ $selectedRegistration->full_name }}</h3>
                            <p class="text-sm text-gray-500">Email: {{ $selectedRegistration->email }}</p>
                            <p class="text-sm text-gray-500">NIK: {{ $selectedRegistration->nik ?? '-' }}</p>
                        </div>
                        <div class="flex items-center gap-2">
                            @if($selectedRegistration->status === 'pending_verification')
                                <button type="button" wire:click.prevent="approveKtp({{ $selectedRegistration->id }})"
                                    class="px-3 py-2 bg-green-600 text-white rounded">Setujui</button>
                                <button type="button" wire:click.prevent="rejectKtp({{ $selectedRegistration->id }})"
                                    class="px-3 py-2 bg-red-600 text-white rounded">Tolak</button>
                            @endif
                            <button type="button" wire:click.prevent="closeModal"
                                class="px-3 py-2 bg-gray-200 rounded">Tutup</button>
                        </div>
                    </div>

                    <div class="mt-4 grid grid-cols-2 gap-4">
                        <div>
                            <h4 class="text-sm font-semibold text-gray-700 mb-2">Foto KTP</h4>
                            @if($selectedRegistration->ktp_photo_path)
                                <img src="{{ Storage::url($selectedRegistration->ktp_photo_path) }}" alt="KTP"
                                    class="w-full rounded cursor-pointer object-contain max-h-96"
                                    wire:click.prevent="showPhoto('{{ Storage::url($selectedRegistration->ktp_photo_path) }}')" />
                            @else
                                <div class="text-sm text-gray-400">Tidak ada foto KTP</div>
                            @endif
                        </div>
                        <div>
                            <h4 class="text-sm font-semibold text-gray-700 mb-2">Foto Selfie</h4>
                            @if($selectedRegistration->selfie_photo_path)
                                <img src="{{ Storage::url($selectedRegistration->selfie_photo_path) }}" alt="Selfie"
                                    class="w-full rounded cursor-pointer object-contain max-h-96"
                                    wire:click.prevent="showPhoto('{{ Storage::url($selectedRegistration->selfie_photo_path) }}')" />
                            @else
                                <div class="text-sm text-gray-400">Tidak ada foto selfie</div>
                            @endif
                        </div>
                    </div>

                    <div class="mt-4">
                        <h5 class="text-sm font-semibold text-gray-700">Alamat</h5>
                        <p class="text-sm text-gray-600">{{ $selectedRegistration->address ?? '-' }}</p>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if(isset($previewPhoto) && $previewPhoto)
        <div class="fixed inset-0 z-60 flex items-center justify-center">
            <div class="fixed inset-0 bg-black/70" wire:click.prevent="closePreview"></div>

            <div class="relative z-70 max-w-4xl w-full px-4">
                <button type="button" wire:click.prevent="closePreview"
                    class="absolute -top-2 -right-2 bg-white rounded-full p-2 shadow-md hover:bg-gray-100">
                    <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>

                <div class="bg-white rounded-lg overflow-hidden shadow-lg">
                    <img src="{{ $previewPhoto }}" alt="Preview" class="w-full h-auto object-contain max-h-[80vh]" />
                </div>
            </div>
        </div>
    @endif

    <!-- JS fallback modal (shows when Livewire isn't responding) -->
    <div id="js-detail-modal" class="hidden fixed inset-0 z-70 items-center justify-center">
        <div id="js-detail-overlay" class="fixed inset-0 bg-black/50"></div>

        <div class="bg-white max-w-3xl w-full rounded-xl shadow-xl z-10 overflow-hidden relative">
            <div class="p-6">
                <div class="flex items-start justify-between">
                    <div>
                        <h3 id="js-detail-name" class="text-lg font-bold">Detail Registrasi</h3>
                        <p id="js-detail-email" class="text-sm text-gray-500"></p>
                        <p id="js-detail-nik" class="text-sm text-gray-500"></p>
                    </div>
                    <div class="flex items-center gap-2">
                        <button id="js-approve-btn" type="button"
                            class="px-3 py-2 bg-green-600 text-white rounded hidden">Setujui</button>
                        <button id="js-reject-btn" type="button"
                            class="px-3 py-2 bg-red-600 text-white rounded hidden">Tolak</button>
                        <button id="js-close-btn" type="button" class="px-3 py-2 bg-gray-200 rounded">Tutup</button>
                    </div>
                </div>

                <div class="mt-4 grid grid-cols-2 gap-4">
                    <div>
                        <h4 class="text-sm font-semibold text-gray-700 mb-2">Foto KTP</h4>
                        <img id="js-detail-ktp" src="" alt="KTP" class="w-full rounded object-contain max-h-96" />
                    </div>
                    <div>
                        <h4 class="text-sm font-semibold text-gray-700 mb-2">Foto Selfie</h4>
                        <img id="js-detail-selfie" src="" alt="Selfie" class="w-full rounded object-contain max-h-96" />
                    </div>
                </div>

                <div class="mt-4">
                    <h5 class="text-sm font-semibold text-gray-700">Alamat</h5>
                    <p id="js-detail-address" class="text-sm text-gray-600"></p>
                </div>
            </div>
        </div>
    </div>

    <script>
        (function () {
            function qs(selector, ctx) { return (ctx || document).querySelector(selector); }
            function qsa(selector, ctx) { return Array.from((ctx || document).querySelectorAll(selector)); }

            function openModal(data) {
                var modal = qs('#js-detail-modal');
                qs('#js-detail-name').textContent = 'Detail Registrasi: ' + data.name;
                qs('#js-detail-email').textContent = 'Email: ' + data.email;
                qs('#js-detail-nik').textContent = 'NIK: ' + data.nik;
                qs('#js-detail-address').textContent = data.address;
                qs('#js-detail-ktp').src = data.ktp || '';
                qs('#js-detail-selfie').src = data.selfie || '';

                // Show/hide approve/reject based on status
                var approve = qs('#js-approve-btn');
                var reject = qs('#js-reject-btn');
                if (data.status === 'pending_verification') {
                    approve.classList.remove('hidden');
                    reject.classList.remove('hidden');
                } else {
                    approve.classList.add('hidden');
                    reject.classList.add('hidden');
                }

                modal.classList.remove('hidden');
                modal.classList.add('flex');

                // wire events if Livewire available
                approve.onclick = function () { if (window.livewire && window.livewire.emit) { window.livewire.emit('approveKtp', data.id); } };
                reject.onclick = function () { if (window.livewire && window.livewire.emit) { window.livewire.emit('rejectKtp', data.id); } };
            }

            function closeModal() {
                var modal = qs('#js-detail-modal');
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }

            // Attach handlers
            document.addEventListener('click', function (e) {
                var btn = e.target.closest && e.target.closest('.js-view-detail');
                if (btn) {
                    e.preventDefault();
                    var data = {
                        id: btn.dataset.id,
                        name: btn.dataset.name || '',
                        email: btn.dataset.email || '',
                        nik: btn.dataset.nik || '',
                        address: btn.dataset.address || '',
                        status: btn.dataset.status || '',
                        ktp: btn.dataset.ktp || '',
                        selfie: btn.dataset.selfie || ''
                    };
                    openModal(data);
                }
            }, false);

            qs('#js-close-btn').addEventListener('click', closeModal);
            qs('#js-detail-overlay').addEventListener('click', closeModal);
        })();
    </script>

</div>