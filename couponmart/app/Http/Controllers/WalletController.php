<?php

namespace App\Http\Controllers;

use App\Models\Wallet;
use App\Services\WalletService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;



class WalletController extends Controller
{
    protected $walletService;

    public function __construct(WalletService $walletService)
    {
        $this->walletService = $walletService;
    }

    public function index() { 
        $wallet = auth()->user()->wallet;
        $transactions = $wallet ? $wallet->transactions()->latest()->get() : collect();
        return view('backend.wallet.index', compact('wallet', 'transactions'));
    }

    public function deposit(Request $request) {
        $request->validate(['amount' => 'required|numeric|min:1']);
        $transaction = $this->walletService->deposit(auth()->user(), $request->amount);
        return back()->with('success', "Deposited KSh {$transaction->amount}");
    }

    public function withdraw(Request $request) {
        $request->validate(['amount' => 'required|numeric|min:1']);
        try {
            $transaction = $this->walletService->withdraw(auth()->user(), $request->amount);
            return back()->with('success', "Withdrew KSh {$transaction->amount}");
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}

