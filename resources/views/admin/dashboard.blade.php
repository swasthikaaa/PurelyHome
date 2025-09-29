<x-app-layout>
    <div class="min-h-screen flex bg-gray-50 text-gray-900">
        <!-- Sidebar -->
        <aside class="w-64 bg-white border-r border-gray-200 flex flex-col shadow-sm">
            <!-- Logo -->
            <div class="h-16 flex items-center justify-center border-b">
                <img src="{{ asset('images/purelyhomelogo.png') }}" 
                     alt="PurelyHome Logo" 
                     class="h-12 w-auto object-contain">
            </div>

            <!-- Sidebar Nav -->
            <nav class="flex-1 p-4 space-y-2">
                <a href="{{ route('admin.dashboard') }}"
                   class="flex items-center px-4 py-2 rounded-lg hover:bg-gray-100 {{ request()->routeIs('admin.dashboard') ? 'bg-gray-200 font-semibold' : '' }}">
                    Dashboard
                </a>
                <a href="{{ route('admin.products.index') }}"
                   class="flex items-center px-4 py-2 rounded-lg hover:bg-gray-100 {{ request()->routeIs('admin.products.*') ? 'bg-gray-200 font-semibold' : '' }}">
                    Products
                </a>
                <a href="{{ route('admin.customers.index') }}"
                   class="flex items-center px-4 py-2 rounded-lg hover:bg-gray-100 {{ request()->routeIs('admin.customers.*') ? 'bg-gray-200 font-semibold' : '' }}">
                    Customers
                </a>
                <a href="{{ route('admin.orders.index') }}"
                   class="flex items-center px-4 py-2 rounded-lg hover:bg-gray-100 {{ request()->routeIs('admin.orders.*') ? 'bg-gray-200 font-semibold' : '' }}">
                    Orders
                </a>
            </nav>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col">
            <!-- Top Navbar -->
            <header class="h-16 w-full bg-white border-b flex items-center justify-between px-6 shadow-sm">
                <h1 class="text-lg font-semibold">Admin Dashboard</h1>
                <div class="flex items-center space-x-4">
                    <!-- User -->
                    <div class="flex items-center space-x-2">
                        <div class="w-10 h-10 rounded-full bg-gray-200 flex items-center justify-center text-gray-700 font-bold">
                            {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
                        </div>
                        <span class="font-medium">Hi, {{ Auth::user()->name ?? 'Admin' }}</span>
                    </div>
                    <!-- Logout -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                                class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600 transition text-sm">
                            Logout
                        </button>
                    </form>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 p-6 space-y-6">
                <!-- Stats Cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div class="bg-white rounded-xl shadow p-5">
                        <h3 class="text-sm text-gray-500">Total Products</h3>
                        <p class="text-2xl font-bold mt-1">{{ \App\Models\Product::count() }}</p>
                    </div>

                    <div class="bg-white rounded-xl shadow p-5">
                        <h3 class="text-sm text-gray-500">Total Orders</h3>
                        <p class="text-2xl font-bold mt-1">{{ \App\Models\Order::count() }}</p>
                    </div>

                    <div class="bg-white rounded-xl shadow p-5">
                        <h3 class="text-sm text-gray-500">Customers</h3>
                        <p class="text-2xl font-bold mt-1">{{ \App\Models\User::where('role','customer')->count() }}</p>
                    </div>

                    <div class="bg-white rounded-xl shadow p-5">
                        <h3 class="text-sm text-gray-500">Revenue</h3>
                        <p class="text-2xl font-bold mt-1">
                            Rs {{ \App\Models\Order::with('orderItems')->get()->sum(fn($o) => $o->orderItems->sum(fn($i) => $i->price * $i->quantity)) }}
                        </p>
                    </div>
                </div>

                <!-- Sales + Monthly Target Section -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Sales Forecast -->
                    <div class="bg-white rounded-xl shadow p-6">
                        <h2 class="text-lg font-semibold mb-4">Sales Forecast</h2>
                        <canvas id="salesForecastChart" class="w-full h-64"></canvas>
                    </div>

                    <!-- Monthly Target Progress -->
                    <div class="bg-white rounded-xl shadow p-6 flex flex-col items-center justify-center">
                        <h2 class="text-lg font-semibold mb-4">Monthly Target</h2>
                        <div class="relative w-40 h-40">
                            <canvas id="monthlyTargetChart"></canvas>
                            <div class="absolute inset-0 flex flex-col items-center justify-center">
                                <p class="text-2xl font-bold" id="targetPercent">75.5%</p>
                                <p class="text-sm text-green-600">+10%</p>
                            </div>
                        </div>
                        <p class="mt-3 text-center text-sm text-gray-500">
                            You earned Rs 3287 today, higher than last month. Keep it up!
                        </p>
                    </div>
                </div>
            </main>
        </div>
    </div>        
</x-app-layout>
