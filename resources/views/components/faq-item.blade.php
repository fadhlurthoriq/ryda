@props(['question', 'answer'])

<div class="py-4 border-b border-neutral-200 last:border-0" x-data="{ open: false }">
    <button type="button" @click="open = !open" class="w-full flex items-center justify-between text-left">
        <span class="font-medium text-neutral-800">{{ $question }}</span>
        <svg class="w-5 h-5 text-neutral-400 flex-shrink-0 transition-transform" :class="open ? 'rotate-180' : ''"
             fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
        </svg>
    </button>
    <p x-show="open" x-cloak x-transition class="mt-2 text-sm text-neutral-600">
        {{ $answer }}
    </p>
</div>