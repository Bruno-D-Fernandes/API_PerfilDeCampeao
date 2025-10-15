<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestão de Esportes</title>
    <link rel="stylesheet" href="css/esporte.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
</head>
<body>
    <div class="dashboard-container">
        <aside class="sidebar">
            <div class="sidebar-header">
                <img id="logo-expanded" src="{{ asset('img/logoPerfil.jpeg') }}" alt="Logo Completa">
                <ion-icon id="logo-collapsed" name="football-outline"></ion-icon>
            </div>

            <nav class="sidebar-nav">
                <ul>
                    <li><a href="dashAdm"><ion-icon name="grid-outline"></ion-icon> <span class="nav-text">Dashboard</span></a></li>
                    <li><a href="usuarios"><ion-icon name="people-outline"></ion-icon> <span class="nav-text">Usuários</span></a></li>
                    <li class="active"><a href="#"><ion-icon name="football-outline"></ion-icon> <span class="nav-text">Esportes</span></a></li>
                    <li><a href="oportunidadesAdm"><ion-icon name="rocket-outline"></ion-icon> <span class="nav-text">Oportunidades</span></a></li>
                </ul>
            </nav>

            <div class="sidebar-footer">
                <ul>
                    <li><a href="#" class="logout"><ion-icon name="log-out-outline"></ion-icon> <span class="nav-text">Sair</span></a></li>
                </ul>
            </div>
        </aside>

        <main class="main-content">
            <header class="main-header">
                <h2 class="page-title">Gestão de Esportes</h2>
            </header>

            <div class="content-body">
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
            </div>
        </main>
    </div>

    <div id="esporteModal" class="modal-overlay">
        <div class="modal-container">
            <form id="esporteForm">
                <div class="modal-header">
                    <h3 id="esporteModalTitle"></h3>
                    <button type="button" class="modal-close-btn" data-modal-id="esporteModal">&times;</button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="esporteId">
                    <div class="form-group">
                        <label for="nomeEsporte">Nome do Esporte</label>
                        <input type="text" id="nomeEsporte" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="descricaoEsporte">Descrição</label>
                        <textarea id="descricaoEsporte" class="form-control" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-modal-id="esporteModal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Salvar</button>
                </div>
            </form>
        </div>
    </div>

    <div id="posicoesManagerModal" class="modal-overlay">
        <div class="modal-container">
            <div class="modal-header">
                <h3 id="posicoesManagerTitle"></h3>
                <button type="button" class="modal-close-btn" data-modal-id="posicoesManagerModal">&times;</button>
            </div>
            <div class="modal-body">
                <p>Clique em uma posição para editar. Adicione ou remova posições para este esporte.</p>
                <ul id="posicoesList"></ul>
                <form id="addPosicaoForm">
                    <input type="hidden" id="posicaoManagerEsporteId">
                    <input type="text" id="newPosicaoName" class="form-control" placeholder="Nome da nova posição" required>
                    <button type="submit" class="btn btn-primary">Adicionar</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-modal-id="posicoesManagerModal">Fechar</button>
            </div>
        </div>
    </div>

    <div id="editPosicaoModal" class="modal-overlay">
        <div class="modal-container">
            <form id="editPosicaoForm">
                <div class="modal-header">
                    <h3>Editar Posição</h3>
                    <button type="button" class="modal-close-btn" data-modal-id="editPosicaoModal">&times;</button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="editPosicaoId">
                    <div class="form-group">
                        <label for="editPosicaoName">Nome da Posição</label>
                        <input type="text" id="editPosicaoName" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-modal-id="editPosicaoModal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Salvar</button>
                </div>
            </form>
        </div>
    </div>

    <div id="deleteConfirmModal" class="modal-overlay">
        <div class="modal-container">
            <div class="modal-header">
                <h3>Confirmar Exclusão</h3>
                <button type="button" class="modal-close-btn" data-modal-id="deleteConfirmModal">&times;</button>
            </div>
            <div class="modal-body">
                <p>Tem certeza que deseja excluir a posição "<strong id="deletePosicaoName"></strong>"?</p>
                <p>Esta ação não pode ser desfeita.</p>
            </div>
            <div class="modal-footer">
                <input type="hidden" id="deletePosicaoId">
                <button type="button" class="btn btn-secondary" data-modal-id="deleteConfirmModal">Cancelar</button>
                <button type="button" id="confirmDeleteBtn" class="btn btn-danger">Excluir</button>
            </div>
        </div>
    </div>

    <div id="deleteEsporteConfirmModal" class="modal-overlay">
        <div class="modal-container">
            <div class="modal-header">
                <h3>Confirmar Exclusão</h3>
                <button type="button" class="modal-close-btn" data-modal-id="deleteEsporteConfirmModal">&times;</button>
            </div>
            <div class="modal-body">
                <p>Tem certeza que deseja excluir o esporte "<strong id="deleteEsporteName"></strong>"?</p>
                <p>Todas as posições associadas a ele também serão excluídas. Esta ação não pode ser desfeita.</p>
            </div>
            <div class="modal-footer">
                <input type="hidden" id="deleteEsporteId">
                <button type="button" class="btn btn-secondary" data-modal-id="deleteEsporteConfirmModal">Cancelar</button>
                <button type="button" id="confirmDeleteEsporteBtn" class="btn btn-danger">Excluir</button>
            </div>
        </div>
    </div>

    <div id="notificationModal" class="modal-overlay">
        <div class="modal-container">
            <div class="modal-header">
                <h3 id="notificationTitle"></h3>
                <button type="button" class="modal-close-btn" data-modal-id="notificationModal">&times;</button>
            </div>
            <div class="modal-body">
                <p id="notificationMessage"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-modal-id="notificationModal">OK</button>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        // --- CONFIGURAÇÃO ---
        const API_TOKEN = localStorage.getItem('admin_auth_token');
        if (!API_TOKEN) {
            document.body.innerHTML = '<h1>Erro de Autenticação. Faça o login de administrador para acessar esta página.</h1>';
            return;
        }

        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        
        const headers = {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'Authorization': `Bearer ${API_TOKEN}`,
            'X-CSRF-TOKEN': csrfToken
        };

        const esportesTableBody = document.getElementById('esportesTableBody');
        const openModal = (modalId) => document.getElementById(modalId).classList.add('show');
        const closeModal = (modalId) => document.getElementById(modalId).classList.remove('show');

        function showNotification(title, message) {
            document.getElementById('notificationTitle').textContent = title;
            document.getElementById('notificationMessage').textContent = message;
            openModal('notificationModal');
        }

        // --- LÓGICA DE ESPORTES ---
        async function fetchEsportes() {
            try {
                const response = await fetch(`/api/admin/esporte`, { headers });
                if (!response.ok) throw new Error('Falha ao buscar esportes.');
                let esportes = await response.json();

                const searchTerm = document.getElementById('esporteSearchInput').value.toLowerCase();
                if (searchTerm) {
                    esportes = esportes.filter(esporte => esporte.nomeEsporte.toLowerCase().includes(searchTerm));
                }

                renderEsportes(esportes);
            } catch (error) {
                console.error(error);
                esportesTableBody.innerHTML = `<tr><td colspan="4">${error.message}</td></tr>`;
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
                row.dataset.esporte = JSON.stringify(esporte);
                row.innerHTML = `
                    <td>${esporte.nomeEsporte}</td>
                    <td>${esporte.descricaoEsporte || 'N/A'}</td>
                    <td>${new Date(esporte.created_at).toLocaleDateString('pt-BR')}</td>
                    <td>
                        <div class="action-buttons">
                            <button class="action-btn view-esporte" title="Ver Posições"><ion-icon name="eye-outline"></ion-icon></button>
                            <button class="action-btn edit-esporte" title="Editar Esporte"><ion-icon name="pencil-outline"></ion-icon></button>
                            <button class="action-btn delete-esporte" title="Excluir Esporte"><ion-icon name="trash-outline"></ion-icon></button>
                        </div>
                    </td>
                `;
                esportesTableBody.appendChild(row);
            });
        }

        document.getElementById('esporteForm').addEventListener('submit', async (e) => {
            e.preventDefault();
            const id = document.getElementById('esporteId').value;
            const url = id ? `/api/admin/esporte/${id}` : '/api/admin/esporte';
            const method = id ? 'PUT' : 'POST';
            const body = JSON.stringify({
                nomeEsporte: document.getElementById('nomeEsporte').value,
                descricaoEsporte: document.getElementById('descricaoEsporte').value,
            });
            try {
                const response = await fetch(url, { method, headers, body });
                if (!response.ok) {
                    const err = await response.json();
                    throw new Error(err.message || 'Falha ao salvar o esporte.');
                }
                closeModal('esporteModal');
                fetchEsportes();
            } catch (error) {
                showNotification('Erro', error.message);
            }
        });
        
        // Listener para o botão de confirmação de exclusão de ESPORTE
        document.getElementById('confirmDeleteEsporteBtn').addEventListener('click', async () => {
            const esporteId = document.getElementById('deleteEsporteId').value;
            try {
                const response = await fetch(`/api/admin/esporte/${esporteId}`, { method: 'DELETE', headers });
                if (!response.ok) {
                    const err = await response.json();
                    throw new Error(err.message || 'Falha ao excluir o esporte.');
                }
                closeModal('deleteEsporteConfirmModal');
                showNotification('Sucesso', 'O esporte foi excluído com sucesso.');
                fetchEsportes();
            } catch (error) {
                closeModal('deleteEsporteConfirmModal');
                showNotification('Erro', error.message);
            }
        });

        // --- LÓGICA DO GERENCIADOR DE POSIÇÕES ---
        async function openPosicaoManager(esporte) {
            document.getElementById('posicoesManagerTitle').textContent = `Posições de ${esporte.nomeEsporte}`;
            document.getElementById('posicaoManagerEsporteId').value = esporte.id;
            await fetchAndRenderPosicoes(esporte.id);
            openModal('posicoesManagerModal');
        }

        async function fetchAndRenderPosicoes(esporteId) {
            const posicoesList = document.getElementById('posicoesList');
            posicoesList.innerHTML = '<li>Carregando...</li>';
            try {
                const response = await fetch(`/api/admin/posicao?idEsporte=${esporteId}`, { headers });
                if (!response.ok) throw new Error('Não foi possível carregar as posições.');
                const posicoes = await response.json();
                
                posicoesList.innerHTML = '';
                if (posicoes.length === 0) {
                    posicoesList.innerHTML = '<li>Nenhuma posição cadastrada.</li>';
                    return;
                }
                posicoes.forEach(posicao => {
                    const li = document.createElement('li');
                    li.dataset.posicao = JSON.stringify(posicao);
                    li.innerHTML = `
                        <span class="posicao-name">${posicao.nomePosicao}</span>
                        <div class="action-buttons">
                            <button class="action-btn edit edit-posicao" title="Editar Posição"><ion-icon name="pencil-outline"></ion-icon></button>
                            <button class="action-btn delete delete-posicao" title="Excluir Posição"><ion-icon name="trash-outline"></ion-icon></button>
                        </div>
                    `;
                    posicoesList.appendChild(li);
                });
            } catch (error) {
                posicoesList.innerHTML = `<li>${error.message}</li>`;
            }
        }

        document.getElementById('addPosicaoForm').addEventListener('submit', async (e) => {
            e.preventDefault();
            const esporteId = document.getElementById('posicaoManagerEsporteId').value;
            const nomePosicao = document.getElementById('newPosicaoName').value;
            if (!nomePosicao.trim()) return;
            const body = JSON.stringify({ idEsporte: esporteId, nomePosicao });
            try {
                const response = await fetch('/api/admin/posicao', { method: 'POST', headers, body });
                if (!response.ok) {
                    const err = await response.json();
                    throw new Error(err.message || 'Falha ao adicionar posição.');
                }
                document.getElementById('newPosicaoName').value = '';
                fetchAndRenderPosicoes(esporteId);
            } catch (error) {
                showNotification('Erro', error.message);
            }
        });

        // --- EVENT LISTENERS GERAIS ---
        document.getElementById('addEsporteBtn').addEventListener('click', () => {
            document.getElementById('esporteForm').reset();
            document.getElementById('esporteId').value = '';
            document.getElementById('esporteModalTitle').textContent = 'Adicionar Novo Esporte';
            openModal('esporteModal');
        });

        document.getElementById('esportesTableBody').addEventListener('click', async (e) => {
            const row = e.target.closest('tr');
            if (!row || !row.dataset.esporte) return;
            const esporte = JSON.parse(row.dataset.esporte);

            if (e.target.closest('.view-esporte')) {
                openPosicaoManager(esporte);
            } else if (e.target.closest('.edit-esporte')) {
                document.getElementById('esporteId').value = esporte.id;
                document.getElementById('nomeEsporte').value = esporte.nomeEsporte;
                document.getElementById('descricaoEsporte').value = esporte.descricaoEsporte;
                document.getElementById('esporteModalTitle').textContent = 'Editar Esporte';
                openModal('esporteModal');
            } else if (e.target.closest('.delete-esporte')) {
                document.getElementById('deleteEsporteName').textContent = esporte.nomeEsporte;
                document.getElementById('deleteEsporteId').value = esporte.id;
                openModal('deleteEsporteConfirmModal');
            }
        });

        document.getElementById('posicoesList').addEventListener('click', (e) => {
            const li = e.target.closest('li');
            if (!li || !li.dataset.posicao) return;
            const posicao = JSON.parse(li.dataset.posicao);

            if (e.target.closest('.edit-posicao')) {
                document.getElementById('editPosicaoId').value = posicao.id;
                document.getElementById('editPosicaoName').value = posicao.nomePosicao;
                openModal('editPosicaoModal');
            } else if (e.target.closest('.delete-posicao')) {
                document.getElementById('deletePosicaoId').value = posicao.id;
                document.getElementById('deletePosicaoName').textContent = posicao.nomePosicao;
                openModal('deleteConfirmModal');
            }
        });

        document.getElementById('editPosicaoForm').addEventListener('submit', async (e) => {
            e.preventDefault();
            const posicaoId = document.getElementById('editPosicaoId').value;
            const novoNome = document.getElementById('editPosicaoName').value;
            const esporteId = document.getElementById('posicaoManagerEsporteId').value;
            if (!novoNome || !novoNome.trim()) return;
            const body = JSON.stringify({ nomePosicao: novoNome });
            try {
                const response = await fetch(`/api/admin/posicao/${posicaoId}`, { method: 'PUT', headers, body });
                if (!response.ok) {
                    const err = await response.json();
                    throw new Error(err.message || 'Falha ao atualizar.');
                }
                closeModal('editPosicaoModal');
                fetchAndRenderPosicoes(esporteId);
            } catch (error) {
                showNotification('Erro', error.message);
            }
        });

        document.getElementById('confirmDeleteBtn').addEventListener('click', async () => {
            const posicaoId = document.getElementById('deletePosicaoId').value;
            const esporteId = document.getElementById('posicaoManagerEsporteId').value;
            try {
                const response = await fetch(`/api/admin/posicao/${posicaoId}`, { method: 'DELETE', headers });
                if (!response.ok) {
                    const err = await response.json();
                    throw new Error(err.message || 'Falha ao excluir.');
                }
                closeModal('deleteConfirmModal');
                fetchAndRenderPosicoes(esporteId);
            } catch (error) {
                showNotification('Erro', error.message);
            }
        });

        // Listeners para fechar todos os modais
        document.querySelectorAll('.modal-close-btn, .btn-secondary, .btn-primary[data-modal-id]').forEach(btn => {
            const modalId = btn.getAttribute('data-modal-id');
            if (modalId) {
                btn.addEventListener('click', () => closeModal(modalId));
            }
        });
        
        document.getElementById('esporteSearchInput').addEventListener('keyup', fetchEsportes);

        // Carga inicial
        fetchEsportes();
    });
    </script>
</body>
</html>