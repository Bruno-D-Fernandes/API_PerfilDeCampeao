<div class="relative w-full group">
    <div class="absolute inset-y-0 start-0 flex items-center ps-[0.63vw] pointer-events-none">
        <svg class="h-[0.83vw] w-[0.83vw] text-gray-400 group-focus-within:text-emerald-500 transition-colors stroke-[0.1vw]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
            <path d="M2.992 16.342a2 2 0 0 1 .094 1.167l-1.065 3.29a1 1 0 0 0 1.236 1.168l3.413-.998a2 2 0 0 1 1.099.092 10 10 0 1 0-4.777-4.719"/>
        </svg>
    </div>

    <input 
        type="text" 
        name="{{ $name }}"
        id="{{ $name }}"
        value="{{ old($name, $value) }}"
        placeholder="{{ $placeholder }}"
        {{ $attributes->merge(['class' => 'block w-full ps-[2.08vw] pe-[5vw] py-[0.73vw] bg-gray-50 border border-[0.052vw] border-gray-200 text-heading text-[0.63vw] rounded-[0.42vw] focus:border-emerald-500 transition-colors focus:outline-none placeholder:text-body']) }}
    >
    
    <div class="absolute inset-y-0 end-0 flex items-center pe-[0.42vw] gap-[0.42vw]">
        <x-icon-button color="none" type="button" class="text-gray-400 hover:text-emerald-500 transition-colors" onclick="openModal('send-invite-modal')">
            <svg class="h-[0.83vw] w-[0.83vw] stroke-[0.1vw]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 2v2"/><path d="M15.726 21.01A2 2 0 0 1 14 22H4a2 2 0 0 1-2-2V10a2 2 0 0 1 2-2"/><path d="M18 2v2"/><path d="M2 13h2"/><path d="M8 8h14"/><rect x="8" y="3" width="14" height="14" rx="2"/>
            </svg>
        </x-icon-button>
 
        <div class="w-[0.052vw] h-[0.83vw] bg-gray-200"></div>

        <x-icon-button color="none" type="submit" class="text-emerald-500 hover:text-emerald-600 transition-colors">
            <svg class="h-[0.83vw] w-[0.83vw] stroke-[0.1vw]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                <path d="M14.536 21.686a.5.5 0 0 0 .937-.024l6.5-19a.496.496 0 0 0-.635-.635l-19 6.5a.5.5 0 0 0-.024.937l7.93 3.18a2 2 0 0 1 1.112 1.11z"/><path d="m21.854 2.147-10.94 10.939"/>
            </svg>
        </x-icon-button>
    </div>
</div>