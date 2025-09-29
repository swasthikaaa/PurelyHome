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

    <!-- Background -->
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-white to-white relative pt-20">
        <!-- Background overlay -->
        <div class="absolute inset-0 bg-gradient-to-br from-white to-white"></div>
        
        <!-- Card Container -->
        <div class="relative z-10 w-full max-w-md">
            <!-- Main Card -->
            <div class="bg-white rounded-2xl shadow-xl p-8 mx-4 border border-gray-100">
                <!-- Header Icon and Title -->
                <div class="text-center mb-8">
                    <!-- Icon -->
                    <div class="mx-auto w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mb-4">
                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    
                    <!-- Title -->
                    <h2 class="text-2xl font-bold text-gray-800 mb-2">
                        Verification Code
                    </h2>
                    
                    <!-- Subtitle -->
                    <p class="text-gray-600 text-sm leading-relaxed">
                        Enter your 6-digit verification code sent to<br>
                        <span class="font-medium text-gray-800">
                            {{ auth()->check() ? auth()->user()->email : (session('pending_user_email') ?? 'your email address') }}
                        </span>
                    </p>
                </div>

                <!-- Error Messages -->
                @if ($errors->any())
                    <div class="mb-6 p-3 bg-red-50 border border-red-200 rounded-lg">
                        <div class="flex items-center">
                            <svg class="w-4 h-4 text-red-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="text-red-700 text-sm">{{ $errors->first('otp') }}</span>
                        </div>
                    </div>
                @endif

                <!-- OTP Form -->
                <form method="POST" action="{{ route('otp.verify') }}" id="otpForm">
                    @csrf
                    
                    <!-- OTP Input Fields -->
                    <div class="flex justify-center space-x-3 mb-8">
                        @for ($i = 0; $i < 6; $i++)
                            <input 
                                type="text" 
                                class="otp-input w-12 h-12 text-center text-xl font-semibold border-2 border-gray-200 rounded-lg focus:border-green-500 focus:ring-2 focus:ring-green-200 focus:outline-none transition-all duration-200 {{ $errors->has('otp') ? 'border-red-300' : '' }}"
                                maxlength="1"
                                data-index="{{ $i }}"
                                {{ $i === 0 ? 'autofocus' : '' }}
                            >
                        @endfor
                    </div>

                    <!-- Hidden input for the complete OTP -->
                    <input type="hidden" name="otp" id="completeOtp" required>

                    <!-- Submit Button -->
                    <div class="mb-6">
                        <button 
                            type="submit" 
                            id="verifyBtn"
                            class="w-full bg-green-600 hover:bg-green-700 text-white font-semibold py-3 px-6 rounded-lg transition-all duration-200 transform hover:scale-[1.02] focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed disabled:hover:scale-100"
                            disabled
                        >
                            <span class="verify-text">Confirm Code</span>
                            <span class="loading-text hidden">
                                <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white inline" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                Verifying...
                            </span>
                        </button>
                    </div>

                    <!-- Resend Link -->
                    <div class="text-center">
                        <p class="text-gray-600 text-sm mb-2">Didn't receive the code?</p>
                        <button 
                            type="button"
                            class="text-green-600 hover:text-green-700 font-medium text-sm transition-colors duration-200 bg-transparent border-none cursor-pointer"
                            onclick="alert('Please contact support for assistance with resending the code.')"
                        >
                            Resend Code
                        </button>
                    </div>
                </form>
            </div>

            <!-- Additional Info -->
            <div class="text-center mt-6">
                <p class="text-gray-600 text-sm">
                    Having trouble? Contact Support
                </p>
            </div>
        </div>
    </div>

    <!-- JavaScript for OTP functionality -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const otpInputs = document.querySelectorAll('.otp-input');
            const completeOtpInput = document.getElementById('completeOtp');
            const verifyBtn = document.getElementById('verifyBtn');
            const form = document.getElementById('otpForm');

            // OTP Input Logic
            otpInputs.forEach((input, index) => {
                input.addEventListener('input', function(e) {
                    const value = e.target.value;
                    
                    if (value && /^\d$/.test(value)) {
                        // Move to next input
                        if (index < otpInputs.length - 1) {
                            otpInputs[index + 1].focus();
                        }
                    }
                    
                    updateCompleteOtp();
                });

                input.addEventListener('keydown', function(e) {
                    if (e.key === 'Backspace' && !e.target.value && index > 0) {
                        otpInputs[index - 1].focus();
                        otpInputs[index - 1].value = '';
                        updateCompleteOtp();
                    }
                    
                    if (e.key === 'ArrowLeft' && index > 0) {
                        otpInputs[index - 1].focus();
                    }
                    
                    if (e.key === 'ArrowRight' && index < otpInputs.length - 1) {
                        otpInputs[index + 1].focus();
                    }
                });

                input.addEventListener('paste', function(e) {
                    e.preventDefault();
                    const paste = (e.clipboardData || window.clipboardData).getData('text');
                    const digits = paste.replace(/\D/g, '').slice(0, 6);
                    
                    digits.split('').forEach((digit, i) => {
                        if (otpInputs[i]) {
                            otpInputs[i].value = digit;
                        }
                    });
                    
                    updateCompleteOtp();
                    
                    if (digits.length === 6) {
                        otpInputs[5].focus();
                    }
                });
            });

            function updateCompleteOtp() {
                const otp = Array.from(otpInputs).map(input => input.value).join('');
                completeOtpInput.value = otp;
                verifyBtn.disabled = otp.length !== 6;
                
                // Update button style based on completion
                if (otp.length === 6) {
                    verifyBtn.classList.remove('opacity-50');
                    verifyBtn.classList.add('shadow-lg');
                } else {
                    verifyBtn.classList.add('opacity-50');
                    verifyBtn.classList.remove('shadow-lg');
                }
            }

            // Form submission
            form.addEventListener('submit', function(e) {
                const verifyText = document.querySelector('.verify-text');
                const loadingText = document.querySelector('.loading-text');
                
                verifyText.classList.add('hidden');
                loadingText.classList.remove('hidden');
                verifyBtn.disabled = true;
            });

            // Auto-focus first input
            otpInputs[0].focus();
        });
    </script>
</x-guest-layout>