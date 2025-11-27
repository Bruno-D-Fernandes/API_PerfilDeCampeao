<label for="input-group-1" class="sr-only">Pesquisa</label>

<div class="relative">
    <div class="absolute inset-y-0 start-0 flex items-center ps-[0.63vw] pointer-events-none">
        <svg class="w-[0.83vw] h-[0.83vw] text-body stroke-[0.1vw]" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="m21 21-3.5-3.5M17 10a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z"/></svg>
    </div>

    <input 
        {{ $attributes->merge([
            'type' => 'text', 
            'id' => 'input-group-1',
            'class' => 'block w-full ps-[1.88vw] pe-[0.63vw] py-[0.63vw] bg-gray-50 text-heading text-[0.73vw] rounded-[0.42vw] border-none shadow-xs placeholder:text-body'
        ]) }}
        placeholder="{{ $placeholder }}"
    >
</div>