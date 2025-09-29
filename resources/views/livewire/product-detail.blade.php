<div class="flex flex-col min-h-screen">
    {{-- Navbar --}}
    @include('partials.navbar')

    {{-- Toast Message --}}
    @if($toastMessage)
        <div id="toast"
             class="fixed top-16 left-1/2 transform -translate-x-1/2 bg-green-500 text-white px-4 py-2 rounded shadow-md flex items-center gap-4 z-50 transition-opacity duration-500 opacity-100">
            <span>{{ $toastMessage }}</span>
            <a href="{{ route('cart.index') }}" class="underline font-semibold hover:text-gray-200">View Cart</a>
        </div>
        <script>
            setTimeout(() => {
                const t = document.getElementById('toast');
                if (t) t.style.opacity = '0';
            }, 3000);
        </script>
    @endif

    <main class="flex-grow max-w-6xl w-full px-4 sm:px-6 mx-auto pt-28 pb-20">
        {{-- Breadcrumb --}}
        <p class="text-xs sm:text-sm text-gray-600">
            <span>Home</span> /
            <span> Products</span> /
            <span class="text-indigo-500"> {{ $product->name }}</span>
        </p>

        <div class="flex flex-col md:flex-row gap-8 md:gap-16 mt-4">
            {{-- Image gallery --}}
            <div class="flex flex-col sm:flex-row gap-4 w-full md:w-1/2">
                {{-- Thumbnails --}}
                <div class="flex sm:flex-col gap-3 sm:w-24">
                    @php
                        $images = [$product->image, $product->image2, $product->image3, $product->image4];
                        $images = array_filter($images);
                    @endphp

                    @foreach($images as $img)
                        <div wire:click="setThumbnail('{{ asset('storage/'.$img) }}')"
                             class="border border-gray-500/30 rounded overflow-hidden cursor-pointer flex-shrink-0 w-20 h-20 sm:w-full sm:h-auto">
                            <img src="{{ asset('storage/'.$img) }}" alt="Thumbnail" class="w-full h-full object-cover">
                        </div>
                    @endforeach
                </div>

                {{-- Main Image --}}
                <div class="flex-1 border border-gray-500/30 rounded overflow-hidden">
                    <img src="{{ $thumbnail }}" alt="Selected product" class="w-full h-full object-cover">
                </div>
            </div>

            {{-- Details --}}
            <div class="text-sm w-full md:w-1/2">
                <h1 class="text-2xl sm:text-3xl font-medium">{{ $product->name }}</h1>

                <div class="mt-4 sm:mt-6">
                    @if($product->offer_price)
                        <p class="text-gray-500/70 line-through text-sm sm:text-base">
                            Rs {{ number_format($product->price,2) }}
                        </p>
                        <p class="text-xl sm:text-2xl font-medium">
                            Rs {{ number_format($product->offer_price,2) }}
                        </p>
                    @else
                        <p class="text-xl sm:text-2xl font-medium">
                            Rs {{ number_format($product->price,2) }}
                        </p>
                    @endif
                    <span class="text-gray-500/70 text-xs sm:text-sm">(inclusive of all taxes)</span>
                </div>

                <p class="text-base font-medium mt-6">About Product</p>
                <p class="text-gray-600 text-sm sm:text-base">{{ $product->description }}</p>

                <div class="flex flex-col sm:flex-row items-stretch mt-8 gap-3 text-base">
                    <button wire:click="addToCart({{ $product->id }})"
                            class="w-full py-3 cursor-pointer font-medium bg-gray-100 text-gray-800/80 hover:bg-gray-200 transition">
                        Add to Cart
                    </button>
                    <button wire:click="buyNow({{ $product->id }})"
                            class="w-full py-3 cursor-pointer font-medium bg-black text-white hover:bg-black/90 transition">
                        Buy now
                    </button>
                </div>
            </div>
        </div>
    </main>

    {{-- Footer always at bottom --}}
    <footer class="mt-auto">
        @include('partials.footer')
    </footer>
</div>
