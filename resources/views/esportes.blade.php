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
        <!-- BARRA LATERAL (Sem alterações) -->
        <aside class="sidebar">
            <div class="sidebar-header">
                 <img id="Logo" src="{{ asset('img/logoPerfil.jpeg') }}" alt="Logo do Perfil">
            </div>
            <nav class="sidebar-nav">
                <span class="menu-title">Menu</span>
                <ul>
                    <li><a href="dashAdm"><ion-icon name="grid-outline"></ion-icon> Dashboard</a></li>
                    <li><a href="usuarios"><ion-icon name="people-outline"></ion-icon> Usuários</a></li>
                    <li class="active"><a href="#"><ion-icon name="football-outline"></ion-icon> Esportes</a></li>
                    <li><a href=""><ion-icon name="rocket-outline"></ion-icon> Oportunidades</a></li>
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

    <!-- MODAL PARA ADICIONAR/EDITAR ESPORTE -->
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

    <!-- MODAL GERENCIADOR DE POSIÇÕES -->
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
            alert(error.message);
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
            alert(error.message);
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
        if (!row) return;
        const esporte = JSON.parse(row.dataset.esporte);

        if (e.target.closest('.edit-esporte')) {
            document.getElementById('esporteId').value = esporte.id;
            document.getElementById('nomeEsporte').value = esporte.nomeEsporte;
            document.getElementById('descricaoEsporte').value = esporte.descricaoEsporte;
            document.getElementById('esporteModalTitle').textContent = 'Editar Esporte';
            openModal('esporteModal');
            return;
        }
        if (e.target.closest('.delete-esporte')) {
            if (confirm(`Tem certeza que deseja excluir o esporte "${esporte.nomeEsporte}"?`)) {
                try {
                    const response = await fetch(`/api/admin/esporte/${esporte.id}`, { method: 'DELETE', headers });
                    if (!response.ok) {
                         const err = await response.json();
                         throw new Error(err.message || 'Falha ao excluir.');
                    }
                    fetchEsportes();
                } catch (error) {
                    alert(error.message);
                }
            }
            return;
        }
        openPosicaoManager(esporte);
    });

    // *** LISTENER CORRIGIDO E COMPLETO PARA O MODAL DE POSIÇÕES ***
     document.getElementById('posicoesList').addEventListener('click', (e) => {
            const li = e.target.closest('li');
            if (!li || !li.dataset.posicao) return;

            const posicao = JSON.parse(li.dataset.posicao);

            if (e.target.closest('.edit-posicao')) {
                document.getElementById('editPosicaoId').value = posicao.id;
                document.getElementById('editPosicaoName').value = posicao.nomePosicao;
                openModal('editPosicaoModal');
            }

            if (e.target.closest('.delete-posicao')) {
                document.getElementById('deletePosicaoId').value = posicao.id;
                document.getElementById('deletePosicaoName').textContent = posicao.nomePosicao;
                openModal('deleteConfirmModal');
            }
        });

        // Listener para o formulário de edição de posição
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
                alert(error.message);
            }
        });

        // Listener para o botão de confirmação de exclusão
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
                alert(error.message);
            }
        });

        // Listeners para fechar todos os modais
        document.querySelectorAll('.modal-close-btn, .btn-secondary').forEach(btn => {
            const modalId = btn.getAttribute('data-modal-id');
            if (modalId) {
                btn.addEventListener('click', () => closeModal(modalId));
            }
        });

    document.querySelectorAll('.modal-close-btn, .btn-secondary').forEach(btn => {
        btn.addEventListener('click', () => closeModal(btn.closest('.modal-overlay').id));
    });
    
    document.getElementById('esporteSearchInput').addEventListener('keyup', fetchEsportes);

    // Carga inicial
    fetchEsportes();
});
</script>
    </script>
</body>
</html>
