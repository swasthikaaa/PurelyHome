<nav class="w-full border-b border-gray-200 bg-white fixed top-0 left-0 z-50">
    <div class="w-full px-4 sm:px-6 md:px-16 lg:px-24 flex items-center justify-between h-16 md:h-20">
        
        <!-- Logo -->
        <div class="shrink-0 flex items-center">
            <a href="{{ route('dashboard') }}">
                <img src="{{ asset('images/purelyhomelogo.png') }}" 
                     alt="Purely Home Logo" 
                     class="block h-12 md:h-16 w-auto" />
            </a>
        </div>

        <!-- Desktop Navigation -->
        <div class="hidden md:flex space-x-8 text-gray-700 font-medium">
            <a href="{{ route('home') }}" 
               class="hover:text-black {{ request()->routeIs('home') ? 'font-semibold text-black' : '' }}">
               Home
            </a>
            <a href="{{ route('products.public.index') }}" 
               class="hover:text-black {{ request()->routeIs('products.public.index') ? 'font-semibold text-black' : '' }}">
               Products
            </a>
            <a href="{{ route('about') }}" 
               class="hover:text-black {{ request()->routeIs('about') ? 'font-semibold text-black' : '' }}">
               About
            </a>
            <a href="{{ route('collections') }}" 
               class="hover:text-black {{ request()->routeIs('collections') ? 'font-semibold text-black' : '' }}">
               Collections
            </a>
        </div>

        <!-- Desktop Search + Cart + Profile -->
        <div class="hidden md:flex items-center space-x-6">
            <livewire:product-search />
            <livewire:cart.cart-icon />

            @auth
            <div class="relative group">
                <button class="flex items-center space-x-2 text-gray-700 hover:text-black focus:outline-none">
                    <span class="font-medium">{{ Auth::user()->name }}</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div class="absolute right-0 mt-2 w-56 bg-white border rounded-lg shadow-md 
                            opacity-0 group-hover:opacity-100 group-hover:translate-y-1 transform transition z-50">
                    <a href="{{ route('profile.show') }}" 
                       class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profile</a>
                    <a href="{{ route('customer.orders') }}" 
                       class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">My Orders</a>
                    <a href="{{ route('orders.track') }}" 
                       class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Track Orders</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                                class="w-full text-left block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
            @else
                <a href="{{ route('login') }}" class="text-gray-700 hover:text-black">Login</a>
                <a href="{{ route('register') }}" class="text-gray-700 hover:text-black">Register</a>
            @endauth
        </div>

        <!-- Mobile Hamburger -->
        <button id="mobile-menu-button" class="md:hidden text-gray-700 focus:outline-none">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>
    </div>

    <!-- Mobile Menu -->
    <div id="mobile-menu" class="hidden md:hidden bg-white border-t border-gray-200 px-6 py-4 space-y-4">
        <!-- Links -->
        <a href="{{ route('home') }}" 
           class="block text-gray-700 hover:text-black {{ request()->routeIs('home') ? 'font-semibold text-black' : '' }}">
           Home
        </a>
        <a href="{{ route('products.public.index') }}" 
           class="block text-gray-700 hover:text-black {{ request()->routeIs('products.public.index') ? 'font-semibold text-black' : '' }}">
           Products
        </a>
        <a href="{{ route('about') }}" 
           class="block text-gray-700 hover:text-black {{ request()->routeIs('about') ? 'font-semibold text-black' : '' }}">
           About
        </a>
        <a href="{{ route('collections') }}" 
           class="block text-gray-700 hover:text-black {{ request()->routeIs('collections') ? 'font-semibold text-black' : '' }}">
           Collections
        </a>

        <!-- Search + Cart inline -->
        <div class="flex items-center space-x-4">
            <div class="flex-1">
                <livewire:product-search />
            </div>
            <livewire:cart.cart-icon />
        </div>

        <!-- Auth -->
        @auth
            <a href="{{ route('profile.show') }}" class="block text-gray-700 hover:text-black">Profile</a>
            <a href="{{ route('customer.orders') }}" class="block text-gray-700 hover:text-black">My Orders</a>
            <a href="{{ route('orders.track') }}" class="block text-gray-700 hover:text-black">Track Orders</a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="block text-gray-700 hover:text-black">Logout</button>
            </form>
        @else
            <a href="{{ route('login') }}" class="block text-gray-700 hover:text-black">Login</a>
            <a href="{{ route('register') }}" class="block text-gray-700 hover:text-black">Register</a>
        @endauth
    </div>

    <!-- Mobile Script -->
    <script>
        document.getElementById("mobile-menu-button").addEventListener("click", function () {
            const menu = document.getElementById("mobile-menu");
            menu.classList.toggle("hidden");
        });
    </script>
</nav>
