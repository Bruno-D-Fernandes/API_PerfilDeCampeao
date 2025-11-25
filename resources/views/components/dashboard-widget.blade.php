<div {{ $attributes->merge(['class' => 'p-4 bg-white border border-2 border-gray-200 flex flex-col gap-y-2 rounded-lg max-w-full']) }}>
    <div class="flex gap-x-2 items-center">
        <div class="h-4 w-4 {{ $iconColor }}">
            {{ $icon ?? '' }}
        </div>

        <span class="text-sm font-medium {{ $iconColor }}">
            {{ $title }}
        </span>
    </div>
    
    <div class="flex items-center gap-x-2">
        <span class="{{ (is_numeric($value) ? 'text-xl' : 'text-lg') }} font-medium text-gray-800 tracking-tight">
            {{ $value }}
        </span>

        @if ($trend !== null)
            <div class="flex gap-x-1 items-center">
                <svg class="w-5 h-5 {{ $trendColor }}" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    @php
                        $isPositive = is_numeric($trend) && (float) str_replace(['+', '%'], '', $trend) >= 0;
                    @endphp

                    @if ($isPositive)
                        <path d="M16 7h6v6"/><path d="m22 7-8.5 8.5-5-5L2 17"/>
                    @else
                        <path d="M16 17h6v-6"/><path d="m22 17-8.5-8.5-5 5L2 7"/>
                    @endif
                </svg>

                <span class="text-lg tracking-tight font-medium {{ $trendColor }}">
                    {{ is_numeric($trend) && (float) $trend > 0 ? '+' : '' }}{{ $trend }}
                </span>
            </div>
        @endif
    </div>
</div>