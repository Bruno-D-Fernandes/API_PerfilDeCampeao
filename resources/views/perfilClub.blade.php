<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Perfil</title>
    <link rel="stylesheet" href="./css/perfilClub.css">
<style>
    #Logo{
        width: 150px;
        border-radius: 20px;
    }
</style>
</head>
<body>
    {{-- Mensagens de feedback --}}
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

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
                            <img class="nav-icon" src="./img/dashboard.png" alt="">
                            <span class="nav-text">Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <img class="nav-icon" src="./img/oportunidades.png" alt="Perfil">
                            <span class="nav-text">Oportunidades</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <img class="nav-icon" src="./img/vector.png" alt="Lista">
                            <span class="nav-text">Listas</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <img class="nav-icon" src="./img/mensagem.png" alt="Dashboard">
                            <span class="nav-text">Mensagens</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <img class="nav-icon" src="./img/notificaçao.png" alt="Perfil">
                            <span class="nav-text">Notificações</span>
                        </a>
                    </li>
                    <li class="nav-item active">
                        <a href="#" class="nav-link">
                            <img class="nav-icon" src="./img/perfil.png" alt="">
                            <span class="nav-text">Perfil</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="pesquisa" class="nav-link">
                            <img class="nav-icon" src="./img/pesquisa.png" alt="">
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
                        <a href="#" class="nav-link" id="logoutBtn">
                            <img class="nav-icon" src="./img/sair.png" alt="Sair">
                            <span class="nav-text">Sair</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="main-content profile-page">
            <!-- Header -->
            <header class="profile-header">
                <h1 class="page-title">Perfil</h1>
                <div class="header-actions">
                    <div class="user-info">
                        <span class="notification-icon">🔔</span>
                        <div class="user-profile">
                            <span class="user-avatar">👤</span>
                            <span class="user-name" id="headerClubName">Nome do Clube</span>
                        </div>
                    </div>
                    <!-- Botão de tema dark -->
                    
                </div>
            </header>

            <!-- Profile Banner -->
            <section class="profile-banner">
                <div class="banner-background"></div>
                <div class="profile-info">
                    <div class="profile-avatar-container">
                        <div class="profile-avatar-large"></div>
                    </div>
                    <div class="profile-details">
                        <div class="profile-stats">
                            <span class="followers-count">125k seguidores</span>
                            <button id="edit-profile-btn" class="follow-btn">Editar Perfil</button>
                        </div>
                        <h2 class="profile-name" id="mainClubName">Nome do Clube</h2>
                        <p class="profile-description" id="clubBio">Descrição do clube não disponível.</p>
                        <p class="profile-sport">
                            <strong>Esporte:</strong> <span id="clubSport">Não informado</span>
                        </p>
                        <p class="profile-location">
                            <strong>Localização:</strong> <span id="clubLocation">Não informado</span>
                        </p>
                    </div>
                </div>
            </section>

            <!-- Profile Navigation -->
            <section class="profile-navigation">
                <nav class="profile-nav">
                    <ul class="profile-nav-list">
                        <li class="profile-nav-item active">
                            <a href="#vagas" class="profile-nav-link">Vagas</a>
                        </li>
                        <li class="profile-nav-item">
                            <a href="#equipe" class="profile-nav-link">Equipe</a>
                        </li>
                        <li class="profile-nav-item">
                            <a href="#conquistas" class="profile-nav-link">Conquistas</a>
                        </li>
                        <li class="profile-nav-item">
                            <a href="#sobre" class="profile-nav-link">Sobre</a>
                        </li>
                    </ul>
                </nav>
            </section>

            <!-- Profile Content -->
            <section class="profile-content">
                <div class="content-area" id="vagas">
                    <div class="empty-state">
                        <div class="empty-icon">📋</div>
                        <h3 class="empty-title">Nenhuma vaga disponível</h3>
                        <p class="empty-description">Este perfil ainda não publicou nenhuma vaga. Volte mais tarde para ver as oportunidades disponíveis.</p>
                        <button class="create-opportunity-btn">Criar Oportunidade</button>
                    </div>
                </div>

                <div class="content-area hidden" id="equipe">
                    <div class="team-grid">
                        <div class="team-member">
                            <div class="member-avatar"></div>
                            <h4 class="member-name">João Silva</h4>
                            <p class="member-position">Técnico</p>
                        </div>
                        <div class="team-member">
                            <div class="member-avatar"></div>
                            <h4 class="member-name">Maria Santos</h4>
                            <p class="member-position">Preparadora Física</p>
                        </div>
                        <div class="team-member">
                            <div class="member-avatar"></div>
                            <h4 class="member-name">Pedro Costa</h4>
                            <p class="member-position">Goleiro</p>
                        </div>
                        <div class="team-member">
                            <div class="member-avatar"></div>
                            <h4 class="member-name">Ana Lima</h4>
                            <p class="member-position">Zagueira</p>
                        </div>
                    </div>
                </div>

                <div class="content-area hidden" id="conquistas">
                    <div class="achievements-list">
                        <div class="achievement-item">
                            <div class="achievement-icon">🏆</div>
                            <div class="achievement-info">
                                <h4 class="achievement-title">Campeonato Regional 2025</h4>
                                <p class="achievement-description">1º lugar no campeonato regional</p>
                                <span class="achievement-date">Setembro 2025</span>
                            </div>
                        </div>
                        <div class="achievement-item">
                            <div class="achievement-icon">🥈</div>
                            <div class="achievement-info">
                                <h4 class="achievement-title">Copa da Cidade 2024</h4>
                                <p class="achievement-description">2º lugar na copa municipal</p>
                                <span class="achievement-date">Dezembro 2024</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="content-area hidden" id="sobre">
                    <div class="about-content">
                        <h3>Sobre o <span id="aboutClubName">Clube</span></h3>
                        <p id="aboutClubBio">Informações sobre o clube não disponíveis.</p>
                        
                        <h4>Informações Gerais</h4>
                        <div class="club-info">
                            <p><strong>Nome:</strong> <span id="infoClubName">Não informado</span></p>
                            <p><strong>CNPJ:</strong> <span id="clubCnpj">Não informado</span></p>
                            <p><strong>Esporte:</strong> <span id="infoClubSport">Não informado</span></p>
                            <p><strong>Cidade:</strong> <span id="clubCity">Não informado</span></p>
                            <p><strong>Estado:</strong> <span id="clubState">Não informado</span></p>
                            <p><strong>Fundado em:</strong> <span id="clubFoundedYear">Não informado</span></p>
                        </div>
                        
                        <h4>Contato</h4>
                        <div class="contact-info">
                            <p><strong>Email:</strong> <span id="clubEmail">Não informado</span></p>
                            <p><strong>Endereço:</strong> <span id="clubAddress">Não informado</span></p>
                        </div>
                    </div>
                </div>
            </section>
        </main>
    </div>

    {{-- Modal de Edição --}}
    <div id="edit-modal" class="modal-overlay hidden">
        <div class="modal-container">
            <div class="modal-header">
                <h3 class="modal-title">Editar Perfil do Clube</h3>
                <button id="close-modal-btn" class="modal-close-btn">&times;</button>
            </div>
            <div class="modal-body">
                <form id="edit-club-form" action="{{ route('clube.updateInfo') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="nomeClube">Nome do Clube</label>
                        <div class="input-icon-wrapper">
                            <input type="text" id="nomeClube" name="nomeClube" class="form-control" 
                                   value="" required>
                        </div>
                    </div>

                    <div class="modal-actions">
                        <button type="button" id="cancel-edit-btn" class="btn-secondary">Cancelar</button>
                        <button type="submit" class="btn-primary">Salvar Alterações</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // ========== CONFIGURAÇÕES DA API ==========
            const API_BASE_URL = 'http://127.0.0.1:8000';
            const token = localStorage.getItem('token');

            // Verifica se tem token
            if (!token) {
                window.location.href = '/login';
                return;
            }

            // ========== CARREGAMENTO DOS DADOS ==========
            loadClubData();

            async function loadClubData() {
                try {
                    const response = await fetch(`${API_BASE_URL}/api/clube/perfil`, {
                        headers: { 
                            'Authorization': token,
                            'Accept': 'application/json'
                        }
                    });

                    if (!response.ok) {
                        throw new Error(`Erro HTTP: ${response.status}`);
                    }

                    const clube = await response.json();
                    
                    // Atualiza TODOS os campos do clube
                    updateAllClubData(clube);

                } catch (error) {
                    console.error('Erro ao carregar dados do clube:', error);
                    
                    if (error.message.includes('401') || error.message.includes('403')) {
                        localStorage.removeItem('token');
                        window.location.href = '/login';
                    }
                }
            }

            // ========== FUNÇÃO PARA ATUALIZAR TODOS OS DADOS ==========
            function updateAllClubData(clube) {
                // Função auxiliar para atualizar elemento por ID
                function updateElement(id, value, defaultValue = 'Não informado') {
                    const element = document.getElementById(id);
                    if (element) {
                        element.textContent = value || defaultValue;
                    }
                }

                // Função auxiliar para formatar localização
                function formatLocation(cidade, estado) {
                    if (cidade && estado) return `${cidade} - ${estado}`;
                    if (cidade) return cidade;
                    if (estado) return estado;
                    return 'Não informado';
                }

                // Função auxiliar para formatar data
                function formatDate(dateString) {
                    if (!dateString) return 'Não informado';
                    try {
                        const date = new Date(dateString);
                        return date.toLocaleDateString('pt-BR');
                    } catch (error) {
                        return dateString;
                    }
                }

                // Função auxiliar para formatar endereço completo
                function formatFullAddress(endereco, cidade, estado) {
                    if (!endereco) return 'Não informado';
                    const location = formatLocation(cidade, estado);
                    if (location !== 'Não informado') {
                        return `${endereco}, ${location}`;
                    }
                    return endereco;
                }

                // ========== ATUALIZA TODOS OS CAMPOS ==========
                
                // Nomes do clube (4 lugares)
                updateElement('headerClubName', clube.nomeClube, 'Nome do Clube');
                updateElement('mainClubName', clube.nomeClube, 'Nome do Clube');
                updateElement('aboutClubName', clube.nomeClube, 'Clube');
                updateElement('infoClubName', clube.nomeClube);

                // Bio/Descrição (2 lugares)
                updateElement('clubBio', clube.bioClube, 'Descrição do clube não disponível.');
                updateElement('aboutClubBio', clube.bioClube, 'Informações sobre o clube não disponíveis.');

                // Esporte (2 lugares)
                const sport = clube.esporteClube || clube.esporte;
                updateElement('clubSport', sport);
                updateElement('infoClubSport', sport);

                // Localização
                const location = formatLocation(clube.cidadeClube, clube.estadoClube);
                updateElement('clubLocation', location);

                // Dados específicos
                updateElement('clubCnpj', clube.cnpjClube);
                updateElement('clubCity', clube.cidadeClube);
                updateElement('clubState', clube.estadoClube);
                updateElement('clubEmail', clube.emailClube);
                updateElement('clubFoundedYear', formatDate(clube.anoCriacaoClube));
                
                // Endereço completo
                const fullAddress = formatFullAddress(clube.enderecoClube, clube.cidadeClube, clube.estadoClube);
                updateElement('clubAddress', fullAddress);
            }

            // ========== LOGOUT ==========
            const logoutBtn = document.getElementById('logoutBtn');
            if (logoutBtn) {
                logoutBtn.addEventListener('click', async (e) => {
                    e.preventDefault();
                    
                    if (confirm('Tem certeza que deseja sair?')) {
                        try {
                            await fetch(`${API_BASE_URL}/api/clube/logout`, {
                                method: 'POST',
                                headers: {
                                    'Authorization': token,
                                    'Content-Type': 'application/json',
                                    'Accept': 'application/json'
                                }
                            });
                        } catch (error) {
                            console.log('Erro no logout da API:', error);
                        } finally {
                            localStorage.removeItem('token');
                            window.location.href = '/login';
                        }
                    }
                });
            }

            // ========== MODAL FUNCTIONALITY ==========
            const editProfileBtn = document.getElementById('edit-profile-btn');
            const editModal = document.getElementById('edit-modal');
            const closeModalBtn = document.getElementById('close-modal-btn');
            const cancelEditBtn = document.getElementById('cancel-edit-btn');

            function openModal() {
                if (editModal) {
                    editModal.classList.remove('hidden');
                    document.body.style.overflow = 'hidden';
                }
            }

            function closeModal() {
                if (editModal) {
                    editModal.classList.add('hidden');
                    document.body.style.overflow = 'auto';
                }
            }

            if (editProfileBtn) editProfileBtn.addEventListener('click', openModal);
            if (closeModalBtn) closeModalBtn.addEventListener('click', closeModal);
            if (cancelEditBtn) cancelEditBtn.addEventListener('click', closeModal);
            if (editModal) {
                editModal.addEventListener('click', function(e) {
                    if (e.target === this) closeModal();
                });
            }

            // ========== NAVEGAÇÃO DO PERFIL ==========
            const profileNavLinks = document.querySelectorAll('.profile-nav-link');
            const contentAreas = document.querySelectorAll('.content-area');

            profileNavLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    
                    profileNavLinks.forEach(l => l.parentElement.classList.remove('active'));
                    this.parentElement.classList.add('active');
                    
                    contentAreas.forEach(area => area.classList.add('hidden'));
                    
                    const targetId = this.getAttribute('href').substring(1);
                    const targetArea = document.getElementById(targetId);
                    if (targetArea) {
                        targetArea.classList.remove('hidden');
                    }
                });
            });

            // ========== AUTO-HIDE ALERTS ==========
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                setTimeout(() => {
                    alert.style.opacity = '0';
                    setTimeout(() => {
                        alert.remove();
                    }, 300);
                }, 5000);
            });

            // ========== TEMA DARK (SEPARADO PARA EVITAR CONFLITOS) ==========
            initializeTheme();
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
