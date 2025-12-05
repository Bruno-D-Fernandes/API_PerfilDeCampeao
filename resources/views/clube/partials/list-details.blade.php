<div class="flex items-center justify-between">
    <div class="w-full flex items-center gap-x-[0.83vw]">
        <div class="h-[2.5vw] w-[2.5vw] rounded-lg bg-emerald-500 flex items-center justify-center">
            <svg class="h-[1.25vw] w-[1.25vw] text-white" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-folder-icon lucide-folder"><path d="M20 20a2 2 0 0 0 2-2V8a2 2 0 0 0-2-2h-7.9a2 2 0 0 1-1.69-.9L9.6 3.9A2 2 0 0 0 7.93 3H4a2 2 0 0 0-2 2v13a2 2 0 0 0 2 2Z"/></svg>
        </div>

        <h2 class="text-[1.88vw] font-medium tracking-tight text-emerald-500">
            {{ $lista->nome }}
        </h2>
    </div>

    <div class="flex items-center gap-x-[0.42vw]">
        <x-icon-button color="blue" onclick="openModal('edit-list-{{ $lista->id }}')">
            <svg class="h-[1.25vw] w-[1.25vw]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-square-pen-icon lucide-square-pen"><path d="M12 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.375 2.625a1 1 0 0 1 3 3l-9.013 9.014a2 2 0 0 1-.853.505l-2.873.84a.5.5 0 0 1-.62-.62l.84-2.873a2 2 0 0 1 .506-.852z"/></svg>
        </x-icon-button>

        <div class="w-px h-[0.83vw] bg-gray-200"></div>

        <x-icon-button color="red">
            <svg class="h-[1.25vw] w-[1.25vw]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trash-icon lucide-trash"><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6"/><path d="M3 6h18"/><path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
        </x-icon-button>
    </div>
</div>  

<div class="flex flex-col gap-[0.83vw]">
    <h3 class="text-[0.83vw] font-normal text-gray-600">
        {{ $lista->descricao }}
    </h3>
    
    <div class="flex gap-x-[0.83vw] items-center">
        <div class="flex gap-x-[0.42vw] items-center text-gray-500">
            <svg class="h-[1.04vw] w-[1.04vw]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-calendar-icon lucide-calendar"><path d="M8 2v4"/><path d="M16 2v4"/><rect width="18" height="18" x="3" y="4" rx="2"/><path d="M3 10h18"/></svg>

            <span class="text-[0.73vw] font-medium">
                Criada em: {{ \Carbon\Carbon::parse($lista->created_at)->format('d/m/Y') }}  
            </span>
        </div>

        <div class="flex gap-x-[0.42vw] items-center text-emerald-500">
            <svg class="h-[1.04vw] w-[1.04vw]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-users-icon lucide-users"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><path d="M16 3.128a4 4 0 0 1 0 7.744"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><circle cx="9" cy="7" r="4"/></svg>

            <span class="text-[0.83vw] font-medium">
                {{ $lista->usuarios->count() }}
            </span>
        </div>
    </div>
</div>

<div class="w-full flex justify-center">
    <x-table tableId="tabela-usuarios">
        <x-slot:header>
            <x-table-header label="Atleta" name="nomeCompletoUsuario" :sortable="true" />
            
            <x-table-header label="Localização" name="cidadeUsuario" :sortable="true" />
            
            <x-table-header label="Idade" name="dataNascimentoUsuario" :sortable="true" />

            <x-table-header label="Gênero" name="generoUsuario" :sortable="true" />
            
            <x-table-header label="Ações" />
        </x-slot:header>

        <x-slot:body>
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

                    <td class="p-[0.75vw]">
                        <div class="flex items-center gap-[0.42vw]">
                            <a href="{{  route('usuarios.perfil', $usuario->id) }}">
                                <x-button size="sq" color="green" type="button">
                                    <svg class="h-[0.83vw] w-[0.83vw]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-user-icon lucide-user"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                                </x-button>
                            </a>

                            <x-button size="sq" color="red" onclick="openModal('remove-user-{{ $usuario->id }}')" title="Remover da Lista">
                                <svg class="h-[0.83vw] w-[0.83vw]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trash-2"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/><line x1="10" x2="10" y1="11" y2="17"/><line x1="14" x2="14" y1="11" y2="17"/></svg>
                            </x-button>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="p-[1.25vw] text-center text-gray-500 text-[0.94vw]">
                        Nenhum usuário encontrado nesta lista.
                    </td>
                </tr>
            @endforelse
        </x-slot:body>
    </x-table>
</div>

@foreach($usuarios as $usuario)
    <x-modal maxWidth="lg" name="remove-user-{{ $usuario->id }}" title="Remover usuário" titleSize="xl" titleColor="red">
        <div class="p-[0.83vw] text-center">
            <div class="mx-auto flex items-center justify-center h-[2.5vw] w-[2.5vw] rounded-full bg-red-100 mb-[0.83vw]">
                <svg class="h-[1.25vw] w-[1.25vw] text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
            </div>
            <h3 class="text-[0.94vw] leading-6 font-medium text-gray-900">Tem certeza absoluta?</h3>
            <p class="text-[0.73vw] text-gray-500 mt-[0.42vw]">
                Você está prestes a remover <strong>"{{ $usuario->nomeCompletoUsuario }}"</strong> da lista <strong>{{ $lista->nome }}</strong>. Essa ação é irreversível.
            </p>
        </div>

        <x-slot:footer>
            <div class="w-full flex gap-x-[0.42vw] justify-end">
                <x-button color="gray" size="md" onclick="closeModal('remove-user-{{ $usuario->id }}')">Cancelar</x-button>

                <x-button 
                    color="red" 
                    size="md" 
                    onclick="confirmDeleteUser({{ $usuario->id }}, '{{ $lista->id }}')"
                >
                    Sim, remover
                </x-button>
            </div>
        </x-slot:footer>
    </x-modal>
@endforeach

<x-modal maxWidth="xl" name="edit-list-{{ $lista->id }}" title="Editar lista" titleSize="[1.25vw]" titleColor="blue">
    <x-form id="edit-list-{{ $lista->id }}-form">
        @csrf
        <div class="flex flex-col gap-[0.42vw]">
            <x-form-group label="Nome" name="nome" id="lista-nome" labelColor="blue" textSize="[1.04vw]" value="{{ $lista->nome }}">
                <x-slot:icon>
                    <svg class="h-[0.83vw] w-[0.83vw]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 4v16"/><path d="M4 7V5a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v2"/><path d="M9 20h6"/></svg>
                </x-slot:icon>
            </x-form-group>

            <x-form-group label="Descrição" name="descricao" id="lista-descricao" labelColor="blue" textSize="[1.04vw]" value="{{ $lista->descricao }}">
                <x-slot:icon>
                    <svg class="h-[0.83vw] w-[0.83vw]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 5H3"/><path d="M17 12H7"/><path d="M19 19H5"/></svg>
                </x-slot:icon>
            </x-form-group>
        </div>
    </x-form>

    <x-slot:footer>
        <div class="w-full flex gap-x-[0.42vw] justify-end">
            <x-button color="gray" size="md" onclick="resetAndClose('edit-list-{{ $lista->id }}-form', 'edit-list-{{ $lista->id }}')">
                Cancelar
            </x-button>

            <x-button color="none" size="md" class="bg-sky-300 text-white hover:bg-sky-600" onclick="saveListAjax({{ $lista->id }})">
                Salvar
            </x-button>
        </div>
    </x-slot:footer>
</x-modal>

<x-modal maxWidth="xl" name="delete-list-{{ $lista->id }}" title="Excluir lista" titleSize="[1.04vw]" titleColor="red">
    <div class="p-[0.83vw] text-center">
        <div class="mx-auto flex items-center justify-center h-[2.5vw] w-[2.5vw] rounded-full bg-red-100 mb-[0.83vw]">
            <svg class="h-[1.25vw] w-[1.25vw] text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
            </svg>
        </div>
        <h3 class="text-[0.94vw] leading-6 font-medium text-gray-900">Tem certeza absoluta?</h3>
        <p class="text-[0.73vw] text-gray-500 mt-[0.42vw]">
            Você está prestes a excluir <strong>"{{ $lista->nome }}"</strong>. Essa ação é irreversível.
        </p>
    </div>

    <x-slot:footer>
        <div class="w-full flex gap-x-[0.42vw] justify-end">
            <x-button color="gray" size="md" onclick="closeModal('delete-list-{{ $lista->id }}')">Cancelar</x-button>
            <x-button color="red" size="md">Sim, excluir</x-button>
        </div>
    </x-slot:footer>
</x-modal>

<script>
    function saveListAjax(listId) {
        const form = document.getElementById(`edit-list-${listId}-form`);
        const formData = new FormData(form);
        formData.append('_method', 'PUT');

        showListLoading();

        fetch(`/api/clube/listas/${listId}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            },
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            document.querySelector('#list-details').innerHTML = data.html;
        })
        .catch(err => {
            console.error(err);
            alert('Erro na requisição!');
        })
        .finally(() => {
            hideListLoading();
        });
    }

    function deleteListAjax(listId) {
        if (!confirm('Tem certeza que deseja excluir esta oportunidade?')) return;

        showOpportunityLoading();

        fetch(`/api/oportunidades/${opportunityId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            }
        })
        .then(res => res.json())
        .then(data => {
            hideOpportunityLoading();
            if (data.success) {
                alert('Oportunidade excluída!');
                window.location.href = '/oportunidades';
            } else {
                alert(data.message || 'Erro ao excluir!');
            }
        })
        .catch(err => {
            hideOpportunityLoading();
            console.error(err);
            alert('Erro na requisição!');
        });
    }
</script>