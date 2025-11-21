@extends('layouts.admin')

@section('content') 

@php
    $role = Auth::user()->getRoleNames()->first();
@endphp 

<h2 class="text-xl font-bold mb-4">Your Cart</h2>

<div class="grid md:grid-cols-4 gap-4">

    @foreach($items as $item)
        <div class="border rounded-lg shadow-sm p-4 bg-white">
            <!-- Header -->
              @if ($item->coupon->image)
                    <div class="border relative" style="position: relative;">
                        <img src="{{ url('/assets/coupons/' . $item->coupon->image) }}" 
                            alt="{{ $item->coupon->title }}" 
                            class="rounded mb-3" 
                            style="width:100%;height:auto">                                   
                    </div>

    
                @endif
            <div class="flex justify-between items-center mb-3">

               
                <h3 class="text-lg font-semibold">{{ $item->coupon->title }}</h3>

                <!-- Remove Button -->
                <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button class="text-red-500 hover:text-red-700 font-bold">×</button>
                </form>
            </div>

            <!-- Details -->
            <div class="space-y-2">
                <p class="text-sm">
                    <span class="font-medium">Price:</span>
                    KSh {{ number_format($item->price, 2) }}
                </p>               

                <p class="text-sm">
                    <span class="font-medium">Total:</span>
                    KSh {{ number_format($item->price * $item->quantity, 2) }}
                </p>
            </div>

            <!-- Quantity Update -->
            <form action="{{ route('cart.update', $item->id) }}" method="POST" class="mt-3">
                @csrf
                <div class="flex items-center gap-3">
                    <input type="number"
                           name="quantity"
                           value="{{ $item->quantity }}"
                           class="w-20 border rounded px-2 py-1">
                    <button class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded">
                        Update
                    </button>
                </div>
            </form>
        </div>
    @endforeach

</div>


<h3 class="text-xl font-bold mt-4">Total: KSh {{ number_format($total, 2) }}</h3>
<form action="{{ route('checkout') }}" method="POST">
    @csrf
    <button class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded mt-4">
        Proceed to Checkout
    </button>
</form>


@endsection