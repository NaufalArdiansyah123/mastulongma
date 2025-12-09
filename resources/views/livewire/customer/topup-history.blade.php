<div class="min-h-screen bg-gradient-to-b from-gray-50 to-white pb-24">
    <!-- Header -->
    <div class="bg-gradient-to-br from-primary-500 to-primary-600 px-5 pt-6 pb-8 rounded-b-3xl shadow-lg">
        <div class="flex items-center gap-3 mb-2">
            <a href="{{ route('customer.dashboard') }}" class="text-white">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            <h1 class="text-xl font-bold text-white">Riwayat Top-Up</h1>
        </div>
        <p class="text-sm text-white/90 pl-9">Lihat semua request top-up Anda</p>
    </div>

    <!-- Content -->
    <div class="px-5 py-6">
        @if (session()->has('success'))
            <div class="mb-4 p-4 bg-green-50 border border-green-200 rounded-xl text-green-700 flex items-start gap-2">
                <svg class="w-5 h-5 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"/>
                </svg>
                <div>{{ session('success') }}</div>
            </div>
        @endif

        <!-- Filter Tabs -->
        <div class="mb-6 bg-white rounded-xl shadow-sm p-1 inline-flex gap-1">
            <button wire:click="filterByStatus('all')"
                class="px-4 py-2 rounded-lg text-sm font-semibold transition {{ $filterStatus === 'all' ? 'bg-primary-600 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                Semua
            </button>
            <button wire:click="filterByStatus('waiting_approval')"
                class="px-4 py-2 rounded-lg text-sm font-semibold transition {{ $filterStatus === 'waiting_approval' ? 'bg-yellow-500 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                Menunggu
            </button>
            <button wire:click="filterByStatus('approved')"
                class="px-4 py-2 rounded-lg text-sm font-semibold transition {{ $filterStatus === 'approved' ? 'bg-green-500 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                Disetujui
            </button>
            <button wire:click="filterByStatus('rejected')"
                class="px-4 py-2 rounded-lg text-sm font-semibold transition {{ $filterStatus === 'rejected' ? 'bg-red-500 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                Ditolak
            </button>
        </div>

        <!-- Transaction List -->
        <div class="space-y-4">
            @forelse($transactions as $transaction)
                <div class="bg-white rounded-xl shadow-sm p-5 border border-gray-100">
                    <div class="flex items-start justify-between mb-3">
                        <div class="flex-1">
                            <div class="flex items-center gap-2 mb-1">
                                <h3 class="font-bold text-gray-900">{{ $transaction->request_code ?? '#'.$transaction->id }}</h3>
                                @if($transaction->status === 'waiting_approval')
                                    <span class="px-2 py-1 bg-yellow-100 text-yellow-700 text-xs font-semibold rounded-full">
                                        ⏳ Menunggu Verifikasi
                                    </span>
                                @elseif($transaction->status === 'approved' || $transaction->status === 'completed')
                                    <span class="px-2 py-1 bg-green-100 text-green-700 text-xs font-semibold rounded-full">
                                        ✅ Disetujui
                                    </span>
                                @elseif($transaction->status === 'rejected')
                                    <span class="px-2 py-1 bg-red-100 text-red-700 text-xs font-semibold rounded-full">
                                        ❌ Ditolak
                                    </span>
                                @else
                                    <span class="px-2 py-1 bg-gray-100 text-gray-700 text-xs font-semibold rounded-full">
                                        {{ ucfirst($transaction->status) }}
                                    </span>
                                @endif
                            </div>
                            <p class="text-xs text-gray-500">{{ $transaction->created_at->format('d M Y, H:i') }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-lg font-bold text-gray-900">Rp {{ number_format($transaction->amount, 0, ',', '.') }}</p>
                            <p class="text-xs text-gray-500">+ Rp {{ number_format($transaction->admin_fee, 0, ',', '.') }} admin</p>
                        </div>
                    </div>

                    <div class="flex items-center justify-between pt-3 border-t border-gray-100">
                        <div class="text-sm text-gray-600">
                            <span class="font-medium">Total:</span> Rp {{ number_format($transaction->total_payment, 0, ',', '.') }}
                        </div>
                        <button wire:click="viewDetail({{ $transaction->id }})"
                            class="text-sm font-semibold text-primary-600 hover:text-primary-700">
                            Lihat Detail →
                        </button>
                    </div>

                    @if($transaction->status === 'rejected' && $transaction->rejection_reason)
                        <div class="mt-3 p-3 bg-red-50 border border-red-100 rounded-lg">
                            <p class="text-xs font-semibold text-red-800 mb-1">Alasan Penolakan:</p>
                            <p class="text-xs text-red-700">{{ $transaction->rejection_reason }}</p>
                        </div>
                    @endif
                </div>
            @empty
                <div class="bg-white rounded-xl shadow-sm p-12 text-center">
                    <svg class="w-20 h-20 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <p class="text-gray-600 font-medium mb-2">Belum ada riwayat top-up</p>
                    <p class="text-sm text-gray-500 mb-4">Mulai top-up saldo Anda sekarang</p>
                    <a href="{{ route('customer.topup.request') }}"
                        class="inline-block px-6 py-3 bg-primary-600 text-white rounded-xl font-semibold hover:bg-primary-700">
                        Top-Up Saldo
                    </a>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($transactions->hasPages())
            <div class="mt-6">
                {{ $transactions->links() }}
            </div>
        @endif
    </div>

    <!-- Detail Modal -->
    @if($showDetailModal && $selectedTransaction)
        <div class="fixed inset-0 bg-black/50 z-50 flex items-end sm:items-center justify-center p-4" wire:click="closeModal">
            <div class="bg-white rounded-t-3xl sm:rounded-3xl w-full max-w-2xl max-h-[90vh] overflow-y-auto" wire:click.stop>
                <!-- Modal Header -->
                <div class="sticky top-0 bg-white border-b border-gray-200 px-6 py-4 rounded-t-3xl">
                    <div class="flex items-center justify-between">
                        <h2 class="text-lg font-bold text-gray-900">Detail Request Top-Up</h2>
                        <button wire:click="closeModal" class="text-gray-400 hover:text-gray-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Modal Content -->
                <div class="p-6 space-y-4">
                    <!-- Status -->
                    <div class="text-center py-4">
                        @if($selectedTransaction->status === 'waiting_approval')
                            <div class="w-20 h-20 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-3">
                                <span class="text-4xl">⏳</span>
                            </div>
                            <p class="text-lg font-bold text-yellow-700">Menunggu Verifikasi</p>
                        @elseif($selectedTransaction->status === 'approved' || $selectedTransaction->status === 'completed')
                            <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-3">
                                <span class="text-4xl">✅</span>
                            </div>
                            <p class="text-lg font-bold text-green-700">Request Disetujui</p>
                        @elseif($selectedTransaction->status === 'rejected')
                            <div class="w-20 h-20 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-3">
                                <span class="text-4xl">❌</span>
                            </div>
                            <p class="text-lg font-bold text-red-700">Request Ditolak</p>
                        @endif
                    </div>

                    <!-- Info -->
                    <div class="bg-gray-50 rounded-xl p-4 space-y-3">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Kode Request:</span>
                            <span class="font-semibold text-gray-900">{{ $selectedTransaction->request_code ?? '#'.$selectedTransaction->id }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Tanggal Request:</span>
                            <span class="font-medium text-gray-900">{{ $selectedTransaction->created_at->format('d M Y, H:i') }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Nominal Top-Up:</span>
                            <span class="font-semibold text-gray-900">Rp {{ number_format($selectedTransaction->amount, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Biaya Admin:</span>
                            <span class="font-medium text-gray-900">Rp {{ number_format($selectedTransaction->admin_fee, 0, ',', '.') }}</span>
                        </div>
                        <div class="border-t border-gray-200 pt-3 flex justify-between">
                            <span class="font-bold text-gray-900">Total Pembayaran:</span>
                            <span class="font-bold text-primary-600 text-lg">Rp {{ number_format($selectedTransaction->total_payment, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <!-- Payment Method -->
                    <div>
                        <label class="text-sm font-semibold text-gray-700 mb-2 block">Metode Pembayaran:</label>
                        <p class="text-sm text-gray-900">{{ ucwords(str_replace(['_', 'bank'], [' ', 'Transfer Bank '], $selectedTransaction->payment_method ?? '-')) }}</p>
                    </div>

                    <!-- Bukti Transfer -->
                    @if($selectedTransaction->proof_of_payment)
                        <div>
                            <label class="text-sm font-semibold text-gray-700 mb-2 block">Bukti Transfer:</label>
                            <img src="{{ asset('storage/' . $selectedTransaction->proof_of_payment) }}" 
                                class="w-full rounded-xl shadow-lg border border-gray-200"
                                alt="Bukti Transfer">
                        </div>
                    @endif

                    <!-- Rejection Reason -->
                    @if($selectedTransaction->status === 'rejected' && $selectedTransaction->rejection_reason)
                        <div class="bg-red-50 border border-red-200 rounded-xl p-4">
                            <label class="text-sm font-semibold text-red-800 mb-2 block">Alasan Penolakan:</label>
                            <p class="text-sm text-red-700">{{ $selectedTransaction->rejection_reason }}</p>
                        </div>
                    @endif

                    <!-- Approval Info -->
                    @if($selectedTransaction->approved_by && $selectedTransaction->approvedBy)
                        <div class="bg-green-50 border border-green-200 rounded-xl p-4">
                            <label class="text-sm font-semibold text-green-800 mb-2 block">Disetujui Oleh:</label>
                            <p class="text-sm text-green-700">{{ $selectedTransaction->approvedBy->name }}</p>
                            <p class="text-xs text-green-600 mt-1">{{ $selectedTransaction->approved_at?->format('d M Y, H:i') }}</p>
                        </div>
                    @endif
                </div>

                <!-- Modal Footer -->
                <div class="sticky bottom-0 bg-white border-t border-gray-200 px-6 py-4">
                    <button wire:click="closeModal"
                        class="w-full px-6 py-3 bg-gray-100 text-gray-700 rounded-xl font-semibold hover:bg-gray-200">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
