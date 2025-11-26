<x-layouts.base :title="$title">
    <x-sidebar>
        <x-slot:logo>
            <div class="h-full flex flex-col gap-y-1 items-center p-3">
                <img src="{{ asset('img/logo-side-clube.png') }}" alt="" class="h-24 object-contain aspect-square">

                <span class="text-xl font-semibold text-emerald-500 tracking-tight">
                    Perfil de Campeão
                </span>
            </div>
        </x-slot:logo>

        <x-sidebar-section title="geral">
            <x-sidebar-link :href="route('clube.dashboard')" label="Dashboard">
                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-layout-dashboard-icon lucide-layout-dashboard"><rect width="7" height="9" x="3" y="3" rx="1"/><rect width="7" height="5" x="14" y="3" rx="1"/><rect width="7" height="9" x="14" y="12" rx="1"/><rect width="7" height="5" x="3" y="16" rx="1"/></svg>
            </x-sidebar-link>

            <x-sidebar-link :href="route('clube.oportunidades')" label="Oportunidades">
                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-megaphone-icon lucide-megaphone"><path d="M11 6a13 13 0 0 0 8.4-2.8A1 1 0 0 1 21 4v12a1 1 0 0 1-1.6.8A13 13 0 0 0 11 14H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2z"/><path d="M6 14a12 12 0 0 0 2.4 7.2 2 2 0 0 0 3.2-2.4A8 8 0 0 1 10 14"/><path d="M8 6v8"/></svg>
            </x-sidebar-link>

            <x-sidebar-link :href="route('clube.listas')" label="Listas">
                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-logs-icon lucide-logs"><path d="M3 5h1"/><path d="M3 12h1"/><path d="M3 19h1"/><path d="M8 5h1"/><path d="M8 12h1"/><path d="M8 19h1"/><path d="M13 5h8"/><path d="M13 12h8"/><path d="M13 19h8"/></svg>
            </x-sidebar-link>

            <x-sidebar-link :href="route('clube.agenda')" label="Agenda">
                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-calendar-days-icon lucide-calendar-days"><path d="M8 2v4"/><path d="M16 2v4"/><rect width="18" height="18" x="3" y="4" rx="2"/><path d="M3 10h18"/><path d="M8 14h.01"/><path d="M12 14h.01"/><path d="M16 14h.01"/><path d="M8 18h.01"/><path d="M12 18h.01"/><path d="M16 18h.01"/></svg>
            </x-sidebar-link>

            <x-sidebar-link :href="route('clube.mensagens')" label="Mensagens">
                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-message-circle-more-icon lucide-message-circle-more"><path d="M2.992 16.342a2 2 0 0 1 .094 1.167l-1.065 3.29a1 1 0 0 0 1.236 1.168l3.413-.998a2 2 0 0 1 1.099.092 10 10 0 1 0-4.777-4.719"/><path d="M8 12h.01"/><path d="M12 12h.01"/><path d="M16 12h.01"/></svg>
            </x-sidebar-link>

            <x-sidebar-link :href="route('clube.pesquisa')" label="Pesquisa">
                <svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="m21 21-3.5-3.5M17 10a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z"/>
                </svg>
            </x-sidebar-link>
        </x-sidebar-section>

        <x-sidebar-section title="Conta">
            <x-sidebar-link :href="route('clube.perfil')" label="Perfil">
                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-user-icon lucide-user"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
            </x-sidebar-link>

            <x-sidebar-link :href="route('clube.configuracoes')" label="Configurações">
                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-bolt-icon lucide-bolt"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/><circle cx="12" cy="12" r="4"/></svg>
            </x-sidebar-link>

            <x-sidebar-link href="javascript:void(0)" onclick="openModal('logout-modal')" label="Sair" context="logout">
                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-door-open-icon lucide-door-open"><path d="M11 20H2"/><path d="M11 4.562v16.157a1 1 0 0 0 1.242.97L19 20V5.562a2 2 0 0 0-1.515-1.94l-4-1A2 2 0 0 0 11 4.561z"/><path d="M11 4H8a2 2 0 0 0-2 2v14"/><path d="M14 12h.01"/><path d="M22 20h-3"/></svg>
            </x-sidebar-link>
        </x-sidebar-section>
    </x-sidebar>

    <div class="sm:ml-80 h-screen flex flex-col">  
        <x-topbar :title="$title" :breadcrumb="$breadcrumb" context="clube">
            @if(isset($action))
                <x-slot:action>
                    {{ $action }}
                </x-slot:action>
            @endif
        </x-topbar>

        <main class="sm:mt-[6.75rem] flex-1 p-8">
            {{ $slot }}
        </main>
    </div>

    <x-modal name="logout-modal" title="Encerrar sessão" titleSize="xl" titleColor="red" maxWidth="md">
        <div class="p-4 text-center">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100 mb-4">
                <svg class="h-6 w-6 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
            </div>
            
            <h3 class="text-lg leading-6 font-medium text-gray-900">Tem certeza que deseja sair?</h3>

            <p class="text-sm text-gray-500 mt-2">
                Você precisará informar suas credenciais novamente para acessar o painel.
            </p>
        </div>

        <x-slot:footer>
            <div class="w-full flex gap-x-2 justify-end">
                <x-button color="gray" size="md" onclick="closeModal('logout-modal')">
                    Cancelar
                </x-button>

                <form method="POST" action="">
                    @csrf
                    <x-button type="submit" color="red" size="md">
                        Sim, sair
                    </x-button>
                </form>
            </div>
        </x-slot:footer>
    </x-modal>
</x-layouts.base>