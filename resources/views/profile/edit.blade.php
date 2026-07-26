<x-seller-layout>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-avatar-form')
                </div>
            </div>
            
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="md:col-span-2 p-4 sm:p-6 bg-white shadow sm:rounded-lg">
                    @include('profile.partials.delete-user-form')
                </div>

                <div class="p-4 sm:p-6 bg-white shadow sm:rounded-lg flex flex-col justify-between">
                    <div>
                        <h2 class="text-lg font-medium text-gray-900">{{ __('Selesai') }}</h2>
                        <p class="mt-1 text-sm text-gray-600">
                            {{ __('Simpan perubahan dan kembali ke dashboard.') }}
                        </p>
                    </div>
                    <a href="{{ route('seller.dashboard') }}"
                    class="mt-4 inline-flex items-center justify-center text-white bg-indigo-600 hover:bg-indigo-700 font-medium rounded-lg text-sm px-4 py-2.5">
                        Keep Changes
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-seller-layout>
