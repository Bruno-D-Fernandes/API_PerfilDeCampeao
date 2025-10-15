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
                <img id="LogoExpanded" src="{{ asset('img/logoPerfil.jpeg') }}" alt="Logo do Perfil Completa">
        
                <img id="LogoCollapsed" src="{{ asset('img/mini_logo.png') }}" alt="MIni logo">
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
                    <!--<li class="nav-item">
                        <a href="lista" class="nav-link">
                            <img class="nav-icon" src="./img/vector.png" alt="Lista">
                            <span class="nav-text">Listas</span>
                        </a>
                    </li>-->
                 <!--    <li class="nav-item">
                        <a href="mensagens" class="nav-link">
                            <img class="nav-icon" src="./img/mensagem.png" alt="Mensagens">
                            <span class="nav-text">Mensagens</span>
                        </a>
                    </li> -->
                    <!--<li class="nav-item">
                        <a href="notificacao" class="nav-link">
                             <img class="nav-icon" src="./img/notificaçao.png" alt="Notificação">
                            <span class="nav-text">Notificações</span>
                        </a>
                    </li>-->
                    <li class="nav-item">
                        <a href="perfil2" class="nav-link">
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
                       <a href="configuracoes" class="nav-link">
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
    
    /**
     * Função para buscar as estatísticas do clube
     */
    async function carregarEstatisticas() {
        try {
            // Pega o token de autenticação
            // AJUSTE conforme seu sistema salva o token
            const token =  localStorage.getItem('token')
            
            if (!token) {
                console.error('Token de autenticação não encontrado');
                document.getElementById('total-oportunidades').textContent = 'N/A';
                return;
            }

            console.log('Buscando estatísticas...');

            // Faz a requisição para a API
            const response = await fetch('/api/clube/minhasOportunidades', {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${token}`,
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });

            console.log('Status da resposta:', response.status);

            if (!response.ok) {
                console.error('Erro ao buscar estatísticas:', response.statusText);
                document.getElementById('total-oportunidades').textContent = 'Erro';
                
                // Se for erro 401, redireciona para login
                if (response.status === 401) {
                    console.log('Sessão expirada');
                    // Descomente a linha abaixo se quiser redirecionar
                    window.location.href = '/login';
                }
                return;
            }

            // Converte a resposta para JSON
            const data = await response.json();
            console.log('Dados recebidos:', data);

            // ATUALIZA O TOTAL DE OPORTUNIDADES
            const totalOportunidadesEl = document.getElementById('total-oportunidades');
            if (totalOportunidadesEl) {
                // Tenta diferentes estruturas de resposta
                const total = data.total_oportunidades  // Versão com estatísticas
                           || data.total                // Versão paginada
                           || (data.data ? data.data.length : 0); // Fallback
                
                totalOportunidadesEl.textContent = total;
                console.log('Total de oportunidades:', total);
            }

            // OPCIONAL: Atualiza total de inscrições (se você tiver esse elemento)
            const totalInscricoesEl = document.getElementById('total-inscricoes');
            if (totalInscricoesEl && data.total_inscricoes !== undefined) {
                totalInscricoesEl.textContent = data.total_inscricoes;
            }

            // OPCIONAL: Atualiza oportunidades ativas
            const oportunidadesAtivasEl = document.getElementById('oportunidades-ativas');
            if (oportunidadesAtivasEl && data.oportunidades_ativas !== undefined) {
                oportunidadesAtivasEl.textContent = data.oportunidades_ativas;
            }

            // OPCIONAL: Renderiza lista de oportunidades
            if (data.data && data.data.length > 0) {
                renderizarOportunidades(data.data);
            }

        } catch (error) {
            console.error('Falha na requisição de estatísticas:', error);
            document.getElementById('total-oportunidades').textContent = 'N/A';
        }
    }

    /**
     * Função para renderizar lista de oportunidades (OPCIONAL)
     */
    function renderizarOportunidades(oportunidades) {
        const container = document.getElementById('lista-oportunidades');
        if (!container) return;

        container.innerHTML = '';

        oportunidades.forEach(oportunidade => {
            const inscricoesCount = oportunidade.inscricoes_count || 0;
            const esporte = oportunidade.esporte?.nomeEsporte || 'N/A';
            const posicao = oportunidade.posicao?.nomePosicao || 'N/A';
            
            const itemHtml = `
                <div class="oportunidade-item" style="border: 1px solid #ddd; padding: 10px; margin: 5px 0; border-radius: 5px;">
                    <h4 style="margin: 0 0 5px 0;">${oportunidade.descricaoOportunidades}</h4>
                    <p style="margin: 3px 0;"><strong>Esporte:</strong> ${esporte}</p>
                    <p style="margin: 3px 0;"><strong>Posição:</strong> ${posicao}</p>
                    <p style="margin: 3px 0;"><strong>Inscrições:</strong> ${inscricoesCount}</p>
                    <p style="margin: 3px 0;"><strong>Data:</strong> ${new Date(oportunidade.datapostagemOportunidades).toLocaleDateString('pt-BR')}</p>
                </div>
            `;
            container.insertAdjacentHTML('beforeend', itemHtml);
        });
    }

    // Chama a função assim que a página terminar de carregar
    console.log('Página carregada, iniciando busca de estatísticas...');
    carregarEstatisticas();
    });
</script>

    

</body>
</html>