window.Pesquisa = window.Pesquisa || {};

Pesquisa.events = {
    showFilterPanel(key) {
        const { filterPanels, filterButtons } = Pesquisa.dom;

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
    },

    openFiltersModal() {
        const { filtersModal } = Pesquisa.dom;
        if (!filtersModal) return;
        filtersModal.removeAttribute('hidden');
        Pesquisa.events.showFilterPanel('idade');
    },

    closeFiltersModal() {
        const { filtersModal } = Pesquisa.dom;
        if (!filtersModal) return;
        filtersModal.setAttribute('hidden', 'hidden');
    },

    init() {
        const { dom, api, state } = Pesquisa;

        if (dom.btnOpenFilters) {
            dom.btnOpenFilters.addEventListener('click', () => {
                Pesquisa.events.openFiltersModal();
            });
        }

        if (dom.filtersClose) {
            dom.filtersClose.addEventListener('click', () => {
                Pesquisa.events.closeFiltersModal();
            });
        }

        if (dom.filtersBackdrop) {
            dom.filtersBackdrop.addEventListener('click', () => {
                Pesquisa.events.closeFiltersModal();
            });
        }

        dom.filterButtons.forEach(btn => {
            btn.addEventListener('click', () => {
                const key = btn.dataset.filterOption;
                if (key) Pesquisa.events.showFilterPanel(key);
            });
        });

        if (dom.btnAdvancedSearch) {
            dom.btnAdvancedSearch.addEventListener('click', e => {
                e.preventDefault();
                state.page = 1;
                api.fetchResults();
            });
        }

        if (dom.simpleForm) {
            dom.simpleForm.addEventListener('submit', e => {
                e.preventDefault();
                state.page = 1;
                api.fetchResults();
            });
        }

        if (dom.advancedForm) {
            dom.advancedForm.addEventListener('submit', e => {
                e.preventDefault();
                state.page = 1;
                api.fetchResults();
                Pesquisa.events.closeFiltersModal();
            });
        }

        if (dom.btnClearFilters) {
            dom.btnClearFilters.addEventListener('click', () => {
                if (dom.simpleForm) dom.simpleForm.reset();
                if (dom.advancedForm) dom.advancedForm.reset();
                state.page = 1;
                api.fetchResults();
            });
        }

        if (dom.ordenarSelect) {
            dom.ordenarSelect.addEventListener('change', () => {
                state.page = 1;
                api.fetchResults();
            });
        }

        if (dom.directionSelect) {
            dom.directionSelect.addEventListener('change', () => {
                state.page = 1;
                api.fetchResults();
            });
        }

        if (dom.btnPrevPage) {
            dom.btnPrevPage.addEventListener('click', () => {
                if (state.page > 1) {
                    state.page--;
                    api.fetchResults();
                }
            });
        }

        if (dom.btnNextPage) {
            dom.btnNextPage.addEventListener('click', () => {
                const last = state.lastResponse?.last_page ?? state.page;
                if (state.page < last) {
                    state.page++;
                    api.fetchResults();
                }
            });
        }
    },
};