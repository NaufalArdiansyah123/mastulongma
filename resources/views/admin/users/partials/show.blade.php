<div class="fixed inset-0 z-50 flex items-center justify-center px-4 py-6 sm:px-6 lg:px-8">
    <div class="fixed inset-0 bg-black bg-opacity-40" id="modal-backdrop"></div>

    <div class="bg-white rounded-2xl shadow-xl max-w-3xl w-full z-10 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
            <h3 class="text-lg font-semibold text-gray-900">Detail Pengguna</h3>
            <button type="button" id="modal-close-btn" class="text-gray-400 hover:text-gray-600">✕</button>
        </div>

        <div class="p-6">
            <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <dt class="text-xs text-gray-500">Nama</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $user->name }}</dd>
                </div>
                <div>
                    <dt class="text-xs text-gray-500">Email</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $user->email }}</dd>
                </div>
                <div>
                    <dt class="text-xs text-gray-500">Role</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ ucfirst($user->role) }}</dd>
                </div>
                <div>
                    <dt class="text-xs text-gray-500">Kota</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $user->city_name ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="text-xs text-gray-500">Terdaftar</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ optional($user->created_at)->format('Y-m-d H:i') }}</dd>
                </div>
                <div>
                    <dt class="text-xs text-gray-500">Status Akun</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $user->status }}</dd>
                </div>
            </dl>

            <div class="mt-6">
                <h4 class="text-sm font-semibold text-gray-700">Informasi KTP (dari users)</h4>
                <div class="mt-2 text-sm text-gray-600">
                    NIK: {{ $user->nik ?? '-' }}<br>
                    KTP Path: {{ $user->ktp_path ?? $user->ktp_photo ?? '-' }}
                </div>
            </div>
        </div>

        <div class="px-6 py-4 border-t border-gray-100 text-right">
            <button type="button" id="modal-close-btn-2"
                class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 rounded-xl">Tutup</button>
        </div>
    </div>
</div>