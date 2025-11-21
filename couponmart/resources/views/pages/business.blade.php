@extends('layouts.app')

@section('title', 'Our Business Partners')
@section('meta_keywords', 'business, partners, suppliers, vendors')
@section('meta_description', 'Explore our trusted business partners, suppliers, and vendors that make our services possible.')

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


        {{-- Main Content --}}
        <main class="md:col-span-3">
            <h1 class="text-2xl font-bold text-gray-900 mb-6">Our Business Partners</h1>

            {{-- Example of a business listing grid --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($businesses as $business)
                
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

            {{-- Pagination --}}
            <div class="mt-6">
                {{ $businesses->links() }}
            </div>
        </main>

    </div>

</div>
@endsection
