<x-layouts.admin title="Dashboard" :breadcrumb="[
    'Dashboard' => null,
]">
    <div class="h-full w-full flex flex-col">
        <div class="flex-grow grid grid-rows-[auto_1fr] gap-6">
            <div class="w-full grid grid-cols-4 gap-4">
                <x-dashboard-widget title="Atletas cadastrados" :value="90" :trend="70" iconColor="text-sky-500/70">
                    <x-slot:icon>
                        <svg class="h-4 w-4 text-sky-500/70" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-users-icon lucide-users"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><path d="M16 3.128a4 4 0 0 1 0 7.744"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><circle cx="9" cy="7" r="4"/></svg>
                    </x-slot:icon>
                </x-dashboard-widget>

                <x-dashboard-widget title="Clubes ativos" :value="7" :trend="3" iconColor="text-sky-500/70">
                    <x-slot:icon>
                        <svg class="h-4 w-4 text-sky-500/70" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-building-icon lucide-building"><path d="M12 10h.01"/><path d="M12 14h.01"/><path d="M12 6h.01"/><path d="M16 10h.01"/><path d="M16 14h.01"/><path d="M16 6h.01"/><path d="M8 10h.01"/><path d="M8 14h.01"/><path d="M8 6h.01"/><path d="M9 22v-3a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v3"/><rect x="4" y="2" width="16" height="20" rx="2"/></svg>
                    </x-slot:icon>
                </x-dashboard-widget>

                <x-dashboard-widget title="Oportunidades ativas" :value="21" :trend="2" iconColor="text-sky-500/70">
                    <x-slot:icon>
                        <svg class="h-4 w-4 text-sky-500/70" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-megaphone-icon lucide-megaphone"><path d="M11 6a13 13 0 0 0 8.4-2.8A1 1 0 0 1 21 4v12a1 1 0 0 1-1.6.8A13 13 0 0 0 11 14H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2z"/><path d="M6 14a12 12 0 0 0 2.4 7.2 2 2 0 0 0 3.2-2.4A8 8 0 0 1 10 14"/><path d="M8 6v8"/></svg>
                    </x-slot:icon>
                </x-dashboard-widget>

                <x-dashboard-widget title="Inscrições realizadas" :value="12" :trend="2" iconColor="text-sky-500/70">
                    <x-slot:icon>
                        <svg class="h-4 w-4 text-sky-500/70" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-file-icon lucide-file"><path d="M6 22a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h8a2.4 2.4 0 0 1 1.704.706l3.588 3.588A2.4 2.4 0 0 1 20 8v12a2 2 0 0 1-2 2z"/><path d="M14 2v5a1 1 0 0 0 1 1h5"/></svg>
                    </x-slot:icon>
                </x-dashboard-widget>
            </div>

            <div class="h-[37.75rem]">
                <div class="grid grid-cols-20 gap-6">
                    <div class="col-span-6 flex flex-col gap-6">
                        <div class="bg-white p-4 rounded-lg border border-2 border-gray-200">
                            <span class="text-md font-medium text-gray-700">
                                Crescimento de usuários
                            </span>
                        </div>

                        <div class="bg-white p-4 rounded-lg border border-2 border-gray-200">
                            <span class="text-md font-medium text-gray-700">
                                Inscrições mensais
                            </span>
                        </div>

                        <div>
                            <div class="bg-white p-4 rounded-lg border border-2 border-gray-200">
                                <span class="text-md font-medium text-gray-700">
                                    Novos cadastros
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="col-span-6 flex flex-col gap-6">
                        <div class="bg-white p-4 rounded-lg border border-2 border-gray-200">
                            <span class="text-md font-medium text-gray-700">
                                Distribuição esportes
                            </span>
                        </div>

                        <div class="bg-white p-4 rounded-lg border border-2 border-gray-200">
                            <span class="text-md font-medium text-gray-700">
                                Oportunidades populares
                            </span>
                        </div>

                        <div class="bg-white p-4 rounded-lg border border-2 border-gray-200">
                            <span class="text-md font-medium text-gray-700">
                                Clubes mais ativos
                            </span>
                        </div>
                    </div>

                    <div class="col-span-8 flex flex-col gap-6">
                        <div class="bg-white p-4 rounded-lg border border-2 border-gray-200">
                            <span class="text-md font-medium text-gray-700">
                                Atividades recentes
                            </span>
                        </div>

                        <div class="bg-white h-max p-4 rounded-lg border border-2 border-gray-200 flex flex-col gap-3">
                            <div class="flex items-center gap-x-2">
                                <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-hourglass-icon lucide-hourglass"><path d="M5 22h14"/><path d="M5 2h14"/><path d="M17 22v-4.172a2 2 0 0 0-.586-1.414L12 12l-4.414 4.414A2 2 0 0 0 7 17.828V22"/><path d="M7 2v4.172a2 2 0 0 0 .586 1.414L12 12l4.414-4.414A2 2 0 0 0 17 6.172V2"/></svg>

                                <span class="text-md font-medium text-gray-700">
                                    Oportunidades pendentes
                                </span>
                            </div>

                            <div class="w-full border border-t border-gray-200"></div>

                            <div class="flex flex-col gap-2 overflow-y-auto max-h-[18rem]">
                                @foreach([1, 2, 3, 4, 5] as $num)
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center gap-x-3">
                                            <div class="h-[1.75rem] border border-l border-3 border-gray-200 rounded-md"></div>

                                            <span class="text-md font-medium text-gray-700">
                                                Vasco da Gama
                                            </span>

                                            <a href="" class="text-sm font-semibold tracking-tight text-sky-500 hover:text-sky-600 underline transition-colors">
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
</x-layouts.admin>