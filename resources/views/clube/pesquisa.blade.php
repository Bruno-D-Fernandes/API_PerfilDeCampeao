<x-layouts.clube title="Pesquisa" :breadcrumb="['Dashboard' => route('clube.dashboard'), 'Pesquisa' => null]">
    <div id="toast-container" class="fixed top-[0.83vw] left-[0.83vw] z-[9999] flex flex-col gap-[0.63vw] pointer-events-auto"></div>

    <div class="h-full flex justify-center gap-[1.25vw] w-full flex-1min-h-0">
    
        <x-form class="flex flex-col gap-[0.42vw] bg-emerald-500 h-full w-1/4 rounded-lg p-[1.25vw]" id="search-form" onsubmit="return false;">
                
            <x-search-input placeholder="Buscar por nome" name="pesquisa" value="{{ request('pesquisa') }}" />

            <div class="w-full border border-t border-white/20 mt-[0.105vw]"></div>

            <div class="flex flex-col gap-[0.42vw] pr-[0.83vw]">
                <x-form-group label="Esporte" name="esporte_id" type="select" id="modalidade_select" labelColor="white">
                    <option value="">Todos</option>
                    @foreach($esportes as $esporte)
                        <option value="{{ $esporte->id }}" @selected(request('esporte_id') == $esporte->id)>
                            {{ $esporte->nomeEsporte }}
                        </option>
                    @endforeach
                </x-form-group>

                <x-form-group label="Posição" name="posicao_id" type="select" id="posicao_select" labelColor="white">
                    <option value="">Todas</option>
                    
                </x-form-group>

                <div class="px-2.5">
                    <x-range-slider label="Idade" nameMin="idade_min" nameMax="idade_max" :min="14" :max="40" :step="1" unit="anos" id="idade_slider" color="white"></x-range-slider>
                    <x-range-slider label="Altura" nameMin="altura_min" nameMax="altura_max" :min="100" :max="240" :step="1" unit="cm" id="altura_slider" color="white"></x-range-slider>
                    <x-range-slider label="Peso" nameMin="peso_min" nameMax="peso_max" :min="40" :max="150" :step="1" unit="kg" id="peso_slider" color="white"></x-range-slider>
                </div>

                <div class="flex flex-col gap-[0.42vw]">
                    <h3 class="block text-md font-medium text-white">
                        Pé dominante
                    </h3>
                    <div class="flex items-center justify-center gap-x-[0.83vw]">
                        <x-radio name="peDominante" label="Destro" id="pe_destro" value="direito" color="white" />
                        <x-radio name="peDominante" label="Canhoto" id="pe_canhoto" value="esquerdo" color="white" />
                    </div>
                </div>

                <div class="flex flex-col gap-[0.42vw]">
                    <h3 class="block text-md font-medium text-white">
                        Mão dominante
                    </h3>
                    <div class="flex items-center justify-center gap-x-[0.83vw]">
                        <x-radio name="maoDominante" label="Destro" id="mao_destro" value="direita" color="white" />
                        <x-radio name="maoDominante" label="Canhoto" id="mao_canhoto" value="esquerda" color="white" />
                    </div>
                </div>

                <x-form-group label="Estado" name="estadoUsuario" type="select" id="estado_select" labelColor="white">
                    <option value="">Todos</option>
                    <option value="SP">São Paulo</option>
                </x-form-group>

                <x-form-group label="Cidade" name="cidadeUsuario" type="select" id="cidade_select" labelColor="white">
                    <option value="">Todas</option>
                    <option value="Campinas">Campinas</option>
                </x-form-group>
            </div>

            <div class="w-full border border-t border-white/20 mt-[0.105vw]"></div>

            <div class="flex gap-x-[0.83vw] mt-[0.21vw] flex-shrink-0">
                <x-button color="none" :full="true" class="border-none bg-transparent text-emerald-800" type="button" id="clear-filters-btn">
                    Limpar
                </x-button>

                <x-button color="none" :full="true" class="border-none bg-white text-emerald-500" type="submit">
                    Filtrar
                </x-button>
            </div>
        </x-form>

        <div class="flex-1 flex flex-col gap-[0.42vw] bg-white min-h-0 w-3/4 overflow-hidden">
            
            <div class="flex items-center justify-between">
                <h3 class="text-[0.93vw] font-medium text-gray-700" id="athletes-count">
                    {{ $atletas->total() }} atletas encontrados
                </h3>

                <div>
                    <x-select name="ordenarpor" id="ibiz" class="pr-8">
                        <option value="recentes" @selected(request('ordenarpor') == 'recentes' || !request('ordenarpor'))>Ordenar por</option>
                        <option value="nome" @selected(request('ordenarpor') == 'nome')>Nome</option>
                        <option value="idade" @selected(request('ordenarpor') == 'idade')>Idade</option>
                        <option value="altura" @selected(request('ordenarpor') == 'altura')>Altura</option>
                        <option value="peso" @selected(request('ordenarpor') == 'peso')>Peso</option>
                    </x-select>
                </div>
            </div>

            <div id="athletes-grid-section" class="flex-1 max-h-full min-h-0">
                @include('clube.partials.athletes-grid', ['atletas' => $atletas])
            </div>

            <div class="w-full h-[0.052vw] bg-gray-200"></div>

            <div id="athletes-pagination-section">
                @include('clube.partials.pagination', ['atletas' => $atletas])
            </div>
        </div>
    </div>

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
</x-layouts.clube>

<script>
    const searchUrl = "{{ route('clube.pesquisa.data') }}"; 
    
    const allPositions = @json($posicoes ?? []);
    console.log('Posições carregadas:', allPositions);

    function getSelectElement(id) {
        const el = document.getElementById(id);

        if (!el) return null;
        if (el.tagName === 'SELECT') return el;

        return el.querySelector('select');
    }

    const esporteSelect = getSelectElement('modalidade_select');
    const posicaoSelect = getSelectElement('posicao_select');
    
    function updatePosicoes() {
        if (!posicaoSelect || !esporteSelect) {
            console.warn('Elementos select de Esporte ou Posição não encontrados.');
            return;
        }

        const esporteId = esporteSelect.value;
        const currentPosicao = "{{ request('posicao_id') }}"; 

        posicaoSelect.innerHTML = '<option value="">Todas</option>';

        if (!allPositions || allPositions.length === 0) return;

        let filtered = [];

        if (!esporteId) {
            filtered = allPositions;
        } else {
            filtered = allPositions.filter(pos => pos.idEsporte == esporteId);
        }

        filtered.forEach(pos => {
            const option = document.createElement('option');
            option.value = pos.id;
            
            option.textContent = pos.nomePosicao || pos.nome_posicao || pos.nome || 'Sem Nome'; 
            if (pos.id == currentPosicao) option.selected = true;
            posicaoSelect.appendChild(option);
        });
    }

    if (esporteSelect) {
        esporteSelect.addEventListener('change', function() {
            updatePosicoes();
        });

        updatePosicoes();
    }
    
    const searchForm = document.getElementById('search-form'); 
    const gridSection = document.getElementById('athletes-grid-section');
    const paginationSection = document.getElementById('athletes-pagination-section');
    const athletesCountElement = document.getElementById('athletes-count');
    const orderSelect = document.getElementById('ibiz');
    const clearBtn = document.getElementById('clear-filters-btn');
    
    let currentParams = {
        page: {{ $atletas->currentPage() }},
        per_page: 9, 
        ordenarpor: '{{ request('ordenarpor', 'recentes') }}'
    };

    function getFormData() {
        const formData = new FormData(searchForm);
        const data = {};
        
        for (const [key, value] of formData.entries()) {
             if (value !== '' && value !== 'on') { 
                data[key] = value;
            }
        }
        
        if (orderSelect && orderSelect.value !== 'recentes') {
            data['ordenarpor'] = orderSelect.value;
        } else {
            data['ordenarpor'] = 'recentes';
        }
        
        data['page'] = currentParams.page;
        data['per_page'] = 9; 

        return data;
    }

    function fetchAthletes(newParams) {
        currentParams = { ...currentParams, ...newParams };
        const data = getFormData();
        
        gridSection.style.opacity = '0.5';
        
        const params = new URLSearchParams(data).toString();
        
        fetch(`${searchUrl}?${params}`, {
            method: 'GET',
            headers: { 'X-Requested-With': 'XMLHttpRequest' },
        })
        .then(response => {
            if (!response.ok) throw new Error('Erro na requisição');
            return response.json();
        })
        .then(result => {
            gridSection.innerHTML = result.grid;
            paginationSection.innerHTML = result.pagination;
            
            if (result.total !== undefined) {
                athletesCountElement.textContent = `${result.total} atletas encontrados`;
            }
            gridSection.style.opacity = '1';
        })
        .catch(error => {
            console.error('Erro:', error);
            gridSection.style.opacity = '1';
        });
    }

    if (searchForm) {
        searchForm.addEventListener('submit', function(e) {
            e.preventDefault();
            fetchAthletes({ page: 1 }); 
        });
    }
    
    if (orderSelect) {
        orderSelect.addEventListener('change', function() {
            fetchAthletes({ page: 1, ordenarpor: this.value });
        });
    }
    
    if (clearBtn) {
        clearBtn.addEventListener('click', function(e) {
            e.preventDefault();
            searchForm.reset();
            
            currentParams = { page: 1, per_page: 9, ordenarpor: 'recentes' };
            if (orderSelect) orderSelect.value = 'recentes';
            
            if (esporteSelect) {
                esporteSelect.value = "";
                updatePosicoes();
            }

            fetchAthletes({}); 
        });
    }

    window.handlePageChange = function(newPage) {
        fetchAthletes({ page: newPage });
    }
    
    window.handlePerPageChange = function(newPerPage) {}

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
            
            showToast('success', successTitle, successText);

            if (result.list || result.data) {
                const newList = result.list || result.data;
                if (typeof window.addListToAllModals === 'function') {
                    window.addListToAllModals(newList);
                }
            }

            if (result.html_modal && typeof window.addListToAllModals === 'function') {
                window.addListToAllModals(result.html_modal);
            }
        } catch (error) {
            console.error('Erro na requisição:', error);
            showToast('error', errorTitle, 'Erro de conexão ou falha no processamento de dados.');
        }
    }

    document.addEventListener('change', function(e) {
        if (e.target && e.target.matches('.save-list-form-container input[type="checkbox"]')) {
            const checkbox = e.target;
            const listId = checkbox.value;
            const atletaId = checkbox.dataset.atletaId;
            const isAdding = checkbox.checked;

            if (!listId || !atletaId) return;

            const method = isAdding ? 'POST' : 'DELETE';
            const url = `/api/clube/listas/${listId}/usuarios/${atletaId}`;

            fetch(url, {
                method,
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(async response => {
                if (!response.ok) throw new Error('Falha na requisição');
                if (typeof window.showToast === 'function') {
                    window.showToast('success', isAdding ? 'Adicionado!' : 'Removido!', `Atleta ${isAdding ? 'adicionado à' : 'removido da'} lista "${checkbox.closest('label').querySelector('span').innerText.trim()}"`);
                }
            })
            .catch(error => {
                console.error('Erro:', error);
                checkbox.checked = !isAdding;
                if (typeof window.showToast === 'function') {
                    window.showToast('error', 'Erro', 'Não foi possível atualizar a lista.');
                }
            });
        }
    });
</script>