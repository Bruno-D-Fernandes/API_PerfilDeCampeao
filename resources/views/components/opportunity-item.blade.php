<x-table tableId="tabela-usuarios" class="h-full">
    <x-slot:header>
        {{-- Coluna combinada: Foto + Nome + Email --}}
        <x-table-header label="Atleta" name="nomeCompletoUsuario" :sortable="true" />
        
        {{-- Localização --}}
        <x-table-header label="Localização" name="cidadeUsuario" :sortable="true" />
        
        {{-- Dados Físicos/Demográficos --}}
        <x-table-header label="Idade / Gênero" name="dataNascimentoUsuario" :sortable="true" />
        
        {{-- Status --}}
        <x-table-header label="Status" name="status" />
        
        {{-- Ações --}}
        <x-table-header label="Ações" />
    </x-slot:header>

    <x-slot:body>
        @forelse($usuarios as $usuario)
            <tr class="hover:bg-gray-50 border-b border-gray-100 transition-colors">
                
                {{-- 1. FOTO E NOME --}}
                <td class="p-[1vw]">
                    <div class="flex items-center gap-[0.83vw]">
                        <img 
                            src="{{ $usuario->fotoPerfilUsuario ? asset('storage/'.$usuario->fotoPerfilUsuario) : asset('assets/images/default-avatar.png') }}" 
                            alt="{{ $usuario->nomeCompletoUsuario }}" 
                            class="h-[2.5vw] w-[2.5vw] rounded-full object-cover border border-gray-200"
                        >
                        <div class="flex flex-col">
                            <span class="text-[0.83vw] font-semibold text-gray-800">
                                {{ $usuario->nomeCompletoUsuario }}
                            </span>
                            <span class="text-[0.73vw] text-gray-500">
                                {{ $usuario->emailUsuario }}
                            </span>
                        </div>
                    </div>
                </td>

                {{-- 2. LOCALIZAÇÃO --}}
                <td class="p-[1vw] text-[0.83vw] text-gray-600">
                    {{ $usuario->cidadeUsuario }} - {{ $usuario->estadoUsuario }}
                </td>

                {{-- 3. IDADE / GÊNERO --}}
                <td class="p-[1vw] text-[0.83vw] text-gray-600">
                    <div class="flex flex-col">
                        <span>
                            {{ \Carbon\Carbon::parse($usuario->dataNascimentoUsuario)->age }} anos
                        </span>
                        <span class="text-[0.73vw] text-gray-400 capitalize">
                            {{ $usuario->generoUsuario }}
                        </span>
                    </div>
                </td>

                {{-- 4. STATUS --}}
                <td class="p-[1vw]">
                    <span class="px-[0.5vw] py-[0.2vw] rounded-full text-[0.73vw] font-medium 
                        {{ $usuario->status === 'approved' ? 'bg-green-100 text-green-700' : '' }}
                        {{ $usuario->status === 'pending' ? 'bg-yellow-100 text-yellow-700' : '' }}
                        {{ $usuario->status === 'rejected' ? 'bg-red-100 text-red-700' : '' }}
                    ">
                        {{ ucfirst($usuario->status) }}
                    </span>
                </td>

                {{-- 5. AÇÕES (VER E REMOVER) --}}
                <td class="p-[1vw]">
                    <div class="flex items-center gap-[0.42vw]">
                        
                        {{-- Botão VER PERFIL --}}
                        <a href="{{ route('clube.usuario.perfil', $usuario->id) }}" title="Ver Perfil">
                            <x-button size="sm" color="blue" type="button">
                                <x-slot:icon>
                                    <svg class="h-[0.83vw] w-[0.83vw]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-eye"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
                                </x-slot:icon>
                            </x-button>
                        </a>

                        {{-- Botão REMOVER DA LISTA --}}
                        <x-button size="sm" color="red" onclick="removerUsuario({{ $usuario->id }})" title="Remover da Lista">
                            <x-slot:icon>
                                <svg class="h-[0.83vw] w-[0.83vw]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trash-2"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/><line x1="10" x2="10" y1="11" y2="17"/><line x1="14" x2="14" y1="11" y2="17"/></svg>
                            </x-slot:icon>
                        </x-button>

                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5" class="p-[2vw] text-center text-gray-500 text-[0.94vw]">
                    Nenhum usuário encontrado nesta lista.
                </td>
            </tr>
        @endforelse
    </x-slot:body>
</x-table>

{{-- Script para a ação de remover (AJAX) --}}
<script>
    async function removerUsuario(id) {
        if(!confirm("Tem certeza que deseja remover este usuário da lista?")) return;

        // Ajuste a URL conforme sua rota de remover da lista
        // Exemplo: /api/clube/lista/remover/{id}
        const url = `/api/clube/lista/usuario/${id}`; 

        try {
            const response = await fetch(url, {
                method: 'DELETE', // ou POST dependendo da sua rota
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            });

            if(response.ok) {
                window.location.reload();
            } else {
                alert("Erro ao remover usuário.");
            }
        } catch (e) {
            console.error(e);
            alert("Erro de conexão.");
        }
    }
</script>