<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Lista de Usuários</title>
    <link rel="stylesheet" href="{{ url('css/usuarios.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

</head>
<body>
    <div class="dashboard-container">
        <!-- ======================= -->
        <!--      BARRA LATERAL      -->
        <!-- ======================= -->
        <aside class="sidebar">
            <div class="sidebar-header">
                <!-- Logo completa, visível apenas quando expandido -->
                <img id="logo-expanded" src="{{ asset('img/logoPerfil.jpeg') }}" alt="Logo Completa">
                <!-- Logo ícone, visível apenas quando encolhido -->
                <ion-icon id="logo-collapsed" name="football-outline"></ion-icon>
            </div>
            <nav class="sidebar-nav">
                <ul>
                    <li><a href="dashAdm"><ion-icon name="grid-outline"></ion-icon> <span class="nav-text">Dashboard</span></a></li>
                    <li class="active"><a href="#"><ion-icon name="people-outline"></ion-icon> <span class="nav-text">Usuários</span> <ion-icon class="chevron" name="chevron-down-outline"></ion-icon></a></li>
                    <li><a href="esporte"><ion-icon name="football-outline"></ion-icon> <span class="nav-text">Esportes</span></a></li>
                    <li><a href="#"><ion-icon name="rocket-outline"></ion-icon> <span class="nav-text">Oportunidades</span></a></li>
                    <li><a href="#"><ion-icon name="list-outline"></ion-icon> <span class="nav-text">Listas</span></a></li>
                    <li><a href="#"><ion-icon name="alert-circle-outline"></ion-icon> <span class="nav-text">Denúncias</span> <ion-icon class="chevron" name="chevron-down-outline"></ion-icon></a></li>
                    <li><a href="#"><ion-icon name="document-text-outline"></ion-icon> <span class="nav-text">Conteúdo</span> <ion-icon class="chevron" name="chevron-down-outline"></ion-icon></a></li>
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
                    <!-- tenho que fazer ainda -->
                     
                    <!-- <button class="filter-button">
                        <ion-icon name="filter-outline"></ion-icon>
                        Ordenar por
                        <ion-icon class="chevron" name="chevron-down-outline"></ion-icon>
                    </button> -->
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

     <div id="viewUserModal" class="modal-overlay">
        <div class="modal-container">
            <div class="modal-header">
                <h3>Detalhes do Usuário</h3>
                <button type="button" class="modal-close-btn" data-modal-id="viewUserModal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="view-user-info">
                    <div class="info-item"><span class="label">Nome Completo</span><span class="value" id="viewUserName"></span></div>
                    <div class="info-item"><span class="label">Email</span><span class="value" id="viewUserEmail"></span></div>
                    <div class="info-item"><span class="label">Data de Nascimento</span><span class="value" id="viewUserBirthdate"></span></div>
                    <div class="info-item"><span class="label">Gênero</span><span class="value" id="viewUserGender"></span></div>
                    <div class="info-item"><span class="label">Localização</span><span class="value" id="viewUserLocation"></span></div>
                    <div class="info-item"><span class="label">Membro Desde</span><span class="value" id="viewUserSince"></span></div>
                    <div class="info-item"><span class="label">Altura</span><span class="value" id="viewUserHeight"></span></div>
                    <div class="info-item"><span class="label">Peso</span><span class="value" id="viewUserWeight"></span></div>
                    <div class="info-item"><span class="label">Pé Dominante</span><span class="value" id="viewUserFoot"></span></div>
                    <div class="info-item"><span class="label">Mão Dominante</span><span class="value" id="viewUserHand"></span></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-modal-id="viewUserModal">Fechar</button>
            </div>
        </div>
    </div>

    <!-- MODAIS PARA EDIÇÃO E EXCLUSÃO DE USUÁRIO -->
    <div id="editUserModal" class="modal-overlay">
        <div class="modal-container">
            <form id="editUserForm">
                <div class="modal-header">
                    <h3>Editar Usuário</h3>
                    <button type="button" class="modal-close-btn" data-modal-id="editUserModal">&times;</button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="editUserId">
                    <div class="form-group">
                        <label for="editUserName">Nome Completo</label>
                        <input type="text" id="editUserName" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="editUserEmail">Email</label>
                        <input type="email" id="editUserEmail" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-modal-id="editUserModal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Salvar Alterações</button>
                </div>
            </form>
        </div>
    </div>

    <div id="deleteUserModal" class="modal-overlay">
        <div class="modal-container">
            <div class="modal-header">
                <h3>Confirmar Exclusão</h3>
                <button type="button" class="modal-close-btn" data-modal-id="deleteUserModal">&times;</button>
            </div>
            <div class="modal-body">
                <p>Tem certeza que deseja excluir o usuário "<strong id="deleteUserName"></strong>"?</p>
                <p>Esta ação não pode ser desfeita.</p>
            </div>
            <div class="modal-footer">
                <input type="hidden" id="deleteUserId">
                <button type="button" class="btn btn-secondary" data-modal-id="deleteUserModal">Cancelar</button>
                <button type="button" id="confirmDeleteBtn" class="btn btn-danger">Excluir</button>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const sidebar = document.querySelector('.sidebar');
        const body = document.body;

        sidebar.addEventListener('mouseenter', () => {
            body.classList.add('sidebar-expanded');
        });

        sidebar.addEventListener('mouseleave', () => {
            body.classList.remove('sidebar-expanded');
        });

        const tableBody = document.getElementById('usersTableBody');
        const searchInput = document.getElementById('searchInput');
        const API_BASE_URL = '';

        // --- CONFIGURAÇÃO DE AUTENTICAÇÃO E HEADERS ---
        const API_TOKEN = localStorage.getItem('admin_auth_token');
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        if (!API_TOKEN) {
            document.body.innerHTML = '<h1>Erro de Autenticação. Faça o login de administrador.</h1>';
            return;
        }

        const headers = {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'Authorization': `Bearer ${API_TOKEN}`,
            'X-CSRF-TOKEN': csrfToken
        };

        // --- FUNÇÕES AUXILIARES ---
        const openModal = (modalId) => document.getElementById(modalId).classList.add('show');
        const closeModal = (modalId) => document.getElementById(modalId).classList.remove('show');
        const formatDate = (dateString) => {
            if (!dateString) return 'N/A';
            const date = new Date(dateString);
            // Corrige o problema de fuso horário pegando a data em UTC
            return new Date(date.getUTCFullYear(), date.getUTCMonth(), date.getUTCDate())
                .toLocaleDateString('pt-BR', { year: 'numeric', month: 'long', day: 'numeric' });
        };
        const createUsername = (fullName) => !fullName ? '' : '@' + fullName.toLowerCase().replace(/\s+/g, '');
        const capitalize = (str) => str ? str.charAt(0).toUpperCase() + str.slice(1) : 'N/A';

        // --- LÓGICA PRINCIPAL ---
        async function fetchAndRenderUsers(searchTerm = '') {
            const listUrl = `${API_BASE_URL}/api/search-usuarios?pesquisa=${encodeURIComponent(searchTerm)}`;
            tableBody.innerHTML = '<tr><td colspan="7">Carregando...</td></tr>';

            try {
                const response = await fetch(listUrl);
                if (!response.ok) throw new Error(`Falha ao buscar dados: ${response.statusText}`);
                
                const result = await response.json();
                const users = result.data;

                tableBody.innerHTML = '';
                if (users.length === 0) {
                    tableBody.innerHTML = '<tr><td colspan="7">Nenhum usuário encontrado.</td></tr>';
                    return;
                }

                users.forEach(user => {
                    const row = document.createElement('tr');
                    row.dataset.user = JSON.stringify(user); 
                    row.innerHTML = `
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
                                <button class="action-btn view" title="Ver Detalhes"><ion-icon name="eye-outline"></ion-icon></button>
                                <button class="action-btn edit" title="Editar Usuário"><ion-icon name="pencil-outline"></ion-icon></button>
                                <button class="action-btn delete" title="Excluir Usuário"><ion-icon name="trash-outline"></ion-icon></button>
                            </div>
                        </td>
                    `;
                    tableBody.appendChild(row);
                });

            } catch (error) {
                console.error('Erro ao buscar usuários:', error);
                tableBody.innerHTML = '<tr><td colspan="7">Erro ao carregar os dados. Tente novamente.</td></tr>';
            }
        }

        // --- EVENT LISTENERS ---

        // Busca inicial e por digitação
        fetchAndRenderUsers();
        let debounceTimer;
        searchInput.addEventListener('keyup', () => {
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(() => fetchAndRenderUsers(searchInput.value), 300);
        });

        // Listener para os botões de ação na tabela (View, Edit, Delete)
        tableBody.addEventListener('click', (e) => {
            const viewBtn = e.target.closest('.action-btn.view');
            const editBtn = e.target.closest('.action-btn.edit');
            const deleteBtn = e.target.closest('.action-btn.delete');
            
            if (!viewBtn && !editBtn && !deleteBtn) return;

            const row = e.target.closest('tr');
            const user = JSON.parse(row.dataset.user);

            // *** LÓGICA PARA O BOTÃO VIEW ***
            if (viewBtn) {
                document.getElementById('viewUserName').textContent = user.nomeCompletoUsuario || 'N/A';
                document.getElementById('viewUserEmail').textContent = user.emailUsuario || 'N/A';
                document.getElementById('viewUserBirthdate').textContent = formatDate(user.dataNascimentoUsuario);
                document.getElementById('viewUserGender').textContent = capitalize(user.generoUsuario);
                document.getElementById('viewUserLocation').textContent = `${user.cidadeUsuario || 'Cidade não informada'}, ${user.estadoUsuario || 'Estado não informado'}`;
                document.getElementById('viewUserSince').textContent = formatDate(user.created_at);
                document.getElementById('viewUserHeight').textContent = user.alturaCm ? `${user.alturaCm} cm` : 'N/A';
                document.getElementById('viewUserWeight').textContent = user.pesoKg ? `${user.pesoKg} kg` : 'N/A';
                document.getElementById('viewUserFoot').textContent = capitalize(user.peDominante);
                document.getElementById('viewUserHand').textContent = capitalize(user.maoDominante);
                openModal('viewUserModal');
            }

            if (editBtn) {
                document.getElementById('editUserId').value = user.id;
                document.getElementById('editUserName').value = user.nomeCompletoUsuario;
                document.getElementById('editUserEmail').value = user.emailUsuario;
                openModal('editUserModal');
            }

            if (deleteBtn) {
                document.getElementById('deleteUserId').value = user.id;
                document.getElementById('deleteUserName').textContent = user.nomeCompletoUsuario;
                openModal('deleteUserModal');
            }
        });

        // Listener para o formulário de edição
        document.getElementById('editUserForm').addEventListener('submit', async (e) => {
            e.preventDefault();
            const userId = document.getElementById('editUserId').value;
            const body = JSON.stringify({
                nomeCompletoUsuario: document.getElementById('editUserName').value,
                emailUsuario: document.getElementById('editUserEmail').value
            });

            try {
                const response = await fetch(`${API_BASE_URL}/api/usuario/update/${userId}`, { method: 'PUT', headers, body });
                if (!response.ok) {
                    const err = await response.json();
                    throw new Error(err.message || 'Falha ao atualizar usuário.');
                }
                closeModal('editUserModal');
                fetchAndRenderUsers(searchInput.value);
                alert('Usuário atualizado com sucesso!');
            } catch (error) {
                alert(`Erro: ${error.message}`);
            }
        });

        // Listener para o botão de confirmação de exclusão
        document.getElementById('confirmDeleteBtn').addEventListener('click', async () => {
            const userId = document.getElementById('deleteUserId').value;
            try {
                const response = await fetch(`${API_BASE_URL}/api/usuario/delete/${userId}`, { method: 'DELETE', headers });
                if (!response.ok) {
                    const err = await response.json();
                    throw new Error(err.message || 'Falha ao excluir usuário.');
                }
                closeModal('deleteUserModal');
                fetchAndRenderUsers(searchInput.value);
                alert('Usuário excluído com sucesso!');
            } catch (error) {
                alert(`Erro: ${error.message}`);
            }
        });

        // Listeners para fechar os modais
        document.querySelectorAll('.modal-close-btn, .btn-secondary').forEach(btn => {
            const modalId = btn.getAttribute('data-modal-id');
            if (modalId) {
                btn.addEventListener('click', () => closeModal(modalId));
            }
        });
    });
    </script>       
</body>
</html>
