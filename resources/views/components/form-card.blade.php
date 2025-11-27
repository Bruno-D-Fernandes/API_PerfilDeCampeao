@php
    $theme = match($color) {
        'red'   => ['title' => 'text-red-600',     'description' => 'text-red-700/70'],
        'blue'  => ['title' => 'text-sky-600',     'description' => 'text-sky-700/70'],
        'green' => ['title' => 'text-emerald-600', 'description' => 'text-emerald-700/70'],
        default => ['title' => 'text-gray-900',    'description' => 'text-gray-700/70'],
    };
@endphp

<div {{ $attributes->merge(['class' => 'p-[1.67vw] w-[66.67vw] rounded-[0.83vw] bg-white flex flex-col items-start gap-[0.83vw]']) }}>
    @if(isset($logo))
        {{ $logo }}
    @endif

    <h1 class="text-[1.88vw] {{ $theme['title'] }} font-semibold tracking-tight">
        {{ $title }}
    </h1>

    <h2 class="text-[0.94vw] {{ $theme['description'] }} font-medium">
        {{ $description }}
    </h2>

    {{ $slot }}
</div>