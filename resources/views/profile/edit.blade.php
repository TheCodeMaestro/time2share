<x-app-layout>
    <x-slot name="header">
    </x-slot>

    <section class="py-12">
        <section class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <section class="p-4 sm:p-8 bg-white shadow sm:rounded-lg" style="border: 0.25rem solid #bcbebf; border-radius: 0.5rem;">
                <section class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </section>
            </section>

            <section class="p-4 sm:p-8 bg-white shadow sm:rounded-lg" style="border: 0.25rem solid #bcbebf; border-radius: 0.5rem;">
                <section class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </section>
            </section>

            <section class="p-4 sm:p-8 bg-white shadow sm:rounded-lg" style="border: 0.25rem solid #bcbebf; border-radius: 0.5rem;">
                <section class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </section>
            </section>
        </section>
    </section>
</x-app-layout>
