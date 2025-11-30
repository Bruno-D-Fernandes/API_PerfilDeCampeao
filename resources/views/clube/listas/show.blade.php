<x-layouts.clube title="Zagueiros - Futebol" :breadcrumb="[
    'Dashboard' => route('clube.dashboard'),
    'Minhas Listas' => route('clube.listas'),
    'Zagueiros - Futebol' => null
]">
    <div class="w-full h-full flex flex-col gap-[0.83vw]">
        <a href="" class="flex items-center gap-x-[0.21vw] text-emerald-500 hover:text-emerald-700 transition-colors font-medium">
            <svg class="w-[0.83vw] h-[0.83vw] stroke-[0.052vw]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-left-icon lucide-chevron-left"><path d="m15 18-6-6 6-6"/></svg>

            Voltar
        </a>

        <div class="relative w-full flex flex-col gap-[0.83vw]">
            <div class="flex items-center justify-between">
                <div class="w-full flex items-center gap-x-[0.83vw]">
                    <div class="h-[2.5vw] w-[2.5vw] rounded-lg bg-emerald-500 flex items-center justify-center">
                        <svg class="h-[1.25vw] w-[1.25vw] text-white" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-folder-icon lucide-folder"><path d="M20 20a2 2 0 0 0 2-2V8a2 2 0 0 0-2-2h-7.9a2 2 0 0 1-1.69-.9L9.6 3.9A2 2 0 0 0 7.93 3H4a2 2 0 0 0-2 2v13a2 2 0 0 0 2 2Z"/></svg>
                    </div>

                    <h2 class="text-[1.88vw] font-medium tracking-tight text-emerald-500">
                        Zagueiros - Futebol
                    </h2>
                </div>

                <div class="flex items-center gap-x-[0.42vw]">
                    <x-icon-button color="blue">
                        <svg class="h-[1.25vw] w-[1.25vw]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-square-pen-icon lucide-square-pen"><path d="M12 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.375 2.625a1 1 0 0 1 3 3l-9.013 9.014a2 2 0 0 1-.853.505l-2.873.84a.5.5 0 0 1-.62-.62l.84-2.873a2 2 0 0 1 .506-.852z"/></svg>
                    </x-icon-button>
            
                    <div class="w-px h-[0.83vw] bg-gray-200"></div>

                    <x-icon-button color="red">
                        <svg class="h-[1.25vw] w-[1.25vw]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trash-icon lucide-trash"><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6"/><path d="M3 6h18"/><path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                    </x-icon-button>
                </div>
            </div>  

            <div class="flex flex-col gap-[0.83vw]">
                <h3 class="text-[1.04vw] font-medium text-gray-800">
                    Monitoramento só dos melhores
                </h3>
                
                <div class="flex gap-x-[0.83vw] items-center">
                    <div class="flex gap-x-[0.42vw] items-center text-gray-400">
                        <svg class="h-[1.04vw] w-[1.04vw]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-calendar-icon lucide-calendar"><path d="M8 2v4"/><path d="M16 2v4"/><rect width="18" height="18" x="3" y="4" rx="2"/><path d="M3 10h18"/></svg>

                        <span class="text-[0.83vw] font-medium">
                            Criada em: 10/10/2024
                        </span>
                    </div>

                    <div class="flex gap-x-[0.42vw] items-center text-emerald-500">
                        <svg class="h-[1.04vw] w-[1.04vw]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-users-icon lucide-users"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><path d="M16 3.128a4 4 0 0 1 0 7.744"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><circle cx="9" cy="7" r="4"/></svg>

                        <span class="text-[0.83vw] font-medium">
                            16 atletas
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="w-full flex justify-center">
            <x-table tableId="tabela-usuarios">
                <x-slot:header>
                    {{-- Coluna combinada: Foto + Nome + Email --}}
                    <x-table-header label="Atleta" name="nomeCompletoUsuario" :sortable="true" />
                    
                    {{-- Localização --}}
                    <x-table-header label="Localização" name="cidadeUsuario" :sortable="true" />
                    
                    {{-- Dados Físicos/Demográficos --}}
                    <x-table-header label="Idade" name="dataNascimentoUsuario" :sortable="true" />

                    <x-table-header label="Gênero" name="generoUsuario" :sortable="true" />
                    
                    {{-- Ações --}}
                    <x-table-header label="Ações" />
                </x-slot:header>

                <x-slot:body>
                    @forelse($usuarios as $usuario)
                        <tr class="hover:bg-gray-50 border-b border-gray-100 transition-colors">
                            
                            {{-- 1. FOTO E NOME --}}
                            <td class="p-[0.75vw]">
                                <div class="flex items-center gap-[0.83vw]">
                                    <img 
                                        src="{{ $usuario->fotoPerfilUsuario ? asset('storage/'.$usuario->fotoPerfilUsuario) : asset('assets/images/default-avatar.png') }}" 
                                        alt="{{ $usuario->nomeCompletoUsuario }}" 
                                        class="h-[2vw] w-[2vw] rounded-full object-cover border border-gray-200"
                                    >
                                    <div class="flex flex-col">
                                        <span class="text-[0.73vw] font-semibold text-gray-800">
                                            {{ $usuario->nomeCompletoUsuario }}
                                        </span>
                                        <span class="text-[0.63vw] text-gray-500">
                                            {{ $usuario->emailUsuario }}
                                        </span>
                                    </div>
                                </div>
                            </td>

                            {{-- 2. LOCALIZAÇÃO --}}
                            <td class="p-[0.75vw] text-[0.73vw] text-gray-700">
                                {{ $usuario->cidadeUsuario }} - {{ $usuario->estadoUsuario }}
                            </td>

                            <td class="p-[0.75vw] text-[0.73vw] text-gray-700">
                                {{ \Carbon\Carbon::parse($usuario->dataNascimentoUsuario)->age }} anos
                            </td>

                            {{-- 3. IDADE / GÊNERO --}}
                            <td class="p-[0.75vw] text-[0.73vw] text-gray-700 capitalize">
                                {{ $usuario->generoUsuario }}
                            </td>

                            {{-- 5. AÇÕES (VER E REMOVER) --}}
                            <td class="p-[0.75vw]">
                                <div class="flex items-center gap-[0.42vw]">
                                    
                                    {{-- Botão VER PERFIL --}}
                                    <a>
                                        <x-button size="sq" color="green" type="button">
                                            <svg class="h-[0.83vw] w-[0.83vw]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-user-icon lucide-user"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                                        </x-button>
                                    </a>

                                    {{-- Botão REMOVER DA LISTA --}}
                                    <x-button size="sq" color="red" onclick="removerUsuario({{ $usuario->id }})" title="Remover da Lista">
                                        <svg class="h-[0.83vw] w-[0.83vw]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trash-2"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/><line x1="10" x2="10" y1="11" y2="17"/><line x1="14" x2="14" y1="11" y2="17"/></svg>
                                    </x-button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="p-[1.25vw] text-center text-gray-500 text-[0.94vw]">
                                Nenhum usuário encontrado nesta lista.
                            </td>
                        </tr>
                    @endforelse
                </x-slot:body>
            </x-table>
        </div>
    </div>
</x-layouts.clube>