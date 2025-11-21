<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard')</title>
   
    <!-- Fonts and Icons -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <!-- Tailwind and Alpine.js -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="//unpkg.com/alpinejs" defer></script>
      @stack('head')
</head>
<body class="bg-gray-100 font-sans">

<div class="flex h-screen">
    {{-- Sidebar --}}
    <aside class="bg-[#131b3c] text-white w-64 flex-shrink-0 hidden md:block">
        <div class="p-4 text-lg font-bold border-b border-gray-700">
            Admin Panel
        </div>
        <nav class="mt-4">
            
                @php                           
                    $role=Auth::user()->getRoleNames()->first();                                                                    
                @endphp                
                            
                @if($role=='business')
                    @include('components.admin.business-dashboard')         
                @endif

                @if($role=='customer')
                    @include('components.admin.client-dashboard')            
                @endif

                @if($role=='admin')
                    @include('components.admin.admin-dashboard')
                @endif
            <a href="#"
               class="block px-4 py-2 hover:bg-gray-800 {{ request()->routeIs('admin.settings') ? 'bg-gray-900' : '' }}">
                Settings
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                    <button type="submit" 
                        class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                        Logout
                    </button>
            </form>
        </nav>
    </aside>

    {{-- Main Content --}}
    <div class="flex flex-col flex-1">
        {{-- Top Navbar --}}
        <header class="bg-white shadow p-4 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <button class="md:hidden p-2 rounded hover:bg-gray-100" id="menu-btn">
                    ☰
                </button>
                <h1 class="text-xl font-bold">@yield('heading', 'Dashboard')</h1>
            </div> 
            

            <div class="flex items-center space-x-6 mr-6">
                <a href="{{ route('home') }}" class="text-gray-700 hover:text-blue-600 font-medium">Home</a>
                <a href="{{ route('coupons.index') }}" class="text-gray-700 hover:text-blue-600 font-medium">Coupons</a>
                <a href="{{ route('business.index') }}" class="text-gray-700 hover:text-blue-600 font-medium">Business</a>    

                <span class="text-gray-300">|</span>

                @guest 
                    <a href="{{ route('login') }}" 
                        class="px-4 py-1 border border-blue-600 text-blue-600 rounded hover:bg-blue-600 hover:text-white transition-colors duration-200">
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

                        <div x-data="{ open: false }" class="relative">
                            {{-- Profile Photo Button --}}
                            <button @click="open = !open" :aria-expanded="open.toString()" class="flex items-center space-x-2 focus:outline-none">
                                <img src="{{ $image && file_exists(public_path($image)) ? asset($image) : asset('images/default-avatar.png') }}" 
                                    alt="Profile" 
                                    class="w-8 h-8 rounded-full object-cover border border-gray-300">
                                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                </svg>
                                <span>{{ $name }}</span>
                            </button>

                            {{-- Dropdown Menu --}}
                            <div x-show="open" @click.outside="open = false" x-transition
                                class="absolute right-0 mt-2 w-40 bg-white border border-gray-200 rounded shadow-lg z-50">
                                <a href="{{ route('dashboard') }}" 
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-50">
                                    Dashboard
                                </a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" 
                                        class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                                        Logout
                                    </button>
                                </form>
                            </div>
                        </div>


                @endguest
            </div>
        </header>

        {{-- Content Area --}}
        <main class="p-6 overflow-auto">
            @yield('content')
        </main>
    </div>
</div>

<script>
    document.getElementById('profile-btn').addEventListener('click', function () {
        document.getElementById('profile-menu').classList.toggle('hidden');
    });
</script>
 @stack('scripts')
</body>
</html>
