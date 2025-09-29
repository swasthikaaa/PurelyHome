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
            <!-- Reset Password Form Card -->
            <div class="w-full max-w-md bg-white shadow-lg rounded-lg p-8">
                <!-- Logo Inside Card -->
                <div class="flex justify-center mb-4">
                    <img src="{{ asset('images/purelyhomelogo.png') }}" alt="PurelyHome Logo" class="h-16 w-auto">
                </div>

                <!-- Title & Info -->
                <h2 class="text-2xl text-gray-900 font-bold text-center">Reset Password</h2>
                <p class="text-sm text-gray-500/90 text-center mt-2">
                    Enter your email and new password to reset your account.
                </p>

                <!-- Validation Errors -->
                <x-validation-errors class="mt-4 mb-2" />

                <!-- Reset Password Form -->
                <form method="POST" action="{{ route('password.update') }}" class="mt-6">
                    @csrf
                    <!-- Token -->
                    <input type="hidden" name="token" value="{{ request()->route('token') }}">

                   <input type="hidden" name="email" value="{{ request()->email }}">


                    <!-- Password -->
                    <div class="mb-4">
                        <input id="password" type="password" name="password" placeholder="New Password"
                               required class="w-full h-12 px-4 border-2 border-black rounded-lg text-gray-900">
                    </div>

                    <!-- Confirm Password -->
                    <div class="mb-4">
                        <input id="password_confirmation" type="password" name="password_confirmation" placeholder="Confirm Password"
                               required class="w-full h-12 px-4 border-2 border-black rounded-lg text-gray-900">
                    </div>

                    <!-- Submit Button -->
                    <button type="submit"
                            class="w-full h-11 rounded-lg text-white bg-black hover:bg-gray-800 transition">
                        Reset Password
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>
