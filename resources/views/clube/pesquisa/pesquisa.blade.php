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

        {{-- BARRA DE BUSCA PRINCIPAL --}}
        <section>
            <form id="simple-search-form">
                <label>
                    <span>Pesquisar clubes, atletas...</span>
                    <input type="text" id="pesquisa" name="pesquisa" autocomplete="off">
                </label>

                <button type="button" id="btn-open-advanced">
                    Pesquisa avançada
                </button>
            </form>
        </section>
        
        <section id="advanced-filters" hidden>
            <h2>Filtros avançados</h2>

            <form id="advanced-search-form">
                {{-- Linha 1: posição --}}
                <div>
                    <label for="posicao_id">Posição</label>
                    <select id="posicao_id" name="posicao_id">
                        <option value="">Todas</option>
                        {{-- opções podem ser preenchidas via JS depois, se quiser --}}
                    </select>
                </div>

                {{-- Linha 2: Altura --}}
                <div>
                    <h3>Altura (cm)</h3>
                    <label>
                        Mínima
                        <input type="number" id="altura_min" name="altura_min" min="50" max="300" step="1">
                    </label>
                    <label>
                        Máxima
                        <input type="number" id="altura_max" name="altura_max" min="50" max="300" step="1">
                    </label>
                </div>

                {{-- Linha 3: Peso --}}
                <div>
                    <h3>Peso (kg)</h3>
                    <label>
                        Mínimo
                        <input type="number" id="peso_min" name="peso_min" min="20" max="500" step="0.1">
                    </label>
                    <label>
                        Máximo
                        <input type="number" id="peso_max" name="peso_max" min="20" max="500" step="0.1">
                    </label>
                </div>

                {{-- Linha 4: Idade --}}
                <div>
                    <h3>Idade (anos)</h3>
                    <label>
                        Mínima
                        <input type="number" id="idade_min" name="idade_min" min="0" max="120" step="1">
                    </label>
                    <label>
                        Máxima
                        <input type="number" id="idade_max" name="idade_max" min="0" max="120" step="1">
                    </label>
                </div>

                {{-- Linha 5: Localização --}}
                <div>
                    <h3>Localização</h3>
                    <label>
                        Estado
                        <input type="text" id="estadoUsuario" name="estadoUsuario">
                    </label>
                    <label>
                        Cidade
                        <input type="text" id="cidadeUsuario" name="cidadeUsuario">
                    </label>
                </div>

                {{-- Linha 6: Dominância --}}
                <div>
                    <h3>Dominância</h3>
                    <label>
                        Pé dominante
                        <select id="peDominante" name="peDominante">
                            <option value="">Todos</option>
                            <option value="direito">Direito</option>
                            <option value="esquerdo">Esquerdo</option>
                        </select>
                    </label>

                    <label>
                        Mão dominante
                        <select id="maoDominante" name="maoDominante">
                            <option value="">Todos</option>
                            <option value="destro">Destro</option>
                            <option value="canhoto">Canhoto</option>
                        </select>
                    </label>
                </div>

                <div>
                    <button type="button" id="btn-clear-filters">Limpar filtros</button>
                    <button type="submit" id="btn-apply-filters">Mostrar resultados</button>
                </div>
            </form>
        </section>

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

            <div id="results-container">
                {{-- cards inseridos via JS --}}
            </div>

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

        const endpoint = root.dataset.endpoint;
        const profileBase = root.dataset.profileUrlBase;
        const csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const token = localStorage.getItem('clube_token');

        const headers = {
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': csrf,
        };

        const state = {
            page: 1,
            per_page: 15,
            lastResponse: null,
        };

        // Util: calcula idade a partir de AAAA-MM-DD
        function calcAge(isoDate) {
            if (!isoDate) return null;
            const d = new Date(isoDate);
            if (isNaN(d.getTime())) return null;
            const today = new Date();
            let age = today.getFullYear() - d.getFullYear();
            const m = today.getMonth() - d.getMonth();
            if (m < 0 || (m === 0 && today.getDate() < d.getDate())) {
                age--;
            }
            return age;
        }

        function buildQueryParams() {
            const params = new URLSearchParams();

            const pesquisa       = document.getElementById('pesquisa')?.value ?? '';
            const posicao_id     = document.getElementById('posicao_id')?.value ?? '';
            const altura_min     = document.getElementById('altura_min')?.value ?? '';
            const altura_max     = document.getElementById('altura_max')?.value ?? '';
            const peso_min       = document.getElementById('peso_min')?.value ?? '';
            const peso_max       = document.getElementById('peso_max')?.value ?? '';
            const idade_min      = document.getElementById('idade_min')?.value ?? '';
            const idade_max      = document.getElementById('idade_max')?.value ?? '';
            const estadoUsuario  = document.getElementById('estadoUsuario')?.value ?? '';
            const cidadeUsuario  = document.getElementById('cidadeUsuario')?.value ?? '';
            const peDominante    = document.getElementById('peDominante')?.value ?? '';
            const maoDominante   = document.getElementById('maoDominante')?.value ?? '';
            const ordenarpor     = document.getElementById('ordenarpor')?.value ?? '';
            const direction      = document.getElementById('direction')?.value ?? '';

            if (pesquisa)      params.set('pesquisa', pesquisa);
            if (posicao_id)    params.set('posicao_id', posicao_id);
            if (altura_min)    params.set('altura_min', altura_min);
            if (altura_max)    params.set('altura_max', altura_max);
            if (peso_min)      params.set('peso_min', peso_min);
            if (peso_max)      params.set('peso_max', peso_max);
            if (idade_min)     params.set('idade_min', idade_min);
            if (idade_max)     params.set('idade_max', idade_max);
            if (estadoUsuario) params.set('estadoUsuario', estadoUsuario);
            if (cidadeUsuario) params.set('cidadeUsuario', cidadeUsuario);
            if (peDominante)   params.set('peDominante', peDominante);
            if (maoDominante)  params.set('maoDominante', maoDominante);
            if (ordenarpor)    params.set('ordenarpor', ordenarpor);
            if (direction)     params.set('direction', direction);

            params.set('per_page', state.per_page);
            params.set('page', state.page);

            return params;
        }

        async function fetchResults() {
            const resultsContainer = document.getElementById('results-container');
            const info             = document.getElementById('pagination-info');
            if (resultsContainer) {
                resultsContainer.innerHTML = 'Carregando...';
            }
            if (info) info.textContent = '';

            const params = buildQueryParams();
            const url = endpoint + '?' + params.toString();

            try {
                const res = await fetch(url, { headers });
                const text = await res.text();
                let data;
                try { data = text ? JSON.parse(text) : null; } catch { data = null; }

                if (!res.ok) {
                    console.error('Erro ao buscar usuários:', data || text);
                    if (resultsContainer) resultsContainer.innerHTML = 'Não foi possível carregar os resultados.';
                    return;
                }

                state.lastResponse = data;
                renderResults();
            } catch (err) {
                console.error('Erro de rede na busca:', err);
                if (resultsContainer) resultsContainer.innerHTML = 'Erro de rede ao carregar os resultados.';
            }
        }

        function renderResults() {
            const resultsContainer = document.getElementById('results-container');
            const info             = document.getElementById('pagination-info');
            const btnPrev          = document.getElementById('btn-prev-page');
            const btnNext          = document.getElementById('btn-next-page');

            if (!resultsContainer) return;

            const resp = state.lastResponse;
            const lista = Array.isArray(resp?.data) ? resp.data : [];

            if (!lista.length) {
                resultsContainer.innerHTML = 'Nenhum resultado encontrado.';
            } else {
                resultsContainer.innerHTML = lista.map(userToRowHTML).join('');
            }

            const current = resp?.current_page ?? state.page;
            const last    = resp?.last_page ?? current;
            const total   = resp?.total ?? lista.length;

            if (info) {
                info.textContent = `Página ${current} de ${last} — ${total} resultados`;
            }

            if (btnPrev) {
                btnPrev.disabled = current <= 1;
            }
            if (btnNext) {
                btnNext.disabled = current >= last;
            }
        }

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
            const pesoStr   = pesoKg   != null ? `${pesoKg} kg`   : '';

            const perfilUrl = profileBase ? `${profileBase}/${id}` : '#';

            return `
                <article class="result-row" data-user-id="${id}">
                    <div class="result-main">
                        <div class="result-avatar">
                            <!-- avatar de exemplo (front pode trocar depois) -->
                            <span>👤</span>
                        </div>

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

        // ======== EVENTOS =========

        // Alternar filtros avançados
        const btnOpenAdvanced = document.getElementById('btn-open-advanced');
        const advancedSection = document.getElementById('advanced-filters');
        if (btnOpenAdvanced && advancedSection) {
            btnOpenAdvanced.addEventListener('click', () => {
                const isHidden = advancedSection.hasAttribute('hidden');
                if (isHidden) {
                    advancedSection.removeAttribute('hidden');
                } else {
                    advancedSection.setAttribute('hidden', 'hidden');
                }
            });
        }

        // Enter na barra simples chama busca
        const simpleForm = document.getElementById('simple-search-form');
        if (simpleForm) {
            simpleForm.addEventListener('submit', (e) => {
                e.preventDefault();
                state.page = 1;
                fetchResults();
            });
        }

        // Botão "Mostrar resultados" nos avançados
        const advancedForm = document.getElementById('advanced-search-form');
        if (advancedForm) {
            advancedForm.addEventListener('submit', (e) => {
                e.preventDefault();
                state.page = 1;
                fetchResults();
            });
        }

        // Botão limpar filtros
        const btnClear = document.getElementById('btn-clear-filters');
        if (btnClear && advancedForm && simpleForm) {
            btnClear.addEventListener('click', () => {
                advancedForm.reset();
                simpleForm.reset();
                state.page = 1;
                fetchResults();
            });
        }

        // Mudança em ordenação
        const ordenarSelect = document.getElementById('ordenarpor');
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

        // Carrega resultados iniciais (ex: sem filtros)
        fetchResults();
    })();
    </script>
</body>
</html>