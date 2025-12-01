<x-layouts.clube title="Dashboard" :breadcrumb="[
    'Dashboard' => null,
]">
    <div class="h-full w-full flex flex-col">
        <div class="h-8 flex gap-x-2 items-center pt-2 pb-8 w-full border-b border-gray-300">
            <span class="text-md font-medium text-emerald-500">
                Esporte
            </span>

            <div>
                <x-form-group :label="null" name="fe" type="select" id="fe" labelColor="green" class="pr-8">
                    <x-slot:icon>
                        <svg class="h-4 w-4 text-emerald-500" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trophy-icon lucide-trophy"><path d="M10 14.66v1.626a2 2 0 0 1-.976 1.696A5 5 0 0 0 7 21.978"/><path d="M14 14.66v1.626a2 2 0 0 0 .976 1.696A5 5 0 0 1 17 21.978"/><path d="M18 9h1.5a1 1 0 0 0 0-5H18"/><path d="M4 22h16"/><path d="M6 9a6 6 0 0 0 12 0V3a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1z"/><path d="M6 9H4.5a1 1 0 0 1 0-5H6"/></svg>
                    </x-slot:icon>

                    <option class="text-md font-medium text-gray-800">
                        Futebol
                    </option>

                    <option class="text-md font-medium text-gray-800">
                        Basquete
                    </option>

                    <option class="text-md font-medium text-gray-800">
                        Vôlei
                    </option>
                </x-form-group>
            </div>
        </div>

        <div class="flex-grow grid grid-rows-[auto_1fr] gap-6 mt-7">
            <div class="w-full grid grid-cols-4 gap-4">
                <x-dashboard-widget title="Inscrições pendentes" :value="90" :trend="70">
                    <x-slot:icon>
                        <svg class="h-4 w-4 text-emerald-500/70" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-clock-icon lucide-clock"><path d="M12 6v6l4 2"/><circle cx="12" cy="12" r="10"/></svg>
                    </x-slot:icon>
                </x-dashboard-widget>

                <x-dashboard-widget title="Oportunidades ativas" :value="7" :trend="3">
                    <x-slot:icon>
                        <svg class="h-4 w-4 text-emerald-500/70"  xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-megaphone-icon lucide-megaphone"><path d="M11 6a13 13 0 0 0 8.4-2.8A1 1 0 0 1 21 4v12a1 1 0 0 1-1.6.8A13 13 0 0 0 11 14H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2z"/><path d="M6 14a12 12 0 0 0 2.4 7.2 2 2 0 0 0 3.2-2.4A8 8 0 0 1 10 14"/><path d="M8 6v8"/></svg>
                    </x-slot:icon>
                </x-dashboard-widget>

                <x-dashboard-widget title="Próximo evento" value="Treino com os manos! (14/10)">
                    <x-slot:icon>
                        <svg class="h-4 w-4 text-emerald-500/70"  xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-calendar-icon lucide-calendar"><path d="M8 2v4"/><path d="M16 2v4"/><rect width="18" height="18" x="3" y="4" rx="2"/><path d="M3 10h18"/></svg>
                    </x-slot:icon>
                </x-dashboard-widget>

                <x-dashboard-widget title="Perfis salvos" :value="27" :trend="4" >
                    <x-slot:icon>
                        <svg class="h-4 w-4 text-emerald-500/70"  xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-users-icon lucide-users"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><path d="M16 3.128a4 4 0 0 1 0 7.744"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><circle cx="9" cy="7" r="4"/></svg>
                    </x-slot:icon>
                </x-dashboard-widget>
            </div>

            <div class="h-[37.75rem]">
                <div class="grid grid-cols-5 gap-6">
                    <div class="col-span-3 flex flex-col gap-6">

                        <div class="grid grid-cols-2 gap-4">
                            <div class="bg-white p-4 rounded-lg border border-2 border-gray-200">
                                <span class="text-md font-medium text-gray-700">
                                    Distribuição por posições
                                </span>
                            </div>

                            <div class="bg-white p-4 rounded-lg border border-2 border-gray-200">
                                <span class="text-md font-medium text-gray-700">
                                    Evolução de candidaturas
                                </span>
                            </div>
                        </div>

                        <div>
                            <div class="bg-white p-4 rounded-lg border border-2 border-gray-200">
                                <span class="text-md font-medium text-gray-700">
                                    Origem geográfica
                                </span>
                            </div>
                        </div>

                        <div class="flex flex-col gap-4">
                            <div class="bg-white p-4 rounded-lg border border-2 border-gray-200">
                                <span class="text-md font-medium text-gray-700">
                                    Atividades recentes
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="col-span-2 flex flex-col gap-6">
                        <div class="bg-white p-4 rounded-lg border border-2 border-gray-200 flex flex-col gap-3">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-x-2">
                                    <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-calendar-days-icon lucide-calendar-days"><path d="M8 2v4"/><path d="M16 2v4"/><rect width="18" height="18" x="3" y="4" rx="2"/><path d="M3 10h18"/><path d="M8 14h.01"/><path d="M12 14h.01"/><path d="M16 14h.01"/><path d="M8 18h.01"/><path d="M12 18h.01"/><path d="M16 18h.01"/></svg>

                                    <span class="text-md font-medium text-gray-700">
                                        Próximo evento
                                    </span>
                                </div>

                                <div class="relative cursor-pointer h-5 w-5 rounded-full bg-red-500">
                                
                                </div>
                            </div>

                            <div class="w-full border border-t border-gray-200"></div>

                            <div class="flex flex-col gap-2">
                                <div class="flex flex-col gap-1.5">
                                    <h2 class="text-xl font-medium tracking-tight text-gray-800">
                                        A volta daqueles que não foram
                                    </h2>

                                    <h3 class="text-md font-normal text-gray-700">
                                        O evento que reúne metade da ETEC de Guaianazes para todos darem a vida!
                                    </h3>
                                </div>  
                                
                                <div class="flex items-center gap-x-2">
                                    <svg class="h-4 w-4 text-gray-500" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-clock-icon lucide-clock"><path d="M12 6v6l4 2"/><circle cx="12" cy="12" r="10"/></svg>

                                    <span class="text-sm font-medium text-gray-500 truncate">
                                        11/11 - 14h até 12/11 - 18h
                                    </span>
                                </div>

                                <div class="flex items-center gap-x-2">
                                    <svg class="h-4 w-4 text-gray-500" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-map-pin-icon lucide-map-pin"><path d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0"/><circle cx="12" cy="10" r="3"/></svg>

                                    <span class="block text-sm font-medium text-gray-500 truncate">
                                        R. Feliciano de Mendonça, 290 - Guaianases, São Paulo - SP, 08460-365
                                    </span>
                                </div>

                                <div>
                                    <x-progress 
                                        :percentage="70" 
                                        :showValue="true" 
                                        color="green" 
                                    />
                                </div>

                                <x-button color="clube" :full="true" class="mt-1">
                                    Ver agenda
                                </x-button>
                            </div>
                        </div>

                        <div class="bg-white h-max p-4 rounded-lg border border-2 border-gray-200 flex flex-col gap-3">
                            <div class="flex items-center gap-x-2">
                                <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-hourglass-icon lucide-hourglass"><path d="M5 22h14"/><path d="M5 2h14"/><path d="M17 22v-4.172a2 2 0 0 0-.586-1.414L12 12l-4.414 4.414A2 2 0 0 0 7 17.828V22"/><path d="M7 2v4.172a2 2 0 0 0 .586 1.414L12 12l4.414-4.414A2 2 0 0 0 17 6.172V2"/></svg>

                                <span class="text-md font-medium text-gray-700">
                                    Inscrições pendentes
                                </span>
                            </div>

                            <div class="w-full border border-t border-gray-200"></div>

                            <div class="flex flex-col gap-2 overflow-y-auto max-h-[18rem]">
                                @foreach([1, 2, 3, 4, 5] as $num)
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center gap-x-3">
                                            <div class="h-[1.75rem] border border-l border-3 border-gray-200 rounded-md"></div>

                                            <span class="text-md font-medium text-gray-700">
                                                João Pedro
                                            </span>

                                            <a href="" class="text-sm font-semibold tracking-tight text-emerald-500 hover:text-emerald-600 underline transition-colors">
                                                Oportunidade
                                            </a>
                                        </div>

                                        <div class="flex items-center gap-x-2">
                                            <x-icon-button color="red">
                                                <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-x-icon lucide-x"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
                                            </x-icon-button>
                                    
                                            <div class="w-px h-4 bg-gray-200"></div>

                                            <x-icon-button color="green">
                                                <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-check-icon lucide-check"><path d="M20 6 9 17l-5-5"/></svg>
                                            </x-icon-button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.clube>