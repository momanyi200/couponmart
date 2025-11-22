@php 
    $role = Auth::user()->getRoleNames()->first();
    $active = 'bg-blue-600 text-white';
    $inactive = 'bg-white text-gray-800 border border-gray-300 hover:bg-gray-100';

    // List all menu items once for both dropdown & desktop
    $menuItems = [
        ['name' => 'Running', 'route' => 'admin.coupons.index'],
        ['name' => 'Being Reviewed', 'route' => 'koupsunderreview'],
        ['name' => 'Pending', 'route' => 'admin.pendingcoupons'],
        ['name' => 'Suspend', 'route' => 'admin.coupons.suspended', 'params' => ['status'=>'me']],
        ['name' => 'Matured', 'route' => 'admin.coupons.matured_expired'],
    ];
@endphp

<div class="container mx-auto">

    <!-- MOBILE DROPDOWN (hidden on md+) -->
    <div class="block md:hidden mb-4">
        <select 
            class="w-full p-2 border rounded-lg"
            onchange="if (this.value) window.location.href = this.value;">
            
            @foreach ($menuItems as $item)
                <option 
                    value="{{ route($item['route'], $item['params'] ?? []) }}"
                    {{ request()->routeIs($item['route']) ? 'selected' : '' }}>
                    {{ $item['name'] }}
                </option>
            @endforeach

            @if($role == 'business')
                <option value="{{ route('admin.coupons.create') }}"
                    {{ request()->routeIs('admin.coupons.create') ? 'selected' : '' }}>
                    Add Coupon
                </option>
            @endif
        </select>
    </div>

    <!-- DESKTOP MENU (hidden on small screens) -->
    <ul class="hidden md:flex justify-end space-x-2">

        @foreach ($menuItems as $item)
            <li>
                <a href="{{ route($item['route'], $item['params'] ?? []) }}"
                   class="px-4 py-2 rounded-lg text-sm font-medium
                        {{ request()->routeIs($item['route']) ? $active : $inactive }}">
                    {{ $item['name'] }}
                </a>
            </li>
        @endforeach

        @if($role == 'business')
        <li>
            <a href="{{ route('admin.coupons.create') }}"
                class="px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200
                {{ request()->routeIs('admin.coupons.create') 
                    ? 'bg-green-600 text-white shadow-lg shadow-green-300/40 scale-105' 
                    : 'bg-green-500 text-white hover:bg-green-600 hover:shadow-lg hover:shadow-green-300/40' }}">
                Add Coupon
            </a>
        </li>
        @endif
    </ul>

</div>
