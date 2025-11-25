@php
    $theme = match($color) {
        'red'   => ['title' => 'text-red-600',     'description' => 'text-red-700/70'],
        'blue'  => ['title' => 'text-sky-600',    'description' => 'text-sky-700/70'],
        'green' => ['title' => 'text-emerald-600', 'description' => 'text-emerald-700/70'],
        default => ['title' => 'text-gray-900',    'description' => 'text-gray-700/70'],
    };
@endphp

<div {{ $attributes->merge(['class' => 'p-8 w-4/6 rounded-2xl bg-white flex flex-col items-start gap-4']) }}>
    @if(isset($logo))
        {{ $logo }}
    @endif

    <h1 class="text-4xl {{ $theme['title'] }} font-semibold tracking-tight">
        {{ $title }}
    </h1>

    <h2 class="text-lg {{ $theme['description'] }} font-medium">
        {{ $description }}
    </h2>

    {{ $slot }}
</div>