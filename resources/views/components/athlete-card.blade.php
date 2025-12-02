<a href="{{ route('usuarios.perfil', $athlete->id) }}" class="pointer-events-auto cursor-pointer max-w-full max-h-full flex flex-col gap-[0.42vw] p-[0.63vw] bg-white border border-[0.1vw] border-gray-300/80 hover:border-emerald-400 transition-colors rounded-[0.42vw] group">
    <div class="relative w-full">
        <x-avatar :src="null" alt="{{ $athlete->nomeCompletoUsuario }}" size="xl" class="!w-[2.9vw] !h-[2.9vw]" />

        <div class="absolute top-0 right-0 z-10 flex gap-x-[0.21vw]">
            <x-icon-button color="none" class="text-emerald-400 hover:text-emerald-500 transition-colors" onclick="event.stopPropagation(); event.preventDefault(); openModal('save-to-list-{{ $athlete->id }}')">
                <svg class="h-[1.25vw] w-[1.25vw] stroke-[0.1vw]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-plus-icon lucide-plus"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
            </x-icon-button>
        </div>
    </div>

    <h2 class="font-semibold text-[0.94vw] text-gray-900">
        {{ $athlete->nomeCompletoUsuario }}
    </h2>

    <div class="flex gap-[0.63vw] flex-wrap items-center justify-center font-medium">
        <x-badge color="green" :border="false">
            <x-slot:icon>
                <svg class="h-[0.83vw] w-[0.83vw] stroke-[0.1vw]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-calendar-icon lucide-calendar"><path d="M8 2v4"/><path d="M16 2v4"/><rect width="18" height="18" x="3" y="4" rx="2"/><path d="M3 10h18"/></svg>
            </x-slot:icon>
            
            {{ \Carbon\Carbon::parse($athlete->dataNascimentoUsuario)->age }} anos
        </x-badge>

        <x-badge color="green" :border="false">
            <x-slot:icon>
                <svg class="h-[0.83vw] w-[0.83vw] stroke-[0.1vw]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trophy-icon lucide-trophy"><path d="M10 14.66v1.626a2 2 0 0 1-.976 1.696A5 5 0 0 0 7 21.978"/><path d="M14 14.66v1.626a2 2 0 0 0 .976 1.696A5 5 0 0 1 17 21.978"/><path d="M18 9h1.5a1 1 0 0 0 0-5H18"/><path d="M4 22h16"/><path d="M6 9a6 6 0 0 0 12 0V3a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1z"/><path d="M6 9H4.5a1 1 0 0 1 0-5H6"/></svg>
            </x-slot:icon>
            
            {{ $athlete->perfis?->first->esporte->nomeEsporte ?? 'N/D' }}
        </x-badge>

        <x-badge color="green" :border="false">
            <x-slot:icon>
                <svg class="h-[0.83vw] w-[0.83vw] stroke-[0.1vw]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-target-icon lucide-target"><circle cx="12" cy="12" r="10"/><circle cx="12" cy="12" r="6"/><circle cx="12" cy="12" r="2"/></svg>
            </x-slot:icon>

            {{ $athlete->perfis?->first->posicoes->first ?? 'N/D' }}
        </x-badge>

        <x-badge color="gray" :border="false">
            <x-slot:icon>
                <svg class="h-[0.83vw] w-[0.83vw] stroke-[0.1vw]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-ruler-icon lucide-ruler"><path d="M21.3 15.3a2.4 2.4 0 0 1 0 3.4l-2.6 2.6a2.4 2.4 0 0 1-3.4 0L2.7 8.7a2.41 2.41 0 0 1 0-3.4l2.6-2.6a2.41 2.41 0 0 1 3.4 0Z"/><path d="m14.5 12.5 2-2"/><path d="m11.5 9.5 2-2"/><path d="m8.5 6.5 2-2"/><path d="m17.5 15.5 2-2"/></svg>
            </x-slot:icon>

            {{ $athlete->alturaCm }}cm
        </x-badge>

        <x-badge color="gray" :border="false">
            <x-slot:icon>
                <svg class="h-[0.83vw] w-[0.83vw] stroke-[0.1vw]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-scale-icon lucide-scale"><path d="m16 16 3-8 3 8c-.87.65-1.92 1-3 1s-2.13-.35-3-1Z"/><path d="m2 16 3-8 3 8c-.87.65-1.92 1-3 1s-2.13-.35-3-1Z"/><path d="M7 21h10"/><path d="M12 3v18"/><path d="M3 7h2c2 0 5-1 7-2 2 1 5 2 7 2h2"/></svg>
            </x-slot:icon>

            80kg
        </x-badge>
    </div>

    <div class="flex items-center gap-x-[0.42vw] text-emerald-400 font-medium text-[0.73vw]">
        <svg class="h-[0.83vw] w-[0.83vw] stroke-[0.1vw]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-map-pin-icon lucide-map-pin"><path d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0"/><circle cx="12" cy="10" r="3"/></svg>

        {{ $athlete->cidadeUsuario }} - {{ $athlete->estadoUsuario }}
    </div>
</a>