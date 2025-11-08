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

        .oportunidades {
            width: 100%;
            height: 100%;
            display: flex;
            flex-direction: column;
            gap: 16px;/
        }

        .oportunidades-header {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .oportunidade, .list-header {
            width: 100%;
            display: grid;
            gap: 16px;
            grid-template-columns: 1.5fr 1fr 1fr 1.5fr 0.75fr 1fr 1.5fr
        }

        .header-col {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .header-col > span {
            font-size: 16px;
        }

        .oportunidade > div {
            display: flex;
            align-items: center;
            justify-content: center;
        } 

        .oportunidade-acoes {
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

        .modal-body, .form-group, #oportunidade-view, #status-view {
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

        .tab-content {
            display: none;
        }

        .tab-content.active {
            display: block;
        }
    </style>
</head>
<body>
    <div class="oportunidades" data-storage-url="{{ asset('storage') }}">
        <div class="oportunidades-header">
            <h1>Oportunidades</h1>
        </div>

        <div class="list-header">
            <div class="header-col">
                <span>Clube</span>
            </div>

            <div class="header-col">
                <span>Esporte</span>
            </div>

            <div class="header-col">
                <span>Posição</span>
            </div>

            <div class="header-col">
                <span>Data de postagem</span>
            </div>
            
            <div class="header-col">
                <span>Inscritos</span>
            </div>

            <div class="header-col">
                <span>Status</span>
            </div>

            <div class="header-col">
                <span>Ações</span>
            </div>
        </div>

        @foreach($oportunidades as $oportunidade)
            <div class="oportunidade" data-oportunidade-id="{{ $oportunidade->id }}">
                <div class="oportunidade-clube">
                    <span>{{ $oportunidade->clube->nomeClube }}</span>
                </div>

                <div class="oportunidade-esporte">
                    <span>{{ $oportunidade->esporte->nomeEsporte }}</span>
                </div>

                <div class="oportunidade-posicao">
                    <span>{{ $oportunidade->posicao->nomePosicao }}</span>
                </div>

                <div class="oportunidade-data">
                    <span>{{ \Carbon\Carbon::parse($oportunidade->datapostagemOportunidades)
                            ->locale('pt_BR')
                            ->translatedFormat('d \d\e F \d\e Y')
                    }}</span>
                </div>

                <div class="oportunidade-inscritos">
                    <span>{{ $oportunidade->inscricoes->count() }}</span>
                </div>

                <div class="oportunidade-status">
                    <span>{{ $oportunidade->showHTMLStatus() }}</span>
                </div>

                <div class="oportunidade-acoes">
                    <button class="oportunidade-ver-btn">
                        <span>Ver</span>
                    </button>

                    @if ($oportunidade->status === \App\Models\Oportunidade::STATUS_PENDING)
                        <button class="oportunidade-aprovar-btn">
                            <span>Aprovar</span>
                        </button>

                        <button class="oportunidade-rejeitar-btn">
                            <span>Rejeitar</span>
                        </button>
                    @else
                        @endif
                </div>
            </div>
        @endforeach
    </div>

    <div class="modal-backdrop hidden"></div>

    <div id="oportunidade-modal" class="app-modal hidden">
        <div class="modal-header">
            <h2 class="modal-title">Adicionar oportunidade</h2>
            <button class="close-modal-btn" data-modal-target="oportunidade-modal">&times;</button>
        </div>

        <form class="modal-body" id="oportunidade-form">
            <div id="oportunidade-view">
                <div class="modal-tabs">
                    <button class="tab-button active" data-target-tab="detalhes-tab" type="button">
                        <span>
                            Detalhes
                        </span>
                    </button>

                    <button class="tab-button" data-target-tab="inscritos-tab" type="button">
                        <span>
                            Inscritos
                        </span>
                    </button>
                </div>

                <div id="detalhes-tab" class="tab-content active">
                    <div class="tab-header">
                        <h3>Detalhes</h3>
                    </div>

                    <div class="detalhes-list-container">
                        <div class="detalhe-group">
                            <h4>
                                Data de postagem
                            </h4>

                            <span>
                                <!-- Data formatada aqui -->
                            </span>
                        </div>

                        <div class="detalhe-group">
                            <h4>
                                Descrição
                            </h4>

                            <span>
                                <!-- Descrição aqui -->
                            </span>
                        </div>

                        <div class="detalhe-group">
                            <h4>
                                Requisitos
                            </h4>

                            <span>
                                <!-- Texto com o limite de idades aqui -->
                            </span>
                        </div>

                        <div class="detalhe-group">
                            <h4>
                                Localização
                            </h4>

                            <span>
                                <!-- Localização aqui -->
                            </span>
                        </div>

                        <div class="detalhe-group">
                            <h4>
                                Contexto
                            </h4>

                            <span>
                                <!-- Contexto aqui -->
                            </span>
                        </div>
                    </div>
                </div>

                <div id="inscritos-tab" class="tab-content">
                    <div class="tab-header">
                        <h3>Inscritos</h3>
                    </div>

                    <div class="inscritos-list-container">

                    </div>
                </div>
            </div>
        </form>
    </div>

    <div id="status-modal" class="app-modal hidden">
        <div class="modal-header">
            <h2 class="modal-title">Alterar status de oportunidade</h2>

            <button class="close-modal-btn" data-modal-target="status-modal">&times;</button>
        </div>

        <form class="modal-body" id="status-form">
            <div id="status-view">
                <div class="form-group">
                    <label for="rejeicao-status">Motivo:</label>

                    <textarea name="rejection_reason" id="rejeicao-status"></textarea>
                </div>
            </div>
        </form>

        <div class="modal-footer">
            <button id="cancel-status-btn">
                <span>
                    Cancelar
                </span>
            </button>

            <button id="save-status-btn">
                <span>
                    Salvar
                </span>
            </button>
        </div>
    </div>

    <div id="confirmar-modal" class="app-modal hidden">
        <div class="modal-header">
            <h2 class="modal-title">Você deseja excluir este clube?</h3>
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

    <script src="{{ asset('js/admin/oportunidades/dom-elements.js') }}"></script>
    <script src="{{ asset('js/admin/oportunidades/utils.js') }}"></script>
    <script src="{{ asset('js/admin/oportunidades/modals.js') }}"></script>
    <script src="{{ asset('js/admin/oportunidades/api.js') }}"></script>
    <script src="{{ asset('js/admin/oportunidades/events.js') }}"></script>
</body>
</html>