@props([
    'title'      => '',
    'breadcrumb' => [],
    'color'      => 'emerald-600',
    'type'       => 'Admin',
    'context'    => null,
])

@php
    $user = auth('admin')->user()
        ?? auth('club')->user()
        ?? auth()->user();

    $displayName = $user->nomeClube ?? $user->nome ?? 'Usuário';
@endphp

<nav class="absolute top-0 right-0 left-[16.67vw] z-30 p-[0.5vw] border-b-[0.052vw] border-gray-300">
    <div class="flex items-center justify-between">
        <div class="flex flex-col">
            @if(!empty($breadcrumb) && is_array($breadcrumb))
                <nav class="flex items-center gap-[0.42vw] text-[0.63vw] font-medium text-gray-500 mb-[0.42vw]">
                    @foreach($breadcrumb as $key => $item)
                        @php
                            if (is_array($item)) {
                                $label = $item['label'] ?? (is_string($key) ? $key : '');
                                $url   = $item['url']   ?? null;
                            } else {
                                $label = is_string($key) ? $key : (is_string($item) ? $item : '');
                                $url   = is_string($item) ? $item : null;
                            }
                        @endphp

                        @if(!$loop->first)
                            <svg class="h-[0.83vw] w-[0.83vw] stroke-[0.1vw]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                                <path d="m9 18 6-6-6-6"/>
                            </svg>
                        @endif

                        @if(!empty($url))
                            <a href="{{ $url }}" class="hover:text-{{ $color }} transition-colors">
                                {{ $label }}
                            </a>
                        @else
                            <span class="text-gray-600 font-semibold cursor-default">
                                {{ $label }}
                            </span>
                        @endif
                    @endforeach
                </nav>
            @endif

            <div class="flex items-center gap-x-[0.83vw]">
                <h1 class="text-[1.04vw] font-semibold text-{{ $color }} tracking-tight">
                    {{ $title }}
                </h1>

                @if(isset($action))
                    {{ $action }}
                @endif
            </div>
        </div>

        <div class="flex items-center gap-[0.83vw]">
            @if ($user instanceof \App\Models\Clube)
                <button 
                    type="button" 
                    onclick="openDrawer('notifications')" 
                    class="relative group p-[0.42vw] bg-white rounded-full border-[0.052vw] border-gray-300 hover:bg-gray-100 hover:border-gray-400 transition-all duration-200 focus:outline-none focus:ring-0 cursor-pointer"
                >
                    <svg class="w-[0.83vw] h-[0.83vw] text-{{ $color }}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                        <path fill-rule="evenodd" d="M5.25 9a6.75 6.75 0 0113.5 0v.75c0 2.123.8 4.057 2.118 5.52a.75.75 0 01-.297 1.206c-1.544.57-3.16.99-4.831 1.243a3.75 3.75 0 11-7.48 0 24.585 24.585 0 01-4.831-1.244.75.75 0 01-.298-1.205A8.217 8.217 0 005.25 9.75V9zm4.502 8.9a2.25 2.25 0 104.496 0 25.057 25.057 0 01-4.496 0z" clip-rule="evenodd" />
                    </svg>

                    <span class="absolute top-0 right-0 flex h-[0.63vw] w-[0.63vw]">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-{{ $color }} opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-[0.63vw] w-[0.63vw] bg-{{ $color }} border-[0.1vw] border-white"></span>
                    </span>
                </button>
            @endif

            <div class="relative">
                <button 
                    data-dropdown-toggle="dropdown-user" 
                    type="button" 
                    class="w-[10vw] flex items-center gap-[0.42vw] p-[0.42vw] bg-white rounded-[0.31vw] border-[0.052vw] border-gray-300 hover:bg-gray-100 hover:border-gray-400 transition-all group duration-200 cursor-pointer focus:outline-none focus:ring-0"
                >
                    @php
                        $foto = null;

                        if ($user instanceof \App\Models\Clube) {
                            $foto = $user->fotoPerfilClube ?? null;
                        } elseif ($user instanceof \App\Models\Admin) {
                            $foto = $user->foto ?? null;
                        }
                    @endphp

                    <div class="h-[1.46vw] w-[1.46vw] rounded-full bg-{{ $color }}/10 flex items-center justify-center text-{{ $color }} font-bold border-[0.1vw] border-white uppercase text-[0.73vw] overflow-hidden">
                        @if ($foto)
                            <img 
                                src="{{ asset('storage/' . $foto) }}" 
                                alt="Foto de perfil" 
                                class="h-full w-full object-cover"
                            >
                        @else
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="h-[1vw] w-[1vw]">
                                <circle cx="12" cy="8" r="4" fill="currentColor" />
                                <path d="M4 20c0-4 3-7 8-7s8 3 8 7" fill="none" stroke="currentColor" stroke-width="2" />
                            </svg>
                        @endif
                    </div>

                    <div class="text-left block min-w-0 flex-1 flex flex-col justify-between">
                        <p class="text-[0.65vw] font-semibold text-gray-700 leading-none truncate">
                            {{ $displayName }}
                        </p>
                        
                        <p class="text-[0.53vw] font-medium text-gray-400 mt-[0.1vw]">
                            {{ $type }}
                        </p>
                    </div>

                    <svg class="w-[0.83vw] h-[0.83vw] text-gray-400 hover:text-gray-600 stroke-[0.08vw]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                    </svg>
                </button>

                <div id="dropdown-user" class="z-50 hidden text-[0.83vw] list-none bg-white divide-y divide-gray-100 rounded-[0.21vw] shadow-lg w-[9.17vw]">
                    <ul class="p-[0.42vw]" role="none">
                        <li>
                            <a href="{{ $user instanceof App\Models\Clube ? route('clube.perfil', $user->id) : null      }}" class="block p-[0.42vw] text-[0.73vw] text-gray-700 hover:bg-gray-100 rounded-[0.31vw]">
                                Meu Perfil
                            </a>
                        </li>
                        <li>
                            {{-- Espaço pra futuros itens --}}
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <x-drawer id="notifications" width="max-w-[26.67vw]">
        <div class="flex flex-col gap-y-[0.42vw]">
            <div class="flex items-center justify-between">
                <h1 class="text-[1.25vw] font-semibold text-emerald-700 tracking-tight">
                    Notificações
                </h1>

                <x-icon-button color="green" onclick="closeDrawer('notifications')">
                    <svg class="h-[1.04vw] w-[1.04vw]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M18 6 6 18"/><path d="m6 6 12 12"/>
                    </svg>
                </x-icon-button>
            </div>
            
            <div class="w-full h-[2.08vw] bg-gray-50 rounded-[0.42vw] flex items-center justify-between">
                <div class="flex items-center gap-x-[0.42vw] p-[0.42vw]">
                    <x-button
                        color="none"
                        type="button"
                        class="pl-0 pr-0 border-none bg-transparent tab-btn font-semibold text-emerald-600"
                        data-tab-group="notifications-tabs"
                        data-tab-target="all"
                    >
                        Todas
                    </x-button>

                    <x-button
                        color="none"
                        type="button"
                        class="pl-0 pr-0 border-none bg-transparent tab-btn font-medium text-emerald-800"
                        data-tab-group="notifications-tabs"
                        data-tab-target="unread"
                    >
                        Não lidas (10)
                    </x-button>
                </div>

                <x-button color="none" class="pl-0 pr-[0.42vw] border-none text-[0.73vw] font-medium bg-transparent text-emerald-500">
                    <x-slot:icon>
                        <svg class="h-[0.83vw] w-[0.83vw]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M18 6 7 17l-5-5"/><path d="m22 10-7.5 7.5L13 16"/>
                        </svg>
                    </x-slot:icon>

                    Marcar todas como lidas
                </x-button>
            </div>

            <div
                class="flex flex-col gap-y-[0.42vw] tab-panel"
                data-tab-panel-group="notifications-tabs"
                data-tab-panel="all"
            >
                <span class="text-[0.73vw] text-gray-900 uppercase tracking-tight font-semibold">
                    Hoje
                </span>

                <div class="flex flex-col gap-y-[0.42vw]">
                    <div class="flex items-center gap-x-[0.42vw]">
                        <div class="h-[2.92vw] w-[2.92vw] aspect-square rounded-[0.31vw] bg-gray-100 flex items-center justify-center">
                            <svg class="h-[1.25vw] w-[1.25vw] text-emerald-600" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-check-check-icon lucide-check-check"><path d="M18 6 7 17l-5-5"/><path d="m22 10-7.5 7.5L13 16"/></svg>
                        </div>

                        <div class="h-full w-full flex flex-col justify-between">
                            <h3 class="text-[0.73vw] font-medium text-emerald-700">
                                Um administrador do sistema recusou a sua oportunidade.
                            </h3>

                            <h4 class="text-[0.63vw] font-normal text-emerald-900">
                                11 de Outubro às 9:30h
                            </h4>
                        </div>
                    </div>
                </div>
            </div>

            <div
                class="flex flex-col gap-y-[0.42vw] tab-panel hidden"
                data-tab-panel-group="notifications-tabs"
                data-tab-panel="unread"
            >
                <span class="text-[0.73vw] text-gray-900 uppercase tracking-tight font-semibold">
                    Não lidas
                </span>

                <div class="flex flex-col gap-y-[0.42vw]">
                    <div class="flex items-center gap-x-[0.42vw]">
                        <div class="h-[2.92vw] w-[2.92vw] aspect-square rounded-[0.31vw] bg-gray-100 flex items-center justify-center">
                            <svg class="h-[1.25vw] w-[1.25vw] text-emerald-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M11 6a13 13 0 0 0 8.4-2.8A1 1 0 0 1 21 4v12a1 1 0 0 1-1.6.8A13 13 13 0 0 0 11 14H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2z"/>
                                <path d="M6 14a12 12 0 0 0 2.4 7.2 2 2 0 0 0 3.2-2.4A8 8 0 0 1 10 14"/>
                                <path d="M8 6v8"/>
                            </svg>
                        </div>

                        <div class="h-full w-full flex flex-col justify-between">
                            <h3 class="text-[0.73vw] font-medium text-emerald-700">
                                Notificação não lida de exemplo.
                            </h3>

                            <h4 class="text-[0.63vw] font-normal text-emerald-900">
                                10 de Outubro às 14:10h
                            </h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-drawer>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const tabButtons = document.querySelectorAll('[data-tab-group="notifications-tabs"]');
            const tabPanels  = document.querySelectorAll('[data-tab-panel-group="notifications-tabs"]');

            function activateTab(targetName) {
                tabButtons.forEach(btn => {
                    const isActive = btn.dataset.tabTarget === targetName;

                    btn.classList.toggle('font-semibold', isActive);
                    btn.classList.toggle('font-medium', !isActive);

                    btn.classList.toggle('text-emerald-600', isActive);
                    btn.classList.toggle('text-emerald-800', !isActive);
                });

                tabPanels.forEach(panel => {
                    const isActive = panel.dataset.tabPanel === targetName;
                    panel.classList.toggle('hidden', !isActive);
                });
            }

            tabButtons.forEach(btn => {
                btn.addEventListener('click', function () {
                    const target = this.dataset.tabTarget;
                    activateTab(target);
                });
            });

            activateTab('all');
        });
    </script>
</nav>