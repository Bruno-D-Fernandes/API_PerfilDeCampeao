@php
    $maxWidthClass = match($maxWidth) {
        'sm' => 'max-w-[20vw]',  
        'md' => 'max-w-[23.33vw]',  
        'lg' => 'max-w-[26.67vw]', 
        'xl' => 'max-w-[30vw]',   
        '2xl' => 'max-w-[35vw]',  
        default => 'max-w-[35vw]',
    };

    $titleSizeClass = match($titleSize) {
        'sm' => 'text-[0.73vw]',
        'md' => 'text-[0.83vw]',
        'lg' => 'text-[0.94vw]',
        'xl' => 'text-[1.04vw]',
        '2xl' => 'text-[1.25vw]',
        '3xl' => 'text-[1.56vw]',
        '4xl' => 'text-[1.88vw]',
        '5xl' => 'text-[2.5vw]',
        default => 'text-[1.04vw]',
    };

    $titleColorClass = match($titleColor) {
        'blue' => 'text-sky-600',
        'gray' => 'text-gray-900',
        'red' => 'text-red-600',
        default => 'text-emerald-600'
    }
@endphp

<div 
    id="{{ $name }}" 
    class="fixed inset-0 z-[900] hidden overflow-y-hidden overflow-x-hidden"
    aria-labelledby="modal-title" 
    role="dialog" 
    aria-modal="true"
>
    <div class="flex min-h-screen items-center justify-center px-[0.83vw] pt-[0.83vw] pb-[4.17vw] text-center block p-0">
        
        <div 
            class="fixed inset-0 bg-gray-900/75 backdrop-blur-[0.21vw] transition-opacity" 
            aria-hidden="true"
            onclick="closeModal('{{ $name }}')"
        ></div>

        <span class="inline-block h-screen align-middle" aria-hidden="true">&#8203;</span>

        <div class="relative inline-block transform overflow-hidden rounded-[0.63vw] bg-white text-left align-bottom shadow-xl transition-all my-[1.67vw] w-full align-middle {{ $maxWidthClass }} p-[0.83vw]">
            <div class="flex items-center justify-between pb-[0.42vw] border-b-[0.052vw] border-gray-300">
                <h3 class="{{ $titleSizeClass }} font-semibold {{ $titleColorClass }} tracking-tight" id="modal-title">
                    {{ $title }}
                </h3>

                <button type="button" onclick="closeModal('{{ $name }}')" class="cursor-pointer text-gray-400 hover:text-gray-500 focus:outline-none">
                    <svg class="h-[1.25vw] w-[1.25vw] stroke-[0.1vw]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <div class="pt-[0.52vw] pb-[0.52vw]">
                {{ $slot }}
            </div>

            @if(isset($footer))
                <div class="flex pt-[0.63vw] justify-end border-t-[0.052vw] border-gray-300">
                    {{ $footer }}
                </div>
            @endif
        </div>
    </div>
</div>