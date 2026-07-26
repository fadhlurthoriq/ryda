@props(['user', 'size' => 'md'])

@php
    $initials = collect(explode(' ', $user->name))
        ->map(fn ($word) => strtoupper(substr($word, 0, 1)))
        ->take(2)
        ->join('');

    $colors = ['bg-indigo-500', 'bg-emerald-500', 'bg-amber-500', 'bg-rose-500', 'bg-sky-500'];
    $color = $colors[$user->id % count($colors)];

    $sizeClass = match ($size) {
        'sm' => 'w-8 h-8 text-xs',
        'md' => 'w-9 h-9 text-sm',
        'lg' => 'w-16 h-16 text-lg',
        'xl' => 'w-24 h-24 text-2xl',
        default => 'w-9 h-9 text-sm',
    };
@endphp

@if ($user->avatar)
    <img src="{{ asset('storage/' . $user->avatar) }}"
         alt="{{ $user->name }}"
         class="{{ $sizeClass }} rounded-full object-cover flex-shrink-0 aspect-square">
@else
    <div class="{{ $sizeClass }} rounded-full {{ $color }} flex items-center justify-center text-white font-semibold flex-shrink-0 aspect-square">
        {{ $initials }}
    </div>
@endif