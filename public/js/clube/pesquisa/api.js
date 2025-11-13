window.Pesquisa = window.Pesquisa || {};

Pesquisa.api = {
    async fetchResults() {
        const { config, dom, state, utils } = Pesquisa;
        const c    = dom?.resultsContainer;
        const info = dom?.paginationInfo;

        if (c) c.textContent = 'Carregando...';
        if (info) info.textContent = '';

        const params = utils.buildQueryParams();
        const url = config.endpoint + '?' + params.toString();

        try {
            const res  = await fetch(url, { headers: config.headers });
            const text = await res.text();
            let data;
            try { data = text ? JSON.parse(text) : null; } catch { data = null; }

            if (!res.ok) {
                console.error('Erro ao buscar usuários:', data || text);
                if (c) c.textContent = 'Não foi possível carregar os resultados.';
                utils.renderActiveFiltersChips();
                return;
            }

            state.lastResponse = data;
            utils.renderResults();
            utils.renderActiveFiltersChips();
        } catch (err) {
            console.error('Erro de rede na busca:', err);
            if (c) c.textContent = 'Erro de rede ao carregar os resultados.';
            utils.renderActiveFiltersChips();
        }
    },
};