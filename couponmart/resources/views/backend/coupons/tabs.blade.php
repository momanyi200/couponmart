@php 
    $role=Auth::user()->getRoleNames()->first();    
@endphp 
<div class="container mx-auto">
    <ul class="flex justify-end space-x-2">
        <li>
            <a href="{{ route('admin.coupons.index') }}"
               class="px-4 py-2 rounded-lg text-sm font-medium
               {{ \Request::route()->getName() === 'admin.coupons.index' 
                    ? 'bg-blue-600 text-white' 
                    : 'bg-white text-gray-800 border border-gray-300 hover:bg-gray-100' }}">
                Running
            </a>
        </li>

        <li>
            <a href="{{ route('koupsunderreview') }}"
               class="px-4 py-2 rounded-lg text-sm font-medium
               {{ \Request::route()->getName() === 'koupsunderreview' 
                    ? 'bg-blue-600 text-white' 
                    : 'bg-white text-gray-800 border border-gray-300 hover:bg-gray-100' }}">
                Being Reviewed
            </a>
        </li>

        <li>
            <a href="{{ route('admin.pendingcoupons') }}"
               class="px-4 py-2 rounded-lg text-sm font-medium
               {{ \Request::route()->getName() === 'admin.pendingcoupons' 
                    ? 'bg-blue-600 text-white' 
                    : 'bg-white text-gray-800 border border-gray-300 hover:bg-gray-100' }}">
                Pending
            </a>
        </li>

        <li>
            <a href="{{ route('admin.coupons.suspended', ['status'=>'me']) }}"
               class="px-4 py-2 rounded-lg text-sm font-medium
               {{ \Request::route()->getName() === 'admin.coupons.suspended' 
                    ? 'bg-blue-600 text-white' 
                    : 'bg-white text-gray-800 border border-gray-300 hover:bg-gray-100' }}">
                Suspend
            </a>
        </li>

        <li>
            <a href="{{ route('admin.coupons.matured_expired') }}"
               class="px-4 py-2 rounded-lg text-sm font-medium
               {{ \Request::route()->getName() === 'bussexpiredcoup' 
                    ? 'bg-blue-600 text-white' 
                    : 'bg-white text-gray-800 border border-gray-300 hover:bg-gray-100' }}">
                Matured
            </a>
        </li>
        @if($role=='business')
        <li>
            <a href="{{ route('admin.coupons.create') }}"
                class="px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200
                {{ \Request::route()->getName() === 'admin.coupons.create' 
                        ? 'bg-green-600 text-white shadow-lg shadow-green-300/40 scale-105' 
                        : 'bg-green-500 text-white hover:bg-green-600 hover:shadow-lg hover:shadow-blue-300/40' }}">
                    Add Coupon
            </a>

        </li>
        @endif
    </ul>
</div>
