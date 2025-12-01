@forelse($usuarios as $usuario)
<tr class="hover:bg-gray-50 border-b border-gray-100 transition-colors">
    <td class="p-[0.75vw]">
        <div class="flex items-center gap-[0.83vw]">
            <img 
                src="{{ $usuario->fotoPerfilUsuario ? asset('storage/'.$usuario->fotoPerfilUsuario) : asset('assets/images/default-avatar.png') }}" 
                alt="{{ $usuario->nomeCompletoUsuario }}" 
                class="h-[2vw] w-[2vw] rounded-full object-cover border border-gray-200"
            >
            <div class="flex flex-col">
                <span class="text-[0.73vw] font-semibold text-gray-800">{{ $usuario->nomeCompletoUsuario }}</span>
                <span class="text-[0.63vw] text-gray-500">{{ $usuario->emailUsuario }}</span>
            </div>
        </div>
    </td>
    
    <td class="p-[0.75vw] text-[0.73vw] text-gray-700">
        {{ $usuario->cidadeUsuario }} - {{ $usuario->estadoUsuario }}
    </td>

    <td class="p-[0.75vw] text-[0.73vw] text-gray-700">
        {{ \Carbon\Carbon::parse($usuario->dataNascimentoUsuario)->age }} anos
    </td>

    <td class="p-[0.75vw] text-[0.73vw] text-gray-700 capitalize">
        {{ $usuario->generoUsuario }}
    </td>

    <td class="p-[0.75vw]">
        <div class="flex items-center gap-[0.42vw]">
            <x-button size="sq" color="green" type="button">
                <svg class="h-[0.83vw] w-[0.83vw]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/>
                    <circle cx="12" cy="7" r="4"/>
                </svg>
            </x-button>

            <x-button 
                size="sq" 
                color="red" 
                onclick="openModal('remove-user-{{ $usuario->id }}')"
                title="Remover da Lista"
            >
                <svg class="h-[0.83vw] w-[0.83vw]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path d="M3 6h18"/>
                    <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/>
                    <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/>
                    <line x1="10" x2="10" y1="11" y2="17"/>
                    <line x1="14" x2="14" y1="11" y2="17"/>
                </svg>
            </x-button>
        </div>
    </td>
</tr>
@empty
<tr>
    <td colspan="6" class="p-[1.25vw] text-center text-gray-500 text-[0.94vw]">
        Nenhum usuário encontrado nesta lista.
    </td>
</tr>
@endforelse