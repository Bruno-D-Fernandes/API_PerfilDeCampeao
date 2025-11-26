<x-layouts.clube title="Configurações" :breadcrumb="[
    'Dashboard' => route('clube.dashboard'),
    'Configurações' => null
]">
    <div class="w-full h-full flex flex-col gap-4 border border-2 border-gray-200 rounded-lg p-4">
        <div class="flex flex-col gap-4">
            <span class="text-lg text-emerald-700 font-semibold">
                Preferências
            </span>

            <div class="flex flex-col gap-4">
                <div class="flex items-center justify-between cursor-pointer w-full rounded-lg h-[3.75rem] bg-white hover:bg-gray-50 transition-colors p-3">
                    <div class="h-full flex items-center gap-x-2">
                        <div class="h-full aspect-square flex items-center justify-center">
                            <svg class="h-5 w-5 text-emerald-500" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-bell-icon lucide-bell"><path d="M10.268 21a2 2 0 0 0 3.464 0"/><path d="M3.262 15.326A1 1 0 0 0 4 17h16a1 1 0 0 0 .74-1.673C19.41 13.956 18 12.499 18 8A6 6 0 0 0 6 8c0 4.499-1.411 5.956-2.738 7.326"/></svg>
                        </div>

                        <div class="h-full flex flex-col justify-between">
                            <h3 class="text-sm text-emerald-500 font-medium">
                                Notificações
                            </h3>

                            <h4 class="text-xs text-emerald-600/80 font-normal">
                                Controle suas notificações
                            </h4>
                        </div>
                    </div>

                    <svg class="h-4 w-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-right-icon lucide-chevron-right"><path d="m9 18 6-6-6-6"/></svg>
                </div>

                <div class="flex items-center justify-between cursor-pointer w-full rounded-lg h-[3.75rem] bg-white hover:bg-gray-50 transition-colors p-3">
                    <div class="h-full flex items-center gap-x-2">
                        <div class="h-full aspect-square flex items-center justify-center">
                            <svg class="h-5 w-5 text-emerald-500" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-palette-icon lucide-palette"><path d="M12 22a1 1 0 0 1 0-20 10 9 0 0 1 10 9 5 5 0 0 1-5 5h-2.25a1.75 1.75 0 0 0-1.4 2.8l.3.4a1.75 1.75 0 0 1-1.4 2.8z"/><circle cx="13.5" cy="6.5" r=".5" fill="currentColor"/><circle cx="17.5" cy="10.5" r=".5" fill="currentColor"/><circle cx="6.5" cy="12.5" r=".5" fill="currentColor"/><circle cx="8.5" cy="7.5" r=".5" fill="currentColor"/></svg>
                        </div>

                        <div class="h-full flex flex-col justify-between">
                            <h3 class="text-sm text-emerald-500 font-medium">
                                Tema
                            </h3>

                            <h4 class="text-xs text-emerald-600/80 font-normal">
                                Customize a forma como o sistema aparece
                            </h4>
                        </div>
                    </div>

                    <div>
                        <label class="inline-flex items-center cursor-pointer">
                            <input type="checkbox" value="" class="sr-only peer" checked>

                            <div class="relative p-2 w-9 h-5 bg-gray-100 peer-focus:outline-none peer-focus:ring-brand-soft rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-buffer after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-emerald-500"></div>
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex flex-col gap-4">
            <span class="text-lg text-emerald-700 font-semibold">
                Conta
            </span>

            <div class="flex flex-col gap-4">
                <div class="flex items-center justify-between cursor-pointer w-full rounded-lg h-[3.75rem] bg-white hover:bg-gray-50 transition-colors p-3">
                    <div class="h-full flex items-center gap-x-2">
                        <div class="h-full aspect-square flex items-center justify-center">
                            <svg class="h-5 w-5 text-emerald-500" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-file-icon lucide-file"><path d="M6 22a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h8a2.4 2.4 0 0 1 1.704.706l3.588 3.588A2.4 2.4 0 0 1 20 8v12a2 2 0 0 1-2 2z"/><path d="M14 2v5a1 1 0 0 0 1 1h5"/></svg>
                        </div>

                        <div class="h-full flex flex-col justify-between">
                            <h3 class="text-sm text-emerald-500 font-medium">
                                Alterar CNPJ
                            </h3>

                            <h4 class="text-xs text-emerald-600/80 font-normal">
                                Altere o CNPJ
                            </h4>
                        </div>
                    </div>

                    <svg class="h-4 w-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-right-icon lucide-chevron-right"><path d="m9 18 6-6-6-6"/></svg>
                </div>

                <div class="flex items-center justify-between cursor-pointer w-full rounded-lg h-[3.75rem] bg-white hover:bg-gray-50 transition-colors p-3">
                    <div class="h-full flex items-center gap-x-2">
                        <div class="h-full aspect-square flex items-center justify-center">
                            <svg class="h-5 w-5 text-emerald-500" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-mail-icon lucide-mail"><path d="m22 7-8.991 5.727a2 2 0 0 1-2.009 0L2 7"/><rect x="2" y="4" width="20" height="16" rx="2"/></svg>
                        </div>

                        <div class="h-full flex flex-col justify-between">
                            <h3 class="text-sm text-emerald-500 font-medium">
                                Alterar email
                            </h3>

                            <h4 class="text-xs text-emerald-600/80 font-normal">
                                Altere o email
                            </h4>
                        </div>
                    </div>

                    <svg class="h-4 w-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-right-icon lucide-chevron-right"><path d="m9 18 6-6-6-6"/></svg>
                </div>

                <div class="flex items-center justify-between cursor-pointer w-full rounded-lg h-[3.75rem] bg-white hover:bg-gray-50 transition-colors p-3">
                    <div class="h-full flex items-center gap-x-2">
                        <div class="h-full aspect-square flex items-center justify-center">
                            <svg class="h-5 w-5 text-emerald-500" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-lock-icon lucide-lock"><rect width="18" height="11" x="3" y="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                        </div>

                        <div class="h-full flex flex-col justify-between">
                            <h3 class="text-sm text-emerald-500 font-medium">
                                Alterar senha
                            </h3>

                            <h4 class="text-xs text-emerald-600/80 font-normal">
                                Altere sua senha
                            </h4>
                        </div>
                    </div>

                    <svg class="h-4 w-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-right-icon lucide-chevron-right"><path d="m9 18 6-6-6-6"/></svg>
                </div>

                <div class="flex items-center justify-between cursor-pointer w-full rounded-lg h-[3.75rem] bg-white hover:bg-gray-50 transition-colors p-3">
                    <div class="h-full flex items-center gap-x-2">
                        <div class="h-full aspect-square flex items-center justify-center">
                            <svg class="h-5 w-5 text-red-500" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trash-icon lucide-trash"><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6"/><path d="M3 6h18"/><path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                        </div>

                        <div class="h-full flex flex-col justify-between">
                            <h3 class="text-sm text-red-500 font-medium">
                                Excluir conta
                            </h3>

                            <h4 class="text-xs text-red-600/80 font-normal">
                                Exclua sua conta
                            </h4>
                        </div>
                    </div>

                    <svg class="h-4 w-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-right-icon lucide-chevron-right"><path d="m9 18 6-6-6-6"/></svg>
                </div>
            </div>
        </div>

        <div class="flex flex-col gap-4">
            <span class="text-lg text-emerald-700 font-semibold">
                Sobre
            </span>

            <div class="flex flex-col gap-4">
                <div class="flex items-center justify-between cursor-pointer w-full rounded-lg h-[3.75rem] bg-white hover:bg-gray-50 transition-colors p-3">
                    <div class="h-full flex items-center gap-x-2">
                        <div class="h-full aspect-square flex items-center justify-center">
                            <svg class="h-5 w-5 text-emerald-500" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-paperclip-icon lucide-paperclip"><path d="m16 6-8.414 8.586a2 2 0 0 0 2.829 2.829l8.414-8.586a4 4 0 1 0-5.657-5.657l-8.379 8.551a6 6 0 1 0 8.485 8.485l8.379-8.551"/></svg>
                        </div>

                        <div class="h-full flex flex-col justify-between">
                            <h3 class="text-sm text-emerald-500 font-medium">
                                Termos e condições
                            </h3>

                            <h4 class="text-xs text-emerald-600/80 font-normal">
                                Veja os termos e condições
                            </h4>
                        </div>
                    </div>

                    <svg class="h-4 w-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-right-icon lucide-chevron-right"><path d="m9 18 6-6-6-6"/></svg>
                </div>

                <div class="flex items-center justify-between cursor-pointer w-full rounded-lg h-[3.75rem] bg-white hover:bg-gray-50 transition-colors p-3">
                    <div class="h-full flex items-center gap-x-2">
                        <div class="h-full aspect-square flex items-center justify-center">
                            <svg class="h-5 w-5 text-emerald-500" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-file-lock-icon lucide-file-lock"><path d="M4 9.8V4a2 2 0 0 1 2-2h8a2.4 2.4 0 0 1 1.706.706l3.588 3.588A2.4 2.4 0 0 1 20 8v12a2 2 0 0 1-2 2h-3"/><path d="M14 2v5a1 1 0 0 0 1 1h5"/><path d="M9 17v-2a2 2 0 0 0-4 0v2"/><rect width="8" height="5" x="3" y="17" rx="1"/></svg>
                        </div>

                        <div class="h-full flex flex-col justify-between">
                            <h3 class="text-sm text-emerald-500 font-medium">
                                Políticas de privacidade
                            </h3>

                            <h4 class="text-xs text-emerald-600/80 font-normal">
                                Veja as politicas de privacidade
                            </h4>
                        </div>
                    </div>

                    <svg class="h-4 w-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-right-icon lucide-chevron-right"><path d="m9 18 6-6-6-6"/></svg>
                </div>
            </div>
        </div>
    </div>
</x-layouts.clube>