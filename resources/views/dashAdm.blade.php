<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard</title>
    <link rel="stylesheet" href="./css/dashadm.css">k
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    {{-- Ícones e a biblioteca de gráficos Chart.js --}}
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


</head>
<body>
    <div class="dashboard-container">
        <!-- Sidebar idêntica à imagem -->
        <aside class="sidebar">
            <div class="sidebar-header">Logo aqui</div>
            <nav class="sidebar-nav">
                <span class="menu-title">Menu</span>
                <ul>
                    <li class="active"><a href="#"><ion-icon name="grid-outline"></ion-icon> Dashboard</a></li>
                    <li><a href="/usuarios"><ion-icon name="people-outline"></ion-icon> Usuários <ion-icon class="chevron" name="chevron-down-outline"></ion-icon></a></li>
                    <li><a href="esporte"><ion-icon name="football-outline"></ion-icon> Esportes</a></li>
                    <li><a href="oportunidades"><ion-icon name="briefcase-outline"></ion-icon> Oportunidades</a></li>
                    <li><a href="#"><ion-icon name="list-outline"></ion-icon> Listas</a></li>
                    <li><a href="#"><ion-icon name="alert-circle-outline"></ion-icon> Denúncias <ion-icon class="chevron" name="chevron-down-outline"></ion-icon></a></li>
                    <li><a href="#"><ion-icon name="document-text-outline"></ion-icon> Conteúdo <ion-icon class="chevron" name="chevron-down-outline"></ion-icon></a></li>
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

        <!-- Conteúdo Principal -->
        <main class="main-content">
            <header class="main-header">
                <h1 class="page-title">Dashboard</h1>
                <div class="user-menu">
                    <button class="icon-button"><ion-icon name="notifications-outline"></ion-icon></button>
                    <div class="user-profile">
                        <span class="avatar"><ion-icon name="person-circle-outline"></ion-icon></span>
                        <span>João Pedro</span>
                    </div>
                </div>
            </header>

            <div class="dashboard-grid">
                <!-- Cards de Estatísticas -->
                <div class="stat-card">
                    <div class="stat-card-header">
                        <span class="stat-card-title">Usuários</span>
                    </div>
                    <p class="stat-card-value" id="total-users">0</p>
                    <p class="stat-card-footer">Total de usuários cadastrados</p>
                </div>
                <div class="stat-card">
                    <div class="stat-card-header">
                        <span class="stat-card-title">Clubes</span>
                    </div>
                    <p class="stat-card-value" id="total-clubs">0</p>
                    <p class="stat-card-footer">Total de clubes cadastrados</p>
                </div>
                <div class="stat-card">
                    <div class="stat-card-header">
                        <span class="stat-card-title">Oportunidades</span>
                    </div>
                    <p class="stat-card-value" id="total-opportunities">0</p>
                    <p class="stat-card-footer">Total de oportunidades criadas</p>
                </div>

                <!-- Gráfico de Cadastro de Usuários -->
                <div class="chart-card">
                    <div class="card-header">
                        <h3 class="card-title"><ion-icon name="people-outline"></ion-icon> Cadastro de usuários</h3>
                    </div>
                    <canvas id="userRegistrationChart"></canvas>
                </div>

                <!-- Lista de Últimas Oportunidades -->
                <div class="list-card">
                    <div class="card-header">
                        <h3 class="card-title"><ion-icon name="briefcase-outline"></ion-icon> Últimas oportunidades</h3>
                    </div>
                    <ul class="opportunity-list" id="latest-opportunities">
                        <!-- Itens serão inseridos pelo JavaScript -->
                    </ul>
                </div>

                <!-- Ações Recentes (Placeholder) -->
                <div class="actions-card">
                    <div class="card-header">
                        <h3 class="card-title">Ações recentes</h3>
                    </div>
                    <table class="actions-table">
                        <thead>
                            <tr><th>Data</th><th>Objeto</th><th>Ação</th><th>Entidade</th><th>Descrição</th></tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>--/--/----</td>
                                <td>-</td>
                                <td>-</td>
                                <td>-</td>
                                <td>Nenhuma ação recente para exibir.</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // --- CONFIGURAÇÃO ---
        const API_TOKEN = localStorage.getItem('admin_auth_token');
        if (!API_TOKEN) {
            document.body.innerHTML = '<h1>Erro de Autenticação. Faça o login de administrador.</h1>';
            return;
        }
        const authHeaders = {
            'Authorization': `Bearer ${API_TOKEN}`,
            'Accept': 'application/json'
        };

        // **CORREÇÃO:** Declarar a variável do gráfico aqui, no escopo mais alto.
        let myUserChart = null;

        // --- FUNÇÕES DE FETCH ---

        // 1. Buscar todos os usuários
        async function fetchAllUsers() {
            try {
                // Usando a rota de admin que você criou.
                const response = await fetch('/api/admin/usuarios', { headers: authHeaders });
                if (!response.ok) throw new Error('Falha ao buscar usuários');
                
                const result = await response.json();
                const users = result.data || result;

                document.getElementById('total-users').textContent = result.total || users.length;
                processUserDataForChart(users);

            } catch (error) {
                console.error("Erro ao buscar usuários:", error);
                document.getElementById('total-users').textContent = 'Erro';
            }
        }

        // 2. Buscar todos os clubes
        async function fetchAllClubs() {
            try {
                // Usando a rota de admin que você criou.
                const response = await fetch('/api/admin/clubes', { headers: authHeaders });
                if (!response.ok) throw new Error('Falha ao buscar clubes');
                const clubes = await response.json();
                
                document.getElementById('total-clubs').textContent = clubes.length;
            } catch (error) {
                console.error("Erro ao buscar clubes:", error);
                document.getElementById('total-clubs').textContent = 'Erro';
            }
        }

        // 3. Buscar todas as oportunidades
        async function fetchAllOpportunities() {
            try {
                // Usando a rota de admin que você criou.
                const response = await fetch('/api/admin/oportunidades', { headers: authHeaders });
                if (!response.ok) throw new Error('Falha ao buscar oportunidades');
                
                const result = await response.json();
                const opportunities = result.data || result;

                document.getElementById('total-opportunities').textContent = result.total || opportunities.length;
                renderLatestOpportunities(opportunities.slice(0, 3));

            } catch (error) {
                console.error("Erro ao buscar oportunidades:", error);
                document.getElementById('total-opportunities').textContent = 'Erro';
                document.getElementById('latest-opportunities').innerHTML = `<li>${error.message}</li>`;
            }
        }

        // --- FUNÇÕES DE RENDERIZAÇÃO ---
        function renderLatestOpportunities(opportunities) {
            const listElement = document.getElementById('latest-opportunities');
            listElement.innerHTML = '';
            if (!opportunities || opportunities.length === 0) {
                listElement.innerHTML = '<li>Nenhuma oportunidade recente.</li>';
                return;
            }
            opportunities.forEach(op => {
                const clubName = op.clube ? op.clube.nomeClube : 'Clube não informado';
                const positionName = op.posicao ? op.posicao.nomePosicao : 'Posição não informada';
                listElement.insertAdjacentHTML('beforeend', `
                    <li class="opportunity-item">
                        <ion-icon name="shield-checkmark-outline" class="club-logo"></ion-icon>
                        <div class="opportunity-info">
                            <div class="club-name">${clubName}</div>
                            <div class="position-name">${positionName}</div>
                        </div>
                    </li>
                `);
            });
        }

        function processUserDataForChart(users) {
            const userCountsByMonth = Array(12).fill(0);
            const monthLabels = ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'];
            
            users.forEach(user => {
                if (user.created_at) {
                    const monthIndex = new Date(user.created_at).getMonth();
                    userCountsByMonth[monthIndex]++;
                }
            });

            renderUserChart(monthLabels, userCountsByMonth);
        }

        function renderUserChart(labels, data) {
            const ctx = document.getElementById('userRegistrationChart').getContext('2d');
            
            // **CORREÇÃO:** Destrói o gráfico anterior se ele já existir.
            if (myUserChart) {
                myUserChart.destroy();
            }
            
            myUserChart = new Chart(ctx, {
                // **MUDANÇA:** Alterado de 'bar' para 'line'
                type: 'line', 
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Novos Usuários',
                        data: data,
                        backgroundColor: 'rgba(59, 130, 246, 0.1)', // Área sob a linha
                        borderColor: 'rgba(59, 130, 246, 1)',
                        borderWidth: 2,
                        fill: true, // Preenche a área sob a linha
                        tension: 0.4 // Deixa a linha mais suave
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: { 
                        y: { 
                            beginAtZero: true,
                            ticks: { 
                                // Garante que o eixo Y só mostre números inteiros
                                callback: function(value) { if (Number.isInteger(value)) { return value; } },
                                stepSize: 1 
                            } 
                        } 
                    },
                    plugins: { 
                        legend: { 
                            display: false 
                        } 
                    }
                }
            });
        }

        // --- INICIALIZAÇÃO ---
        function initializeDashboard() {
            fetchAllUsers();
            fetchAllClubs();
            fetchAllOpportunities();
        }

        initializeDashboard();
    });
    </script>
</body>
</html>
