<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Pesquisar perfis</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
<main id="search-root"
      data-endpoint="{{ url('/api/usuario/search') }}"
      data-profile-url-base="{{ url('/clube/usuario') }}"
>
    <header>
        <h1>Pesquisar perfis</h1>
    </header>

    {{-- BARRA SUPERIOR: busca simples + botões --}}
    <section>
        <form id="simple-search-form">
            <label>
                <span>Pesquisar clubes, atletas...</span>
                <input type="text" id="pesquisa" name="pesquisa" autocomplete="off">
            </label>

            <button type="button" id="btn-advanced-search">
                Pesquisa avançada
            </button>
        </form>

        <div>
            <!-- "+" que abre o modal de filtros -->
            <button type="button" id="btn-open-filters-modal">+</button>

            <!-- limpar filtros (limpa tudo e refaz busca) -->
            <button type="button" id="btn-clear-filters">Limpar filtros</button>
        </div>
    </section>

    {{-- MODAL DE FILTROS AVANÇADOS --}}
    <div id="filters-modal" hidden>
        <div id="filters-modal-backdrop"></div>

        <div id="filters-modal-panel">
            <header>
                <h2>Filtros avançados</h2>
                <button type="button" id="filters-close">X</button>
            </header>

            {{-- “Abas” de filtros: Tipo, Localização, Idade, Altura, Peso, Gênero --}}
            <div id="filter-options">
                <button type="button" data-filter-option="tipo">Tipo</button>
                <button type="button" data-filter-option="localizacao">Localização</button>
                <button type="button" data-filter-option="idade">Idade</button>
                <button type="button" data-filter-option="altura">Altura</button>
                <button type="button" data-filter-option="peso">Peso</button>
                <button type="button" data-filter-option="genero">Gênero</button>
            </div>

            <form id="advanced-search-form">
                {{-- PAINEL: TIPO (ex.: tipo de perfil, posição, etc.) --}}
                <section data-filter-panel="tipo" hidden>
                    <h3>Tipo</h3>

                    <div>
                        <label for="tipoPerfil">Tipo de perfil</label>
                        <select id="tipoPerfil" name="tipoPerfil">
                            <option value="">Todos</option>
                            <option value="atleta">Atleta</option>
                            <option value="clube">Clube</option>
                        </select>
                    </div>

                    <div>
                        <label for="posicao_id">Posição</label>
                        <select id="posicao_id" name="posicao_id">
                            <option value="">Todas</option>
                            {{-- options podem ser preenchidas via JS depois --}}
                        </select>
                    </div>
                </section>

                {{-- PAINEL: LOCALIZAÇÃO --}}
                <section data-filter-panel="localizacao" hidden>
                    <h3>Localização</h3>

                    <div>
                        <label for="estadoUsuario">Estado</label>
                        <input type="text" id="estadoUsuario" name="estadoUsuario">
                    </div>

                    <div>
                        <label for="cidadeUsuario">Cidade</label>
                        <input type="text" id="cidadeUsuario" name="cidadeUsuario">
                    </div>
                </section>

                {{-- PAINEL: IDADE --}}
                <section data-filter-panel="idade" hidden>
                    <h3>Idade (anos)</h3>

                    <div>
                        <label for="idade_min">Idade mínima</label>
                        <input type="number" id="idade_min" name="idade_min" min="0" max="120" step="1">
                    </div>

                    <div>
                        <label for="idade_max">Idade máxima</label>
                        <input type="number" id="idade_max" name="idade_max" min="0" max="120" step="1">
                    </div>
                </section>

                {{-- PAINEL: ALTURA --}}
                <section data-filter-panel="altura" hidden>
                    <h3>Altura (cm)</h3>

                    <div>
                        <label for="altura_min">Altura mínima</label>
                        <input type="number" id="altura_min" name="altura_min" min="50" max="300" step="1">
                    </div>

                    <div>
                        <label for="altura_max">Altura máxima</label>
                        <input type="number" id="altura_max" name="altura_max" min="50" max="300" step="1">
                    </div>
                </section>

                {{-- PAINEL: PESO --}}
                <section data-filter-panel="peso" hidden>
                    <h3>Peso (kg)</h3>

                    <div>
                        <label for="peso_min">Peso mínimo</label>
                        <input type="number" id="peso_min" name="peso_min" min="20" max="500" step="0.1">
                    </div>

                    <div>
                        <label for="peso_max">Peso máximo</label>
                        <input type="number" id="peso_max" name="peso_max" min="20" max="500" step="0.1">
                    </div>
                </section>

                {{-- PAINEL: GÊNERO --}}
                <section data-filter-panel="genero" hidden>
                    <h3>Gênero</h3>

                    <div>
                        <label for="generoUsuario">Gênero</label>
                        <select id="generoUsuario" name="generoUsuario">
                            <option value="">Todos</option>
                            <option value="masculino">Masculino</option>
                            <option value="feminino">Feminino</option>
                            <option value="outro">Outro</option>
                        </select>
                    </div>
                </section>

                <div>
                    <button type="submit" id="btn-apply-filters">Aplicar filtros</button>
                </div>
            </form>
        </div>
    </div>

    {{-- RESULTADOS --}}
    <section id="results-section">
        <header>
            <h2>Resultados</h2>

            <div id="order-wrapper">
                <label for="ordenarpor">Ordenar por</label>
                <select id="ordenarpor" name="ordenarpor">
                    <option value="recentes">Mais recentes</option>
                    <option value="nome">Nome</option>
                    <option value="idade">Idade</option>
                    <option value="altura">Altura</option>
                    <option value="peso">Peso</option>
                    <option value="todos">Sem ordenação específica</option>
                </select>

                <select id="direction" name="direction">
                    <option value="asc">Crescente</option>
                    <option value="desc" selected>Decrescente</option>
                </select>
            </div>
        </header>

        <div id="results-container"></div>

        <footer id="pagination-controls">
            <button type="button" id="btn-prev-page" disabled>Anterior</button>
            <span id="pagination-info"></span>
            <button type="button" id="btn-next-page" disabled>Próxima</button>
        </footer>
    </section>
</main>

<script>
(function () {
    const root = document.getElementById('search-root');
    if (!root) return;

    const endpoint    = root.dataset.endpoint;
    const profileBase = root.dataset.profileUrlBase;
    const token = localStorage.getItem('clube_token');
    const csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const headers = {
        'Accept': 'application/json',
        'X-Requested-With': 'XMLHttpRequest',
        'Authorization': token,
        'X-CSRF-TOKEN': csrf,
    };

    const state = {
        page: 1,
        per_page: 15,
        lastResponse: null,
    };

    function calcAge(isoDate) {
        if (!isoDate) return null;
        const d = new Date(isoDate);
        if (isNaN(d.getTime())) return null;
        const today = new Date();
        let age = today.getFullYear() - d.getFullYear();
        const m = today.getMonth() - d.getMonth();
        if (m < 0 || (m === 0 && today.getDate() < d.getDate())) age--;
        return age;
    }

    // ---------- COLETA DOS CAMPOS PARA QUERY ----------
    function buildQueryParams() {
        const p = new URLSearchParams();

        const pesquisa       = document.getElementById('pesquisa')?.value ?? '';

        const tipoPerfil     = document.getElementById('tipoPerfil')?.value ?? '';
        const posicao_id     = document.getElementById('posicao_id')?.value ?? '';

        const altura_min     = document.getElementById('altura_min')?.value ?? '';
        const altura_max     = document.getElementById('altura_max')?.value ?? '';

        const peso_min       = document.getElementById('peso_min')?.value ?? '';
        const peso_max       = document.getElementById('peso_max')?.value ?? '';

        const idade_min      = document.getElementById('idade_min')?.value ?? '';
        const idade_max      = document.getElementById('idade_max')?.value ?? '';

        const estadoUsuario  = document.getElementById('estadoUsuario')?.value ?? '';
        const cidadeUsuario  = document.getElementById('cidadeUsuario')?.value ?? '';

        const generoUsuario  = document.getElementById('generoUsuario')?.value ?? '';

        const ordenarpor     = document.getElementById('ordenarpor')?.value ?? '';
        const direction      = document.getElementById('direction')?.value ?? '';

        if (pesquisa)      p.set('pesquisa', pesquisa);

        if (tipoPerfil)    p.set('tipoPerfil', tipoPerfil);          // backend pode usar depois se quiser
        if (posicao_id)    p.set('posicao_id', posicao_id);

        if (altura_min)    p.set('altura_min', altura_min);
        if (altura_max)    p.set('altura_max', altura_max);

        if (peso_min)      p.set('peso_min', peso_min);
        if (peso_max)      p.set('peso_max', peso_max);

        if (idade_min)     p.set('idade_min', idade_min);
        if (idade_max)     p.set('idade_max', idade_max);

        if (estadoUsuario) p.set('estadoUsuario', estadoUsuario);
        if (cidadeUsuario) p.set('cidadeUsuario', cidadeUsuario);

        if (generoUsuario) p.set('generoUsuario', generoUsuario);    // idem, pronto pra usar no controller

        if (ordenarpor)    p.set('ordenarpor', ordenarpor);
        if (direction)     p.set('direction', direction);

        p.set('per_page', state.per_page);
        p.set('page', state.page);

        return p;
    }

    // ---------- CHAMADA À API ----------
    async function fetchResults() {
        const resultsContainer = document.getElementById('results-container');
        const info             = document.getElementById('pagination-info');

        if (resultsContainer) resultsContainer.textContent = 'Carregando...';
        if (info) info.textContent = '';

        const params = buildQueryParams();
        const url = endpoint + '?' + params.toString();

        try {
            const res  = await fetch(url, { headers });
            const text = await res.text();
            let data;
            try { data = text ? JSON.parse(text) : null; } catch { data = null; }

            if (!res.ok) {
                console.error('Erro ao buscar usuários:', data || text);
                if (resultsContainer) resultsContainer.textContent = 'Não foi possível carregar os resultados.';
                return;
            }

            state.lastResponse = data;
            renderResults();
        } catch (err) {
            console.error('Erro de rede na busca:', err);
            if (resultsContainer) resultsContainer.textContent = 'Erro de rede ao carregar os resultados.';
        }
    }

    // ---------- RENDER DOS CARDS ----------
    function userToRowHTML(u) {
        const id        = u.id;
        const nome      = u.nomeCompletoUsuario || 'Usuário';
        const cidade    = u.cidadeUsuario || '';
        const estado    = u.estadoUsuario || '';
        const alturaCm  = u.alturaCm != null ? u.alturaCm : null;
        const pesoKg    = u.pesoKg   != null ? u.pesoKg   : null;
        const idade     = calcAge(u.dataNascimentoUsuario);
        const posicoes  = Array.isArray(u.posicoes) ? u.posicoes : [];
        const primeiraPosicao = posicoes[0]?.nomePosicao || '';

        const localStr  = (cidade || estado) ? `${cidade}${cidade && estado ? ' - ' : ''}${estado}` : '';
        const idadeStr  = idade != null ? `${idade} anos` : '';
        const alturaStr = alturaCm != null ? `${alturaCm} cm` : '';
        const pesoStr   = pesoKg   != null ? `${pesoKg} kg` : '';

        const perfilUrl = profileBase ? `${profileBase}/${id}` : '#';

        return `
            <article class="result-row" data-user-id="${id}">
                <div class="result-main">
                    <div class="result-avatar"><span>👤</span></div>

                    <div class="result-info">
                        <div class="result-name">${nome}</div>
                        <div class="result-meta">
                            <span class="result-role">Atleta</span>
                            ${primeiraPosicao ? `<span class="result-position">${primeiraPosicao}</span>` : ''}
                            ${localStr ? `<span class="result-location">${localStr}</span>` : ''}
                            ${idadeStr ? `<span class="result-age">${idadeStr}</span>` : ''}
                            ${alturaStr ? `<span class="result-height">${alturaStr}</span>` : ''}
                            ${pesoStr ? `<span class="result-weight">${pesoStr}</span>` : ''}
                        </div>
                    </div>
                </div>

                <div class="result-actions">
                    <a href="${perfilUrl}" class="btn-view-profile">Ver perfil</a>
                    <button type="button" class="btn-follow">Seguir</button>
                </div>
            </article>
        `;
    }

    function renderResults() {
        const resultsContainer = document.getElementById('results-container');
        const info             = document.getElementById('pagination-info');
        const btnPrev          = document.getElementById('btn-prev-page');
        const btnNext          = document.getElementById('btn-next-page');

        if (!resultsContainer) return;

        const resp  = state.lastResponse;
        const lista = Array.isArray(resp?.data) ? resp.data : [];

        if (!lista.length) {
            resultsContainer.textContent = 'Nenhum resultado encontrado.';
        } else {
            resultsContainer.innerHTML = lista.map(userToRowHTML).join('');
        }

        const current = resp?.current_page ?? state.page;
        const last    = resp?.last_page ?? current;
        const total   = resp?.total ?? lista.length;

        if (info) info.textContent = `Página ${current} de ${last} — ${total} resultados`;
        if (btnPrev) btnPrev.disabled = current <= 1;
        if (btnNext) btnNext.disabled = current >= last;
    }

    // ---------- MODAL / ABAS DE FILTRO ----------
    const filtersModal   = document.getElementById('filters-modal');
    const modalCloseBtn  = document.getElementById('filters-close');
    const modalBackdrop  = document.getElementById('filters-modal-backdrop');
    const btnOpenModal   = document.getElementById('btn-open-filters-modal');
    const filterButtons  = document.querySelectorAll('[data-filter-option]');
    const filterPanels   = document.querySelectorAll('[data-filter-panel]');

    function showFilterPanel(key) {
        filterPanels.forEach(sec => {
            if (sec.dataset.filterPanel === key) {
                sec.removeAttribute('hidden');
            } else {
                sec.setAttribute('hidden', 'hidden');
            }
        });

        filterButtons.forEach(btn => {
            if (btn.dataset.filterOption === key) {
                btn.setAttribute('data-active', 'true');
            } else {
                btn.removeAttribute('data-active');
            }
        });
    }

    function openFiltersModal() {
        if (!filtersModal) return;
        filtersModal.removeAttribute('hidden');
        // ao abrir, mostra a primeira aba (tipo) por padrão
        showFilterPanel('tipo');
    }

    function closeFiltersModal() {
        if (!filtersModal) return;
        filtersModal.setAttribute('hidden', 'hidden');
    }

    if (btnOpenModal) {
        btnOpenModal.addEventListener('click', () => {
            openFiltersModal();
        });
    }
    if (modalCloseBtn) {
        modalCloseBtn.addEventListener('click', () => {
            closeFiltersModal();
        });
    }
    if (modalBackdrop) {
        modalBackdrop.addEventListener('click', () => {
            closeFiltersModal();
        });
    }

    filterButtons.forEach(btn => {
        btn.addEventListener('click', () => {
            const key = btn.dataset.filterOption;
            if (key) showFilterPanel(key);
        });
    });

    // ---------- EVENTOS GERAIS ----------

    const simpleForm        = document.getElementById('simple-search-form');
    const advancedForm      = document.getElementById('advanced-search-form');
    const btnAdvancedSearch = document.getElementById('btn-advanced-search');
    const btnClear          = document.getElementById('btn-clear-filters');

    // Botão "Pesquisa avançada" -> apenas busca
    if (btnAdvancedSearch) {
        btnAdvancedSearch.addEventListener('click', (e) => {
            e.preventDefault();
            state.page = 1;
            fetchResults();
        });
    }

    // Enter na busca simples
    if (simpleForm) {
        simpleForm.addEventListener('submit', (e) => {
            e.preventDefault();
            state.page = 1;
            fetchResults();
        });
    }

    // Aplicar filtros no modal
    if (advancedForm) {
        advancedForm.addEventListener('submit', (e) => {
            e.preventDefault();
            state.page = 1;
            fetchResults();
            closeFiltersModal();
        });
    }

    // Limpar filtros (busca + filtros do modal)
    if (btnClear) {
        btnClear.addEventListener('click', () => {
            if (simpleForm) simpleForm.reset();
            if (advancedForm) advancedForm.reset();
            state.page = 1;
            fetchResults();
        });
    }

    // Ordenação
    const ordenarSelect   = document.getElementById('ordenarpor');
    const directionSelect = document.getElementById('direction');

    if (ordenarSelect) {
        ordenarSelect.addEventListener('change', () => {
            state.page = 1;
            fetchResults();
        });
    }
    if (directionSelect) {
        directionSelect.addEventListener('change', () => {
            state.page = 1;
            fetchResults();
        });
    }

    // Paginação
    const btnPrev = document.getElementById('btn-prev-page');
    const btnNext = document.getElementById('btn-next-page');

    if (btnPrev) {
        btnPrev.addEventListener('click', () => {
            if (state.page > 1) {
                state.page--;
                fetchResults();
            }
        });
    }

    if (btnNext) {
        btnNext.addEventListener('click', () => {
            const last = state.lastResponse?.last_page ?? state.page;
            if (state.page < last) {
                state.page++;
                fetchResults();
            }
        });
    }

    // Primeira carga
    fetchResults();
})();
</script>
</body>
</html>