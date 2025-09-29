<div>
    {{-- Navbar --}}
    @include('partials.navbar')

    {{-- Toast --}}
    @if($toastMessage)
        <div id="toast" class="fixed top-16 left-1/2 transform -translate-x-1/2 bg-green-500 text-white px-4 py-2 rounded shadow-md flex items-center gap-4 z-50 transition-opacity duration-500 opacity-100">
            <span>{{ $toastMessage }}</span>
            <a href="{{ route('cart.index') }}" class="underline font-semibold hover:text-gray-200">View Cart</a>
        </div>
        <script>
            setTimeout(() => {
                const t = document.getElementById('toast');
                if(t) t.style.opacity = '0';
            }, 3000);
        </script>
    @endif

    <div class="pt-20">
        {{-- Search Results --}}
        @if(isset($products))
            <section class="py-16 px-6 md:px-16 lg:px-24">
                <h1 class="text-3xl font-medium text-slate-800 text-center mb-6">
                    Search results for "{{ $searchTerm }}"
                </h1>

                <div class="flex flex-wrap items-center justify-center gap-6">
                    @forelse($products as $item)
                        <div class="flex flex-col bg-white shadow-md w-72">
                            <a href="{{ route('product.show', $item->id) }}">
                                <img class="w-72 h-48 object-cover"
                                     src="{{ $item->image ? asset('storage/'.$item->image) : asset('images/default.png') }}"
                                     alt="{{ $item->name }}">
                            </a>
                            <div class="p-4 text-sm">
                                <p class="text-slate-600">Rs {{ number_format($item->price, 2) }}</p>
                                <p class="text-slate-800 text-base font-medium my-1.5">{{ $item->name }}</p>
                                <p class="text-slate-500">{{ Str::limit($item->description, 60, '...') }}</p>

                                @if($item->quantity > 0)
                                    <div class="grid grid-cols-2 gap-2 mt-3">
                                        <button wire:click="addToCart({{ $item->id }})"
                                                class="bg-slate-100 text-slate-600 py-2 hover:bg-slate-200 transition">
                                            Add to cart
                                        </button>
                                        <button wire:click="buyNow({{ $item->id }})"
                                                class="bg-slate-800 text-white py-2 hover:bg-slate-900 transition">
                                            Buy now
                                        </button>
                                    </div>
                                @else
                                    <div class="mt-3">
                                        <span class="px-4 py-2 bg-red-600 text-white rounded block text-center">
                                            Out of Stock
                                        </span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-500 text-center w-full">No products found.</p>
                    @endforelse
                </div>
            </section>
        @else
            {{-- New Arrivals --}}
            <section class="py-16 px-6 md:px-16 lg:px-24">
                <h1 class="text-3xl font-medium text-slate-800 text-center mb-2">New Arrivals</h1>
                <p class="text-slate-600 mb-10 text-center">
                    Explore the latest additions to our home essentials collection.
                </p>

                <div class="flex flex-wrap items-center justify-center gap-6">
                    @foreach($newArrivals as $item)
                        <div class="group w-56">
                            <a href="{{ route('product.show', $item->id) }}">
                                <img src="{{ $item->image ? asset('storage/'.$item->image) : asset('images/default.png') }}"
                                     alt="{{ $item->name }}"
                                     class="rounded-lg w-full h-72 object-cover object-top group-hover:shadow-xl transition">
                            </a>
                            <p class="text-sm mt-2 text-gray-700">{{ $item->name }}</p>
                            <p class="text-xl text-gray-900">Rs {{ number_format($item->price, 2) }}</p>

                            @if($item->quantity > 0)
                                <button wire:click="addToCart({{ $item->id }})"
                                        class="bg-slate-100 text-slate-600 py-2 mt-2 w-full hover:bg-slate-200 transition">
                                    Add to cart
                                </button>
                            @else
                                <span class="bg-red-600 text-white py-2 mt-2 w-full inline-block text-center rounded">
                                    Out of Stock
                                </span>
                            @endif
                        </div>
                    @endforeach
                </div>
            </section>

            {{-- Other Products --}}
            <section class="py-16 px-6 md:px-16 lg:px-24 flex flex-wrap justify-center gap-6">
                @foreach($otherProducts as $item)
                    <div class="flex flex-col bg-white shadow-md w-72">
                        <a href="{{ route('product.show', $item->id) }}">
                            <img class="w-72 h-48 object-cover"
                                 src="{{ $item->image ? asset('storage/'.$item->image) : asset('images/default.png') }}"
                                 alt="{{ $item->name }}">
                        </a>
                        <div class="p-4 text-sm">
                            <p class="text-slate-600">Rs {{ number_format($item->price, 2) }}</p>
                            <p class="text-slate-800 text-base font-medium my-1.5">{{ $item->name }}</p>
                            <p class="text-slate-500">{{ Str::limit($item->description, 60, '...') }}</p>

                            @if($item->quantity > 0)
                                <div class="grid grid-cols-2 gap-2 mt-3">
                                    <button wire:click="addToCart({{ $item->id }})"
                                            class="bg-slate-100 text-slate-600 py-2 hover:bg-slate-200 transition">
                                        Add to cart
                                    </button>
                                    <button wire:click="buyNow({{ $item->id }})"
                                            class="bg-slate-800 text-white py-2 hover:bg-slate-900 transition">
                                        Buy now
                                    </button>
                                </div>
                            @else
                                <span class="px-4 py-2 bg-red-600 text-white rounded block text-center mt-3">
                                    Out of Stock
                                </span>
                            @endif
                        </div>
                    </div>
                @endforeach
            </section>
        @endif
    </div>

    {{-- Footer --}}
    @include('partials.footer')
</div>
