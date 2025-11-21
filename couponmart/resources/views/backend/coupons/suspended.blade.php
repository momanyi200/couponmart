@extends('layouts.admin')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-6">
    <h1 class="text-2xl font-bold mb-6">Suspended Coupons</h1>

    
    <div class="mb-5">
        @include('backend.coupons.tabs')
    </div>

    @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 border border-green-300 text-green-800 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

   <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        @forelse($coupons as $coupon)
            @foreach($coupon->suspensions as $suspension)
                <div class="bg-white rounded-2xl shadow-md border border-gray-200 overflow-hidden">
                        @if ($coupon->image)
                            <div class="border relative p-3" style="position: relative;">
                                <img src="{{ url('/assets/coupons/' . $coupon->image) }}" 
                                    alt="{{ $coupon->title }}" 
                                    class="rounded mb-3" 
                                    style="width:100%;height:auto">
                                
                            </div>                       

                        @endif
                    <div class="px-5 py-2">
                        <h6 class="text-lg font-semibold text-gray-800">{{ $coupon->title }}</h6>
                        <p class="mt-2 text-sm text-gray-600">
                            <span class="font-medium">Reason:</span> {{ $suspension->reason }}
                        </p>
                        <p class="text-sm text-gray-600 mt-1">
                            <span class="font-medium">Suspended By:</span>
                            {{ $suspension->user->name }}
                            @if($suspension->user_id === $coupon->business->user_id)
                                <span class="ml-2 px-2 py-0.5 text-xs rounded-full bg-blue-100 text-blue-600">Owner</span>
                            @elseif($suspension->user->hasRole('admin'))
                                <span class="ml-2 px-2 py-0.5 text-xs rounded-full bg-red-100 text-red-600">Admin</span>
                            @else
                                <span class="ml-2 px-2 py-0.5 text-xs rounded-full bg-gray-100 text-gray-600">User</span>
                            @endif
                        </p>
                        <p class="text-sm text-gray-600 mt-1">
                            <span class="font-medium">Suspended At:</span>
                            {{ $suspension->created_at->format('d M Y, H:i') }}
                        </p>
                    </div>

                    <!-- Footer -->
                    <div class="px-5 py-3 bg-gray-50 border-t flex justify-between items-center">
                        @php
                            $user = auth()->user();
                            $canLift = false;

                            if ($suspension->user_id === $coupon->business->user_id && $user->id === $suspension->user_id) {
                                $canLift = true;
                            } elseif ($suspension->user->hasRole('admin') && $user->hasRole('admin')) {
                                $canLift = true;
                            } elseif ($suspension->user_id === $user->id) {
                                $canLift = true;
                            }
                        @endphp

                        @if($canLift)
                            <form action="{{ route('admin.coupons.activate', $coupon->id) }}" method="POST">
                                @csrf
                                <button
                                    class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-lg shadow">
                                    Lift Suspension
                                </button>
                            </form>
                        @else
                            <span class="text-xs text-gray-500">No actions available</span>
                        @endif
                    </div>
                </div>
            @endforeach
        @empty
            <div class="col-span-full">
                <div class="p-6 bg-yellow-50 text-yellow-700 rounded-lg text-center">
                    No suspended coupons found.
                </div>
            </div>
        @endforelse
    </div>

</div>
@endsection
