<x-layouts.clube title="Minhas Listas" :breadcrumb="[
    'Dashboard' => route('clube.dashboard'),
    'Minhas Listas' => null
]">
    @php
        $clube = auth()->guard('club')->user();
        $listas = $clube->listas;
    @endphp

    <div id="toast-container" class="fixed top-4 left-4 z-[9999] flex flex-col gap-3 pointer-events-auto"></div>

    <x-slot:action>
        <x-button onclick="openModal('create-list')" color="clube" size="sm">
            <x-slot:icon>
                <svg class="h-[0.83vw] w-[0.83vw] stroke-[0.1vw]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
            </x-slot:icon>

            Criar Lista
        </x-button>
    </x-slot:action>

    <x-modal maxWidth="xl" name="create-list" title="Criar lista" titleSize="[1.25vw]" titleColor="green">
        <x-form id="create-list-form" method="POST">
            @csrf
            <div class="flex flex-col gap-[0.42vw]">
                <x-form-group label="Nome" name="nome" id="lista-nome" labelColor="green" textSize="[1.04vw]">
                    <x-slot:icon>
                        <svg class="h-[0.83vw] w-[0.83vw] stroke-[0.1vw]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><path d="M12 4v16"/><path d="M4 7V5a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v2"/><path d="M9 20h6"/></svg>
                    </x-slot:icon>
                </x-form-group>

                <x-form-group label="Descrição" name="descricao" id="lista-descricao" labelColor="green" textSize="[1.04vw]">
                    <x-slot:icon>
                        <svg class="h-[0.83vw] w-[0.83vw] stroke-[0.1vw]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><path d="M21 5H3"/><path d="M17 12H7"/><path d="M19 19H5"/></svg>
                    </x-slot:icon>
                </x-form-group>
            </div>
        </x-form>

        <x-slot:footer>
            <div class="w-full flex gap-x-[0.42vw] justify-end">
                <x-button color="gray" size="md" onclick="resetAndClose('cr-list-form', 'create-list')">
                    Cancelar
                </x-button>

                <x-button color="clube" size="md" onclick="submitAjax('create-list-form', '/api/clube/listas', 'POST', 'create-list', null, 'Sucesso!', 'Lista criada com sucesso!', 'Erro!', 'Ocorreu um erro ao criar a lista.')">
                    Salvar
                </x-button>
            </div>
        </x-slot:footer>
    </x-modal>

    <div id="lists-grid" class="grid grid-cols-3 gap-[0.83vw]">
        <button class="group break-inside-avoid w-full h-[9vw] rounded-[0.42vw] border-[0.15vw] border-dashed border-emerald-500 hover:border-emerald-600 bg-white flex flex-col items-center justify-center gap-[0.83vw] cursor-pointer hover:-translate-y-[0.1vw] transition-transform transition-colors disabled:opacity-50 disabled:cursor-not-allowed" onclick="openModal('create-list')">
            <svg class="h-[3.33vw] w-[3.33vw] text-emerald-500 group-hover:text-emerald-600 stroke-[0.1vw]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="M12 5v14"/></svg>

            <h3 class="text-[0.94vw] font-semibold text-emerald-500 group-hover:text-emerald-600">
                Criar nova lista
            </h3>
        </button>

        @foreach($listas as $item)
            @include('clube.partials.list-card', ['item' => $item])
        @endforeach
    </div>
</x-layouts.clube>

<script>
    async function submitAjax(formId, url, method, modalName, listId = null, 
        successTitle = 'Sucesso!', 
        successText = 'Operação realizada com êxito.', 
        errorTitle = 'Erro!', 
        errorText = 'A solicitação falhou. Tente novamente.') {

        const form = document.getElementById(formId);
        const formData = new FormData(form);
        const data = Object.fromEntries(formData.entries());

        try {
            const response = await fetch(url, {
                method: method,
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                },
                credentials: 'include',
                body: JSON.stringify(data)
            });

            if (!response.ok) {
                const errorData = await response.json();
                
                const detailedErrorText = errorText + ' Detalhe: ' + (errorData.message || 'Erro de servidor.');
                
                showToast('error', errorTitle, detailedErrorText);
                return;
            }

            const result = await response.json();

            resetAndClose(formId, modalName);

            if (method === 'POST') {
                if (result.html) {
                    const grid = document.getElementById('lists-grid');
                    grid.insertAdjacentHTML('beforeend', result.html);
                }
            } else if (method === 'PUT' && listId) {
                const nameEl = document.getElementById(`list-nome-${listId}`);
                const descEl = document.getElementById(`list-desc-${listId}`);

                if (nameEl) nameEl.textContent = result.data.nome;
                if (descEl) descEl.textContent = result.data.descricao;
            }

            const finalSuccessText = result.message || successText;

            showToast('success', successTitle, finalSuccessText);

        } catch (error) {
            console.error('Erro na requisição:', error);
            showToast('error', errorTitle, 'Erro de conexão ou falha no processamento de dados.');
        }
    }
</script>