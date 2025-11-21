@extends('layouts.admin')
 
@section('content')
<div class="container mx-auto px-6">
    <h2 class="text-2xl font-bold mb-6">
        Matured & Expired Coupons
    </h2> 

    <div class="mb-5">
        @include('backend.coupons.tabs')
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($coupons as $coupon) 
            <div class="bg-white rounded-2xl shadow-md border border-gray-200 overflow-hidden">
                 @if ($coupon->image)
                        <div class="border relative">
                            <img src="{{ url('/assets/vouchers/' . $coupon->image) }}" 
                                alt="{{ $coupon->title }}" 
                                class="rounded mb-3" 
                                style="width:100%;height:auto">

                            @if($coupon->remaining_vouchers > "0")
                                <div class="fquantity px-3 py-2 bg-green-600 text-white text-sm rounded shadow"
                                    style="position: absolute; bottom: 10px; right: 10px;">
                                    {{ $coupon->remaining_vouchers." / ".$coupon->total_vouchers }}
                                </div>
                            @endif
                        </div>
                     @endif

                <div class="p-5">
                    <h5 class="text-lg font-semibold text-gray-800">{{ $coupon->title }}</h5>
                    <p class="mt-2 text-sm text-gray-600">
                        {{ Str::limit($coupon->details, 100) }}
                    </p>
                    <p class="text-sm text-gray-600 mt-1">
                        Cost: ${{ number_format($coupon->cost, 2) }}
                    </p>
                    <p class="text-sm text-gray-600 mt-1">
                        Ends: {{ \Carbon\Carbon::parse($coupon->end_date)->format('d M Y') }}
                    </p>
                </div>
                <div class="px-5 py-3 bg-gray-50 border-t flex justify-between items-center">
                    <span class="px-3 py-1 text-xs rounded-full 
                        {{ $coupon->status === 'expired' ? 'bg-red-100 text-red-600' : 'bg-yellow-100 text-yellow-600' }}">
                        {{ ucfirst($coupon->status) }}
                    </span>
                </div>
                <form action="{{ route('admin.coupons.rerun',$coupon) }}" method="GET" class="mt-2 text-start p-4">
                    @csrf
                    
                    <button type="submit" class="px-3 py-1 bg-green-600 text-white rounded hover:bg-green-700">
                        Rerun
                    </button>
                </form>

            </div>
        @empty
            <div class="col-span-full">
                <div class="p-6 bg-yellow-50 text-yellow-700 rounded-lg text-center">
                    No matured or expired coupons found.
                </div>
            </div>
        @endforelse
    </div>
</div>
@endsection
