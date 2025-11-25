@php
    $user_id = Auth::user()->id;
    $role = Auth::user()->getRoleNames()->first();
    $image = "";
    $name = "admin";
    $user = App\Models\User::find($user_id);

    $globalUnread = \App\Models\Message::where('is_read', false)
                                        ->where('sender_id', '!=', auth()->id())
                                        ->whereHas('conversation.participants', function ($q) {
                                            $q->where('user_id', auth()->id());
                                        })
                                        ->count();
@endphp 

<div class="w-56 p-5 bg-white text-left shadow-md rounded-lg">
    <div class="mb-6 text-left"> 
        @if(file_exists($image) && $image)
            <img src="{{ $image }}" class="w-32 h-32 object-cover rounded-full mx-auto border border-gray-300" />
        @else
            <div class="w-32 h-32 flex items-center justify-center rounded-full bg-gray-100 mx-auto border border-gray-300 text-gray-500">
                <i class="bx bx-user text-6xl"></i>
            </div>
        @endif

        <p class="text-center mt-2">
            <a href="{{ url('updateprofpic') }}" class="text-sm text-blue-600 hover:underline">
                Change profile pic
            </a>
        </p>
        <h3 class="text-center text-lg font-medium mt-2">{{ $name }}</h3>
    </div>

    <h4 class="text-gray-700 font-semibold mb-2">Dashboard</h4>

    <div class="text-gray-600 text-sm mb-4">
        Wallet Bal: <span class="font-bold">{{ \App\Models\Wallet::system()->balance }} </span> Kes
    </div>

    <nav class="space-y-1">
        <a href="#" class="block px-3 py-2 rounded-md hover:bg-gray-100">Home</a>
        <a href="{{route('admin.coupons.index')}}" class="block px-3 py-2 rounded-md hover:bg-gray-100">View all Coupons</a>
        <a href="{{ route('towns.index') }}" class="block px-3 py-2 rounded-md hover:bg-gray-100">Town</a>
        <a href="{{ route('categories.index') }}" class="block px-3 py-2 rounded-md hover:bg-gray-100">Category</a>
        <a href="{{ route('admin.business.index')}}" class="block px-3 py-2 rounded-md hover:bg-gray-100">Business</a>
        <a href="{{ route('user-profiles.index')}}" class="block px-3 py-2 rounded-md hover:bg-gray-100">Normal users</a>
        <a href="{{ route('system-charges.index')}}" class="block px-3 py-2 rounded-md hover:bg-gray-100">
            System Charges and Cash Back
        </a>
        <a href="{{ route('orders.index')}}" class="block px-3 py-2 rounded-md hover:bg-gray-100">
            Orders
        </a>

         <a href="{{ route('messages.index')}}" class="relative block px-3 py-2 rounded-md hover:bg-gray-100">
            Messages
            @if($globalUnread > 0)
                <span class="absolute -top-1 -right-3 bg-red-600 text-white text-xs px-2 py-0.5 rounded-full">
                    {{ $globalUnread }}
                </span>
            @endif
        </a>
    </nav>

    <h4 class="text-gray-700 font-semibold mt-6 mb-2">Wallet</h4>
    <a href="{{ route('wallet.index') }}" class="flex items-center px-3 py-2 rounded-md hover:bg-gray-100">
        <i class="bx bxs-coupon mr-2"></i> Details
    </a>
</div>
