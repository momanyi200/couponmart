<?php

namespace App\Services;

use App\Models\User;
use App\Models\Wallet;
use App\Models\WalletTransaction;

class WalletService
{
    public function deposit(User $user, $amount, $reference = null)
    {
        $wallet = $user->wallet ?? Wallet::create(['user_id' => $user->id]);

        $transaction = $wallet->transactions()->create([
            'type' => 'deposit',
            'amount' => $amount,
            'reference' => $reference,
            'status' => 'completed',
        ]);

        $wallet->increment('balance', $amount);

        return $transaction;
    }

    public function withdraw(User $user, $amount, $reference = null)
    {
        $wallet = $user->wallet ?? Wallet::create(['user_id' => $user->id]);

        if ($wallet->balance < $amount) {
            throw new \Exception('Insufficient balance');
        }

        $transaction = $wallet->transactions()->create([
            'type' => 'withdrawal',
            'amount' => $amount,
            'reference' => $reference,
            'status' => 'completed',
        ]);

        $wallet->decrement('balance', $amount);

        return $transaction;
    }
}
