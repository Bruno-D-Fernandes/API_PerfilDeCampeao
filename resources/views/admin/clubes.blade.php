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

        .clubes {
            width: 100%;
            height: 100%;
            display: flex;
            flex-direction: column;
            gap: 16px;/
        }

        .clubes-header {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .clube, .list-header {
            width: 100%;
            display: grid;
            gap: 16px;
            grid-template-columns: 1.5fr 1fr 1.5fr 1fr 1fr 1fr
        }

        .header-col {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .header-col > span {
            font-size: 16px;
        }

        .clube > div {
            display: flex;
            align-items: center;
            justify-content: center;
        } 

        .clube-acoes {
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

        .modal-body, .form-group, #clube-view {
            width: 100%;
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .form-group.img {
            align-items: center;
        }

        .form-group.img .img-btns {
            display: flex;
            gap: 16px;
        }

        .form-group label {
            width: 100%;
        }

        .img-preview {
            background-color: #000;
        }

        .img-preview.foto {
            height: 96px;
            aspect-ratio: 1 / 1;
            border-radius: 50%;
            overflow: hidden;
        }

        .img-preview.banner {
            height: 48px;
            aspect-ratio: 3 / 1;
            overflow: hidden;
        }

        .img-preview img {
            height: 100%;
            width: 100%;
            object-fit: cover;
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
    </style>
</head>
<body>
    <div class="clubes" data-storage-url="{{ asset('storage') }}">
        <div class="clubes-header">
            <h1>Clubes</h1>

            <button id="clube-add-btn">
                <span>
                    Adicionar clube
                </span>
            </button>
        </div>

        <div class="list-header">
            <div class="header-col">
                <span>Nome</span>
            </div>

            <div class="header-col">
                <span>Email</span>
            </div>

            <div class="header-col">
                <span>CNPJ</span>
            </div>

            <div class="header-col">
                <span>Data de Criação</span>
            </div>
            
            <div class="header-col">
                <span>Data de cadastro</span>
            </div>

            <div class="header-col">
                <span>Ações</span>
            </div>
        </div>

        @foreach($clubes as $clube)
            <div class="clube" data-clube-id="{{ $clube->id }}">
                <div class="clube-nome">
                    <span>{{ $clube->nomeClube }}</span>
                </div>

                <div class="clube-email">
                    <span>{{ $clube->emailClube }}</span>
                </div>

                <div class="clube-cnpj">
                    <span>{{ $clube->cnpjClube }}</span>
                </div>

                <div class="clube-ano">
                    <span>{{ \Carbon\Carbon::parse($clube->anoCriacaoClube)
                            ->locale('pt_BR')
                            ->translatedFormat('d \d\e F \d\e Y')
                    }}</span>
                </div>

                <div class="clube-data">
                    <span>{{ \Carbon\Carbon::parse($clube->created_at)
                            ->locale('pt_BR')
                            ->translatedFormat('d \d\e F')
                    }}</span>
                </div>

                <div class="clube-acoes">
                    <button class="clube-ver-btn">
                        <span>Ver</span>
                    </button>

                    <button class="clube-editar-btn">
                        <span>Editar</span>
                    </button>

                    <button class="clube-excluir-btn">
                        <span>Excluir</span>
                    </button>
                </div>
            </div>
        @endforeach
    </div>

    <div class="modal-backdrop hidden"></div>

    <div id="clube-modal" class="app-modal hidden">
        <div class="modal-header">
            <h2 class="modal-title">Adicionar clube</h2>
            <button class="close-modal-btn" data-modal-target="clube-modal">&times;</button>
        </div>

        <form class="modal-body" id="clube-form">
            <div id="clube-view">
                <div class="form-group img">
                    <label for="clube-form-foto">Foto:</label>

                    <div class="img-preview foto">
                        <img src="" alt="" class="foto-preview" style="display: none;">
                    </div>

                    <input type="file" name="fotoPerfilClube" id="clube-form-foto" accept="image/*">
                </div>

                <div class="form-group img">
                    <label for="clube-form-banner">Banner:</label>

                    <div class="img-preview banner">
                        <img src="" alt="" class="banner-preview" style="display: none;">
                    </div>

                    <input type="file" name="fotoBannerClube" id="clube-form-banner" accept="image/*">
                </div>

                <div class="form-group">
                    <label for="clube-form-nome">Nome:</label>

                    <input type="text" name="nomeClube" id="clube-form-nome">
                </div>

                <div class="form-group">
                    <label for="clube-form-email">Email:</label>

                    <input type="text" name="emailClube" id="clube-form-email">
                </div>

                <div class="form-group">
                    <label for="clube-form-cnpj">CNPJ:</label>

                    <input type="text" name="cnpjClube" id="clube-form-cnpj">
                </div>

                <div class="form-group">
                    <label for="clube-form-data">Data de Criação:</label>

                    <input type="date" name="anoCriacaoClube" id="clube-form-data">
                </div>

                <div class="form-group">
                    <label for="clube-form-endereco">Endereço:</label>

                    <input type="text" name="enderecoClube" id="clube-form-endereco">
                </div>

                <div class="form-group">
                    <label for="clube-form-cidade">Cidade:</label>

                    <input type="text" name="cidadeClube" id="clube-form-cidade">
                </div>

                <div class="form-group">
                    <label for="clube-form-estado">Estado:</label>

                    <input type="text" name="estadoClube" id="clube-form-estado">
                </div>

                <div class="form-group">
                    <label for="clube-form-bio">Biografia:</label>

                    <textarea name="bioClube" id="clube-form-bio"></textarea>
                </div>

                <div class="form-group">
                    <label for="clube-form-categoria">Categoria:</label>

                    <select name="categoria_id" id="clube-form-categoria">
                        @foreach($categorias as $categoria)
                            <option value="{{ $categoria->id }}">{{ $categoria->nomeCategoria }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="clube-form-esporte">Esporte:</label>

                    <select name="esporte_id" id="clube-form-esporte">
                        @foreach($esportes as $esporte)
                            <option value="{{ $esporte->id }}">{{ $esporte->nomeEsporte }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </form>

        <div class="modal-footer">
            <button id="clube-cancelar-btn">
                <span>Cancelar</span>
            </button>

            <button id="clube-salvar-btn">
                <span>Salvar</span>
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

    <script src="{{ asset('js/admin/clubes/dom-elements.js') }}"></script>
    <script src="{{ asset('js/admin/clubes/utils.js') }}"></script>
    <script src="{{ asset('js/admin/clubes/modals.js') }}"></script>
    <script src="{{ asset('js/admin/clubes/api.js') }}"></script>
    <script src="{{ asset('js/admin/clubes/events.js') }}"></script>
</body>
</html>