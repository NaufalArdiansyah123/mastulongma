<?php
namespace App\Livewire\SuperAdmin;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Str;
use App\Models\BalanceTransaction;

class TransactionsLog extends Component
{
    use WithPagination;

    public $search = '';
    public $type = 'all'; // types: all, topup, withdraw, other
    public $perPage = 15;
    public $from = null;
    public $to = null;

    protected $queryString = ['search' => ['except' => ''], 'type' => ['except' => 'all']];

    protected $listeners = ['refreshTransactions' => '$refresh'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingType()
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = BalanceTransaction::query()->with('user');

        if ($this->type && $this->type !== 'all') {
            $query->where('type', $this->type);
        }

        if ($this->search) {
            $s = trim($this->search);
            $query->where(function ($q) use ($s) {
                $q->where('reference', 'like', "%{$s}%")
                    ->orWhereHas('user', function ($qu) use ($s) {
                        $qu->where('name', 'like', "%{$s}%")->orWhere('email', 'like', "%{$s}%");
                    });
            });
        }

        if ($this->from) {
            $query->whereDate('created_at', '>=', $this->from);
        }
        if ($this->to) {
            $query->whereDate('created_at', '<=', $this->to);
        }

        $transactions = $query->orderBy('created_at', 'desc')->paginate($this->perPage);

        return view('superadmin.transactions-log', [
            'transactions' => $transactions,
        ]);
    }
}
