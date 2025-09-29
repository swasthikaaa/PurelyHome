<x-guest-layout>
    <div class="min-h-screen flex flex-col bg-gray-50">
        <!-- Navbar -->
        <nav class="w-full bg-white shadow-md">
            <div class="flex items-center justify-center px-4 py-2">
                <img src="{{ asset('images/purelyhomelogo.png') }}" 
                     alt="PurelyHome Logo" 
                     class="h-14 md:h-16 w-auto object-contain">
            </div>
        </nav>

        <!-- Main Content -->
        <div class="flex flex-1 items-center justify-center px-4">
            <!-- Forgot Password Form Card -->
            <div class="w-full max-w-md bg-white shadow-lg rounded-lg p-8">


                <!-- Title & Info -->
                <h2 class="text-2xl text-gray-900 font-bold text-center">Forgot Password</h2>
                <p class="text-sm text-gray-500/90 text-center mt-2">
                    Enter your email address and we’ll send you a reset link.
                </p>

                <!-- Session Status -->
                @if (session('status'))
                    <div class="mt-4 mb-2 text-sm text-green-600 text-center">
                        {{ session('status') }}
                    </div>
                @endif

                <!-- Validation Errors -->
                <x-validation-errors class="mt-4 mb-2" />

                <!-- Forgot Password Form -->
                <form method="POST" action="{{ route('password.email') }}" class="mt-6">
                    @csrf
                    <!-- Email -->
                    <div class="mb-4">
                        <input id="email" type="email" name="email" placeholder="Email address"
                               value="{{ old('email') }}" required autofocus
                               class="w-full h-12 px-4 border-2 border-black rounded-lg text-gray-900">
                    </div>

                    <!-- Submit Button -->
                    <button type="submit"
                            class="w-full h-11 rounded-lg text-white bg-black hover:bg-gray-800 transition">
                        Email Password Reset Link
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>
