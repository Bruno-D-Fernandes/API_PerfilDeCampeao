<x-layouts.clube title="Pesquisa" :breadcrumb="['Dashboard' => route('clube.dashboard'), 'Pesquisa' => null]">
    <div class="flex justify-center gap-[1.25vw] w-full h-full">
    
        <x-form class="flex flex-col justify-between gap-2 bg-emerald-500 h-full w-1/4 rounded-lg p-[1.25vw]" id="search-form" onsubmit="return false;">
                
            <x-search-input placeholder="Buscar por nome" name="pesquisa" value="{{ request('pesquisa') }}" />

            <div class="w-full border border-t border-white/20 mt-[0.105vw]"></div>

            <div class="flex flex-col gap-[0.42vw] max-h-full overflow-y-auto scrollbar-custom pr-[0.83vw]">
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
                    {{-- As opções serão preenchidas pelo JavaScript --}}
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

            <div class="flex gap-x-[0.83vw] mt-[0.21vw]">
                <x-button color="none" :full="true" class="border-none bg-transparent text-emerald-800" type="button" id="clear-filters-btn">
                    Limpar
                </x-button>

                <x-button color="none" :full="true" class="border-none bg-white text-emerald-500" type="submit">
                    Filtrar
                </x-button>
            </div>
        </x-form>

        <div class="flex flex-col gap-[0.42vw] bg-white h-full w-3/4">
            
            <div class="flex items-center justify-between">
                <h3 class="text-xl font-medium text-gray-700" id="athletes-count">
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

            <div id="athletes-grid-section" class="flex-grow">
                @include('clube.partials.athletes-grid', ['atletas' => $atletas])
            </div>

            <div class="w-full h-[0.052vw] bg-gray-200"></div>

            <div id="athletes-pagination-section">
                @include('clube.partials.pagination', ['atletas' => $atletas])
            </div>
        </div>
    </div>
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
</script>