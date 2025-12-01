<button class="group break-inside-avoid w-full h-[9vw] rounded-[0.42vw] border-[0.15vw] border-dashed border-emerald-500 hover:border-emerald-600 bg-white flex flex-col items-center justify-center gap-[0.83vw] cursor-pointer hover:-translate-y-[0.1vw] transition-transform transition-colors disabled:opacity-50 disabled:cursor-not-allowed" onclick="openModal('create-list')">
    <svg class="h-[3.33vw] w-[3.33vw] text-emerald-500 group-hover:text-emerald-600 stroke-[0.1vw]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
    <h3 class="text-[0.94vw] font-semibold text-emerald-500 group-hover:text-emerald-600">
        Criar nova lista
    </h3>
</button>

@foreach($listas as $item)
    @include('clube.partials.list-card', ['item' => $item])
@endforeach