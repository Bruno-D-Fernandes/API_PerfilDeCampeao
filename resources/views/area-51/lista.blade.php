<x-layouts.clube title="Zagueiros - Futebol" :breadcrumb="[
    'Dashboard' => route('admin-clubes'),
    'Minhas Linhas' => route('admin-clubes'),
    'Zagueiros - Futebol' => null
]">
    <div class="flex flex-col gap-6">
        <a href="" class="flex items-center gap-x-1 text-emerald-500 hover:text-emerald-700 transition-colors font-medium">
            <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-left-icon lucide-chevron-left"><path d="m15 18-6-6 6-6"/></svg>

            Voltar
        </a>

        <div class="relative w-full flex flex-col gap-4">
            <div class="flex items-center justify-between">
                <div class="w-full flex items-center gap-x-4">
                    <div class="h-12 w-12 rounded-lg bg-emerald-500 flex items-center justify-center">
                        <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-folder-icon lucide-folder"><path d="M20 20a2 2 0 0 0 2-2V8a2 2 0 0 0-2-2h-7.9a2 2 0 0 1-1.69-.9L9.6 3.9A2 2 0 0 0 7.93 3H4a2 2 0 0 0-2 2v13a2 2 0 0 0 2 2Z"/></svg>
                    </div>

                    <h2 class="text-4xl font-medium tracking-tight text-emerald-500">
                        Zagueiros - Futebol
                    </h2>
                </div>

                <div class="flex items-center gap-x-2">
                    <x-icon-button color="blue">
                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-square-pen-icon lucide-square-pen"><path d="M12 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.375 2.625a1 1 0 0 1 3 3l-9.013 9.014a2 2 0 0 1-.853.505l-2.873.84a.5.5 0 0 1-.62-.62l.84-2.873a2 2 0 0 1 .506-.852z"/></svg>
                    </x-icon-button>
            
                    <div class="w-px h-4 bg-gray-200"></div>

                    <x-icon-button color="red">
                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trash-icon lucide-trash"><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6"/><path d="M3 6h18"/><path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                    </x-icon-button>
                </div>
            </div>  

            <div class="flex flex-col gap-4">
                <h3 class="text-lg font-medium text-gray-800">
                    Monitoramento só dos melhores
                </h3>
                
                <div class="flex gap-x-4 items-center">
                    <div class="flex gap-x-2 items-center text-gray-400">
                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-calendar-icon lucide-calendar"><path d="M8 2v4"/><path d="M16 2v4"/><rect width="18" height="18" x="3" y="4" rx="2"/><path d="M3 10h18"/></svg>

                        <span class="text-md font-medium">
                            Criada em: 10/10/2024
                        </span>
                    </div>

                    <div class="flex gap-x-2 items-center text-emerald-500">
                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-users-icon lucide-users"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><path d="M16 3.128a4 4 0 0 1 0 7.744"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><circle cx="9" cy="7" r="4"/></svg>

                        <span class="text-md font-medium">
                            16 atletas
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.clube>