window.Pesquisa = window.Pesquisa || {};

Pesquisa.utils = {
    calcAge(isoDate) {
        if (!isoDate) return null;
        const d = new Date(isoDate);
        if (isNaN(d.getTime())) return null;
        const today = new Date();
        let age = today.getFullYear() - d.getFullYear();
        const m = today.getMonth() - d.getMonth();
        if (m < 0 || (m === 0 && today.getDate() < d.getDate())) age--;
        return age;
    },

    buildQueryParams() {
        const { state, dom } = Pesquisa;
        const p = new URLSearchParams();

        const pesquisa       = dom.inputPesquisa?.value ?? '';
        const posicao_id     = dom.posicaoSelect?.value ?? '';

        const altura_min     = dom.alturaMin?.value ?? '';
        const altura_max     = dom.alturaMax?.value ?? '';

        const peso_min       = dom.pesoMin?.value ?? '';
        const peso_max       = dom.pesoMax?.value ?? '';

        const idade_min      = dom.idadeMin?.value ?? '';
        const idade_max      = dom.idadeMax?.value ?? '';

        const estadoUsuario  = dom.estadoUsuario?.value ?? '';
        const cidadeUsuario  = dom.cidadeUsuario?.value ?? '';

        const ordenarpor     = dom.ordenarSelect?.value ?? '';
        const direction      = dom.directionSelect?.value ?? '';

        if (pesquisa)      p.set('pesquisa', pesquisa);
        if (posicao_id)    p.set('posicao_id', posicao_id);
        if (altura_min)    p.set('altura_min', altura_min);
        if (altura_max)    p.set('altura_max', altura_max);
        if (peso_min)      p.set('peso_min', peso_min);
        if (peso_max)      p.set('peso_max', peso_max);
        if (idade_min)     p.set('idade_min', idade_min);
        if (idade_max)     p.set('idade_max', idade_max);
        if (estadoUsuario) p.set('estadoUsuario', estadoUsuario);
        if (cidadeUsuario) p.set('cidadeUsuario', cidadeUsuario);
        if (ordenarpor)    p.set('ordenarpor', ordenarpor);
        if (direction)     p.set('direction', direction);

        p.set('per_page', state.per_page);
        p.set('page', state.page);

        return p;
    },

    renderActiveFiltersChips() {
        const { dom, state } = Pesquisa;
        const container = dom.activeFilters;
        if (!container) return;

        const chips = [];

        const idadeMin = dom.idadeMin?.value || '';
        const idadeMax = dom.idadeMax?.value || '';

        const alturaMin = dom.alturaMin?.value || '';
        const alturaMax = dom.alturaMax?.value || '';

        const pesoMin   = dom.pesoMin?.value || '';
        const pesoMax   = dom.pesoMax?.value || '';

        const estado    = dom.estadoUsuario?.value || '';
        const cidade    = dom.cidadeUsuario?.value || '';

        const posicaoSelect = dom.posicaoSelect;
        const posicaoValue  = posicaoSelect?.value || '';
        const posicaoLabel  = posicaoSelect && posicaoSelect.value
            ? (posicaoSelect.options[posicaoSelect.selectedIndex]?.text || '')
            : '';

        if (idadeMin || idadeMax) {
            const label = `Idade: ${idadeMin || '?'} - ${idadeMax || '?'}`;
            chips.push(
                `<button type="button" class="filter-chip" data-clear="idade_min,idade_max">${label} ×</button>`
            );
        }

        if (alturaMin || alturaMax) {
            const label = `Altura: ${alturaMin || '?'} - ${alturaMax || '?'} cm`;
            chips.push(
                `<button type="button" class="filter-chip" data-clear="altura_min,altura_max">${label} ×</button>`
            );
        }

        if (pesoMin || pesoMax) {
            const label = `Peso: ${pesoMin || '?'} - ${pesoMax || '?'} kg`;
            chips.push(
                `<button type="button" class="filter-chip" data-clear="peso_min,peso_max">${label} ×</button>`
            );
        }

        if (cidade || estado) {
            const locLabel = `${cidade}${cidade && estado ? ' - ' : ''}${estado}`;
            chips.push(
                `<button type="button" class="filter-chip" data-clear="cidadeUsuario,estadoUsuario">Localização: ${locLabel} ×</button>`
            );
        }

        if (posicaoValue && posicaoLabel) {
            chips.push(
                `<button type="button" class="filter-chip" data-clear="posicao_id">Posição: ${posicaoLabel} ×</button>`
            );
        }

        container.innerHTML = chips.join('');

        container.querySelectorAll('[data-clear]').forEach(btn => {
            btn.addEventListener('click', () => {
                const fields = (btn.dataset.clear || '').split(',');
                fields.forEach(id => {
                    const el = document.getElementById(id);
                    if (!el) return;
                    if (el.tagName === 'SELECT' || el.tagName === 'INPUT') {
                        el.value = '';
                    }
                });
                state.page = 1;
                Pesquisa.api.fetchResults();
            });
        });
    },

    userToRowHTML(u) {
        const { profileBase } = Pesquisa.config;
        const id        = u.id;
        const nome      = u.nomeCompletoUsuario || 'Usuário';
        const cidade    = u.cidadeUsuario || '';
        const estado    = u.estadoUsuario || '';
        const alturaCm  = u.alturaCm != null ? u.alturaCm : null;
        const pesoKg    = u.pesoKg   != null ? u.pesoKg   : null;
        const idade     = Pesquisa.utils.calcAge(u.dataNascimentoUsuario);
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
                    <div class="result-avatar"><span><i class='bx bx-user'></i></span></div>

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
                </div>
            </article>
        `;
    },

    renderResults() {
        const { dom, state } = Pesquisa;
        const c      = dom.resultsContainer;
        const info   = dom.paginationInfo;
        const btnPrev = dom.btnPrevPage;
        const btnNext = dom.btnNextPage;

        if (!c) return;

        const resp  = state.lastResponse;
        const lista = Array.isArray(resp?.data) ? resp.data : [];

        if (!lista.length) {
            c.textContent = 'Nenhum resultado encontrado.';
        } else {
            c.innerHTML = lista.map(Pesquisa.utils.userToRowHTML).join('');
        }

        const current = resp?.current_page ?? state.page;
        const last    = resp?.last_page ?? current;
        const total   = resp?.total ?? lista.length;

        if (info) info.textContent = `Página ${current} de ${last} — ${total} resultados`;
        if (btnPrev) btnPrev.disabled = current <= 1;
        if (btnNext) btnNext.disabled = current >= last;
    },
};