@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-emerald-50 via-white to-teal-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md mx-auto">
        @if($transaction)
            <!-- Success Card -->
            <div class="bg-white rounded-3xl shadow-2xl overflow-hidden transform transition-all duration-500 hover:scale-[1.02]">
                <!-- Header with Animation -->
                <div class="bg-gradient-to-r from-emerald-500 to-teal-500 px-6 py-8 text-center relative overflow-hidden">
                    <!-- Animated Background Circles -->
                    <div class="absolute top-0 left-0 w-full h-full opacity-20">
                        <div class="absolute top-4 left-4 w-20 h-20 bg-white rounded-full animate-pulse"></div>
                        <div class="absolute bottom-4 right-4 w-16 h-16 bg-white rounded-full animate-pulse delay-100"></div>
                        <div class="absolute top-1/2 right-8 w-10 h-10 bg-white rounded-full animate-pulse delay-200"></div>
                    </div>
                    
                    <!-- Checkmark Icon -->
                    <div class="relative mx-auto w-20 h-20 bg-white rounded-full flex items-center justify-center shadow-lg mb-4 animate-bounce-slow">
                        <svg class="w-10 h-10 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    
                    <h1 class="text-2xl font-bold text-white relative">Pembayaran Berhasil!</h1>
                    <p class="text-emerald-100 mt-2 relative">Transaksi Anda telah dikonfirmasi</p>
                </div>

                <!-- Transaction Details -->
                <div class="px-6 py-8">
                    <!-- Order ID -->
                    <div class="flex items-center justify-between py-4 border-b border-gray-100">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-emerald-100 rounded-full flex items-center justify-center">
                                <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"></path>
                                </svg>
                            </div>
                            <span class="text-gray-500 text-sm">Order ID</span>
                        </div>
                        <span class="font-semibold text-gray-800">{{ $transaction->order_id }}</span>
                    </div>

                    <!-- Amount -->
                    <div class="flex items-center justify-between py-4 border-b border-gray-100">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <span class="text-gray-500 text-sm">Jumlah</span>
                        </div>
                        <span class="font-bold text-xl text-emerald-600">Rp {{ number_format($transaction->amount, 0, ',', '.') }}</span>
                    </div>

                    <!-- Status -->
                    <div class="flex items-center justify-between py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center">
                                <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <span class="text-gray-500 text-sm">Status</span>
                        </div>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-emerald-100 text-emerald-800">
                            <span class="w-2 h-2 bg-emerald-500 rounded-full mr-2 animate-pulse"></span>
                            {{ ucfirst($transaction->status) }}
                        </span>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="px-6 pb-8 space-y-3">
                    <a href="{{ route('dashboard') }}" 
                       class="block w-full py-3 px-4 bg-gradient-to-r from-emerald-500 to-teal-500 text-white text-center font-semibold rounded-xl shadow-lg shadow-emerald-500/30 hover:shadow-emerald-500/50 transform hover:-translate-y-0.5 transition-all duration-200">
                        <span class="flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                            </svg>
                            Kembali ke Dashboard
                        </span>
                    </a>
                    <a href="{{ route('customer.transactions.index') }}" 
                       class="block w-full py-3 px-4 bg-white text-emerald-600 text-center font-semibold rounded-xl border-2 border-emerald-200 hover:border-emerald-500 hover:bg-emerald-50 transform hover:-translate-y-0.5 transition-all duration-200">
                        <span class="flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                            Lihat Semua Transaksi
                        </span>
                    </a>
                </div>
            </div>

           
        @else
            <!-- Error Card -->
            <div class="bg-white rounded-3xl shadow-2xl overflow-hidden">
                <!-- Header -->
                <div class="bg-gradient-to-r from-amber-500 to-orange-500 px-6 py-8 text-center relative overflow-hidden">
                    <div class="absolute top-0 left-0 w-full h-full opacity-20">
                        <div class="absolute top-4 left-4 w-20 h-20 bg-white rounded-full animate-pulse"></div>
                        <div class="absolute bottom-4 right-4 w-16 h-16 bg-white rounded-full animate-pulse delay-100"></div>
                    </div>
                    
                    <!-- Warning Icon -->
                    <div class="relative mx-auto w-20 h-20 bg-white rounded-full flex items-center justify-center shadow-lg mb-4">
                        <svg class="w-10 h-10 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                    </div>
                    
                    <h1 class="text-2xl font-bold text-white relative">Transaksi Tidak Ditemukan</h1>
                    <p class="text-amber-100 mt-2 relative">Order ID: {{ $order_id }}</p>
                </div>

                <!-- Message -->
                <div class="px-6 py-8">
                    <div class="bg-amber-50 border border-amber-200 rounded-xl p-4 mb-6">
                        <div class="flex items-start gap-3">
                            <svg class="w-6 h-6 text-amber-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <div>
                                <p class="text-amber-800 text-sm">
                                    Kami tidak menemukan detail transaksi untuk Order ID ini. 
                                    Jika saldo belum muncul, tunggu beberapa menit atau hubungi support.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="space-y-3">
                        <a href="{{ route('dashboard') }}" 
                           class="block w-full py-3 px-4 bg-gradient-to-r from-amber-500 to-orange-500 text-white text-center font-semibold rounded-xl shadow-lg shadow-amber-500/30 hover:shadow-amber-500/50 transform hover:-translate-y-0.5 transition-all duration-200">
                            <span class="flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                                </svg>
                                Kembali ke Dashboard
                            </span>
                        </a>
                        <a href="{{ route('support') }}" 
                           class="block w-full py-3 px-4 bg-white text-amber-600 text-center font-semibold rounded-xl border-2 border-amber-200 hover:border-amber-500 hover:bg-amber-50 transform hover:-translate-y-0.5 transition-all duration-200">
                            <span class="flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                </svg>
                                Hubungi Support
                            </span>
                        </a>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

<style>
    @keyframes bounce-slow {
        0%, 100% {
            transform: translateY(-5%);
            animation-timing-function: cubic-bezier(0.8, 0, 1, 1);
        }
        50% {
            transform: translateY(0);
            animation-timing-function: cubic-bezier(0, 0, 0.2, 1);
        }
    }
    .animate-bounce-slow {
        animation: bounce-slow 2s infinite;
    }
    .delay-100 {
        animation-delay: 100ms;
    }
    .delay-200 {
        animation-delay: 200ms;
    }
</style>
@endsection