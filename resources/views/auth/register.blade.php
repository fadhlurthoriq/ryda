<x-auth-split-layout bg-image="auth-register.png" heading="Yuk, buat akun dulu">

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <div>
            <label for="name" class="block mb-1.5 text-sm text-gray-700">Nama Lengkap</label>
            <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name"
                   class="block w-full rounded-xl border border-gray-300 px-4 py-3 text-sm focus:ring-gold focus:border-gold"
                   placeholder="Nama kamu">
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div>
            <label for="email" class="block mb-1.5 text-sm text-gray-700">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username"
                   class="block w-full rounded-xl border border-gray-300 px-4 py-3 text-sm focus:ring-gold focus:border-gold"
                   placeholder="example@email.com">
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
            <label for="phone" class="block mb-1.5 text-sm text-gray-700">Nomor HP</label>
            <input id="phone" type="text" name="phone" value="{{ old('phone') }}" required
                   class="block w-full rounded-xl border border-gray-300 px-4 py-3 text-sm focus:ring-gold focus:border-gold"
                   placeholder="08xxxxxxxxxx">
            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
        </div>

        <div class="grid grid-cols-2 gap-3">
            <div>
                <label for="password" class="block mb-1.5 text-sm text-gray-700">Password</label>
                <input id="password" type="password" name="password" required autocomplete="new-password"
                       class="block w-full rounded-xl border border-gray-300 px-4 py-3 text-sm focus:ring-gold focus:border-gold"
                       placeholder="********">
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div>
                <label for="password_confirmation" class="block mb-1.5 text-sm text-gray-700">Konfirmasi</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                       class="block w-full rounded-xl border border-gray-300 px-4 py-3 text-sm focus:ring-gold focus:border-gold"
                       placeholder="********">
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>
        </div>

        <button type="submit"
                class="class= w-full bg-white hover:bg-neutral-50 text-gold-600 font-semibold border-2 border-gold-500 rounded-xl py-3 text-sm mt-2">
            Daftar
        </button>

        <p class="text-center text-sm text-gray-600 pt-1">
            Sudah punya akun? Langsung
            <a href="{{ route('login') }}" class="text-gold font-medium hover:underline">masuk</a>
            aja
        </p>
    </form>
</x-auth-split-layout>