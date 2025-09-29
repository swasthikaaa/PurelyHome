<div class="flex flex-col min-h-screen">
    {{-- Navbar --}}
    @include('partials.navbar')

    <!-- ✅ Add correct top padding so content is not hidden under navbar -->
    <div class="pt-32 md:pt-28 flex flex-col md:flex-row py-8 md:py-12 max-w-7xl w-full px-4 sm:px-6 mx-auto gap-8 md:gap-10">
        <!-- Left: Cart Items -->
        <div class="flex-1 bg-white shadow-md rounded-lg p-4 sm:p-6">
            <h1 class="text-xl sm:text-2xl font-semibold text-gray-800 mb-4 sm:mb-6 border-b pb-2 sm:pb-4">
                Your Cart <span class="text-sm text-gray-500">({{ $cartItems->count() }} items)</span>
            </h1>

            @forelse ($cartItems as $item)
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between border-b py-4 gap-4"
                     wire:key="cart-item-{{ $item->_id }}">
                    <!-- Product Info -->
                    <div class="flex items-start sm:items-center gap-4 w-full sm:w-auto">
                        <div class="w-20 h-20 border rounded-lg overflow-hidden flex-shrink-0">
                            <img src="{{ $item->product->image 
                                          ? asset('storage/'.$item->product->image) 
                                          : ($item->product->image_url ?? 'https://via.placeholder.com/100') }}"
                                 alt="{{ $item->product->name ?? 'Product' }}"
                                 class="object-cover w-full h-full">
                        </div>
                        <div>
                            <h3 class="text-gray-800 font-medium text-sm sm:text-base">
                                {{ $item->product->name ?? 'Unknown' }}
                            </h3>
                            <div class="flex items-center mt-2">
                                <label class="text-xs sm:text-sm text-gray-500 mr-2">Qty:</label>
                                <select
                                    wire:change="updateQuantity('{{ $item->_id }}', $event.target.value)"
                                    class="border rounded px-2 pr-6 py-1 text-xs sm:text-sm focus:ring-indigo-500 focus:border-indigo-500">
                                    @for ($i = 1; $i <= 10; $i++)
                                        <option value="{{ $i }}" {{ $item->quantity == $i ? 'selected' : '' }}>
                                            {{ $i }}
                                        </option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Price + Remove -->
                    <div class="text-left sm:text-right w-full sm:w-auto">
                        <p class="text-base sm:text-lg font-semibold text-gray-800">
                            Rs {{ (($item->product->offer_price ?? $item->product->price) ?? 0) * $item->quantity }}
                        </p>
                        <button wire:click="removeFromCart('{{ $item->_id }}')"
                                class="text-red-500 text-xs sm:text-sm hover:underline mt-2">
                            Remove
                        </button>
                    </div>
                </div>
            @empty
                <p class="text-gray-500 mt-6 text-sm sm:text-base">Your cart is empty.</p>
            @endforelse

            <a href="{{ route('products.public.index') }}"
               class="inline-flex items-center mt-6 text-black hover:text-black font-medium text-sm">
                ← Continue Shopping
            </a>
        </div>

        <!-- Right: Order Summary -->
        <div class="w-full md:w-1/3 bg-white shadow-md rounded-lg p-4 sm:p-6">
            <h2 class="text-lg sm:text-xl font-semibold text-gray-800 mb-4">Order Summary</h2>

            <div class="space-y-3 text-gray-600 text-sm sm:text-base">
                <div class="flex justify-between">
                    <span>Subtotal</span>
                    <span>
                        Rs {{ $cartItems->sum(fn($i) => (($i->product->offer_price ?? $i->product->price) ?? 0) * $i->quantity) }}
                    </span>
                </div>
                <div class="flex justify-between">
                    <span>Shipping</span>
                    <span class="text-green-600">Free</span>
                </div>
                <div class="flex justify-between">
                    <span>Tax (2%)</span>
                    <span>
                        Rs {{ round($cartItems->sum(fn($i) => (($i->product->offer_price ?? $i->product->price) ?? 0) * $i->quantity) * 0.02, 2) }}
                    </span>
                </div>
                <hr>
                <div class="flex justify-between font-semibold text-gray-800 text-base sm:text-lg">
                    <span>Total</span>
                    <span>
                        Rs {{ round($cartItems->sum(fn($i) => (($i->product->offer_price ?? $i->product->price) ?? 0) * $i->quantity) * 1.02, 2) }}
                    </span>
                </div>
            </div>

            <!-- ✅ Checkout button -->
            <button wire:click="checkout"
                class="block w-full mt-6 py-3 bg-black text-white rounded-lg font-medium text-center hover:bg-gray-900 transition text-sm sm:text-base">
                Checkout
            </button>
        </div>
    </div>

    @include('partials.footer')
</div>
