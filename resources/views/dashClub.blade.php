<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    
    <style>
        #Logo{
        width: 150px;
        border-radius: 20px;
    }
    </style><link rel="stylesheet" href="./css/dashClub.css">
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
                    <li class="nav-item active">
                        <a href="#" class="nav-link">
                            <span class="nav-icon"><img class="nav-icon" src="./img/dashboard.png" alt=""></span>
                            <span class="nav-text">Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="oportunidades" class="nav-link">
                            <img class="nav-icon" src="./img/oportunidades.png" alt="Perfil">
                            <span class="nav-text">Oportunidades</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="lista" class="nav-link">
                            <img class="nav-icon" src="./img/vector.png" alt="Lista">
                            <span class="nav-text">Listas</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="mensagens" class="nav-link">
                            <img class="nav-icon" src="./img/mensagem.png" alt="Mensagens">
                            <span class="nav-text">Mensagens</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="notificacao" class="nav-link">
                            <img class="nav-icon" src="./img/notificaçao.png" alt="Notificação">
                            <span class="nav-text">Notificações</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="perfil" class="nav-link">
                            <img class="nav-icon" src="./img/perfil.png" alt="Perfil">
                            <span class="nav-text">Perfil</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="pesquisa" class="nav-link">
                            <img class="nav-icon" src="./img/pesquisa.png" alt="Pesquisa">
                            <span class="nav-text">Pesquisa</span>
                        </a>
                    </li>
                    <li class="nav-item">
                       <a href="configuracao" class="nav-link">
                            <img class="nav-icon" src="./img/configuracoes.png" alt="Configurações">
                            <span class="nav-text">Configurações</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <img class="nav-icon" src="./img/sair.png" alt="Sair">
                            <span class="nav-text">Sair</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <header class="page-header">
                <h1 class="page-title">Dashboard</h1>
            </header>

            <!-- Stats Cards -->
            <section class="stats-section">
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-content">
                            <h3 class="stat-title">Seguidores</h3>
                            <div class="stat-value">0</div>
                            <div class="stat-change positive">+0%</div>
                        </div>
                        <div class="stat-icon">
                            <div class="icon-followers"></div>
                        </div>
                    </div>

                    <div class="stat-card">
    <div class="stat-content">
        <h3 class="stat-title">Oportunidades</h3>
        <!-- Opcional: você pode mudar o subtítulo para "Total" ou remover -->
        <div class="stat-subtitle">Total Cadastrado</div> 
        <!-- Adicione o ID aqui e coloque um valor inicial de carregamento -->
        <div class="stat-value" id="total-oportunidades">...</div> 
    </div>
    <div class="stat-icon">
        <div class="icon-opportunities"></div>
    </div>
</div>

                    <div class="stat-card">
                        <div class="stat-content">
                            <h3 class="stat-title">Lista de Campeões</h3>
                        </div>
                        <div class="stat-icon">
                            <div class="icon-champions"></div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Chart Section -->
            <section class="chart-section">
                <div class="chart-header">
                    <h2 class="chart-title">Interessados</h2>
                    <select class="chart-filter">
                        <option value="zagueiro">Zagueiro</option>
                        <option value="atacante">Atacante</option>
                        <option value="meio-campo">Meio-campo</option>
                    </select>
                </div>
                <div class="chart-container">
                    <div class="chart">
                        <div class="chart-bar" style="height: 0%;">
                            <div class="bar-value">0</div>
                            <div class="bar-label">seg</div>
                        </div>
                        <div class="chart-bar" style="height: 0%;">
                            <div class="bar-value">0</div>
                            <div class="bar-label">ter</div>
                        </div>
                        <div class="chart-bar" style="height: 0%;">
                            <div class="bar-value">0</div>
                            <div class="bar-label">qua</div>
                        </div>
                        <div class="chart-bar" style="height: 0%;">
                            <div class="bar-value">0</div>
                            <div class="bar-label">qui</div>
                        </div>
                        <div class="chart-bar" style="height: 0%;">
                            <div class="bar-value">0</div>
                            <div class="bar-label">sex</div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Activities Section -->
            <section class="activities-section">
                <h2 class="section-title">Atividades recentes</h2>
                <div class="activities-table">
                    <div class="table-header">
                        <div class="header-cell">Perfil</div>
                        <div class="header-cell">Atividade</div>
                        <div class="header-cell">Oportunidade</div>
                        <div class="header-cell">Data</div>
                        <div class="header-cell">Clube atual</div>
                        <div class="header-cell">Ações</div>
                    </div>
                    

                </div>
            </section>

            <!-- Right Panel -->
            <aside class="right-panel">
                <section class="suggestions-section">
                    <div class="suggestions-header">
                        <h3 class="suggestions-title">Sugestões</h3>
                        <select class="suggestions-filter">
                            <option value="lateral">Lateral</option>
                            <option value="zagueiro">Zagueiro</option>
                            <option value="atacante">Atacante</option>
                        </select>
                    </div>
                    <div class="suggestions-list" id="suggestions-list-container">

    <p>Carregando sugestões...</p> 
</div>

                <!-- Mini Chart -->
                <section class="mini-chart-section">
                    <div class="mini-chart">
                        <div class="mini-bar" style="height: 60%;">
                            <div class="mini-bar-label">qui</div>
                        </div>
                        <div class="mini-bar" style="height: 100%;">
                            <div class="mini-bar-label">sex</div>
                        </div>
                    </div>
                </section>
            </aside>
        </main>
    </div>
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Função para buscar as estatísticas do clube
            async function carregarEstatisticas() {
                try {
                    // Faz a requisição para a API que criamos
                    const response = await fetch('/api/oportunidades/estatisticas', {
                        headers: {
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    });

                    if (!response.ok) {
                        // Se a resposta não for OK (ex: erro 401, 500), exibe um erro
                        console.error('Erro ao buscar estatísticas:', response.statusText);
                        document.getElementById('total-oportunidades').textContent = 'Erro';
                        return;
                    }

                    // Converte a resposta para JSON
                    const stats = await response.json();

                    // Atualiza o elemento HTML com o total de oportunidades
                    const totalOportunidadesEl = document.getElementById('total-oportunidades');
                    if (totalOportunidadesEl) {
                        totalOportunidadesEl.textContent = stats.total_oportunidades;
                    }

                } catch (error) {
                    console.error('Falha na requisição de estatísticas:', error);
                    document.getElementById('total-oportunidades').textContent = 'N/A';
                }
            }

            // Chama a função assim que a página terminar de carregar
            carregarEstatisticas();
        });
    </script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        
        // Função para carregar as estatísticas (já existente)
        async function carregarEstatisticas() {
            // ... seu código existente ...
        }

        // --- NOVA FUNÇÃO PARA CARREGAR SUGESTÕES ---
        async function carregarSugestoes() {
            const container = document.getElementById('suggestions-list-container');
            
            try {
                // Chama a nova rota da API
                const response = await fetch('/api/usuarios/sugestoes', {
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });

                if (!response.ok) {
                    container.innerHTML = '<p>Erro ao carregar sugestões.</p>';
                    return;
                }

                const sugestoes = await response.json();

                // Limpa a mensagem "Carregando..."
                container.innerHTML = '';

                if (sugestoes.length === 0) {
                    container.innerHTML = '<p>Nenhuma sugestão encontrada.</p>';
                    return;
                }

                // Cria um item na lista para cada sugestão recebida
                sugestoes.forEach(usuario => {
                    const itemHtml = `
                        <div class="suggestion-item">
                            <div class="suggestion-avatar"></div>
                            <div class="suggestion-info">
                                <div class="suggestion-name">${usuario.nomeCompletoUsuario}</div>
                                <div class="suggestion-handle">${usuario.username}</div>
                            </div>
                            <button class="suggestion-action">→</button>
                        </div>
                    `;
                    // Adiciona o novo elemento HTML ao container
                    container.insertAdjacentHTML('beforeend', itemHtml);
                });

            } catch (error) {
                console.error('Falha ao carregar sugestões:', error);
                container.innerHTML = '<p>Não foi possível buscar as sugestões.</p>';
            }
        }

        // Chama as duas funções ao carregar a página
        carregarEstatisticas();
        carregarSugestoes(); 
    });
</script>

    

</body>
</html>
