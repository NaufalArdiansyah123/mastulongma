<div id="superadmin-withdraw-modal" class="fixed inset-0 z-50 flex items-center justify-center p-6">
    <div id="superadmin-withdraw-modal-overlay" class="absolute inset-0 bg-black bg-opacity-50"></div>

    <div class="relative w-full max-w-4xl mx-auto bg-white rounded-lg shadow-2xl z-10 max-h-[90vh] overflow-auto">
        <div class="flex items-center justify-between border-b border-gray-100 px-6 py-4">
            <div>
                <h3 class="text-lg font-semibold">Proses Withdraw #{{ $withdraw->id }}</h3>
                <p class="text-sm text-gray-500">Permintaan dari mitra berikut informasinya.</p>
            </div>
            <div>
                <button id="close-superadmin-withdraw-modal"
                    class="inline-flex items-center justify-center w-8 h-8 rounded-md hover:bg-gray-100 text-gray-600">
                    &times;
                </button>
            </div>
        </div>

        <div class="p-6 space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="{{ $withdraw->status === 'pending' ? 'md:col-span-2' : 'md:col-span-3' }} space-y-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <h4 class="text-sm text-gray-500">Mitra</h4>
                            <div class="font-semibold">{{ $withdraw->user?->name ?? '-' }} <span
                                    class="text-xs text-gray-400">(ID: {{ $withdraw->user_id }})</span></div>
                        </div>
                        <div class="text-right">
                            @if($withdraw->status === 'pending')
                                <div class="inline-flex items-center px-3 py-1 rounded bg-yellow-100 text-yellow-800">Pending</div>
                            @elseif($withdraw->status === 'processing')
                                <div class="inline-flex items-center px-3 py-1 rounded bg-blue-100 text-blue-800">Processing</div>
                            @elseif($withdraw->status === 'success')
                                <div class="inline-flex items-center px-3 py-1 rounded bg-green-100 text-green-800">Success</div>
                            @else
                                <div class="inline-flex items-center px-3 py-1 rounded bg-red-100 text-red-800">Failed</div>
                            @endif
                        </div>
                    </div>

                    <div class="bg-gray-50 p-4 rounded">
                        <div class="flex items-center justify-between">
                            <div>
                                <div class="text-sm text-gray-500">Jumlah</div>
                                <div class="text-2xl font-bold text-gray-900">Rp
                                    {{ number_format($withdraw->amount, 0, ',', '.') }}
                                </div>
                            </div>
                            <div class="text-sm text-gray-500 text-right">
                                <div>Bank / Rekening</div>
                                <div class="font-medium">{{ $withdraw->bank_code }} / {{ $withdraw->account_number }}
                                </div>
                            </div>
                        </div>
                        <div class="text-sm text-gray-500 mt-4">Keterangan</div>
                        <div class="mt-1">{{ $withdraw->description ?? '-' }}</div>
                    </div>

                    @if($withdraw->status === 'pending')
                        <form action="{{ route('superadmin.withdraws.approve', $withdraw) }}" method="POST"
                            class="bg-white p-4 border border-gray-100 rounded">
                            @csrf
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm text-gray-700">Catatan (opsional)</label>
                                    <input type="text" name="note" class="mt-1 block w-full rounded border-gray-300" />
                                </div>
                                <div>
                                    <label class="block text-sm text-gray-700">Referensi Transfer (opsional)</label>
                                    <input type="text" name="transfer_reference"
                                        class="mt-1 block w-full rounded border-gray-300" />
                                </div>
                            </div>
                            <div class="mt-4 flex items-center justify-end">
                                <button type="submit" class="px-5 py-2 bg-green-600 text-white rounded-lg shadow">Approve
                                    &amp; Potong Saldo</button>
                            </div>
                        </form>
                    @else
                        <div class="text-sm text-gray-500">Status: <strong>{{ ucfirst($withdraw->status) }}</strong></div>
                        <div class="mt-2">Diproses pada:
                            {{ $withdraw->processed_at ? $withdraw->processed_at->format('Y-m-d H:i') : '-' }}
                        </div>
                        <div class="mt-2">Referensi: {{ $withdraw->external_id ?? '-' }}</div>
                    @endif
                </div>

                @if($withdraw->status === 'pending')
                    <div class="md:col-span-1">
                        <div class="bg-white p-4 border rounded mb-4">
                            <div class="text-sm text-gray-500">Aksi</div>
                            <div class="mt-3">
                                <p class="text-sm text-gray-700">Jika ingin menolak permintaan ini, klik tombol di bawah.
                                </p>
                                <button id="open-reject-local"
                                    class="mt-3 w-full px-4 py-2 bg-red-600 text-white rounded">Tolak</button>
                            </div>
                        </div>

                        <div id="reject-form-local" class="hidden bg-gray-50 p-4 border rounded">
                            <form action="{{ route('superadmin.withdraws.reject', $withdraw) }}" method="POST">
                                @csrf
                                <label class="block text-sm text-gray-700">Catatan Penolakan (opsional)</label>
                                <input type="text" name="note" class="mt-2 block w-full rounded border-gray-300" />
                                <div class="mt-4 flex items-center justify-between">
                                    <button type="button" id="reject-cancel-local"
                                        class="px-3 py-2 bg-gray-100 rounded">Batal</button>
                                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded">Konfirmasi
                                        Tolak</button>
                                </div>
                            </form>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Note: modal behavior is initialized by the parent page JS after insertion -->
</div>
