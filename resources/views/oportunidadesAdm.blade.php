<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Lista de Oportunidades</title>
    <link rel="stylesheet" href="{{ url('css/oportunidadesAdm.css') }}">
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
                <img id="logo-expanded" src="{{ asset('img/logoPerfil.jpeg') }}" alt="Logo Completa">
                <ion-icon id="logo-collapsed" name="football-outline"></ion-icon>
            </div>

            <nav class="sidebar-nav">
                <ul>
                    <li><a href="dashAdm"><ion-icon name="grid-outline"></ion-icon> <span class="nav-text">Dashboard</span></a></li>
                    <li><a href="usuarios"><ion-icon name="people-outline"></ion-icon> <span class="nav-text">Usuários</span></a></li>
                    <li><a href="esporte"><ion-icon name="football-outline"></ion-icon> <span class="nav-text">Esportes</span></a></li>
                    <li class="active"><a href="oportunidadesAdm"><ion-icon name="rocket-outline"></ion-icon> <span class="nav-text">Oportunidades</span></a></li>
                </ul>
            </nav>

            <div class="sidebar-footer">
                <ul>
                    <li><a href="#" class="logout"><ion-icon name="log-out-outline"></ion-icon> <span class="nav-text">Sair</span></a></li>
                </ul>
            </div>
        </aside>

        <!-- ======================= -->
        <!--    CONTEÚDO PRINCIPAL   -->
        <!-- ======================= -->
        <main class="main-content">
            <header class="main-header">
                <h2 class="page-title">Lista de oportunidades</h2>
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

    <!-- MODAL PARA EDITAR OPORTUNIDADE -->
    <div id="editOpportunityModal" class="modal-overlay">
        <div class="modal-container">
            <form id="editOpportunityForm">
                <div class="modal-header">
                    <h3>Editar Oportunidade</h3>
                    <button type="button" class="modal-close-btn" data-modal-id="editOpportunityModal">&times;</button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="editOpportunityId">
                    <div class="form-group">
                        <label for="editDescricao">Descrição</label>
                        <textarea id="editDescricao" class="form-control" rows="4" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="editClube">Clube</label>
                        <input type="text" id="editClube" class="form-control" readonly>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-modal-id="editOpportunityModal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Salvar Alterações</button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL PARA CONFIRMAR EXCLUSÃO -->
    <div id="deleteOpportunityModal" class="modal-overlay">
        <div class="modal-container">
            <div class="modal-header">
                <h3>Confirmar Exclusão</h3>
                <button type="button" class="modal-close-btn" data-modal-id="deleteOpportunityModal">&times;</button>
            </div>
            <div class="modal-body">
                <p>Tem certeza que deseja excluir esta oportunidade?</p>
                <p><strong id="deleteOpportunityName"></strong></p>
                <p>Esta ação não pode ser desfeita.</p>
            </div>
            <div class="modal-footer">
                <input type="hidden" id="deleteOpportunityId">
                <button type="button" class="btn btn-secondary" data-modal-id="deleteOpportunityModal">Cancelar</button>
                <button type="button" id="confirmDeleteBtn" class="btn btn-danger">Excluir</button>
            </div>
        </div>
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

        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

        const authHeaders = {
            'Authorization': `Bearer ${API_TOKEN}`,
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        };

        if (csrfToken) {
            authHeaders['X-CSRF-TOKEN'] = csrfToken;
        }

        // Função para formatar a data
        const formatDate = (dateString) => {
            if (!dateString) return 'N/A';
            return new Date(dateString).toLocaleDateString('pt-BR', {
                day: '2-digit', month: 'long', year: 'numeric'
            });
        };

        // Função para abrir modal
        const openModal = (modalId) => {
            document.getElementById(modalId).classList.add('show');
        };

        // Função para fechar modal
        const closeModal = (modalId) => {
            document.getElementById(modalId).classList.remove('show');
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
                                op.participants_count = 0;
                                return op;
                            }
                            const participantsResult = await participantsResponse.json();
                            op.participants_count = participantsResult.total || 0;
                            return op;
                        } catch (e) {
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
            tableBody.innerHTML = '';
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
                            <button class="action-btn view" title="Visualizar" onclick="viewOpportunity(${op.id})"><ion-icon name="eye-outline"></ion-icon></button>
                            <button class="action-btn edit" title="Editar" onclick="editOpportunity(${op.id})"><ion-icon name="pencil-outline"></ion-icon></button>
                            <button class="action-btn delete" title="Excluir" onclick="deleteOpportunity(${op.id}, '${op.descricaoOportunidades.substring(0, 50)}...')"><ion-icon name="trash-outline"></ion-icon></button>
                        </div>
                    </td>
                `;
                tableBody.appendChild(row);
            });
        }

        // Função para visualizar oportunidade
        window.viewOpportunity = function(id) {
            alert('Funcionalidade de visualização em desenvolvimento. ID: ' + id);
        };

        // Função para editar oportunidade
        window.editOpportunity = async function(id) {
            try {
                const response = await fetch(`/api/admin/oportunidades`, { headers: authHeaders });
                if (!response.ok) throw new Error('Falha ao buscar oportunidade.');
                
                const result = await response.json();
                const opportunities = result.data || result;
                const opportunity = opportunities.find(op => op.id === id);

                if (!opportunity) throw new Error('Oportunidade não encontrada.');

                document.getElementById('editOpportunityId').value = opportunity.id;
                document.getElementById('editDescricao').value = opportunity.descricaoOportunidades;
                document.getElementById('editClube').value = opportunity.clube ? opportunity.clube.nomeClube : 'Clube não informado';
                
                openModal('editOpportunityModal');
            } catch (error) {
                console.error('Erro ao buscar oportunidade:', error);
                alert('Erro ao carregar dados da oportunidade.');
            }
        };

        // Função para deletar oportunidade
        window.deleteOpportunity = function(id, description) {
            document.getElementById('deleteOpportunityId').value = id;
            document.getElementById('deleteOpportunityName').textContent = description;
            openModal('deleteOpportunityModal');
        };

        // Submissão do formulário de edição
        document.getElementById('editOpportunityForm').addEventListener('submit', async (e) => {
            e.preventDefault();
            const id = document.getElementById('editOpportunityId').value;
            const data = {
                descricaoOportunidades: document.getElementById('editDescricao').value
            };

            try {
                const response = await fetch(`/api/admin/oportunidade/${id}`, {
                    method: 'PUT',
                    headers: authHeaders,
                    body: JSON.stringify(data)
                });

                if (response.ok) {
                    closeModal('editOpportunityModal');
                    fetchOpportunities();
                    alert('Oportunidade atualizada com sucesso!');
                } else {
                    throw new Error('Falha ao atualizar oportunidade.');
                }
            } catch (error) {
                console.error('Erro ao atualizar oportunidade:', error);
                alert('Erro ao atualizar oportunidade.');
            }
        });

        // Confirmação de exclusão
        document.getElementById('confirmDeleteBtn').addEventListener('click', async () => {
            const id = document.getElementById('deleteOpportunityId').value;

            try {
                const response = await fetch(`/api/admin/oportunidade/${id}`, {
                    method: 'DELETE',
                    headers: authHeaders
                });

                if (response.ok) {
                    closeModal('deleteOpportunityModal');
                    fetchOpportunities();
                    alert('Oportunidade excluída com sucesso!');
                } else {
                    throw new Error('Falha ao excluir oportunidade.');
                }
            } catch (error) {
                console.error('Erro ao excluir oportunidade:', error);
                alert('Erro ao excluir oportunidade.');
            }
        });

        // Fechar modais
        document.querySelectorAll('[data-modal-id]').forEach(btn => {
            btn.addEventListener('click', () => {
                const modalId = btn.getAttribute('data-modal-id');
                closeModal(modalId);
            });
        });

        // Inicia o carregamento dos dados
        fetchOpportunities();
    });
    </script>
</body>
</html>

