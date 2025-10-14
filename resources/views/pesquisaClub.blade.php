<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesquisar perfis</title>
    <link rel="stylesheet" href="{{ asset('css/pesquisaClub.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
      <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <style>
        /* Estilos adicionais para os novos filtros */
        .advanced-filters {
            display: none;
            background: #f8f9fa;
            border: 1px solid #e9ecef;
            border-radius: 8px;
            padding: 20px;
            margin-top: 15px;
            animation: slideDown 0.3s ease-out;
        }

        .advanced-filters.show {
            display: block;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .filter-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 15px;
            margin-bottom: 20px;
        }

        .filter-group {
            display: flex;
            flex-direction: column;
        }

        .filter-group label {
            font-weight: 600;
            margin-bottom: 5px;
            color: #495057;
            font-size: 14px;
        }

        .filter-group input,
        .filter-group select {
            padding: 8px 12px;
            border: 1px solid #ced4da;
            border-radius: 4px;
            font-size: 14px;
            transition: border-color 0.2s;
        }

        .filter-group input:focus,
        .filter-group select:focus {
            outline: none;
            border-color: #007bff;
            box-shadow: 0 0 0 2px rgba(0, 123, 255, 0.25);
        }

        .range-inputs {
            display: flex;
            gap: 10px;
            align-items: center;
        }

        .range-inputs input {
            flex: 1;
        }

        .range-separator {
            color: #6c757d;
            font-weight: bold;
        }

        .filter-actions {
            display: flex;
            gap: 10px;
            justify-content: flex-end;
            margin-top: 15px;
            padding-top: 15px;
            border-top: 1px solid #e9ecef;
        }

        .btn {
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.2s;
        }

        .btn-primary {
            background-color: #007bff;
            color: white;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .btn-secondary {
            background-color: #6c757d;
            color: white;
        }

        .btn-secondary:hover {
            background-color: #545b62;
        }

        .btn-outline {
            background-color: transparent;
            border: 1px solid #ced4da;
            color: #495057;
        }

        .btn-outline:hover {
            background-color: #f8f9fa;
        }

        .active-filters {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin: 15px 0;
        }

        .filter-tag {
            background-color: #e3f2fd;
            color: #1976d2;
            padding: 4px 8px;
            border-radius: 16px;
            font-size: 12px;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .filter-tag .remove-filter {
            background: none;
            border: none;
            color: #1976d2;
            cursor: pointer;
            font-weight: bold;
            padding: 0;
            width: 16px;
            height: 16px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .filter-tag .remove-filter:hover {
            background-color: #1976d2;
            color: white;
        }

        .results-info {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin: 15px 0;
            padding: 10px;
            background-color: #f8f9fa;
            border-radius: 4px;
        }

        .results-count {
            font-weight: 600;
            color: #495057;
        }

        .pagination {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
            margin: 20px 0;
        }

        .pagination button {
            padding: 8px 12px;
            border: 1px solid #ced4da;
            background: white;
            cursor: pointer;
            border-radius: 4px;
            transition: all 0.2s;
        }

        .pagination button:hover:not(:disabled) {
            background-color: #007bff;
            color: white;
            border-color: #007bff;
        }

        .pagination button:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .pagination .current-page {
            background-color: #007bff;
            color: white;
            border-color: #007bff;
        }

        .loading {
            text-align: center;
            padding: 40px;
            color: #6c757d;
        }

        .loading::after {
            content: '';
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 2px solid #f3f3f3;
            border-top: 2px solid #007bff;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin-left: 10px;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .error-message {
            background-color: #f8d7da;
            color: #721c24;
            padding: 15px;
            border-radius: 4px;
            margin: 15px 0;
            border: 1px solid #f5c6cb;
        }

        .profile-card {
            transition: transform 0.2s, box-shadow 0.2s;
            background: white;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 15px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .profile-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .profile-stats {
            display: flex;
            gap: 15px;
            margin: 10px 0;
            font-size: 14px;
            color: #6c757d;
        }

        .profile-stat {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .profile-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 10px;
        }

        .profile-name {
            margin: 0;
            color: #333;
            font-size: 18px;
        }

        .profile-badges {
            display: flex;
            flex-wrap: wrap;
            gap: 5px;
        }

        .badge {
            padding: 2px 8px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 500;
        }

        .badge.athlete {
            background-color: #fff3cd;
            color: #856404;
        }

        .badge.position {
            background-color: #d4edda;
            color: #155724;
        }

        .badge.location {
            background-color: #cce5ff;
            color: #004085;
        }

        .badge.age {
            background-color: #f8d7da;
            color: #721c24;
        }

        .profile-actions {
            display: flex;
            gap: 10px;
            margin-top: 15px;
        }

        .profile-btn {
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            transition: all 0.2s;
        }

        .view-btn {
            background-color: #007bff;
            color: white;
        }

        .view-btn:hover {
            background-color: #0056b3;
        }

        .contact-btn {
            background-color: #28a745;
            color: white;
        }

        .contact-btn:hover {
            background-color: #1e7e34;
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #6c757d;
        }

        .empty-state h3 {
            margin-bottom: 10px;
            color: #495057;
        }
        #Logo{
        width: 150px;
        border-radius: 20px;
    }
    </style>
</head>
<body>
    <div class="container">
        <!-- Sidebar -->
         <aside class="sidebar">
            <div class="logo-section">
                <img id="Logo" src="{{ asset('img/logoPerfil.jpeg') }}" alt="Logo do Perfil">
            </div>
            
            <nav class="nav-menu">
                <ul>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <ion-icon name="grid-outline"></ion-icon>
                            <span class="nav-text">Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <ion-icon name="trophy-outline"></ion-icon>
                            <span class="nav-text">Oportunidades</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <ion-icon name="list-outline"></ion-icon>
                            <span class="nav-text">Listas</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <ion-icon name="chatbubbles-outline"></ion-icon>
                            <span class="nav-text">Mensagens</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <ion-icon name="notifications-outline"></ion-icon>
                            <span class="nav-text">Notificações</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="perfil" class="nav-link">
                            <ion-icon name="person-circle-outline"></ion-icon>
                            <span class="nav-text">Perfil</span>
                        </a>
                    </li>
                    <li class="nav-item active">
                        <a href="#" class="nav-link">
                            <ion-icon name="search-outline"></ion-icon>
                            <span class="nav-text">Pesquisa</span>
                        </a>
                    </li>
                    <li class="nav-item">
                       <a href="configuracoes" class="nav-link">
                            <ion-icon name="settings-outline"></ion-icon>
                            <span class="nav-text">Configurações</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <ion-icon name="log-out-outline"></ion-icon>
                            <span class="nav-text">Sair</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="main-content search-page">
            <!-- Header -->
           <header class="search-header">
                <h1 class="page-title">Pesquisar perfis</h1>
                <div class="header-actions">
                    <div class="user-info">
                        <span class="notification-icon"><ion-icon name="notifications-outline"></ion-icon></span>
                        <div class="user-profile">
                            <span class="user-avatar"><ion-icon name="person-circle-outline"></ion-icon></span>
                            <span class="user-name">
                                @auth
                                    {{ Auth::user()->nomeClube ?? 'Clube' }}
                                @else
                                    Clube
                                @endauth
                            </span>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Search Section -->
            <section class="search-section">
                 <div class="search-container">
                    <div class="search-input-wrapper">
                        <span class="search-icon"><ion-icon name="search-outline"></ion-icon></span>
                        <input type="text" id="search-input" class="search-input" placeholder="Pesquisar por nome ou email...">
                    </div>
                    <button class="advanced-search-btn" id="toggle-filters">
                        <span class="filter-icon"><ion-icon name="chevron-down-outline"></ion-icon></span>
                        Pesquisa avançada
                    </button>
                </div>

                <!-- Filtros Avançados -->
                <div class="advanced-filters" id="advanced-filters">
                    <div class="filter-grid">
                        <!-- Posição -->
                        <div class="filter-group">
                            <label for="posicao-select">Posição</label>
                            <select id="posicao-select">
                                <option value="">Todas as posições</option>
                                <!-- Opções serão carregadas dinamicamente -->
                            </select>
                        </div>

                        <!-- Altura -->
                        <div class="filter-group">
                            <label>Altura (cm)</label>
                            <div class="range-inputs">
                                <input type="number" id="altura-min" placeholder="Min" min="50" max="300">
                                <span class="range-separator">até</span>
                                <input type="number" id="altura-max" placeholder="Max" min="50" max="300">
                            </div>
                        </div>

                        <!-- Peso -->
                        <div class="filter-group">
                            <label>Peso (kg)</label>
                            <div class="range-inputs">
                                <input type="number" id="peso-min" placeholder="Min" min="20" max="500">
                                <span class="range-separator">até</span>
                                <input type="number" id="peso-max" placeholder="Max" min="20" max="500">
                            </div>
                        </div>

                        <!-- Idade -->
                        <div class="filter-group">
                            <label>Idade (anos)</label>
                            <div class="range-inputs">
                                <input type="number" id="idade-min" placeholder="Min" min="0" max="120">
                                <span class="range-separator">até</span>
                                <input type="number" id="idade-max" placeholder="Max" min="0" max="120">
                            </div>
                        </div>

                        <!-- Estado -->
                        <div class="filter-group">
                            <label for="estado-input">Estado</label>
                            <input type="text" id="estado-input" placeholder="Ex: São Paulo">
                        </div>

                        <!-- Cidade -->
                        <div class="filter-group">
                            <label for="cidade-input">Cidade</label>
                            <input type="text" id="cidade-input" placeholder="Ex: São Paulo">
                        </div>

                        <!-- Pé Dominante -->
                        <div class="filter-group">
                            <label for="pe-dominante-select">Pé Dominante</label>
                            <select id="pe-dominante-select">
                                <option value="">Qualquer</option>
                                <option value="direito">Direito</option>
                                <option value="esquerdo">Esquerdo</option>
                            </select>
                        </div>

                        <!-- Mão Dominante -->
                        <div class="filter-group">
                            <label for="mao-dominante-select">Mão Dominante</label>
                            <select id="mao-dominante-select">
                                <option value="">Qualquer</option>
                                <option value="destro">Destro</option>
                                <option value="canhoto">Canhoto</option>
                            </select>
                        </div>
                    </div>

                    <div class="filter-actions">
                        <button class="btn btn-outline" id="clear-filters">Limpar filtros</button>
                        <button class="btn btn-primary" id="apply-filters">Aplicar filtros</button>
                    </div>
                </div>

                <!-- Filtros Ativos -->
                <div class="active-filters" id="active-filters"></div>

                <!-- Informações dos Resultados -->
                <div class="results-info" id="results-info" style="display: none;">
                    <span class="results-count" id="results-count">0 perfis encontrados</span>
                    <div class="results-actions">
                        <select id="sort-select" class="sort-select">
                            <option value="recentes">Mais recentes</option>
                            <option value="nome">Nome (A-Z)</option>
                            <option value="altura">Altura</option>
                            <option value="peso">Peso</option>
                            <option value="idade">Idade</option>
                        </select>
                        <select id="per-page-select" style="margin-left: 10px;">
                            <option value="15">15 por página</option>
                            <option value="30">30 por página</option>
                            <option value="50">50 por página</option>
                        </select>
                    </div>
                </div>
            </section>

            <!-- Results Section -->
            <section class="results-section">
                <div class="profile-results" id="profile-results">
                    <!-- Resultados serão carregados aqui -->
                </div>

                <!-- Pagination -->
                <div class="pagination" id="pagination" style="display: none;">
                    <!-- Paginação será gerada dinamicamente -->
                </div>
            </section>
        </main>
    </div>

    <script>
        // Configuração global
        const API_BASE_URL = '{{ url("/") }}';
        const CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        class UsuarioSearch {
            constructor() {
                this.currentPage = 1;
                this.perPage = 15;
                this.totalPages = 1;
                this.currentFilters = {};
                this.isLoading = false;
                
                this.initializeElements();
                this.bindEvents();
                this.loadInitialData();
            }

            initializeElements() {
                // Elementos de busca
                this.searchInput = document.getElementById('search-input');
                this.toggleFiltersBtn = document.getElementById('toggle-filters');
                this.advancedFilters = document.getElementById('advanced-filters');
                this.applyFiltersBtn = document.getElementById('apply-filters');
                this.clearFiltersBtn = document.getElementById('clear-filters');
                
                // Elementos de filtros
                this.posicaoSelect = document.getElementById('posicao-select');
                this.alturaMin = document.getElementById('altura-min');
                this.alturaMax = document.getElementById('altura-max');
                this.pesoMin = document.getElementById('peso-min');
                this.pesoMax = document.getElementById('peso-max');
                this.idadeMin = document.getElementById('idade-min');
                this.idadeMax = document.getElementById('idade-max');
                this.estadoInput = document.getElementById('estado-input');
                this.cidadeInput = document.getElementById('cidade-input');
                this.peDominanteSelect = document.getElementById('pe-dominante-select');
                this.maoDominanteSelect = document.getElementById('mao-dominante-select');
                
                // Elementos de resultados
                this.profileResults = document.getElementById('profile-results');
                this.activeFilters = document.getElementById('active-filters');
                this.resultsInfo = document.getElementById('results-info');
                this.resultsCount = document.getElementById('results-count');
                this.sortSelect = document.getElementById('sort-select');
                this.perPageSelect = document.getElementById('per-page-select');
                this.pagination = document.getElementById('pagination');
            }

            bindEvents() {
                // Toggle filtros avançados
                this.toggleFiltersBtn.addEventListener('click', () => {
                    this.advancedFilters.classList.toggle('show');
                    const icon = this.toggleFiltersBtn.querySelector('.filter-icon');
                    icon.textContent = this.advancedFilters.classList.contains('show') ? '🔼' : '🔽';
                });

                // Busca em tempo real
                let searchTimeout;
                this.searchInput.addEventListener('input', () => {
                    clearTimeout(searchTimeout);
                    searchTimeout = setTimeout(() => {
                        this.currentPage = 1;
                        this.performSearch();
                    }, 500);
                });

                // Aplicar filtros
                this.applyFiltersBtn.addEventListener('click', () => {
                    this.currentPage = 1;
                    this.performSearch();
                });

                // Limpar filtros
                this.clearFiltersBtn.addEventListener('click', () => {
                    this.clearAllFilters();
                });

                // Ordenação e paginação
                this.sortSelect.addEventListener('change', () => {
                    this.currentPage = 1;
                    this.performSearch();
                });

                this.perPageSelect.addEventListener('change', () => {
                    this.perPage = parseInt(this.perPageSelect.value);
                    this.currentPage = 1;
                    this.performSearch();
                });
            }

            async loadInitialData() {
                await this.loadPosicoes();
                await this.performSearch();
            }

            async loadPosicoes() {
                try {
                    const response = await fetch(`${API_BASE_URL}/api/posicoes`, {
                        headers: {
                            'X-CSRF-TOKEN': CSRF_TOKEN,
                            'Accept': 'application/json',
                        }
                    });
                    
                    if (response.ok) {
                        const posicoes = await response.json();
                        
                        posicoes.forEach(posicao => {
                            const option = document.createElement('option');
                            option.value = posicao.id;
                            option.textContent = posicao.nomePosicao;
                            this.posicaoSelect.appendChild(option);
                        });
                    } else {
                        console.warn('Endpoint de posições não encontrado, usando dados padrão');
                        this.loadPosicoesPadrao();
                    }
                } catch (error) {
                    console.warn('Erro ao carregar posições, usando dados padrão:', error);
                    this.loadPosicoesPadrao();
                }
            }

            loadPosicoesPadrao() {
                const posicoes = [
                    { id: 1, nomePosicao: 'Goleiro' },
                    { id: 2, nomePosicao: 'Zagueiro' },
                    { id: 3, nomePosicao: 'Lateral' },
                    { id: 4, nomePosicao: 'Meio-campo' },
                    { id: 5, nomePosicao: 'Atacante' }
                ];

                posicoes.forEach(posicao => {
                    const option = document.createElement('option');
                    option.value = posicao.id;
                    option.textContent = posicao.nomePosicao;
                    this.posicaoSelect.appendChild(option);
                });
            }

            buildFilters() {
                const filters = {};

                // Busca textual
                if (this.searchInput.value.trim()) {
                    filters.pesquisa = this.searchInput.value.trim();
                }

                // Posição
                if (this.posicaoSelect.value) {
                    filters.posicao_id = this.posicaoSelect.value;
                }

                // Altura
                if (this.alturaMin.value) filters.altura_min = this.alturaMin.value;
                if (this.alturaMax.value) filters.altura_max = this.alturaMax.value;

                // Peso
                if (this.pesoMin.value) filters.peso_min = this.pesoMin.value;
                if (this.pesoMax.value) filters.peso_max = this.pesoMax.value;

                // Idade
                if (this.idadeMin.value) filters.idade_min = this.idadeMin.value;
                if (this.idadeMax.value) filters.idade_max = this.idadeMax.value;

                // Localização
                if (this.estadoInput.value.trim()) filters.estadoUsuario = this.estadoInput.value.trim();
                if (this.cidadeInput.value.trim()) filters.cidadeUsuario = this.cidadeInput.value.trim();

                // Dominância
                if (this.peDominanteSelect.value) filters.peDominante = this.peDominanteSelect.value;
                if (this.maoDominanteSelect.value) filters.maoDominante = this.maoDominanteSelect.value;

                // Paginação e ordenação
                filters.page = this.currentPage;
                filters.per_page = this.perPage;
                filters.ordenarpor = this.sortSelect.value;

                return filters;
            }

            async performSearch() {
                if (this.isLoading) return;

                this.isLoading = true;
                this.showLoading();

                try {
                    const filters = this.buildFilters();
                    this.currentFilters = filters;

                    // Construir URL com parâmetros
                    const url = new URL(`${API_BASE_URL}/api/clube/search-usuarios`);
                    Object.keys(filters).forEach(key => {
                        if (filters[key] !== null && filters[key] !== undefined && filters[key] !== '') {
                            url.searchParams.append(key, filters[key]);
                        }
                    });



                    const authToken = localStorage.getItem('token');

                    const headers = {
                        'X-CSRF-TOKEN': CSRF_TOKEN,
                         'Accept': 'application/json',
                    };

                    if (authToken) {
            headers['Authorization'] = authToken; // O token já deve ter o "Bearer " do login
        } else {
            console.error('Token de autenticação não encontrado. Faça o login primeiro.');
            this.showError('Você não está autenticado. Por favor, faça o login e tente novamente.');
            return; // Interrompe a busca se não houver token
        }

         const response = await fetch(url, {
            headers: headers // Use o objeto de headers que acabamos de criar
        });
                    
                    if (!response.ok) {
                        throw new Error(`Erro HTTP: ${response.status}`);
                    }

                    const data = await response.json();
                    
                    this.renderResults(data);
                    this.updateActiveFilters();
                    this.updateResultsInfo(data);
                    this.renderPagination(data);

                } catch (error) {
                    console.error('Erro na busca:', error);
                    this.showError('Erro ao buscar usuários. Verifique sua conexão e tente novamente.');
                } finally {
                    this.isLoading = false;
                }
            }

            showLoading() {
                this.profileResults.innerHTML = '<div class="loading">Carregando usuários...</div>';
            }

            showError(message) {
                this.profileResults.innerHTML = `<div class="error-message">${message}</div>`;
            }

            renderResults(data) {
                const usuarios = data.data || [];

                if (usuarios.length === 0) {
                    this.profileResults.innerHTML = `
                        <div class="empty-state">
                            <h3>Nenhum atleta encontrado</h3>
                            <p>Tente ajustar os filtros de busca para encontrar mais resultados.</p>
                        </div>
                    `;
                    return;
                }

                this.profileResults.innerHTML = '';

                usuarios.forEach(usuario => {
                    const idade = this.calcularIdade(usuario.dataNascimentoUsuario);
                    const posicoes = usuario.posicoes?.map(p => p.nomePosicao).join(', ') || 'Sem posição';
                    const localizacao = [usuario.cidadeUsuario, usuario.estadoUsuario].filter(Boolean).join(' - ') || 'Localização não informada';

                    const card = document.createElement('div');
                    card.classList.add('profile-card');
                    card.innerHTML = `
                        <div class="profile-header">
                            <h3 class="profile-name">${usuario.nomeCompletoUsuario}</h3>
                            <div class="profile-badges">
                               <span class="badge athlete">
  <ion-icon name="star"></ion-icon> Atleta
</span>

<span class="badge position">
  <ion-icon name="football-outline"></ion-icon> ${posicoes}
</span>

<span class="badge location">
  <ion-icon name="location-outline"></ion-icon> ${localizacao}
</span>

<span class="badge age">
  <ion-icon name="person-outline"></ion-icon> ${idade} anos
</span>
                            </div>
                        </div>
                        <div class="profile-stats">
                        ${usuario.alturaCm ? `
  <div class="profile-stat">
    <ion-icon name="resize-outline"></ion-icon> ${usuario.alturaCm}cm
  </div>` : ''}

${usuario.pesoKg ? `
  <div class="profile-stat">
    <ion-icon name="barbell-outline"></ion-icon> ${usuario.pesoKg}kg
  </div>` : ''}

${usuario.peDominante ? `
  <div class="profile-stat">
    <ion-icon name="walk-outline"></ion-icon> ${usuario.peDominante}
  </div>` : ''}

${usuario.maoDominante ? `
  <div class="profile-stat">
    <ion-icon name="hand-left-outline"></ion-icon> ${usuario.maoDominante}
  </div>` : ''}
                        </div>
                        <div class="profile-actions">
                            <button class="profile-btn view-btn" onclick="verPerfil(${usuario.id})">Ver perfil</button>
                            <button class="profile-btn contact-btn" onclick="contatar(${usuario.id})">Contato</button>
                        </div>
                    `;
                    this.profileResults.appendChild(card);
                });
            }

            calcularIdade(dataNascimento) {
                if (!dataNascimento) return 'N/A';
                
                const hoje = new Date();
                const nascimento = new Date(dataNascimento);
                let idade = hoje.getFullYear() - nascimento.getFullYear();
                const mes = hoje.getMonth() - nascimento.getMonth();
                
                if (mes < 0 || (mes === 0 && hoje.getDate() < nascimento.getDate())) {
                    idade--;
                }
                
                return idade;
            }

            updateActiveFilters() {
                this.activeFilters.innerHTML = '';
                
                const filterLabels = {
                    pesquisa: 'Busca',
                    posicao_id: 'Posição',
                    altura_min: 'Altura mín',
                    altura_max: 'Altura máx',
                    peso_min: 'Peso mín',
                    peso_max: 'Peso máx',
                    idade_min: 'Idade mín',
                    idade_max: 'Idade máx',
                    estadoUsuario: 'Estado',
                    cidadeUsuario: 'Cidade',
                    peDominante: 'Pé dominante',
                    maoDominante: 'Mão dominante'
                };

                Object.keys(this.currentFilters).forEach(key => {
                    if (filterLabels[key] && this.currentFilters[key]) {
                        const tag = document.createElement('div');
                        tag.className = 'filter-tag';
                        tag.innerHTML = `
                            <span>${filterLabels[key]}: ${this.currentFilters[key]}</span>
                            <button class="remove-filter" onclick="usuarioSearch.removeFilter('${key}')">×</button>
                        `;
                        this.activeFilters.appendChild(tag);
                    }
                });
            }

            updateResultsInfo(data) {
                this.resultsCount.textContent = `${data.total || 0} perfis encontrados`;
                this.resultsInfo.style.display = 'flex';
                this.totalPages = data.last_page || 1;
                this.currentPage = data.current_page || 1;
            }

            renderPagination(data) {
                if (this.totalPages <= 1) {
                    this.pagination.style.display = 'none';
                    return;
                }

                this.pagination.style.display = 'flex';
                this.pagination.innerHTML = '';

                // Botão anterior
                const prevBtn = document.createElement('button');
                prevBtn.textContent = '← Anterior';
                prevBtn.disabled = this.currentPage === 1;
                prevBtn.onclick = () => this.goToPage(this.currentPage - 1);
                this.pagination.appendChild(prevBtn);

                // Números das páginas
                const startPage = Math.max(1, this.currentPage - 2);
                const endPage = Math.min(this.totalPages, this.currentPage + 2);

                for (let i = startPage; i <= endPage; i++) {
                    const pageBtn = document.createElement('button');
                    pageBtn.textContent = i;
                    pageBtn.className = i === this.currentPage ? 'current-page' : '';
                    pageBtn.onclick = () => this.goToPage(i);
                    this.pagination.appendChild(pageBtn);
                }

                // Botão próximo
                const nextBtn = document.createElement('button');
                nextBtn.textContent = 'Próximo →';
                nextBtn.disabled = this.currentPage === this.totalPages;
                nextBtn.onclick = () => this.goToPage(this.currentPage + 1);
                this.pagination.appendChild(nextBtn);
            }

            goToPage(page) {
                if (page >= 1 && page <= this.totalPages && page !== this.currentPage) {
                    this.currentPage = page;
                    this.performSearch();
                }
            }

            removeFilter(filterKey) {
                // Limpar o campo correspondente
                switch (filterKey) {
                    case 'pesquisa':
                        this.searchInput.value = '';
                        break;
                    case 'posicao_id':
                        this.posicaoSelect.value = '';
                        break;
                    case 'altura_min':
                        this.alturaMin.value = '';
                        break;
                    case 'altura_max':
                        this.alturaMax.value = '';
                        break;
                    case 'peso_min':
                        this.pesoMin.value = '';
                        break;
                    case 'peso_max':
                        this.pesoMax.value = '';
                        break;
                    case 'idade_min':
                        this.idadeMin.value = '';
                        break;
                    case 'idade_max':
                        this.idadeMax.value = '';
                        break;
                    case 'estadoUsuario':
                        this.estadoInput.value = '';
                        break;
                    case 'cidadeUsuario':
                        this.cidadeInput.value = '';
                        break;
                    case 'peDominante':
                        this.peDominanteSelect.value = '';
                        break;
                    case 'maoDominante':
                        this.maoDominanteSelect.value = '';
                        break;
                }

                // Refazer a busca
                this.currentPage = 1;
                this.performSearch();
            }

            clearAllFilters() {
                // Limpar todos os campos
                this.searchInput.value = '';
                this.posicaoSelect.value = '';
                this.alturaMin.value = '';
                this.alturaMax.value = '';
                this.pesoMin.value = '';
                this.pesoMax.value = '';
                this.idadeMin.value = '';
                this.idadeMax.value = '';
                this.estadoInput.value = '';
                this.cidadeInput.value = '';
                this.peDominanteSelect.value = '';
                this.maoDominanteSelect.value = '';

                // Refazer a busca
                this.currentPage = 1;
                this.performSearch();
            }
        }

        // Funções globais para ações dos botões
        function verPerfil(usuarioId) {
            // Implementar navegação para o perfil do usuário
            console.log('Ver perfil do usuário:', usuarioId);
            // window.location.href = `/usuario/${usuarioId}`;
            alert(`Funcionalidade "Ver perfil" será implementada para o usuário ${usuarioId}`);
        }

        function contatar(usuarioId) {
            // Implementar funcionalidade de contato
            console.log('Contatar usuário:', usuarioId);
            // window.location.href = `/mensagens/novo/${usuarioId}`;
            alert(`Funcionalidade "Contatar" será implementada para o usuário ${usuarioId}`);
        }

        // Inicializar quando a página carregar
        let usuarioSearch;
        document.addEventListener('DOMContentLoaded', function() {
            usuarioSearch = new UsuarioSearch();
        });
    </script>

    <script>
        // Seleciona os elementos do DOM
        const themeToggle = document.getElementById('theme-toggle');
        const themeName = document.getElementById('theme-name');
        const body = document.body;

        // Função para aplicar o tema salvo
        const applyTheme = (theme) => {
            if (theme === 'dark') {
                body.classList.add('dark-theme');
                themeName.textContent = 'Escuro';
                themeToggle.checked = true;
            } else {
                body.classList.remove('dark-theme');
                themeName.textContent = 'Claro';
                themeToggle.checked = false;
            }
        };

        // Verifica se há um tema salvo no localStorage
        const savedTheme = localStorage.getItem('theme');
        
        // Aplica o tema salvo ao carregar a página
        // Se não houver tema salvo, o padrão será 'claro'
        applyTheme(savedTheme);

        // Adiciona o evento de clique ao toggle
        themeToggle.addEventListener('change', () => {
            let newTheme;
            // Se o toggle estiver marcado, o tema é 'escuro'
            if (themeToggle.checked) {
                newTheme = 'dark';
            } else {
                newTheme = 'claro';
            }
            
            // Aplica o novo tema
            applyTheme(newTheme);
            
            // Salva a preferência no localStorage
            localStorage.setItem('theme', newTheme);
        });
    </script>
</body>
</html>
