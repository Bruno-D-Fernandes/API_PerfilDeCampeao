window.Pesquisa = window.Pesquisa || {};

(function () {
    document.addEventListener('DOMContentLoaded', () => {
        const root = document.getElementById('search-root');
        if (!root) return;

        const token = localStorage.getItem('clube_token');
        const csrf  = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') ?? '';

        Pesquisa.config = {
            endpoint: root.dataset.endpoint,
            profileBase: root.dataset.profileUrlBase,
            headers: {
                Accept: 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                Authorization: token,
                'X-CSRF-TOKEN': csrf,
            },
        };

        Pesquisa.state = {
            page: 1,
            per_page: 15,
            lastResponse: null,
        };

        if (Pesquisa.dom && typeof Pesquisa.dom.init === 'function') {
            Pesquisa.dom.init();
        }

        if (Pesquisa.events && typeof Pesquisa.events.init === 'function') {
            Pesquisa.events.init();
        }

        if (Pesquisa.api && typeof Pesquisa.api.fetchResults === 'function') {
            Pesquisa.api.fetchResults();
        }
    });
})();