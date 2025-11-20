<?php

namespace App\Livewire\Customer\Helps;

use App\Models\City;
use App\Models\Help;
use App\Models\UserBalance;
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

    protected $rules = [
        'title' => 'required|string|max:255',
        'description' => 'required|string',
        'amount' => 'required|numeric|min:10000|max:100000000',
        'city_id' => 'required|exists:cities,id',
        'location' => 'nullable|string|max:255',
        'photo' => 'nullable|image|max:2048',
    ];

    protected $messages = [
        'amount.required' => 'Nominal uang harus diisi',
        'amount.numeric' => 'Nominal harus berupa angka',
        'amount.min' => 'Nominal minimal Rp 10.000',
        'amount.max' => 'Nominal maksimal Rp 100.000.000',
    ];

    public function save()
    {
        $this->validate();
        // Check user balance
        $userId = auth()->id();
        $userBalance = UserBalance::firstOrCreate(['user_id' => $userId], ['balance' => 0]);

        $amount = (float) $this->amount;
        if ($userBalance->balance < $amount) {
            $this->insufficientMessage = 'Saldo Anda tidak cukup untuk membuat permintaan bantuan ini.';
            $this->showInsufficientModal = true;
            return;
        }

        // Proceed to create help and deduct balance atomically
        DB::transaction(function () use ($userId, $amount) {
            $photoPath = null;
            if ($this->photo) {
                $photoPath = $this->photo->store('helps', 'public');
            }

            $help = Help::create([
                'user_id' => $userId,
                'city_id' => $this->city_id,
                'title' => $this->title,
                'amount' => $this->amount,
                'description' => $this->description,
                'location' => $this->location,
                'photo' => $photoPath,
                'status' => 'menunggu_mitra',
            ]);

            // Deduct balance using UserBalance helper to keep history
            $userBalance = UserBalance::firstOrCreate(['user_id' => $userId], ['balance' => 0]);
            $userBalance->deductBalance($amount, 'Pembayaran bantuan #' . $help->id, $help->id);
        });

        session()->flash('message', 'Permintaan bantuan berhasil dibuat! Saldo Anda telah dikurangi dan permintaan menunggu mitra.');

        return redirect()->route('customer.helps.index');
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
