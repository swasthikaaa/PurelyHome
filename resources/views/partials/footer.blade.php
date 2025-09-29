<footer class="px-6 md:px-16 lg:px-24 xl:px-32 pt-8 w-full bg-black text-white">
    <div class="flex flex-col md:flex-row justify-between w-full gap-10 border-b border-gray-700 pb-6">
        <div class="md:max-w-96">
            <img class="h-14" src="{{ asset('images/purelyhomelogo.png') }}" alt="Purely Home Logo">
            <p class="mt-6 text-sm text-gray-300">Purely Home brings you handcrafted furniture, home decor, kitchen essentials, and cleaning supplies designed to make your living space both elegant and functional.</p>
        </div>
        <div class="flex-1 flex flex-col md:flex-row items-start md:justify-end gap-10 md:gap-20">
            <div>
                <h2 class="font-semibold mb-5 text-white">Company</h2>
                <ul class="text-sm space-y-2">
                    <li><a href="/" class="hover:text-gray-300">Home</a></li>
                    <li><a href="/about" class="hover:text-gray-300">About Us</a></li>
                    <li><a href="/products" class="hover:text-gray-300">Products</a></li>
                    <li><a href="/contact" class="hover:text-gray-300">Contact Us</a></li>
                    <li><a href="/privacy" class="hover:text-gray-300">Privacy Policy</a></li>
                </ul>
            </div>
            <div>
                <h2 class="font-semibold mb-5 text-white">Subscribe to our newsletter</h2>
                <div class="text-sm space-y-2">
                    <p>Get the latest updates on home essentials, new arrivals, and exclusive offers.</p>
                    <div class="flex flex-col sm:flex-row items-start sm:items-center gap-2 pt-4">
                        <input class="border border-gray-600 placeholder-gray-400 focus:ring-2 ring-white outline-none w-full sm:w-64 h-10 rounded px-3 text-black" type="email" placeholder="Enter your email">
                        <button class="bg-white w-full sm:w-32 h-10 text-black rounded hover:bg-gray-300 transition">Subscribe</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <p class="pt-4 text-center text-xs md:text-sm pb-5 text-gray-400">Copyright 2024 © <a href="/" class="hover:underline">Purely Home</a>. All Rights Reserved.</p>
</footer>
