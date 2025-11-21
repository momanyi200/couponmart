@extends('layouts.admin')

@section('content')

@php 
    $role=Auth::user()->getRoleNames()->first();    
@endphp 

<div class="max-w-6xl mx-auto px-4 py-8 space-y-8">

    <!-- Wallet Balance -->
    <div class="bg-white shadow-md rounded-lg p-6">
        <h2 class="text-2xl font-semibold mb-2">Your Wallet</h2>
        <p class="text-xl text-green-600 font-bold">KSh {{ number_format($wallet?->balance ?? 0, 2) }}</p>
    </div>

    <!-- Deposit & Withdraw Forms -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        <!-- Deposit Card -->
        <div class="bg-white shadow-md rounded-lg p-6">
            <h3 class="text-xl font-semibold mb-4">Deposit Funds</h3>

            <form method="POST" action="{{ route('wallet.deposit') }}" class="space-y-4">
                @csrf
                
                <div>
                    <label class="block text-sm font-medium mb-1">Amount</label>
                    <input type="number" name="amount" class="w-full border rounded-lg px-3 py-2" min="1" required placeholder="Enter amount">
                </div>

                <button class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 w-full">
                    Deposit
                </button>
            </form>
        </div>

        <!-- Withdraw Card -->
        <div class="bg-white shadow-md rounded-lg p-6">
            <h3 class="text-xl font-semibold mb-4">Withdraw Funds</h3>

            <form method="POST" action="{{ route('wallet.withdraw') }}" class="space-y-4">
                @csrf
                
                <div>
                    <label class="block text-sm font-medium mb-1">Amount</label>
                    <input type="number" name="amount" class="w-full border rounded-lg px-3 py-2" min="1" required placeholder="Enter amount">
                </div>

                <button class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 w-full">
                    Withdraw
                </button>
            </form>
        </div>

    </div>

    <!-- Transactions -->
    <div class="bg-white shadow-md rounded-lg p-6">
        <h3 class="text-xl font-semibold mb-4">Transactions</h3>

        <div class="space-y-4">

            @forelse($transactions as $tx)
                <div class="border rounded-lg p-4 flex justify-between items-center">

                    <div>
                        <p class="font-semibold capitalize">{{ $tx->type }}</p>
                        <p>{{ $tx->reference}}</p>
                        <p class="text-sm text-gray-500">
                            {{ $tx->created_at->format('d M Y, H:i') }}
                        </p>
                    </div>

                    <div class="text-right">
                        <p class="font-semibold
                            @if($tx->type === 'deposit') text-green-600
                            @elseif($tx->type === 'withdrawal') text-red-600
                            @else text-blue-600
                            @endif">
                            KSh {{ number_format($tx->amount, 2) }}
                        </p>

                        <span class="text-sm px-2 py-1 rounded-full 
                            @if($tx->status === 'completed') bg-green-100 text-green-700
                            @elseif($tx->status === 'pending') bg-yellow-100 text-yellow-700
                            @else bg-red-100 text-red-700
                            @endif">
                            {{ ucfirst($tx->status) }}
                        </span>
                    </div>

                </div>
            @empty
                <p class="text-gray-500">No transactions yet.</p>
            @endforelse

        </div>
    </div>

</div>

@endsection
