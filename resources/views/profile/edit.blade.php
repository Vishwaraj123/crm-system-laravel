<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="container-fluid max-w-7xl mx-auto space-y-6">
            <div class="card border-0 shadow-sm rounded-4 overlay-hidden">
                <div class="card-body p-4 sm:p-8">
                    <div class="max-w-xl">
                        <h5 class="fw-bold mb-4 text-dark border-bottom pb-2">{{ __('Update Profile Information') }}</h5>
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm rounded-4 overlay-hidden">
                <div class="card-body p-4 sm:p-8">
                    <div class="max-w-xl">
                        <h5 class="fw-bold mb-4 text-dark border-bottom pb-2">{{ __('Update Password') }}</h5>
                        @include('profile.partials.update-password-form')
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm rounded-4 overlay-hidden">
                <div class="card-body p-4 sm:p-8">
                    <div class="max-w-xl">
                        <h5 class="fw-bold mb-4 text-danger border-bottom pb-2">{{ __('Delete Account') }}</h5>
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
