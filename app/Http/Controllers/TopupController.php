<?php

namespace App\Http\Controllers;

use App\Models\BalanceTransaction;
use App\Models\UserBalance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Midtrans\Config;
use Midtrans\Notification;

class TopupController extends Controller
{
    public function __construct()
    {
        // Set Midtrans configuration
        Config::$serverKey = config('services.midtrans.server_key');
        Config::$isProduction = config('services.midtrans.is_production');
        Config::$isSanitized = config('services.midtrans.is_sanitized');
        Config::$is3ds = config('services.midtrans.is_3ds');
    }

    /**
     * Handle finish callback from Midtrans
     */
    public function finish(Request $request)
    {
        $orderId = $request->order_id;

        Log::info('Midtrans finish callback', ['order_id' => $orderId]);

        return redirect()->route('customer.topup')->with('status', 'Pembayaran sedang diproses. Silakan tunggu konfirmasi.');
    }

    /**
     * Handle unfinish callback from Midtrans
     */
    public function unfinish(Request $request)
    {
        $orderId = $request->order_id;

        Log::info('Midtrans unfinish callback', ['order_id' => $orderId]);

        return redirect()->route('customer.topup')->with('error', 'Pembayaran dibatalkan.');
    }

    /**
     * Handle error callback from Midtrans
     */
    public function error(Request $request)
    {
        $orderId = $request->order_id;

        Log::info('Midtrans error callback', ['order_id' => $orderId]);

        return redirect()->route('customer.topup')->with('error', 'Terjadi kesalahan pada pembayaran.');
    }

    /**
     * Handle notification webhook from Midtrans
     */
    public function notification(Request $request)
    {
        try {
            // Create notification instance
            $notification = new Notification();

            $transactionStatus = $notification->transaction_status;
            $fraudStatus = $notification->fraud_status;
            $orderId = $notification->order_id;

            Log::info('Midtrans notification', [
                'order_id' => $orderId,
                'transaction_status' => $transactionStatus,
                'fraud_status' => $fraudStatus,
            ]);

            // Find transaction by order_id
            $transaction = BalanceTransaction::where('order_id', $orderId)->first();

            if (!$transaction) {
                Log::warning('Transaction not found', ['order_id' => $orderId]);
                return response()->json(['status' => 'error', 'message' => 'Transaction not found'], 404);
            }

            // Update midtrans response
            $transaction->midtrans_response = json_encode($notification->getResponse());

            // Handle transaction status
            if ($transactionStatus == 'capture') {
                if ($fraudStatus == 'accept') {
                    // Payment success
                    $this->updateTransactionSuccess($transaction, $notification->payment_type);
                }
            } elseif ($transactionStatus == 'settlement') {
                // Payment success
                $this->updateTransactionSuccess($transaction, $notification->payment_type);
            } elseif ($transactionStatus == 'pending') {
                // Payment pending
                $transaction->status = 'pending';
                $transaction->payment_type = $notification->payment_type;
                $transaction->save();
            } elseif (in_array($transactionStatus, ['deny', 'expire', 'cancel'])) {
                // Payment failed
                $transaction->status = 'failed';
                $transaction->payment_type = $notification->payment_type;
                $transaction->save();
            }

            return response()->json(['status' => 'success']);
        } catch (\Exception $e) {
            Log::error('Midtrans notification error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Update transaction to success and add balance
     */
    private function updateTransactionSuccess(BalanceTransaction $transaction, $paymentType)
    {
        // Update transaction status
        $transaction->status = 'completed';
        $transaction->payment_type = $paymentType;
        $transaction->save();

        // Update user balance
        $userBalance = UserBalance::firstOrCreate(
            ['user_id' => $transaction->user_id],
            ['balance' => 0]
        );

        $userBalance->balance += $transaction->amount;
        $userBalance->save();

        Log::info('Transaction success', [
            'transaction_id' => $transaction->id,
            'user_id' => $transaction->user_id,
            'amount' => $transaction->amount,
            'new_balance' => $userBalance->balance,
        ]);
    }
}
