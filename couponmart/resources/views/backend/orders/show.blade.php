@extends('layouts.admin')

@section('content')

    @php 
        $role=Auth::user()->getRoleNames()->first();    
        $user = auth()->user();
        $isBuyer = $order->user_id == $user->id;
        $isSeller = $order->seller_id == $user->id;
    @endphp

    <div class="max-w-7xl mx-auto px-4 py-6">

        <div class="max-w-lg mx-auto mt-10 p-6 bg-white rounded shadow">
            <h2 class="text-2xl font-bold mb-4">Order Summary</h2>

            <p><strong>Order No:</strong> {{ $order->order_number }}</p>
            <p><strong>Total Amount:</strong> KSh {{ number_format($order->total, 2) }}</p>

            <h3 class="text-xl font-semibold mt-4 mb-2">QR Code</h3>

            <img src="{{ asset($order->qr_code_path) }}" class="w-56 mx-auto">

            <h3 class="text-xl font-semibold mt-4 mb-2">Items</h3>
            @foreach($order->items as $item)
                <div class="border p-3 rounded mb-2">
                    <p>{{ $item->coupon->title }}</p>
                    <p>Qty: {{ $item->quantity }}</p>
                    <p>Price: KSh {{ number_format($item->price, 2) }}</p>
                </div>
            @endforeach
            <a href="{{ route('orders.pdf', $order->id) }}"
                class="bg-red-600 text-white px-4 py-2 rounded mt-4 inline-block hover:bg-red-700">
                Download PDF
            </a>
            

            @if ($isBuyer || $isSeller)
                <a href="{{ route('conversations.start', $order->id) }}"
                class="px-4 py-2 bg-blue-600 text-white rounded">
                    {{ $isBuyer ? 'Contact Seller' : 'Contact Buyer' }}
                </a>
            @endif

        </div>
      

    </div>

@endsection
