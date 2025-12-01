<x-layouts.admin title="Esportes" :breadcrumb="[
    'Dashboard' => route('clube.dashboard'),
    'Esportes' => null,
]">
    <div class="h-full w-full flex flex-col overflow-y-hidden">
        
        {{-- TABELA DE ESPORTES --}}
        <x-table tableId="tabela-esportes"> {{-- ID da tabela alterado para esportes --}}
            <x-slot:header>
                <x-table-header label="Nome do Esporte" name="nomeEsporte" :sortable="true" /> {{-- nomeEsporte --}}
                <x-table-header label="Descrição" name="descricaoEsporte" :sortable="true" /> {{-- descricaoEsporte --}}
                <x-table-header label="Status" name="status" />
                <x-table-header label="Ações" />
            </x-slot:header>

            <x-slot:body>
                {{-- O corpo da tabela será preenchido pelo JavaScript --}}
            </x-slot:body>
        </x-table>

        {{-- ======================================================= --}}
        {{-- JS BOILERPLATE: Funções Genéricas, Toast e CRUD --}}
        {{-- ======================================================= --}}
        <script>
            // Variável para a instância da DataTable (para permitir o refresh)
            let esportesDataTable; // Variável alterada
            
            // --- ROTAS BASE API ---
            const ESPORTE_API_BASE_URL = '{{ url("esporte") }}/'; // Rota alterada para 'esporte'
            const TOKEN_KEY = 'admin_token'; 
            
            // --- FUNÇÃO TOAST (Mantida) ---
            window.showToast = (type, title, message) => {
                const colors = { success: "emerald", error: "red", warning: "amber", info: "sky" };
                const color = colors[type] ?? "sky";

                const toast = document.createElement("div");
                toast.className = `toast-alert flex items-start p-3 mb-3 rounded-lg border bg-${color}-50 border-${color}-400 shadow transition-all animate-fade-in-up w-[420px]`;
                toast.innerHTML = `
                    <div class="inline-flex items-center justify-center flex-shrink-0 w-6 h-6 mt-0.5 text-${color}-600">
                        <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="ms-3 text-sm font-medium flex-1">
                        <div class="font-semibold text-${color}-800 mb-0.5">${title}</div>
                        <div class="text-${color}-700">${message}</div>
                    </div>
                    <button onclick="this.parentElement.remove()" 
                        class="cursor-pointer ms-auto -mx-1 -my-1 focus:outline-none rounded-lg p-1 
                        inline-flex items-center justify-center h-7 w-7 text-${color}-500 hover:bg-${color}-100">
                        <svg class="w-3 h-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                    </button>
                `;

                let container = document.getElementById("toast-container");
                if (!container) {
                     container = document.createElement('div');
                     container.id = 'toast-container';
                     container.className = 'fixed top-4 right-4 z-[100] flex flex-col items-end space-y-3';
                     document.body.appendChild(container);
                }

                container.appendChild(toast);
                setTimeout(() => toast.remove(), 4000);
            }

            // --- FUNÇÕES BÁSICAS DE MODAL (Mantidas) ---

            window.openModal = (modalId) => {
                const modal = document.getElementById(modalId);
                if (modal) {
                    modal.classList.remove('hidden');
                    document.body.classList.add('overflow-hidden');
                }
            };

            window.closeModal = (modalId) => {
                const modal = document.getElementById(modalId);
                if (modal) {
                    modal.classList.add('hidden');
                    document.body.classList.remove('overflow-hidden');
                }
            };

            // --- LÓGICA DE EDIÇÃO (PUT) ---
            window.setupAndEditModal = (item) => {
                const modalId = 'edit-modal-generic';
                const form = document.getElementById('edit-form-esporte'); // ID do formulário alterado
                
                if (!form) {
                    console.error('O formulário de edição (edit-form-esporte) não foi encontrado.');
                    return;
                }

                // 1. PREENCHER DADOS
                document.getElementById('edit-id-input').value = item.id;
                document.getElementById('edit-esporte-nome').value = item.nomeEsporte; // Campo alterado
                document.getElementById('edit-esporte-descricao').value = item.descricaoEsporte || ''; // Campo alterado
                
                const newForm = form.cloneNode(true);
                form.parentNode.replaceChild(newForm, form);
                
                newForm.addEventListener('submit', async (e) => {
                    e.preventDefault();
                    const itemId = document.getElementById('edit-id-input').value; 
                    
                    const formData = new FormData(newForm);
                    
                    const data = {
                        nomeEsporte: formData.get('esporte-nome'), // Name do input alterado
                        descricaoEsporte: formData.get('esporte-descricao') // Name do input alterado
                    };
                    
                    try {
                        const response = await fetch(`${ESPORTE_API_BASE_URL}${itemId}`, { // Rota alterada
                            method: 'PUT',
                            headers: {
                                'Content-Type': 'application/json',
                                'Authorization': 'Bearer ' + localStorage.getItem(TOKEN_KEY)
                            },
                            body: JSON.stringify(data),
                        });
                        
                        if (response.ok) {
                            window.showToast('success', 'Sucesso!', `O esporte "${data.nomeEsporte}" foi atualizado.`);
                            closeModal(modalId);
                            if (esportesDataTable && esportesDataTable.refresh) { // Variável alterada
                                esportesDataTable.refresh();
                            }
                        } else {
                            const errorData = await response.json();
                            const errorMessage = errorData.message || response.statusText;
                            window.showToast('error', 'Erro ao Atualizar', `Não foi possível salvar o esporte. Detalhe: ${errorMessage}`);
                        }
                    } catch (error) {
                        console.error('Erro de rede:', error);
                        window.showToast('error', 'Erro de Conexão', 'Não foi possível conectar ao servidor.');
                    }
                });

                // 3. ABRIR O MODAL
                openModal(modalId);
            };

            // --- LÓGICA DE DELEÇÃO (DELETE) ---
            window.setupAndDeleteModal = (id, nomeEsporte) => { // Parâmetro renomeado
                const modalId = 'delete-modal-generic';
                const confirmBtn = document.getElementById('delete-confirm-button');
                
                if (!confirmBtn) {
                    console.error('O botão de confirmação de exclusão não foi encontrado.');
                    return;
                }

                // 1. PREENCHER DADOS
                document.getElementById('delete-nome-display').innerText = nomeEsporte; // Variável alterada

                // 2. CONFIGURAR AÇÃO
                const newConfirmBtn = confirmBtn.cloneNode(true);
                confirmBtn.parentNode.replaceChild(newConfirmBtn, confirmBtn);
                
                newConfirmBtn.addEventListener('click', async () => {
                    
                    try {
                        const response = await fetch(`${ESPORTE_API_BASE_URL}${id}`, { // Rota alterada
                            method: 'DELETE',
                            headers: {
                                'Authorization': 'Bearer ' + localStorage.getItem(TOKEN_KEY)
                            }
                        });
                        
                        if (response.ok || response.status === 204) {
                            window.showToast('success', 'Excluído!', `O esporte "${nomeEsporte}" foi removido com sucesso.`); // Variável alterada
                            if (esportesDataTable && esportesDataTable.refresh) { // Variável alterada
                                esportesDataTable.refresh();
                            }
                        } else {
                            const errorData = await response.json();
                            const errorMessage = errorData.message || response.statusText;
                            window.showToast('error', 'Erro ao Excluir', `Não foi possível excluir o esporte. Detalhe: ${errorMessage}`);
                        }
                        
                        closeModal(modalId);
                    } catch (error) {
                        console.error('Erro de rede:', error);
                        window.showToast('error', 'Erro de Conexão', 'Não foi possível conectar ao servidor.');
                    }
                });

                // 3. ABRIR O MODAL
                openModal(modalId);
            };
        </script>

        {{-- ======================================================= --}}
        {{-- INICIALIZAÇÃO DA DATATABLE E RENDERIZAÇÃO DA LINHA --}}
        {{-- ======================================================= --}}
        <script type="module">
            document.addEventListener('DOMContentLoaded', () => {
                
                esportesDataTable = new DataTable({ // Variável alterada
                    tableId: 'tabela-esportes', // ID da tabela alterado
                    apiUrl: '{{ route("admin.esportes.listar") }}', // Rota alterada (Assumindo que você definirá essa rota)
                    tokenKey: 'admin_token',    
                    renderRow: (item) => {
                        
                        const isAtivo = item.status === 'ativo';
                        
                        const badgeStyle = isAtivo ? {
                            text: 'text-emerald-400',
                            bg: 'bg-emerald-50',
                            border: 'border-emerald-200',
                            dot: 'bg-emerald-400'
                        } : {
                            text: 'text-red-400',
                            bg: 'bg-red-50',
                            border: 'border-red-200',
                            dot: 'bg-red-400'
                        };

                        const btnBase = "cursor-pointer p-[0.42vw] rounded-[0.42vw] hover:bg-gray-100 focus:outline-none transition-colors duration-200";
                        const btnBlue = "text-sky-600 hover:text-sky-700 focus:ring-sky-500";
                        const btnRed = "text-red-600 hover:text-red-700 focus:ring-red-500";
                        
                        return `
                            <tr class="bg-white hover:bg-gray-50 border-b border-gray-100 transition-colors">
                                
                                <td class="px-[1.25vw] py-[0.83vw] text-[0.73vw] text-gray-700 font-medium">
                                    ${item.nomeEsporte}
                                </td>
                                
                                <td class="px-[1.25vw] py-[0.83vw] text-[0.73vw] text-gray-500">
                                    ${item.descricaoEsporte || '<span class="italic text-gray-400">Sem descrição</span>'}
                                </td>
                                
                                <td class="px-[1.25vw] py-[0.83vw]">
                                    <span class="inline-flex items-center rounded-[0.83vw] py-[0.31vw] px-[0.73vw] text-[0.63vw] font-medium ring-[0.052vw] ring-inset ${badgeStyle.bg} ${badgeStyle.text} ${badgeStyle.border}">
                                        <span class="mr-[0.21vw] h-[0.21vw] w-[0.21vw] rounded-full ${badgeStyle.dot}"></span>
                                        ${item.status.charAt(0).toUpperCase() + item.status.slice(1)}
                                    </span>
                                </td>
                                
                                <td class="px-[1.25vw] py-[0.83vw] text-right">
                                    <div class="flex items-center justify-start gap-[0.42vw]">
                                        
                                        <button type="button" onclick='setupAndEditModal(${JSON.stringify(item)})' 
                                            class="${btnBase} ${btnBlue}" title="Editar">
                                            <svg class="w-[0.83vw] h-[0.83vw] stroke-[0.1vw]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </button>

                                        <button type="button" onclick="setupAndDeleteModal(${item.id}, '${item.nomeEsporte}')" 
                                            class="${btnBase} ${btnRed}" title="Deletar">
                                            <svg class="w-[0.83vw] h-[0.83vw] stroke-[0.1vw]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>

                                    </div>
                                </td>
                            </tr>
                        `;
                    }
                });

            });
        </script>
    </div>

    {{-- ======================================================= --}}
    {{-- MODAIS GENÉRICOS (HTML) --}}
    {{-- ======================================================= --}}
    <div id="modals-container">
        
        {{-- 1. MODAL DE EDIÇÃO GENÉRICO --}}
        <div
            id="edit-modal-generic"
            class="fixed inset-0 z-50 hidden overflow-y-auto overflow-x-hidden"
            aria-labelledby="modal-title"
            role="dialog"
            aria-modal="true"
        >
            <div class="flex min-h-screen items-center justify-center px-[0.83vw] pt-[0.83vw] pb-[4.17vw] text-center block p-0">

                <div
                    class="fixed inset-0 bg-gray-900/75 backdrop-blur-[0.21vw] transition-opacity"
                    aria-hidden="true"
                    onclick="closeModal('edit-modal-generic')"
                ></div>

                <span class="inline-block h-screen align-middle" aria-hidden="true">&#8203;</span>

                <div class="relative inline-block transform overflow-hidden rounded-[0.63vw] bg-white text-left align-bottom shadow-xl transition-all my-[1.67vw] w-full align-middle max-w-[30vw] p-[0.83vw]">
                    <div class="flex items-center justify-between pb-[0.42vw] border-b-[0.052vw] border-gray-300">
                        <h3 class="text-[1.25vw] font-semibold text-sky-600 tracking-tight" id="modal-title">
                            Editar Esporte
                        </h3>

                        <button type="button" onclick="closeModal('edit-modal-generic')" class="cursor-pointer text-gray-400 hover:text-gray-500 focus:outline-none">
                            <svg class="h-[1.25vw] w-[1.25vw] stroke-[0.1vw]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <div class="pt-[0.52vw] pb-[0.52vw]">
                        <form id="edit-form-esporte" class="flex flex-col gap-[0.42vw]"> {{-- ID DO FORMULÁRIO ALTERADO --}}
                            
                            {{-- CAMPO ID OCULTO --}}
                            <input type="hidden" id="edit-id-input" name="id" value=""> 

                            <div class="w-full flex flex-col gap-[0.42vw]">
                                <label for="edit-esporte-nome" class="block text-[1.04vw] font-medium text-sky-600">
                                    Nome do Esporte
                                </label>
                                <div class="relative w-full">
                                    <div class="absolute inset-y-0 start-0 flex items-center ps-[0.73vw] pointer-events-none text-gray-500 z-10">
                                        <div class="w-[1.04vw] h-[1.04vw] flex items-center justify-center">
                                            <svg class="h-[0.83vw] w-[0.83vw]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-type-icon lucide-type"><path d="M12 4v16"/><path d="M4 7V5a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v2"/><path d="M9 20h6"/></svg>
                                        </div>
                                    </div>
                                    <input
                                        type="text"
                                        id="edit-esporte-nome" {{-- ID DO CAMPO NOME ALTERADO --}}
                                        name="esporte-nome" {{-- NAME DO CAMPO NOME ALTERADO --}}
                                        class="block w-full p-[0.52vw] text-[0.73vw] text-gray-900 bg-gray-50 border-[0.052vw] border-gray-300 rounded-[0.42vw] focus:border-[0.052vw] focus:ring-sky-500 focus:border-sky-500 ps-[2.08vw]"
                                    >
                                </div>
                                <p id="esporte-nome-error" class="text-[0.73vw] text-red-600 hidden"></p>
                            </div>
                            <div class="w-full flex flex-col gap-[0.42vw]">
                                <label for="edit-esporte-descricao" class="block text-[1.04vw] font-medium text-sky-600">
                                    Descrição
                                </label>
                                <div class="relative w-full">
                                    <div class="absolute inset-y-0 start-0 flex items-center ps-[0.73vw] pointer-events-none text-gray-500 z-10">
                                        <div class="w-[1.04vw] h-[1.04vw] flex items-center justify-center">
                                            <svg class="h-[0.83vw] w-[0.83vw]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-text-align-center-icon lucide-text-align-center"><path d="M21 5H3"/><path d="M17 12H7"/><path d="M19 19H5"/></svg>
                                        </div>
                                    </div>
                                    <input
                                        type="text"
                                        id="edit-esporte-descricao" {{-- ID DO CAMPO DESCRIÇÃO ALTERADO --}}
                                        name="esporte-descricao" {{-- NAME DO CAMPO DESCRIÇÃO ALTERADO --}}
                                        class="block w-full p-[0.52vw] text-[0.73vw] text-gray-900 bg-gray-50 border-[0.052vw] border-gray-300 rounded-[0.42vw] focus:border-[0.052vw] focus:ring-sky-500 focus:border-sky-500 ps-[2.08vw]"
                                    >
                                </div>
                                <p id="esporte-descricao-error" class="text-[0.73vw] text-red-600 hidden"></p>
                            </div>

                    </div>

                    <div class="flex pt-[0.63vw] justify-end border-t-[0.052vw] border-gray-300">
                        <div class="w-full flex gap-x-[0.42vw] justify-end">
                            <button type="button" onclick="closeModal('edit-modal-generic')" class="cursor-pointer inline-flex items-center justify-center font-medium rounded-[0.42vw] shadow-xs focus:outline-none transition-transform hover:-translate-y-[0.1vw] transition-colors disabled:opacity-50 disabled:cursor-not-allowed bg-gray-50 border-[0.052vw] border-gray-300 text-gray-700 hover:bg-gray-200 focus:border-gray-400 focus:ring-0 focus:ring-offset-0 px-[0.83vw] py-[0.52vw] text-[0.73vw]">
                                Cancelar
                            </button>

                            <button type="submit" id="edit-submit-button" class="cursor-pointer inline-flex items-center justify-center font-medium rounded-[0.42vw] focus:outline-none transition-transform hover:-translate-y-[0.1vw] transition-colors disabled:opacity-50 disabled:cursor-not-allowed px-[0.83vw] py-[0.52vw] text-[0.73vw] bg-sky-300 text-white hover:bg-sky-600">
                                Salvar
                            </button>
                        </div>
                    </div>
                    </form> {{-- FIM DO FORMULÁRIO --}}
                </div>
            </div>
        </div>

        {{-- 2. MODAL DE DELEÇÃO GENÉRICO --}}
        <div
            id="delete-modal-generic"
            class="fixed inset-0 z-50 hidden overflow-y-auto overflow-x-hidden"
            aria-labelledby="modal-title"
            role="dialog"
            aria-modal="true"
        >
            <div class="flex min-h-screen items-center justify-center px-[0.83vw] pt-[0.83vw] pb-[4.17vw] text-center block p-0">

                <div
                    class="fixed inset-0 bg-gray-900/75 backdrop-blur-[0.21vw] transition-opacity"
                    aria-hidden="true"
                    onclick="closeModal('delete-modal-generic')"
                ></div>

                <span class="inline-block h-screen align-middle" aria-hidden="true">&#8203;</span>

                <div class="relative inline-block transform overflow-hidden rounded-[0.63vw] bg-white text-left align-bottom shadow-xl transition-all my-[1.67vw] w-full align-middle max-w-[26.67vw] p-[0.83vw]">
                    <div class="flex items-center justify-between pb-[0.42vw] border-b-[0.052vw] border-gray-300">
                        <h3 class="text-[1.04vw] font-semibold text-red-600 tracking-tight" id="modal-title">
                            Excluir Esporte
                        </h3>

                        <button type="button" onclick="closeModal('delete-modal-generic')" class="cursor-pointer text-gray-400 hover:text-gray-500 focus:outline-none">
                            <svg class="h-[1.25vw] w-[1.25vw] stroke-[0.1vw]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <div class="pt-[0.52vw] pb-[0.52vw]">
                        <div class="p-[0.83vw] text-center">
                            <div class="mx-auto flex items-center justify-center h-[2.5vw] w-[2.5vw] rounded-full bg-red-100 mb-[0.83vw]">
                                <svg class="h-[1.25vw] w-[1.25vw] text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                </svg>
                            </div>
                            <h3 class="text-[0.94vw] leading-6 font-medium text-gray-900">Tem certeza absoluta?</h3>
                            <p class="text-[0.73vw] text-gray-500 mt-[0.42vw]">
                                Você está prestes a excluir <strong>"<span id="delete-nome-display"></span>"</strong>.
                                Essa ação é irreversível.
                            </p>
                        </div>
                    </div>

                    <div class="flex pt-[0.63vw] justify-end border-t-[0.052vw] border-gray-300">
                        <div class="w-full flex gap-x-[0.42vw] justify-end">
                            <button type="button" onclick="closeModal('delete-modal-generic')" class="cursor-pointer inline-flex items-center justify-center font-medium rounded-[0.42vw] shadow-xs focus:outline-none transition-transform hover:-translate-y-[0.1vw] transition-colors disabled:opacity-50 disabled:cursor-not-allowed bg-gray-50 border-[0.052vw] border-gray-300 text-gray-700 hover:bg-gray-200 focus:border-gray-400 focus:ring-0 focus:ring-offset-0 px-[0.83vw] py-[0.52vw] text-[0.73vw]">
                                Cancelar
                            </button>

                            <button type="button" id="delete-confirm-button" class="cursor-pointer inline-flex items-center justify-center font-medium rounded-[0.42vw] shadow-xs focus:outline-none transition-transform hover:-translate-y-[0.1vw] transition-colors disabled:opacity-50 disabled:cursor-not-allowed bg-red-300 text-white hover:bg-red-500 focus:ring-red-500 px-[0.83vw] py-[0.52vw] text-[0.73vw]">
                                Sim, excluir
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</x-layouts.admin>