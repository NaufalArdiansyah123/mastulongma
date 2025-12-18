<?php

namespace App\Livewire\Customer\Helps;

use App\Models\City;
use App\Models\Help;
use App\Models\PartnerActivity;
use App\Models\UserBalance;
use App\Models\AppSetting;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;
use Carbon\Carbon;

class Create extends Component
{
    use WithFileUploads;

    public $title = '';
    public $description = '';
    public $equipment_provided = '';
    public $amount = '';
    public $city_id = '';
    public $location = '';
    public $full_address = '';
    public $latitude = null;
    public $longitude = null;
    // Scheduling
    public $scheduled_date = null; // YYYY-MM-DD
    public $scheduled_time = null; // HH:MM
    public $photo;
    public $showInsufficientModal = false;
    public $insufficientMessage = '';
    public $showConfirmModal = false;
    public $confirmAmount = 0;
    public $confirmAdminFee = 0;
    public $confirmTotal = 0;
    public $currentBalance = 0;
    public $confirmScheduled = null;

    protected $rules = [
        'title' => 'required|string|max:255',
        'description' => 'required|string',
        'equipment_provided' => 'nullable|string|max:1000',
        'amount' => 'required|numeric|min:0|max:100000000',
        'city_id' => 'required|exists:cities,id',
        'location' => 'nullable|string|max:255',
        'full_address' => 'nullable|string|max:1000',
        'latitude' => 'nullable|numeric|between:-90,90',
        'longitude' => 'nullable|numeric|between:-180,180',
        'photo' => 'nullable|image|max:2048',
        'scheduled_date' => 'nullable|date',
        'scheduled_time' => ['nullable','regex:/^(?:[0-1]?\d|2[0-3]):[0-5]\d$/'],
    ];

    protected $messages = [
        'amount.required' => 'Nominal uang harus diisi',
        'amount.numeric' => 'Nominal harus berupa angka',
        'amount.min' => 'Nominal tidak boleh kurang dari nilai minimal yang ditetapkan',
        'amount.max' => 'Nominal maksimal Rp 100.000.000',
        'scheduled_date.date' => 'Format tanggal tidak valid',
        'scheduled_time.regex' => 'Format waktu tidak valid. Gunakan format 24-jam HH:MM, contoh: 9:30 atau 09:30',
    ];

    public function save()
    {
        // Finalize creation after confirmation
        // Load settings (double-check)
        $minNominal = (float) AppSetting::get('min_help_nominal', 10000);
        $adminFee = (float) AppSetting::get('admin_fee', 0);

        $this->rules['amount'] = 'required|numeric|min:' . $minNominal . '|max:100000000';
        $this->validate();

        $userId = auth()->id();
        $userBalance = UserBalance::firstOrCreate(['user_id' => $userId], ['balance' => 0]);

        $amount = (float) $this->amount;
        $total = $amount + $adminFee;

        if ($userBalance->balance < $total) {
            $this->insufficientMessage = 'Saldo Anda tidak cukup. Total yang harus dibayar: Rp ' . number_format($total, 0, ',', '.');
            $this->showInsufficientModal = true;
            return;
        }

        // Final server-side check: scheduled_at not in the past
        if ($this->scheduled_date) {
            $time = $this->scheduled_time ?: '00:00';
            $scheduledAtCheck = Carbon::parse($this->scheduled_date . ' ' . $time);
            if ($scheduledAtCheck->lt(Carbon::now())) {
                $this->addError('scheduled_date', 'Jadwal tidak boleh berada di masa lalu');
                return;
            }
        }

        // Proceed to create help and deduct balance atomically
        DB::transaction(function () use ($userId, $amount, $adminFee, $total) {
            $photoPath = null;
            if ($this->photo) {
                $photoPath = $this->photo->store('helps', 'public');
            }

            // Generate unique order id for this help
            $orderId = $this->generateOrderId();

            // Combine scheduled_date and scheduled_time into scheduled_at if provided
            $scheduledAt = null;
            if ($this->scheduled_date) {
                $time = $this->scheduled_time ?: '00:00';
                $scheduledAt = date('Y-m-d H:i:s', strtotime($this->scheduled_date . ' ' . $time));
            }

            $help = Help::create([
                'user_id' => $userId,
                'order_id' => $orderId,
                'city_id' => $this->city_id,
                'title' => $this->title,
                'amount' => $amount,
                'admin_fee' => $adminFee,
                'total_amount' => $total,
                'description' => $this->description,
                'equipment_provided' => $this->equipment_provided,
                'location' => $this->location,
                'full_address' => $this->full_address,
                'scheduled_at' => $scheduledAt,
                'latitude' => $this->latitude,
                'longitude' => $this->longitude,
                'photo' => $photoPath,
                'status' => 'menunggu_mitra',
            ]);

            // Deduct balance using UserBalance helper to keep history
            $userBalance = UserBalance::firstOrCreate(['user_id' => $userId], ['balance' => 0]);
            $userBalance->deductBalance($total, 'Pembayaran bantuan #' . $help->id, $help->id);
        });

        session()->flash('message', 'Permintaan bantuan berhasil dibuat! Saldo Anda telah dikurangi dan permintaan menunggu mitra.');

        return redirect()->route('customer.helps.index');
    }

    public function prepareConfirm()
    {
        // Load settings
        $minNominal = (float) AppSetting::get('min_help_nominal', 10000);
        $adminFee = (float) AppSetting::get('admin_fee', 0);

        $this->rules['amount'] = 'required|numeric|min:' . $minNominal . '|max:100000000';
        $this->validate();

        $amount = (float) $this->amount;
        $total = $amount + $adminFee;

        // Validate scheduled datetime is not in the past
        if ($this->scheduled_date) {
            $time = $this->scheduled_time ?: '00:00';
            $scheduledAt = Carbon::parse($this->scheduled_date . ' ' . $time);
            if ($scheduledAt->lt(Carbon::now())) {
                $this->addError('scheduled_date', 'Jadwal tidak boleh berada di masa lalu');
                return;
            }
        }

        $userId = auth()->id();
        $userBalance = UserBalance::firstOrCreate(['user_id' => $userId], ['balance' => 0]);

        if ($userBalance->balance < $total) {
            $this->insufficientMessage = 'Saldo Anda tidak cukup. Total yang harus dibayar: Rp ' . number_format($total, 0, ',', '.');
            $this->showInsufficientModal = true;
            return;
        }

        $this->confirmAmount = $amount;
        $this->confirmAdminFee = $adminFee;
        $this->confirmTotal = $total;
        // Prepare scheduled display
        if ($this->scheduled_date) {
            $time = $this->scheduled_time ?: '00:00';
            $this->confirmScheduled = date('d M Y H:i', strtotime($this->scheduled_date . ' ' . $time));
        } else {
            $this->confirmScheduled = null;
        }
        $this->currentBalance = $userBalance->balance ?? 0;
        $this->showConfirmModal = true;
    }

    public function closeConfirmModal()
    {
        $this->showConfirmModal = false;
    }

    public function closeInsufficientModal()
    {
        $this->showInsufficientModal = false;
        $this->insufficientMessage = '';
    }

    /**
     * Generate a unique order id for a Help record.
     * Format: HELP-YYYYMMDDHHIISS-<random4>
     */
    private function generateOrderId()
    {
        // Try a few times to avoid collision
        for ($i = 0; $i < 5; $i++) {
            $candidate = 'HELP-' . date('YmdHis') . '-' . random_int(1000, 9999);
            if (!Help::where('order_id', $candidate)->exists()) {
                return $candidate;
            }
            // small sleep to change timestamp if collision
            usleep(200);
        }

        // Fallback - use uniqid
        return 'HELP-' . uniqid();
    }

    public function render()
    {
        $cities = City::where('is_active', true)->get();

        return view('livewire.customer.helps.create', [
            'cities' => $cities,
        ]);
    }
}
