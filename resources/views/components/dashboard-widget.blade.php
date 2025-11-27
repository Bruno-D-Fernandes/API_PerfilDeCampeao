<div {{ $attributes->merge(['class' => 'p-[0.83vw] bg-white border border-[0.15vw] border-gray-200 flex flex-col gap-y-[0.42vw] rounded-[0.42vw] max-w-full hover:border-' . $borderColor . '-500 transition-colors']) }}>
    <div class="flex gap-x-[0.42vw] items-center">
        <div class="h-[0.83vw] w-[0.83vw] {{ $iconColor }}">
            {{ $icon ?? '' }}
        </div>

        <span class="text-[0.73vw] font-medium {{ $iconColor }}">
            {{ $title }}
        </span>
    </div>
    
    <div class="flex items-center gap-x-[0.42vw]">
        <span class="{{ (is_numeric($value) ? 'text-[1.04vw]' : 'text-[0.94vw]') }} font-medium text-gray-800 tracking-tight">
            {{ $value }}
        </span>

        @if ($trend !== null)
            <div class="flex gap-x-[0.21vw] items-center">
                <svg class="w-[1.04vw] h-[1.04vw] stroke-[0.1vw] {{ $trendColor }}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                    @php
                        $isPositive = is_numeric($trend) && (float) str_replace(['+', '%'], '', $trend) >= 0;
                    @endphp

                    @if ($isPositive)
                        <path d="M16 7h6v6"/><path d="m22 7-8.5 8.5-5-5L2 17"/>
                    @else
                        <path d="M16 17h6v-6"/><path d="m22 17-8.5-8.5-5 5L2 7"/>
                    @endif
                </svg>

                <span class="text-[0.94vw] tracking-tight font-medium {{ $trendColor }}">
                    {{ is_numeric($trend) && (float) $trend > 0 ? '+' : '' }}{{ $trend }}
                </span>
            </div>
        @endif
    </div>
</div>