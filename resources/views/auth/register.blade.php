<x-guest-layout>
    <!-- White Navbar with Logo -->
    <nav class="bg-white shadow-sm border-b border-gray-100 fixed top-0 left-0 right-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-center h-20">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <img src="{{ asset('images/purelyhomelogo.png') }}" 
                             alt="Purely Home Logo" 
                             class="block h-16 w-auto" />
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="min-h-screen bg-gray-50 flex items-center justify-center pt-20 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full">
            <!-- Form Card -->
            <div class="bg-white rounded-2xl shadow-xl p-8">
                <!-- Header -->
                <div class="text-center mb-8">
                    <h2 class="text-3xl font-bold text-gray-900 mb-2">Get Started</h2>
                    <p class="text-gray-600">
                        Already have an account? 
                        <a href="{{ route('login') }}" class="text-black hover:text-gray-700 font-semibold">
                            Log in
                        </a>
                    </p>
                </div>

                <!-- Validation Errors -->
                <x-validation-errors class="mb-6" />

                <!-- Registration Form -->
                <form method="POST" action="{{ route('register') }}" class="space-y-4">
                    @csrf

                    <!-- Name Field -->
                    <div>
                        <input 
                            id="name" 
                            type="text" 
                            name="name" 
                            value="{{ old('name') }}" 
                            required 
                            autofocus
                            placeholder="Enter your full name"
                            class="w-full h-12 px-4 bg-gray-50 border border-gray-200 rounded-lg text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:border-transparent transition-all duration-200"
                        />
                    </div>

                    <!-- Email Field -->
                    <div>
                        <input 
                            id="email" 
                            type="email" 
                            name="email" 
                            value="{{ old('email') }}" 
                            required
                            placeholder="Enter your email here"
                            class="w-full h-12 px-4 bg-gray-50 border border-gray-200 rounded-lg text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:border-transparent transition-all duration-200"
                        />
                    </div>

                    <!-- Phone Field -->
                    <div>
                        <input 
                            id="phone" 
                            type="text" 
                            name="phone" 
                            value="{{ old('phone') }}" 
                            required
                            placeholder="Phone Number"
                            class="w-full h-12 px-4 bg-gray-50 border border-gray-200 rounded-lg text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:border-transparent transition-all duration-200"
                        />
                    </div>

                    <!-- Password Field -->
                    <div>
                        <input 
                            id="password" 
                            type="password" 
                            name="password" 
                            required 
                            autocomplete="new-password"
                            placeholder="Setup Password"
                            class="w-full h-12 px-4 bg-gray-50 border border-gray-200 rounded-lg text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:border-transparent transition-all duration-200"
                        />
                    </div>

                    <!-- Confirm Password Field -->
                    <div>
                        <input 
                            id="password_confirmation" 
                            type="password" 
                            name="password_confirmation" 
                            required 
                            autocomplete="new-password"
                            placeholder="Confirm Password"
                            class="w-full h-12 px-4 bg-gray-50 border border-gray-200 rounded-lg text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:border-transparent transition-all duration-200"
                        />
                    </div>

                    <!-- Submit Button -->
                    <div class="pt-4">
                        <button 
                            type="submit"
                            class="w-full h-12 bg-black hover:bg-gray-800 text-white font-semibold rounded-lg transition-all duration-200 transform hover:scale-[1.02] focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2"
                        >
                            Sign Up
                        </button>
                    </div>
                </form>

                <!-- Terms and Conditions -->
                <div class="text-center mt-6">
                    <p class="text-xs text-gray-500 leading-relaxed">
                        By signing up, you agree to our 
                        <a href="#" class="text-black hover:text-gray-700 underline">Terms of Service</a> 
                        and 
                        <a href="#" class="text-black hover:text-gray-700 underline">Privacy Policy</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>