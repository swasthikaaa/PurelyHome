<x-app-layout>
{{-- Navbar --}}
@include('partials.navbar')

{{-- ✅ Wrapper to push content below fixed navbar --}}
<div class="pt-20">

    {{-- Hero / First Section: Our Latest Creations --}}
    <section class="w-full py-12 md:py-16 bg-white text-black">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 text-center">
            <h2 class="text-3xl sm:text-4xl md:text-5xl font-bold">Our Latest Creations at PurelyHome</h2>
            <p class="mt-3 sm:mt-4 text-base sm:text-lg md:text-xl">
                Discover our premium kitchen supplies, home decor, and cleaning essentials—crafted with care for modern homes.
            </p>
        </div>

        {{-- Responsive Cards --}}
        <div class="mt-8 md:mt-10 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 max-w-5xl mx-auto px-4 sm:px-6">
            {{-- Kitchen Supplies --}}
            <div class="relative group h-64 sm:h-72 md:h-[400px] overflow-hidden rounded-lg shadow-md">
                <img class="h-full w-full object-cover object-center transition-transform duration-500 group-hover:scale-105"
                     src="{{ asset('images/about-2.jpg') }}"
                     alt="Kitchen Supplies">
                <div class="absolute inset-0 flex flex-col justify-end p-6 sm:p-8 text-white bg-black/40 opacity-0 group-hover:opacity-100 transition-all duration-300">
                    <h1 class="text-xl sm:text-2xl md:text-3xl font-semibold">Kitchen Supplies</h1>
                    <p class="text-xs sm:text-sm mt-1">High-quality essentials to make your kitchen stylish and functional.</p>
                </div>
            </div>

            {{-- Home Decor --}}
            <div class="relative group h-64 sm:h-72 md:h-[400px] overflow-hidden rounded-lg shadow-md">
                <img class="h-full w-full object-cover object-center transition-transform duration-500 group-hover:scale-105"
                     src="{{ asset('images/about-3.jpg') }}"
                     alt="Home Decor">
                <div class="absolute inset-0 flex flex-col justify-end p-6 sm:p-8 text-white bg-black/40 opacity-0 group-hover:opacity-100 transition-all duration-300">
                    <h1 class="text-xl sm:text-2xl md:text-3xl font-semibold">Home Decor</h1>
                    <p class="text-xs sm:text-sm mt-1">Elegant pieces that add charm and character to every room.</p>
                </div>
            </div>

            {{-- Cleaning Essentials --}}
            <div class="relative group h-64 sm:h-72 md:h-[400px] overflow-hidden rounded-lg shadow-md">
                <img class="h-full w-full object-cover object-center transition-transform duration-500 group-hover:scale-105"
                     src="{{ asset('images/about-1.jpg') }}"
                     alt="Cleaning Essentials">
                <div class="absolute inset-0 flex flex-col justify-end p-6 sm:p-8 text-white bg-black/40 opacity-0 group-hover:opacity-100 transition-all duration-300">
                    <h1 class="text-xl sm:text-2xl md:text-3xl font-semibold">Cleaning Essentials</h1>
                    <p class="text-xs sm:text-sm mt-1">Keep your home spotless with stylish and practical cleaning supplies.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- Features Section --}}
    <section class="max-w-6xl mx-auto px-4 sm:px-6 py-12 md:py-16 grid grid-cols-1 md:grid-cols-3 gap-8">
        <div class="bg-white rounded-xl shadow-lg p-6 sm:p-8 flex flex-col items-center text-center hover:shadow-xl transition-shadow duration-300">
            <div class="p-4 sm:p-6 bg-indigo-50 rounded-full mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 sm:w-12 sm:h-12 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" />
                </svg>
            </div>
            <h3 class="text-base sm:text-lg font-semibold mb-2">Lightning-Fast Service</h3>
            <p class="text-gray-600 text-sm">Quick deliveries and responsive customer service for all orders.</p>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-6 sm:p-8 flex flex-col items-center text-center hover:shadow-xl transition-shadow duration-300">
            <div class="p-4 sm:p-6 bg-blue-50 rounded-full mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 sm:w-12 sm:h-12 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 3C7.03 3 3 7.03 3 12c0 4.97 4.03 9 9 9 4.97 0 9-4.03 9-9 0-4.97-4.03-9-9-9zM9 12h.01M15 12h.01M12 15h.01" />
                </svg>
            </div>
            <h3 class="text-base sm:text-lg font-semibold mb-2">Beautifully Designed Products</h3>
            <p class="text-gray-600 text-sm">Modern, stylish home essentials curated to match your lifestyle.</p>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-6 sm:p-8 flex flex-col items-center text-center hover:shadow-xl transition-shadow duration-300">
            <div class="p-4 sm:p-6 bg-green-50 rounded-full mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 sm:w-12 sm:h-12 text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13l-1.35 2.7a1 1 0 00.9 1.5h12.1a1 1 0 00.9-1.5L17 13M7 13V6h13" />
                </svg>
            </div>
            <h3 class="text-base sm:text-lg font-semibold mb-2">Easy Shopping Experience</h3>
            <p class="text-gray-600 text-sm">Simple checkout, secure payment, and hassle-free returns.</p>
        </div>
    </section>

    {{-- FAQ Section --}}
    <section class="max-w-5xl mx-auto px-4 sm:px-6 py-12 md:py-16">
        <div class="text-center mb-10 md:mb-12">
            <span class="text-gray-400 uppercase tracking-widest text-sm">F.A.Q</span>
            <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold mt-2">Frequently Asked Questions</h2>
            <p class="text-gray-500 mt-3 max-w-2xl mx-auto text-sm sm:text-base">
                Have questions about our products or services? Here are some of the most common ones.
            </p>
        </div>

        <div class="flex flex-col md:flex-row md:gap-12">
            {{-- Left Info Column --}}
            <div class="md:w-1/2 mb-8 md:mb-0 text-center md:text-left">
                <span class="text-gray-400 text-sm">Need help?</span>
                <h3 class="text-xl sm:text-2xl font-bold mt-2 mb-3">Have Any Questions?</h3>
                <p class="text-gray-600 text-sm sm:text-base">
                    We are here to help you with any questions you might have about our products, shipping, or services.
                </p>
                <a href="#" class="inline-block mt-4 px-6 py-3 bg-black text-white rounded-lg transition-colors">
                    Contact Us
                </a>
            </div>

            {{-- Accordion Column --}}
            <div class="md:w-1/2 space-y-4">
                <details class="bg-white rounded-lg shadow p-5 group">
                    <summary class="flex items-center justify-between cursor-pointer text-gray-800 font-semibold group-open:text-blue-600">
                        <span>What products do you offer?</span>
                        <svg class="w-5 h-5 text-gray-400 group-open:rotate-180 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </summary>
                    <p class="mt-3 text-gray-600 text-sm">
                        We sell kitchen supplies, home decor, and cleaning essentials designed for modern homes.
                    </p>
                </details>

                <details class="bg-white rounded-lg shadow p-5 group">
                    <summary class="flex items-center justify-between cursor-pointer text-gray-800 font-semibold group-open:text-blue-600">
                        <span>How can I track my order?</span>
                        <svg class="w-5 h-5 text-gray-400 group-open:rotate-180 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </summary>
                    <p class="mt-3 text-gray-600 text-sm">
                        After purchase, you will receive an email with tracking details and estimated delivery time.
                    </p>
                </details>

                <details class="bg-white rounded-lg shadow p-5 group">
                    <summary class="flex items-center justify-between cursor-pointer text-gray-800 font-semibold group-open:text-blue-600">
                        <span>Do you ship internationally?</span>
                        <svg class="w-5 h-5 text-gray-400 group-open:rotate-180 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </summary>
                    <p class="mt-3 text-gray-600 text-sm">
                        Currently, we ship only within our country. International shipping may be available in the future.
                    </p>
                </details>

                <details class="bg-white rounded-lg shadow p-5 group">
                    <summary class="flex items-center justify-between cursor-pointer text-gray-800 font-semibold group-open:text-blue-600">
                        <span>What payment methods are accepted?</span>
                        <svg class="w-5 h-5 text-gray-400 group-open:rotate-180 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </summary>
                    <p class="mt-3 text-gray-600 text-sm">
                        We accept all major credit/debit cards and PayPal.
                    </p>
                </details>
            </div>
        </div>
    </section>
</div>

{{-- Footer --}}
@include('partials.footer')
</x-app-layout>
