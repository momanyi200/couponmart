@php
    $user = Auth::user();
    $role = $user->getRoleNames()->first();
    $userProfile = $role === 'customer' ? $user->profile : null; // Assuming 'profile' is a relationship
    $image = $userProfile && $userProfile->image ? 'assets/users/' . $userProfile->image : null;
    $name = $userProfile->first_name ?? '';
@endphp 
    
<div class="profile-sidebar p-3 bg-white text-start" style="width:250px;">
    <div class="profile-header mb-6 text-center">
       
        @if(file_exists($image) && $image)
            <img src="{{ url($image) }}" class="img-fluid img-thumbnail" alt="Profile Image"/>
        @else
            <i class="bx bx-user img-fluid img-thumbnail"></i>
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
 
    
    <h4 class="title fs-5 text-start mt-4 border-bottom">Dashboard</h4>
   
    <div class="flex flex-col gap-1">
        

        @foreach([
           
            ['route'=>'cart.index','title'=>'My Cart','icon'=>'bx bx-cart-alt'],
            ['route'=>'orders.index', 'title'=>'My Orders','icon'=>'bx bxs-coupon'],
            ['route'=>'dashboard', 'title'=>' Bookmarked Businesses','icon'=>'bx bxs-bookmarks'],
            ['route'=>'messages.index', 'title'=>' Messages','icon'=>'bx bxs-bookmarks'],
            
            ] as $sidebar)            
            
                <a href="{{ route($sidebar['route']) }}"
                   class="px-3 py-2 rounded hover:bg-gray-100 text-gray-700 text-sm">
                   <i class="{{$sidebar['icon']}} mx-1"></i>{{$sidebar['title']}}
                </a>
                            
        @endforeach    
          
    </div> 

    
    <h4 class="title fs-5 text-start mt-4 border-bottom">Wallet</h4>
    <div class="flex flex-col gap-1">
        <a href="{{ route('wallet.index') }}" class="px-3 py-2 rounded hover:bg-gray-100 text-gray-700 text-sm">
            Wallet Details
        </a>
        
    </div>
</div>
