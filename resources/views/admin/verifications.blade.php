<div>
    <div class="px-6 py-8">
        @if (session()->has('message'))
            <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-xl text-green-700 flex items-start gap-2">
                <svg class="w-5 h-5 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"/>
                </svg>
                <div>{{ session('message') }}</div>
            </div>
        @endif

        <!-- Filter Section -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
            <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100">
                <label class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-2 block">Cari Mitra</label>
                <div class="relative">
                    <input type="text" wire:model.debounce.500ms="search" placeholder="Nama, email, atau NIK..." class="w-full px-4 py-2.5 pl-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition" />
                    <svg class="w-5 h-5 text-gray-400 absolute left-3 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
            </div>

            <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100">
                <label class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-2 block">Filter Status</label>
                <select wire:model="statusFilter" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition">
                    <option value="">Semua Status</option>
                    <option value="pending">Pending</option>
                    <option value="approved">Terverifikasi</option>
                    <option value="rejected">Ditolak</option>
                </select>
            </div>

            <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100">
                <label class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-2 block">Per Halaman</label>
                <select wire:model="perPage" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition">
                    <option value="10">10 Data</option>
                    <option value="25">25 Data</option>
                    <option value="50">50 Data</option>
                    <option value="100">100 Data</option>
                </select>
            </div>
        </div>

        <!-- Table Card -->
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-200">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-5 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">ID</th>
                            <th class="px-6 py-5 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Mitra</th>
                            <th class="px-6 py-5 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">NIK</th>
                            <th class="px-6 py-5 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Dokumen</th>
                            <th class="px-6 py-5 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-5 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Waktu</th>
                            <th class="px-6 py-5 text-center text-xs font-bold text-gray-700 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($verifications as $v)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-5 whitespace-nowrap text-sm font-medium text-gray-900">
                                #{{ $v->id }}
                            </td>
                            <td class="px-6 py-5">
                                <div class="flex items-center">
                                    <div class="h-12 w-12 flex-shrink-0">
                                        <div class="h-12 w-12 rounded-full bg-gradient-to-br from-primary-500 to-primary-700 flex items-center justify-center text-white font-bold text-lg shadow-md">
                                            {{ strtoupper(substr($v->full_name ?? ($v->name ?? '-'),0,1)) }}
                                        </div>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-semibold text-gray-900">{{ $v->full_name ?? ($v->name ?? '-') }}</div>
                                        <div class="text-sm text-gray-500">{{ $v->email ?? '-' }}</div>
                                        <div class="text-xs text-gray-400 mt-0.5">{{ ucfirst($v->role ?? 'customer') }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-5 whitespace-nowrap">
                                <div class="text-sm font-mono font-semibold text-gray-900">{{ $v->nik ?? '-' }}</div>
                            </td>
                            <td class="px-6 py-5 whitespace-nowrap">
                                <div class="flex items-center gap-2">
                                    @if(!empty($v->selfie_url))
                                        <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-blue-100 text-blue-700">
                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                                            </svg>
                                            Selfie
                                        </span>
                                    @endif
                                    @if(!empty($v->ktp_url))
                                        <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-purple-100 text-purple-700">
                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z"/>
                                            </svg>
                                            KTP
                                        </span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-5 whitespace-nowrap">
                                @if(($v->status ?? '') === 'approved')
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-800">
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                        </svg>
                                        Terverifikasi
                                    </span>
                                @elseif(($v->status ?? '') === 'rejected')
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-red-100 text-red-800">
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                        </svg>
                                        Ditolak
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-yellow-100 text-yellow-800">
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                        </svg>
                                        Pending
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-5 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ optional($v->created_at)->format('d M Y') ?? '-' }}</div>
                                <div class="text-xs text-gray-500">{{ optional($v->created_at)->format('H:i') ?? '-' }}</div>
                            </td>
                            <td class="px-6 py-5 whitespace-nowrap text-center text-sm font-medium">
                                <button type="button" wire:click="viewKtp({{ $v->id }})" class="inline-flex items-center px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white text-sm font-medium rounded-lg shadow-sm transition">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                    Detail
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                <p class="mt-2 text-sm text-gray-500">Tidak ada data verifikasi</p>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                {{ $verifications->links() }}
            </div>
        </div>

        @if($showModal && $selected)
            <div class="fixed inset-0 bg-black bg-opacity-70 flex items-center justify-center z-50 p-4" role="dialog" aria-modal="true" wire:click="closeModal">
                <div class="bg-white rounded-2xl w-full max-w-5xl shadow-2xl max-h-[90vh] overflow-y-auto" wire:click.stop>
                    <!-- Modal Header -->
                    <div class="sticky top-0 bg-gradient-to-r from-emerald-500 to-emerald-600 px-6 py-5 rounded-t-2xl">
                        <div class="flex items-start justify-between">
                            <div class="flex items-center gap-4">
                                <div class="h-14 w-14 rounded-full bg-white/20 backdrop-blur flex items-center justify-center text-white font-bold text-xl shadow-lg">
                                    {{ strtoupper(substr($selected->full_name ?? ($selected->name ?? '-'),0,1)) }}
                                </div>
                                <div>
                                    <h3 class="text-xl font-bold text-white">{{ $selected->full_name ?? ($selected->name ?? '-') }}</h3>
                                    <div class="text-sm text-primary-100 mt-0.5">ID: #{{ $selected->id }} • {{ ucfirst($selected->role ?? 'customer') }}</div>
                                </div>
                            </div>
                            <div class="flex items-center gap-3">
                                @if(($selected->status ?? '') === 'approved')
                                    <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-bold bg-green-100 text-green-800">
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                        </svg>
                                        Terverifikasi
                                    </span>
                                @elseif(($selected->status ?? '') === 'rejected')
                                    <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-bold bg-red-100 text-red-800">
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                        </svg>
                                        Ditolak
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-bold bg-yellow-100 text-yellow-800">
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                        </svg>
                                        Pending
                                    </span>
                                @endif
                                <button type="button" wire:click="closeModal" class="text-white hover:bg-white/20 rounded-lg p-2 transition" aria-label="Tutup">
                                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Body -->
                    <div class="p-6">
                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
                            <!-- Info Pribadi Section -->
                            <div class="lg:col-span-2 space-y-4">
                                <div class="bg-gray-50 rounded-xl p-5 border border-gray-200">
                                    <h4 class="text-sm font-bold text-gray-700 uppercase tracking-wider mb-4 flex items-center">
                                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                                        </svg>
                                        Informasi Pribadi
                                    </h4>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <div class="text-xs text-gray-500 mb-1">NIK</div>
                                            <div class="text-sm font-mono font-semibold text-gray-900">{{ $selected->nik ?? '-' }}</div>
                                        </div>
                                        <div>
                                            <div class="text-xs text-gray-500 mb-1">Nama Lengkap</div>
                                            <div class="text-sm font-semibold text-gray-900">{{ $selected->full_name ?? '-' }}</div>
                                        </div>
                                        <div>
                                            <div class="text-xs text-gray-500 mb-1">Tempat Lahir</div>
                                            <div class="text-sm font-semibold text-gray-900">{{ $selected->place_of_birth ?? '-' }}</div>
                                        </div>
                                        <div>
                                            <div class="text-xs text-gray-500 mb-1">Tanggal Lahir</div>
                                            <div class="text-sm font-semibold text-gray-900">{{ $selected->date_of_birth ? $selected->date_of_birth->format('d M Y') : '-' }}</div>
                                        </div>
                                        <div>
                                            <div class="text-xs text-gray-500 mb-1">Jenis Kelamin</div>
                                            <div class="text-sm font-semibold text-gray-900">{{ $selected->gender ?? '-' }}</div>
                                        </div>
                                        <div>
                                            <div class="text-xs text-gray-500 mb-1">Agama</div>
                                            <div class="text-sm font-semibold text-gray-900">{{ $selected->religion ?? '-' }}</div>
                                        </div>
                                        <div>
                                            <div class="text-xs text-gray-500 mb-1">Status Pernikahan</div>
                                            <div class="text-sm font-semibold text-gray-900">{{ $selected->marital_status ?? '-' }}</div>
                                        </div>
                                        <div>
                                            <div class="text-xs text-gray-500 mb-1">Pekerjaan</div>
                                            <div class="text-sm font-semibold text-gray-900">{{ $selected->occupation ?? '-' }}</div>
                                        </div>
                                    </div>
                                </div>

                                <div class="bg-gray-50 rounded-xl p-5 border border-gray-200">
                                    <h4 class="text-sm font-bold text-gray-700 uppercase tracking-wider mb-4 flex items-center">
                                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                                        </svg>
                                        Alamat Lengkap
                                    </h4>
                                    <div class="grid grid-cols-1 gap-4">
                                        <div>
                                            <div class="text-xs text-gray-500 mb-1">Alamat</div>
                                            <div class="text-sm font-semibold text-gray-900">{{ $selected->address ?? '-' }}</div>
                                        </div>
                                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                            <div>
                                                <div class="text-xs text-gray-500 mb-1">RT</div>
                                                <div class="text-sm font-semibold text-gray-900">{{ $selected->rt ?? '-' }}</div>
                                            </div>
                                            <div>
                                                <div class="text-xs text-gray-500 mb-1">RW</div>
                                                <div class="text-sm font-semibold text-gray-900">{{ $selected->rw ?? '-' }}</div>
                                            </div>
                                            <div>
                                                <div class="text-xs text-gray-500 mb-1">Kelurahan</div>
                                                <div class="text-sm font-semibold text-gray-900">{{ $selected->kelurahan ?? '-' }}</div>
                                            </div>
                                            <div>
                                                <div class="text-xs text-gray-500 mb-1">Kecamatan</div>
                                                <div class="text-sm font-semibold text-gray-900">{{ $selected->kecamatan ?? '-' }}</div>
                                            </div>
                                        </div>
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            <div>
                                                <div class="text-xs text-gray-500 mb-1">Kota/Kabupaten</div>
                                                <div class="text-sm font-semibold text-gray-900">{{ $selected->city ?? '-' }}</div>
                                            </div>
                                            <div>
                                                <div class="text-xs text-gray-500 mb-1">Provinsi</div>
                                                <div class="text-sm font-semibold text-gray-900">{{ $selected->province ?? '-' }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="bg-gray-50 rounded-xl p-5 border border-gray-200">
                                    <h4 class="text-sm font-bold text-gray-700 uppercase tracking-wider mb-4 flex items-center">
                                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"/>
                                            <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"/>
                                        </svg>
                                        Informasi Akun
                                    </h4>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <div class="text-xs text-gray-500 mb-1">Email</div>
                                            <div class="text-sm font-semibold text-gray-900">{{ $selected->email ?? '-' }}</div>
                                        </div>
                                        <div>
                                            <div class="text-xs text-gray-500 mb-1">Role</div>
                                            <div class="text-sm font-semibold text-gray-900">{{ ucfirst($selected->role ?? 'mitra') }}</div>
                                        </div>
                                        <div>
                                            <div class="text-xs text-gray-500 mb-1">UUID</div>
                                            <div class="text-xs font-mono text-gray-700">{{ $selected->uuid ?? '-' }}</div>
                                        </div>
                                        <div>
                                            <div class="text-xs text-gray-500 mb-1">Waktu Registrasi</div>
                                            <div class="text-sm font-semibold text-gray-900">{{ optional($selected->created_at)->format('d M Y, H:i') ?? '-' }} WIB</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Dokumen Section -->
                            <div class="space-y-4">
                                <div class="bg-gray-50 rounded-xl p-5 border border-gray-200">
                                    <h4 class="text-sm font-bold text-gray-700 uppercase tracking-wider mb-4 flex items-center">
                                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"/>
                                        </svg>
                                        Dokumen Verifikasi
                                    </h4>
                                    
                                    <!-- Foto Selfie -->
                                    <div class="mb-4">
                                        <div class="text-xs font-semibold text-gray-600 mb-2">Foto Selfie</div>
                                        @if(!empty($selected->selfie_url))
                                            <a href="{{ $selected->selfie_url }}" target="_blank" rel="noopener noreferrer" class="block rounded-xl overflow-hidden border-2 border-gray-300 hover:border-primary-500 transition shadow-sm hover:shadow-lg group">
                                                <img src="{{ $selected->selfie_url }}" alt="Selfie" class="w-full h-56 object-cover group-hover:scale-105 transition duration-300" />
                                            </a>
                                            <div class="mt-2 flex gap-2">
                                                <a href="{{ $selected->selfie_url }}" target="_blank" class="text-sm font-medium text-emerald-700 hover:text-emerald-900 flex items-center gap-2 px-2 py-1 rounded">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                                                    </svg>
                                                    Buka di tab baru
                                                </a>
                                                <span class="text-gray-300">•</span>
                                                <a href="{{ $selected->selfie_url }}" download class="text-sm font-medium text-gray-700 hover:text-gray-900 flex items-center gap-2 px-2 py-1 rounded">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                                    </svg>
                                                    Unduh
                                                </a>
                                            </div>
                                        @else
                                            <div class="w-full h-56 bg-gray-100 rounded-xl flex flex-col items-center justify-center text-gray-400 border-2 border-dashed border-gray-300">
                                                <svg class="w-12 h-12 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                </svg>
                                                <span class="text-sm">Tidak ada foto selfie</span>
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Foto KTP -->
                                    <div>
                                        <div class="text-xs font-semibold text-gray-600 mb-2">Foto KTP</div>
                                        @if(!empty($selected->ktp_url))
                                            <a href="{{ $selected->ktp_url }}" target="_blank" rel="noopener noreferrer" class="block rounded-xl overflow-hidden border-2 border-gray-300 hover:border-emerald-500 transition shadow-sm hover:shadow-lg group bg-white">
                                                <img src="{{ $selected->ktp_url }}" alt="KTP" class="w-full h-56 object-contain group-hover:scale-105 transition duration-300" />
                                            </a>
                                            <div class="mt-2 flex gap-2">
                                                <a href="{{ $selected->ktp_url }}" target="_blank" class="text-sm font-medium text-emerald-700 hover:text-emerald-900 flex items-center gap-2 px-2 py-1 rounded">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                                                    </svg>
                                                    Buka di tab baru
                                                </a>
                                                <span class="text-gray-300">•</span>
                                                <a href="{{ $selected->ktp_url }}" download class="text-sm font-medium text-gray-700 hover:text-gray-900 flex items-center gap-2 px-2 py-1 rounded">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                                    </svg>
                                                    Unduh
                                                </a>
                                            </div>
                                        @else
                                            <div class="w-full h-56 bg-gray-100 rounded-xl flex flex-col items-center justify-center text-gray-400 border-2 border-dashed border-gray-300">
                                                <svg class="w-12 h-12 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                                </svg>
                                                <span class="text-sm">Tidak ada foto KTP</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="border-t border-gray-200 pt-5">
                            <div class="flex items-center justify-between flex-wrap gap-4">
                                <div class="text-xs text-gray-500">
                                    <span class="font-semibold">Catatan:</span> Pastikan dokumen terlihat jelas dan sesuai dengan data yang tertera.
                                </div>
                                <div class="flex items-center gap-3">
                                    <button type="button" wire:click="closeModal" class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-lg transition">
                                        Tutup
                                    </button>
                                    @if(($selected->status ?? '') !== 'approved')
                                        <button type="button" wire:click="rejectKtp({{ $selected->id }})" class="px-5 py-2.5 bg-red-600 hover:bg-red-700 text-white font-medium rounded-lg shadow-sm transition flex items-center gap-2">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                            </svg>
                                            Tolak Verifikasi
                                        </button>
                                        <button type="button" wire:click="approveKtp({{ $selected->id }})" class="px-5 py-2.5 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg shadow-sm transition flex items-center gap-2">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                            </svg>
                                            Verifikasi Sekarang
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
