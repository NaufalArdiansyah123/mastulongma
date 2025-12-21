@extends('layouts.admin')

@section('page-title', 'Manajemen Bantuan - Disetujui')

@section('content')
    <div class="bg-white shadow rounded-lg p-6">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h3 class="text-lg font-bold">Bantuan — Disetujui</h3>
                <p class="text-sm text-gray-500">Menampilkan bantuan dengan status disetujui (hanya lihat untuk Admin).</p>
            </div>
            <div class="flex items-center gap-2">
                <input wire:model.debounce.500ms="search" type="text" placeholder="Cari judul atau deskripsi"
                    class="px-3 py-2 border rounded" />
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full table-auto">
                <thead>
                    <tr class="text-left text-sm text-gray-600">
                        <th class="px-3 py-2">#</th>
                        <th class="px-3 py-2">Judul</th>
                        <th class="px-3 py-2">Customer</th>
                        <th class="px-3 py-2">Kota</th>
                        <th class="px-3 py-2">Kategori</th>
                        <th class="px-3 py-2">Jumlah</th>
                        <th class="px-3 py-2">Tanggal</th>
                        <th class="px-3 py-2">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($helps as $help)
                        <tr class="border-t">
                            <td class="px-3 py-2">{{ $help->id }}</td>
                            <td class="px-3 py-2">{{ $help->title }}</td>
                            <td class="px-3 py-2">{{ $help->customer->name ?? '-' }}</td>
                            <td class="px-3 py-2">{{ $help->city->name ?? '-' }}</td>
                            <td class="px-3 py-2">{{ $help->category->name ?? '-' }}</td>
                            <td class="px-3 py-2">Rp {{ number_format($help->amount ?? 0,0,',','.') }}</td>
                            <td class="px-3 py-2">{{ $help->created_at?->format('Y-m-d') }}</td>
                            <td class="px-3 py-2">
                                <a href="{{ route('admin.helps') }}" class="px-3 py-1 bg-gray-100 text-gray-700 rounded text-xs">Detail</a>
                                <!-- Admin hanya bisa melihat, tidak ada tombol approve/reject -->
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-3 py-6 text-center text-gray-500">Tidak ada bantuan disetujui.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">{{ $helps->links() }}</div>
    </div>
@endsection
