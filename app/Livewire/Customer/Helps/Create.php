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
    public $amount = '';
    public $city_id = '';
    public $location = '';
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
        'amount' => 'required|numeric|min:0|max:100000000',
        'city_id' => 'required|exists:cities,id',
        'location' => 'nullable|string|max:255',
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

            $help = Help::create([
                'user_id' => $userId,
                'city_id' => $this->city_id,
                'title' => $this->title,
                'amount' => $amount,
                'admin_fee' => $adminFee,
                'total_amount' => $total,
                'description' => $this->description,
                'location' => $this->location,
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

    public function render()
    {
        $cities = City::where('is_active', true)->get();

        return view('livewire.customer.helps.create', [
            'cities' => $cities,
        ]);
    }
}
