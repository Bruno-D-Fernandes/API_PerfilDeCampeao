<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <style>
        .hidden {
            display: none !important;
        }

        .container, .profile-info, #profile, .profile-details, .modal-body, .form-group, #oportunidade-view, #opportunities, #members-list, .members-list-group, .members-list-group-function, .members-list-rows, #adicionar-membro-view {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .tabs {
            display: flex;
            gap: 16px; 
        }

        .profile-imgs {
            width: 100%;
            height: 228px;
            position: relative;
        }

        .banner {
            width: 100%;
            height: 180px;
            background-color: #000;
        }

        .picture {
            height: 96px;
            aspect-ratio: 1 / 1;
            border-radius: 50%;
            background-color: #fff;
            border: 8px solid #fff;
            position: absolute;
            left: 48px;
            bottom: 0px;
        }
        
        .opportunity {
            width: 100%;
            height: 48px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: relative;
        }

        .opportunity-details {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .opportunity-options {
            display: flex;
            flex-direction: column;
            gap: 4px;
            position: absolute;
            top: 100%;
            right: 0;
            z-index: 100;
        }

        .modal-backdrop {
            width: 100%;
            height: 100%;
            position: fixed;
            top: 0;
            left: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 100;
        }

        .app-modal {
            width: 600px;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: #fff;
            z-index: 101;
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .modal-body {
            max-height: 300px;
            overflow-y: auto;
        }

        .close-modal-btn {
            width: 32px;
            height: 32px;
        }

        .modal-body, .form-group, #oportunidade-view {
            width: 100%;
        }

        .modal-footer {
            width: 100%;
            height: 48px;
            display: flex;
            justify-content: center;
            gap: 32px;
        }

        .modal-footer button {
            width: 50%;
            height: 100%;
        }

        #members-list, .members-list-group, .members-list-group-function, .members-list-rows, .members-list-row {
            width: 100%;
        }

        .members-list-header {
            width: 100%;
            height: 32px;
            display: flex;
            gap: 16px;
            align-items: center;
        }

        .members-list-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .no-data {
            width: 100%;
            min-height: 140px;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .search-user {
            display: flex;
            gap: 16px;
            align-items: center;
        }

        .search-user-container {
            width: 100%;
            max-height: 100px;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .search-user-row {
            width: 100%;
            flex-shrink: 0;
            background-color: #fafafa;
        }

        .user-selected {
            width: 100%;
            height: 48px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .profile-picture {
            height: 75%;
            aspect-ratio: 1 / 1;
            border-radius: 50%;
            background-color: #000;
        }

        .profile-picture img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .tab-content.active {
            display: block !important;
        }

        .tab-content {
            display: none !important;
        }

        #confirmar-modal {
            width: 420px;
        }
    </style>
</head>
<body>
    <div class="container" data-storage-url="{{ asset('/storage') }}">
        <h1>Clube</h1>

        <div id="profile">
            <div class="profile-info">
                <div class="profile-imgs">
                    <div class="banner">

                    </div>

                    <div class="picture">

                    </div>
                </div>

                <div class="profile-details">
                    <span class="profile-name">
                        {{ $clube->nomeClube }}
                    </span>

                    <span class="profile-bio">
                        {{ $clube->bioClube }}
                    </span>
                </div>
            </div>

            <div class="tabs">
                <button data-target-tab="opportunities">
                    <span>
                        Oportunidades
                    </span>
                </button>

                <button data-target-tab="members-list">
                    <span>
                        Membros
                    </span>
                </button>

                <button data-target-tab="about">
                    <span>
                        Sobre
                    </span>
                </button>
            </div>

            <div class="tab-container">
                <div id="opportunities" class="tab-content active">
                    @foreach($clube->oportunidades as $oportunidade)
                        <div class="opportunity" data-oportunidade-id="{{ $oportunidade->id }}">
                            <div class="opportunity-details">
                                <span>
                                    {{ $oportunidade->posicao->nomePosicao }}
                                </span>
                                
                                <span>
                                    {{ $oportunidade->esporte->nomeEsporte }}
                                </span>
                                
                                <span>
                                    Sub - {{ $oportunidade->idadeMaxima }}
                                </span>

                                <span>
                                    Interessados - {{ $oportunidade->candidatos->count() }}
                                </span>
                            </div>

                            <button class="see-details-btn">
                                <i class="fa-solid fa-ellipsis"></i>
                            </button>

                            <div class="opportunity-options hidden">
                                <button class="oportunidade-ver-btn">
                                    <span>
                                        Ver
                                    </span>
                                </button>

                                <button class="oportunidade-editar-btn">
                                    <span>
                                       Editar 
                                    </span>
                                </button>

                                <button class="oportunidade-excluir-btn">
                                    <span>
                                        Excluir
                                    </span>
                                </button>

                                <button class="oportunidade-inscritos-btn">
                                    <span>
                                        Inscritos
                                    </span>
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div id="members-list" class="tab-content">
                    <div class="members-list-header">
                        <input type="text" id="member-search-input" placeholder="Buscar membro">

                        <button id="add-member-btn">
                            <span>
                                Adicionar membro
                            </span>
                        </button>

                        <button class="clear-search-btn" type="button" data-clear-target="member-search-input">
                            <span>
                                Limpar busca
                            </span>
                        </button>
                    </div>

                    <div class="members-list-group">
                        @if(empty($membrosAgrupados))
                            <div class="no-data">
                                <span>
                                    Sem dados para mostrar
                                </span>
                            </div>
                        @else
                            @foreach($membrosAgrupados as $esporteNome => $funcoesNoEsporte)
                                <span>{{ $esporteNome }}:</span>

                                @foreach($funcoesNoEsporte as $funcaoNome => $listaDeMembrosPorFuncao) 
                                    <div class="members-list-group-function">
                                        <span>{{ $funcaoNome }}:</span>
                                        <div class="members-list-rows">
                                            @foreach($listaDeMembrosPorFuncao as $membro) 
                                                <div class="members-list-row" data-member-id="{{ $membro->id }}">
                                                    <span>
                                                        {{ $membro->nomeCompletoUsuario }}
                                                    </span>

                                                    <button class="member-view-btn" data-member-id="{{ $membro->id }}">
                                                        <span>
                                                            Ver perfil
                                                        </span>
                                                    </button>

                                                    <!--
                                                    
                                                    <button class="member-remove-btn" 
                                                        data-member-id="{{ $membro->id }}" 
                                                        data-esporte-id="{{ $membro->pivot->esporte_id }}"
                                                        data-funcao-id="{{ $membro->pivot->funcao_id }}">
                                                        <span>
                                                            Remover
                                                        </span>
                                                    </button>

                                                    -->
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal-backdrop hidden"></div>

    <div id="adicionar-membro-modal" class="app-modal hidden">
        <div class="modal-header">
            <h2 class="modal-title">Adicionar membro:</h2>
            <button class="close-modal-btn" data-modal-target="adicionar-membro-modal">&times;</button>
        </div>

        <form class="modal-body" id="adicionar-membro-form">
            <div id="adicionar-membro-view">
                <div class="search-user">
                    <input type="text" id="user-search-input" placeholder="Buscar usuário">
                        
                    <button class="clear-search-btn" type="button" data-clear-target="user-search-input">
                        <span>
                            Limpar busca
                        </span>
                    </button>
                </div>

                <div class="search-user-container">
                    <div class="search-user-row">
                        <span>
                            João
                        </span>
                    </div>
                    
                    <div class="search-user-row">
                        <span>
                            João
                        </span>
                    </div>

                    <div class="search-user-row">
                        <span>
                            João
                        </span>
                    </div>

                    <div class="search-user-row">
                        <span>
                            João
                        </span>
                    </div>

                    <div class="search-user-row">
                        <span>
                            João
                        </span>
                    </div>

                    <div class="search-user-row">
                        <span>
                            João
                        </span>
                    </div>

                    <div class="search-user-row">
                        <span>
                            João
                        </span>
                    </div>

                    <div class="search-user-row">
                        <span>
                            João
                        </span>
                    </div>

                    <div class="search-user-row">
                        <span>
                            João
                        </span>
                    </div>

                    <div class="search-user-row">
                        <span>
                            João
                        </span>
                    </div>
                </div>

                <div class="user-selected user-needed hidden">
                    <div class="profile-picture">

                    </div>

                    <span>
                        João
                    </span>
                </div>

                <div class="form-group user-needed hidden">
                    <label for="adicionar-membro-form-esporte">Esporte:</label>

                    <select name="esporte_id" id="adicionar-membro-form-esporte">
                        @foreach($esportes as $esporte)
                            <option value="{{ $esporte->id }}">{{ $esporte->nomeEsporte }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group user-needed hidden">
                    <label for="adicionar-membro-form-funcao">Função:</label>

                    <select name="funcao_id" id="adicionar-membro-form-funcao">
                        @foreach($funcoes as $funcao)
                            <option value="{{ $funcao->id }}">{{ $funcao->nome }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </form>

        <div class="modal-footer">
            <button id="adicionar-membro-cancelar-btn" disabled>
                <span>Cancelar</span>
            </button>

            <button id="adicionar-membro-salvar-btn" disabled type="button">
                <span>Salvar</span>
            </button>
        </div>
    </div>

    <div id="oportunidade-modal" class="app-modal hidden">
        <div class="modal-header">
            <h2 class="modal-title">Detalhes da Oportunidade:</h2>
            <button class="close-modal-btn" data-modal-target="oportunidade-modal">&times;</button>
        </div>

        <form class="modal-body" id="oportunidade-form">
            <div id="oportunidade-view">
                <div class="form-group"> 
                    <label for="descricaoOportunidades">Descrição:</label>
                    
                    <textarea name="oportunidade-form-descricao" id="oportunidade-form-descricao"></textarea> 
                </div>
                
                <div class="form-group">
                    <label for="oportunidade-form-data">Data de Postagem:</label>
                    
                    <input type="date" id="oportunidade-form-data" name="datapostagemOportunidades"> 
                </div> 

                <div class="form-group"> 
                    <label for="oportunidade-form-esporte">Esporte:</label>

                    <select name="esporte_id" id="oportunidade-form-esporte">
                        @foreach($esportes as $esporte)
                            <option value="{{ $esporte->id }}">{{ 
                                $esporte->nomeEsporte }}
                            </option> 
                        @endforeach 
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="oportunidade-form-posicao">Posição:</label>
                    
                    <select name="posicoes_id" id="oportunidade-form-posicao">
                        @foreach($posicoes as $posicao)
                            <option value="{{ $posicao->id }}">{{ $posicao->nomePosicao }}</option>
                        @endforeach 
                    </select> 
                </div> 
                
                <div class="form-group"> 
                    <label for="oportunidade-form-idade-minima">Idade mínima:</label> 
                    
                    <input type="number" id="oportunidade-form-idade-minima" name="idadeMinima" min="0"> 
                </div> 
                
                <div class="form-group"> 
                    <label for="oportunidade-form-idade-maxima">Idade máxima:</label> 
                    
                    <input type="number" id="oportunidade-form-idade-maxima" name="idadeMaxima" min="0"> 
                </div> 
                
                <div class="form-group"> 
                    <label for="oportunidade-form-endereco">Endereço:</label> 
                    
                    <input type="text" id="oportunidade-form-endereco" name="enderecoOportunidade"> 
                </div> 

                <div class="form-group"> 
                    <label for="oportunidade-form-cidade">Cidade:</label> 
                    
                    <input type="text" id="oportunidade-form-cidade" name="cidadeOportunidade"> 
                </div>
                
                <div class="form-group"> 
                    <label for="oportunidade-form-estado">Estado:</label>
                    
                    <input type="text" id="oportunidade-form-estado" name="estadoOportunidade"> 
                </div> 
                
                <div class="form-group"> 
                    <label for="oportunidade-form-cep">CEP:</label> 
                    
                    <input type="text" id="oportunidade-form-cep" name="cepOportunidade"> 
                </div>
            </div>
        </form>

        <div class="modal-footer">
            <button id="oportunidade-cancelar-btn" disabled>
                <span>Cancelar</span>
            </button>

            <button id="oportunidade-salvar-btn" disabled type="button">
                <span>Salvar</span>
            </button>
        </div>
    </div>

    <div id="confirmar-modal" class="app-modal hidden">
        <div class="modal-header">
            <h2 class="modal-title">Você deseja excluir esta função?</h3>
        </div>
        
        <div class="modal-body">
            <p class="modal-alert">
                Essa ação é irreversível.
            </p>
        </div>

        <div class="modal-footer">
            <button id="cancel-confirm-btn">
                <span>
                    Cancelar
                </span>
            </button>

            <button id="save-confirm-btn">
                <span>
                    Salvar
                </span>
            </button>
        </div>
    </div>

    <script>
        const BEARER = 'Bearer 1|iHMveTWB2oTTA95AGwQEpCYLunr48JDNXRY2k5V9e0068d3d';
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        const container = document.querySelector('.container');

        let oportunidadeId = -1;
        let readOnly = true;

        const storageUrl = container.dataset.storageUrl;

        const seeDetailsBtns = document.querySelectorAll('.see-details-btn');

        const opportunityOptions = document.querySelectorAll('.opportunity-options');

        const oportunidades = document.querySelector('#opportunities');

        document.addEventListener('click', (e) => {
            const openOptions = [...opportunityOptions].filter(opt => !opt.classList.contains('hidden'));

            if (openOptions.length === 0) return;

            openOptions.forEach(opt => {
                if (!opt.contains(e.target)) {
                    opt.classList.add('hidden');
                }
            });
        });

        oportunidades.addEventListener('click', (e) => {
            const btnEditar = e.target.closest('.oportunidade-editar-btn');
            const btnVer = e.target.closest('.oportunidade-ver-btn');
            const btnExcluir = e.target.closest('.oportunidade-excluir-btn');

            if (btnEditar) {
                readOnly = false;
                oportunidadeId = btnEditar.closest('.opportunity').dataset.oportunidadeId;
                enableInputs();
                fetchOportunidadeDetails(oportunidadeId);
                abrirModal(modalOportunidade);
            } else if (btnVer) {
                readOnly = true;
                oportunidadeId = btnVer.closest('.opportunity').dataset.oportunidadeId;
                disableInputs();
                fetchOportunidadeDetails(oportunidadeId);
                abrirModal(modalOportunidade);
            } else if (btnExcluir) {
                readOnly = false;
                oportunidadeId = btnExcluir.closest('.opportunity').dataset.oportunidadeId;
                criarConfirmacao('Deseja excluir esta oportunidade?', 'Essa ação é irreversível.', () => deleteOportunidade(oportunidadeId), () => {});
            } else {
                return;
            }
        });

        const salvarOportunidadeBtn = document.querySelector('#oportunidade-salvar-btn');
        const cancelarOportunidadeBtn = document.querySelector('#oportunidade-cancelar-btn');

        salvarOportunidadeBtn.addEventListener('click', () => {
            if(oportunidadeId !== -1) saveOportunidade(oportunidadeId); 
            else saveOportunidade();
        });

        cancelarOportunidadeBtn.addEventListener('click', () => fecharModal(modalOportunidade));
        
        seeDetailsBtns.forEach(seeDetailsBtn => {
            seeDetailsBtn.addEventListener('click', (e) => {
                e.stopPropagation();

                seeDetailsBtn.parentElement.querySelector('.opportunity-options').classList.toggle('hidden');
            });
        });

        const membersDataContainer = document.querySelector('.members-list-group');

        const searchInput = document.querySelector('#member-search-input');
        
        let timer;

        searchInput.addEventListener('input', function() {
            const query = this.value;

            clearTimeout(timer);

            timer = setTimeout(() => {
                searchMembers(query);
            }, 300);
        });

        const clearSearchBtns = document.querySelectorAll('.clear-search-btn');

        clearSearchBtns.forEach(clearSearchBtn => {
            clearSearchBtn.addEventListener('click', () => {
                const clearTgt = clearSearchBtn.dataset.clearTarget;

                document.querySelector(`#${clearTgt}`).value = '';

                if (clearTgt === 'member-search-input') {
                    searchMembers('');
                } else {
                    searchUsers('');
                    disableBtns();
                }
            });
        });

        const searchUserInput = document.querySelector('#user-search-input');
        const searchUserContainer = document.querySelector('.search-user-container');

        searchUsers('');

        let timer2;

        searchUserInput.addEventListener('input', function() {
            const query = this.value;

            clearTimeout(timer2);

            timer2 = setTimeout(() => {
                searchUsers(query);

                if (searchUserContainer.classList.contains('hidden')) {
                    searchUserContainer.classList.remove('hidden')
                }
            }, 300);
        });

        const hideUserNeeded = () => {
            document.querySelectorAll('.user-needed').forEach(item => {
                item.classList.add('hidden');
            });
        }

        const showUserNeeded = () => {
            document.querySelectorAll('.user-needed').forEach(item => {
                item.classList.remove('hidden');
            });
        }

        const addMemberBtn = document.querySelector('#add-member-btn');

        const modalBackdrop = document.querySelector('.modal-backdrop');

        const modais = {
            'oportunidade-modal': {
                content: document.querySelector('#oportunidade-modal'),
                inputs: [
                    document.querySelector('#oportunidade-form-descricao'),
                    document.querySelector('#oportunidade-form-data'),
                    document.querySelector('#oportunidade-form-esporte'),
                    document.querySelector('#oportunidade-form-posicao'),
                    document.querySelector('#oportunidade-form-idade-minima'),
                    document.querySelector('#oportunidade-form-idade-maxima'),
                    document.querySelector('#oportunidade-form-endereco'),
                    document.querySelector('#oportunidade-form-cidade'),
                    document.querySelector('#oportunidade-form-estado'),
                    document.querySelector('#oportunidade-form-cep'),
                ],
                type: 1,
            }, 'adicionar-membro-modal': {
                content: document.querySelector('#adicionar-membro-modal'),
                inputs: [
                    searchUserInput,
                    document.querySelector('#adicionar-membro-form-esporte'),
                    document.querySelector('#adicionar-membro-form-funcao'),
                ],
                type: 1,
            },
            'confirmar-modal': {
                content: document.querySelector('#confirmar-modal'),
                type: 3,
            },
        }

        const modalAdicionarMembro = modais['adicionar-membro-modal'];
        const modalOportunidade = modais['oportunidade-modal'];
        const modalConfirmar = modais['confirmar-modal'];

        const oportunidadeModalTitle = modalOportunidade.content.querySelector('.modal-title');
        const confirmarModalTitle = modalConfirmar.content.querySelector('.modal-title');

        const confirmarModalAlert = modalConfirmar.content.querySelector('.modal-alert');

        addMemberBtn.addEventListener('click', () => {
            abrirModal(modalAdicionarMembro);

            hideUserNeeded();
        });

        const closeModalBtns = document.querySelectorAll('.close-modal-btn');

        closeModalBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                const tgt = btn.dataset.modalTarget;
                fecharModal(modais[tgt]);
            });
        });

        const adicionarMembroBtn = document.querySelector('#adicionar-membro-salvar-btn');
        const cancelarMembroBtn = document.querySelector('#adicionar-membro-cancelar-btn');

        cancelarMembroBtn.addEventListener('click', () => {
            fecharModal(modalAdicionarMembro);
        });

        adicionarMembroBtn.addEventListener('click', () => {
            const usuarioId = modalAdicionarMembro.content.querySelector('.user-selected').dataset.usuarioId;
            const esporteId = modalAdicionarMembro.content.querySelector('#adicionar-membro-form-esporte').value;
            const funcaoId = modalAdicionarMembro.content.querySelector('#adicionar-membro-form-funcao').value;

            const dados = {
                usuario_id: usuarioId,
                esporte_id: esporteId,
                funcao_id: funcaoId,
            };

            fetch('../api/clube/1/membros/' + usuarioId, {
                method: 'POST',
                headers: {
                    'Authorization': `Bearer ${BEARER}`,
                    'X-CSRF-TOKEN': csrfToken,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify(dados)
            })
            .then(response => response.json())
            .then(data => {
                if (data.error || data.errors) {
                    console.error('Erro retornado pela API:', data);
                    alert('Erro ao adicionar membro ao clube.');
                } else {
                    console.log('Membro adicionado com sucesso:', data);
                    alert('Membro adicionado com sucesso!');
                }

                fecharModal(modalAdicionarMembro);
                searchMembers('');
            })
            .catch((error) => {
                console.error('Erro ao adicionar membro ao clube:', error);
            });
        });

        function criarConfirmacao(titulo, texto, funcaoSim, funcaoNao) {
            confirmarModalTitle.textContent = titulo;
            confirmarModalAlert.textContent = texto;

            const saveBtn = modalConfirmar.content.querySelector('#save-confirm-btn');
            const cancelBtn = modalConfirmar.content.querySelector('#cancel-confirm-btn');

            const newSaveBtn = saveBtn.cloneNode(true);
            saveBtn.parentNode.replaceChild(newSaveBtn, saveBtn);

            const newCancelBtn = cancelBtn.cloneNode(true);
            cancelBtn.parentNode.replaceChild(newCancelBtn, cancelBtn);

            abrirModal(modalConfirmar);

            newSaveBtn.addEventListener('click', () => {
                funcaoSim();
                fecharModal(modalConfirmar);
            });

            newCancelBtn.addEventListener('click', () => {
                funcaoNao();
                fecharModal(modalConfirmar);
            });
        }

        function disableBtns() {
            modalAdicionarMembro.content.querySelectorAll('button').forEach(btn => {
                if (btn.classList.contains('close-modal-btn')) return;

                const isClearSearchBtn = [...clearSearchBtns].some(
                    clearBtn => clearBtn === btn && clearBtn.dataset.clearTarget === 'user-search-input'
                );

                if (isClearSearchBtn) return;

                btn.disabled = true;
            });
        }

        function enableBtns() {
            modalAdicionarMembro.content.querySelectorAll('button').forEach(btn => {
                btn.disabled = false;
            });
        }

        function abrirModal(modal) {
            if (modal === modalAdicionarMembro) {
                searchUserContainer.classList.remove('hidden');
                searchUsers('');
                disableBtns();
            }

            modal.content.classList.remove('hidden');
            modalBackdrop.classList.remove('hidden');
        }

        function fecharModal(modal) {
            modal.content.classList.add('hidden');
            limparModal(modal);
            const algumAberto = Object.values(modais).some(m => !m.content.classList.contains('hidden'));
            if (!algumAberto) modalBackdrop.classList.add('hidden');
        }

        function limparModal(modal) {
            if (modal.inputs) modal.inputs.forEach(inp => {
                if (inp.tagName === 'SELECT' && (inp.id === 'adicionar-membro-form-esporte' || inp.id === 'adicionar-membro-form-funcao')) {
                    const firstOption = inp.querySelector('option');
                    if (firstOption) inp.value = firstOption.value;
                } else {
                    inp.value = '';
                }
            });
        }

        function disableInputs() {
            if (readOnly) {
                modalOportunidade.inputs.forEach(inp => inp.disabled = true);
                salvarOportunidadeBtn.disabled = true;
                cancelarOportunidadeBtn.disabled = true;
            }
        }

        function enableInputs() {
            modalOportunidade.inputs.forEach(inp => inp.disabled = false);
            salvarOportunidadeBtn.disabled = false;
            cancelarOportunidadeBtn.disabled = false;
        }

        const tabBtns = document.querySelectorAll('.tabs button');

        tabBtns.forEach(tabBtn => {
            tabBtn.addEventListener('click', () => {
                tabBtn.classList.add('active');
                document.querySelectorAll('.tab-content').forEach(tc => tc.classList.remove('active'));
                document.querySelector(`#${tabBtn.dataset.targetTab}`).classList.add('active');
            });
        });

        async function searchUsers(query) {
            if (searchUserContainer.classList.contains('hidden')) {
                searchUserContainer.classList.remove('hidden');
                hideUserNeeded();
            }

            const url = new URL('../api/search-usuarios', window.location.origin);

            if (query) url.searchParams.set('pesquisa', query);

            try {
                const response = await fetch(url,  {
                    headers: {
                        'Authorization': `Bearer ${BEARER}`,
                        'X-CSRF-TOKEN': csrfToken,
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                });

                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }

                const data = await response.json();

                searchUserContainer.innerHTML = '';

                renderUsersList(data.data);
            } catch(error) {
                console.error('Erro ao buscar membros do clube:', error);
            }
        }

        async function searchMembers(query) {
            try {
                const response = await fetch(`../api/clube/1/membros?search=${encodeURIComponent(query)}`,  {
                    headers: {
                    'Authorization': `Bearer ${BEARER}`,
                    'X-CSRF-TOKEN': csrfToken,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                    }
                });

                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }

                const data = await response.json();

                console.log(data);

                renderMembersList(data);
            } catch(error) {
                console.error('Erro ao buscar membros do clube:', error);
            }
        }

        async function fetchOportunidadeDetails(oportunidadeId) {
            try {
                const response = await fetch(`../api/clube/oportunidade/${oportunidadeId}`, {
                    headers: {
                        'Authorization': `Bearer ${BEARER}`,
                        'X-CSRF-TOKEN': csrfToken,
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    }
                });

                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }

                const data = await response.json();

                console.log(data);
                
                modalOportunidade.inputs[0].value = data.descricaoOportunidades;
                modalOportunidade.inputs[1].value = data.datapostagemOportunidades;
                modalOportunidade.inputs[2].value = data.esporte.id;
                modalOportunidade.inputs[3].value = data.posicao.id;
                modalOportunidade.inputs[4].value = data.idadeMinima;
                modalOportunidade.inputs[5].value = data.idadeMaxima;
                modalOportunidade.inputs[6].value = data.enderecoOportunidade;
                modalOportunidade.inputs[7].value = data.cidadeOportunidade;
                modalOportunidade.inputs[8].value = data.estadoOportunidade;
                modalOportunidade.inputs[9].value = data.cepOportunidade;
            } catch (error) {
                console.error('Erro ao buscar detalhes da oportunidade:', error);
                oportunidadeModalTitle.textContent = "Erro ao carregar oportunidade";
            }
        }

        async function saveOportunidade(oportunidadeId = null) {
            const editMode = oportunidadeId !== null;

            try {
                const url = '../api/clube/oportunidade/' + oportunidadeId;

                const formData = new FormData(document.querySelector('#oportunidade-form'));

                if (editMode) {
                    formData.append('_method', 'PUT');
                }

                const response = await fetch(url, {
                    method: 'POST',
                    headers: {
                        'Authorization': `Bearer ${BEARER}`,
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: formData
                });

                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }

                const data = await response.json();

                if(!data.error || !data.errors) {
                    alert('Oportunidade salva com sucesso!');

                    if (!editMode) {
                        oportunidades.appendChild(createOportunidadeRow(data.data));
                    } else {
                        const oldRow = oportunidades.querySelector(`.opportunity[data-oportunidade-id="${oportunidadeId}"]`);
                        const newRow = createOportunidadeRow(data.data);
                        oportunidades.replaceChild(newRow, oldRow);
                    }
                    
                    fecharModal(modalOportunidade);
                }                
            } catch (error) {
                console.error('Erro ao salvar oportunidade:', error);
                alert('Erro ao salvar oportunidade!');
            }
        }

        function renderUsersList(usuarios) {
            let htmlContent = '';

            const hasData = usuarios.length > 0;

            if (hasData) {
                for (const usuario of usuarios) {
                    htmlContent += `
                        <div class="search-user-row" 
                            data-id="${usuario.id}" 
                            data-nome="${usuario.nomeCompletoUsuario}" 
                            data-img="${usuario.fotoPerfilUsuario}">
                            <span>${usuario.nomeCompletoUsuario}</span>
                        </div>
                    `;
                }
            }

            searchUserContainer.innerHTML = htmlContent;

            const userRows = searchUserContainer.querySelectorAll('.search-user-row');

            userRows.forEach(row => {
                row.addEventListener('click', () => {
                    searchUserContainer.classList.add('hidden');

                    showUserNeeded();

                    enableBtns();

                    const userSelected = document.querySelector('.user-selected');

                    const nome = row.dataset.nome;
                    const img = row.dataset.img;

                    userSelected.dataset.usuarioId = row.dataset.id;
                    
                    userSelected.querySelector('span').textContent = nome;

                    const profilePicture = userSelected.querySelector('.profile-picture');

                    if (img !== "undefined") {
                        profilePicture.innerHTML = `<img src="${storageUrl}/${img}" alt="" />`;
                    } else {
                        profilePicture.innerHTML = '';
                    }

                    userSelected.classList.remove('hidden');
                });
            });
        }

        function renderMembersList(membrosAgrupados) {
            let htmlContent = '';

            const hasData = Object.keys(membrosAgrupados).length > 0;

            if (!hasData) {
                htmlContent = `
                    <div class="no-data">
                        <span>
                            Sem dados para mostrar
                        </span>
                    </div>
                `;
            } else {
                for (const esporteNome in membrosAgrupados) {
                    if (membrosAgrupados.hasOwnProperty(esporteNome)) {

                        htmlContent += `
                            <span>
                                ${esporteNome}:
                            </span>
                        `;

                        const funcoesNoEsporte = membrosAgrupados[esporteNome];

                        for (const funcaoNome in funcoesNoEsporte) {
                            if (funcoesNoEsporte.hasOwnProperty(funcaoNome)) {
                                
                                htmlContent += `
                                    <div class="members-list-group-function">
                                        <span>
                                            ${funcaoNome}:
                                        </span>

                                        <div class="members-list-rows">
                                `;

                                const membros = funcoesNoEsporte[funcaoNome];
                                
                                membros.forEach(membro => {         
                                    htmlContent += `
                                            <div class="members-list-row" data-member-id="${membro.id}">
                                                <span class="member-name">
                                                    ${membro.nomeCompletoUsuario}
                                                </span>

                                                <button class="member-view-btn" data-member-id="${membro.id}">
                                                    <span>
                                                        Ver perfil
                                                    </span>
                                                </button>
                                            </div>
                                    `;
                                });
                                htmlContent += `
                                        </div> 
                                    </div>
                                `;
                            }
                        }
                    }
                }
            }

            membersDataContainer.innerHTML = htmlContent;
        }

        async function deleteOportunidade(oportunidadeId) {
            try {
                const url = "../api/clube/oportunidade/" + oportunidadeId;

                const response = await fetch(url, {
                    method: 'DELETE',
                    headers: {
                        'Authorization': `Bearer ${BEARER}`,
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                });

                if (response.ok) {
                    if (response.status === 204) {
                        alert('Oportunidade excluída com sucesso!');
                        oportunidades.querySelector(`.opportunity[data-oportunidade-id="${oportunidadeId}"]`)?.remove();
                    } else {
                        const data = await response.json();

                        if (data.error || data.errors) {
                            console.error('Erro retornado pela API:', data);
                            alert('Erro ao excluir oportunidade');
                        } else {
                            alert('Oportunidade excluída com sucesso! (Obteve retorno de dados)');
                            oportunidades.querySelector(`.opportunity[data-oportunidade-id="${oportunidadeId}"]`)?.remove();
                        }
                    }
                } else {
                    console.error('Erro HTTP:', response.status, response.statusText);

                    try {
                        const errorData = await response.json();
                        alert(`Erro ao excluir clube: ${errorData.message || response.statusText}`);
                    } catch (jsonError) {
                        alert(`Erro ao excluir clube: ${response.statusText}`);
                    }
                }          
            } catch (error) {
                console.error('Erro ao excluir clube:', error);
                alert('Erro ao excluir clube!');
            }
        }

        function createOportunidadeRow(oportunidade) {
            const div = document.createElement('div');
            div.className = "opportunity";
            div.dataset.oportunidade = oportunidade.id;
            div.innerHTML = `
                <div class="opportunity-details">
                    <span>
                        ${oportunidade.posicao.nomePosicao}
                    </span>
                    <span>
                        ${oportunidade.esporte.nomeEsporte}
                    </span>
                    <span>
                        Sub - ${oportunidade.idadeMaxima}
                    </span>
                    <span>
                        Interessados - ${oportunidade.candidatos.length}
                    </span>
                </div>
                <button class="see-details-btn">
                    <i class="fa-solid fa-ellipsis"></i>
                </button>
                <div class="opportunity-options hidden">
                    <button class="oportunidade-ver-btn">
                        <span>
                            Ver
                        </span>
                    </button>
                    <button class="oportunidade-editar-btn">
                        <span>
                            Editar 
                        </span>
                    </button>
                    <button class="oportunidade-excluir-btn">
                        <span>
                            Excluir
                        </span>
                    </button>
                    <button class="oportunidade-inscritos-btn">
                        <span>
                            Inscritos
                        </span>
                    </button>
                </div>
            `;
            return div;
        }
    </script>
</body>
</html>