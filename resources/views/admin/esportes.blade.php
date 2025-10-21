<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        .hidden {
            display: none !important;
        }

        .esportes {
            width: 100%;
            height: 100%;
            display: flex;
            flex-direction: column;
            gap: 16px;/
        }

        .esportes-header {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .esporte, .list-header {
            width: 100%;
            display: grid;
            gap: 16px;
            grid-template-columns: 2fr 3fr 1fr 1fr 2fr 2fr;
        }

        .header-col {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .header-col > span {
            font-size: 16px;
        }

        .esporte > div {
            display: flex;
            align-items: center;
            justify-content: center;
        } 

        .esporte-acoes {
            display: flex;
            gap: 16px
        }

        #modal-backdrop {
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

        .close-modal-btn {
            width: 32px;
            height: 32px;
        }

        .modal-body, .form-group, .tab-content, .posicoes-list-container, .caracteristicas-list-container,
        #esporte-view, #posicao-view, #caracteristica-view {
            width: 100%;
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .tab-content.active {
            display: block;
            max-height: 450px;
            overflow-y: auto;
        }

        .tab-content {
            display: none;
        }

        .tab-header {
            width: 100%;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .posicoes-list-header, .posicoes-list-row, .caracteristicas-list-header, .caracteristicas-list-row {
            width: 100%;
            display: grid;
            gap: 16px;
            grid-template-columns: 1.5fr 2.5fr 1fr;
        }

        .posicoes-header-col, .posicao-col, .caracteristicas-header-row, .caracteristica-col {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .posicao-col.acoes {
            display: flex;
            gap: 16px;
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

        #posicao-modal, #caracteristica-modal {
            width: 400px;
        }
    </style>
</head>
<body>
    <div class="esportes">
        <div class="esportes-header">
            <h1>Esportes</h1>

            <button id="esporte-add-btn">
                <span>
                    Adicionar esporte
                </span>
            </button>
        </div>

        <div class="list-header">
            <div class="header-col">
                <span>Nome</span>
            </div>

            <div class="header-col">
                <span>Descrição</span>
            </div>

            <div class="header-col">
                <span>Posições</span>
            </div>

            <div class="header-col">
                <span>Características</span>
            </div>

            <div class="header-col">
                <span>Data de cadastro</span>
            </div>

            <div class="header-col">
                <span>Ações</span>
            </div>
        </div>

        @foreach($esportes as $esporte)
            <div class="esporte" data-esporte-id="{{ $esporte->id }}">
                <div class="esporte-nome">
                    <span>{{ $esporte->nomeEsporte }}</span>
                </div>

                <div class="esporte-descricao">
                    <span>{{ $esporte->descricaoEsporte ?? 'Sem descrição' }}</span>
                </div>

                <div class="esporte-posicoes">
                    <span>{{ $esporte->posicoes->count() }}</span>
                </div>

                <div class="esporte-caracteristicas">
                    <span>{{ $esporte->caracteristicas->count() }}</span>
                </div>

                <div class="esporte-cadastro">
                    <span>
                        {{ \Carbon\Carbon::parse($esporte->created_at)
                            ->locale('pt_BR')
                            ->translatedFormat('d \d\e F')
                        }}
                    </span>
                </div>

                <div class="esporte-acoes">
                    <button class="esporte-ver-btn">
                        <span>Ver</span>
                    </button>

                    <button class="esporte-atualizar-btn">
                        <span>Atualizar</span>
                    </button>

                    <button class="esporte-excluir-btn">
                        <span>Excluir</span>
                    </button>
                </div>
            </div>
        @endforeach
    </div>

    <div id="modal-backdrop" class="hidden"></div>

    <div id="esporte-modal" class="app-modal hidden">
        <div class="modal-header">
            <h2 class="modal-title">Adicionar esporte</h2>
            <button class="close-modal-btn" data-modal-target="esporte-modal">&times;</button>
        </div>

        <form class="modal-body" id="esporte-form">
            <div id="esporte-view">
                <div class="form-group">
                    <label for="esporte-form-nome">Nome:</label>

                    <input type="text" name="nomeEsporte" id="esporte-form-nome">
                </div>

                <div class="form-group">
                    <label for="esporte-form-descricao">Descrição:</label>

                    <input type="text" name="descricaoEsporte" id="esporte-form-descricao">
                </div>
            </div>

            <div class="modal-tabs">
                <button class="tab-button active" data-target-tab="posicoes-tab" type="button">
                    <span>
                        Posições
                    </span>
                </button>

                <button class="tab-button" data-target-tab="caracteristicas-tab" type="button">
                    <span>
                        Características
                    </span>
                </button>
            </div>

            <div id="posicoes-tab" class="tab-content active">
                <div class="tab-header">
                    <h3>Posições</h3>

                    <button id="posicao-add-btn" type="button">
                        <span>
                            Adicionar posições
                        </span>
                    </button>
                </div>

                <div class="posicoes-list-container">
                    <div class="posicoes-list-header">
                        <div class="posicoes-header-col">
                            <span>Nome</span>
                        </div>

                        <div class="posicoes-header-col">
                            <span>Descrição</span>
                        </div>

                        <div class="posicoes-header-col">
                            <span>Ações</span>
                        </div>
                    </div>

                    <div class="posicoes-list-row">
                        <div class="posicao-col nome">
                            <span>Atacante</span>
                        </div>

                        <div class="posicao-col descricao">
                            <span>Faz gols</span>
                        </div>

                        <div class="posicao-col acoes">
                            <button class="posicao-atualizar-btn" type="button"><span>Editar</span></button>
                            <button class="posicao-excluir-btn" type="button"><span>Excluir</span></button>
                        </div>
                    </div>
                </div>
            </div>

            <div id="caracteristicas-tab" class="tab-content">
                <div class="tab-header">
                    <h3>Características</h3>

                    <button id="caracteristica-add-btn" type="button">
                        <span>
                            Adicionar característica
                        </span>
                    </button>
                </div>

                <div class="caracteristicas-list-container">
                    <div class="caracteristicas-list-header">
                        <div class="caracteristicas-header-col">
                            <span>Nome</span>
                        </div>

                        <div class="caracteristicas-header-col">
                            <span>Descrição</span>
                        </div>

                        <div class="caracteristicas-header-col">
                            <span>Ação</span>
                        </div>
                    </div>

                    <div class="caracteristicas-list-row">
                        <div class="caracteristica-col">
                            <span>Atacante</span>
                        </div>

                        <div class="caracteristica-col">
                            <span>Faz gols</span>
                        </div>

                        <div class="caracteristica-col">
                            <button class="caracteristica-editar-btn" type="button"><span>Editar</span></button>
                            <button class="caracteristica-excluir-btn" type="button"><span>Excluir</span></button>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        <div class="modal-footer">
            <button id="esporte-cancelar-btn">
                <span>Cancelar</span>
            </button>

            <button id="esporte-salvar-btn">
                <span>Salvar</span>
            </button>
        </div>
    </div>

    <div id="posicao-modal" class="app-modal hidden">
        <div class="modal-header">
            <h2 class="modal-title">Adicionar posição</h2>
            <button class="close-modal-btn" data-modal-target="posicao-modal">&times;</button>
        </div>

        <form class="modal-body" id="posicao-form">
            <div id="posicao-view">
                <div class="form-group">
                    <label for="posicao-form-nome">Nome:</label>

                    <input type="text" name="nomePosicao" id="posicao-form-nome">
                </div>
            </div>
        </form>

        <div class="modal-footer">
            <button id="posicao-cancelar-btn">
                <span>Cancelar</span>
            </button>

            <button id="posicao-salvar-btn">
                <span>Salvar</span>
            </button>
        </div>
    </div>

    <div id="caracteristica-modal" class="app-modal hidden">
        <div class="modal-header">
            <h2 class="modal-title">Adicionar característica</h2>
            <button class="close-modal-btn" data-modal-target="caracteristica-modal">&times;</button>
        </div>

        <form class="modal-body" id="caracteristica-form">
            <div id="caracteristica-view">
                <div class="form-group">
                    <label for="caracteristica-form-caracteristica">Característica:</label>

                    <input type="text" name="caracteristica" id="caracteristica-form-caracteristica">
                </div>

                <div class="form-group">
                    <label for="caracteristica-form-unidade">Unidade de medida:</label>

                    <input type="text" name="unidade_medida" id="caracteristica-form-unidade">
                </div>
            </div>
        </form>

        <div class="modal-footer">
            <button id="caracteristica-cancelar-btn">
                <span>Cancelar</span>
            </button>

            <button id="caracteristica-salvar-btn">
                <span>Salvar</span>
            </button>
        </div>
    </div>

    <script>
        const BEARER = '2|cePsgspuAroUD23dl2OGyAtz9CLBA8cjxM4WAq3x1403cff6';

        const esportes = document.querySelector('.esportes');

        let esporteId = -1;
        let posicaoId = -1;
        let caracteristicaId = -1;

        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        let readOnly = true;

        const modalBackdrop = document.querySelector('#modal-backdrop');

        const modais = {
            'esporte-modal': {
                content: document.querySelector('#esporte-modal'),
                inputs: [
                    document.querySelector('#esporte-form-nome'),
                    document.querySelector('#esporte-form-descricao'),
                ],
            },

            'posicao-modal': {
                content: document.querySelector('#posicao-modal'),
                inputs: [
                    document.querySelector('#posicao-form-nome'),
                ],
            },
            
            'caracteristica-modal': {
                content: document.querySelector('#caracteristica-modal'),
                inputs: [
                    document.querySelector('#caracteristica-form-caracteristica'),
                    document.querySelector('#caracteristica-form-unidade'),
                ],
            },
        }

        const modalEsporte = modais['esporte-modal'];
        const modalPosicao = modais['posicao-modal'];
        const modalCaracteristica = modais['caracteristica-modal'];
        const esporteModalTitle = modalEsporte.content.querySelector('.modal-title');
        const posicaoModalTitle = modalPosicao.content.querySelector('.modal-title');
        const caracteristicaModalTitle = modalPosicao.content.querySelector('.modal-title');
        const posicoesListContainer = modalEsporte.content.querySelector('.posicoes-list-container');
        const caracteristicasListContainer = modalEsporte.content.querySelector('.caracteristicas-list-container');

        const abrirModal = (modal) => {
            modal.content.classList.remove('hidden');
            modalBackdrop.classList.remove('hidden');
        }

        const fecharModal = (modal) => {
            modal.content.classList.add('hidden');

            limparModal(modal);

            modalBackdrop.classList.add('hidden');
        }

        const closeModalBtns = document.querySelectorAll('.close-modal-btn');

        closeModalBtns.forEach(closeBtn => {
            closeBtn.addEventListener('click', () => {
                const tgt = closeBtn.dataset.modalTarget;
                fecharModal(modais[tgt]);
            });
        });

        const modalTabs = document.querySelector('.modal-tabs');
        const tabBtns = modalTabs.querySelectorAll('.tab-button');

        const changeTabs = (targetTabId) => {
            const tabContents = document.querySelectorAll('.tab-content');

            tabBtns.forEach(tabBtn => {
                tabBtn.classList.remove('active');
            });

            tabContents.forEach(tabContent => {
                tabContent.classList.remove('active');
            });

            const newTabContent = document.querySelector(`#${targetTabId}`);
            if (newTabContent) {
                newTabContent.classList.add('active');
            }
        }

        tabBtns.forEach(tabBtn => {
            tabBtn.addEventListener('click', () => {
                tabBtn.classList.add('active');
                changeTabs(tabBtn.dataset.targetTab);
            });
        });

        const addEsporteBtn = document.querySelector('#esporte-add-btn');
        const addPosicaoBtn = document.querySelector('#posicao-add-btn');
        const addCaracteristicaBtn = document.querySelector('#caracteristica-add-btn');

        const editPosicaoBtns = document.querySelectorAll('.posicao-editar-btn');
        const deletePosicaoBtns = document.querySelectorAll('.posicao-excluir-btn');

        const editCaracteristicaBtns = document.querySelectorAll('.caracteristica-editar-btn');
        const deleteCaracteristicaBtns = document.querySelectorAll('.caracteristica-excluir-btn');

        const disableInputs = () => {
            modalEsporte.inputs[0].disabled = true;
            modalEsporte.inputs[1].disabled = true;
            addPosicaoBtn.disabled = true;
            addCaracteristicaBtn.disabled = true;
            editPosicaoBtns.forEach(editPosicaoBtn => editPosicaoBtn.disabled = true);
            deletePosicaoBtns.forEach(deletePosicaoBtn => deletePosicaoBtn.disabled = true);
            editCaracteristicaBtns.forEach(editCaracteristicaBtn => editCaracteristicaBtn.disabled = true);
            deleteCaracteristicaBtns.forEach(deleteCaracteristicaBtn => deleteCaracteristicaBtn.disabled = true);
        }

        const enableInputs = () => {
            modalEsporte.inputs[0].disabled = false;
            modalEsporte.inputs[1].disabled = false;
            addPosicaoBtn.disabled = false;
            addCaracteristicaBtn.disabled = false;
            editPosicaoBtns.forEach(editPosicaoBtn => editPosicaoBtn.disabled = false);
            deletePosicaoBtns.forEach(deletePosicaoBtn => deletePosicaoBtn.disabled = false);
            editCaracteristicaBtns.forEach(editCaracteristicaBtn => editCaracteristicaBtn.disabled = false);
            deleteCaracteristicaBtns.forEach(deleteCaracteristicaBtn => deleteCaracteristicaBtn.disabled = false);
        }

        addEsporteBtn.addEventListener('click', () => {
            disableInputs();
            abrirModal(modais['esporte-modal']);
        });

        addPosicaoBtn.addEventListener('click', () => abrirModal(modais['posicao-modal']));

        addCaracteristicaBtn.addEventListener('click', () => abrirModal(modais['caracteristica-modal']));

        const verEsportesBtns = document.querySelectorAll('.esporte-ver-btn');

        verEsportesBtns.forEach(verEsporteBtn => {
            verEsporteBtn.addEventListener('click', (e) => {
                esporteId = e.target.closest('.esporte').dataset.esporteId;

                fetchEsporteDetails(Number(esporteId));

                abrirModal(modais['esporte-modal']);
            });
        });

        const atualizarEsportesBtns = document.querySelectorAll('.esporte-atualizar-btn');

        atualizarEsportesBtns.forEach(atualizarEsportesBtn => {
            atualizarEsportesBtn.addEventListener('click', (e) => {
                esporteId = e.target.closest('.esporte').dataset.esporteId;

                fetchEsporteDetails(Number(esporteId));

                readOnly = false;
                enableInputs();

                abrirModal(modais['esporte-modal']);
            });
        });

        const salvarEsporteBtn = document.querySelector('#esporte-salvar-btn');
        const cancelarEsporteBtn = document.querySelector('#esporte-cancelar-btn');

        salvarEsporteBtn.addEventListener('click', () => {
            if (esporteId !== -1){
                saveEsporte(esporteId);
            } else {
                saveEsporte();
            }
        });

        const salvarPosicaoBtn = document.querySelector('#posicao-salvar-btn');
        const cancelarPosicaoBtn = document.querySelector('#posicao-cancelar-btn');

        salvarPosicaoBtn.addEventListener('click', () => {
            if (posicaoId !== -1){
                savePosicao(posicaoId);
            } else {
                savePosicao();
            }
        });

        posicoesListContainer.addEventListener('click', (e) => {
            const btn = e.target.closest('.posicao-editar-btn');

            if (!btn) return;

            posicaoId = btn.closest('.posicoes-list-row').dataset.posicaoId;

            fetchPosicaoDetails(posicaoId);

            abrirModal(modais['posicao-modal']);
        });

        const salvarCaracteristicaBtn = document.querySelector('#caracteristica-salvar-btn');
        const cancelarCaracteristicaBtn = document.querySelector('#caracteristica-cancelar-btn');

        salvarCaracteristicaBtn.addEventListener('click', () => {
            if (caracteristicaId !== -1){
                saveCaracteristica(caracteristicaId);
            } else {
                saveCaracteristica();
            }
        });

        caracteristicasListContainer.addEventListener('click', (e) => {
            const btn = e.target.closest('.caracteristica-editar-btn');

            if (!btn) return;

            caracteristicaId = btn.closest('.caracteristicas-list-row').dataset.caracteristicaId;

            fetchCaracteristicaDetails(caracteristicaId);

            abrirModal(modais['caracteristica-modal']);
        });

        async function saveCaracteristica(caracteristicaId = null) {
            const editMode = caracteristicaId !== null;

            try {
                const url = editMode ? '../api/admin/caracteristica/' + caracteristicaId : "../api/admin/caracteristica/";

                const formData = new FormData(document.querySelector('#caracteristica-form'));

                formData.append('esporte_id', esporteId);

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
                    alert('Característica salva com sucesso!');

                    if (!editMode) {
                        document.querySelector('.caracteristicas-list-container').appendChild(createCaracteristicaRow(data));
                    } else {
                        const oldRow = document.querySelector('.caracteristicas-list-container').querySelector(`.caracteristicas-list-row[data-caracteristica-id="${caracteristicaId}"]`);
                        const newRow = createCaracteristicaRow(data);
                        document.querySelector('.caracteristicas-list-container').replaceChild(newRow, oldRow);
                    }

                    fecharModal(modais['caracteristica-modal']);
                }                
            } catch (error) {
                console.error('Erro ao salvar caracteristica:', error);
                alert('Erro ao salvar caracteristica!');
            }
        }

        async function savePosicao(posicaoId = null) {
            const editMode = posicaoId !== null;

            try {
                const url = editMode ? '../api/admin/posicao/' + posicaoId : "../api/admin/posicao/";

                const formData = new FormData(document.querySelector('#posicao-form'));

                formData.append('idEsporte', esporteId);

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
                    alert('Posição salvo com sucesso!');

                    if (!editMode) {
                        document.querySelector('.posicoes-list-container').appendChild(createPosicaoRow(data));
                    } else {
                        const oldRow = document.querySelector('.posicoes-list-container').querySelector(`.posicoes-list-row[data-posicao-id="${posicaoId}"]`);
                        const newRow = createPosicaoRow(data);
                        document.querySelector('.posicoes-list-container').replaceChild(newRow, oldRow);
                    }

                    fecharModal(modais['posicao-modal']);
                }                
            } catch (error) {
                console.error('Erro ao salvar posição:', error);
                alert('Erro ao salvar posição!');
            }
        }

        async function saveEsporte(esporteId = null) {
            const editMode = esporteId !== null;

            try {
                const url = editMode ? '../api/admin/esporte/' + esporteId : "../api/admin/esporte/";

                const formData = new FormData(document.querySelector('#esporte-form'));

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
                    alert('Esporte salvo com sucesso!');

                    if (!editMode) {
                        esportes.appendChild(createEsporteRow(data));
                    } else {
                        const oldRow = esportes.querySelector(`.esporte[data-esporte-id="${esporteId}"]`);
                        const newRow = createEsporteRow(data);
                        esportes.replaceChild(newRow, oldRow);
                    }
                    
                    fecharModal(modais['esporte-modal']);
                }                
            } catch (error) {
                console.error('Erro ao salvar esporte:', error);
                alert('Erro ao salvar esporte!');
            }
        }

        async function fetchCaracteristicaDetails(caracteristicaId) {
            try {
                const response = await fetch(`../api/admin/caracteristica/${caracteristicaId}`, {
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
                
                caracteristicaModalTitle.textContent = `Detalhes da Característica: ${data.caracteristica}`;

                document.querySelector('#caracteristica-form-caracteristica').value = data.caracteristica;
                document.querySelector('#caracteristica-form-unidade').value = data.unidade_medida;
            } catch (error) {
                console.error('Erro ao buscar detalhes da característica:', error);
                caracteristicaModalTitle.textContent = "Erro ao carregar característica";
            }
        }

        async function fetchPosicaoDetails(posicaoId) {
            try {
                const response = await fetch(`../api/admin/posicao/${posicaoId}`, {
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
                
                posicaoModalTitle.textContent = `Detalhes da Posição: ${data.nomePosicao}`;

                document.querySelector('#posicao-form-nome').value = data.nomePosicao;
            } catch (error) {
                console.error('Erro ao buscar detalhes da posição:', error);
                posicaoModalTitle.textContent = "Erro ao carregar posição";
            }
        }

        async function fetchEsporteDetails(esporteId) {
            try {
                const response = await fetch(`../api/admin/esporte/${esporteId}`, {
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
                
                esporteModalTitle.textContent = `Detalhes do Esporte: ${data.nomeEsporte}`;

                modalEsporte.inputs[0].value = data.nomeEsporte;
                modalEsporte.inputs[1].value = data.descricaoEsporte;

                posicoesListContainer.innerHTML = `
                    <div class="posicoes-list-header">
                        <div class="posicoes-header-col"><span>Nome</span></div>
                        <div class="posicoes-header-col"><span>Descrição</span></div>
                        <div class="posicoes-header-col"><span>Ações</span></div>
                    </div>
                `;

                if (data.posicoes && data.posicoes.length > 0) {
                    data.posicoes.forEach(posicao => {
                        posicoesListContainer.innerHTML += `
                            <div class="posicoes-list-row" data-posicao-id="${posicao.id}">
                                <div class="posicao-col nome"><span>${posicao.nomePosicao}</span></div>
                                <div class="posicao-col descricao"><span>${posicao.descricaoPosicao || 'N/A'}</span></div>
                                <div class="posicao-col acoes">
                                    <button class="posicao-editar-btn" data-posicao-id="${posicao.id}" ${readOnly ? 'disabled="true"' : ''} type="button"><span>Editar</span></button>
                                    <button class="posicao-excluir-btn" data-posicao-id="${posicao.id}" ${readOnly ? 'disabled="true"' : ''} type="button"><span>Excluir</span></button>
                                </div>
                            </div>
                        `;
                    });
                }

                caracteristicasListContainer.innerHTML = `
                    <div class="caracteristicas-list-header">
                        <div class="caracteristicas-header-col"><span>Nome</span></div>
                        <div class="caracteristicas-header-col"><span>Unidade</span></div>
                        <div class="caracteristicas-header-col"><span>Ações</span></div>
                    </div>
                `;
                
                if (data.caracteristicas && data.caracteristicas.length > 0) {
                    data.caracteristicas.forEach(caracteristica => {
                        caracteristicasListContainer.innerHTML += `
                            <div class="caracteristicas-list-row" data-caracteristica-id="${caracteristica.id}">
                                <div class="caracteristica-col"><span>${caracteristica.caracteristica}</span></div>
                                <div class="caracteristica-col"><span>${caracteristica.unidade_medida || 'N/A'}</span></div>
                                <div class="caracteristica-col">
                                    <button class="caracteristica-editar-btn" data-caracteristica-id="${caracteristica.id}" ${readOnly ? 'disabled="true"' : ''} type="button"><span>Editar</span></button>
                                    <button class="caracteristica-excluir-btn" data-caracteristica-id="${caracteristica.id}" ${readOnly ? 'disabled="true"' : ''} type="button"><span>Excluir</span></button>
                                </div>
                            </div>
                        `;
                    });
                }
            } catch (error) {
                console.error('Erro ao buscar detalhes do esporte:', error);
                esporteModalTitle.textContent = "Erro ao carregar esporte";
                posicoesListContainer.innerHTML = '<p style="color: red;">Não foi possível carregar as posições.</p>';
                caracteristicasListContainer.innerHTML = '<p style="color: red;">Não foi possível carregar as características.</p>';
            }
        }

        function limparModal(modal) {
            modal.inputs.forEach(inp => {
                inp.value = ""; 
            });
        }

        function createEsporteRow(esporte) {
            const div = document.createElement('div');
            div.className = "esporte";
            div.dataset.esporteId = esporte.id;

            div.innerHTML = `
                <div class="esporte-nome">
                    <span>${esporte.nomeEsporte}</span>
                </div>

                <div class="esporte-descricao">
                    <span>${esporte.descricaoEsporte ? esporte.descricaoEsporte : "Sem descrição"}</span>
                </div>

                <div class="esporte-posicoes">
                    <span>${esporte.posicoes.length}</span>
                </div>

                <div class="esporte-caracteristicas">
                    <span>${esporte.caracteristicas.length}</span>
                </div>

                <div class="esporte-cadastro">
                    <span>
                        ${formatarDataPortugues(new Date().toISOString())}
                    </span>
                </div>

                <div class="esporte-acoes">
                    <button class="esporte-ver-btn">
                        <span>Ver</span>
                    </button>

                    <button class="esporte-editar-btn">
                        <span>Atualizar</span>
                    </button>

                    <button class="esporte-excluir-btn">
                        <span>Excluir</span>
                    </button>
                </div>
            `;

            return div;
        }

        function createPosicaoRow(posicao) {
            const div = document.createElement('div');
            div.className = "posicoes-list-row";
            div.dataset.posicaoId = posicao.id;

            div.innerHTML = `
                <div class="posicao-col nome">
                    <span>${posicao.nomePosicao}</span>
                </div>

                <div class="posicao-col descricao">
                    <span>N/A</span>
                </div>

                <div class="posicao-col acoes">
                    <button class="posicao-editar-btn" type="button"><span>Editar</span></button>
                    <button class="posicao-excluir-btn" type="button"><span>Excluir</span></button>
                </div>
            `;

            return div;
        }

        function createCaracteristicaRow(caracteristica) {
            const div = document.createElement('div');
            div.className = "caracteristicas-list-row";
            div.dataset.caracteristicaId = caracteristica.id;

            div.innerHTML = `
                <div class="caracteristica-col">
                    <span>${caracteristica.caracteristica}</span>
                </div>

                <div class="caracteristica-col">
                    <span>${caracteristica.unidade_medida}</span>
                </div>

                <div class="caracteristica-col">
                    <button class="caracteristica-editar-btn" type="button"><span>Editar</span></button>
                    <button class="caracteristica-excluir-btn" type="button"><span>Excluir</span></button>
                </div>
            `;

            return div;
        }

        function formatarDataPortugues(dataString) {
            const data = new Date(dataString);

            const dia = data.getDate().toString().padStart(2, '0');
            const mes = data.toLocaleString('pt-BR', { month: 'long' });

            return `${dia} de ${mes}`;
        }
   </script>
</body>
</html>