@extends('layouts.admin')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-6">
    <h1 class="text-2xl font-bold mb-6">Pending Coupons</h1>

    
    <div class="mb-5">
        @include('backend.coupons.tabs')
    </div>

    @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 border border-green-300 text-green-800 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    @if($coupons->count())
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($coupons as $coupon)
                <div class="bg-white rounded-lg shadow p-5 border hover:shadow-lg transition">
                     @if ($coupon->image)
                            <div class="border relative" style="position: relative;">
                                <img src="{{ url('/assets/vouchers/' . $coupon->image) }}" 
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
                        @else
                        <div class="text-center py-9">
                          <a class="mx-auto my-6 bg-yellow-500 text-white px-3 py-1 rounded-lg text-sm text-center hover:bg-yellow-600" 
                            href="{{route('admin.coupons.addimage',$coupon->id)}}">Add image</a>
                        </div>    

                        @endif
                    <div class="flex justify-between items-center mb-3">
                        <h2 class="text-lg font-semibold text-gray-800">{{ $coupon->title }}</h2>
                        <span class="text-sm px-2 py-1 bg-gray-200 rounded-full">
                            {{ ucfirst($coupon->rerun) }}
                        </span>
                    </div>
                   
                    <p class="text-gray-600 text-sm mb-3">
                        <strong>Categories:</strong>
                    </p>
                    <div class="flex flex-wrap gap-2 mb-4">
                        @foreach($coupon->categories as $cat)
                            <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-xs">
                                {{ $cat->cat_name }}
                            </span>
                        @endforeach
                    </div>

                    <div class="flex justify-between items-center gap-2">
                        <a href="{{ route('admin.coupons.edit', $coupon) }}"
                        class="w-[46%] bg-yellow-500 text-white px-3 py-1 rounded-lg text-sm text-center hover:bg-yellow-600">
                        Edit
                        </a>

                        <form action="{{ route('admin.coupons.destroy', $coupon) }}" method="POST"
                            onsubmit="return confirm('Are you sure you want to delete this coupon?')" class="w-[46%]">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="w-full bg-red-600 text-white px-3 py-1 rounded-lg text-sm hover:bg-red-700">
                                Delete
                            </button>
                        </form>
                    </div>

                </div>
            @endforeach
        </div>

        <div class="mt-6">
            {{ $coupons->links('pagination::tailwind') }}
        </div>
    @else
        <p class="text-gray-500">No coupons found.</p>
    @endif
</div>
@endsection
