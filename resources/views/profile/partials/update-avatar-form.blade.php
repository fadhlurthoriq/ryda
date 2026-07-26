<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">{{ __('Foto Profil') }}</h2>
        <p class="mt-1 text-sm text-gray-600">{{ __('Update atau hapus foto profil kamu.') }}</p>
    </header>

    <div class="mt-4 flex items-center gap-4">
        <x-avatar :user="auth()->user()" size="xl" />

        <div class="flex-1 space-y-3">
            <form method="POST" action="{{ route('profile.avatar.update') }}" enctype="multipart/form-data">
                @csrf
                @method('patch')

                <input type="file" name="avatar" id="avatar" accept="image/png,image/jpeg,image/jpg"
                       class="block w-full text-sm text-gray-900 border border-gray-300 cursor-pointer bg-gray-50">
                <x-input-error class="mt-2" :messages="$errors->get('avatar')" />

                <div class="flex items-center gap-3 mt-3">
                    <x-primary-button>{{ __('Upload') }}</x-primary-button>

                    @if (session('status') === 'avatar-updated')
                        <p class="text-sm text-gray-600">{{ __('Foto profil berhasil diupdate.') }}</p>
                    @endif
                    @if (session('status') === 'avatar-removed')
                        <p class="text-sm text-gray-600">{{ __('Foto profil berhasil dihapus.') }}</p>
                    @endif
                </div>
            </form>

            @if (auth()->user()->avatar)
                <form id="delete-avatar-form" method="POST" action="{{ route('profile.avatar.destroy') }}">
                    @csrf
                    @method('DELETE')
                </form>

                <button type="button" onclick="confirmDeleteAvatar()" class="text-sm text-red-600 hover:underline">
                    Hapus foto profil
                </button>
            @endif
        </div>
    </div>
</section>

<script>
    function confirmDeleteAvatar() {
        confirmAction({
            title: 'Hapus foto profil?',
            text: 'Foto profil kamu akan dihapus permanen.',
        }).then((confirmed) => {
            if (confirmed) {
                document.getElementById('delete-avatar-form').submit();
            }
        });
    }
</script>