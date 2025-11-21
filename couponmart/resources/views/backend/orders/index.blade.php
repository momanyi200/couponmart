@extends('layouts.admin')

@section('content')

@php 
    $role=Auth::user()->getRoleNames()->first();    
@endphp
<div class="max-w-6xl mx-auto px-4">

    <h1 class="text-2xl font-semibold mb-6">My Orders</h1>
    
    <form method="GET" class="flex flex-wrap gap-3 mb-4">

        <!-- Status -->
        <select name="status" class="border p-2 rounded">
            <option value="">All Status</option>
            <option value="pending" {{ request('status')=='pending' ? 'selected' : '' }}>Pending</option>
            <option value="paid" {{ request('status')=='paid' ? 'selected' : '' }}>Paid</option>
            <option value="cancelled" {{ request('status')=='cancelled' ? 'selected' : '' }}>Cancelled</option>
        </select>

        <!-- From Date -->
        <input type="date"
            name="from"
            class="border p-2 rounded"
            value="{{ request('from') }}">

        <!-- To Date -->
        <input type="date"
            name="to"
            class="border p-2 rounded"
            value="{{ request('to') }}">

        <!-- Filter Button -->
        <button class="bg-blue-600 text-white px-4 py-2 rounded">
            Filter
        </button>

        <!-- Reset Button -->
        <a href="{{ route('orders.index') }}" class="px-4 py-2 border rounded">
            Reset
        </a>

    </form>



    @if($orders->count() == 0)
        <p class="text-gray-600">You have no orders yet.</p>
    @endif

    <div class="grid md:grid-cols-4 gap-6">
        @foreach($orders as $order)
            <div class="bg-white shadow rounded p-4 border">

                <div class="flex justify-between items-center">
                    <h2 class="text-lg font-semibold">
                        Order #{{ $order->order_number }}
                    </h2>

                    <span class="text-sm bg-blue-600 text-white px-2 py-1 rounded">
                        {{ ucfirst($order->status) }}
                    </span>
                </div>

                <p class="text-gray-600 text-sm mt-1">
                    {{ $order->created_at->format('d M Y, h:i A') }}
                </p>

                <div class="my-3">
                    <p class="text-gray-700">
                        <strong>Total:</strong> KSh {{ number_format($order->total, 2) }}
                    </p>
                    <p class="text-gray-700">
                        <strong>Items:</strong> {{ $order->items_count }}
                    </p>
                </div>

                @if($order->qr_code_path)
                    <img src="{{ asset($order->qr_code_path) }}"
                         class="w-32 h-32 object-cover border rounded mb-3">
                @endif

                <a href="{{ route('orders.show', $order->id) }}"
                   class="inline-block bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                    View Details
                </a>
            </div>
        @endforeach
    </div>

    <div class="mt-6">
        {{ $orders->links() }}
    </div>

</div>
@endsection
