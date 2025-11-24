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

        <!-- Filters -->
        <form method="GET" class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-6">

            <input type="text" name="reference" placeholder="Search reference"
                value="{{ request('reference') }}"
                class="border rounded-lg px-3 py-2">

            <select name="type" class="border rounded-lg px-3 py-2">
                <option value="">All Types</option>
                <option value="deposit" {{ request('type')=='deposit'?'selected':'' }}>Deposit</option>
                <option value="withdrawal" {{ request('type')=='withdrawal'?'selected':'' }}>Withdrawal</option>
            </select>

            <select name="status" class="border rounded-lg px-3 py-2">
                <option value="">All Status</option>
                <option value="completed" {{ request('status')=='completed'?'selected':'' }}>Completed</option>
                <option value="pending" {{ request('status')=='pending'?'selected':'' }}>Pending</option>
                <option value="failed" {{ request('status')=='failed'?'selected':'' }}>Failed</option>
            </select>

            <input type="date" name="start_date"
                value="{{ request('start_date') }}"
                class="border rounded-lg px-3 py-2">

            <input type="date" name="end_date"
                value="{{ request('end_date') }}"
                class="border rounded-lg px-3 py-2">

            <button class="md:col-span-5 bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                Apply Filters
            </button>

        </form>

        <!-- Transactions List -->
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
                <p class="text-gray-500">No transactions found.</p>
            @endforelse

        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $transactions->links() }}
        </div>
    </div>


</div>

@endsection
