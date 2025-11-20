<?php

use App\Models\Registration;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component {
    public $step1_data;
    public $step2_data;
    public $step3_data;
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';
    public bool $agree_terms = false;

    public function mount()
    {
        // Cek apakah registration UUID ada
        $uuid = Session::get('registration_uuid');
        if (!$uuid) {
            $this->redirect(route('register.step1'), navigate: true);
            return;
        }

        $registration = Registration::where('uuid', $uuid)->first();
        if (!$registration || !$registration->ktp_photo_path || !$registration->selfie_photo_path) {
            $this->redirect(route('register.step1'), navigate: true);
            return;
        }

        // Load step data from registration record
        $this->step1_data = $registration->only([
            'nik',
            'full_name',
            'place_of_birth',
            'date_of_birth',
            'gender',
            'address',
            'rt',
            'rw',
            'kelurahan',
            'kecamatan',
            'city',
            'province',
            'religion',
            'marital_status',
            'occupation'
        ]);

        $this->step2_data = ['ktp_photo_path' => $registration->ktp_photo_path];
        $this->step3_data = ['selfie_photo_path' => $registration->selfie_photo_path];
    }

    public function complete(): void
    {
        $validated = $this->validate([
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'agree_terms' => ['accepted'],
        ]);
        // Ambil registration
        $uuid = Session::get('registration_uuid');
        $registration = Registration::where('uuid', $uuid)->first();
        if (!$registration) {
            $this->redirect(route('register.step1'), navigate: true);
            return;
        }

        // Gabungkan semua data
        $userData = [
            'name' => $registration->full_name,
            'email' => $validated['email'],
            'role' => $registration->role ?? 'kustomer',
            'password' => Hash::make($validated['password']),
            'nik' => $registration->nik,
            'place_of_birth' => $registration->place_of_birth,
            'date_of_birth' => $registration->date_of_birth,
            'gender' => $registration->gender,
            'address' => $registration->address,
            'rt' => $registration->rt,
            'rw' => $registration->rw,
            'kelurahan' => $registration->kelurahan,
            'kecamatan' => $registration->kecamatan,
            'city' => $registration->city,
            'province' => $registration->province,
            'religion' => $registration->religion,
            'marital_status' => $registration->marital_status,
            'occupation' => $registration->occupation,
            'ktp_photo' => $registration->ktp_photo_path,
            'selfie_photo' => $registration->selfie_photo_path,
        ];

        // Buat user baru tetapi jangan login — akun perlu verifikasi admin
        // Set status default 'pending' and verified = false
        $userData['status'] = 'pending';
        $userData['verified'] = false;

        $user = User::create($userData);

        event(new Registered($user));

        // Tandai registration menunggu verifikasi admin
        $registration->update([
            'status' => 'pending_verification',
            'email' => $validated['email'],
            // store hashed password in registration for audit if desired
            'password' => Hash::make($validated['password']),
        ]);

        // Hapus UUID session
        Session::forget('registration_uuid');

        // Redirect to a success/awaiting-verification page
        $this->redirect(route('registration.success'), navigate: true);
    }

    public function previousStep(): void
    {
        $this->redirect(route('register.step3'), navigate: true);
    }

    public function editStep($step): void
    {
        $this->redirect(route("register.step{$step}"), navigate: true);
    }
}; ?>

<div class="bg-gradient-to-br from-primary-400 via-primary-500 to-primary-600 flex flex-col overflow-hidden shadow-2xl"
    style="height: 100vh; max-height: 100vh;">

    <!-- Header -->
    <div class="flex-shrink-0 pt-6 pb-4 px-6">
        <div class="flex items-center justify-between">
            <button wire:click="previousStep" class="text-white">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </button>
            <h1 class="text-xl font-bold text-white">Verifikasi Data</h1>
            <div class="w-6"></div>
        </div>

        <!-- Progress Indicator -->
        <div class="mt-4 flex items-center gap-2">
            <div class="flex-1 h-1 bg-white rounded-full"></div>
            <div class="flex-1 h-1 bg-white rounded-full"></div>
            <div class="flex-1 h-1 bg-white rounded-full"></div>
            <div class="flex-1 h-1 bg-white rounded-full"></div>
        </div>
        <p class="text-white/90 text-sm mt-2 text-center">Step 4 of 4</p>
    </div>

    <!-- Card Container -->
    <div class="flex-1 flex flex-col bg-gray-50 rounded-t-[2.5rem] overflow-y-auto px-6 py-6">
        <form wire:submit="complete" class="flex-1 flex flex-col space-y-4">
            <p class="text-sm text-gray-600 mb-2">Periksa kembali data Anda sebelum melanjutkan</p>

            <!-- Data KTP Summary -->
            <div class="bg-white rounded-xl p-4 shadow-sm">
                <div class="flex items-center justify-between mb-3">
                    <h3 class="font-bold text-gray-900 flex items-center gap-2">
                        <svg class="w-5 h-5 text-primary-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                clip-rule="evenodd" />
                        </svg>
                        Data Pribadi
                    </h3>
                    <button type="button" wire:click="editStep(1)"
                        class="text-primary-600 text-sm font-semibold">Edit</button>
                </div>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-600">NIK:</span>
                        <span class="font-semibold text-gray-900">{{ $step1_data['nik'] }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Nama:</span>
                        <span class="font-semibold text-gray-900">{{ $step1_data['full_name'] }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">TTL:</span>
                        <span class="font-semibold text-gray-900">{{ $step1_data['place_of_birth'] }},
                            {{ date('d/m/Y', strtotime($step1_data['date_of_birth'])) }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Jenis Kelamin:</span>
                        <span class="font-semibold text-gray-900">{{ $step1_data['gender'] }}</span>
                    </div>
                    <div class="pt-2 border-t">
                        <span class="text-gray-600 block mb-1">Alamat:</span>
                        <span class="font-semibold text-gray-900 text-xs">
                            {{ $step1_data['address'] }}, RT {{ $step1_data['rt'] }}/RW {{ $step1_data['rw'] }},
                            Kel. {{ $step1_data['kelurahan'] }}, Kec. {{ $step1_data['kecamatan'] }},
                            {{ $step1_data['city'] }}, {{ $step1_data['province'] }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Foto KTP -->
            <div class="bg-white rounded-xl p-4 shadow-sm">
                <div class="flex items-center justify-between mb-3">
                    <h3 class="font-bold text-gray-900 flex items-center gap-2">
                        <svg class="w-5 h-5 text-primary-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z"
                                clip-rule="evenodd" />
                        </svg>
                        Foto KTP
                    </h3>
                    <button type="button" wire:click="editStep(2)"
                        class="text-primary-600 text-sm font-semibold">Edit</button>
                </div>
                <img src="{{ Storage::url($step2_data['ktp_photo_path']) }}" alt="KTP" class="w-full rounded-lg">
            </div>

            <!-- Foto Selfie -->
            <div class="bg-white rounded-xl p-4 shadow-sm">
                <div class="flex items-center justify-between mb-3">
                    <h3 class="font-bold text-gray-900 flex items-center gap-2">
                        <svg class="w-5 h-5 text-primary-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z"
                                clip-rule="evenodd" />
                        </svg>
                        Foto Selfie dengan KTP
                    </h3>
                    <button type="button" wire:click="editStep(3)"
                        class="text-primary-600 text-sm font-semibold">Edit</button>
                </div>
                <img src="{{ Storage::url($step3_data['selfie_photo_path']) }}" alt="Selfie" class="w-full rounded-lg">
            </div>

            <!-- Email & Password -->
            <div class="bg-white rounded-xl p-4 shadow-sm">
                <h3 class="font-bold text-gray-900 mb-3 flex items-center gap-2">
                    <svg class="w-5 h-5 text-primary-500" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                        <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                    </svg>
                    Akun Login
                </h3>
                <div class="space-y-3">
                    <div>
                        <label for="email" class="block text-xs font-semibold text-gray-700 mb-2">Email *</label>
                        <input wire:model="email" id="email" type="email" placeholder="example@email.com"
                            class="w-full px-4 py-3 bg-gray-50 border-0 rounded-xl text-gray-700 text-sm placeholder-gray-400 focus:ring-2 focus:ring-primary-400 transition">
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>
                    <div>
                        <label for="password" class="block text-xs font-semibold text-gray-700 mb-2">Password *</label>
                        <input wire:model="password" id="password" type="password" placeholder="Min. 8 karakter"
                            class="w-full px-4 py-3 bg-gray-50 border-0 rounded-xl text-gray-700 text-sm placeholder-gray-400 focus:ring-2 focus:ring-primary-400 transition">
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>
                    <div>
                        <label for="password_confirmation"
                            class="block text-xs font-semibold text-gray-700 mb-2">Konfirmasi Password *</label>
                        <input wire:model="password_confirmation" id="password_confirmation" type="password"
                            placeholder="Ketik ulang password"
                            class="w-full px-4 py-3 bg-gray-50 border-0 rounded-xl text-gray-700 text-sm placeholder-gray-400 focus:ring-2 focus:ring-primary-400 transition">
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>
                </div>
            </div>

            <!-- Terms & Conditions -->
            <div class="bg-gray-50 rounded-xl p-4">
                <label class="flex items-start gap-3 cursor-pointer">
                    <input wire:model="agree_terms" type="checkbox" class="w-5 h-5 text-primary-500 rounded mt-0.5">
                    <span class="text-sm text-gray-700 flex-1">
                        Saya menyetujui <a href="#" class="text-primary-600 font-semibold">Syarat & Ketentuan</a>
                        serta <a href="#" class="text-primary-600 font-semibold">Kebijakan Privasi</a> yang berlaku
                    </span>
                </label>
                <x-input-error :messages="$errors->get('agree_terms')" class="mt-2" />
            </div>

            <!-- Complete Button -->
            <div class="pt-2 pb-2">
                <button type="submit" wire:loading.attr="disabled"
                    class="w-full bg-green-500 hover:bg-green-600 text-white font-bold py-3.5 rounded-full shadow-lg hover:shadow-xl transition disabled:opacity-50">
                    <span wire:loading.remove>Selesai & Daftar</span>
                    <span wire:loading>Mendaftarkan akun...</span>
                </button>
            </div>
        </form>
    </div>
</div>