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

        .modal-backdrop {
            width: 100%;
            height: 100%;
            position: fixed;
            top: 0;
            left: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 100;
        }

        .modal-backdrop.second {
            z-index: 101;
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

        .posicoes-list-container, .caracteristicas-list-container {
            max-height: 160px;
            overflow-y: auto;
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

        .posicoes-list-header, .posicoes-list-row {
            width: 100%;
            display: grid;
            gap: 16px;
            grid-template-columns: 1.5fr 2.5fr 1fr;
        }

        .caracteristicas-list-header, .caracteristicas-list-row {
            width: 100%;
            display: grid;
            gap: 16px;
            grid-template-columns: 1.5fr 1fr 2fr 1.5fr;
        }

        .posicoes-header-col, .posicao-col, .caracteristicas-header-col, .caracteristica-col {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .posicao-col.acoes, .caracteristica-col.acoes {
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

        #posicao-modal, #caracteristica-modal, #confirmar-modal {
            width: 400px;
            z-index: 103;
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

                    <button class="esporte-editar-btn">
                        <span>Editar</span>
                    </button>

                    <button class="esporte-excluir-btn">
                        <span>Excluir</span>
                    </button>
                </div>
            </div>
        @endforeach
    </div>

    <div class="modal-backdrop hidden"></div>

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
                            Adicionar posição
                        </span>
                    </button>
                </div>

                <div class="posicoes-list-container">
                    
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

    <div class="modal-backdrop second hidden"></div>

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

    <div id="confirmar-modal" class="app-modal hidden">
        <div class="modal-header">
            <h2 class="modal-title">Você deseja excluir este usuário?</h3>
        </div>
        
        <div class="modal-body">
            <p class="modal-alert">
                Essa ação não será possível reverter.
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

    <script src="{{ asset('js/admin/esportes/dom-elements.js') }}"></script>
    <script src="{{ asset('js/admin/esportes/utils.js') }}"></script>
    <script src="{{ asset('js/admin/esportes/modals.js') }}"></script>
    <script src="{{ asset('js/admin/esportes/api.js') }}"></script>
    <script src="{{ asset('js/admin/esportes/events.js') }}"></script>
</body>
</html>