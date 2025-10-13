<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Gerenciar Oportunidades</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

    <style>
        /* CSS COMPLETO E UNIFICADO */
        :root {
            --primary-blue: #3B82F6;
            --text-dark: #1F2937;
            --text-light: #6B7280;
            --bg-light: #F9FAFB;
            --bg-white: #FFFFFF;
            --border-color: #E5E7EB;
            --logout-red: #EF4444;
            --action-view: #3B82F6;
            --action-edit: #8B5CF6;
            --action-delete: #EF4444;
            --green-text: #16A34A;
            --green-bg: #DCFCE7;
            --sidebar-width-expanded: 250px;
            --sidebar-width-collapsed: 80px;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-light);
            color: var(--text-dark);
        }

        .dashboard-container { display: flex; min-height: 100vh; }

        .main-content {
            margin-left: var(--sidebar-width-collapsed);
            flex-grow: 1;
            padding: 24px 32px;
            transition: margin-left 0.3s ease;
        }

        body.sidebar-expanded .main-content {
            margin-left: var(--sidebar-width-expanded);
        }

        .sidebar {
            width: var(--sidebar-width-collapsed);
            background-color: var(--bg-white);
            border-right: 1px solid var(--border-color);
            display: flex;
            flex-direction: column;
            padding: 24px 12px;
            position: fixed;
            height: 100%;
            left: 0;
            top: 0;
            transition: width 0.3s ease;
            overflow-x: hidden;
        }

        .sidebar:hover {
            width: var(--sidebar-width-expanded);
        }

        .sidebar-header {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 50px;
            margin-bottom: 24px;
            padding: 0 12px;
        }

        .sidebar:hover .sidebar-header {
            justify-content: flex-start;
        }

        #logo-expanded {
            display: none;
            width: 150px;
            border-radius: 20px;
        }
        #logo-collapsed {
            display: block;
            font-size: 28px;
            color: var(--primary-blue);
        }

        .sidebar:hover #logo-expanded { display: block; }
        .sidebar:hover #logo-collapsed { display: none; }

        .sidebar-nav { flex-grow: 1; }

        .menu-title, .nav-text, .chevron {
            opacity: 0;
            visibility: hidden;
            white-space: nowrap;
            transition: opacity 0.2s ease;
            display: none;
        }

        .sidebar:hover .menu-title,
        .sidebar:hover .nav-text,
        .sidebar:hover .chevron {
            opacity: 1;
            visibility: visible;
            display: inline;
            transition-delay: 0.1s;
        }

        .sidebar-nav ul, .sidebar-footer ul { list-style: none; padding: 0; }

        .sidebar-nav li a, .sidebar-footer li a {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 10px 12px;
            margin-bottom: 4px;
            border-radius: 6px;
            text-decoration: none;
            color: var(--text-light);
            transition: background-color 0.2s;
        }

        .sidebar:hover .sidebar-nav li a,
        .sidebar:hover .sidebar-footer li a {
            justify-content: flex-start;
        }

        .sidebar-nav li a:hover { background-color: var(--bg-light); color: var(--text-dark); }
        .sidebar-nav li.active a { background-color: var(--primary-blue); color: var(--bg-white); }

        .sidebar-nav li a ion-icon, .sidebar-footer li a ion-icon {
            font-size: 22px;
            min-width: 32px;
            text-align: center;
            transition: margin-right 0.3s ease;
        }

        .sidebar:hover .sidebar-nav li a ion-icon,
        .sidebar:hover .sidebar-footer li a ion-icon {
            margin-right: 12px;
        }

        .sidebar-footer { padding-top: 16px; border-top: 1px solid var(--border-color); }
        .sidebar-footer li a.logout { color: var(--logout-red); }

        .main-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; }
        .page-title { font-size: 28px; font-weight: 700; }
        .user-menu { display: flex; align-items: center; gap: 16px; }
        .icon-button { background: none; border: none; cursor: pointer; color: var(--text-light); padding: 4px; font-size: 24px; }
        .user-profile { display: flex; align-items: center; gap: 12px; background-color: var(--bg-white); padding: 6px 12px 6px 6px; border-radius: 999px; border: 1px solid var(--border-color); font-weight: 500; }
        .user-profile .avatar { width: 32px; height: 32px; border-radius: 50%; background-color: var(--primary-blue-light); color: var(--primary-blue); display: flex; align-items: center; justify-content: center; font-size: 20px; }
        .content-body { background-color: var(--bg-white); border-radius: 12px; padding: 24px; border: 1px solid var(--border-color); }
        .toolbar { display: flex; align-items: center; gap: 16px; margin-bottom: 24px; }
        .search-bar { flex-grow: 1; position: relative; }
        .search-bar ion-icon { position: absolute; left: 14px; top: 50%; transform: translateY(-50%); width: 20px; height: 20px; color: var(--text-light); }
        .search-bar input { width: 100%; padding: 10px 16px 10px 44px; border-radius: 8px; border: 1px solid var(--border-color); background-color: var(--bg-light); font-size: 14px; }
        .filter-button, .add-button { padding: 10px 16px; border-radius: 8px; border: 1px solid var(--border-color); background-color: var(--bg-white); font-size: 14px; font-weight: 500; cursor: pointer; display: flex; align-items: center; gap: 8px; }
        .add-button { background-color: var(--text-dark); color: var(--bg-white); }
        .table-container { width: 100%; overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; text-align: left; }
        th, td { padding: 12px 16px; vertical-align: middle; white-space: nowrap; }
        thead { border-bottom: 1px solid var(--border-color); }
        th { font-size: 12px; font-weight: 600; color: var(--text-light); text-transform: uppercase; }
        tbody tr { border-bottom: 1px solid var(--border-color); }
        tbody tr:last-child { border-bottom: none; }
        td { font-size: 14px; color: var(--text-dark); }
        .action-buttons { display: flex; gap: 8px; }
        .action-btn { width: 32px; height: 32px; border-radius: 6px; border: 1px solid var(--border-color); background-color: var(--bg-white); color: var(--text-light); display: flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.2s; }
        .action-btn:hover { color: white; }
        .action-btn.view:hover { background-color: var(--action-view); }
        .action-btn.edit:hover { background-color: var(--action-edit); }
        .action-btn.delete:hover { background-color: var(--action-delete); }
        .tag { padding: 4px 10px; border-radius: 999px; font-size: 12px; font-weight: 500; }
        .tag-status-ativo { background-color: var(--green-bg); color: var(--green-text); }
        .club-cell { display: flex; align-items: center; gap: 12px; }
        .club-avatar { width: 32px; height: 32px; border-radius: 50%; background-color: var(--primary-blue-light); color: var(--primary-blue); display: flex; align-items: center; justify-content: center; font-size: 20px; }

        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            align-items: center;
            justify-content: center;
        }

        .modal.active {
            display: flex;
        }

        .modal-content {
            background-color: var(--bg-white);
            padding: 32px;
            border-radius: 12px;
            max-width: 600px;
            width: 90%;
            max-height: 90vh;
            overflow-y: auto;
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
        }

        .modal-title {
            font-size: 24px;
            font-weight: 700;
        }

        .close-modal {
            background: none;
            border: none;
            font-size: 28px;
            cursor: pointer;
            color: var(--text-light);
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: var(--text-dark);
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            font-size: 14px;
            font-family: 'Inter', sans-serif;
        }

        .form-group textarea {
            resize: vertical;
            min-height: 100px;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }

        .submit-button {
            width: 100%;
            padding: 12px;
            background-color: var(--primary-blue);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: opacity 0.2s;
        }

        .submit-button:hover {
            opacity: 0.9;
        }

        .submit-button:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .error-message {
            color: var(--logout-red);
            font-size: 12px;
            margin-top: 4px;
        }

        .success-message {
            color: var(--green-text);
            background-color: var(--green-bg);
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 16px;
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="sidebar-header">
                <img id="logo-expanded" src="{{ asset('img/logoPerfil.jpeg') }}" alt="Logo Completa">
                <ion-icon id="logo-collapsed" name="football-outline"></ion-icon>
            </div>
            <nav class="sidebar-nav">
                <ul>
                    <li><a href="dashAdm"><ion-icon name="grid-outline"></ion-icon> <span class="nav-text">Dashboard</span></a></li>
                    <li><a href="usuarios"><ion-icon name="people-outline"></ion-icon> <span class="nav-text">Usuários</span></a></li>
                    <li><a href="esporte"><ion-icon name="football-outline"></ion-icon> <span class="nav-text">Esportes</span></a></li>
                    <li class="active"><a href="#"><ion-icon name="briefcase-outline"></ion-icon> <span class="nav-text">Oportunidades</span></a></li>
                    <li><a href="#"><ion-icon name="list-outline"></ion-icon> <span class="nav-text">Listas</span></a></li>
                    <li><a href="#"><ion-icon name="alert-circle-outline"></ion-icon> <span class="nav-text">Denúncias</span></a></li>
                    <li><a href="#"><ion-icon name="document-text-outline"></ion-icon> <span class="nav-text">Conteúdo</span></a></li>
                    <li><a href="#"><ion-icon name="stats-chart-outline"></ion-icon> <span class="nav-text">Estatísticas</span></a></li>
                </ul>
            </nav>
            <div class="sidebar-footer">
                <ul>
                    <li><a href="#"><ion-icon name="settings-outline"></ion-icon> <span class="nav-text">Configurações</span></a></li>
                    <li><a href="#" class="logout"><ion-icon name="log-out-outline"></ion-icon> <span class="nav-text">Sair</span></a></li>
                </ul>
            </div>
        </aside>

        <!-- Conteúdo Principal -->
        <main class="main-content">
            <header class="main-header">
                <h2 class="page-title">Gerenciar Oportunidades</h2>
                <div class="user-menu">
                    <button class="icon-button"><ion-icon name="notifications-outline"></ion-icon></button>
                    <div class="user-profile">
                        <div class="avatar"><ion-icon name="person-outline"></ion-icon></div>
                        <span>Clube</span>
                    </div>
                </div>
            </header>

            <div class="content-body">
                <div class="toolbar">
                    <div class="search-bar">
                        <ion-icon name="search-outline"></ion-icon>
                        <input type="text" id="searchInput" placeholder="Pesquisar por descrição...">
                    </div>
                    <button class="filter-button">
                        <ion-icon name="filter-outline"></ion-icon>
                        Ordenar por
                    </button>
                    <button class="add-button" id="openModalBtn">Adicionar Oportunidade</button>
                </div>

                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>Esporte</th>
                                <th>Posição</th>
                                <th>Descrição</th>
                                <th>Idade</th>
                                <th>Localização</th>
                                <th>Data de Criação</th>
                                <th>Ações Rápidas</th>
                            </tr>
                        </thead>
                        <tbody id="opportunitiesTableBody">
                            <!-- Linhas da tabela serão inseridas aqui pelo JavaScript -->
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>

    <!-- Modal de Cadastro/Edição -->
    <div id="opportunityModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="modalTitle">Nova Oportunidade</h3>
                <button class="close-modal" id="closeModalBtn">&times;</button>
            </div>

            <div id="successMessage" class="success-message" style="display: none;"></div>

            <form id="opportunityForm">
                <div class="form-group">
                    <label for="esporte_id">Esporte *</label>
                    <select id="esporte_id" name="esporte_id" required>
                        <option value="">Selecione um esporte</option>
                    </select>
                    <div class="error-message" id="error_esporte_id"></div>
                </div>

                <div class="form-group">
                    <label for="posicoes_id">Posição *</label>
                    <select id="posicoes_id" name="posicoes_id" required disabled>
                        <option value="">Selecione primeiro um esporte</option>
                    </select>
                    <div class="error-message" id="error_posicoes_id"></div>
                </div>

                <div class="form-group">
                    <label for="descricaoOportunidades">Descrição *</label>
                    <textarea id="descricaoOportunidades" name="descricaoOportunidades" required placeholder="Descreva a oportunidade..."></textarea>
                    <div class="error-message" id="error_descricaoOportunidades"></div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="idadeMinima">Idade Mínima</label>
                        <input type="number" id="idadeMinima" name="idadeMinima" min="0" max="120" placeholder="Ex: 16">
                        <div class="error-message" id="error_idadeMinima"></div>
                    </div>

                    <div class="form-group">
                        <label for="idadeMaxima">Idade Máxima</label>
                        <input type="number" id="idadeMaxima" name="idadeMaxima" min="0" max="120" placeholder="Ex: 25">
                        <div class="error-message" id="error_idadeMaxima"></div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="estadoOportunidade">Estado</label>
                        <input type="text" id="estadoOportunidade" name="estadoOportunidade" maxlength="2" placeholder="Ex: SP">
                        <div class="error-message" id="error_estadoOportunidade"></div>
                    </div>

                    <div class="form-group">
                        <label for="cidadeOportunidade">Cidade</label>
                        <input type="text" id="cidadeOportunidade" name="cidadeOportunidade" maxlength="100" placeholder="Ex: São Paulo">
                        <div class="error-message" id="error_cidadeOportunidade"></div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="enderecoOportunidade">Endereço</label>
                    <input type="text" id="enderecoOportunidade" name="enderecoOportunidade" maxlength="255" placeholder="Rua, número, bairro">
                    <div class="error-message" id="error_enderecoOportunidade"></div>
                </div>

                <div class="form-group">
                    <label for="cepOportunidade">CEP</label>
                    <input type="text" id="cepOportunidade" name="cepOportunidade" maxlength="9" placeholder="00000-000">
                    <div class="error-message" id="error_cepOportunidade"></div>
                </div>

                <button type="submit" class="submit-button" id="submitBtn">Cadastrar Oportunidade</button>
            </form>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // --- LÓGICA DA SIDEBAR EXPANSÍVEL ---
        const sidebar = document.querySelector('.sidebar');
        const body = document.body;
        sidebar.addEventListener('mouseenter', () => body.classList.add('sidebar-expanded'));
        sidebar.addEventListener('mouseleave', () => body.classList.remove('sidebar-expanded'));

        // --- VARIÁVEIS GLOBAIS ---
        const tableBody = document.getElementById('opportunitiesTableBody');
        const modal = document.getElementById('opportunityModal');
        const openModalBtn = document.getElementById('openModalBtn');
        const closeModalBtn = document.getElementById('closeModalBtn');
        const opportunityForm = document.getElementById('opportunityForm');
        const esporteSelect = document.getElementById('esporte_id');
        const posicaoSelect = document.getElementById('posicoes_id');
        const successMessage = document.getElementById('successMessage');

        // Usar o token do clube (prefixo clube)
        const API_TOKEN = localStorage.getItem('token');

        if (!API_TOKEN) {
            alert('Erro de Autenticação. Faça o login como clube.');
            return;
        }

        const authHeaders = {
            'Authorization': `Bearer ${API_TOKEN}`,
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        };

        // --- FUNÇÕES AUXILIARES ---
        const formatDate = (dateString) => {
            if (!dateString) return 'N/A';
            return new Date(dateString).toLocaleDateString('pt-BR', {
                day: '2-digit', month: 'long', year: 'numeric'
            });
        };

        const showSuccess = (message) => {
            successMessage.textContent = message;
            successMessage.style.display = 'block';
            setTimeout(() => {
                successMessage.style.display = 'none';
            }, 5000);
        };

        const clearErrors = () => {
            document.querySelectorAll('.error-message').forEach(el => el.textContent = '');
        };

        const showErrors = (errors) => {
            clearErrors();
            for (const [field, messages] of Object.entries(errors)) {
                const errorEl = document.getElementById(`error_${field}`);
                if (errorEl) {
                    errorEl.textContent = messages.join(', ');
                }
            }
        };

        // --- MODAL ---
        openModalBtn.addEventListener('click', () => {
            modal.classList.add('active');
            opportunityForm.reset();
            clearErrors();
            successMessage.style.display = 'none';
            posicaoSelect.disabled = true;
            posicaoSelect.innerHTML = '<option value="">Selecione primeiro um esporte</option>';
        });

        closeModalBtn.addEventListener('click', () => {
            modal.classList.add('active');
        });

        modal.addEventListener('click', (e) => {
            if (e.target === modal) {
                modal.classList.remove('active');
            }
        });

        // --- CARREGAR ESPORTES ---
        async function loadEsportes() {
            try {
                const response = await fetch('/api/clube/esporte', { headers: authHeaders });
                if (!response.ok) throw new Error('Falha ao buscar esportes.');
                
                const esportes = await response.json();
                
                esporteSelect.innerHTML = '<option value="">Selecione um esporte</option>';
                esportes.forEach(esporte => {
                    const option = document.createElement('option');
                    option.value = esporte.id;
                    option.textContent = esporte.nomeEsporte;
                    esporteSelect.appendChild(option);
                });
            } catch (error) {
                console.error('Erro ao carregar esportes:', error);
                alert('Erro ao carregar esportes. Verifique sua conexão.');
            }
        }

        // --- CARREGAR POSIÇÕES BASEADO NO ESPORTE ---
        esporteSelect.addEventListener('change', async function() {
            const esporteId = this.value;
            
            if (!esporteId) {
                posicaoSelect.disabled = true;
                posicaoSelect.innerHTML = '<option value="">Selecione primeiro um esporte</option>';
                return;
            }

            try {
                const response = await fetch(`/api/clube/posicao?idEsporte=${esporteId}`, { headers: authHeaders });
                if (!response.ok) throw new Error('Falha ao buscar posições.');
                
                const posicoes = await response.json();
                
                posicaoSelect.innerHTML = '<option value="">Selecione uma posição</option>';
                posicoes.forEach(posicao => {
                    const option = document.createElement('option');
                    option.value = posicao.id;
                    option.textContent = posicao.nomePosicao;
                    posicaoSelect.appendChild(option);
                });
                
                posicaoSelect.disabled = false;
            } catch (error) {
                console.error('Erro ao carregar posições:', error);
                alert('Erro ao carregar posições. Verifique sua conexão.');
            }
        });

        // --- CADASTRAR OPORTUNIDADE ---
        opportunityForm.addEventListener('submit', async function(e) {
            e.preventDefault();
            clearErrors();

            const formData = {
                descricaoOportunidades: document.getElementById('descricaoOportunidades').value,
                datapostagemOportunidades: new Date().toISOString().split('T')[0],
                esporte_id: parseInt(document.getElementById('esporte_id').value),
                posicoes_id: parseInt(document.getElementById('posicoes_id').value),
                idadeMinima: document.getElementById('idadeMinima').value ? parseInt(document.getElementById('idadeMinima').value) : null,
                idadeMaxima: document.getElementById('idadeMaxima').value ? parseInt(document.getElementById('idadeMaxima').value) : null,
                estadoOportunidade: document.getElementById('estadoOportunidade').value || null,
                cidadeOportunidade: document.getElementById('cidadeOportunidade').value || null,
                enderecoOportunidade: document.getElementById('enderecoOportunidade').value || null,
                cepOportunidade: document.getElementById('cepOportunidade').value || null,
            };

            const submitBtn = document.getElementById('submitBtn');
            submitBtn.disabled = true;
            submitBtn.textContent = 'Cadastrando...';

            try {
                const response = await fetch('/api/clube/oportunidade', {
                    method: 'POST',
                    headers: authHeaders,
                    body: JSON.stringify(formData)
                });

                const data = await response.json();

                if (!response.ok) {
                    if (data.errors) {
                        showErrors(data.errors);
                    } else {
                        alert(data.message || 'Erro ao cadastrar oportunidade.');
                    }
                    return;
                }

                showSuccess('Oportunidade cadastrada com sucesso!');
                opportunityForm.reset();
                posicaoSelect.disabled = true;
                posicaoSelect.innerHTML = '<option value="">Selecione primeiro um esporte</option>';
                
                // Recarregar a lista de oportunidades
                fetchOpportunities();

                // Fechar modal após 2 segundos
                setTimeout(() => {
                    modal.classList.remove('active');
                }, 2000);

            } catch (error) {
                console.error('Erro ao cadastrar oportunidade:', error);
                alert('Erro ao cadastrar oportunidade. Verifique sua conexão.');
            } finally {
                submitBtn.disabled = false;
                submitBtn.textContent = 'Cadastrar Oportunidade';
            }
        });

        // --- BUSCAR E RENDERIZAR OPORTUNIDADES ---
        async function fetchOpportunities() {
            tableBody.innerHTML = '<tr><td colspan="7">Carregando...</td></tr>';
            try {
                const response = await fetch('/api/clube/oportunidades', { headers: authHeaders });
                if (!response.ok) throw new Error('Falha ao buscar oportunidades.');
                
                const result = await response.json();
                const opportunities = result.data || result;

                if (opportunities.length === 0) {
                    tableBody.innerHTML = '<tr><td colspan="7">Nenhuma oportunidade encontrada.</td></tr>';
                    return;
                }

                renderTable(opportunities);

            } catch (error) {
                console.error('Erro ao carregar dados:', error);
                tableBody.innerHTML = `<tr><td colspan="7">Erro ao carregar: ${error.message}</td></tr>`;
            }
        }

        function renderTable(data) {
            tableBody.innerHTML = '';
            data.forEach(op => {
                const idadeRange = op.idadeMinima || op.idadeMaxima 
                    ? `${op.idadeMinima || '?'} - ${op.idadeMaxima || '?'} anos`
                    : 'Não especificado';
                
                const localizacao = op.cidadeOportunidade && op.estadoOportunidade
                    ? `${op.cidadeOportunidade}/${op.estadoOportunidade}`
                    : op.cidadeOportunidade || op.estadoOportunidade || 'Não especificado';

                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${op.esporte ? op.esporte.nomeEsporte : 'N/A'}</td>
                    <td>${op.posicao ? op.posicao.nomePosicao : 'N/A'}</td>
                    <td>${op.descricaoOportunidades}</td>
                    <td>${idadeRange}</td>
                    <td>${localizacao}</td>
                    <td>${formatDate(op.datapostagemOportunidades)}</td>
                    <td>
                        <div class="action-buttons">
                            <button class="action-btn view" title="Visualizar" onclick="viewOpportunity(${op.id})">
                                <ion-icon name="eye-outline"></ion-icon>
                            </button>
                            <button class="action-btn edit" title="Editar" onclick="editOpportunity(${op.id})">
                                <ion-icon name="pencil-outline"></ion-icon>
                            </button>
                            <button class="action-btn delete" title="Excluir" onclick="deleteOpportunity(${op.id})">
                                <ion-icon name="trash-outline"></ion-icon>
                            </button>
                        </div>
                    </td>
                `;
                tableBody.appendChild(row);
            });
        }

        // --- FUNÇÕES DE AÇÃO (VIEW, EDIT, DELETE) ---
        window.viewOpportunity = function(id) {
            alert(`Visualizar oportunidade ${id} - Funcionalidade a ser implementada`);
        };

        window.editOpportunity = function(id) {
            alert(`Editar oportunidade ${id} - Funcionalidade a ser implementada`);
        };

        window.deleteOpportunity = async function(id) {
            if (!confirm('Tem certeza que deseja excluir esta oportunidade?')) {
                return;
            }

            try {
                const response = await fetch(`/api/clube/oportunidade/${id}`, {
                    method: 'DELETE',
                    headers: authHeaders
                });

                if (!response.ok) {
                    const data = await response.json();
                    alert(data.message || 'Erro ao excluir oportunidade.');
                    return;
                }

                alert('Oportunidade excluída com sucesso!');
                fetchOpportunities();

            } catch (error) {
                console.error('Erro ao excluir oportunidade:', error);
                alert('Erro ao excluir oportunidade. Verifique sua conexão.');
            }
        };

        // --- INICIALIZAÇÃO ---
        loadEsportes();
        fetchOpportunities();
    });
    </script>
</body>
</html>

