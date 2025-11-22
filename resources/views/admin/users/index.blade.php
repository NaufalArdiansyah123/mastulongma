@extends('layouts.admin')

@section('content')
    <div class="bg-white shadow-sm border-b border-gray-200">
        <div class="px-8 py-6">
            <h1 class="text-3xl font-bold text-gray-900">Kelola Pengguna</h1>
            <p class="text-sm text-gray-600 mt-1">Daftar pengguna di kota Anda, beserta status KTP dan status akun.</p>
        </div>
    </div>

    <div class="p-8">
        <!-- Filter Bar -->
        <div class="mb-6">
            <form method="GET" action="{{ route('admin.users.index') }}"
                class="bg-white rounded-2xl shadow-md border border-gray-200 p-4">
                <div class="flex items-center justify-between mb-3">
                    <p class="text-xs font-semibold text-gray-700">Filter Pengguna</p>
                    @if (request()->hasAny(['search', 'role', 'account_status', 'ktp_status']))
                        <a href="{{ route('admin.users.index') }}"
                            class="text-[11px] text-gray-400 hover:text-gray-600 underline">Reset filter</a>
                    @endif
                </div>

                <div class="space-y-3">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Cari Pengguna</label>
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Nama atau email pengguna"
                            class="w-full px-3 py-2 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-4 gap-3 items-end">
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Role</label>
                            <select name="role"
                                class="w-full px-3 py-2 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                                <option value="all" {{ request('role') === 'all' ? 'selected' : '' }}>Semua Role</option>
                                <option value="mitra" {{ request('role') === 'mitra' ? 'selected' : '' }}>Mitra</option>
                                <option value="kustomer" {{ request('role') === 'kustomer' ? 'selected' : '' }}>Kustomer</option>
                                <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Status Akun</label>
                            <select name="account_status"
                                class="w-full px-3 py-2 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                                <option value="" {{ request('account_status') === null ? 'selected' : '' }}>Semua</option>
                                <option value="active" {{ request('account_status') === 'active' ? 'selected' : '' }}>Aktif
                                </option>
                                <option value="inactive"
                                    {{ request('account_status') === 'inactive' ? 'selected' : '' }}>Nonaktif</option>
                                <option value="blocked" {{ request('account_status') === 'blocked' ? 'selected' : '' }}>Diblokir
                                </option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Status KTP</label>
                            <select name="ktp_status"
                                class="w-full px-3 py-2 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                                <option value="" {{ request('ktp_status') === null ? 'selected' : '' }}>Semua</option>
                                <option value="uploaded" {{ request('ktp_status') === 'uploaded' ? 'selected' : '' }}>Sudah
                                    Upload</option>
                                <option value="missing" {{ request('ktp_status') === 'missing' ? 'selected' : '' }}>Belum
                                    Upload</option>
                            </select>
                        </div>

                        <div class="flex justify-start md:justify-end">
                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 bg-primary-600 text-white text-xs font-semibold rounded-xl shadow-sm hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                                Terapkan Filter
                            </button>
                        </div>
                    </div>
                </div>

                <div class="mt-3 flex items-center justify-between">
                    <p class="text-[11px] text-gray-400">Kombinasikan pencarian, role, status akun, dan status KTP untuk
                        menemukan pengguna secara cepat.</p>
                </div>
            </form>
        </div>

        <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                <div>
                    <h2 class="text-lg font-semibold text-gray-900">Daftar Pengguna</h2>
                    <p class="text-xs text-gray-500 mt-1">Pantau dan kelola akun pengguna yang terdaftar di platform.</p>
                </div>
                @if ($users->total() > 0)
                    <p class="text-[11px] text-gray-500">Total {{ $users->total() }} pengguna.</p>
                @endif
            </div>

            @if ($users->isEmpty())
                <div class="px-6 py-12 flex flex-col items-center justify-center text-center">
                    <svg class="w-16 h-16 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 20h5v-2a4 4 0 00-5-4M9 20H4v-2a4 4 0 015-4m4-6a4 4 0 11-8 0 4 4 0 018 0zm6 0a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    <p class="text-gray-500 text-sm font-medium">Belum ada pengguna di kota Anda.</p>
                    <p class="text-gray-400 text-xs mt-1">Pengguna baru akan muncul di sini setelah mereka mendaftar.</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    Nama
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    Email
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    Role
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    Kota
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    Status KTP
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    Status Akun
                                </th>
                                <th class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    Bantuan
                                </th>
                                <th class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    Rating
                                </th>
                                <th class="px-6 py-3 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    Pelanggaran
                                </th>
                                <th class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @foreach ($users as $user)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-3 text-sm text-gray-900 whitespace-nowrap">
                                        {{ $user->name }}
                                    </td>
                                    <td class="px-6 py-3 text-sm text-gray-500 whitespace-nowrap">
                                        {{ $user->email }}
                                    </td>
                                    <td class="px-6 py-3 text-sm text-gray-500 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-700">
                                            {{ ucfirst($user->role) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-3 text-sm text-gray-500 whitespace-nowrap">
                                        {{ optional($user->city)->name ?? '-' }}
                                    </td>
                                    <td class="px-6 py-3 text-sm">
                                        @if (!$user->ktp_path)
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-500">
                                                Belum Upload
                                            </span>
                                        @elseif($user->ktp_path && !$user->verified)
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-800">
                                                Pending
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">
                                                Terverifikasi
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-3 text-sm">
                                        @if ($user->status === 'blocked')
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-800">
                                                Diblokir
                                            </span>
                                        @elseif ($user->status === 'inactive')
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-800">
                                                Nonaktif
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">
                                                Aktif
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-3 text-sm text-right whitespace-nowrap">
                                        {{ number_format($user->helps_count ?? 0) }}
                                    </td>
                                    <td class="px-6 py-3 text-sm text-right whitespace-nowrap">
                                        @if ($user->role === 'mitra' && !is_null($user->average_rating))
                                            <span class="inline-flex items-center justify-end space-x-1">
                                                <svg class="w-4 h-4 text-amber-400" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                </svg>
                                                <span>{{ number_format($user->average_rating, 1) }}</span>
                                            </span>
                                        @else
                                            <span class="text-xs text-gray-400">-</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-3 text-sm text-center whitespace-nowrap">
                                        @if (($user->partner_reports_count ?? 0) > 0)
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-[11px] font-semibold bg-red-100 text-red-700">
                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M4.293 17.293L11 4.586a1 1 0 011.789 0l6.707 12.707A1 1 0 0118.707 19H5.293a1 1 0 01-.9-1.707z" />
                                                </svg>
                                                {{ $user->partner_reports_count }} laporan
                                            </span>
                                        @else
                                            <span class="text-xs text-gray-400">-</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-3 text-sm text-right space-x-2 whitespace-nowrap">
                                        <a href="{{ route('admin.users.show', $user) }}"
                                            class="inline-flex items-center px-3 py-1 border border-gray-300 rounded-full text-xs text-gray-700 hover:bg-gray-50">
                                            Detail
                                        </a>

                                        <form action="{{ route('admin.partners.toggle', $user->id) }}" method="POST" class="inline">
                                            @csrf
                                            <button
                                                class="px-3 py-1 rounded-full text-xs {{ $user->is_blocked ? 'bg-green-600 text-white hover:bg-green-700' : 'bg-red-600 text-white hover:bg-red-700' }}">
                                                {{ $user->is_blocked ? 'Buka Blokir' : 'Blokir' }}
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if ($users->hasPages())
                    <div class="bg-gray-50 px-6 py-4 border-t border-gray-100 flex justify-center">
                        {{ $users->links() }}
                    </div>
                @endif
            @endif
        </div>
    </div>
@endsection
