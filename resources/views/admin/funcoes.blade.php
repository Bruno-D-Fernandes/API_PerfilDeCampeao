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

        .funcoes {
            width: 100%;
            height: 100%;
            display: flex;
            flex-direction: column;
            gap: 16px;/
        }

        .funcoes-header {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .funcao, .list-header {
            width: 100%;
            display: grid;
            gap: 16px;
            grid-template-columns: 2fr 3fr 1fr 1.5fr;
        }

        .header-col {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .header-col > span {
            font-size: 16px;
        }

        .funcao > div {
            display: flex;
            align-items: center;
            justify-content: center;
        } 

        .funcao-acoes {
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

        .modal-body, .form-group {
            width: 100%;
            display: flex;
            flex-direction: column;
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
    </style>
</head>
<body>
    <div class="funcoes">
        <div class="funcoes-header">
            <h1>Funções</h1>

            <button id="funcao-add-btn">
                <span>
                    Adicionar função
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
                <span>Data de cadastro</span>
            </div>

            <div class="header-col">
                <span>Ações</span>
            </div>
        </div>

        @foreach($funcoes as $funcao)
            <div class="funcao" data-funcao-id="{{ $funcao->id }}">
                <div class="funcao-nome">
                    <span>{{ $funcao->nome }}</span>
                </div>

                <div class="funcao-descricao">
                    <span>{{ $funcao->descricao ?? 'Sem descrição' }}</span>
                </div>

                <div class="funcao-data">
                    <span>{{ \Carbon\Carbon::parse($funcao->created_at)
                            ->locale('pt_BR')
                            ->translatedFormat('d \d\e F')
                    }}</span>
                </div>

                <div class="funcao-acoes">
                    <button class="funcao-ver-btn">
                        <span>Ver</span>
                    </button>

                    <button class="funcao-editar-btn">
                        <span>Editar</span>
                    </button>

                    <button class="funcao-excluir-btn">
                        <span>Excluir</span>
                    </button>
                </div>
            </div>
        @endforeach
    </div>

    <div class="modal-backdrop hidden"></div>

    <div id="funcao-modal" class="app-modal hidden">
        <div class="modal-header">
            <h2 class="modal-title">Adicionar função</h2>
            <button class="close-modal-btn" data-modal-target="funcao-modal">&times;</button>
        </div>

        <form class="modal-body" id="funcao-form">
            <div id="funcao-view">
                <div class="form-group">
                    <label for="funcao-form-nome">Nome:</label>

                    <input type="text" name="nome" id="funcao-form-nome">
                </div>

                <div class="form-group">
                    <label for="funcao-form-descricao">Descrição:</label>

                    <input type="text" name="descricao" id="funcao-form-descricao">
                </div>
            </div>
        </form>

        <div class="modal-footer">
            <button id="funcao-cancelar-btn">
                <span>Cancelar</span>
            </button>

            <button id="funcao-salvar-btn">
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

    <script src="{{ asset('js/admin/funcoes/dom-elements.js') }}"></script>
    <script src="{{ asset('js/admin/funcoes/utils.js') }}"></script>
    <script src="{{ asset('js/admin/funcoes/modals.js') }}"></script>
    <script src="{{ asset('js/admin/funcoes/api.js') }}"></script>
    <script src="{{ asset('js/admin/funcoes/events.js') }}"></script>
</body>
</html>