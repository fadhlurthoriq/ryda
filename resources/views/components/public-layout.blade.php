@props(['title' => null])

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? config('app.name', 'Ryda') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-white">

    <header class="sticky inset-x-0 top-4 z-50 w-full" x-data="{ mobileOpen: false }">
        <nav class="relative mx-4 lg:mx-auto lg:max-w-6xl rounded-full border border-neutral-10 bg-white/50 backdrop-blur-md px-4 py-2.5 flex flex-wrap items-center gap-4 lg:gap-8 shadow-sm">
            <a href="{{ route('vehicles.index') }}" class="flex items-center gap-2 font-bold text-neutral-800">
                <img src="{{ asset('images/logo.png') }}" alt="Ryda" class="h-8 w-8 object-contain">
                Ryda
            </a>

            <div class="hidden md:block md:w-auto ms-4">
                <ul class="flex md:flex-row gap-8 font-medium">
                    <li><a href="{{ route('vehicles.index') }}" class="text-sm text-neutral-600 hover:text-neutral-900">Beranda</a></li>
                    <li><a href="{{ route('vehicles.index') }}" class="text-sm text-neutral-600 hover:text-neutral-900">Mobil</a></li>
                    <li><a href="{{ route('vehicles.index') }}" class="text-sm text-neutral-600 hover:text-neutral-900">Motor</a></li>
                </ul>
            </div>

            <div class="flex gap-2 ml-auto items-center">
                @guest
                    <a href="{{ route('login') }}" class="btn-pill bg-transparent text-neutral-600 hover:text-neutral-900">Login</a>
                    <a href="{{ route('register') }}" class="btn-pill bg-gold-500 text-white hover:bg-gold-600">Register</a>
                @endguest

                @auth
                    <div x-data="{ open: false }" class="relative">
                        <button @click="open = !open" type="button" class="flex items-center">
                            <x-avatar :user="auth()->user()" size="sm" />
                        </button>
                        <div x-show="open" @click.away="open = false" x-cloak
                            class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-xl border border-neutral-200 divide-y divide-neutral-100">
                            <div class="py-1">
                                @if (auth()->user()->isPenjual())
                                    <a href="{{ route('seller.dashboard') }}" class="block px-4 py-2 text-sm text-neutral-700 hover:bg-neutral-50">Dashboard Penjual</a>
                                @endif
                                <a href="{{ route('wishlists.index') }}" class="block px-4 py-2 text-sm text-neutral-700 hover:bg-neutral-50">Wishlist</a>
                                <a href="{{ route('transactions.index') }}" class="block px-4 py-2 text-sm text-neutral-700 hover:bg-neutral-50">Transaksi</a>
                                <a href="{{ route('messages.index') }}" class="block px-4 py-2 text-sm text-neutral-700 hover:bg-neutral-50">Pesan</a>
                                <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-neutral-700 hover:bg-neutral-50">Profil</a>
                            </div>
                            <div class="py-1">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-neutral-50">Logout</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endauth

                <button @click="mobileOpen = !mobileOpen" type="button" class="p-2 md:hidden text-neutral-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>

            <div x-show="mobileOpen" x-cloak
                class="md:hidden absolute top-14 right-2 left-2 border border-neutral-200 rounded-2xl bg-white/90 backdrop-blur-xl shadow-xl overflow-hidden">
                <a href="{{ route('vehicles.index') }}" class="block text-sm text-neutral-600 hover:bg-neutral-100 py-3 px-4">Home</a>
                <a href="{{ route('vehicles.index') }}" class="block text-sm text-neutral-600 hover:bg-neutral-100 py-3 px-4">Mobil</a>
                <a href="{{ route('vehicles.index') }}" class="block text-sm text-neutral-600 hover:bg-neutral-100 py-3 px-4">Motor</a>
            </div>
        </nav>
    </header>

    <main>
        {{ $slot }}
    </main>

    <footer class="pt-6">
        <div class="max-w-6xl mx-auto px-4">
            <div class="flex flex-col md:flex-row justify-between items-center gap-4 py-6">
                <div class="flex items-center gap-2 font-bold text-neutral-800">
                    <img src="{{ asset('images/logo.png') }}" alt="Ryda" class="h-8 w-8 object-contain opacity-80">
                    Ryda
                </div>
                <div class="flex flex-row gap-6 text-sm text-neutral-600">
                    <a href="{{ route('vehicles.index') }}" class="hover:text-gold-600">Mobil</a>
                    <a href="{{ route('vehicles.index') }}" class="hover:text-gold-600">Motor</a>
                    <a href="{{ route('login') }}" class="hover:text-gold-600">Login</a>
                    <a href="{{ route('register') }}" class="hover:text-gold-600">Daftar</a>
                </div>
            </div>

            <div class="border-t border-neutral-200 py-4 text-center">
                <p class="text-sm text-neutral-500">&copy; {{ date('Y') }} Ryda. All rights reserved.</p>
            </div>
        </div>
    </footer>
</body>
</html>