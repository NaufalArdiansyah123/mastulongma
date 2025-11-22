<?php

use App\Models\Registration;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component {
    public string $nik = '';
    public string $full_name = '';
    public string $place_of_birth = '';
    public string $date_of_birth = '';
    public string $gender = '';
    public string $address = '';
    public string $rt = '';
    public string $rw = '';
    public string $kelurahan = '';
    public string $kecamatan = '';
    public string $city = '';
    public string $province = '';
    public string $religion = '';
    public string $marital_status = '';
    public string $occupation = '';

    // Auto-detect gender from NIK
    public function updatedNik($value)
    {
        if (strlen($value) >= 8) {
            $tglLahir = (int) substr($value, 6, 2);
            // Jika tanggal > 40, berarti perempuan
            $this->gender = $tglLahir > 40 ? 'Perempuan' : 'Laki-laki';
        }
    }

    // Preload saved registration values if a registration UUID exists in session
    public function mount(): void
    {
        $uuid = Session::get('registration_uuid');
        if (!$uuid) {
            return;
        }

        $registration = Registration::where('uuid', $uuid)->first();
        if (!$registration) {
            return;
        }

        $this->nik = $registration->nik ?? $this->nik;
        $this->full_name = $registration->full_name ?? $this->full_name;
        $this->place_of_birth = $registration->place_of_birth ?? $this->place_of_birth;
        $this->date_of_birth = $registration->date_of_birth ?? $this->date_of_birth;
        $this->gender = $registration->gender ?? $this->gender;
        $this->address = $registration->address ?? $this->address;
        $this->rt = $registration->rt ?? $this->rt;
        $this->rw = $registration->rw ?? $this->rw;
        $this->kelurahan = $registration->kelurahan ?? $this->kelurahan;
        $this->kecamatan = $registration->kecamatan ?? $this->kecamatan;
        $this->city = $registration->city ?? $this->city;
        $this->province = $registration->province ?? $this->province;
        $this->religion = $registration->religion ?? $this->religion;
        $this->marital_status = $registration->marital_status ?? $this->marital_status;
        $this->occupation = $registration->occupation ?? $this->occupation;
    }

    public function nextStep(): void
    {
        $validated = $this->validate([
            'nik' => ['required', 'string', 'size:16', 'regex:/^[0-9]+$/'],
            'full_name' => ['required', 'string', 'max:255'],
            'place_of_birth' => ['required', 'string', 'max:100'],
            'date_of_birth' => ['required', 'date'],
            'gender' => ['required', 'in:Laki-laki,Perempuan'],
            'address' => ['required', 'string', 'max:500'],
            'rt' => ['required', 'string', 'max:5'],
            'rw' => ['required', 'string', 'max:5'],
            'kelurahan' => ['required', 'string', 'max:100'],
            'kecamatan' => ['required', 'string', 'max:100'],
            'city' => ['required', 'string', 'max:100'],
            'province' => ['required', 'string', 'max:100'],
            'religion' => ['required', 'string', 'max:50'],
            'marital_status' => ['required', 'in:Belum Kawin,Kawin,Cerai Hidup,Cerai Mati'],
            'occupation' => ['required', 'string', 'max:100'],
        ]);

        // Simpan atau update record registration di database
        $uuid = Session::get('registration_uuid');

        if ($uuid) {
            $registration = Registration::where('uuid', $uuid)->first();
        } else {
            $registration = null;
        }

        $role = Session::get('registration_role', 'customer');

        if ($registration) {
            $registration->update($validated + ['status' => 'in_progress', 'role' => $role]);
        } else {
            $registration = Registration::create(array_merge($validated, [
                'uuid' => Str::uuid()->toString(),
                'status' => 'in_progress',
                'role' => $role,
            ]));
            Session::put('registration_uuid', $registration->uuid);
        }

        // Clear client-side saved draft for step1 (if any)
        $this->dispatch('clear-registration-step1');

        $this->redirect(route('register.step2'), navigate: true);
    }
}; ?>

<div class="bg-gradient-to-br from-primary-400 via-primary-500 to-primary-600 flex flex-col overflow-hidden shadow-2xl"
    style="height: 100vh; max-height: 100vh;">

    <!-- Header -->
    <div class="flex-shrink-0 pt-6 pb-4 px-6">
        <div class="flex items-center justify-between">
            <a href="{{ route('register') }}" wire:navigate class="text-white">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
            <h1 class="text-xl font-bold text-white">Data KTP</h1>
            <div class="w-6"></div>
        </div>

        <!-- Progress Indicator -->
        <div class="mt-4 flex items-center gap-2">
            <div class="flex-1 h-1 bg-white rounded-full"></div>
            <div class="flex-1 h-1 bg-white/30 rounded-full"></div>
            <div class="flex-1 h-1 bg-white/30 rounded-full"></div>
            <div class="flex-1 h-1 bg-white/30 rounded-full"></div>
        </div>
        <p class="text-white/90 text-sm mt-2 text-center">Step 1 of 4</p>
    </div>

    <!-- Card Container -->
    <div class="flex-1 flex flex-col bg-gray-50 rounded-t-[2.5rem] overflow-y-auto px-6 py-6">
        <form wire:submit="nextStep" class="space-y-4">
            <p class="text-sm text-gray-600 mb-4">Isi data sesuai dengan KTP Anda</p>

            <!-- NIK -->
            <div>
                <label for="nik" class="block text-xs font-semibold text-gray-700 mb-2">NIK *</label>
                <input wire:model.live="nik" id="nik" type="text" maxlength="16" placeholder="16 digit NIK"
                    oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                    class="w-full px-4 py-3 bg-white border-0 rounded-xl text-gray-700 text-sm placeholder-gray-400 focus:ring-2 focus:ring-primary-400 transition shadow-sm">
                <p class="text-xs text-gray-500 mt-1">{{ strlen($nik) }}/16 digit</p>
                <x-input-error :messages="$errors->get('nik')" class="mt-2" />
            </div>

            <!-- Nama Lengkap -->
            <div>
                <label for="full_name" class="block text-xs font-semibold text-gray-700 mb-2">Nama Lengkap *</label>
                <input wire:model="full_name" id="full_name" type="text" placeholder="Sesuai KTP"
                    class="w-full px-4 py-3 bg-white border-0 rounded-xl text-gray-700 text-sm placeholder-gray-400 focus:ring-2 focus:ring-primary-400 transition shadow-sm">
                <x-input-error :messages="$errors->get('full_name')" class="mt-2" />
            </div>

            <!-- Tempat & Tanggal Lahir -->
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label for="place_of_birth" class="block text-xs font-semibold text-gray-700 mb-2">Tempat Lahir
                        *</label>
                    <input wire:model="place_of_birth" id="place_of_birth" type="text" placeholder="Kota"
                        class="w-full px-4 py-3 bg-white border-0 rounded-xl text-gray-700 text-sm placeholder-gray-400 focus:ring-2 focus:ring-primary-400 transition shadow-sm">
                    <x-input-error :messages="$errors->get('place_of_birth')" class="mt-2" />
                </div>
                <div>
                    <label for="date_of_birth" class="block text-xs font-semibold text-gray-700 mb-2">Tanggal Lahir
                        *</label>
                    <input wire:model="date_of_birth" id="date_of_birth" type="date"
                        class="w-full px-4 py-3 bg-white border-0 rounded-xl text-gray-700 text-sm placeholder-gray-400 focus:ring-2 focus:ring-primary-400 transition shadow-sm">
                    <x-input-error :messages="$errors->get('date_of_birth')" class="mt-2" />
                </div>
            </div>

            <!-- Jenis Kelamin -->
            <div>
                <label class="block text-xs font-semibold text-gray-700 mb-2">Jenis Kelamin *</label>
                <div class="grid grid-cols-2 gap-3">
                    <label class="flex items-center px-4 py-3 bg-white rounded-xl cursor-pointer border-2 transition"
                        :class="$wire.gender === 'Laki-laki' ? 'border-primary-500' : 'border-transparent'">
                        <input wire:model="gender" type="radio" value="Laki-laki" class="w-4 h-4 text-primary-500">
                        <span class="ml-2 text-sm text-gray-700">Laki-laki</span>
                    </label>
                    <label class="flex items-center px-4 py-3 bg-white rounded-xl cursor-pointer border-2 transition"
                        :class="$wire.gender === 'Perempuan' ? 'border-primary-500' : 'border-transparent'">
                        <input wire:model="gender" type="radio" value="Perempuan" class="w-4 h-4 text-primary-500">
                        <span class="ml-2 text-sm text-gray-700">Perempuan</span>
                    </label>
                </div>
                <x-input-error :messages="$errors->get('gender')" class="mt-2" />
            </div>

            <!-- Alamat -->
            <div>
                <label for="address" class="block text-xs font-semibold text-gray-700 mb-2">Alamat *</label>
                <textarea wire:model="address" id="address" rows="3" placeholder="Alamat lengkap sesuai KTP"
                    class="w-full px-4 py-3 bg-white border-0 rounded-xl text-gray-700 text-sm placeholder-gray-400 focus:ring-2 focus:ring-primary-400 transition shadow-sm"></textarea>
                <x-input-error :messages="$errors->get('address')" class="mt-2" />
            </div>

            <!-- RT/RW -->
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label for="rt" class="block text-xs font-semibold text-gray-700 mb-2">RT *</label>
                    <input wire:model="rt" id="rt" type="text" placeholder="001"
                        class="w-full px-4 py-3 bg-white border-0 rounded-xl text-gray-700 text-sm placeholder-gray-400 focus:ring-2 focus:ring-primary-400 transition shadow-sm">
                    <x-input-error :messages="$errors->get('rt')" class="mt-2" />
                </div>
                <div>
                    <label for="rw" class="block text-xs font-semibold text-gray-700 mb-2">RW *</label>
                    <input wire:model="rw" id="rw" type="text" placeholder="002"
                        class="w-full px-4 py-3 bg-white border-0 rounded-xl text-gray-700 text-sm placeholder-gray-400 focus:ring-2 focus:ring-primary-400 transition shadow-sm">
                    <x-input-error :messages="$errors->get('rw')" class="mt-2" />
                </div>
            </div>

            <!-- Kelurahan/Desa -->
            <div>
                <label for="kelurahan" class="block text-xs font-semibold text-gray-700 mb-2">Kelurahan/Desa *</label>
                <input wire:model="kelurahan" id="kelurahan" type="text" placeholder="Nama Kelurahan/Desa"
                    class="w-full px-4 py-3 bg-white border-0 rounded-xl text-gray-700 text-sm placeholder-gray-400 focus:ring-2 focus:ring-primary-400 transition shadow-sm">
                <x-input-error :messages="$errors->get('kelurahan')" class="mt-2" />
            </div>

            <!-- Kecamatan -->
            <div>
                <label for="kecamatan" class="block text-xs font-semibold text-gray-700 mb-2">Kecamatan *</label>
                <input wire:model="kecamatan" id="kecamatan" type="text" placeholder="Nama Kecamatan"
                    class="w-full px-4 py-3 bg-white border-0 rounded-xl text-gray-700 text-sm placeholder-gray-400 focus:ring-2 focus:ring-primary-400 transition shadow-sm">
                <x-input-error :messages="$errors->get('kecamatan')" class="mt-2" />
            </div>

            <script>
                (function () {
                    const prefix = 'registration_step1_';
                    const fields = ['nik', 'full_name', 'place_of_birth', 'date_of_birth', 'gender', 'address', 'rt', 'rw', 'kelurahan', 'kecamatan', 'city', 'province', 'religion', 'marital_status', 'occupation'];

                    // Load saved draft from localStorage into inputs
                    window.addEventListener('DOMContentLoaded', () => {
                        try {
                            fields.forEach(name => {
                                const key = prefix + name;
                                const el = document.getElementById(name);
                                if (!el) return;
                                const val = localStorage.getItem(key);
                                if (val !== null) {
                                    el.value = val;
                                    el.dispatchEvent(new Event('input', { bubbles: true }));
                                }
                            });
                        } catch (e) {
                            // ignore
                        }
                    });

                    // Save changes to localStorage on input
                    fields.forEach(name => {
                        const el = document.getElementById(name);
                        if (!el) return;
                        el.addEventListener('input', (ev) => {
                            try { localStorage.setItem(prefix + name, ev.target.value); } catch (e) { }
                        });
                    });

                    // Clear saved draft when Livewire dispatches clear-registration-step1
                    document.addEventListener('clear-registration-step1', () => {
                        try { fields.forEach(name => localStorage.removeItem(prefix + name)); } catch (e) { }
                    });

                    // Livewire will trigger a custom event name when dispatch() is called server-side
                    document.addEventListener('livewire:load', function () {
                        if (window.Livewire) {
                            window.Livewire.on('clear-registration-step1', () => {
                                try { fields.forEach(name => localStorage.removeItem(prefix + name)); } catch (e) { }
                            });
                        }
                    });
                })();
            </script>

            <!-- Kota/Kabupaten -->
            <div>
                <label for="city" class="block text-xs font-semibold text-gray-700 mb-2">Kota/Kabupaten *</label>
                <input wire:model="city" id="city" type="text" placeholder="Nama Kota/Kabupaten"
                    class="w-full px-4 py-3 bg-white border-0 rounded-xl text-gray-700 text-sm placeholder-gray-400 focus:ring-2 focus:ring-primary-400 transition shadow-sm">
                <x-input-error :messages="$errors->get('city')" class="mt-2" />
            </div>

            <!-- Provinsi -->
            <div>
                <label for="province" class="block text-xs font-semibold text-gray-700 mb-2">Provinsi *</label>
                <input wire:model="province" id="province" type="text" placeholder="Nama Provinsi"
                    class="w-full px-4 py-3 bg-white border-0 rounded-xl text-gray-700 text-sm placeholder-gray-400 focus:ring-2 focus:ring-primary-400 transition shadow-sm">
                <x-input-error :messages="$errors->get('province')" class="mt-2" />
            </div>

            <!-- Agama -->
            <div>
                <label for="religion" class="block text-xs font-semibold text-gray-700 mb-2">Agama *</label>
                <select wire:model="religion" id="religion"
                    class="w-full px-4 py-3 bg-white border-0 rounded-xl text-gray-700 text-sm focus:ring-2 focus:ring-primary-400 transition shadow-sm">
                    <option value="">Pilih Agama</option>
                    <option value="Islam">Islam</option>
                    <option value="Kristen">Kristen</option>
                    <option value="Katolik">Katolik</option>
                    <option value="Hindu">Hindu</option>
                    <option value="Buddha">Buddha</option>
                    <option value="Konghucu">Konghucu</option>
                </select>
                <x-input-error :messages="$errors->get('religion')" class="mt-2" />
            </div>

            <!-- Status Perkawinan -->
            <div>
                <label for="marital_status" class="block text-xs font-semibold text-gray-700 mb-2">Status Perkawinan
                    *</label>
                <select wire:model="marital_status" id="marital_status"
                    class="w-full px-4 py-3 bg-white border-0 rounded-xl text-gray-700 text-sm focus:ring-2 focus:ring-primary-400 transition shadow-sm">
                    <option value="">Pilih Status</option>
                    <option value="Belum Kawin">Belum Kawin</option>
                    <option value="Kawin">Kawin</option>
                    <option value="Cerai Hidup">Cerai Hidup</option>
                    <option value="Cerai Mati">Cerai Mati</option>
                </select>
                <x-input-error :messages="$errors->get('marital_status')" class="mt-2" />
            </div>

            <!-- Pekerjaan -->
            <div>
                <label for="occupation" class="block text-xs font-semibold text-gray-700 mb-2">Pekerjaan *</label>
                <input wire:model="occupation" id="occupation" type="text" placeholder="Contoh: Karyawan Swasta"
                    class="w-full px-4 py-3 bg-white border-0 rounded-xl text-gray-700 text-sm placeholder-gray-400 focus:ring-2 focus:ring-primary-400 transition shadow-sm">
                <x-input-error :messages="$errors->get('occupation')" class="mt-2" />
            </div>

            <!-- Next Button -->
            <div class="pt-4 pb-6">
                <button type="submit" wire:loading.attr="disabled"
                    class="w-full bg-primary-500 hover:bg-primary-600 text-white font-bold py-3.5 rounded-full shadow-lg hover:shadow-xl transition disabled:opacity-50">
                    <span wire:loading.remove>Lanjutkan</span>
                    <span wire:loading>Memproses...</span>
                </button>
            </div>
        </form>
    </div>
</div>