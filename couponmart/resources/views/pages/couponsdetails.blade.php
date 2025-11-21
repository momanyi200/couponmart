@extends('layouts.app')

@section('title', $coupon->title)

@section('content')
<div class="container mx-auto py-6">
    <div class="bg-white shadow-lg rounded-lg overflow-hidden">
        <!-- Coupon Image -->
        <img src="{{ url('/assets/coupons/' . $coupon->image) }}" 
             alt="{{ $coupon->title }}" 
             class="w-full h-64 object-cover">

        <div class="p-6">
            <!-- Title -->
            <h1 class="text-2xl font-bold mb-4">{{ $coupon->title }}</h1>

            <!-- Business Name -->
            @if($coupon->business)
                <p class="text-gray-500 mb-2">
                    Offered by: 
                    <a href="{{ route('business.show', $coupon->business->id) }}" class="text-blue-600 hover:underline">
                        {{ $coupon->business->business_name }}
                    </a>
                </p>
            @endif

            <!-- Description -->
            <p class="mb-4 text-gray-700">{{ $coupon->description }}</p>

            <!-- Quantity & Expiry -->
            <div class="flex items-center gap-6">
                <div class="bg-gray-100 px-3 py-2 rounded">
                    <strong>Remaining:</strong> {{ $coupon->remaining_vouchers }} / {{ $coupon->total_vouchers }}
                </div>
                <div class="bg-gray-100 px-3 py-2 rounded">
                    <strong>Expires on:</strong> {{ $coupon->end_date->format('d M Y') }}
                </div>
            </div>

            <!-- Claim / Action Button -->
            <div class="mt-6">
                
                <form action="{{ route('cart.add') }}" method="POST">
                    @csrf
                    <input type="hidden" name="coupon_id" value="{{ $coupon->id }}">
                    <button class="bg-green-600 text-white px-6 py-3 rourounded-lg shadownded">Add to Cart</button>
                </form>

            </div>
        </div>
    </div>

    @if($relatedCoupons->count())
        <section class="mt-10">
            <h3 class="text-xl font-semibold mb-4">Related Coupons</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
                @foreach($relatedCoupons as $related)
                    <div class="bg-white border rounded-lg shadow hover:shadow-lg transition p-4">
                        <img src="{{ asset('assets/coupons/' . $related->image) }}" 
                            alt="{{ $related->title }}" 
                            class="w-full h-40 object-cover rounded-md mb-3">
                        
                        <h4 class="font-bold text-lg">{{ $related->title }}</h4>
                        <p class="text-sm text-gray-600 mb-2">
                            {{ Str::limit($related->description, 60) }}
                        </p>
                        
                        <a href="{{ route('coupons.show', $related->id) }}" 
                        class="text-green-600 hover:underline font-medium">
                            View Coupon
                        </a>
                    </div>
                @endforeach
            </div>
        </section>
    @endif

</div>
@endsection
