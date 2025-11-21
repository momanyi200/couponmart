@extends('layouts.admin')

@section('content')

@php 
    $role = Auth::user()->getRoleNames()->first();    
@endphp 

<div class="max-w-7xl mx-auto px-4 py-6">
    <h1 class="text-2xl font-bold mb-6">Coupons</h1>

    <div class="mb-5">
        @include('backend.coupons.tabs')
    </div>

    @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 border border-green-300 text-green-800 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    @if($coupons->count())
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($coupons as $coupon)
                
                <div class="bg-white rounded-lg shadow p-5 border hover:shadow-lg transition">
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
                    <div class="flex justify-between items-center mb-3">
                        <h2 class="text-lg font-semibold text-gray-800">{{ $coupon->title }}</h2>
                        <span class="text-sm px-2 py-1 bg-gray-200 rounded-full">
                            {{ ucfirst($coupon->rerun) }}
                        </span>
                    </div>
                   
                    <p class="text-gray-600 text-sm mb-2">
                        <strong>Categories:</strong>
                    </p>

                    <div class="flex flex-wrap gap-2 mb-4">
                        @forelse($coupon->categories as $cat)
                            <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-xs">
                                {{ $cat->cat_name }}
                            </span>
                        @empty
                            <span class="text-xs text-gray-500 italic">No category</span>
                        @endforelse
                    </div>

                  
                    <div class="flex flex-col gap-3">

                        {{-- First row: Edit + Delete (business only) --}}
                        @if($role == 'business')
                            <div class="flex gap-3">
                                <a href="{{ route('admin.coupons.edit', $coupon) }}"
                                class="w-full bg-yellow-500 text-white px-3 py-2 rounded-lg text-sm text-center
                                        font-medium shadow-sm hover:bg-yellow-600 hover:shadow-md transition">
                                    ✏️ Edit
                                </a>

                                <form action="{{ route('admin.coupons.destroy', $coupon) }}" method="POST"
                                    onsubmit="return confirm('Are you sure you want to delete this coupon?')"
                                    class="w-full">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="w-full bg-red-600 text-white px-3 py-2 rounded-lg text-sm font-medium
                                                shadow-sm hover:bg-red-700 hover:shadow-md transition">
                                        🗑️ Delete
                                    </button>
                                </form>
                            </div>
                        @endif

                        {{-- Second row: Suspend (FULL WIDTH always) --}}
                        @if($role=='admin' || (Auth::id() === $coupon->business->user_id))
                            <button 
                                onclick="openSuspendModal({{ $coupon->id }})"
                                class="w-full bg-gray-800 text-white px-3 py-2 rounded-lg text-sm font-medium
                                    shadow-sm hover:bg-black hover:shadow-md transition">
                                🚫 Suspend
                            </button>
                        @endif

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


<!-- Modal -->
<div id="suspendModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-2xl shadow-lg p-6 w-full max-w-md">
        <h2 class="text-xl font-bold text-gray-800 mb-4">Suspend Coupon</h2>

        <form id="suspendForm" method="POST">
            @csrf
            <textarea 
                name="reason" 
                rows="3" 
                class="w-full border rounded p-2 mb-4" 
                placeholder="Enter suspension reason..." 
                required></textarea>

            <div class="flex justify-end gap-2">
                <button type="button" onclick="closeSuspendModal()" 
                        class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">
                    Cancel
                </button>
                <button type="submit" 
                        class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
                    Suspend
                </button>
            </div>
        </form>
    </div>
</div>

@endsection

<script>
    function openSuspendModal(couponId) {
        let modal = document.getElementById("suspendModal");
        let form = document.getElementById("suspendForm");
        form.action = `/admin/coupons/${couponId}/suspend`; // set form action
        modal.classList.remove("hidden");
        modal.classList.add("flex"); // show modal
    }

    function closeSuspendModal() {
        let modal = document.getElementById("suspendModal");
        modal.classList.remove("flex");
        modal.classList.add("hidden"); // hide modal
    }
</script>
