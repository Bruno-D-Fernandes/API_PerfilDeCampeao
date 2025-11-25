<x-layouts.clube title="Perfil" :breadcrumb="[
    'Dashboard' => route('clube.dashboard'),
    'Perfil' => null
]">
    <div class="w-full h-full">
        <div class="flex flex-col gap-4">
            <div class="h-76">
                <div class="relative w-full h-64 rounded-lg bg-emerald-500 flex items-center justify-center">
                    <svg class="h-16 w-16 text-white" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-image-icon lucide-image"><rect width="18" height="18" x="3" y="3" rx="2" ry="2"/><circle cx="9" cy="9" r="2"/><path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21"/></svg>

                    <div class="absolute left-16 top-full h-24 w-24 rounded-full bg-emerald-500 -translate-y-1/2 border-4 border-white flex items-center justify-center">
                        <svg class="h-10 w-10 text-white" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-camera-icon lucide-camera"><path d="M13.997 4a2 2 0 0 1 1.76 1.05l.486.9A2 2 0 0 0 18.003 7H20a2 2 0 0 1 2 2v9a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V9a2 2 0 0 1 2-2h1.997a2 2 0 0 0 1.759-1.048l.489-.904A2 2 0 0 1 10.004 4z"/><circle cx="12" cy="13" r="3"/></svg>
                    </div>

                    <div class="absolute right-0 top-full translate-y-3">
                        <x-button color="clube" size="md">
                            Editar
                        </x-button>
                    </div>
                </div>
            </div>

            <div class="flex items-center gap-x-4">
                <h1 class="text-2xl font-semibold text-gray-800">
                    Vasco da Gama
                </h1>
            </div>

            <div class="w-full grid grid-cols-10 gap-4">
                <div class="col-span-3 h-auto rounded-lg bg-white border border-2 border-gray-200 hover:border-emerald-500 transition-colors p-4 flex flex-col gap-4">
                    <div class="flex flex-col gap-2">
                        <span class="text-md font-semibold uppercase text-emerald-500 tracking-tight">
                            Sobre
                        </span>

                        <span class="w-full text-md font-normal text-gray-900 line-clamp-3">
                            Fala molecos e molecas aqui quem fala é o rezendeevil e vão todos para a bosta intensa. Fala molecos e molecas aqui quem fala é o rezendeevil e vão todos para a bosta intensa. Fala molecos e molecas aqui quem fala é o rezendeevil e vão todos para a bosta intensa. Fala molecos e molecas aqui quem fala é o rezendeevil e vão todos para a bosta intensa
                        </span>

                        <div class="flex flex-wrap w-full items-center justify-center gap-2">
                            <x-badge color="green" :border="false">
                                <x-slot:icon>
                                    <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-medal-icon lucide-medal"><path d="M7.21 15 2.66 7.14a2 2 0 0 1 .13-2.2L4.4 2.8A2 2 0 0 1 6 2h12a2 2 0 0 1 1.6.8l1.6 2.14a2 2 0 0 1 .14 2.2L16.79 15"/><path d="M11 12 5.12 2.2"/><path d="m13 12 5.88-9.8"/><path d="M8 7h8"/><circle cx="12" cy="17" r="5"/><path d="M12 18v-2h-.5"/></svg>
                                </x-slot:icon>

                                Profissional
                            </x-badge>

                            <x-badge color="green" :border="false">
                                <x-slot:icon>
                                    <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-calendar1-icon lucide-calendar-1"><path d="M11 14h1v4"/><path d="M16 2v4"/><path d="M3 10h18"/><path d="M8 2v4"/><rect x="3" y="4" width="18" height="18" rx="2"/></svg> 
                                </x-slot:icon>

                                Fundado em 1912
                            </x-badge>

                            <x-badge color="green" :border="false">
                                <x-slot:icon>
                                    <svg class="h-3 w-3" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-map-pin-icon lucide-map-pin"><path d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0"/><circle cx="12" cy="10" r="3"/></svg>
                                </x-slot:icon>
                                
                                Rio de Janeiro - RJ
                            </x-badge>

                            <x-badge color="green" :border="false">
                                <x-slot:icon>
                                    <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trophy-icon lucide-trophy"><path d="M10 14.66v1.626a2 2 0 0 1-.976 1.696A5 5 0 0 0 7 21.978"/><path d="M14 14.66v1.626a2 2 0 0 0 .976 1.696A5 5 0 0 1 17 21.978"/><path d="M18 9h1.5a1 1 0 0 0 0-5H18"/><path d="M4 22h16"/><path d="M6 9a6 6 0 0 0 12 0V3a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1z"/><path d="M6 9H4.5a1 1 0 0 1 0-5H6"/></svg>
                                </x-slot:icon>
                                
                                Futebol
                            </x-badge>

                            <x-badge color="green" :border="false">
                                <x-slot:icon>
                                    <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trophy-icon lucide-trophy"><path d="M10 14.66v1.626a2 2 0 0 1-.976 1.696A5 5 0 0 0 7 21.978"/><path d="M14 14.66v1.626a2 2 0 0 0 .976 1.696A5 5 0 0 1 17 21.978"/><path d="M18 9h1.5a1 1 0 0 0 0-5H18"/><path d="M4 22h16"/><path d="M6 9a6 6 0 0 0 12 0V3a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1z"/><path d="M6 9H4.5a1 1 0 0 1 0-5H6"/></svg>
                                </x-slot:icon>
                                
                                Basquete
                            </x-badge>

                            <x-badge color="green" :border="false">
                                <x-slot:icon>
                                    <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trophy-icon lucide-trophy"><path d="M10 14.66v1.626a2 2 0 0 1-.976 1.696A5 5 0 0 0 7 21.978"/><path d="M14 14.66v1.626a2 2 0 0 0 .976 1.696A5 5 0 0 1 17 21.978"/><path d="M18 9h1.5a1 1 0 0 0 0-5H18"/><path d="M4 22h16"/><path d="M6 9a6 6 0 0 0 12 0V3a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1z"/><path d="M6 9H4.5a1 1 0 0 1 0-5H6"/></svg>
                                </x-slot:icon>
                                
                                Vôlei
                            </x-badge>
                        </div>
                    </div>

                    <div class="flex flex-col gap-2">
                        <span class="text-md font-semibold uppercase text-emerald-500 tracking-tight">
                            Contato
                        </span>

                        <span class="inline-flex gap-x-2 text-md font-medium tracking-tight text-emerald-600">
                            Email:

                            <a href="" class="text-md font-medium tracking-tight underline flex items-center gap-x-2 text-gray-300 hover:text-emerald-400 transition-colors">
                                joaopedroferreiralima@gmail.com
                            </a>
                        </span>

                        <span class="inline-flex gap-x-2 text-md font-medium tracking-tight text-emerald-600">
                            CNPJ:

                            <span class="text-md font-medium tracking-tight text-emerald-500">
                                joaopedroferreiralima@gmail.com
                            </span>
                        </span>
                    </div>
                </div>

                <div class="col-span-7 h-full rounded-lg bg-white hover:border-emerald-500 transition-colors">
                    <x-tabs 
                        :options="[
                            'futebol' => 'Futebol', 
                            'basquete' => 'Basquete'
                        ]" 
                        default="futebol"
                    >
                        <x-slot name="icon_futebol">
                            <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trophy-icon lucide-trophy"><path d="M10 14.66v1.626a2 2 0 0 1-.976 1.696A5 5 0 0 0 7 21.978"/><path d="M14 14.66v1.626a2 2 0 0 0 .976 1.696A5 5 0 0 1 17 21.978"/><path d="M18 9h1.5a1 1 0 0 0 0-5H18"/><path d="M4 22h16"/><path d="M6 9a6 6 0 0 0 12 0V3a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1z"/><path d="M6 9H4.5a1 1 0 0 1 0-5H6"/></svg>
                        </x-slot>

                        <x-slot name="icon_basquete">
                            <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trophy-icon lucide-trophy"><path d="M10 14.66v1.626a2 2 0 0 1-.976 1.696A5 5 0 0 0 7 21.978"/><path d="M14 14.66v1.626a2 2 0 0 0 .976 1.696A5 5 0 0 1 17 21.978"/><path d="M18 9h1.5a1 1 0 0 0 0-5H18"/><path d="M4 22h16"/><path d="M6 9a6 6 0 0 0 12 0V3a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1z"/><path d="M6 9H4.5a1 1 0 0 1 0-5H6"/></svg>
                        </x-slot>

                        <x-slot name="candidatos">
                            
                        </x-slot>

                        <x-slot name="detalhes">

                        </x-slot>
                    </x-tabs>
                </div>
            </div>
        </div>        
    </div>
</x-layouts.clube>