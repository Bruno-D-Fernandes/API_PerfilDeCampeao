<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Gerenciar Oportunidades</title>
    <link rel="stylesheet" href="./css/oportunidadesClub.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
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
    <div class="container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="logo-section">
                <img id="Logo" src="{{ asset('img/logoPerfil.jpeg') }}" alt="Logo do Perfil">
            </div>
            
            <nav class="nav-menu">
                <ul>
                    <li class="nav-item">
                        <a href="dashClub" class="nav-link">
                            <span class="nav-icon"><img class="nav-icon" src="./img/dashboard.png" alt=""></span>
                            <span class="nav-text">Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-item active">
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

        <!-- Conteúdo Principal -->
        <main class="main-content">
            <header class="main-header">
                <h2 class="page-title">Gerenciar Oportunidades</h2>
                <div class="user-menu">
                    <button class="icon-button"><ion-icon name="notifications-outline"></ion-icon></button>
                    <div class="user-profile">
                        <div class="avatar"><ion-icon name="person-outline"></ion-icon></div>
                        <span>Clube</span>
                    </div>
                </div>
            </header>

            <div class="content-body">
                <div class="toolbar">
                    <div class="search-bar">
                        <ion-icon name="search-outline"></ion-icon>
                        <input type="text" id="searchInput" placeholder="Pesquisar por descrição...">
                    </div>
                    <button class="filter-button">
                        <ion-icon name="filter-outline"></ion-icon>
                        Ordenar por
                    </button>
                    <button class="add-button" id="openModalBtn">Adicionar Oportunidade</button>
                </div>

                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>Esporte</th>
                                <th>Posição</th>
                                <th>Descrição</th>
                                <th>Idade</th>
                                <th>Localização</th>
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

    <!-- Modal de Cadastro/Edição -->
    <div id="opportunityModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="modalTitle">Nova Oportunidade</h3>
                <button class="close-modal" id="closeModalBtn">&times;</button>
            </div>

            <div id="successMessage" class="success-message" style="display: none;"></div>

            <form id="opportunityForm">
                <div class="form-group">
                    <label for="esporte_id">Esporte *</label>
                    <select id="esporte_id" name="esporte_id" required>
                        <option value="">Selecione um esporte</option>
                    </select>
                    <div class="error-message" id="error_esporte_id"></div>
                </div>

                <div class="form-group">
                    <label for="posicoes_id">Posição *</label>
                    <select id="posicoes_id" name="posicoes_id" required disabled>
                        <option value="">Selecione primeiro um esporte</option>
                    </select>
                    <div class="error-message" id="error_posicoes_id"></div>
                </div>

                <div class="form-group">
                    <label for="descricaoOportunidades">Descrição *</label>
                    <textarea id="descricaoOportunidades" name="descricaoOportunidades" required placeholder="Descreva a oportunidade..."></textarea>
                    <div class="error-message" id="error_descricaoOportunidades"></div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="idadeMinima">Idade Mínima</label>
                        <input type="number" id="idadeMinima" name="idadeMinima" min="0" max="120" placeholder="Ex: 16">
                        <div class="error-message" id="error_idadeMinima"></div>
                    </div>

                    <div class="form-group">
                        <label for="idadeMaxima">Idade Máxima</label>
                        <input type="number" id="idadeMaxima" name="idadeMaxima" min="0" max="120" placeholder="Ex: 25">
                        <div class="error-message" id="error_idadeMaxima"></div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="estadoOportunidade">Estado</label>
                        <input type="text" id="estadoOportunidade" name="estadoOportunidade" maxlength="2" placeholder="Ex: SP">
                        <div class="error-message" id="error_estadoOportunidade"></div>
                    </div>

                    <div class="form-group">
                        <label for="cidadeOportunidade">Cidade</label>
                        <input type="text" id="cidadeOportunidade" name="cidadeOportunidade" maxlength="100" placeholder="Ex: São Paulo">
                        <div class="error-message" id="error_cidadeOportunidade"></div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="enderecoOportunidade">Endereço</label>
                    <input type="text" id="enderecoOportunidade" name="enderecoOportunidade" maxlength="255" placeholder="Rua, número, bairro">
                    <div class="error-message" id="error_enderecoOportunidade"></div>
                </div>

                <div class="form-group">
                    <label for="cepOportunidade">CEP</label>
                    <input type="text" id="cepOportunidade" name="cepOportunidade" maxlength="9" placeholder="00000-000">
                    <div class="error-message" id="error_cepOportunidade"></div>
                </div>

                <button type="submit" class="submit-button" id="submitBtn">Cadastrar Oportunidade</button>
            </form>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // --- LÓGICA DA SIDEBAR EXPANSÍVEL ---
        const sidebar = document.querySelector('.sidebar');
        const body = document.body;
        sidebar.addEventListener('mouseenter', () => body.classList.add('sidebar-expanded'));
        sidebar.addEventListener('mouseleave', () => body.classList.remove('sidebar-expanded'));

        // --- VARIÁVEIS GLOBAIS ---
        const tableBody = document.getElementById('opportunitiesTableBody');
        const modal = document.getElementById('opportunityModal');
        const openModalBtn = document.getElementById('openModalBtn');
        const closeModalBtn = document.getElementById('closeModalBtn');
        const opportunityForm = document.getElementById('opportunityForm');
        const esporteSelect = document.getElementById('esporte_id');
        const posicaoSelect = document.getElementById('posicoes_id');
        const successMessage = document.getElementById('successMessage');

        // Usar o token do clube (prefixo clube)
        const API_TOKEN = localStorage.getItem('token');

        if (!API_TOKEN) {
            alert('Erro de Autenticação. Faça o login como clube.');
            return;
        }

        const authHeaders = {
            'Authorization': `Bearer ${API_TOKEN}`,
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        };

        // --- FUNÇÕES AUXILIARES ---
        const formatDate = (dateString) => {
            if (!dateString) return 'N/A';
            return new Date(dateString).toLocaleDateString('pt-BR', {
                day: '2-digit', month: 'long', year: 'numeric'
            });
        };

        const showSuccess = (message) => {
            successMessage.textContent = message;
            successMessage.style.display = 'block';
            setTimeout(() => {
                successMessage.style.display = 'none';
            }, 5000);
        };

        const clearErrors = () => {
            document.querySelectorAll('.error-message').forEach(el => el.textContent = '');
        };

        const showErrors = (errors) => {
            clearErrors();
            for (const [field, messages] of Object.entries(errors)) {
                const errorEl = document.getElementById(`error_${field}`);
                if (errorEl) {
                    errorEl.textContent = messages.join(', ');
                }
            }
        };

        // --- MODAL ---
        openModalBtn.addEventListener('click', () => {
            modal.classList.add('active');
            opportunityForm.reset();
            clearErrors();
            successMessage.style.display = 'none';
            posicaoSelect.disabled = true;
            posicaoSelect.innerHTML = '<option value="">Selecione primeiro um esporte</option>';
        });

        closeModalBtn.addEventListener('click', () => {
            modal.classList.add('active');
        });

        modal.addEventListener('click', (e) => {
            if (e.target === modal) {
                modal.classList.remove('active');
            }
        });

        // --- CARREGAR ESPORTES ---
        async function loadEsportes() {
            try {
                const response = await fetch('/api/clube/esporte', { headers: authHeaders });
                if (!response.ok) throw new Error('Falha ao buscar esportes.');
                
                const esportes = await response.json();
                
                esporteSelect.innerHTML = '<option value="">Selecione um esporte</option>';
                esportes.forEach(esporte => {
                    const option = document.createElement('option');
                    option.value = esporte.id;
                    option.textContent = esporte.nomeEsporte;
                    esporteSelect.appendChild(option);
                });
            } catch (error) {
                console.error('Erro ao carregar esportes:', error);
                alert('Erro ao carregar esportes. Verifique sua conexão.');
            }
        }

        // --- CARREGAR POSIÇÕES BASEADO NO ESPORTE ---
        esporteSelect.addEventListener('change', async function() {
            const esporteId = this.value;
            
            if (!esporteId) {
                posicaoSelect.disabled = true;
                posicaoSelect.innerHTML = '<option value="">Selecione primeiro um esporte</option>';
                return;
            }

            try {
                const response = await fetch(`/api/clube/posicao?idEsporte=${esporteId}`, { headers: authHeaders });
                if (!response.ok) throw new Error('Falha ao buscar posições.');
                
                const posicoes = await response.json();
                
                posicaoSelect.innerHTML = '<option value="">Selecione uma posição</option>';
                posicoes.forEach(posicao => {
                    const option = document.createElement('option');
                    option.value = posicao.id;
                    option.textContent = posicao.nomePosicao;
                    posicaoSelect.appendChild(option);
                });
                
                posicaoSelect.disabled = false;
            } catch (error) {
                console.error('Erro ao carregar posições:', error);
                alert('Erro ao carregar posições. Verifique sua conexão.');
            }
        });

        // --- CADASTRAR OPORTUNIDADE ---
        opportunityForm.addEventListener('submit', async function(e) {
            e.preventDefault();
            clearErrors();

            const formData = {
                descricaoOportunidades: document.getElementById('descricaoOportunidades').value,
                datapostagemOportunidades: new Date().toISOString().split('T')[0],
                esporte_id: parseInt(document.getElementById('esporte_id').value),
                posicoes_id: parseInt(document.getElementById('posicoes_id').value),
                idadeMinima: document.getElementById('idadeMinima').value ? parseInt(document.getElementById('idadeMinima').value) : null,
                idadeMaxima: document.getElementById('idadeMaxima').value ? parseInt(document.getElementById('idadeMaxima').value) : null,
                estadoOportunidade: document.getElementById('estadoOportunidade').value || null,
                cidadeOportunidade: document.getElementById('cidadeOportunidade').value || null,
                enderecoOportunidade: document.getElementById('enderecoOportunidade').value || null,
                cepOportunidade: document.getElementById('cepOportunidade').value || null,
            };

            const submitBtn = document.getElementById('submitBtn');
            submitBtn.disabled = true;
            submitBtn.textContent = 'Cadastrando...';

            try {
                const response = await fetch('/api/clube/oportunidade', {
                    method: 'POST',
                    headers: authHeaders,
                    body: JSON.stringify(formData)
                });

                const data = await response.json();

                if (!response.ok) {
                    if (data.errors) {
                        showErrors(data.errors);
                    } else {
                        alert(data.message || 'Erro ao cadastrar oportunidade.');
                    }
                    return;
                }

                showSuccess('Oportunidade cadastrada com sucesso!');
                opportunityForm.reset();
                posicaoSelect.disabled = true;
                posicaoSelect.innerHTML = '<option value="">Selecione primeiro um esporte</option>';
                
                // Recarregar a lista de oportunidades
                fetchOpportunities();

                // Fechar modal após 2 segundos
                setTimeout(() => {
                    modal.classList.remove('active');
                }, 2000);

            } catch (error) {
                console.error('Erro ao cadastrar oportunidade:', error);
                alert('Erro ao cadastrar oportunidade. Verifique sua conexão.');
            } finally {
                submitBtn.disabled = false;
                submitBtn.textContent = 'Cadastrar Oportunidade';
            }
        });

        // --- BUSCAR E RENDERIZAR OPORTUNIDADES ---
        async function fetchOpportunities() {
            tableBody.innerHTML = '<tr><td colspan="7">Carregando...</td></tr>';
            try {
                const response = await fetch('/api/clube/oportunidades', { headers: authHeaders });
                if (!response.ok) throw new Error('Falha ao buscar oportunidades.');
                
                const result = await response.json();
                const opportunities = result.data || result;

                if (opportunities.length === 0) {
                    tableBody.innerHTML = '<tr><td colspan="7">Nenhuma oportunidade encontrada.</td></tr>';
                    return;
                }

                renderTable(opportunities);

            } catch (error) {
                console.error('Erro ao carregar dados:', error);
                tableBody.innerHTML = `<tr><td colspan="7">Erro ao carregar: ${error.message}</td></tr>`;
            }
        }

        function renderTable(data) {
            tableBody.innerHTML = '';
            data.forEach(op => {
                const idadeRange = op.idadeMinima || op.idadeMaxima 
                    ? `${op.idadeMinima || '?'} - ${op.idadeMaxima || '?'} anos`
                    : 'Não especificado';
                
                const localizacao = op.cidadeOportunidade && op.estadoOportunidade
                    ? `${op.cidadeOportunidade}/${op.estadoOportunidade}`
                    : op.cidadeOportunidade || op.estadoOportunidade || 'Não especificado';

                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${op.esporte ? op.esporte.nomeEsporte : 'N/A'}</td>
                    <td>${op.posicao ? op.posicao.nomePosicao : 'N/A'}</td>
                    <td>${op.descricaoOportunidades}</td>
                    <td>${idadeRange}</td>
                    <td>${localizacao}</td>
                    <td>${formatDate(op.datapostagemOportunidades)}</td>
                    <td>
                        <div class="action-buttons">
                            <button class="action-btn view" title="Visualizar" onclick="viewOpportunity(${op.id})">
                                <ion-icon name="eye-outline"></ion-icon>
                            </button>
                            <button class="action-btn edit" title="Editar" onclick="editOpportunity(${op.id})">
                                <ion-icon name="pencil-outline"></ion-icon>
                            </button>
                            <button class="action-btn delete" title="Excluir" onclick="deleteOpportunity(${op.id})">
                                <ion-icon name="trash-outline"></ion-icon>
                            </button>
                        </div>
                    </td>
                `;
                tableBody.appendChild(row);
            });
        }

        // --- FUNÇÕES DE AÇÃO (VIEW, EDIT, DELETE) ---
        window.viewOpportunity = function(id) {
            alert(`Visualizar oportunidade ${id} - Funcionalidade a ser implementada`);
        };

        window.editOpportunity = function(id) {
            alert(`Editar oportunidade ${id} - Funcionalidade a ser implementada`);
        };

        window.deleteOpportunity = async function(id) {
            if (!confirm('Tem certeza que deseja excluir esta oportunidade?')) {
                return;
            }

            try {
                const response = await fetch(`/api/clube/oportunidade/${id}`, {
                    method: 'DELETE',
                    headers: authHeaders
                });

                if (!response.ok) {
                    const data = await response.json();
                    alert(data.message || 'Erro ao excluir oportunidade.');
                    return;
                }

                alert('Oportunidade excluída com sucesso!');
                fetchOpportunities();

            } catch (error) {
                console.error('Erro ao excluir oportunidade:', error);
                alert('Erro ao excluir oportunidade. Verifique sua conexão.');
            }
        };

        // --- INICIALIZAÇÃO ---
        loadEsportes();
        fetchOpportunities();
    });
    </script>
</body>
</html>

