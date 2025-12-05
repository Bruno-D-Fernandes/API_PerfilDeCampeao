<x-layouts.clube title="Minhas Listas" :breadcrumb="[
    'Dashboard' => route('clube.dashboard'),
    'Minhas Listas' => null
]">
    @php
        $clube = auth()->guard('club')->user();
        $listas = $clube->listas;
    @endphp

    <div id="toast-container" class="fixed top-[0.83vw] left-[0.83vw] z-[9999] flex flex-col gap-[0.63vw] pointer-events-auto"></div>

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
                <x-button color="gray" size="md" onclick="document.querySelector('#create-list-form').reset(); closeModal('create-list')">
                    Cancelar
                </x-button>

                <x-button color="clube" size="md" onclick="submitAjax('create-list-form', '/api/clube/listas', 'POST', 'create-list', null, 'Sucesso!', 'Lista criada com sucesso!', 'Erro!', 'Ocorreu um erro ao criar a lista.')">
                    Salvar
                </x-button>
            </div>
        </x-slot:footer>
    </x-modal>

    <div id="lists-grid" class="grid grid-cols-3 gap-[0.83vw]">
        @include('clube.partials.lists-grid', ['listas' => $listas])
    </div>

    <div id="lists-loading" class="absolute inset-0 bg-white/50 backdrop-blur-sm z-[9999] flex items-center justify-center hidden rounded-[0.42vw]">
        <svg class="animate-spin h-[1.67vw] w-[1.67vw] text-emerald-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
    </div>
</x-layouts.clube>

<script>
    function showListsLoading() {
        document.getElementById('lists-loading').classList.remove('hidden');
    }

    function hideListsLoading() {
        document.getElementById('lists-loading').classList.add('hidden');
    }

    async function submitAjax(formId, url, method, modalName, listId = null, 
        successTitle = 'Sucesso!', 
        successText = 'Operação realizada com êxito.', 
        errorTitle = 'Erro!', 
        errorText = 'A solicitação falhou. Tente novamente.') {

        const form = document.getElementById(formId);
        const formData = new FormData(form);
        const data = Object.fromEntries(formData.entries());

        showListsLoading();

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
        } finally {
            hideListsLoading();
        }
    }

    async function deleteListAjax(id, modalName) {
        showListsLoading();

        try {
            const response = await fetch(`/api/clube/listas/${id}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document
                        .querySelector('meta[name="csrf-token"]')
                        .getAttribute('content'),
                    'Accept': 'application/json'
                }
            });

            const data = await response.json();

            if (!response.ok) {
                showToast('error', 'Erro!', data.message || 'Falha ao excluir.');
                return;
            }

            closeModal(modalName);

            const gridEl = document.getElementById('lists-grid');
            if (gridEl) {
                if (data.html && data.html.trim() !== '') {
                    gridEl.innerHTML = data.html;
                } else {
                    gridEl.innerHTML = `
                        <div class="p-[0.42vw] flex items-center justify-center h-full">
                            <x-empty-state text="Nenhuma lista encontrada.">
                                <x-slot:icon>
                                    <svg class="h-[1.67vw] w-[1.67vw] text-gray-400" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-user-x-icon lucide-user-x"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><line x1="17" x2="22" y1="8" y2="13"/><line x1="22" x2="17" y1="8" y2="13"/></svg>
                                </x-slot:icon>
                                <p class="text-gray-400 font-normal text-[0.83vw]">
                                    Não há listas cadastradas no momento.
                                </p>
                            </x-empty-state>
                        </div>
                    `;
                }
            }

            showToast('success', 'Excluído!', 'A lista foi removida com sucesso.');
        } catch (error) {
            console.error('Erro na requisição:', error);
            showToast('error', 'Erro!', 'Erro de conexão.');
        } finally {
            hideListsLoading();
        }
    }

</script>