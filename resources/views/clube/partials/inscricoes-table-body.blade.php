@forelse($inscricoes as $inscricao)
    @php
        $usuario = $inscricao->usuario;
    @endphp

    <tr class="hover:bg-gray-50 border-b border-gray-100 transition-colors">
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

        <td class="p-[0.75vw] text-[0.73vw] text-gray-700">
            {{ $usuario->cidadeUsuario }} - {{ $usuario->estadoUsuario }}
        </td>

        <td class="p-[0.75vw] text-[0.73vw] text-gray-700">
            {{ \Carbon\Carbon::parse($usuario->dataNascimentoUsuario)->age }} anos
        </td>

        <td class="p-[0.75vw] text-[0.73vw] text-gray-700 capitalize">
            {{ $usuario->generoUsuario }}
        </td>

        @php
            $inscBadgeColor = match($inscricao->status) {
                'rejected' => 'red',
                'approved' => 'green',
                default => 'gray',
            };
        @endphp

        <td class="p-[0.75vw] text-[0.73vw] text-gray-700 capitalize">
            <x-badge color="{{ $inscBadgeColor }}" :border="false" class="px-2.5">
                {!! $inscricao->showHTMLStatus() !!}
            </x-badge>
        </td>

        <td class="p-[0.75vw]">
            <div class="flex items-center gap-[0.42vw]">
                <x-button size="sq" color="blue" type="button">
                    <svg class="h-[0.83vw] w-[0.83vw]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-user-icon lucide-user"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                </x-button>

                @if($inscricao->status === $inscricao::STATUS_APPROVED)
                    <x-button size="sq" color="red" onclick="openModal('remove-user-{{ $usuario->id }}')" title="Remover da Lista">
                        <svg class="h-[0.83vw] w-[0.83vw]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-x-icon lucide-x"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
                    </x-button>
                @elseif($inscricao->status === $inscricao::STATUS_PENDING)
                    <x-button size="sq" color="green" type="button">
                        <svg class="h-[0.83vw] w-[0.83vw]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-check-icon lucide-check"><path d="M20 6 9 17l-5-5"/></svg>
                    </x-button>

                    <x-button size="sq" color="red" onclick="openModal('remove-user-{{ $usuario->id }}')">
                        <svg class="h-[0.83vw] w-[0.83vw]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-x-icon lucide-x"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
                    </x-button>
                @else
                    <x-button size="sq" color="red" onclick="openModal('remove-user-{{ $usuario->id }}')">
                        <svg class="h-[0.83vw] w-[0.83vw]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-x-icon lucide-x"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
                    </x-button>
                @endif
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