<x-layouts.clube title="Perfil" :breadcrumb="[
    'Dashboard' => route('clube.dashboard'),
    'Usuário' => null
]">
    <div class="w-full h-full">
        <div class="w-full h-full flex flex-col gap-4">
            <div class="pb-[2.75rem]">
                <div class="relative w-full h-64 rounded-lg bg-emerald-500 flex items-center justify-center">
                    <svg class="h-16 w-16 text-white" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-image-icon lucide-image"><rect width="18" height="18" x="3" y="3" rx="2" ry="2"/><circle cx="9" cy="9" r="2"/><path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21"/></svg>

                    <div class="absolute left-16 top-full h-24 w-24 rounded-full bg-emerald-500 -translate-y-1/2 border-4 border-white flex items-center justify-center">
                        <svg class="h-10 w-10 text-white" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-camera-icon lucide-camera"><path d="M13.997 4a2 2 0 0 1 1.76 1.05l.486.9A2 2 0 0 0 18.003 7H20a2 2 0 0 1 2 2v9a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V9a2 2 0 0 1 2-2h1.997a2 2 0 0 0 1.759-1.048l.489-.904A2 2 0 0 1 10.004 4z"/><circle cx="12" cy="13" r="3"/></svg>
                    </div>

                    <div class="absolute right-0 top-full translate-y-3">
                        <x-button color="clube" size="md">
                            Enviar mensagem
                        </x-button>
                    </div>
                </div>
            </div>

            <div class="flex items-center gap-x-4">
                <h1 class="text-2xl font-semibold text-gray-800">
                    Rafael Silva da Cunha
                </h1>
            </div>

            <div class="w-full h-full grid grid-cols-10 gap-4">
                <div class="col-span-3 h-full rounded-lg bg-white border border-2 border-gray-200 hover:border-emerald-500 transition-colors p-4 flex flex-col gap-4">
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
                                    <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-calendar-icon lucide-calendar"><path d="M8 2v4"/><path d="M16 2v4"/><rect width="18" height="18" x="3" y="4" rx="2"/><path d="M3 10h18"/></svg>
                                </x-slot:icon>
                                
                                17 anos
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
                                    <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-target-icon lucide-target"><circle cx="12" cy="12" r="10"/><circle cx="12" cy="12" r="6"/><circle cx="12" cy="12" r="2"/></svg>
                                </x-slot:icon>

                                Atacante
                            </x-badge>

                            <x-badge color="gray" :border="false">
                                <x-slot:icon>
                                    <svg class="h-4 w-4"xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-ruler-icon lucide-ruler"><path d="M21.3 15.3a2.4 2.4 0 0 1 0 3.4l-2.6 2.6a2.4 2.4 0 0 1-3.4 0L2.7 8.7a2.41 2.41 0 0 1 0-3.4l2.6-2.6a2.41 2.41 0 0 1 3.4 0Z"/><path d="m14.5 12.5 2-2"/><path d="m11.5 9.5 2-2"/><path d="m8.5 6.5 2-2"/><path d="m17.5 15.5 2-2"/></svg>
                                </x-slot:icon>

                                180cm
                            </x-badge>

                            <x-badge color="gray" :border="false">
                                <x-slot:icon>
                                    <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-scale-icon lucide-scale"><path d="m16 16 3-8 3 8c-.87.65-1.92 1-3 1s-2.13-.35-3-1Z"/><path d="m2 16 3-8 3 8c-.87.65-1.92 1-3 1s-2.13-.35-3-1Z"/><path d="M7 21h10"/><path d="M12 3v18"/><path d="M3 7h2c2 0 5-1 7-2 2 1 5 2 7 2h2"/></svg>
                                </x-slot:icon>

                                80kg
                            </x-badge>

                            <x-badge color="gray" :border="false">
                                <x-slot:icon>
                                    <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-mars-icon lucide-mars"><path d="M16 3h5v5"/><path d="m21 3-6.75 6.75"/><circle cx="10" cy="14" r="6"/></svg>
                                </x-slot:icon>

                                Masculino
                            </x-badge>
                        </div>
                    </div>

                    <div class="flex flex-col gap-2">
                        <span class="text-md font-semibold uppercase text-emerald-500 tracking-tight">
                            Contato
                        </span>

                        <span class="inline-flex gap-x-2 text-md font-medium tracking-tight text-emerald-600">
                            Email:

                            <a href="" class="text-md font-medium tracking-tight underline flex items-center gap-x-2 text-emerald-500 hover:text-emerald-700 transition-colors">
                                joaopedroferreiralima@gmail.com
                            </a>
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

                        <x-slot name="futebol">
                            
                        </x-slot>

                        <x-slot name="basquete">

                        </x-slot>
                    </x-tabs>
                </div>
            </div>
        </div>
    </div>
</x-layouts.clube>