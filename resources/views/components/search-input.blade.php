<label for="input-group-1" class="sr-only">Pesquisa</label>

<div class="relative">
    <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
        <svg class="w-4 h-4 text-body" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="m21 21-3.5-3.5M17 10a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z"/></svg>
    </div>

    <input 
        {{ $attributes->merge([
            'type' => 'text', 
            'id' => 'input-group-1',
            'class' => 'block w-full ps-9 pe-3 py-3 bg-gray-50 text-heading text-sm rounded-lg border-none shadow-xs placeholder:text-body'
        ]) }}
        placeholder="{{ $placeholder }}"
    >
</div>