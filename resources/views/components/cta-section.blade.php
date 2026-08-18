@props([
    'badge' => null,
    'title',
    'description' => null,
    'points' => [],
    'buttonLabel' => null,
    'buttonUrl' => null,
    'image',
    'imageAlt' => '',
    'reverse' => false,
])

<section class="py-16 bg-neutral-50">
    <div class="max-w-6xl mx-auto px-4">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">

            <div class="{{ ! $reverse ? 'lg:order-2' : '' }} overflow-hidden">
                <img src="{{ $image }}" alt="{{ $imageAlt }}" class="w-full h-auto object-cover">
            </div>

            <div class="{{ ! $reverse ? 'lg:order-1' : '' }}">
                @if ($badge)
                    <span class="badge-pill">{{ $badge }}</span>
                @endif
                <h2 class="mt-4 text-4xl font-semibold text-neutral-900">{{ $title }}</h2>
                @if ($description)
                    <p class="mt-3 text-neutral-600">{{ $description }}</p>
                @endif

                @if (count($points))
                    <ul class="mt-6 space-y-4">
                        @foreach ($points as $point)
                            <li class="flex items-start gap-3">
                                <svg class="w-5 h-5 text-gold-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                <div>
                                    <h6 class="font-medium text-neutral-800">{{ $point['title'] }}</h6>
                                    <p class="text-sm text-neutral-500">{{ $point['description'] }}</p>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @endif

                @if ($buttonLabel)
                    <a href="{{ $buttonUrl }}" class="btn-pill bg-neutral-900 text-white hover:bg-neutral-800 mt-8 inline-flex">
                        {{ $buttonLabel }}
                    </a>
                @endif
            </div>
        </div>
    </div>
</section>