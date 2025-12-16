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
    public $photo;
    public $showInsufficientModal = false;
    public $insufficientMessage = '';
    public $showConfirmModal = false;
    public $confirmAmount = 0;
    public $confirmAdminFee = 0;
    public $confirmTotal = 0;
    public $currentBalance = 0;

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
    ];

    protected $messages = [
        'amount.required' => 'Nominal uang harus diisi',
        'amount.numeric' => 'Nominal harus berupa angka',
        'amount.min' => 'Nominal tidak boleh kurang dari nilai minimal yang ditetapkan',
        'amount.max' => 'Nominal maksimal Rp 100.000.000',
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

        // Proceed to create help and deduct balance atomically
        DB::transaction(function () use ($userId, $amount, $adminFee, $total) {
            $photoPath = null;
            if ($this->photo) {
                $photoPath = $this->photo->store('helps', 'public');
            }

            // Generate unique order id for this help
            $orderId = $this->generateOrderId();

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
