<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestão de Esportes e Posições</title>
    <link rel="stylesheet" href="{{ asset('css/dashboard/esporte.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
</head>

<style>
    /* SEU CSS EXISTENTE VAI AQUI (sem alterações ) */
    :root {
        --primary-blue: #3B82F6; --primary-blue-light: #EFF6FF; --text-dark: #1F2937; --text-light: #6B7280; --bg-light: #F9FAFB; --bg-white: #FFFFFF; --border-color: #E5E7EB; --status-green: #10B981; --status-green-bg: #D1FAE5; --logout-red: #EF4444; --action-view: #3B82F6; --action-edit: #8B5CF6; --action-delete: #EF4444;
    }
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body { font-family: 'Inter', sans-serif; background-color: var(--bg-light); color: var(--text-dark); -webkit-font-smoothing: antialiased; -moz-osx-font-smoothing: grayscale; }
    .dashboard-container { display: flex; min-height: 100vh; }
    .sidebar { width: 250px; background-color: var(--bg-white); border-right: 1px solid var(--border-color); display: flex; flex-direction: column; padding: 24px 12px; position: fixed; height: 100%; left: 0; top: 0; }
    .sidebar-header { padding: 0 12px 24px 12px; }
    .logo { font-size: 24px; font-weight: 700; color: var(--text-dark); }
    .sidebar-nav { flex-grow: 1; }
    .menu-title { font-size: 12px; font-weight: 600; color: var(--text-light); text-transform: uppercase; letter-spacing: 0.05em; padding: 0 12px 8px 12px; display: block; }
    .sidebar-nav ul, .sidebar-footer ul { list-style: none; }
    .sidebar-nav li a, .sidebar-footer li a { display: flex; align-items: center; padding: 10px 12px; margin-bottom: 4px; border-radius: 6px; text-decoration: none; font-size: 14px; font-weight: 500; color: var(--text-light); transition: background-color 0.2s, color 0.2s; }
    .sidebar-nav li a:hover { background-color: var(--bg-light); color: var(--text-dark); }
    .sidebar-nav li.active a { background-color: var(--primary-blue); color: var(--bg-white); }
    .sidebar-nav li a .icon, .sidebar-footer li a .icon { width: 20px; height: 20px; margin-right: 12px; }
    .sidebar-nav li a .chevron { width: 16px; height: 16px; margin-left: auto; }
    .sidebar-nav li.active a .icon, .sidebar-nav li.active a .chevron { color: var(--bg-white); }
    .sidebar-footer { padding-top: 16px; border-top: 1px solid var(--border-color); }
    .sidebar-footer li a.logout { color: var(--logout-red); }
    .sidebar-footer li a.logout:hover { background-color: #FEF2F2; }
    .main-content { margin-left: 250px; flex-grow: 1; padding: 24px 32px; }
    .main-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; }
    .page-title { font-size: 28px; font-weight: 700; color: var(--text-dark); }
    .user-menu { display: flex; align-items: center; gap: 16px; }
    .icon-button { background: none; border: none; cursor: pointer; color: var(--text-light); padding: 4px; }
    .icon-button svg { width: 24px; height: 24px; }
    .user-profile { display: flex; align-items: center; gap: 12px; background-color: var(--bg-white); padding: 6px 12px 6px 6px; border-radius: 999px; border: 1px solid var(--border-color); font-weight: 500; }
    .user-profile .avatar { width: 32px; height: 32px; border-radius: 50%; background-color: var(--primary-blue-light); color: var(--primary-blue); display: flex; align-items: center; justify-content: center; }
    .user-profile .avatar svg { width: 20px; height: 20px; }
    .content-body { background-color: var(--bg-white); border-radius: 12px; padding: 24px; border: 1px solid var(--border-color); }
    .toolbar { display: flex; align-items: center; gap: 16px; margin-bottom: 24px; }
    .search-bar { flex-grow: 1; position: relative; }
    .search-bar svg { position: absolute; left: 14px; top: 50%; transform: translateY(-50%); width: 20px; height: 20px; color: var(--text-light); }
    .search-bar input { width: 100%; padding: 10px 16px 10px 44px; border-radius: 8px; border: 1px solid var(--border-color); background-color: var(--bg-light); font-size: 14px; }
    .search-bar input:focus { outline: none; border-color: var(--primary-blue); background-color: var(--bg-white); }
    .filter-button, .add-button { padding: 10px 16px; border-radius: 8px; border: 1px solid var(--border-color); background-color: var(--bg-white); font-size: 14px; font-weight: 500; cursor: pointer; display: flex; align-items: center; gap: 8px; transition: background-color 0.2s; }
    .filter-button:hover, .add-button:hover { background-color: var(--bg-light); }
    .filter-button svg { width: 16px; height: 16px; }
    .add-button { background-color: var(--text-dark); color: var(--bg-white); border-color: var(--text-dark); }
    .add-button:hover { background-color: #374151; }
    .table-container { width: 100%; overflow-x: auto; }
    table { width: 100%; border-collapse: collapse; text-align: left; }
    th, td { padding: 12px 16px; vertical-align: middle; }
    thead { border-bottom: 1px solid var(--border-color); }
    th { font-size: 12px; font-weight: 600; color: var(--text-light); text-transform: uppercase; letter-spacing: 0.05em; }
    tbody tr { border-bottom: 1px solid var(--border-color); }
    tbody tr:last-child { border-bottom: none; }
    td { font-size: 14px; color: var(--text-light); }
    td:first-child { font-weight: 500; color: var(--text-dark); }
    .status-badge { display: inline-block; padding: 4px 10px; border-radius: 999px; font-size: 12px; font-weight: 500; }
    .status-badge.active { background-color: var(--status-green-bg); color: var(--status-green); }
    .action-buttons { display: flex; gap: 8px; }
    .action-btn { width: 32px; height: 32px; border-radius: 6px; border: 1px solid var(--border-color); background-color: var(--bg-white); color: var(--text-light); display: flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.2s; }
    .action-btn svg { width: 16px; height: 16px; }
    .action-btn:hover { color: var(--bg-white); border-color: transparent; }
    .action-btn.view:hover { background-color: var(--action-view); }
    .action-btn.edit:hover { background-color: var(--action-edit); }
    .action-btn.delete:hover { background-color: var(--action-delete); }
    .modal-overlay { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.6); z-index: 1000; display: flex; align-items: center; justify-content: center; opacity: 0; visibility: hidden; transition: opacity 0.3s, visibility 0.3s; }
    .modal-overlay.show { opacity: 1; visibility: visible; }
    .modal-container { background: var(--bg-white); border-radius: 12px; padding: 24px; width: 100%; max-width: 500px; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2); transform: scale(0.95); transition: transform 0.3s; }
    .modal-overlay.show .modal-container { transform: scale(1); }
    .modal-header { display: flex; justify-content: space-between; align-items: center; padding-bottom: 16px; margin-bottom: 20px; border-bottom: 1px solid var(--border-color); }
    .modal-header h3 { font-size: 20px; font-weight: 600; color: var(--text-dark); }
    .modal-close-btn { background: none; border: none; font-size: 24px; cursor: pointer; color: var(--text-light); }
    .modal-body { margin-bottom: 24px; }
    .form-group { margin-bottom: 16px; }
    .form-group label { display: block; font-size: 14px; font-weight: 500; margin-bottom: 8px; }
    .form-control { width: 100%; padding: 10px 14px; border-radius: 8px; border: 1px solid var(--border-color); font-size: 14px; }
    .form-control:focus { outline: none; border-color: var(--primary-blue); }
    textarea.form-control { resize: vertical; min-height: 80px; }
    .modal-footer { display: flex; justify-content: flex-end; gap: 12px; }
    .btn { padding: 10px 20px; border-radius: 8px; font-weight: 500; cursor: pointer; border: 1px solid transparent; }
    .btn-secondary { background-color: var(--bg-white); border-color: var(--border-color); color: var(--text-dark); }
    .btn-secondary:hover { background-color: var(--bg-light); }
    .btn-primary { background-color: var(--primary-blue); color: var(--bg-white); }
    .btn-primary:hover { background-color: #2563EB; }
    .error-message { color: var(--logout-red); font-size: 12px; margin-top: 4px; }
    #Logo { width: 150px; border-radius: 20px; }
    .icon, .icon-button, .action-btn, .avatar, .modal-close-btn { display: inline-flex; align-items: center; justify-content: center; }
    .icon, .icon-button ion-icon, .action-btn ion-icon, .avatar ion-icon { font-size: 20px; }
    .sidebar-nav li a .icon, .sidebar-footer li a .icon { font-size: 20px; width: 20px; height: 20px; margin-right: 12px; }
    .action-btn ion-icon { font-size: 18px; }
    .modal-close-btn { font-size: 28px; }
    .item-icon.small { width: 20px; height: 20px; }
    .sidebar-nav li a ion-icon, .sidebar-footer li a ion-icon { font-size: 20px; margin-right: 12px; }

    /* === NOVOS ESTILOS PARA ABAS === */
    .tabs { display: flex; border-bottom: 1px solid var(--border-color); margin-bottom: 24px; }
    .tab-link { padding: 10px 20px; cursor: pointer; font-size: 16px; font-weight: 500; color: var(--text-light); border-bottom: 2px solid transparent; margin-bottom: -1px; }
    .tab-link.active { color: var(--primary-blue); border-bottom-color: var(--primary-blue); }
    .tab-content { display: none; }
    .tab-content.active { display: block; }
    .filter-container { display: flex; gap: 1rem; }
</style>

<body>
    <div class="dashboard-container">
        <!-- BARRA LATERAL (Sem alterações) -->
        <aside class="sidebar">
            <div class="sidebar-header">
                 <img id="Logo" src="{{ asset('img/logoPerfil.jpeg') }}" alt="Logo do Perfil">
            </div>
            <nav class="sidebar-nav">
                <span class="menu-title">Menu</span>
                <ul>
                    <li><a href="/dashboard/index"><ion-icon name="grid-outline"></ion-icon> Dashboard</a></li>
                    <li><a href="/dashboard/usuarios"><ion-icon name="people-outline"></ion-icon> Usuários</a></li>
                    <li class="active"><a href="#"><ion-icon name="football-outline"></ion-icon> Esportes</a></li>
                    <li><a href="/dashboard/oportunidades"><ion-icon name="rocket-outline"></ion-icon> Oportunidades</a></li>
                    <li><a href=""><ion-icon name="list-outline"></ion-icon> Listas</a></li>
                    <li><a href="#"><ion-icon name="alert-circle-outline"></ion-icon> Denúncias</a></li>
                    <li><a href="#"><ion-icon name="document-text-outline"></ion-icon> Conteúdo</a></li>
                    <li><a href="#"><ion-icon name="stats-chart-outline"></ion-icon> Estatísticas</a></li>
                </ul>
            </nav>
            <div class="sidebar-footer">
                <ul>
                    <li><a href="#"><ion-icon name="settings-outline"></ion-icon> Configurações</a></li>
                    <li><a href="#" class="logout"><ion-icon name="log-out-outline"></ion-icon> Sair</a></li>
                </ul>
            </div>
        </aside>

        <!-- CONTEÚDO PRINCIPAL -->
        <main class="main-content">
            <header class="main-header">
                <h2 class="page-title">Gestão de Esportes</h2>
                <div class="user-menu">
                    <button class="icon-button"><ion-icon name="notifications-outline"></ion-icon></button>
                    <div class="user-profile">
                        <div class="avatar"><ion-icon name="person-outline"></ion-icon></div>
                        <span>Admin</span>
                    </div>
                </div>
            </header>

            <div class="content-body">
                <!-- ABAS -->
                <div class="tabs">
                    <a class="tab-link active" data-tab="esportes">Esportes</a>
                    <a class="tab-link" data-tab="posicoes">Posições</a>
                </div>

                <!-- CONTEÚDO DA ABA ESPORTES -->
                <div id="tab-esportes" class="tab-content active">
                    <div class="toolbar">
                        <div class="search-bar">
                            <input type="text" id="esporteSearchInput" placeholder="Pesquisar esportes...">
                        </div>
                        <button class="add-button" id="addEsporteBtn">Adicionar Esporte</button>
                    </div>
                    <div class="table-container">
                        <table>
                            <thead>
                                <tr>
                                    <th>Nome</th>
                                    <th>Descrição</th>
                                    <th>Data de Cadastro</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody id="esportesTableBody"></tbody>
                        </table>
                    </div>
                </div>

                <!-- CONTEÚDO DA ABA POSIÇÕES -->
                <div id="tab-posicoes" class="tab-content">
                    <div class="toolbar">
                         <div class="filter-container">
                            <select id="posicaoFilterEsporte" class="form-control">
                                <option value="">Filtrar por esporte</option>
                            </select>
                        </div>
                        <div class="search-bar">
                            <input type="text" id="posicaoSearchInput" placeholder="Pesquisar posições...">
                        </div>
                        <button class="add-button" id="addPosicaoBtn">Adicionar Posição</button>
                    </div>
                    <div class="table-container">
                        <table>
                            <thead>
                                <tr>
                                    <th>Posição</th>
                                    <th>Esporte</th>
                                    <th>Data de Cadastro</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody id="posicoesTableBody"></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- MODAL PARA ESPORTES -->
    <div id="esporteModal" class="modal-overlay">
        <div class="modal-container">
            <div class="modal-header">
                <h3 id="esporteModalTitle">Adicionar Novo Esporte</h3>
                <button class="modal-close-btn" data-modal-id="esporteModal">&times;</button>
            </div>
            <form id="esporteForm">
                <input type="hidden" id="esporteId" name="id">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="nomeEsporte">Nome do Esporte</label>
                        <input type="text" id="nomeEsporte" name="nomeEsporte" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="descricaoEsporte">Descrição</label>
                        <textarea id="descricaoEsporte" name="descricaoEsporte" class="form-control" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-modal-id="esporteModal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Salvar</button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL PARA POSIÇÕES -->
    <div id="posicaoModal" class="modal-overlay">
        <div class="modal-container">
            <div class="modal-header">
                <h3 id="posicaoModalTitle">Adicionar Nova Posição</h3>
                <button class="modal-close-btn" data-modal-id="posicaoModal">&times;</button>
            </div>
            <form id="posicaoForm">
                <input type="hidden" id="posicaoId" name="id">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="idEsporte">Esporte</label>
                        <select id="idEsporte" name="idEsporte" class="form-control" required>
                            <option value="">Selecione um esporte</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="nomePosicao">Nome da Posição</label>
                        <input type="text" id="nomePosicao" name="nomePosicao" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-modal-id="posicaoModal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Salvar</button>
                </div>
            </form>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
    // --- CONFIGURAÇÃO GERAL ---
    // CORREÇÃO 1: Buscar dinamicamente o token do localStorage.
    // Garanta que, após o login do admin, você salve o token assim:
    // localStorage.setItem('admin_auth_token', 'seu_token_recebido_da_api');
    const API_TOKEN = localStorage.getItem('admin_auth_token');

    // Se não houver token, impede a execução e avisa o usuário.
    if (!API_TOKEN) {
        console.error("Token de autenticação de administrador não encontrado. Faça o login primeiro.");
        document.querySelector('.content-body').innerHTML = '<h1>Erro de Autenticação</h1><p>Token de administrador não encontrado. Por favor, <a href="/login/admin">faça o login</a> novamente.</p>';
        return; // Interrompe a execução do script
    }

    const headers = {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
        'Authorization': `Bearer ${API_TOKEN}`
    };

    // --- ELEMENTOS DO DOM ---
    const tabLinks = document.querySelectorAll('.tab-link');
    const tabContents = document.querySelectorAll('.tab-content');
    const esporteForm = document.getElementById('esporteForm');
    const esportesTableBody = document.getElementById('esportesTableBody');
    const esporteSearchInput = document.getElementById('esporteSearchInput');
    const posicaoForm = document.getElementById('posicaoForm');
    const posicoesTableBody = document.getElementById('posicoesTableBody');
    const posicaoSearchInput = document.getElementById('posicaoSearchInput');
    const posicaoFilterEsporte = document.getElementById('posicaoFilterEsporte');
    const idEsporteSelect = document.getElementById('idEsporte');

    // --- FUNÇÕES AUXILIARES ---
    const formatDate = (dateString) => dateString ? new Date(dateString).toLocaleDateString('pt-BR') : 'N/A';
    const openModal = (modalId) => document.getElementById(modalId).classList.add('show');
    const closeModal = (modalId) => document.getElementById(modalId).classList.remove('show');
    
    let debounceTimer;
    const debounce = (func, delay) => {
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(func, delay);
    };

    // --- LÓGICA DE ABAS ---
    tabLinks.forEach(link => {
        link.addEventListener('click', () => {
            const tabId = link.getAttribute('data-tab');
            tabLinks.forEach(l => l.classList.remove('active'));
            tabContents.forEach(c => c.classList.remove('active'));
            link.classList.add('active');
            document.getElementById(`tab-${tabId}`).classList.add('active');
        });
    });

    // --- LÓGICA DE ESPORTES ---
    async function fetchEsportes(searchTerm = '') {
        try {
            const response = await fetch(`/api/admin/esporte`, { headers });
            if (response.status === 401) throw new Error('Não autorizado. Verifique o token.');
            if (!response.ok) throw new Error(`Erro HTTP: ${response.status}`);
            
            let esportes = await response.json();

            if (searchTerm) {
                esportes = esportes.filter(e => e.nomeEsporte.toLowerCase().includes(searchTerm.toLowerCase()));
            }

            renderEsportes(esportes);
            populateEsporteSelects(esportes);
        } catch (error) {
            console.error('Erro ao buscar esportes:', error);
            esportesTableBody.innerHTML = `<tr><td colspan="4">Erro ao carregar dados. ${error.message}</td></tr>`;
        }
    }

    function renderEsportes(esportes) {
        esportesTableBody.innerHTML = '';
        if (!esportes || esportes.length === 0) {
            esportesTableBody.innerHTML = `<tr><td colspan="4">Nenhum esporte encontrado.</td></tr>`;
            return;
        }
        esportes.forEach(esporte => {
            const row = document.createElement('tr');
            row.dataset.esporteData = JSON.stringify(esporte); // Armazena todos os dados na linha
            row.innerHTML = `
                <td>${esporte.nomeEsporte}</td>
                <td>${esporte.descricaoEsporte || 'N/A'}</td>
                <td>${formatDate(esporte.created_at)}</td>
                <td>
                    <div class="action-buttons">
                        <button class="action-btn edit" data-id="${esporte.id}" data-type="esporte"><ion-icon name="pencil-outline"></ion-icon></button>
                        <button class="action-btn delete" data-id="${esporte.id}" data-type="esporte"><ion-icon name="trash-outline"></ion-icon></button>
                    </div>
                </td>
            `;
            esportesTableBody.appendChild(row);
        });
    }

    function populateEsporteSelects(esportes) {
        const currentFilter = posicaoFilterEsporte.value;
        const currentSelect = idEsporteSelect.value;
        posicaoFilterEsporte.innerHTML = '<option value="">Filtrar por esporte</option>';
        idEsporteSelect.innerHTML = '<option value="">Selecione um esporte</option>';
        esportes.forEach(esporte => {
            posicaoFilterEsporte.innerHTML += `<option value="${esporte.id}">${esporte.nomeEsporte}</option>`;
            idEsporteSelect.innerHTML += `<option value="${esporte.id}">${esporte.nomeEsporte}</option>`;
        });
        posicaoFilterEsporte.value = currentFilter;
        idEsporteSelect.value = currentSelect;
    }

    esporteForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        const id = document.getElementById('esporteId').value;
        const isEdit = !!id;
        const url = isEdit ? `/api/admin/esporte/${id}` : '/api/admin/esporte';
        const method = isEdit ? 'PUT' : 'POST';
        const body = JSON.stringify({
            nomeEsporte: document.getElementById('nomeEsporte').value,
            descricaoEsporte: document.getElementById('descricaoEsporte').value,
        });
        try {
            const response = await fetch(url, { method, headers, body });
            if (!response.ok) {
                 const errorData = await response.json();
                 throw new Error(errorData.message || 'Falha ao salvar esporte');
            }
            closeModal('esporteModal');
            await fetchEsportes();
            await fetchPosicoes(posicaoFilterEsporte.value, posicaoSearchInput.value);
        } catch (error) {
            console.error('Erro ao salvar esporte:', error);
            alert(`Não foi possível salvar o esporte: ${error.message}`);
        }
    });

    // --- LÓGICA DE POSIÇÕES ---
    async function fetchPosicoes(esporteId = '', searchTerm = '') {
        try {
            const params = new URLSearchParams({ idEsporte: esporteId });
            const response = await fetch(`/api/admin/posicao?${params}`, { headers });
            if (response.status === 401) throw new Error('Não autorizado. Verifique o token.');
            if (!response.ok) throw new Error(`Erro HTTP: ${response.status}`);
            
            let posicoes = await response.json();

            if (searchTerm) {
                posicoes = posicoes.filter(p => p.nomePosicao.toLowerCase().includes(searchTerm.toLowerCase()));
            }
            renderPosicoes(posicoes);
        } catch (error) {
            console.error('Erro ao buscar posições:', error);
            posicoesTableBody.innerHTML = `<tr><td colspan="4">Erro ao carregar dados. ${error.message}</td></tr>`;
        }
    }

    function renderPosicoes(posicoes) {
        posicoesTableBody.innerHTML = '';
        if (!posicoes || posicoes.length === 0) {
            posicoesTableBody.innerHTML = `<tr><td colspan="4">Nenhuma posição encontrada.</td></tr>`;
            return;
        }
        posicoes.forEach(posicao => {
            const row = document.createElement('tr');
            row.dataset.posicaoData = JSON.stringify(posicao); // Armazena todos os dados na linha
            row.innerHTML = `
                <td>${posicao.nomePosicao}</td>
                <td>${posicao.esporte ? posicao.esporte.nomeEsporte : 'N/A'}</td>
                <td>${formatDate(posicao.created_at)}</td>
                <td>
                    <div class="action-buttons">
                        <button class="action-btn edit" data-id="${posicao.id}" data-type="posicao"><ion-icon name="pencil-outline"></ion-icon></button>
                        <button class="action-btn delete" data-id="${posicao.id}" data-type="posicao"><ion-icon name="trash-outline"></ion-icon></button>
                    </div>
                </td>
            `;
            posicoesTableBody.appendChild(row);
        });
    }

    posicaoForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        const id = document.getElementById('posicaoId').value;
        const isEdit = !!id;
        const url = isEdit ? `/api/admin/posicao/${id}` : '/api/admin/posicao';
        const method = isEdit ? 'PUT' : 'POST';
        const body = JSON.stringify({
            nomePosicao: document.getElementById('nomePosicao').value,
            idEsporte: document.getElementById('idEsporte').value,
        });
        try {
            const response = await fetch(url, { method, headers, body });
            if (!response.ok) {
                const errorData = await response.json();
                throw new Error(errorData.message || 'Falha ao salvar posição');
            }
            closeModal('posicaoModal');
            fetchPosicoes(posicaoFilterEsporte.value, posicaoSearchInput.value);
        } catch (error) {
            console.error('Erro ao salvar posição:', error);
            alert(`Não foi possível salvar a posição: ${error.message}`);
        }
    });

    // --- EVENT LISTENERS GERAIS ---
    document.getElementById('addEsporteBtn').addEventListener('click', () => {
        esporteForm.reset();
        document.getElementById('esporteId').value = '';
        document.getElementById('esporteModalTitle').textContent = 'Adicionar Novo Esporte';
        openModal('esporteModal');
    });

    document.getElementById('addPosicaoBtn').addEventListener('click', () => {
        posicaoForm.reset();
        document.getElementById('posicaoId').value = '';
        document.getElementById('posicaoModalTitle').textContent = 'Adicionar Nova Posição';
        openModal('posicaoModal');
    });

    document.querySelectorAll('.modal-close-btn, .btn-secondary[data-modal-id]').forEach(btn => {
        btn.addEventListener('click', () => closeModal(btn.dataset.modalId));
    });

    document.querySelector('.content-body').addEventListener('click', async (e) => {
        const target = e.target.closest('.action-btn');
        if (!target) return;

        const id = target.dataset.id;
        const type = target.dataset.type;
        const row = target.closest('tr');

        if (target.classList.contains('edit')) {
            if (type === 'esporte' && row.dataset.esporteData) {
                const data = JSON.parse(row.dataset.esporteData);
                document.getElementById('esporteId').value = data.id;
                document.getElementById('nomeEsporte').value = data.nomeEsporte;
                document.getElementById('descricaoEsporte').value = data.descricaoEsporte || '';
                document.getElementById('esporteModalTitle').textContent = 'Editar Esporte';
                openModal('esporteModal');
            } else if (type === 'posicao' && row.dataset.posicaoData) {
                const data = JSON.parse(row.dataset.posicaoData);
                document.getElementById('posicaoId').value = data.id;
                document.getElementById('nomePosicao').value = data.nomePosicao;
                document.getElementById('idEsporte').value = data.idEsporte;
                document.getElementById('posicaoModalTitle').textContent = 'Editar Posição';
                openModal('posicaoModal');
            }
        }

        if (target.classList.contains('delete')) {
            const itemDescription = type === 'esporte' ? 'este esporte' : 'esta posição';
            if (confirm(`Tem certeza que deseja excluir ${itemDescription}?`)) {
                const url = `/api/admin/${type}/${id}`;
                try {
                    const response = await fetch(url, { method: 'DELETE', headers });
                    if (!response.ok) {
                        const errorData = await response.json();
                        throw new Error(errorData.message || 'Falha ao excluir');
                    }
                    if (type === 'esporte') {
                        await fetchEsportes();
                        await fetchPosicoes();
                    } else {
                        fetchPosicoes(posicaoFilterEsporte.value, posicaoSearchInput.value);
                    }
                } catch (error) {
                    console.error(`Erro ao deletar ${type}:`, error);
                    alert(`Não foi possível excluir: ${error.message}`);
                }
            }
        }
    });

    // Listeners de busca e filtro
    esporteSearchInput.addEventListener('keyup', () => debounce(() => fetchEsportes(esporteSearchInput.value), 300));
    posicaoSearchInput.addEventListener('keyup', () => debounce(() => fetchPosicoes(posicaoFilterEsporte.value, posicaoSearchInput.value), 300));
    posicaoFilterEsporte.addEventListener('change', () => fetchPosicoes(posicaoFilterEsporte.value, posicaoSearchInput.value));

    // --- CARGA INICIAL ---
    async function initialize() {
        await fetchEsportes();
        await fetchPosicoes();
    }

    initialize();
});

    </script>
</body>
</html>
