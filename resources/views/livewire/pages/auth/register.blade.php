<?php

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component {
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    /**
     * Handle an incoming registration request.
     */
    public function register(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        event(new Registered($user = User::create($validated)));

        Auth::login($user);

        $this->redirect(route('dashboard', absolute: false), navigate: true);
    }
}; ?>

<div class="bg-gradient-to-br from-primary-400 via-primary-500 to-primary-600 flex flex-col overflow-hidden shadow-2xl"
    style="height: 100vh; max-height: 100vh;">

    <!-- Header -->
    <div class="flex-shrink-0 pt-8 pb-6 text-center">
        <h1 class="text-3xl font-bold text-gray-900">Create Account</h1>
    </div>

    <!-- Card Container - Flex grow untuk fill space -->
    <div class="flex-1 flex flex-col bg-gray-50 rounded-t-[2.5rem] overflow-y-auto px-6 py-8">
        <form wire:submit="register" class="space-y-4 flex-1 flex flex-col">
            <!-- Full Name -->
            <div>
                <label for="name" class="block text-xs font-semibold text-gray-700 mb-2">Full Name</label>
                <input wire:model="name" id="name" type="text" name="name" required autofocus autocomplete="name"
                    placeholder="example@example.com"
                    class="w-full px-4 py-3 bg-white border-0 rounded-xl text-gray-700 text-sm placeholder-gray-400 focus:ring-2 focus:ring-primary-400 transition shadow-sm">
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <!-- Email -->
            <div>
                <label for="email" class="block text-xs font-semibold text-gray-700 mb-2">Email</label>
                <input wire:model="email" id="email" type="email" name="email" required autocomplete="username"
                    placeholder="example@example.com"
                    class="w-full px-4 py-3 bg-white border-0 rounded-xl text-gray-700 text-sm placeholder-gray-400 focus:ring-2 focus:ring-primary-400 transition shadow-sm">
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Mobile Number (Optional - untuk future) -->
            <div>
                <label for="phone" class="block text-xs font-semibold text-gray-700 mb-2">Mobile Number</label>
                <input type="tel" id="phone" name="phone" placeholder="+ 123 456 789"
                    class="w-full px-4 py-3 bg-white border-0 rounded-xl text-gray-700 text-sm placeholder-gray-400 focus:ring-2 focus:ring-primary-400 transition shadow-sm">
            </div>

            <!-- Date of Birth (Optional - untuk future) -->
            <div>
                <label for="dob" class="block text-xs font-semibold text-gray-700 mb-2">Date Of Birth</label>
                <input type="text" id="dob" name="dob" placeholder="DD / MM / YYY"
                    class="w-full px-4 py-3 bg-white border-0 rounded-xl text-gray-700 text-sm placeholder-gray-400 focus:ring-2 focus:ring-primary-400 transition shadow-sm">
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block text-xs font-semibold text-gray-700 mb-2">Password</label>
                <div class="relative">
                    <input wire:model="password" id="password" type="password" name="password" required
                        autocomplete="new-password" placeholder="••••••••"
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
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Confirm Password -->
            <div>
                <label for="password_confirmation" class="block text-xs font-semibold text-gray-700 mb-2">Confirm
                    Password</label>
                <div class="relative">
                    <input wire:model="password_confirmation" id="password_confirmation" type="password"
                        name="password_confirmation" required autocomplete="new-password" placeholder="••••••••"
                        class="w-full px-4 py-3 bg-white border-0 rounded-xl text-gray-700 text-sm placeholder-gray-400 focus:ring-2 focus:ring-primary-400 transition shadow-sm">
                    <button type="button" onclick="togglePassword('password_confirmation')"
                        class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-500">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </button>
                </div>
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <!-- Terms -->
            <div class="text-center text-xs text-gray-600 mt-2">
                By continuing, you agree to<br>
                <a href="#" class="text-gray-800 font-semibold hover:text-primary-600">Terms of Use</a> and
                <a href="#" class="text-gray-800 font-semibold hover:text-primary-600">Privacy Policy</a>.
            </div>

            <!-- Sign Up Button -->
            <button type="submit" wire:loading.attr="disabled"
                class="w-full bg-primary-500 hover:bg-primary-600 text-white font-bold py-3.5 rounded-full shadow-lg hover:shadow-xl transition disabled:opacity-50 mt-6">
                Sign Up
            </button>

            <!-- Log In Link - Push ke bawah -->
            <div class="text-center mt-auto pt-4">
                <p class="text-sm text-gray-600">
                    Already have an account?
                    <a href="{{ route('login') }}" wire:navigate
                        class="text-primary-600 font-semibold hover:text-primary-700">
                        Log In
                    </a>
                </p>
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