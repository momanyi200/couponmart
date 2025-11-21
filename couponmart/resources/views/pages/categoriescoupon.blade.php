@extends('layouts.app')

@section('content')

<div class="container mx-auto px-4 py-8">
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        {{-- Sidebar --}}
            <aside class="md:col-span-1 space-y-8">

                {{-- Categories --}}
                <div x-data="{ openCat: false }">
                    <h2 
                        class="text-lg font-bold text-gray-800 mb-4 flex justify-between items-center cursor-pointer md:cursor-default"
                        @click="openCat = !openCat"
                    >
                        Categories
                        <span class="md:hidden">
                            <svg xmlns="http://www.w3.org/2000/svg" 
                                class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </span>
                    </h2>

                    <ul 
                        class="space-y-2 md:block"
                        :class="{'hidden': !openCat, 'block': openCat}"
                        x-cloak
                    >
                        @foreach ($categories as $cat)
                            <li>
                                <a href="{{ route('categories.coupon', $cat->id) }}" 
                                class="text-gray-600 hover:text-green-600">
                                    {{ $cat->cat_name }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>

                {{-- Towns --}}
                <div x-data="{ openTown: false }">
                    <h2 
                        class="text-lg font-bold text-gray-800 mb-4 flex justify-between items-center cursor-pointer md:cursor-default"
                        @click="openTown = !openTown"
                    >
                        Towns
                        <span class="md:hidden">
                            <svg xmlns="http://www.w3.org/2000/svg" 
                                class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </span>
                    </h2>

                    <ul 
                        class="space-y-2 md:block"
                        :class="{'hidden': !openTown, 'block': openTown}"
                        x-cloak
                    >
                        @foreach ($towns as $town)
                            <li>
                                <a href="" 
                                class="text-gray-600 hover:text-green-600">
                                    {{ $town->town_name }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>

            </aside>
        <main class="md:col-span-3">

            <h1 class="text-2xl font-bold text-gray-800 mb-6">
                Coupons in {{ $category->cat_name }}
            </h1>

            
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-6">
                
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
                            <p class="text-sm text-gray-600 mb-2">{{ Str::limit($coupon->details, 80) }}</p>
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
                        <p class="text-gray-500">No coupons available at the moment.</p>
                    @endforelse

            </div>

            <div class="mt-6">
                {{ $coupons->links() }}
            </div>

        </main>
    </div> 
</div>   

@endsection
