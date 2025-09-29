<x-app-layout>
    {{-- Navbar --}}
    <div class="relative z-50">
        @include('partials.navbar')
    </div>
    <div class="bg-gray-100 min-h-screen flex items-center justify-center p-4 pt-24">
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden w-full max-w-3xl">
            
            {{-- Header --}}
            <div class="bg-black px-6 py-4">
                <div class="flex items-center justify-between gap-2">
                    <h2 class="text-lg font-semibold text-white">Order Confirmation</h2>
                    <span class="bg-white/20 text-white text-xs font-medium px-2.5 py-1 rounded-full">
                        {{ session('method') === 'cod' ? 'COD' : 'Paid' }}
                    </span>
                </div>
                <p class="text-slate-200 text-sm mt-2">
                    {{ session('method') === 'cod' 
                        ? 'Thank you for choosing Cash on Delivery!' 
                        : 'Thank you for your payment!' }}
                </p>
            </div>

            {{-- Order Details --}}
            <div class="p-6">
                <div class="flex flex-wrap justify-between items-center gap-4">
                    <div>
                        <p class="text-slate-500 text-sm font-medium">Order Number</p>
                        <p class="text-slate-900 text-sm font-medium mt-2">
                            {{ $order->_id }}
                        </p>
                    </div>
                    <div>
                        <p class="text-slate-500 text-sm font-medium">Date</p>
                        <p class="text-slate-900 text-sm font-medium mt-2">
                            {{ $order->order_date?->timezone('Asia/Colombo')->format('M d, Y h:i A') }}
                        </p>
                    </div>
                    <div>
                        <p class="text-slate-500 text-sm font-medium">Total</p>
                        <p class="text-sm font-medium text-indigo-700 mt-2">
                            Rs {{ $order->orderItems->sum(fn($i) => $i->price * $i->quantity) }}
                        </p>
                    </div>
                </div>

                {{-- Shipping Info --}}
                <div class="bg-gray-100 rounded-xl p-4 mt-8">
                    <h3 class="text-base font-medium text-slate-900 mb-6">Shipping Information</h3>
                    <div class="grid sm:grid-cols-2 gap-4">
                        <div>
                            <p class="text-slate-500 text-sm font-medium">Customer</p>
                            <p class="text-slate-900 text-sm font-medium mt-2">
                                {{ $order->user?->name ?? 'Customer' }}
                            </p>
                        </div>
                        <div>
                            <p class="text-slate-500 text-sm font-medium">Shipping Method</p>
                            <p class="text-slate-900 text-sm font-medium mt-2">
                                {{ $order->payment?->method === 'cod' ? 'Cash on Delivery' : 'Card Payment' }}
                            </p>
                        </div>
                        <div>
                            <p class="text-slate-500 text-sm font-medium">Address</p>
                            <p class="text-slate-900 text-sm font-medium mt-2">
                                {{ $order->payment?->address ?? 'No address provided' }}
                            </p>
                        </div>
                        <div>
                            <p class="text-slate-500 text-sm font-medium">Phone</p>
                            <p class="text-slate-900 text-sm font-medium mt-2">
                                {{ $order->payment?->phone ?? 'N/A' }}
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Order Items --}}
                <div class="mt-8">
                    <h3 class="text-base font-medium text-slate-900 mb-6">
                        Order Items ({{ $order->orderItems->count() ?? 0 }})
                    </h3>
                    <div class="space-y-4">
                        @foreach($order->orderItems ?? [] as $item)
                            <div class="flex items-start gap-4 max-sm:flex-col">
                                <div class="w-[80px] h-[80px] bg-gray-200 rounded-lg flex items-center justify-center shrink-0">
                                    <img src="{{ $item->product?->image ?? 'https://via.placeholder.com/80' }}" 
                                         alt="Product" class="w-16 h-16 object-contain rounded-sm" />
                                </div>
                                <div class="flex-1">
                                    <h4 class="text-sm font-medium text-slate-900">
                                        {{ $item->product?->name ?? 'Unknown Product' }}
                                    </h4>
                                    <p class="text-slate-500 text-xs font-medium mt-2">
                                        Qty: {{ $item->quantity ?? 1 }}
                                    </p>
                                </div>
                                <div class="text-right">
                                    <p class="text-slate-900 text-sm font-semibold">
                                        Rs {{ $item->price * $item->quantity }}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Order Summary --}}
                <div class="bg-gray-100 rounded-xl p-4 mt-8">
                    <h3 class="text-base font-medium text-slate-900 mb-6">Order Summary</h3>
                    <div class="space-y-4">
                        <div class="flex justify-between">
                            <p class="text-sm text-slate-500 font-medium">Subtotal</p>
                            <p class="text-slate-900 text-sm font-semibold">
                                Rs {{ $order->orderItems->sum(fn($i) => $i->price * $i->quantity) }}
                            </p>
                        </div>
                        <div class="flex justify-between">
                            <p class="text-sm text-slate-500 font-medium">Shipping</p>
                            <p class="text-slate-900 text-sm font-semibold">Rs 0</p>
                        </div>
                        <div class="flex justify-between pt-3 border-t border-gray-300">
                            <p class="text-[15px] font-semibold text-slate-900">Total</p>
                            <p class="text-[15px] font-semibold text-indigo-700">
                                Rs {{ $order->orderItems->sum(fn($i) => $i->price * $i->quantity) }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Footer --}}
            <div class="bg-gray-100 px-6 py-4">
                <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
                    <p class="text-slate-500 text-sm font-medium">
                        Need help? <a href="#" class="text-black hover:underline">Contact us</a>
                    </p>
                    <a href="{{ route('dashboard') }}" 
                       class="bg-black hover:bg-black text-white font-medium text-[15px] py-2 px-4 rounded-lg cursor-pointer transition duration-200">
                        Go to Dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>
    {{-- Footer --}}
    @include('partials.footer')
</x-app-layout>
