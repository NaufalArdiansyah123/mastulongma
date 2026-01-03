@extends('layouts.superadmin')

@section('content')

    <div class="p-8 space-y-6">
        @if(session('status'))
            <div class="mb-4 p-3 bg-green-50 border border-green-200 text-green-700 rounded">{{ session('status') }}</div>
        @endif

        <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                <div>
                    <h2 class="text-lg font-semibold text-gray-900">Daftar Withdraw</h2>
                    <p class="text-xs text-gray-500 mt-1">Menampilkan permintaan tarik saldo terbaru dari mitra.</p>
                </div>
            </div>

            <!-- Summary + Filters -->
            <div class="px-6 py-4 border-b border-gray-100">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="col-span-2 flex gap-4 items-center">
                        <div class="bg-white p-4 rounded-lg shadow-sm border w-full">
                            <div class="text-sm text-gray-500">Total Request</div>
                            <div class="text-2xl font-bold mt-1">{{ $counts['all'] ?? 0 }}</div>
                        </div>
                        <div class="bg-white p-4 rounded-lg shadow-sm border w-1/3">
                            <div class="text-sm text-gray-500">Pending</div>
                            <div class="text-xl font-semibold text-yellow-800 mt-1">{{ $counts['pending'] ?? 0 }}</div>
                        </div>
                        <div class="bg-white p-4 rounded-lg shadow-sm border w-1/3">
                            <div class="text-sm text-gray-500">Success</div>
                            <div class="text-xl font-semibold text-green-800 mt-1">{{ $counts['success'] ?? 0 }}</div>
                        </div>
                    </div>

                    <div class="col-span-1">
                        <form method="GET" action="{{ route('superadmin.withdraws.index') }}" class="flex items-center gap-2">
                            <select name="status" class="form-select block w-full rounded border-gray-300 p-2 text-sm">
                                <option value="">All status</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>Processing</option>
                                <option value="success" {{ request('status') == 'success' ? 'selected' : '' }}>Success</option>
                                <option value="failed" {{ request('status') == 'failed' ? 'selected' : '' }}>Failed</option>
                            </select>
                        </form>
                    </div>
                </div>

                <form method="GET" action="{{ route('superadmin.withdraws.index') }}"
                    class="mt-4 grid grid-cols-1 md:grid-cols-6 gap-3 items-end">
                    <div class="md:col-span-2">
                        <label class="text-xs text-gray-600">User (ID or name)</label>
                        <input type="text" name="user" value="{{ request('user') }}"
                            class="mt-1 block w-full rounded border-gray-300 p-2 text-sm" placeholder="ID or name" />
                    </div>
                    <div>
                        <label class="text-xs text-gray-600">Bank</label>
                        <select name="bank_code" class="mt-1 block w-full rounded border-gray-300 p-2 text-sm">
                            <option value="">All banks</option>
                            @foreach(($banks ?? []) as $b)
                                <option value="{{ $b }}" {{ request('bank_code') == $b ? 'selected' : '' }}>{{ $b }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="text-xs text-gray-600">Dari</label>
                        <input type="date" name="date_from" value="{{ request('date_from') }}"
                            class="mt-1 block w-full rounded border-gray-300 p-2 text-sm" />
                    </div>
                    <div>
                        <label class="text-xs text-gray-600">Sampai</label>
                        <input type="date" name="date_to" value="{{ request('date_to') }}"
                            class="mt-1 block w-full rounded border-gray-300 p-2 text-sm" />
                    </div>
                    <div class="md:col-span-1 flex gap-2">
                        <button type="submit" class="px-4 py-2 bg-primary-600 text-white rounded">Apply</button>
                        <a href="{{ route('superadmin.withdraws.index') }}"
                            class="px-4 py-2 bg-gray-100 text-gray-700 rounded">Reset</a>
                    </div>
                </form>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead>
                        <tr class="bg-gray-50 text-gray-600">
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider">#</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider">Mitra</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider">Jumlah</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider">Bank / Rekening
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-right text-xs font-semibold uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        @foreach($items as $item)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-3 text-sm text-gray-700">{{ $item->id }}</td>
                                <td class="px-6 py-3 text-sm text-gray-700">
                                    @if($item->user)
                                        <a href="{{ route('superadmin.users', $item->user) }}"
                                            class="text-primary-600 hover:underline">{{ $item->user->name }}</a>
                                        <div class="text-[11px] text-gray-400">ID: {{ $item->user_id }}</div>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="px-6 py-3 text-sm text-gray-900">Rp {{ number_format($item->amount, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-3 text-sm text-gray-700">{{ $item->bank_code }} / {{ $item->account_number }}
                                </td>
                                <td class="px-6 py-3 text-sm">
                                    @if($item->status === 'pending')
                                        <span class="px-2 py-1 rounded bg-yellow-100 text-yellow-800">Pending</span>
                                    @elseif($item->status === 'processing')
                                        <span class="px-2 py-1 rounded bg-blue-100 text-blue-800">Processing</span>
                                    @elseif($item->status === 'success')
                                        <span class="px-2 py-1 rounded bg-green-100 text-green-800">Success</span>
                                    @else
                                        <span class="px-2 py-1 rounded bg-red-100 text-red-800">Failed</span>
                                    @endif
                                </td>
                                <td class="px-6 py-3 text-right text-sm">
                                    <button data-id="{{ $item->id }}"
                                        class="open-withdraw-modal inline-flex items-center px-3 py-1.5 bg-primary-500 text-white rounded-full hover:bg-primary-600">Lihat
                                        / Proses</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if ($items->hasPages())
                <div class="bg-gray-50 px-6 py-4 border-t border-gray-100 flex justify-center">
                    {{ $items->links() }}
                </div>
            @endif
        </div>
    </div>
    <!-- Modal container -->
    <div id="superadmin-withdraw-modal-container"></div>

    <script>
        (function () {
            function openModal(id) {
                var container = document.getElementById('superadmin-withdraw-modal-container');
                // Fetch modal HTML
                fetch('/superadmin/withdraws/' + id + '/modal')
                    .then(function (res) { return res.text(); })
                    .then(function (html) {
                        container.innerHTML = html;
                        // Ensure modal scripts/behavior are initialized after injection
                        initSuperadminWithdrawModal(container);
                        window.scrollTo(0, 0);
                    })
                    .catch(function (err) { console.error('Failed to load modal:', err); });
            }

            document.querySelectorAll('.open-withdraw-modal').forEach(function (btn) {
                btn.addEventListener('click', function () {
                    var id = this.getAttribute('data-id');
                    openModal(id);
                });
            });
        })();

        function initSuperadminWithdrawModal(container) {
            var modal = container.querySelector('#superadmin-withdraw-modal');
            if (!modal) return;
            var overlay = modal.querySelector('#superadmin-withdraw-modal-overlay');
            var closeBtn = modal.querySelector('#close-superadmin-withdraw-modal');
            function removeModal() { container.innerHTML = ''; }
            // Initialize Alpine for dynamically injected modal (if Alpine is present)
            try {
                if (window.Alpine && typeof Alpine.initTree === 'function') {
                    Alpine.initTree(modal);
                }
            } catch (e) {
                console.warn('Alpine initTree failed for injected modal', e);
            }

            // Attach fallback handlers for reject modal inside injected modal
            try {
                var openRejectBtn = modal.querySelector('#open-reject-local');
                var fallback = modal.querySelector('#withdraw-reject-modal-fallback');
                var closeFallback = modal.querySelector('#close-reject-fallback');
                var cancelFallback = modal.querySelector('#cancel-reject-fallback');
                var overlayFallback = modal.querySelector('#withdraw-reject-fallback-overlay');

                console.log('initSuperadminWithdrawModal: openRejectBtn=', !!openRejectBtn, 'fallback=', !!fallback, 'overlay=', !!overlayFallback);

                function showFallback() {
                    if (!fallback) return;
                    fallback.classList.remove('hidden');
                    document.body.style.overflow = 'hidden';
                }
                function hideFallback() {
                    if (!fallback) return;
                    fallback.classList.add('hidden');
                    document.body.style.overflow = '';
                }

                if (openRejectBtn) {
                    openRejectBtn.addEventListener('click', function (e) {
                        // always show fallback as a guarantee when button clicked
                        try { console.log('open-reject-local clicked'); } catch (err) {}
                        showFallback();
                        try { window.dispatchEvent(new CustomEvent('open-reject')); } catch (err) {}
                    });
                } else {
                    // if button not found inside modal, listen globally just in case
                    window.addEventListener('click', function (ev) {
                        var target = ev.target || ev.srcElement;
                        if (target && target.id === 'open-reject-local') {
                            showFallback();
                            try { window.dispatchEvent(new CustomEvent('open-reject')); } catch (err) {}
                        }
                    });
                }

                if (closeFallback) closeFallback.addEventListener('click', hideFallback);
                if (cancelFallback) cancelFallback.addEventListener('click', hideFallback);
                if (overlayFallback) overlayFallback.addEventListener('click', hideFallback);
            } catch (e) {
                console.warn('Failed to attach reject fallback handlers', e);
            }

            if (closeBtn) closeBtn.addEventListener('click', removeModal);
            if (overlay) overlay.addEventListener('click', removeModal);
            document.body.style.overflow = 'hidden';
            var originalRemove = removeModal;
            removeModal = function () { document.body.style.overflow = ''; originalRemove(); };
        }
    </script>
@endsection
