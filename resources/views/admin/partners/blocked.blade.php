@extends('layouts.admin')

@section('content')
    <div class="bg-white shadow-sm border-b border-gray-200">
        <div class="px-8 py-6">
            <h1 class="text-3xl font-bold text-gray-900">Mitra Diblokir</h1>
            <p class="text-sm text-gray-600 mt-1">Daftar mitra yang saat ini diblokir dari platform, dan dapat dibuka
                blokirnya.</p>
        </div>
    </div>

    <div class="p-8">
        <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                <div>
                    <h2 class="text-lg font-semibold text-gray-900">Daftar Mitra Diblokir</h2>
                    <p class="text-xs text-gray-500 mt-1">Kelola dan buka blokir mitra yang sebelumnya dinonaktifkan.
                    </p>
                </div>
                @if ($blocked->count() > 0)
                    <p class="text-[11px] text-gray-500">Total {{ $blocked->count() }} mitra diblokir.</p>
                @endif
            </div>

            @if ($blocked->isEmpty())
                <div class="px-6 py-12 flex flex-col items-center justify-center text-center">
                    <svg class="w-16 h-16 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 9V5a4 4 0 118 0v4m-1 4H9m10 0a2 2 0 01-2 2H9a2 2 0 01-2-2m12 0V9a2 2 0 00-2-2h-1M7 13v-2a2 2 0 012-2h1" />
                    </svg>
                    <p class="text-gray-500 text-sm font-medium">Belum ada mitra yang diblokir.</p>
                    <p class="text-gray-400 text-xs mt-1">Mitra yang diblokir akan muncul di sini dan dapat dibuka blokirnya
                        kapan saja.</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    Nama</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    Email</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    Kota</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    Status Akun</th>
                                <th class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @foreach ($blocked as $user)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-3 text-sm text-gray-900 whitespace-nowrap">
                                        <a href="{{ route('admin.users.show', $user) }}"
                                            class="text-primary-600 hover:text-primary-700 hover:underline">
                                            {{ $user->name }}
                                        </a>
                                    </td>
                                    <td class="px-6 py-3 text-sm text-gray-500 whitespace-nowrap">{{ $user->email }}</td>
                                    <td class="px-6 py-3 text-sm text-gray-500 whitespace-nowrap">
                                        {{ optional($user->city)->name ?? '-' }}
                                    </td>
                                    <td class="px-6 py-3 text-sm">
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-800">
                                            Diblokir
                                        </span>
                                    </td>
                                    <td class="px-6 py-3 text-sm text-right whitespace-nowrap space-x-2">
                                        <a href="{{ route('admin.partners.activity', ['search' => $user->email]) }}"
                                            class="inline-flex items-center px-3 py-1 border border-gray-300 rounded-full text-xs text-gray-700 hover:bg-gray-50">
                                            Lihat Aktivitas
                                        </a>

                                        <form method="POST" action="{{ route('admin.partners.toggle', $user->id) }}"
                                            class="inline">
                                            @csrf
                                            <button
                                                class="px-3 py-1 rounded-full text-xs bg-green-600 text-white hover:bg-green-700">
                                                Buka Blokir
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
@endsection
