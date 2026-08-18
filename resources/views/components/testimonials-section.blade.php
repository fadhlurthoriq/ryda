@props(['title', 'description' => null, 'testimonials' => [], 'buttonLabel' => null, 'buttonUrl' => null])

<section class="bg-neutral-50 py-24 scroll-mt-16">
    <div class="max-w-6xl mx-auto px-4">
        <div class="flex flex-col items-center text-center gap-3 max-w-2xl mx-auto">
            <span class="badge-pill">Testimoni</span>
            <h2 class="text-4xl lg:text-5xl font-semibold text-neutral-900">{{ $title }}</h2>
            @if ($description)
                <p class="text-neutral-600">{{ $description }}</p>
            @endif
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mt-10">
            @foreach ($testimonials as $testimonial)
                <div class="group bg-white border border-neutral-200 rounded-xl p-6">
                    <div class="flex items-center gap-2">
                        <div class="size-9 rounded-full ring-2 ring-gold-300 bg-gold-500 flex items-center justify-center text-white text-sm font-semibold">
                            {{ $testimonial['initials'] }}
                        </div>
                        <div class="flex flex-col gap-0.5">
                            <h2 class="text-base font-semibold text-neutral-800 leading-none">{{ $testimonial['name'] }}</h2>
                            <span class="text-xs text-neutral-500 leading-none">{{ $testimonial['role'] }}</span>
                        </div>
                    </div>
                    <p class="text-neutral-600 mt-4">"{{ $testimonial['content'] }}"</p>
                </div>
            @endforeach
        </div>

        @if ($buttonLabel)
            <div class="text-center mt-12">
                <a href="{{ $buttonUrl }}" class="btn-pill bg-neutral-900 text-white hover:bg-neutral-800">
                    {{ $buttonLabel }}
                </a>
            </div>
        @endif
    </div>
</section>