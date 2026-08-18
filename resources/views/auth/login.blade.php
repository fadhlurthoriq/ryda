<x-auth-split-layout bg-image="auth-login.png" heading="Halo, selamat datang">

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        <div>
            <label for="email" class="block mb-1.5 text-sm text-gray-700">Email Anda</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                   class="block w-full rounded-xl border border-gray-300 px-4 py-3 text-sm focus:ring-gold focus:border-gold"
                   placeholder="example@email.com">
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
            <label for="password" class="block mb-1.5 text-sm text-gray-700">Password</label>
            <input id="password" type="password" name="password" required autocomplete="current-password"
                   class="block w-full rounded-xl border border-gray-300 px-4 py-3 text-sm focus:ring-gold focus:border-gold"
                   placeholder="********">
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between pt-1">
            <label class="inline-flex items-center gap-2 text-sm text-gray-600">
                <input type="checkbox" name="remember"
                       class="rounded border-gray-300 text-gold focus:ring-gold">
                Remember me
            </label>

            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="text-sm text-gold hover:underline">
                    Forgot Password?
                </a>
            @endif
        </div>

        <button type="submit"
                class="w-full bg-white hover:bg-neutral-50 text-gold-600 font-semibold border-2 border-gold-500 rounded-xl py-3 text-sm mt-2">
            Login
        </button>

        <p class="text-center text-sm text-gray-600 pt-1">
            Masih baru disini? Yuk
            <a href="{{ route('register') }}" class="text-gold font-medium hover:underline">daftar</a>
            dulu
        </p>
    </form>
</x-auth-split-layout>