<div>
    {{-- Navbar --}}
    @include('partials.navbar')

    {{-- Full-width Exclusive Offer Banner --}}
    <div class="mt-20 w-full bg-black text-white text-center py-3 px-4">
        <p class="text-xs sm:text-sm md:text-base font-medium tracking-wide leading-snug">
            🎉 Enjoy the flat 50% discount on all our premium collections 🎉
        </p>
    </div>

    <!-- Collections Section -->
    <section class="py-12 px-4 sm:px-6 md:px-12 lg:px-16 xl:px-24">
        <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-slate-800 text-center mb-10">
            Our Collections
        </h1>

        @forelse($categories as $category)
            <div class="mb-12">
                <h2 class="text-xl sm:text-2xl font-semibold text-gray-800 mb-6">
                    {{ $category->name }}
                </h2>

                {{-- ✅ Responsive Product Grid --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6">
                    @forelse($category->products as $product)
                        <div class="bg-white shadow rounded-lg overflow-hidden hover:shadow-lg transition">
                            {{-- ✅ Image links to product detail --}}
                            <a href="{{ route('product.show', $product->id) }}">
                                <img src="{{ $product->image ? asset('storage/'.$product->image) : asset('images/default.png') }}"
                                     alt="{{ $product->name }}"
                                     class="h-48 w-full object-cover sm:h-56 md:h-60 lg:h-64">
                            </a>
                            <div class="p-4">
                                {{-- ✅ Price with Offer & Discount Badge --}}
                                @if($product->offer_price && $product->offer_price < $product->price)
                                    <div class="flex flex-wrap items-center gap-2">
                                        <p class="text-sm text-gray-500 line-through">
                                            Rs {{ number_format($product->price, 2) }}
                                        </p>
                                        <p class="text-base sm:text-lg font-semibold text-green-600">
                                            Rs {{ number_format($product->offer_price, 2) }}
                                        </p>
                                        <span class="px-2 py-0.5 bg-red-500 text-white text-xs rounded">
                                            -{{ round((($product->price - $product->offer_price) / $product->price) * 100) }}% OFF
                                        </span>
                                    </div>
                                @else
                                    <p class="text-base sm:text-lg font-medium text-gray-800">
                                        Rs {{ number_format($product->price, 2) }}
                                    </p>
                                @endif

                                {{-- Name + Description --}}
                                <p class="text-base sm:text-lg font-medium text-gray-800 mt-2">
                                    {{ $product->name }}
                                </p>
                                <p class="text-sm text-gray-500">
                                    {{ Str::limit($product->description, 50, '...') }}
                                </p>
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-500">No products in this category yet.</p>
                    @endforelse
                </div>
            </div>
        @empty
            <p class="text-gray-500 text-center">No categories available.</p>
        @endforelse
    </section>

    {{-- Footer --}}
    @include('partials.footer')
</div>
