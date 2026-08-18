@props(['bgImage', 'heading' => 'Selamat datang'])

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Ryda') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased">
    <div class="min-h-screen flex bg-neutral-100">

        <!-- Kiri: card form putih -->
        <div class="w-full bg-white lg:w-1/2 flex items-center justify-center px-8 py-12">
            <div class="w-full max-w-md shadow-sm p-8">
                <div class="flex flex-col items-center text-center mb-6">
                    <img src="{{ asset('images/logo.png') }}" alt="Ryda" class="w-28 h-28 object-contain mb-3">
                    <h1 class="text-2xl font-bold text-gray-900">{{ $heading }}</h1>
                </div>

                {{ $slot }}
            </div>
        </div>

        <!-- Kanan: foto -->
        <div class="hidden lg:flex lg:w-1/2 items-center justify-center relative overflow-hidden">
            <img src="{{ asset('images/' . $bgImage) }}" alt=""
                 class="max-w-[85%] max-h-[70vh] w-auto h-auto object-contain">
        </div>
    </div>
</body>
</html>