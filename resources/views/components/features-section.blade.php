@props(['title', 'description' => null, 'features' => []])

<section class="bg-neutral-50 py-24 scroll-mt-16">
    <div class="max-w-6xl mx-auto px-4">
        <div class="flex flex-col items-center text-center gap-3 max-w-2xl mx-auto">
            <span class="badge-pill">Kenapa Ryda</span>
            <h2 class="text-4xl lg:text-5xl font-semibold text-neutral-900">{{ $title }}</h2>
            @if ($description)
                <p class="text-neutral-600">{{ $description }}</p>
            @endif
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-10">
            @foreach ($features as $feature)
                <div class="flex flex-row justify-start items-start gap-4 p-6 rounded-lg">
                    <div class="size-12 rounded-full flex items-center justify-center flex-shrink-0 bg-gold-100 text-gold-600">
                        {!! $feature['icon'] !!}
                    </div>
                    <div>
                        <h6 class="text-md font-medium text-neutral-800">{{ $feature['title'] }}</h6>
                        <p class="text-sm text-neutral-500 mt-1">{{ $feature['description'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>