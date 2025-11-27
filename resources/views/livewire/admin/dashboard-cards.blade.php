<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
    <div class="bg-white rounded-lg shadow p-4 flex items-center gap-4">
        <div class="w-12 h-12 rounded-lg flex items-center justify-center shadow-sm"
            style="background: linear-gradient(135deg,#eef2ff,#e0f2fe);">
            <svg class="w-6 h-6 text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M12 8v4l3 3" />
            </svg>
        </div>
        <div>
            <div class="text-xs text-gray-500">Baru (1 jam)</div>
            <div class="text-lg font-bold text-gray-900">{{ number_format($newLastHour ?? 0) }}</div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-4 flex items-center gap-4">
        <div class="w-12 h-12 rounded-lg flex items-center justify-center shadow-sm"
            style="background: linear-gradient(135deg,#fff7ed,#ffedd5);">
            <svg class="w-6 h-6 text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M3 7h18M3 12h18M3 17h18" />
            </svg>
        </div>
        <div>
            <div class="text-xs text-gray-500">Hari ini</div>
            <div class="text-lg font-bold text-yellow-600">{{ number_format($todayCount ?? 0) }}</div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-4 flex items-center gap-4">
        <div class="w-12 h-12 rounded-lg flex items-center justify-center shadow-sm"
            style="background: linear-gradient(135deg,#ecfdf5,#bbf7d0);">
            <svg class="w-6 h-6 text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M9 12l2 2 4-4" />
            </svg>
        </div>
        <div>
            <div class="text-xs text-gray-500">Pengguna baru (24h)</div>
            <div class="text-lg font-bold text-green-600">{{ number_format($newUsers24h ?? 0) }}</div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-4 flex items-center gap-4">
        <div class="w-12 h-12 rounded-lg flex items-center justify-center shadow-sm"
            style="background: linear-gradient(135deg,#eff6ff,#dbeafe);">
            <svg class="w-6 h-6 text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6"
                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10" />
            </svg>
        </div>
        <div>
            <div class="text-xs text-gray-500">Mitra Aktif</div>
            <div class="text-lg font-bold text-gray-900">{{ number_format($activeMitra ?? 0) }}</div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-4 flex items-center gap-4">
        <div class="w-12 h-12 rounded-lg flex items-center justify-center shadow-sm"
            style="background: linear-gradient(135deg,#fff7ed,#ffedd5);">
            <svg class="w-6 h-6 text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M9 12h6m-6 4h6" />
            </svg>
        </div>
        <div>
            <div class="text-xs text-gray-500">Belum terselesaikan</div>
            <div class="text-lg font-bold text-orange-600">{{ number_format($unresolved ?? 0) }}</div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-4 flex items-center gap-4">
        <div class="w-12 h-12 rounded-lg flex items-center justify-center shadow-sm"
            style="background: linear-gradient(135deg,#ecfeff,#bbf7d0);">
            <svg class="w-6 h-6 text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M12 8v4l3 3" />
            </svg>
        </div>
        <div>
            <div class="text-xs text-gray-500">Rata-rata selesai (jam)</div>
            <div class="text-lg font-bold text-teal-600">
                {{ isset($avgCompletionHours) && $avgCompletionHours !== null ? $avgCompletionHours : '-' }}
            </div>
        </div>
    </div>
</div>