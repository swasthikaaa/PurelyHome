<x-app-layout>
    {{-- Navbar --}}
    @include('partials.navbar')

    <div class="p-4 pt-8 sm:p-10">
        <div class="max-w-6xl mx-auto">
            <h2 class="text-xl sm:text-2xl font-semibold text-slate-900 mb-6">My Order Tracking</h2>

            @forelse($orders as $order)
                <div class="bg-white rounded-lg shadow-md p-4 sm:p-6 mb-10">
                    <!-- Header -->
                    <div class="flex flex-col sm:flex-row sm:items-center gap-4 sm:gap-6 border-b border-gray-300 pb-4 sm:pb-6">
                        <div class="flex-1">
                            <h3 class="text-lg sm:text-xl font-semibold text-slate-900">Order #{{ $order->_id }}</h3>
                            <p class="text-xs sm:text-sm text-gray-600 mt-2">
                                Status: {{ ucfirst($order->status) }} <br>
                                Date: {{ $order->order_date->timezone('Asia/Colombo')->format('d M Y, h:i A') }}
                            </p>
                        </div>
                        <a href="{{ route('orders.invoice', $order->_id) }}" 
                           class="text-sm sm:text-[15px] font-medium px-4 py-2 sm:py-3 rounded-md bg-indigo-600 hover:bg-indigo-700 text-white tracking-wide text-center">
                           Download Invoice
                        </a>
                    </div>

                    <!-- Tracking Steps -->
                    <div class="mt-6 sm:mt-8 border-b border-gray-300 pb-6">
                        <ul class="grid grid-cols-1 min-[400px]:grid-cols-2 md:grid-cols-4 gap-6">
                            <li class="text-center sm:text-left">
                                <span class="flex h-9 w-9 mb-2 sm:mb-4 items-center justify-center mx-auto sm:mx-0 rounded-full {{ $order->order_date ? 'bg-blue-200' : 'bg-gray-200' }} ring-4 sm:ring-8 ring-white">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 {{ $order->order_date ? 'fill-blue-700' : 'fill-slate-900' }}" viewBox="0 0 24 24">
                                        <path d="M22.05 4.8c-.6-.6-1.5-.6-2.1 0L8.7 16.05 4.05 11.4c-.6-.6-1.5-.6-2.1 0s-.6 1.5 0 2.1l5.7 5.7c.3.3.6.45 1.05.45s.75-.15 1.05-.45l12.3-12.3c.6-.6.6-1.5 0-2.1z"/>
                                    </svg>
                                </span>
                                <h4 class="mb-1 sm:mb-2 text-sm sm:text-[15px] font-semibold text-slate-900">Order placed</h4>
                                <p class="text-xs sm:text-sm text-slate-600">{{ $order->order_date->format('d M Y, h:i A') }}</p>
                            </li>

                            <li class="text-center sm:text-left">
                                <span class="flex h-9 w-9 mb-2 sm:mb-4 items-center justify-center mx-auto sm:mx-0 rounded-full {{ $order->arrived_at ? 'bg-blue-200' : 'bg-gray-200' }} ring-4 sm:ring-8 ring-white">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 {{ $order->arrived_at ? 'fill-blue-700' : 'fill-slate-900' }}" viewBox="0 0 24 24">
                                        <path d="M22.05 4.8c-.6-.6-1.5-.6-2.1 0L8.7 16.05 4.05 11.4c-.6-.6-1.5-.6-2.1 0s-.6 1.5 0 2.1l5.7 5.7c.3.3.6.45 1.05.45s.75-.15 1.05-.45l12.3-12.3c.6-.6.6-1.5 0-2.1z"/>
                                    </svg>
                                </span>
                                <h4 class="mb-1 sm:mb-2 text-sm sm:text-[15px] font-semibold text-slate-900">Arrived at courier</h4>
                                <p class="text-xs sm:text-sm text-slate-600">{{ $order->arrived_at ?? 'Pending' }}</p>
                            </li>

                            <li class="text-center sm:text-left">
                                <span class="flex h-9 w-9 mb-2 sm:mb-4 items-center justify-center mx-auto sm:mx-0 rounded-full {{ $order->out_for_delivery_at ? 'bg-blue-200' : 'bg-gray-200' }} ring-4 sm:ring-8 ring-white">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 {{ $order->out_for_delivery_at ? 'fill-blue-700' : 'fill-slate-900' }}" viewBox="0 0 24 24">
                                        <path d="M19 9l-7 7-7-7" stroke="currentColor" stroke-width="2" fill="none"/>
                                    </svg>
                                </span>
                                <h4 class="mb-1 sm:mb-2 text-sm sm:text-[15px] font-semibold text-slate-900">Out for delivery</h4>
                                <p class="text-xs sm:text-sm text-slate-600">{{ $order->out_for_delivery_at ?? 'Pending' }}</p>
                            </li>

                            <li class="text-center sm:text-left">
                                <span class="flex h-9 w-9 mb-2 sm:mb-4 items-center justify-center mx-auto sm:mx-0 rounded-full {{ $order->delivered_at ? 'bg-blue-200' : 'bg-gray-200' }} ring-4 sm:ring-8 ring-white">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 {{ $order->delivered_at ? 'fill-blue-700' : 'fill-slate-900' }}" viewBox="0 0 24 24">
                                        <path d="M12 2L2 12h20L12 2z"/>
                                    </svg>
                                </span>
                                <h4 class="mb-1 sm:mb-2 text-sm sm:text-[15px] font-semibold text-slate-900">Delivered</h4>
                                <p class="text-xs sm:text-sm text-slate-600">{{ $order->delivered_at ?? 'Pending' }}</p>
                            </li>
                        </ul>
                    </div>

                    <!-- Products + Billing -->
                    <div class="mt-6 sm:mt-8 grid grid-cols-1 lg:grid-cols-2 gap-8 sm:gap-12">
                        <!-- Products -->
                        <div>
                            <h3 class="text-base font-semibold text-slate-900 border-b border-gray-300 pb-2">Products</h3>
                            <div class="space-y-4 mt-4 sm:mt-6">
                                @foreach($order->orderItems as $item)
                                    <div class="grid grid-cols-1 sm:grid-cols-3 items-center gap-4">
                                        <div class="sm:col-span-2 flex items-center gap-4">
                                            <div class="w-16 h-16 sm:w-20 sm:h-20 shrink-0 bg-gray-100 p-2 rounded-md">
                                                <img src="{{ $item->product?->image ?? 'https://via.placeholder.com/100' }}"
                                                     class="w-full h-full object-contain"/>
                                            </div>
                                            <div>
                                                <h4 class="text-sm sm:text-[15px] font-medium text-slate-900">
                                                    {{ $item->product?->name ?? 'Unknown Product' }}
                                                </h4>
                                                <p class="text-xs text-slate-600 mt-1">Qty: {{ $item->quantity }}</p>
                                            </div>
                                        </div>
                                        <div class="sm:ml-auto">
                                            <h4 class="text-sm sm:text-[15px] font-medium text-slate-900">
                                                Rs {{ $item->price * $item->quantity }}
                                            </h4>
                                        </div>
                                    </div>
                                    <hr class="border-gray-300"/>
                                @endforeach
                            </div>
                        </div>

                        <!-- Billing -->
                        <div class="bg-gray-100 rounded-md p-4 sm:p-6 h-full">
                            <h3 class="text-base font-semibold text-slate-900 border-b border-gray-300 pb-2">Billing details</h3>
                            @php
                                $subtotal = $order->subtotal ?? $order->orderItems->sum(fn($i) => $i->price * $i->quantity);
                                $shipping = $order->shipping ?? 0;
                                $tax = $order->tax ?? round($subtotal * 0.02, 2);
                                $total = $order->total ?? ($subtotal + $shipping + $tax);
                            @endphp
                            <ul class="font-medium mt-4 sm:mt-6 space-y-3 sm:space-y-4">
                                <li class="flex flex-wrap gap-2 sm:gap-4 text-slate-600 text-xs sm:text-sm">
                                    Subtotal <span class="ml-auto text-slate-900 font-semibold">Rs {{ $subtotal }}</span>
                                </li>
                                <li class="flex flex-wrap gap-2 sm:gap-4 text-slate-600 text-xs sm:text-sm">
                                    Shipping <span class="ml-auto text-slate-900 font-semibold">Rs {{ $shipping }}</span>
                                </li>
                                <li class="flex flex-wrap gap-2 sm:gap-4 text-slate-600 text-xs sm:text-sm">
                                    Tax (2%) <span class="ml-auto text-slate-900 font-semibold">Rs {{ $tax }}</span>
                                </li>
                                <hr class="border-gray-300"/>
                                <li class="flex flex-wrap gap-2 sm:gap-4 text-sm sm:text-[15px]">
                                    Total <span class="ml-auto text-slate-900 font-semibold">Rs {{ $total }}</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            @empty
                <div class="bg-yellow-100 text-yellow-800 p-4 rounded text-sm sm:text-base">
                    You have not placed any orders yet.
                </div>
            @endforelse
        </div>
    </div>

    {{-- Footer --}}
    @include('partials.footer')
</x-app-layout>
