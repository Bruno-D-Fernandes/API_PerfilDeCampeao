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

        .container, .profile-info, #profile, .profile-details, .tab-content > div, .modal-body, .form-group, #oportunidade-view, .members-list, .members-list-group, .members-list-group-function, .members-list-rows, #adicionar-membro-view {
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
            width: 420px;
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

        .members-list, .members-list-group, .members-list-group-function, .members-list-rows, .members-list-row {
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

                <button data-target-tab="team">
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

            <div class="tab-content">
                <div class="opportunities hidden">
                    @foreach($clube->oportunidades as $oportunidade)
                        <div class="opportunity">
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
                                <button>
                                    <span>
                                        Ver
                                    </span>
                                </button>

                                <button>
                                    <span>
                                       Atualizar 
                                    </span>
                                </button>

                                <button>
                                    <span>
                                        Excluir
                                    </span>
                                </button>

                                <button>
                                    <span>
                                        Inscritos
                                    </span>
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="members-list">
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

    <div class="modal-backdrop"></div>

    <div id="adicionar-membro-modal" class="app-modal">
        <div class="modal-header">
            <h2 class="modal-title">Adicionar membro:</h2>
            <button class="close-modal-btn" data-modal-target="oportunidade-modal">&times;</button>
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
            <button id="oportunidade-cancelar-btn">
                <span>Cancelar</span>
            </button>

            <button id="oportunidade-salvar-btn">
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

        const storageUrl = container.dataset.storageUrl;

        const seeDetailsBtns = document.querySelectorAll('.see-details-btn');

        const opportunityOptions = document.querySelectorAll('.opportunity-options');

        document.addEventListener('click', (e) => {
            const openOptions = [...opportunityOptions].filter(opt => !opt.classList.contains('hidden'));

            if (openOptions.length === 0) return;

            openOptions.forEach(opt => {
                if (!opt.contains(e.target)) {
                    opt.classList.add('hidden');
                }
            });
        });
        
        seeDetailsBtns.forEach(seeDetailsBtn => {
            seeDetailsBtn.addEventListener('click', (e) => {
                e.stopPropagation();

                seeDetailsBtn.parentElement.querySelector('.opportunity-options').classList.remove('hidden');
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
                    searchMembers();
                } else {
                    searchUsers('');
                }
            });
        });

        const searchUserInput = document.querySelector('#user-search-input');
        const searchUserContainer = document.querySelector('.search-user-container');

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
    </script>
</body>
</html>