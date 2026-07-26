@props(['title' => null])

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Dashboard' }} - {{ config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 antialiased">

    <!-- Sidebar: fixed, nggak ikut scroll -->
    <aside class="fixed inset-y-0 left-0 w-64 bg-white border-r flex flex-col z-20">
        <div class="h-16 flex items-center px-6 border-b flex-shrink-0">
            <span class="text-lg font-bold text-gray-900">Ryda</span>
        </div>

        <nav class="flex-1 px-3 py-4 space-y-1 overflow-y-auto">
            <a href="{{ route('seller.dashboard') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium
                      {{ request()->routeIs('seller.dashboard') ? 'bg-gray-100 text-gray-900' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 12l2-2m0 0l7-7 7 7m-9-9v9m0 0h6a2 2 0 002-2v-7m-8 9v-9" />
                </svg>
                Dashboard
            </a>
            <a href="{{ route('vehicles.my-vehicles') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium
                      {{ request()->routeIs('vehicles.my-vehicles') ? 'bg-gray-100 text-gray-900' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
                Iklan saya
            </a>
            <a href="{{ route('transactions.index') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium
                      {{ request()->routeIs('transactions.*') ? 'bg-gray-100 text-gray-900' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 10h18M7 15h1m4 0h1m-7 4h12a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
                Transaksi
            </a>
            <a href="{{ route('messages.index') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium
                      {{ request()->routeIs('messages.*') ? 'bg-gray-100 text-gray-900' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                </svg>
                Pesan
            </a>
        </nav>

        <div class="p-3 border-t flex-shrink-0">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                        class="w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-red-500 hover:bg-red-50">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                    Logout
                </button>
            </form>
        </div>
    </aside>

    <!-- Header: fixed, nggak ikut scroll -->
    <header class="fixed top-0 right-0 left-64 h-16 bg-white border-b flex items-center justify-between px-6 z-10">
        <h1 class="text-lg font-semibold text-gray-900">{{ $title ?? 'Dashboard' }}</h1>

        <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 hover:opacity-80">
            <span class="text-sm font-medium text-gray-700">{{ Auth::user()->name }}</span>
            <x-avatar :user="Auth::user()" size="md" />
        </a>
    </header>

    <!-- Konten: cuma ini yang scroll -->
    <main class="ml-64 mt-16 p-6 h-[calc(100vh-4rem)] overflow-y-auto">
        @if (session('success'))
            <script>
                document.addEventListener('DOMContentLoaded', () => showToast(@js(session('success')), 'success'));
            </script>
        @endif
        @if (session('info'))
            <script>
                document.addEventListener('DOMContentLoaded', () => showToast(@js(session('info')), 'info'));
            </script>
        @endif
        @if (session('status') === 'avatar-updated')
            <script>
                document.addEventListener('DOMContentLoaded', () => showToast('Foto profil berhasil diupdate.', 'success'));
            </script>
        @endif
        @if (session('status') === 'avatar-removed')
            <script>
                document.addEventListener('DOMContentLoaded', () => showToast('Foto profil berhasil dihapus.', 'success'));
            </script>
        @endif

        {{ $slot }}
    </main>
</body>
</html>