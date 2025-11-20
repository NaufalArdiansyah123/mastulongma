<div class="max-w-md mx-auto min-h-screen bg-gray-50">
    <!-- Header -->
    <div class="bg-gradient-to-br from-primary-400 via-primary-500 to-primary-600 px-6 pt-6 pb-4 rounded-b-3xl">
        <div class="flex items-center justify-between mb-4">
            <a href="{{ route('customer.dashboard') }}" class="text-white">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
            <h1 class="text-xl font-bold text-white">Riwayat Transaksi</h1>
            <div class="w-6"></div>
        </div>
        <p class="text-sm text-white opacity-90">Catatan mutasi saldo dan aktivitas top-up / penarikan.</p>
    </div>

    <!-- Content -->
    <div class="px-4 pt-6 pb-24 min-h-[60vh]">
        <div class="space-y-3">
            @if($transactions->count())
                @foreach($transactions as $t)
                    <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100 hover:shadow-md transition">
                        <div class="flex items-start justify-between gap-3">
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center justify-between mb-1">
                                    <h3 class="font-semibold text-gray-900 text-sm">
                                        @if(($t->type ?? '') === 'topup')
                                            Tambah Saldo
                                        @else
                                            Pengurangan Saldo
                                        @endif
                                    </h3>
                                    <span class="text-xs text-gray-500">{{ $t->created_at->diffForHumans() }}</span>
                                </div>
                                {{-- Details: payment/order for topup, reference help for deduction --}}
                                @if(($t->type ?? '') === 'topup')
                                    <div class="text-xs text-gray-500">
                                        {{ $t->payment_type ? 'Topup via ' . ucfirst($t->payment_type) : ($t->description ?? 'Topup Saldo') }}
                                        @if(!empty($t->order_id))
                                            <div class="text-xs text-gray-400">Order: {{ $t->order_id }}</div>
                                        @endif
                                    </div>
                                @else
                                    <div class="text-xs text-gray-500">
                                        @if(!empty($t->reference_id))
                                            @if(Route::has('customer.helps.show'))
                                                <a href="{{ route('customer.helps.show', $t->reference_id) }}"
                                                    class="text-primary-600 underline">Untuk Bantuan #{{ $t->reference_id }}</a>
                                            @else
                                                Untuk Bantuan #{{ $t->reference_id }}
                                            @endif
                                        @else
                                            {{ $t->description ?? 'Pengurangan' }}
                                        @endif
                                    </div>
                                @endif
                                <div class="text-xs text-gray-500">{{ $t->created_at->format('d M Y H:i') }}</div>
                            </div>
                            <div class="flex-shrink-0 text-right">
                                <div
                                    class="text-sm font-bold {{ ($t->type ?? '') === 'topup' ? 'text-green-600' : 'text-red-500' }}">
                                    Rp
                                    {{ number_format(abs($t->amount), 0, ',', '.') }}
                                </div>
                               
                            </div>
                        </div>
                    </div>
                @endforeach

                <div class="mt-4">
                    {{ $transactions->links('pagination::tailwind') }}
                </div>
            @else
                <div class="text-center py-12">
                    <div class="bg-gray-100 rounded-full w-16 h-16 flex items-center justify-center mb-4">
                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8c-3.314 0-6 2.686-6 6v2h12v-2c0-3.314-2.686-6-6-6zM12 8a4 4 0 100-8 4 4 0 000 8z" />
                        </svg>
                    </div>
                    <p class="text-gray-500">Belum ada transaksi.</p>
                </div>
            @endif
        </div>
    </div>
</div>