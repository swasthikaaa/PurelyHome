<x-app-layout>
<div>
    {{-- Navbar --}}
    <div class="relative z-50">
        @include('partials.navbar')
    </div>

    <!-- Hero Carousel Section -->
    <section class="w-full relative overflow-hidden"> 
        <div id="carousel" class="flex transition-transform duration-500 ease-in-out">

            <!-- Slide 1: Welcome -->
            <div class="flex-shrink-0 w-full relative">
                <img src="{{ asset('images/Hero1.jpg') }}" alt="Welcome" class="w-full h-screen object-cover">
                <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center px-6">
                    <div class="flex flex-col items-center text-center text-white space-y-6 max-w-2xl">
                        <h1 class="text-4xl md:text-5xl font-bold">Welcome to Purely Home</h1>
                        <p class="text-lg md:text-xl">
                            Discover handcrafted essentials and decor blending tradition with modern design.
                        </p>
                        <a href="{{ route('products.public.index') }}" 
                           class="bg-black text-white px-8 py-3 rounded-lg text-lg font-medium hover:bg-gray-800 transition">
                           Get yours now!
                        </a>
                    </div>
                </div>
            </div>

            <!-- Slide 2: Product Feature -->
            <div class="flex-shrink-0 w-full relative">
                <img src="{{ asset('images/Hero2.jpg') }}" alt="Featured Product" class="w-full h-screen object-cover">
                <div class="absolute inset-0 bg-black bg-opacity-40 flex items-center justify-center">
                    <div class="text-center text-white px-6">
                        <h2 class="text-3xl md:text-4xl font-semibold mb-4">Handcrafted Kitchenware</h2>
                        <p class="text-lg md:text-xl max-w-2xl mx-auto">
                            Elegant designs for your living space, made with love and care.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Slide 3: New Collection -->
            <div class="flex-shrink-0 w-full relative">
                <img src="{{ asset('images/Hero3.jpg') }}" alt="New Collection" class="w-full h-screen object-cover">
                <div class="absolute inset-0 bg-black bg-opacity-40 flex items-center justify-center">
                    <div class="text-center text-white px-6">
                        <h2 class="text-3xl md:text-4xl font-semibold mb-4">New Arrivals</h2>
                        <p class="text-lg md:text-xl max-w-2xl mx-auto">
                            Explore our latest collection crafted for modern homes.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Carousel Controls (fixed for mobile + desktop) -->
        <button id="prev"
            class="absolute bottom-6 md:bottom-auto md:top-1/2 left-4 transform md:-translate-y-1/2 
                   bg-white p-2 md:p-3 rounded-full shadow hover:bg-gray-200 z-10">
            <span class="text-lg md:text-xl">&larr;</span>
        </button>

        <button id="next"
            class="absolute bottom-6 md:bottom-auto md:top-1/2 right-4 transform md:-translate-y-1/2 
                   bg-white p-2 md:p-3 rounded-full shadow hover:bg-gray-200 z-10">
            <span class="text-lg md:text-xl">&rarr;</span>
        </button>
    </section>

    <!-- Latest Creations Section -->
    <section class="w-full py-16 px-6 md:px-16 lg:px-24 bg-white relative z-10">
        <h2 class="text-3xl font-semibold text-gray-900 text-center">Our Latest Creations</h2>
        <p class="mt-2 text-gray-600 text-center">Beautifully crafted essentials just for you</p>
        <div class="mt-10 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8">
            <div class="rounded-xl overflow-hidden shadow hover:shadow-lg transition">
                <img src="{{ asset('images/Latest1.jpg') }}" alt="Home Decor" class="w-full h-64 object-cover">
                <div class="p-4">
                    <h3 class="font-medium text-lg">Stylish Vase</h3>
                    <p class="text-gray-600 text-sm">Minimalist decor for modern homes.</p>
                </div>
            </div>
            <div class="rounded-xl overflow-hidden shadow hover:shadow-lg transition">
                <img src="{{ asset('images/Latest2.jpg') }}" alt="Kitchen Essentials" class="w-full h-64 object-cover">
                <div class="p-4">
                    <h3 class="font-medium text-lg">Premium Kitchen Set</h3>
                    <p class="text-gray-600 text-sm">Elegant and practical kitchen essentials.</p>
                </div>
            </div>
            <div class="rounded-xl overflow-hidden shadow hover:shadow-lg transition">
                <img src="{{ asset('images/Latest3.jpg') }}" alt="Cleaning Supplies" class="w-full h-64 object-cover">
                <div class="p-4">
                    <h3 class="font-medium text-lg">Cleaning Essentials</h3>
                    <p class="text-gray-600 text-sm">Keep your home spotless with style.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Promotional Section -->
<section class="py-16 bg-gray-50 relative z-10">
    <div class="grid grid-cols-1 md:grid-cols-2 max-w-5xl bg-white mx-4 md:mx-auto rounded-xl overflow-hidden shadow-lg">
        
        <!-- Image -->
        <div class="w-full">
            <img src="{{ asset('images/Promo.jpg') }}" 
                 alt="Promotional"
                 class="w-full h-full object-cover md:h-full min-h-[250px] md:min-h-[100%]">
        </div>

        <!-- Text -->
        <div class="flex items-center justify-center p-8 sm:p-10 md:p-16">
            <div class="text-center md:text-left space-y-4">
                <h1 class="text-2xl md:text-3xl font-bold text-gray-900 leading-snug">
                    Don’t miss out on our discounted products.
                </h1>
                <p class="text-gray-600 text-base md:text-lg">
                    Grab amazing discounts on home decor, kitchen essentials, and cleaning supplies today!
                </p>
                <div class="mt-4 flex flex-col sm:flex-row justify-center md:justify-start gap-4">
                    <a href="{{ route('collections') }}" 
                       class="px-6 sm:px-8 py-3 text-sm bg-black text-white rounded-lg text-center hover:bg-gray-800 transition">
                       Check out the products
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>


    {{-- Footer --}}
    @include('partials.footer')
</div>
</x-app-layout>
