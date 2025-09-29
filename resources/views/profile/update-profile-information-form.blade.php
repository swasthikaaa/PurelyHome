<div>
    <!-- Profile Info Form -->
    <form wire:submit.prevent="updateProfileInformation" class="space-y-6">
        <!-- Profile Photo -->
        @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
            <div class="flex items-center space-x-6">
                <img class="h-20 w-20 rounded-full object-cover border"
                     src="{{ $this->user->profile_photo_url }}"
                     alt="{{ $this->user->name }}">

                <div>
                    <input type="file" class="hidden" wire:model="photo" x-ref="photo" id="profile_photo" />

                    <x-secondary-button type="button" x-on:click.prevent="$refs.photo.click()">
                        {{ __('Change Photo') }}
                    </x-secondary-button>

                    @if ($this->user->profile_photo_path)
                        <x-secondary-button type="button" wire:click="deleteProfilePhoto">
                            {{ __('Remove') }}
                        </x-secondary-button>
                    @endif

                    <x-input-error for="photo" class="mt-2" />
                </div>
            </div>
        @endif

        <!-- Username -->
        <div>
            <x-label for="name" value="Username" />
            <x-input id="name" type="text" class="mt-1 block w-full"
                     wire:model.defer="state.name" required autofocus />
            <x-input-error for="name" class="mt-2" />
        </div>

        <!-- Email (read-only) -->
        <div>
            <x-label for="email" value="Email" />
            <x-input id="email" type="email"
                     class="mt-1 block w-full bg-gray-100 text-gray-600 cursor-not-allowed"
                     wire:model="state.email" disabled />
        </div>

        <div class="flex justify-end">
            <x-action-message class="me-3" on="saved">
                {{ __('Saved.') }}
            </x-action-message>

            <x-button wire:loading.attr="disabled" wire:target="photo">
                {{ __('Save Changes') }}
            </x-button>
        </div>
    </form>
</div>
