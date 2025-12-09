<x-app-layout>
    <x-slot name="title">Bantuan & Dukungan</x-slot>

    <div class="min-h-screen bg-gray-50">
        <!-- Header -->
        <div class="bg-gradient-to-br from-primary-400 via-primary-500 to-primary-600 px-6 py-4 rounded-b-3xl">
            <div class="flex items-center justify-between">
                <a href="{{ route('mitra.profile') }}" class="text-white">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </a>
                <h1 class="text-xl font-bold text-white">Bantuan & Dukungan</h1>
                <div class="w-6"></div>
            </div>
        </div>

        <!-- Content -->
        <div class="px-6 py-6 pb-24 space-y-4">
            <!-- FAQ Section -->
            <div class="bg-white rounded-2xl shadow-md p-5">
                <div class="flex items-center mb-4">
                    <div class="bg-gradient-to-br from-purple-400 to-purple-600 text-white p-3 rounded-full">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h2 class="ml-3 text-lg font-bold text-gray-900">Frequently Asked Questions</h2>
                </div>
                <div class="space-y-3">
                    <details class="group">
                        <summary class="cursor-pointer list-none flex items-center justify-between p-3 bg-gray-50 rounded-xl hover:bg-gray-100 transition">
                            <span class="font-semibold text-gray-900">Bagaimana cara mengambil bantuan?</span>
                            <svg class="w-5 h-5 text-gray-400 group-open:rotate-180 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </summary>
                        <div class="mt-2 px-3 py-2 text-sm text-gray-600 leading-relaxed">
                            Anda dapat melihat daftar bantuan yang tersedia di halaman dashboard, pilih bantuan yang sesuai dengan kemampuan Anda, lalu klik "Ambil Bantuan".
                        </div>
                    </details>

                    <details class="group">
                        <summary class="cursor-pointer list-none flex items-center justify-between p-3 bg-gray-50 rounded-xl hover:bg-gray-100 transition">
                            <span class="font-semibold text-gray-900">Bagaimana cara menarik saldo?</span>
                            <svg class="w-5 h-5 text-gray-400 group-open:rotate-180 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </summary>
                        <div class="mt-2 px-3 py-2 text-sm text-gray-600 leading-relaxed">
                            Masuk ke menu Withdraw, isi jumlah penarikan dan informasi rekening bank Anda. Admin akan memproses penarikan dalam 1-3 hari kerja.
                        </div>
                    </details>

                    <details class="group">
                        <summary class="cursor-pointer list-none flex items-center justify-between p-3 bg-gray-50 rounded-xl hover:bg-gray-100 transition">
                            <span class="font-semibold text-gray-900">Bagaimana sistem rating bekerja?</span>
                            <svg class="w-5 h-5 text-gray-400 group-open:rotate-180 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </summary>
                        <div class="mt-2 px-3 py-2 text-sm text-gray-600 leading-relaxed">
                            Setelah bantuan selesai, customer dapat memberikan rating dan ulasan untuk Anda. Rating yang baik akan meningkatkan reputasi Anda sebagai mitra.
                        </div>
                    </details>

                    <details class="group">
                        <summary class="cursor-pointer list-none flex items-center justify-between p-3 bg-gray-50 rounded-xl hover:bg-gray-100 transition">
                            <span class="font-semibold text-gray-900">Bagaimana jika ada masalah dengan bantuan?</span>
                            <svg class="w-5 h-5 text-gray-400 group-open:rotate-180 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </summary>
                        <div class="mt-2 px-3 py-2 text-sm text-gray-600 leading-relaxed">
                            Anda dapat melaporkan masalah melalui fitur "Laporkan" atau hubungi customer support melalui kontak yang tersedia di bawah.
                        </div>
                    </details>
                </div>
            </div>

            <!-- Contact Support -->
            <div class="bg-white rounded-2xl shadow-md p-5">
                <h2 class="text-lg font-bold text-gray-900 mb-4">Hubungi Kami</h2>
                <div class="space-y-3">
                    <a href="mailto:support@mastulongmas.com" class="flex items-center p-3 bg-gray-50 rounded-xl hover:bg-gray-100 transition">
                        <div class="bg-gradient-to-br from-blue-400 to-blue-600 text-white p-2.5 rounded-full">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div class="ml-3 flex-1">
                            <p class="font-semibold text-gray-900">Email</p>
                            <p class="text-sm text-gray-600">support@mastulongmas.com</p>
                        </div>
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>

                    <a href="https://wa.me/6281234567890" target="_blank" class="flex items-center p-3 bg-gray-50 rounded-xl hover:bg-gray-100 transition">
                        <div class="bg-gradient-to-br from-green-400 to-green-600 text-white p-2.5 rounded-full">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                            </svg>
                        </div>
                        <div class="ml-3 flex-1">
                            <p class="font-semibold text-gray-900">WhatsApp</p>
                            <p class="text-sm text-gray-600">+62 812-3456-7890</p>
                        </div>
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>

                    <a href="tel:+6281234567890" class="flex items-center p-3 bg-gray-50 rounded-xl hover:bg-gray-100 transition">
                        <div class="bg-gradient-to-br from-primary-400 to-primary-600 text-white p-2.5 rounded-full">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                        </div>
                        <div class="ml-3 flex-1">
                            <p class="font-semibold text-gray-900">Telepon</p>
                            <p class="text-sm text-gray-600">+62 812-3456-7890</p>
                        </div>
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>
            </div>

            <!-- App Info -->
            <div class="bg-white rounded-2xl shadow-md p-5">
                <h2 class="text-lg font-bold text-gray-900 mb-3">Informasi Aplikasi</h2>
                <div class="space-y-2 text-sm text-gray-600">
                    <div class="flex justify-between">
                        <span>Versi Aplikasi</span>
                        <span class="font-semibold text-gray-900">1.0.0</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Platform</span>
                        <span class="font-semibold text-gray-900">Web & Mobile</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Last Update</span>
                        <span class="font-semibold text-gray-900">{{ now()->format('d M Y') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
