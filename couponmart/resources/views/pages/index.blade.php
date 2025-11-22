@extends('layouts.app')

@section('title', 'Welcome to CouponSeller')

@section('content')
    {{-- Hero Section --}}
    <section class="bg-white py-16">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <h1 class="text-4xl md:text-5xl font-bold text-gray-800 mb-4">Save Big with CouponSeller</h1>
            <p class="text-lg text-gray-600 mb-6">
                Discover and buy amazing discount coupons from trusted businesses near you.
            </p>
            <a href="" class="inline-block px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                Get Started
            </a>
        </div>
    </section>

    <section id="intro" class="w-full px-0 py-0">
    <div class="grid grid-cols-3 sm:gap-0 lg:gap-6 py-6">
        @foreach([
            ['icon' => 'bx-checkbox-checked', 'title' => 'Quality Products'],
            ['icon' => 'bx-money', 'title' => 'Cash Back'],
            ['icon' => 'bx-phone-call', 'title' => '24/7 Support'],
        ] as $intro)
            <div class="bg-white text-center 
                p-2 sm:p-4 
                shadow-sm 
                border-0 sm:border">

                <div class="mb-1 sm:mb-3">
                   <div class="mb-1 sm:mb-3 flex justify-center">
                    <div class="rounded-full bg-black 
                        w-12 h-12 sm:w-16 sm:h-16 
                        flex items-center justify-center">

                        <i class="bx {{ $intro['icon'] }} 
                            text-white 
                            text-2xl sm:text-4xl">
                        </i>

                    </div>
                </div>


                </div>

                <h3 class="font-medium 
                    text-sm sm:text-base 
                    text-gray-800">
                    {{ $intro['title'] }}
                </h3>

            </div>
        @endforeach
    </div>
</section>


 

    {{-- Categories --}}
    <section class="py-12 bg-gray-100">
        <div class="max-w-7xl mx-auto px-4">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Popular Categories</h2>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
                @foreach ($categories as $category)
                    <div class="bg-white p-4 rounded shadow text-center hover:bg-blue-50">
                        <span class="text-lg font-semibold text-gray-700">{{ $category->cat_name }}</span>
                    </div>
                @endforeach
            </div>
        </div> 
    </section>

    {{-- Featured Coupons --}}
    <section class="py-12">
        <div class="max-w-7xl mx-auto px-4">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Featured Coupons</h2>
            <div class="grid grid-cols-1 sm:grid-cols-3 md:grid-cols-4 gap-6">
                @forelse ($coupons as $coupon)
                    <div class="bg-white rounded-lg shadow p-4 hover:shadow-lg transition">
                        @if ($coupon->image)
                            <div class="border relative" style="position: relative;">
                                <img src="{{ url('/assets/coupons/' . $coupon->image) }}" 
                                    alt="{{ $coupon->title }}" 
                                    class="rounded mb-3" 
                                    style="width:100%;height:auto">

                                @if($coupon->remaining_vouchers > "0")
                                    <div class="fquantity px-3 py-2 bg-green-600 text-white text-sm rounded shadow"
                                        title="remaining coupon v/s total coupons"
                                        style="position: absolute; bottom: 10px; right: 10px;">
                                        {{ $coupon->remaining_vouchers." / ".$coupon->total_vouchers }}
                                    </div>
                                @endif
                            </div>
  
                        @endif

                        
                        <h3 class="text-lg font-bold">{{ $coupon->title }}</h3>
                        <!-- <p class="text-sm text-gray-600 mb-2">{{ Str::limit($coupon->details, 80) }}</p> -->
                        <p class="text-blue-600 font-semibold">Ksh {{ number_format($coupon->cost, 2) }}</p>
                        <div class="flex flex-wrap gap-2 my-3">
                            <form action="{{ route('cart.add') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="coupon_id" value="{{ $coupon->id }}">
                                    <button class="bg-green-600 text-white px-4 py-1 rounded">Add to Cart</button>
                                </form>
                            <a href="{{route('coupons.show', $coupon->id)}}" class="block mt-2 text-sm text-blue-500 text-center hover:underline">View Coupon</a>
                        </div>
                    </div>
                @empty
                    <p>No coupons available at the moment.</p>
                @endforelse
            </div>
        </div>
    </section>
    {{-- Active Businesses Section --}}
    <section class="py-12 bg-gray-100">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-gray-800">Our Active Businesses</h2>
                <a href="#" class="text-blue-600 hover:underline text-sm">
                    View All →
                </a>
            </div>

            @if ($businesses->count())
                <div class="grid grid-cols-1 sm:grid-cols-3 md:grid-cols-4 gap-6">
                    @foreach ($businesses as $business)
                        <div class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition text-center">

                            <div class="flex justify-center mb-4">
                                @if ($business->image)
                                    <img 
                                        src="{{ url('assets/business/' . $business->image) }}" 
                                        alt="{{ $business->name }}" 
                                        class="w-2/3 aspect-square object-cover rounded-full border-4 border-white shadow"
                                    >
                                @else
                                    <div class="w-2/3 aspect-square bg-gray-300 rounded-full flex items-center justify-center text-white text-4xl font-bold border-4 border-white shadow">
                                        {{ strtoupper(substr($business->name, 0, 1)) }}
                                    </div>
                                @endif
                            </div>

                            <h3 class="text-xl font-semibold">{{ $business->business_name }}</h3>

                            <p class="text-gray-600 text-sm mb-3">
                                {{ Str::limit($business->bios, 100) ?? 'No description provided.' }}
                            </p>
                           

                            <a href="{{ route('business.show', $business->id) }}" class="text-blue-600 hover:underline text-sm">
                                View Coupons →
                            </a>
                        </div>

                    @endforeach
                </div>
            @else
                <p class="text-gray-500">No active businesses available at the moment.</p>
            @endif
        </div>
    </section>

@endsection
