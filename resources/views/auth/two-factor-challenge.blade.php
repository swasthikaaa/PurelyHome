<x-action-section>
    <x-slot name="title">
        {{ __('Two Factor Authentication') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Add additional security to your account using email-based OTP verification.') }}
    </x-slot>

    <x-slot name="content">
        <h3 class="text-lg font-medium text-gray-900">
            {{ __('Two Factor Authentication is enabled via Email OTP.') }}
        </h3>

        <div class="mt-3 max-w-xl text-sm text-gray-600">
            <p>
                {{ __('Whenever you log in, a One-Time Password (OTP) will be sent to your registered email address for verification.') }}
            </p>
        </div>

        <div class="mt-4 max-w-xl text-sm text-gray-800 bg-gray-100 rounded-lg p-4">
            <p class="font-semibold">
                {{ __('Your OTPs will be sent to:') }}
            </p>
            <p class="mt-1 text-gray-900">
                {{ auth()->user()->email }}
            </p>
        </div>

        <div class="mt-5">
            <p class="text-sm text-gray-600">
                {{ __('This method ensures your account is protected using both your password and your email access.') }}
            </p>
        </div>
    </x-slot>
</x-action-section>
