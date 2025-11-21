@php
    $user = Auth::user();
    $business = $user->business;
    $image = $business && $business->image ? 'assets/business/' . $business->image : null;
    $name = $business->business_name ?? 'Your Business';
@endphp

<div class="p-4 bg-white text-start overflow-auto w-full md:w-64 rounded shadow">
    <!-- Profile Header -->
    <div class="mb-6 text-center">
        @if($image && file_exists(public_path($image)))
            <img src="{{ url($image) }}" class="mx-auto w-24 h-24 rounded-full border shadow object-cover" alt="Profile Picture" />
        @else
            <div class="mx-auto w-24 h-24 flex items-center justify-center rounded-full border bg-gray-100 text-gray-500 text-4xl shadow">
                <i class='bx bx-user'></i>
            </div>
        @endif
        
        <p class="my-2">
            <a href="{{ route('profile.updateimage') }}" class="text-blue-600 text-sm hover:underline">
                Change Profile Pic
            </a>
        </p>
        <h3 class="font-semibold text-lg">{{ $name }}</h3>
        <div class="mt-1 text-gray-700 text-sm flex items-center justify-center gap-1" title="Wallet balance">
            <i class='bx bxs-wallet text-base'></i>
            {{ number_format($user->wallet_balance, 2) }} Kes
        </div> 
    </div>

    <!-- Dashboard Links -->
    <h4 class="text-base font-semibold border-b pb-1 mb-2">Dashboard</h4>
    <div class="flex flex-col gap-1">
        @foreach([
            ['route'=>'dashboard', 'title'=>'Dashboard'],
            ['route'=>'admin.coupons.index', 'title'=>'Coupons'],
            ['route'=>'order.lookup', 'title'=>'Codes'],
            ['route'=>'order.check', 'title'=>'QR Scanner'],
            ['route'=>'myinterest', 'title'=>'My Interests/Categories'],
            ['route'=>'physicalLocation', 'title'=>'Physical Location'],
        ] as $sidebar)
            <a href="{{ route($sidebar['route']) }}" 
               class="px-3 py-2 rounded hover:bg-gray-100 text-gray-700 text-sm">
                {{ $sidebar['title'] }}
            </a>
        @endforeach
    </div>

    <!-- Wallet Links -->
    <h4 class="mt-4 text-base font-semibold border-b pb-1 mb-2">Wallet</h4>
    <div class="flex flex-col gap-1">
        <a href="{{ route('wallet.index') }}" class="px-3 py-2 rounded hover:bg-gray-100 text-gray-700 text-sm">
            Wallet Details
        </a>
        <a href="#" class="px-3 py-2 rounded hover:bg-gray-100 text-gray-700 text-sm">
            Withdraw
        </a>
    </div>
</div>
