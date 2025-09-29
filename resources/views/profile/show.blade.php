<x-app-layout>
    {{-- Navbar --}}
    @include('partials.navbar')

    <!-- Full-width page container with top padding matching navbar height -->
    <div class="bg-gray-100 pt-20"> {{-- pt-20 = navbar height (80px) --}}

        <!-- Content Sections: Full-width with spacing -->
        <div class="max-w-6xl mx-auto py-12 px-6 space-y-12">

            <!-- Profile Information -->
            <section class="bg-white rounded-2xl p-8 shadow hover:shadow-lg transition">
                <h3 class="text-2xl font-semibold text-gray-800 mb-4">Edit Profile</h3>
                                @livewire('profile.update-profile-information-form')
            </section>

            <!-- Change Password -->
            <section class="bg-white rounded-2xl p-8 shadow hover:shadow-lg transition">
                <h3 class="text-2xl font-semibold text-gray-800 mb-4">Change Password</h3>
                @livewire('profile.update-password-form')
            </section>

            <!-- Browser Sessions -->
            <section class="bg-white rounded-2xl p-8 shadow hover:shadow-lg transition">
                <h3 class="text-2xl font-semibold text-gray-800 mb-4">Browser Sessions</h3>
                @livewire('profile.logout-other-browser-sessions-form')
            </section>

            <!-- Delete Account -->
            <section class="bg-red-50 rounded-2xl p-8 shadow border border-red-200 hover:shadow-lg transition">
                <h3 class="text-2xl font-semibold text-red-600 mb-4">Delete Account</h3>
                <p class="text-red-500 text-sm mb-6">Once deleted, all your account data will be permanently removed.</p>
                @livewire('profile.delete-user-form')
            </section>

        </div>
    </div>

    {{-- Footer --}}
    @include('partials.footer')
</x-app-layout>
