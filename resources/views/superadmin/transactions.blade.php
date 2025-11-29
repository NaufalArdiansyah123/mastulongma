@component('layouts.superadmin', ['title' => 'Log Transaksi'])
<div>
    <header class="bg-white shadow-sm border-b border-gray-200 sticky top-0 z-10">
        <div class="px-8 py-6">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Log Transaksi</h1>
                <p class="text-sm text-gray-600 mt-1">Riwayat topup, withdraw, dan mutasi saldo pengguna.</p>
            </div>
        </div>
    </header>

    <div class="px-6 py-6">
        <div class="w-full">
            <div class="bg-white rounded-2xl shadow-md p-4 border border-gray-200 w-full">
                <livewire:super-admin.transactions-log />
            </div>
        </div>
    </div>
</div>
@endcomponent