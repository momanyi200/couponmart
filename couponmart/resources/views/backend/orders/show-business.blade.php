@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto bg-white p-6 shadow rounded">

    <h2 class="text-xl font-bold mb-4">Order Details</h2>

    <p><strong>Order Number:</strong> {{ $order->order_number }}</p>
    <p><strong>Date:</strong> {{ $order->created_at->format('d M Y H:i') }}</p>
    <p><strong>Total:</strong> KSh {{ number_format($order->total, 2) }}</p>

    <div class="mt-6">
        <h3 class="font-semibold mb-3 text-lg">Ordered Items</h3>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @foreach ($order->items as $item)
                <div class="border rounded-lg shadow p-4 flex gap-4 bg-white">

                    <!-- Image -->
                    <div class="w-24 h-24">
                        <img src="{{ url('/assets/coupons/' . $item->coupon->image) }}"
                            alt="Coupon Image"
                            class="w-full h-full object-cover rounded">                        
                    </div>

                    <!-- Details -->
                    <div class="flex-1">
                        <h4 class="font-bold text-gray-800 text-lg">
                            {{ $item->coupon->title }}
                        </h4>

                        <p class="text-gray-600 text-sm">
                            Price: <span class="font-semibold">KSh {{ number_format($item->price, 2) }}</span>
                        </p>

                        <p class="text-gray-600 text-sm">
                            Quantity: <span class="font-semibold">{{ $item->quantity }}</span>
                        </p>

                        <p class="text-gray-900 font-semibold mt-2">
                            Total: KSh {{ number_format($item->price * $item->quantity, 2) }}
                        </p>
                    </div>

                </div>
            @endforeach
        </div>
         {{-- Optional Actions --}}
        <div class="mt-6 flex gap-3">
            @if($order->status !== 'redeemed')
                <form action="{{ route('orders.redeem', $order->id) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <button class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                        Mark as Redeemed
                    </button>
                </form>
            @endif

            <a href="{{ route('order.lookup') }}" class="px-4 py-2 border rounded hover:bg-gray-100">
                Lookup Another Order
            </a>
        </div>
    </div>


</div>
@endsection
