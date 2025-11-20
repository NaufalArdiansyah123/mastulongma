<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component {
    public LoginForm $form;

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $this->validate();

        $this->form->authenticate();

        // Redirect admins to admin login page
        if (in_array(auth()->user()->role, ['admin', 'super_admin'])) {
            Auth::logout();
            $this->addError('email', 'Admin users must login at /admin/login');
            return;
        }

        Session::regenerate();

        // Determine redirect destination based on user role
        $user = auth()->user();

        // Redirect to role-specific dashboard
        if ($user->role === 'mitra') {
            $redirect = route('mitra.dashboard', absolute: false);
        } elseif ($user->role === 'kustomer') {
            $redirect = route('customer.dashboard', absolute: false);
        } else {
            // Default fallback
            $redirect = route('dashboard', absolute: false);
        }

        $this->redirectIntended(default: $redirect, navigate: true);
    }
}; ?>

<div class="bg-gradient-to-br from-primary-400 via-primary-500 to-primary-600 flex flex-col overflow-hidden shadow-2xl"
    style="height: 100vh; max-height: 100vh;">



    <!-- Header -->
    <div class="flex-shrink-0 pt-8 pb-6 text-center">
        <h1 class="text-3xl font-bold text-gray-900">Welcome</h1>
    </div>

    <!-- Card Container - Flex grow untuk fill space -->
    <div class="flex-1 flex flex-col bg-gray-50 rounded-t-[2.5rem] overflow-y-auto px-6 py-8">
        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form wire:submit="login" class="space-y-4 flex-1 flex flex-col">
            <!-- Email Address -->
            <div>
                <label for="email" class="block text-xs font-semibold text-gray-700 mb-2">Username Or Email</label>
                <input wire:model="form.email" id="email" type="email" name="email" required autofocus
                    autocomplete="username" placeholder="example@example.com"
                    class="w-full px-4 py-3 bg-white border-0 rounded-xl text-gray-700 text-sm placeholder-gray-400 focus:ring-2 focus:ring-primary-400 transition shadow-sm">
                <x-input-error :messages="$errors->get('form.email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block text-xs font-semibold text-gray-700 mb-2">Password</label>
                <div class="relative">
                    <input wire:model="form.password" id="password" type="password" name="password" required
                        autocomplete="current-password" placeholder="••••••••"
                        class="w-full px-4 py-3 bg-white border-0 rounded-xl text-gray-700 text-sm placeholder-gray-400 focus:ring-2 focus:ring-primary-400 transition shadow-sm">
                    <button type="button" onclick="togglePassword('password')"
                        class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-500">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </button>
                </div>
                <x-input-error :messages="$errors->get('form.password')" class="mt-2" />
            </div>

            <!-- Log In Button -->
            <button type="submit" wire:loading.attr="disabled"
                class="w-full bg-primary-500 hover:bg-primary-600 text-white font-bold py-3.5 rounded-full shadow-lg hover:shadow-xl transition disabled:opacity-50 mt-6">
                Log In
            </button>

            <!-- Forgot Password -->
            @if (Route::has('password.request'))
                <div class="text-center">
                    <a href="{{ route('password.request') }}" wire:navigate
                        class="text-sm text-gray-700 hover:text-gray-900 font-semibold">
                        Forgot Password?
                    </a>
                </div>
            @endif

            <!-- Sign Up Button -->
            <a href="{{ route('register') }}" wire:navigate
                class="block w-full bg-white hover:bg-gray-100 text-gray-700 font-bold py-3.5 rounded-full text-center transition shadow-sm border border-gray-200">
                Sign Up
            </a>

            <!-- Fingerprint Section -->
            <div class="text-center my-4">
                <p class="text-sm text-gray-600">or sign up with
                </p>
                <p class="text-xs text-gray-500 mt-2"></p>
            </div>

            <!-- Social Login -->
            <div class="flex justify-center gap-4">
                <button type="button"
                    class="w-12 h-12 rounded-full bg-white border border-gray-200 flex items-center justify-center hover:border-primary-400 transition shadow-sm">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"
                            fill="#4285F4" />
                        <path
                            d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"
                            fill="#34A853" />
                        <path
                            d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"
                            fill="#FBBC05" />
                        <path
                            d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"
                            fill="#EA4335" />
                    </svg>
                </button>
                <button type="button"
                    class="w-12 h-12 rounded-full bg-white border border-gray-200 flex items-center justify-center hover:border-primary-400 transition shadow-sm">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M9.198 21.5h4v-8.01h3.604l.396-3.98h-4V7.5a1 1 0 011-1h3v-4h-3a5 5 0 00-5 5v2.01h-2l-.396 3.98h2.396v8.01z" />
                    </svg>
                </button>
            </div>

            <!-- Sign Up Link - Push ke bawah -->
            <div class="text-center mt-auto pt-4 space-y-3">
                <p class="text-sm text-gray-600">
                    Don't have an account?
                    <a href="{{ route('register') }}" wire:navigate
                        class="text-primary-600 font-semibold hover:text-primary-700">
                        Sign Up
                    </a>
                </p>

                <!-- Admin Login Link -->
                <div class="pt-3 border-t border-gray-200">
                    <a href="{{ route('admin.login') }}" wire:navigate
                        class="inline-flex items-center text-sm text-gray-700 hover:text-primary-600 font-medium">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                        Admin Login
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    function togglePassword(id) {
        const input = document.getElementById(id);
        input.type = input.type === 'password' ? 'text' : 'password';
    }
</script>