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

        .listas {
            width: 100%;
            height: 100%;
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .listas-header {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .lista, .list-header {
            width: 100%;
            display: grid;
            gap: 16px;
            grid-template-columns: 1.5fr 1.5fr 0.5fr 1fr 1fr;
        }

        .header-col {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .header-col > span {
            font-size: 16px;
        }

        .lista > div {
            display: flex;
            align-items: center;
            justify-content: center;
        } 

        .lista-acoes {
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

        .modal-body, .form-group, #lista-view {
            width: 100%;
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .form-group label {
            width: 100%;
        }

        .modal-body {
            max-height: 300px;
            overflow-y: auto;
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

        .users-list {
            width: 100%;
            display: flex;
            flex-direction: column;
            gap: 16px;
        }
    </style>
</head>
<body>
    <div class="listas" data-storage-url="{{ asset('storage') }}">
        <div class="listas-header">
            <h1>Listas</h1>
        </div>

        <div class="list-header">
            <div class="header-col">
                <span>Nome</span>
            </div>

            <div class="header-col">
                <span>Clube</span>
            </div>

            <div class="header-col">
                <span>Usuários</span>
            </div>

            <div class="header-col">
                <span>Data de criação</span>
            </div>

            <div class="header-col">
                <span>Ações</span>
            </div>
        </div>

        @foreach($listas as $lista)
            <div class="lista" data-lista-id="{{ $lista->id }}">
                <div class="lista-nome">
                    <span>{{ $lista->nome }}</span>
                </div>

                <div class="lista-clube">
                    <span>{{ $lista->clube->nomeClube }}</span>
                </div>

                <div class="lista-usuarios">
                    <span>{{ $lista->usuarios->count() }}</span>
                </div>

                <div class="lista-data">
                    <span>{{ \Carbon\Carbon::parse($lista->created_at)
                        ->locale('pt_BR')
                        ->translatedFormat('d \d\e F \d\e Y') }}
                    </span>
                </div>

                <div class="lista-acoes">
                    <button class="lista-ver-btn">
                        <span>Ver</span>
                    </button>

                    <button class="lista-excluir-btn">
                        <span>Excluir</span>
                    </button>
                </div>
            </div>
        @endforeach
    </div>

    <div class="modal-backdrop hidden"></div>

    <div id="lista-modal" class="app-modal hidden">
        <div class="modal-header">
            <h2 class="modal-title">Detalhes da lista:</h2>
            <button class="close-modal-btn" data-modal-target="lista-modal">&times;</button>
        </div>

        <div class="modal-body" id="lista-form">
            <div id="lista-view">
                <h3>
                    <!-- Nome da Lista -->
                </h3>

                <span>
                    Criada por: 
                </span>

                <span>
                    Descrição: 
                </span>

                <div class="users-list">
                    <span>
                        Usuários (<!-- Quantidade de usuários  -->)
                    </span>

                    <div class="users-list-container">

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="confirmar-modal" class="app-modal hidden">
        <div class="modal-header">
            <h2 class="modal-title">Você deseja excluir esta lista?</h3>
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

    <script src="{{ asset('js/admin/listas/dom-elements.js') }}"></script>
    <script src="{{ asset('js/admin/listas/utils.js') }}"></script>
    <script src="{{ asset('js/admin/listas/modals.js') }}"></script>
    <script src="{{ asset('js/admin/listas/api.js') }}"></script>
    <script src="{{ asset('js/admin/listas/events.js') }}"></script>
</body>
</html>