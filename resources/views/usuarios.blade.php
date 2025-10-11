<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Usuários</title>
    {{-- Certifique-se de que o caminho para o CSS está correto --}}
    <link rel="stylesheet" href="{{ url('css/usuarios.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    {{-- Usando os mesmos ícones Ionicons --}}
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <style>
         #Logo{
        width: 150px;
        border-radius: 20px;
    }
    </style>
</head>

<body>
    <div class="dashboard-container">
        <!-- ======================= -->
        <!--      BARRA LATERAL      -->
        <!-- ======================= -->
        <aside class="sidebar">
            <div class="sidebar-header">
                 <img id="Logo" src="{{ asset('img/logoPerfil.jpeg') }}" alt="Logo do Perfil">
            </div>
            <nav class="sidebar-nav">
                <span class="menu-title">Menu</span>
                <ul>
                    <li><a href="/dashboard/index"><ion-icon name="grid-outline"></ion-icon> Dashboard</a></li>
                    <li class="active"><a href="#"><ion-icon name="people-outline"></ion-icon> Usuários <ion-icon class="chevron" name="chevron-down-outline"></ion-icon></a></li>
                    <li><a href="/dashboard/esporte"><ion-icon name="football-outline"></ion-icon> Esportes</a></li>
                    <li><a href="/dashboard/oportunidades"><ion-icon name="rocket-outline"></ion-icon> Oportunidades</a></li>
                    <li ><a href="#"><ion-icon name="list-outline"></ion-icon> Listas</a></li>
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

        <!-- ======================= -->
        <!--    CONTEÚDO PRINCIPAL   -->
        <!-- ======================= -->
        <main class="main-content">
            <header class="main-header">
                <h2 class="page-title">Lista de usuários</h2>
                <div class="user-menu">
                    <button class="icon-button"><ion-icon name="notifications-outline"></ion-icon></button>
                    <div class="user-profile">
                        <div class="avatar">
                            <ion-icon name="person-outline"></ion-icon>
                        </div>
                        <span>João Pedro</span>
                    </div>
                </div>
            </header>

            <div class="content-body">
                <div class="toolbar">
                    <div class="search-bar">
                        <ion-icon name="search-outline"></ion-icon>
                        <input type="text" id="searchInput" placeholder="Pesquisar por nome ou email...">
                    </div>
                    <button class="filter-button">
                        <ion-icon name="filter-outline"></ion-icon>
                        Ordenar por
                        <ion-icon class="chevron" name="chevron-down-outline"></ion-icon>
                    </button>
                    <button class="add-button">Adicionar</button>
                </div>

                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>Foto/Avatar</th>
                <th>Nome de usuário</th>
                <th>Email</th>
                <th>Tipo</th> 
                <th>Status</th>
                <th>Data de cadastro</th>
                <th>Ações rápidas</th>
                            </tr>
                        </thead>
                        <tbody id="usersTableBody">
                            <tr>
                                <td>
                                    <div class="item-icon user-avatar large">
                                        <ion-icon name="person-circle-outline"></ion-icon>
                                    </div>
                                </td>
                                <td class="user-name-cell">
                                    <span class="main-name">João Pedro</span>
                                    <span class="sub-name">@joaopedro</span>
                                </td>
                                <td>joaopedro@email.com</td>
                                <td><span class="tag tag-type-atleta">Atleta</span></td>
                                <td><span class="tag tag-status-ativo">Ativo</span></td>
                                <td>23 de Outubro de 2024</td>
                                <td>
                                    <div class="action-buttons">
                                        <button class="action-btn view"><ion-icon name="eye-outline"></ion-icon></button>
                                        <button class="action-btn edit"><ion-icon name="pencil-outline"></ion-icon></button>
                                        <button class="action-btn delete"><ion-icon name="trash-outline"></ion-icon></button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
    <script>
document.addEventListener('DOMContentLoaded', function() {
    const tableBody = document.getElementById('usersTableBody');
    const searchInput = document.getElementById('searchInput');

    // Função para formatar a data (ex: 2025-10-09 -> 09 de Outubro de 2025)
    function formatDate(dateString) {
        if (!dateString) return 'N/A';
        const options = { year: 'numeric', month: 'long', day: 'numeric' };
        return new Date(dateString).toLocaleDateString('pt-BR', options);
    }

    // Função para criar o @username a partir do nome completo
    function createUsername(fullName) {
        if (!fullName) return '';
        return '@' + fullName.toLowerCase().replace(/\s+/g, '');
    }

    // Função principal para buscar e renderizar os usuários
    async function fetchAndRenderUsers(searchTerm = '') {
        // O nome do parâmetro de busca no seu controller é 'pesquisa'
        const url = `/api/search-usuarios?pesquisa=${encodeURIComponent(searchTerm)}`;
        
        tableBody.innerHTML = '<tr><td colspan="7">Carregando...</td></tr>';

        try {
            const response = await fetch(url);
            if (!response.ok) {
                throw new Error('Falha ao buscar dados da API: ' + response.statusText);
            }
            const result = await response.json();
            const users = result.data;

            tableBody.innerHTML = ''; // Limpa a tabela

            if (users.length === 0) {
                tableBody.innerHTML = '<tr><td colspan="7">Nenhum usuário encontrado.</td></tr>';
                return;
            }

            // Cria e insere uma linha <tr> para cada usuário
            users.forEach(user => {
                const row = `
                    <tr>
                        <td>
                            <div class="item-icon user-avatar large">
                                <ion-icon name="person-circle-outline"></ion-icon>
                            </div>
                        </td>
                        <td class="user-name-cell">
                            <span class="main-name">${user.nomeCompletoUsuario}</span>
                            <span class="sub-name">${createUsername(user.nomeCompletoUsuario)}</span>
                        </td>
                        <td>${user.emailUsuario}</td>
                        <td><span class="tag tag-type-atleta">Atleta</span></td>
                        <td><span class="tag tag-status-ativo">Ativo</span></td>
                        <td>${formatDate(user.created_at)}</td>
                        <td>
                            <div class="action-buttons">
                                <button class="action-btn view"><ion-icon name="eye-outline"></ion-icon></button>
                                <button class="action-btn edit"><ion-icon name="pencil-outline"></ion-icon></button>
                                <button class="action-btn delete"><ion-icon name="trash-outline"></ion-icon></button>
                            </div>
                        </td>
                    </tr>
                `;
                tableBody.insertAdjacentHTML('beforeend', row);
            });

        } catch (error) {
            console.error('Erro ao buscar usuários:', error);
            tableBody.innerHTML = '<tr><td colspan="7">Erro ao carregar os dados. Tente novamente.</td></tr>';
        }
    }

    // --- EVENT LISTENERS ---

    // 1. Busca inicial quando a página carrega
    fetchAndRenderUsers();

    // 2. Evento para buscar enquanto o usuário digita (com debounce)
    let debounceTimer;
    searchInput.addEventListener('keyup', () => {
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(() => {
            // Passa o valor do input para a função de busca
            fetchAndRenderUsers(searchInput.value);
        }, 300); // Atraso de 300ms para evitar muitas requisições
    });
});
</script>
</body>
</html>
