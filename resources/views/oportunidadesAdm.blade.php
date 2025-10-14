<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Lista de Oportunidades</title>
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
            background-color: var(--bg-light );
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
    </style>
</head>
<body>
    <div class="dashboard-container">
        <!-- Sidebar (reutilizada) -->
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
                <h2 class="page-title">Lista de oportunidades</h2>
                <div class="user-menu">
                    <button class="icon-button"><ion-icon name="notifications-outline"></ion-icon></button>
                    <div class="user-profile">
                        <div class="avatar"><ion-icon name="person-outline"></ion-icon></div>
                        <span>Admin</span>
                    </div>
                </div>
            </header>

            <div class="content-body">
                <div class="toolbar">
                    <div class="search-bar">
                        <ion-icon name="search-outline"></ion-icon>
                        <input type="text" id="searchInput" placeholder="Pesquisar por clube ou descrição...">
                    </div>
                    <button class="filter-button">
                        <ion-icon name="filter-outline"></ion-icon>
                        Ordenar por
                    </button>
                    <button class="add-button">Adicionar</button>
                </div>

                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>Clube</th>
                                <th>Descrição</th>
                                <th>Participantes</th>
                                <th>Status</th>
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

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // --- LÓGICA DA SIDEBAR EXPANSÍVEL ---
        const sidebar = document.querySelector('.sidebar');
        const body = document.body;
        sidebar.addEventListener('mouseenter', () => body.classList.add('sidebar-expanded'));
        sidebar.addEventListener('mouseleave', () => body.classList.remove('sidebar-expanded'));

        // --- LÓGICA DA PÁGINA DE OPORTUNIDADES ---
        const tableBody = document.getElementById('opportunitiesTableBody');
        const API_TOKEN = localStorage.getItem('admin_auth_token');

        if (!API_TOKEN) {
            document.body.innerHTML = '<h1>Erro de Autenticação. Faça o login de administrador.</h1>';
            return;
        }

        const authHeaders = {
            'Authorization': `Bearer ${API_TOKEN}`,
            'Accept': 'application/json'
        };

        // Função para formatar a data
        const formatDate = (dateString) => {
            if (!dateString) return 'N/A';
            return new Date(dateString).toLocaleDateString('pt-BR', {
                day: '2-digit', month: 'long', year: 'numeric'
            });
        };

        // Função principal para buscar e renderizar os dados
        async function fetchOpportunities() {
            tableBody.innerHTML = '<tr><td colspan="6">Carregando...</td></tr>';
            try {
                // 1. Busca a lista de todas as oportunidades
                const opportunitiesResponse = await fetch('/api/admin/oportunidades', { headers: authHeaders });
                if (!opportunitiesResponse.ok) throw new Error('Falha ao buscar oportunidades.');
                
                const opportunitiesResult = await opportunitiesResponse.json();
                const opportunities = opportunitiesResult.data || opportunitiesResult;

                if (opportunities.length === 0) {
                    tableBody.innerHTML = '<tr><td colspan="6">Nenhuma oportunidade encontrada.</td></tr>';
                    return;
                }

                // 2. Para cada oportunidade, busca o número de inscritos
                const opportunitiesWithParticipants = await Promise.all(
                    opportunities.map(async (op) => {
                        try {
                            const participantsResponse = await fetch(`/api/admin/oportunidade/${op.id}/inscritos`, { headers: authHeaders });
                            if (!participantsResponse.ok) {
                                // Se falhar (ex: 404), assume 0 participantes
                                op.participants_count = 0;
                                return op;
                            }
                            const participantsResult = await participantsResponse.json();
                            op.participants_count = participantsResult.total || 0;
                            return op;
                        } catch (e) {
                            // Em caso de erro de rede para uma chamada, assume 0
                            op.participants_count = 0;
                            return op;
                        }
                    })
                );

                renderTable(opportunitiesWithParticipants);

            } catch (error) {
                console.error('Erro ao carregar dados:', error);
                tableBody.innerHTML = `<tr><td colspan="6">Erro ao carregar: ${error.message}</td></tr>`;
            }
        }

        // Função para renderizar a tabela com os dados combinados
        function renderTable(data) {
            tableBody.innerHTML = ''; // Limpa a tabela
            data.forEach(op => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>
                        <div class="club-cell">
                            <div class="club-avatar">
                                <ion-icon name="shield-outline"></ion-icon>
                            </div>
                            <span>${op.clube ? op.clube.nomeClube : 'Clube não informado'}</span>
                        </div>
                    </td>
                    <td>${op.descricaoOportunidades}</td>
                    <td>${op.participants_count}</td>
                    <td><span class="tag tag-status-ativo">Ativo</span></td>
                    <td>${formatDate(op.datapostagemOportunidades)}</td>
                    <td>
                        <div class="action-buttons">
                            <button class="action-btn view" title="Visualizar"><ion-icon name="eye-outline"></ion-icon></button>
                            <button class="action-btn edit" title="Editar"><ion-icon name="pencil-outline"></ion-icon></button>
                            <button class="action-btn delete" title="Excluir"><ion-icon name="trash-outline"></ion-icon></button>
                        </div>
                    </td>
                `;
                tableBody.appendChild(row);
            });
        }

        // Inicia o carregamento dos dados
        fetchOpportunities();
    });
    </script>
</body>
</html>