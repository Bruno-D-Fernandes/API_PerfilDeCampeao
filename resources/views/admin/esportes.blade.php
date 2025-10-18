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

        .esporte, .header {
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
            max-height: 450px;
            overflow-y: auto;
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
        <div class="header">
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
                    <button>
                        <span>Ver</span>
                    </button>

                    <button>
                        <span>Atualizar</span>
                    </button>

                    <button>
                        <span>Excluir</span>
                    </button>
                </div>
            </div>
        @endforeach
    </div>

    <div id="modal-backdrop"></div>

    <div id="esporte-modal" class="app-modal hidden">
        <div class="modal-header">
            <h2 class="modal-title">Adicionar esporte</h2>
            <button class="close-modal-btn" data-modal-target="esporte-modal">&times;</button>
        </div>

        <div class="modal-body">
            <div id="esporte-view">
                <div class="form-group">
                    <label for="esporte-form-nome">Nome:</label>

                    <input type="text" id="esporte-form-nome">
                </div>

                <div class="form-group">
                    <label for="esporte-form-descricao">Descrição:</label>

                    <input type="text" id="esporte-form-descricao">
                </div>
            </div>

            <div class="modal-tabs">
                <button class="tab-button active" data-tab-target="posicoes-tab">
                    <span>
                        Posições
                    </span>
                </button>

                <button class="tab-button" data-tab-target="caracteristicas-tab">
                    <span>
                        Características
                    </span>
                </button>
            </div>

            <div id="posicoes-tab-content" class="tab-content active">
                <div class="tab-header">
                    <h3>Posições</h3>

                    <button class="add-posicao-btn">
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
                            <button class="posicao-editar-btn"><span>Editar</span></button>
                            <button class="posicao-excluir-btn"><span>Excluir</span></button>
                        </div>
                    </div>
                </div>
            </div>

            <div id="caracteristicas-tab-content" class="tab-content hidden">
                <div class="tab-header">

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
                            <button class="caracteristica-editar-btn"><span>Editar</span></button>
                            <button class="caracteristica-excluir-btn"><span>Excluir</span></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

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

        <div class="modal-body">
            <div id="posicao-view">
                <div class="form-group">
                    <label for="posicao-form-nome">Nome:</label>

                    <input type="text" id="posicao-form-nome">
                </div>

                <div class="form-group">
                    <label for="posicao-form-descricao">Descrição:</label>

                    <input type="text" id="posicao-form-descricao">
                </div>
            </div>
        </div>

        <div class="modal-footer">
            <button id="posicao-cancelar-btn">
                <span>Cancelar</span>
            </button>

            <button id="posicao-salvar-btn">
                <span>Salvar</span>
            </button>
        </div>
    </div>

    <div id="caracteristica-modal" class="app-modal">
        <div class="modal-header">
            <h2 class="modal-title">Adicionar característica</h2>
            <button class="close-modal-btn" data-modal-target="caracteristica-modal">&times;</button>
        </div>

        <div class="modal-body">
            <div id="caracteristica-view">
                <div class="form-group">
                    <label for="caracteristica-form-nome">Nome:</label>

                    <input type="text" id="caracteristica-form-nome">
                </div>

                <div class="form-group">
                    <label for="caracteristica-form-unidade">Unidade de medida:</label>

                    <input type="text" id="caracteristica-form-unidade">
                </div>
            </div>
        </div>

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
        const BEARER = '1|veMWAqZAhSUNcKNJztoW6oxsOYC8McYW427W9Wh87542b9fc';

        const esportes = document.querySelector('.esportes');
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        async function fetchEsportes() {

        }
   </script>
</body>
</html>