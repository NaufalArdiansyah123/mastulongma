<div class="w-full p-6">
    <div class="bg-white rounded-xl shadow-sm border border-gray-100">
        <!-- Filter Section -->
        <div class="p-6 border-b border-gray-100">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Daftar Transaksi</h2>
            <div class="flex flex-wrap items-center gap-3">
                <div class="flex-1 min-w-[280px]">
                    <input wire:model.live.debounce.400ms="search" type="text" placeholder="Cari user, email atau ref"
                        class="border border-gray-300 rounded-lg px-4 py-2.5 w-full focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all" />
                </div>

                <select wire:model.live="type" class="border border-gray-300 rounded-lg px-4 py-2.5 bg-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                    <option value="all">Semua Tipe</option>
                    <option value="topup">Topup</option>
                    <option value="withdraw">Withdraw</option>
                    <option value="other">Lainnya</option>
                </select>

                <input wire:model.live="from" type="date" class="border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all" />
                <input wire:model.live="to" type="date" class="border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all" />

                <select wire:model.live="perPage" class="border border-gray-300 rounded-lg px-4 py-2.5 bg-white ml-auto focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                    <option value="10">10 / halaman</option>
                    <option value="15">15 / halaman</option>
                    <option value="30">30 / halaman</option>
                    <option value="50">50 / halaman</option>
                </select>
            </div>
        </div>

        <!-- Table Section -->
        <div class="overflow-x-auto">
            <table class="min-w-full w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3.5 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Waktu</th>
                        <th class="px-6 py-3.5 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">User</th>
                        <th class="px-6 py-3.5 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Tipe</th>
                        <th class="px-6 py-3.5 text-right text-xs font-semibold text-gray-700 uppercase tracking-wider">Jumlah</th>
                        <th class="px-6 py-3.5 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Ref</th>
                        <th class="px-6 py-3.5 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Status</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @forelse($transactions as $t)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 text-sm text-gray-600 whitespace-nowrap">{{ $t->created_at }}</td>
                            <td class="px-6 py-4 text-sm">
                                @if($t->user)
                                    <div class="font-medium text-gray-900">{{ $t->user->name }}</div>
                                    <div class="text-xs text-gray-500 mt-0.5">{{ $t->user->email }}</div>
                                @else
                                    <div class="text-sm text-gray-400">-</div>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-xs font-medium bg-blue-50 text-blue-700">
                                    {{ ucfirst($t->type) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-right font-medium text-gray-900 whitespace-nowrap">
                                Rp {{ number_format($t->amount, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">
                                <code class="text-xs bg-gray-100 px-2 py-1 rounded">{{ $t->reference ?? '-' }}</code>
                            </td>
                            <td class="px-6 py-4 text-sm">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-50 text-green-700 border border-green-200">
                                    {{ $t->status ?? 'ok' }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <svg class="w-12 h-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    <p class="text-sm text-gray-500 font-medium">Tidak ada transaksi</p>
                                    <p class="text-xs text-gray-400 mt-1">Data transaksi akan muncul di sini</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination Section -->
        <div class="px-6 py-4 border-t border-gray-100 bg-gray-50">
            {{ $transactions->links() }}
        </div>
    </div>
</div>