<?php

namespace App\Observers;

use App\Models\BalanceTransaction;
use App\Models\UserBalance;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Livewire\Livewire;

class BalanceTransactionObserver
{
    /**
     * Handle the BalanceTransaction "created" event.
     */
    public function created(BalanceTransaction $transaction): void
    {
        $this->processIfCompleted($transaction, null);
    }

    /**
     * Handle the BalanceTransaction "updated" event.
     */
    public function updated(BalanceTransaction $transaction): void
    {
        $originalStatus = $transaction->getOriginal('status');
        $this->processIfCompleted($transaction, $originalStatus);
    }

    /**
     * Process topup when transaction becomes completed.
     *
     * @param BalanceTransaction $transaction
     * @param string|null $originalStatus
     * @return void
     */
    protected function processIfCompleted(BalanceTransaction $transaction, ?string $originalStatus): void
    {
        try {
            // Only process topup transactions
            if ($transaction->type !== 'topup') {
                return;
            }

            // Normalize possible typo 'complate' to 'completed'
            $currentStatus = strtolower(trim($transaction->status ?? ''));
            $originalStatusNormalized = $originalStatus ? strtolower(trim($originalStatus)) : null;

            if ($originalStatusNormalized === 'complate') {
                $originalStatusNormalized = 'completed';
            }

            if ($currentStatus === 'complate') {
                $currentStatus = 'completed';
            }

            // If originalStatus provided and already completed, skip (prevents double process)
            if ($originalStatusNormalized === 'completed') {
                return;
            }

            // Only act when current status is 'completed'
            if ($currentStatus !== 'completed') {
                return;
            }

            // Amount must be positive
            $amount = (float) $transaction->amount;
            if ($amount <= 0) {
                return;
            }

            DB::transaction(function () use ($transaction, $amount) {
                // Get or create user balance record
                $userBalance = UserBalance::firstOrCreate(
                    ['user_id' => $transaction->user_id],
                    ['balance' => 0]
                );

                // Increment balance by amount
                $userBalance->increment('balance', $amount);

                // Emit Livewire event so dashboard components can refresh immediately
                try {
                    Livewire::emit('balance-updated');
                } catch (\Throwable $e) {
                    // ignore if Livewire not available in this context
                }

                // Mark transaction as processed (if column exists)
                if (property_exists($transaction, 'processed_at') || array_key_exists('processed_at', $transaction->getAttributes())) {
                    $transaction->processed_at = now();
                    $transaction->save();
                }

                // Optional: Log the change for traceability
                Log::info('BalanceTransaction processed: added topup to user balance', [
                    'transaction_id' => $transaction->id,
                    'user_id' => $transaction->user_id,
                    'amount' => $amount,
                ]);
            });
        } catch (\Throwable $e) {
            Log::error('Failed to process BalanceTransaction observer', [
                'transaction_id' => $transaction->id ?? null,
                'error' => $e->getMessage(),
            ]);
        }
    }
}
