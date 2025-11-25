<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('title', 'Coupon Seller')</title>

    <!-- Fonts and Icons -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <!-- Tailwind and Alpine.js -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="//unpkg.com/alpinejs" defer></script>

    @stack('head')
</head> 
<body class="bg-gray-100 text-gray-900">

    <!-- Navbar -->
<nav class="bg-white shadow" x-data="{ mobileMenu: false, open: false }">
    <div class="max-w-7xl mx-auto px-4 py-3 flex justify-between items-center">

        <!-- Logo -->
        <a href="{{ url('/') }}" class="text-xl font-bold text-blue-600">
            CouponSeller
        </a>

        <!-- Mobile Menu Button -->
        <button @click="mobileMenu = !mobileMenu" class="md:hidden text-gray-600 focus:outline-none">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
        </button>
        
        @php
            $user = Auth::user();
            $role = $user ? $user->getRoleNames()->first() : null;
            $image = '';
            $name = '';

            if ($role === 'business') {
                $imagePath = optional($user->business)->image;
                $image = $imagePath ? 'assets/business/'.$imagePath : '';
                $name = optional($user->business)->business_name ?? 'Business User';
            }

            if ($role === 'customer') {
                $imagePath = optional($user->profile)->image;
                $image = $imagePath ? 'assets/users/'.$imagePath : '';
                $name = optional($user->profile)->first_name ?? 'Customer';
            }
        
            $globalUnread = \App\Models\Message::where('is_read', false)
                ->where('sender_id', '!=', auth()->id())
                ->whereHas('conversation.participants', function ($q) {
                    $q->where('user_id', auth()->id());
                })
                ->count();
        @endphp



        <!-- Desktop Menu -->
        <div class="hidden md:flex items-center space-x-6">
            <a href="{{ route('home') }}" class="text-gray-700 hover:text-blue-600 font-medium">Home</a>
            <a href="{{ route('coupons.index') }}" class="text-gray-700 hover:text-blue-600 font-medium">Coupons</a>
            <a href="{{ route('business.index') }}" class="text-gray-700 hover:text-blue-600 font-medium">Business</a>

           
            <span class="text-gray-300">|</span>

            @guest
                <a href="{{ route('login') }}"
                    class="px-4 py-1 border border-blue-600 text-blue-600 rounded hover:bg-blue-600 hover:text-white transition">
                    Login
                </a>
            @else

                @if($role === 'customer')
                    <a href="{{ route('cart.index') }}" class="text-gray-700 hover:text-blue-600 font-medium">Cart</a>
                @endif
                <a href="{{ route('messages.index') }}" class="relative text-gray-700 hover:text-blue-600 font-medium">
                    Messages
                    @if($globalUnread > 0)
                        <span class="absolute -top-1 -right-3 bg-red-600 text-white text-xs px-2 py-0.5 rounded-full">
                            {{ $globalUnread }}
                        </span>
                    @endif
                </a>

                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" class="flex items-center space-x-2 focus:outline-none">
                        <img src="{{ $image && file_exists($image) ? asset($image) : asset('images/default-avatar.png') }}"
                            class="w-8 h-8 rounded-full object-cover border"/>

                        <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor"
                             stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                        </svg>

                        <span>{{ $name }}</span>
                    </button>

                    <div x-show="open" @click.outside="open = false" x-transition
                        class="absolute right-0 mt-2 w-40 bg-white border rounded shadow-lg z-50">
                        <a href="{{ route('dashboard') }}"
                           class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-50">
                            Dashboard
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            @endguest
        </div>
    </div>

    <!-- Mobile Menu -->
    <div x-show="mobileMenu" x-transition class="md:hidden bg-white border-t">
        <a href="{{ route('home') }}"
           class="block px-4 py-3 text-gray-700 hover:bg-blue-50">Home</a>
        <a href="{{ route('coupons.index') }}"
           class="block px-4 py-3 text-gray-700 hover:bg-blue-50">Coupons</a>
        <a href="{{ route('business.index') }}"
           class="block px-4 py-3 text-gray-700 hover:bg-blue-50">Business</a>

        @guest
            <a href="{{ route('login') }}"
               class="block mx-4 my-2 text-center px-4 py-2 border border-blue-600 text-blue-600 rounded hover:bg-blue-600 hover:text-white">
               Login
            </a>
        @else
            <div class="px-4 py-3 border-t flex items-center space-x-3">
                <img src="{{ $image && file_exists(public_path($image)) ? asset($image) : asset('images/default-avatar.png') }}"
                    class="w-10 h-10 rounded-full border object-cover"/>
                <span class="font-medium">{{ $name }}</span>
            </div>

            <a href="{{ route('dashboard') }}"
               class="block px-4 py-3 text-gray-700 hover:bg-blue-50">
               Dashboard
            </a>

            <form method="POST" action="{{ route('logout') }}" class="border-t">
                @csrf
                <button class="block w-full text-left px-4 py-3 text-red-600 hover:bg-red-50">
                    Logout
                </button>
            </form>
        @endguest
    </div>
</nav>



    <!-- Flash messages -->
    @if (session('success'))
        <div class="bg-green-100 text-green-800 text-sm p-4 text-center">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="bg-red-100 text-red-800 text-sm p-4 text-center">
            {{ session('error') }}
        </div>
    @endif

    <!-- Main content -->
    <main class="py-8 min-h-[80vh]">
        <div class="max-w-7xl mx-auto px-4  min-h-[90vh]">
            @yield('content')
        </div>
    </main>

    <!-- Footer (optional) -->
    <footer class="bg-white shadow py-4 mt-12">
        <div class="text-center text-sm text-gray-500">
            &copy; {{ now()->year }} CouponSeller. All rights reserved.
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
