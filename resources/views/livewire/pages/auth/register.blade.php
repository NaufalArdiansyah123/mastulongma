<?php

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component {
    public function startRegistration(): void
    {
        // Redirect ke step 1 untuk registrasi multi-step
        $this->redirect(route('register.choose-role'), navigate: true);
    }
}; ?>

<div class="bg-gradient-to-br from-primary-400 via-primary-500 to-primary-600 flex flex-col overflow-hidden shadow-2xl"
    style="height: 100vh; max-height: 100vh;">

    <!-- Header -->
    <div class="flex-shrink-0 pt-8 pb-6 text-center">
        <h1 class="text-3xl font-bold text-white">Daftar Akun Baru</h1>
        <p class="text-white/90 text-sm mt-2">Lengkapi data untuk verifikasi</p>
    </div>

    <!-- Card Container -->
    <div class="flex-1 flex flex-col bg-gray-50 rounded-t-[2.5rem] overflow-y-auto px-6 py-8">
        <div class="flex-1 flex flex-col justify-between">
            <!-- Info Section -->
            <div class="space-y-6">
                <!-- Welcome Message -->
                <div class="text-center mb-8">
                    <div class="w-24 h-24 bg-primary-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-12 h-12 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-900 mb-2">Siapkan Dokumen Anda</h2>
                    <p class="text-gray-600 text-sm">Proses registrasi memerlukan beberapa dokumen untuk verifikasi
                        identitas</p>
                </div>

                <!-- Requirements List -->
                <div class="bg-white rounded-2xl p-6 shadow-lg">
                    <h3 class="font-bold text-gray-900 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-primary-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                                clip-rule="evenodd" />
                        </svg>
                        Yang Perlu Disiapkan:
                    </h3>
                    <div class="space-y-3">
                        <div class="flex items-start gap-3">
                            <div
                                class="flex-shrink-0 w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                                <span class="text-green-600 font-bold text-sm">1</span>
                            </div>
                            <div class="flex-1">
                                <h4 class="font-semibold text-gray-900 text-sm">Data KTP</h4>
                                <p class="text-xs text-gray-600">NIK, nama lengkap, alamat, dan data lainnya sesuai KTP
                                </p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <div
                                class="flex-shrink-0 w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                <span class="text-blue-600 font-bold text-sm">2</span>
                            </div>
                            <div class="flex-1">
                                <h4 class="font-semibold text-gray-900 text-sm">Foto KTP</h4>
                                <p class="text-xs text-gray-600">Foto KTP yang jelas dan terbaca</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <div
                                class="flex-shrink-0 w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center">
                                <span class="text-purple-600 font-bold text-sm">3</span>
                            </div>
                            <div class="flex-1">
                                <h4 class="font-semibold text-gray-900 text-sm">Foto Selfie + KTP</h4>
                                <p class="text-xs text-gray-600">Foto selfie sambil memegang KTP Anda</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <div
                                class="flex-shrink-0 w-8 h-8 bg-orange-100 rounded-full flex items-center justify-center">
                                <span class="text-orange-600 font-bold text-sm">4</span>
                            </div>
                            <div class="flex-1">
                                <h4 class="font-semibold text-gray-900 text-sm">Email & Password</h4>
                                <p class="text-xs text-gray-600">Email aktif untuk akun login Anda</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Info Banner -->
                <div class="bg-blue-50 border border-blue-200 rounded-xl p-4">
                    <div class="flex gap-3">
                        <div class="flex-shrink-0">
                            <svg class="w-5 h-5 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h4 class="text-sm font-bold text-blue-900 mb-1">Informasi Penting</h4>
                            <p class="text-xs text-blue-800">Data yang Anda berikan akan digunakan untuk verifikasi
                                identitas dan keamanan akun. Pastikan semua data yang dimasukkan benar dan sesuai dengan
                                KTP asli.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="space-y-3 mt-6">
                <button wire:click="startRegistration" type="button"
                    class="w-full bg-primary-500 hover:bg-primary-600 text-white font-bold py-3.5 rounded-full shadow-lg hover:shadow-xl transition">
                    Mulai Pendaftaran
                </button>

                <div class="text-center">
                    <p class="text-sm text-gray-600">
                        Sudah punya akun?
                        <a href="{{ route('login') }}" wire:navigate
                            class="text-primary-600 font-semibold hover:text-primary-700">
                            Login
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>