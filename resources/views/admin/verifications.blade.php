<div>
    @php
        // Ambil semua user — jika model tidak ada, gunakan koleksi kosong
        if (class_exists(\App\Models\User::class)) {
            $users = \App\Models\User::orderBy('created_at', 'desc')->get();
        } else {
            $users = collect();
        }

        // helper untuk membaca kolom KTP/telepon dengan toleransi nama kolom berbeda
        function get_user_field($user, $candidates = [])
        {
            foreach ($candidates as $col) {
                if (isset($user->$col))
                    return $user->$col;
            }
            return null;
        }
    @endphp

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
                                <th
                                    class="px-6 py-5 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                    ID
                                </th>
                                <th
                                    class="px-6 py-5 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                    Nama Mitra</th>
                                <th
                                    class="px-6 py-5 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                    Role</th>
                                <th
                                    class="px-6 py-5 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                    NIK</th>
                                <th
                                    class="px-6 py-5 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                    Foto Selfie</th>
                                <th
                                    class="px-6 py-5 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                    Foto KTP</th>
                                <th
                                    class="px-6 py-5 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                    Status</th>
                                <th
                                    class="px-6 py-5 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                    Upload</th>
                                <th
                                    class="px-6 py-5 text-center text-xs font-bold text-gray-700 uppercase tracking-wider">
                                    Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @php
                                // If Livewire $verifications is empty, fallback to top-level $users (plain User list)
                                $rows = (isset($verifications) && $verifications->count()) ? $verifications : $users;
                            @endphp
                            @forelse($rows as $mitra)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-6 py-5 whitespace-nowrap text-sm font-medium text-gray-900">
                                        #{{ $mitra->id }}
                                    </td>
                                    <td class="px-6 py-5">
                                        <div class="flex items-center">
                                            <div class="h-12 w-12 flex-shrink-0">
                                                <div class="h-12 w-12 rounded-full bg-green-600 flex items-center justify-center text-white font-bold text-lg">
                                                    {{ substr($mitra->name ?? ($mitra->full_name ?? '-'), 0, 1) }}
                                                </div>
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-semibold text-gray-900">{{ $mitra->name }}</div>
                                                <div class="text-sm text-gray-500">{{ $mitra->email }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-5 whitespace-nowrap">
                                        @php
                                            $roleRaw = get_user_field($mitra, ['role', 'roles', 'role_name', 'role_id']);
                                            $roleLabel = '-';
                                            if (is_array($roleRaw)) {
                                                $roleLabel = implode(', ', $roleRaw);
                                            } elseif (is_string($roleRaw) && $roleRaw !== '') {
                                                $roleLabel = $roleRaw;
                                            } elseif (is_object($roleRaw)) {
                                                if (method_exists($roleRaw, 'pluck')) {
                                                    $roleLabel = implode(', ', $roleRaw->pluck('name')->toArray());
                                                } elseif (property_exists($roleRaw, 'name')) {
                                                    $roleLabel = $roleRaw->name;
                                                }
                                            } elseif (is_numeric($roleRaw)) {
                                                $roleLabel = (string) $roleRaw;
                                            }
                                        @endphp
                                        <div class="text-sm text-gray-700">{{ $roleLabel }}</div>
                                    </td>
                                    <td class="px-6 py-5 whitespace-nowrap">
                                        <div class="text-sm text-gray-900 font-mono">{{ $mitra->nik ?? $mitra->nik_number ?? '-' }}</div>
                                    </td>
                                    <td class="px-6 py-5 whitespace-nowrap">
                                        @php
                                            $selfie = $mitra->selfie_photo_path ?? $mitra->ktp_selfie_path ?? $mitra->selfie_path ?? $mitra->photo_selfie ?? $mitra->selfie ?? null;
                                        @endphp
                                        @if ($selfie)
                                            @php
                                                $isAbsolute = \Illuminate\Support\Str::startsWith($selfie, ['http://', 'https://']);
                                                $isSlash = \Illuminate\Support\Str::startsWith($selfie, '/');
                                                $selfieUrl = $isAbsolute ? $selfie : ($isSlash ? asset($selfie) : asset('storage/' . ltrim($selfie, '/')));
                                            @endphp
                                            <div>
                                                <button type="button" wire:click="showPhoto('{{ $selfieUrl }}')" class="text-blue-600 hover:text-blue-900 text-sm font-medium inline-flex items-center space-x-2">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                    </svg>
                                                    <span>Lihat</span>
                                                </button>
                                            </div>
                                        @else
                                            <span class="text-gray-400 text-sm">-</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-5 whitespace-nowrap">
                                        @php
                                            $ktpPath = $mitra->ktp_path ?? $mitra->ktp_photo_path ?? null;
                                            $ktpUrl = null;
                                            if ($ktpPath) {
                                                $isAbsolute = \Illuminate\Support\Str::startsWith($ktpPath, ['http://', 'https://']);
                                                $isSlash = \Illuminate\Support\Str::startsWith($ktpPath, '/');
                                                $ktpUrl = $isAbsolute ? $ktpPath : ($isSlash ? asset($ktpPath) : asset('storage/' . ltrim($ktpPath, '/')));
                                            }
                                        @endphp
                                        @if ($ktpUrl)
                                            <button wire:click="showPhoto('{{ $ktpUrl }}')" class="text-blue-600 hover:text-blue-900 text-sm font-medium flex items-center space-x-1">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                                <span>Lihat</span>
                                            </button>
                                        @else
                                            <span class="text-gray-400 text-sm">-</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-5 whitespace-nowrap">
                                        @php
                                            $status = strtolower(optional($mitra)->status ?? '');
                                        @endphp
                                        @if(in_array($status, ['approved','verified','active']) || (isset($mitra->verified) && $mitra->verified))
                                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Terverifikasi</span>
                                        @elseif($status === 'rejected')
                                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Ditolak</span>
                                        @else
                                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Pending</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-5 whitespace-nowrap text-sm text-gray-500">
                                        {{ optional($mitra->created_at)->format('d M Y') ?? '-' }}
                                    </td>
                                    <td class="px-6 py-5 whitespace-nowrap text-center text-sm font-medium">
                                        @php
                                            $rowStatus = strtolower(optional($mitra)->status ?? '');
                                            $isVerifiedRow = (isset($mitra->verified) && $mitra->verified) || in_array($rowStatus, ['approved','verified','active']);
                                            $isRejectedRow = $rowStatus === 'rejected';
                                        @endphp
                                        <div class="flex items-center justify-center space-x-2">
                                            <button wire:click="viewKtp({{ $mitra->id }})" class="inline-flex items-center px-3 py-1 bg-white border border-gray-200 text-blue-600 rounded-md text-sm hover:bg-blue-50 transition" title="Lihat detail">
                                                <span>Lihat</span>
                                            </button>

                                            @if (!($isVerifiedRow || $isRejectedRow))
                                                <button wire:click="viewKtp({{ $mitra->id }}, true)" class="inline-flex items-center px-3 py-1 bg-white border border-gray-200 text-red-600 rounded-md text-sm hover:bg-red-50 transition" title="Tolak">
                                                    <span>Tolak</span>
                                                </button>
                                                <button wire:click="approveKtp({{ $mitra->id }})" class="inline-flex items-center px-3 py-1 bg-green-600 text-white rounded-md text-sm hover:bg-green-700 transition" title="Verifikasi">
                                                    <span>Verifikasi</span>
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

        @if ($showModal && ($selectedRegistration || $selectedUser))
            <div class="fixed inset-0 bg-transparent backdrop-blur-sm flex items-center justify-center z-50 p-4">
                <div class="bg-white rounded-2xl shadow-2xl w-full max-w-5xl overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                        <div>
                            <h2 class="text-xl font-bold text-gray-900">Detail Registrasi Mitra</h2>
                            <p class="text-sm text-gray-500 mt-1">Lihat data lengkap registrasi dan foto untuk verifikasi.</p>
                        </div>
                        <button wire:click="closeModal" class="text-gray-500 hover:text-gray-700 bg-gray-50 hover:bg-gray-100 p-2 rounded-md">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <div class="grid grid-cols-3 gap-6 p-6">
                        <div class="col-span-2">
                            <h3 class="text-sm font-semibold text-gray-700 mb-3">Informasi Registrasi</h3>
                            <dl class="grid grid-cols-2 gap-y-3 gap-x-6 text-sm">
                                @php $r = $selectedRegistration ?? null; $u = $selectedUser ?? null; @endphp
                                <div>
                                    <dt class="text-gray-500">Nama Lengkap</dt>
                                    <dd class="font-medium text-gray-900">{{ optional($r)->full_name ?? optional($u)->name ?? '-' }}</dd>
                                </div>
                                <div>
                                    <dt class="text-gray-500">Email</dt>
                                    <dd class="font-medium text-gray-900">{{ optional($r)->email ?? optional($u)->email ?? '-' }}</dd>
                                </div>
                                <div>
                                    <dt class="text-gray-500">NIK</dt>
                                    <dd class="font-medium text-gray-900">{{ optional($r)->nik ?? optional($u)->nik ?? '-' }}</dd>
                                </div>
                                <div>
                                    <dt class="text-gray-500">No. HP</dt>
                                    <dd class="font-medium text-gray-900">{{ optional($u)->phone ?? (optional($r)->phone ?? '-') }}</dd>
                                </div>
                                <div>
                                    <dt class="text-gray-500">Tempat, Tanggal Lahir</dt>
                                    <dd class="font-medium text-gray-900">{{ (optional($r)->place_of_birth ?? '-') . ', ' . (optional(optional($r)->date_of_birth)->format('d M Y') ?? '-') }}</dd>
                                </div>
                                <div>
                                    <dt class="text-gray-500">Jenis Kelamin</dt>
                                    <dd class="font-medium text-gray-900">{{ optional($r)->gender ?? '-' }}</dd>
                                </div>
                                <div class="col-span-2">
                                    <dt class="text-gray-500">Alamat</dt>
                                    <dd class="font-medium text-gray-900">{{ optional($r)->address ?? '-' }} @if(optional($r)->rt || optional($r)->rw) (RT/RW: {{ optional($r)->rt ?? '-' }}/{{ optional($r)->rw ?? '-' }}) @endif</dd>
                                </div>
                                <div>
                                    <dt class="text-gray-500">Kelurahan / Kecamatan</dt>
                                    <dd class="font-medium text-gray-900">{{ (optional($r)->kelurahan ?? '-') . ' / ' . (optional($r)->kecamatan ?? '-') }}</dd>
                                </div>
                                <div>
                                    <dt class="text-gray-500">Kota / Provinsi</dt>
                                    <dd class="font-medium text-gray-900">{{ (optional($r)->city ?? '-') . ' / ' . (optional($r)->province ?? '-') }}</dd>
                                </div>
                                <div>
                                    <dt class="text-gray-500">Pekerjaan</dt>
                                    <dd class="font-medium text-gray-900">{{ optional($r)->occupation ?? '-' }}</dd>
                                </div>
                                <div>
                                    <dt class="text-gray-500">Agama</dt>
                                    <dd class="font-medium text-gray-900">{{ optional($r)->religion ?? '-' }}</dd>
                                </div>
                                <div>
                                    <dt class="text-gray-500">Status Pernikahan</dt>
                                    <dd class="font-medium text-gray-900">{{ optional($r)->marital_status ?? '-' }}</dd>
                                </div>
                                <div>
                                    <dt class="text-gray-500">Status Pendaftaran</dt>
                                    <dd class="font-medium text-gray-900">{{ ucfirst(optional($r)->status ?? optional($u)->status ?? 'pending') }}</dd>
                                </div>
                                <div>
                                    <dt class="text-gray-500">Peran</dt>
                                    <dd class="font-medium text-gray-900">{{ get_user_field($r ?? $u, ['role','roles','role_name']) ?? '-' }}</dd>
                                </div>
                                <div class="col-span-2">
                                    <dt class="text-gray-500">Catatan / Alasan Ditolak</dt>
                                    <dd class="font-medium text-gray-900">{{ optional($r)->reject_reason ?? '-' }}</dd>
                                </div>
                            </dl>

                            @if($showRejectForm)
                                <div id="reject-form" class="mt-6">
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Alasan penolakan (opsional)</label>
                                    <textarea wire:model.live="rejectReason" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-red-500 focus:border-red-500" placeholder="Tuliskan alasan jika Anda menolak verifikasi KTP ini..."></textarea>
                                </div>
                            @endif
                        </div>

                        <div>
                            <h3 class="text-sm font-semibold text-gray-700 mb-3">Foto</h3>
                            <div class="space-y-4">
                                @php
                                    $ktp = optional($r)->ktp_photo_path ?? optional($r)->ktp_path ?? optional($u)->ktp_path ?? null;
                                    $selfie = optional($r)->selfie_photo_path ?? optional($r)->ktp_selfie_path ?? optional($r)->selfie_path ?? optional($u)->selfie ?? null;
                                    $makeUrl = function ($p) {
                                        if (!$p) return null;
                                        $isAbsolute = \Illuminate\Support\Str::startsWith($p, ['http://','https://']);
                                        $isSlash = \Illuminate\Support\Str::startsWith($p, '/');
                                        return $isAbsolute ? $p : ($isSlash ? asset($p) : asset('storage/' . ltrim($p, '/')));
                                    };
                                    $ktpUrl = $makeUrl($ktp);
                                    $selfieUrl = $makeUrl($selfie);
                                @endphp

                                <div>
                                    <dt class="text-gray-500">Foto KTP</dt>
                                    @if ($ktpUrl)
                                        <div class="border border-gray-200 rounded-xl overflow-hidden bg-gray-50">
                                            <img src="{{ $ktpUrl }}" alt="KTP" class="w-full max-h-[320px] object-contain bg-black" />
                                        </div>
                                        <div class="mt-2">
                                            <button wire:click="showPhoto('{{ $ktpUrl }}')" class="inline-flex items-center px-3 py-2 bg-white border border-gray-200 rounded-lg text-sm text-blue-600 hover:bg-gray-50">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                                                Lihat KTP
                                            </button>
                                        </div>
                                    @else
                                        <div class="border border-dashed border-gray-300 rounded-xl h-40 flex items-center justify-center text-gray-400 text-sm">Belum ada foto KTP</div>
                                    @endif
                                </div>

                                <div>
                                    <dt class="text-gray-500">Foto Selfie</dt>
                                    @if ($selfieUrl)
                                        <div class="border border-gray-200 rounded-xl overflow-hidden bg-gray-50">
                                            <img src="{{ $selfieUrl }}" alt="Selfie" class="w-full max-h-[320px] object-contain bg-black" />
                                        </div>
                                        <div class="mt-2">
                                            <button wire:click="showPhoto('{{ $selfieUrl }}')" class="inline-flex items-center px-3 py-2 bg-white border border-gray-200 rounded-lg text-sm text-blue-600 hover:bg-gray-50">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                                                Lihat Selfie
                                            </button>
                                        </div>
                                    @else
                                        <div class="border border-dashed border-gray-300 rounded-xl h-40 flex items-center justify-center text-gray-400 text-sm">Belum ada foto Selfie</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex items-center justify-between">
                        <div class="text-xs text-gray-500">Tinjau dengan teliti sebelum menyetujui demi keamanan platform.</div>
                        <div class="flex space-x-3">
                            @php $actionId = optional($selectedRegistration)->id ?? optional($selectedUser)->id ?? null; @endphp
                            @if (!$actionId)
                                <span class="text-sm text-gray-500">ID tidak tersedia</span>
                            @else
                                @php
                                    $currentStatus = optional($selectedRegistration)->status ?? optional($selectedUser)->status ?? '';
                                    $isVerifiedFlag = optional($selectedUser)->verified ?? false;
                                @endphp

                                {{-- Show actions only when registration is not approved/verified and not rejected --}}
                                @if ($currentStatus !== 'approved' && $currentStatus !== 'rejected' && !$isVerifiedFlag)
                                    <button type="button" wire:click="$set('showRejectForm', true)" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-xl text-sm font-medium hover:bg-gray-100">Tolak</button>
                                    @if($showRejectForm)
                                        <button wire:click="rejectKtp({{ $actionId }})" class="px-4 py-2 bg-red-600 text-white rounded-xl text-sm font-medium hover:bg-red-700">Kirim Penolakan</button>
                                    @endif
                                    <button wire:click="approveKtp({{ $actionId }})" class="px-4 py-2 bg-green-600 text-white rounded-xl text-sm font-medium hover:bg-green-700">Verifikasi</button>
                                @elseif($currentStatus === 'approved' || $isVerifiedFlag)
                                    <button wire:click="rejectKtp({{ $actionId }})" class="px-4 py-2 border border-red-300 text-red-700 rounded-xl text-sm font-medium hover:bg-red-50">Batalkan Verifikasi</button>
                                @else
                                    {{-- For rejected or unknown states, show no action buttons except maybe a label --}}
                                    <span class="px-4 py-2 inline-block text-sm text-gray-600">Tidak ada aksi tersedia</span>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endif

        @if ($previewPhoto)
            <div class="fixed inset-0 bg-black bg-opacity-60 flex items-center justify-center z-50 p-4">
                <div class="relative bg-transparent rounded-md max-w-4xl w-full">
                    <button wire:click="closePreview" class="absolute top-3 right-3 z-50 bg-white rounded-full p-2 shadow-md">
                        <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                    <div class="rounded-md overflow-hidden bg-white">
                        <img src="{{ $previewPhoto }}" alt="Preview Foto KTP" class="w-full max-h-[80vh] object-contain bg-black" />
                    </div>
                </div>
            </div>
        @endif
    </div>

    