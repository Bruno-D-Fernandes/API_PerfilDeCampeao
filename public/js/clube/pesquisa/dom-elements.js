window.Pesquisa = window.Pesquisa || {};

Pesquisa.dom = {
    init() {
        this.root              = document.getElementById('search-root');

        this.resultsContainer  = document.getElementById('results-container');
        this.paginationInfo    = document.getElementById('pagination-info');
        this.btnPrevPage       = document.getElementById('btn-prev-page');
        this.btnNextPage       = document.getElementById('btn-next-page');
        this.activeFilters     = document.getElementById('active-filters');

        this.filtersModal      = document.getElementById('filters-modal');
        this.filtersBackdrop   = document.getElementById('filters-modal-backdrop');
        this.filtersClose      = document.getElementById('filters-close');
        this.btnOpenFilters    = document.getElementById('btn-open-filters-modal');

        this.filterButtons     = Array.from(document.querySelectorAll('[data-filter-option]'));
        this.filterPanels      = Array.from(document.querySelectorAll('[data-filter-panel]'));

        this.simpleForm        = document.getElementById('simple-search-form');
        this.advancedForm      = document.getElementById('advanced-search-form');
        this.btnAdvancedSearch = document.getElementById('btn-advanced-search');
        this.btnClearFilters   = document.getElementById('btn-clear-filters');

        this.ordenarSelect     = document.getElementById('ordenarpor');
        this.directionSelect   = document.getElementById('direction');

        this.inputPesquisa     = document.getElementById('pesquisa');
        this.posicaoSelect     = document.getElementById('posicao_id');

        this.idadeMin          = document.getElementById('idade_min');
        this.idadeMax          = document.getElementById('idade_max');
        this.alturaMin         = document.getElementById('altura_min');
        this.alturaMax         = document.getElementById('altura_max');
        this.pesoMin           = document.getElementById('peso_min');
        this.pesoMax           = document.getElementById('peso_max');
        this.estadoUsuario     = document.getElementById('estadoUsuario');
        this.cidadeUsuario     = document.getElementById('cidadeUsuario');
    },
};