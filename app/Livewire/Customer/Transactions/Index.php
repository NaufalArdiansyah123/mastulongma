<?php

namespace App\Livewire\Customer\Transactions;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\BalanceTransaction;

class Index extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';

    public function render()
    {
        $transactions = BalanceTransaction::where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('livewire.customer.transactions.index', [
            'transactions' => $transactions,
        ]);
    }
}
