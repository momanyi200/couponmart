<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet">

    <!-- Icons -->
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">

    <!-- Tailwind & Alpine -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="//unpkg.com/alpinejs" defer></script>

    @stack('head')
</head>

<body class="bg-gray-100 font-sans" x-data="{ sidebar: false }">

<div class="flex h-screen">

    <!-- Sidebar -->
    <aside 
        class="bg-[#131b3c] text-white w-64 fixed inset-y-0 left-0 transform md:transform-none 
               transition-transform duration-300 z-50 md:z-auto
               md:translate-x-0" 
        :class="{ '-translate-x-full': !sidebar }">

        <div class="p-4 text-lg font-bold border-b border-gray-700">
            Couponmart
        </div>

        <nav class="mt-4">
            @php $role = Auth::user()->getRoleNames()->first(); @endphp

            @if($role == 'business')
                @include('components.admin.business-dashboard')
            @endif

            @if($role == 'customer')
                @include('components.admin.client-dashboard')
            @endif

            @if($role == 'admin')
                @include('components.admin.admin-dashboard')
            @endif

            <a href="#"
               class="block px-4 py-2 hover:bg-gray-800 {{ request()->routeIs('admin.settings') ? 'bg-gray-900' : '' }}">
                Settings
            </a>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                    Logout
                </button>
            </form>
        </nav>
    </aside>

    <!-- Dark overlay (mobile only) -->
    <div 
        class="fixed inset-0 bg-black bg-opacity-40 z-40 md:hidden" 
        x-show="sidebar" 
        @click="sidebar = false"
        x-transition.opacity>
    </div>

    <!-- Main content -->
    <div class="flex flex-col flex-1 md:ml-64">

        <!-- Top Navbar -->
        <header class="bg-white shadow p-4 flex items-center justify-between">

            <div class="flex items-center gap-3">

                <!-- Hamburger (mobile only) -->
                <button 
                    class="md:hidden p-2 rounded hover:bg-gray-100" 
                    @click="sidebar = true">
                    <i class='bx bx-menu text-2xl'></i>
                </button>

                <h1 class="text-xl font-bold">@yield('heading', 'Couponmart')</h1>
            </div>

            <!-- Right menu -->
            <div class="hidden md:flex items-center space-x-6 mr-6">

                <a href="{{ route('home') }}" class="text-gray-700 hover:text-blue-600 font-medium">Home</a>
                <a href="{{ route('coupons.index') }}" class="text-gray-700 hover:text-blue-600 font-medium">Coupons</a>
                <a href="{{ route('business.index') }}" class="text-gray-700 hover:text-blue-600 font-medium">Business</a>    

                <span class="text-gray-300">|</span>

                @guest
                    <a href="{{ route('login') }}"
                       class="px-4 py-1 border border-blue-600 text-blue-600 rounded hover:bg-blue-600 hover:text-white">
                        Login
                    </a>
                @else
                    @php
                        $role = Auth::user()->getRoleNames()->first();
                        $image = '';
                        $name = '';

                        if ($role === 'business') {
                            $imagePath = optional(Auth::user()->business)->image;
                            $image = $imagePath ? 'assets/business/' . $imagePath : '';
                            $name = optional(Auth::user()->business)->business_name ?? 'Business User';
                        }

                        if ($role === 'customer') {
                            $imagePath = optional(Auth::user()->profile)->image;
                            $image = $imagePath ? 'assets/customer/' . $imagePath : '';
                            $name = optional(Auth::user()->profile)->first_name ?? 'Customer';
                        }
                    @endphp

                    <!-- Profile Dropdown -->
                    <div x-data="{ open: false }" class="relative">

                        <button @click="open = !open" class="flex items-center space-x-2">
                            <img src="{{ $image && file_exists(public_path($image)) ? asset($image) : asset('images/default-avatar.png') }}"
                                 class="w-8 h-8 rounded-full object-cover border border-gray-300">
                            <i class='bx bx-chevron-down text-gray-500'></i>
                            <span>{{ $name }}</span>
                        </button>

                        <div 
                            x-show="open"
                            @click.outside="open = false"
                            x-transition
                            class="absolute right-0 mt-2 w-40 bg-white border border-gray-200 rounded shadow-lg z-50">
                            
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

        </header>

        <!-- Page Content -->
        <main class="p-6 overflow-auto">
            @yield('content')
        </main>
    </div>

</div>


@stack('scripts')
</body>
</html>
