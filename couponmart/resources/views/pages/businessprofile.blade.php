{{-- resources/views/business/profile.blade.php --}}
@extends('layouts.app')

@section('title', $business->name . ' - Profile')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-6 grid grid-cols-1 md:grid-cols-4 gap-6">

    {{-- Sidebar --}}
    <aside class="bg-white rounded-xl shadow p-4 md:block hidden">
        {{-- Logo --}}
        <div class="flex flex-col items-center mb-4">
            <img 
                src="{{ $business->image ? asset('assets/business/'.$business->image) : asset('images/default-logo.png') }}"
                alt="{{ $business->business_name }}"
                class="w-24 h-24 rounded-full object-cover mb-2 border-2 border-white shadow"
            >
            <h2 class="text-lg font-semibold text-center">{{ $business->business_name }}</h2>
        </div>


        {{-- Quick Actions --}}
        <div class="space-y-2">
            <a href="#overview" class="block px-3 py-2 rounded hover:bg-gray-100">Overview</a>
            <a href="#services" class="block px-3 py-2 rounded hover:bg-gray-100">Services</a>
            <a href="#contact" class="block px-3 py-2 rounded hover:bg-gray-100">Contact</a>
        </div>
    </aside>

    {{-- Main Content --}}
    <main class="md:col-span-3 space-y-6">

        {{-- Business Overview --}}
        <section id="overview" class="bg-white rounded-xl shadow p-6">
            <h3 class="text-xl font-semibold mb-4">About {{ $business->name }}</h3>
            <p class="text-gray-700">
                {{ $business->bios ?? 'No description available.' }}
            </p>
        </section>

        {{-- Services / Products --}}
        <section id="services" class="bg-white rounded-xl shadow p-6">
            <h3 class="text-xl font-semibold mb-4">Our Coupons</h3>
             <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                @forelse ($business->coupons as $coupon)
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
                        <p class="text-sm text-gray-600 mb-2">{{ Str::limit($coupon->bios, 80) }}</p>
                        <p class="text-blue-600 font-semibold">Ksh {{ number_format($coupon->cost, 2) }}</p>
                        <a href="#" class="block mt-2 text-sm text-blue-500 hover:underline">View Coupon</a>
                    </div>
                @empty
                    <p>No coupons available at the moment.</p>
                @endforelse
            </div>
        </section>

        {{-- Contact Info --}}
        <section id="contact" class="bg-white rounded-xl shadow p-6">
            <h3 class="text-xl font-semibold mb-4">Contact Information</h3>
            <ul class="space-y-2 text-gray-700">
                @if($business->phone)
                    <li><strong>Phone:</strong> {{ $business->phone }}</li>
                @endif
                @if($business->email)
                    <li><strong>Email:</strong> {{ $business->email }}</li>
                @endif
                @if($business->address)
                    <li><strong>Address:</strong> {{ $business->address }}</li>
                @endif
                @if($business->website)
                    <li><strong>Website:</strong> 
                        <a href="{{ $business->website }}" target="_blank" class="text-blue-600 hover:underline">
                            {{ $business->website }}
                        </a>
                    </li>
                @endif
            </ul>
        </section>

    </main>
</div>
@endsection
