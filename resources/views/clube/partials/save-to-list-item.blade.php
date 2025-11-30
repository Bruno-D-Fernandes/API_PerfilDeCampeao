<label class="group flex items-center gap-x-[0.83vw] px-[0.63vw] py-[0.52vw] cursor-pointer hover:bg-gray-50 transition-colors rounded-[0.42vw]">
    <div class="relative flex items-center justify-center">
    
        <input type="checkbox" name="lists[]" value="{{ $lista->id }}" 
            @if(isset($atletaId) && $lista->usuarios?->contains($atletaId)) checked @endif 
            class="peer sr-only">
        
        <div class="w-[1.04vw] h-[1.04vw] border-[0.1vw] border-gray-400 rounded-[0.21vw] bg-white peer-checked:bg-emerald-600 peer-checked:border-emerald-600 transition-all duration-200"></div>
        
        <svg class="absolute w-[0.63vw] h-[0.63vw] opacity-0 peer-checked:opacity-100 pointer-events-none transition-opacity duration-200" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="4" stroke-linecap="round" stroke-linejoin="round">
            <polyline points="20 6 9 17 4 12"></polyline>
        </svg>
    </div>
    
    <span class="text-[0.73vw] font-medium text-gray-700 group-hover:text-gray-900 select-none truncate flex-1">
        {{ $lista->nome }}
    </span>

    @if(isset($lista->is_private) && $lista->is_private)
        <svg class="w-[0.73vw] h-[0.73vw] text-gray-400 ml-auto" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
    @endif
</label>