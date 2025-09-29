<x-guest-layout>
    <div class="min-h-screen flex flex-col bg-gray-50">
        <!-- Navbar -->
        <nav class="w-full bg-white shadow-md">
            <div class="flex items-center px-4 py-2">
                <img src="{{ asset('images/purelyhomelogo.png') }}" 
                     alt="PurelyHome Logo" 
                     class="h-14 md:h-16 w-auto object-contain">
            </div>
        </nav>

        <!-- Main Content -->
        <div class="flex flex-1 h-[700px] w-full">
            <!-- Left image -->
            <div class="w-full hidden md:inline-block">
                <img class="h-full w-full object-cover" 
                     src="{{ asset('images/login-side-image.png') }}" 
                     alt="login side image">
            </div>

            <!-- Login form -->
            <div class="w-full flex flex-col items-center justify-center px-6">
                <form method="POST" action="{{ route('login') }}"
                      class="md:w-96 w-80 flex flex-col items-center justify-center bg-white shadow-lg rounded-lg p-8">
                    @csrf

                    <h2 class="text-4xl text-gray-900 font-medium">Welcome Back!</h2>
                    <p class="text-sm text-gray-500/90 mt-3">Please sign in to PurelyHome to continue</p>

                    <!-- Error Message -->
                    @if ($errors->any())
                        <div class="w-full mt-4 bg-red-100 text-red-700 text-sm p-2 rounded">
                            {{ $errors->first() }}
                        </div>
                    @endif

                    <!-- Email -->
                    <div class="w-full mt-6">
                        <input name="email" type="email" placeholder="Email address" value="{{ old('email') }}"
                               class="w-full h-12 px-4 bg-gray-50 border border-gray-200 rounded-lg text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:border-transparent transition-all duration-200" required>
                    </div>

                    <!-- Password -->
                    <div class="w-full mt-6">
                        <input name="password" type="password" placeholder="Password"
                               class="w-full h-12 px-4 bg-gray-50 border border-gray-200 rounded-lg text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:border-transparent transition-all duration-200" required>
                    </div>

                    <!-- Forgot Password -->
                    <div class="w-full flex justify-end mt-2">
                        <a href="{{ route('password.request') }}" 
                           class="text-sm text-black hover:underline">
                            Forgot your password?
                        </a>
                    </div>

                    <!-- Submit -->
                    <button type="submit"
                            class="mt-6 w-full h-11 rounded-lg text-white bg-black hover:bg-gray-800 transition">
                        Login
                    </button>

                    <!-- Register -->
                    <p class="text-gray-500/90 text-sm mt-4">
                        Don’t have an account?
                        <a class="text-black hover:underline" href="{{ route('register') }}">Sign up</a>
                    </p>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>
