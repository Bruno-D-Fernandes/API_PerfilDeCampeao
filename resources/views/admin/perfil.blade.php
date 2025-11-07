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
    <div class="perfil" data-storage-url="{{ asset('storage') }}" data-admin-id="{{ $admin->id }}">
        <h1>Perfil</h1>

        <div class="info">
            <div class="general">
                <div class="profile-picture">

                </div>

                <div class="admin">
                    <span class="nome">
                        João Pedro
                    </span>

                    <span class="cargo">
                        Administrador
                    </span>
                </div>

                <button id="editar-perfil-btn">
                    <span>
                        Editar
                    </span>
                </button>
            </div>

            <div class="personal-info-container">
                <div class="personal-info-header">
                    <h2>
                        Informações Pessoais
                    </h2>

                    <button id="editar-informacoes-btn">
                        <span>
                            Editar
                        </span>
                    </button>
                </div>

                <div class="personal-info">
                    <div class="personal-info-group email">
                        <h3>
                            Email
                        </h3>

                        <span>
                            fjoaopedro1302@gmail.com
                        </span>
                    </div>

                    <div class="personal-info-group telefone">
                        <h3>
                            Telefone
                        </h3>

                        <span>
                            (11) 91234-5678
                        </span>
                    </div>

                    <div class="personal-info-group endereco">
                        <h3>
                            Endereço
                        </h3>

                        <span>
                            Rua da Amargura, 123 - Bairro Exemplo, Cidade Exemplo - SP, 12345-678
                        </span>
                    </div>

                    <div class="personal-info-group data">
                        <h3>
                            Data de nascimento
                        </h3>

                        <span>
                            {{ \Carbon\Carbon::parse        ($clube->anoCriacaoClube)
                                ->locale('pt_BR')
                                ->translatedFormat('d \d\e F \d\e Y')
                            }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal-backdrop hidden"></div>

    <div id="perfil-modal" class="app-modal hidden">
        <div class="modal-header">
            <h2 class="modal-title">Editar perfil</h2>
            <button class="close-modal-btn" data-modal-target="perfil-modal">&times;</button>
        </div>

        <form class="modal-body" id="perfil-form">
            <div id="perfil-view">
                <div class="form-group img">
                    <label for="perfil-form-foto">Foto:</label>

                    <div class="img-preview foto">
                        <img src="" alt="" class="foto-preview" style="display: none;">
                    </div>

                    <input type="file" name="foto_perfil" id="perfil-form-foto" accept="image/*">
                </div>

                <div class="form-group">
                    <label for="perfil-form-nome">Nome:</label>

                    <input type="text" name="nome" id="perfil-form-nome">
                </div>
            </div>
        </form>

        <div class="modal-footer">
            <button id="perfil-cancelar-btn">
                <span>Cancelar</span>
            </button>

            <button id="perfil-salvar-btn">
                <span>Salvar</span>
            </button>
        </div>
    </div>

    <div id="informacoes-modal" class="app-modal hidden">
        <div class="modal-header">
            <h2 class="modal-title">Editar informações pessoais</h2>
            <button class="close-modal-btn" data-modal-target="informacoes-modal">&times;</button>
        </div>

        <form class="modal-body" id="informacoes-form">
            <div id="informacoes-view">
                <div class="form-group">
                    <label for="informacoes-form-email">Email:</label>

                    <input type="text" name="email" id="informacoes-form-email">
                </div>

                <div class="form-group">
                    <label for="informacoes-form-contato">Telefone:</label>

                    <input type="text" name="telefone" id="informacoes-form-telefone">
                </div>

                <div class="form-group">
                    <label for="informacoes-form-endereco">Endereço:</label>

                    <input type="text" name="endereco" id="informacoes-form-endereco">
                </div>

                <div class="form-group">
                    <label for="informacoes-form-data">Data de Nascimento:</label>

                    <input type="date" name="data_nascimento" id="informacoes-form-data">
                </div>
            </div>
        </form>

        <div class="modal-footer">
            <button id="informacoes-cancelar-btn">
                <span>Cancelar</span>
            </button>

            <button id="informacoes-salvar-btn">
                <span>Salvar</span>
            </button>
        </div>
    </div>

    <div id="confirmar-modal" class="app-modal hidden">
        <div class="modal-header">
            <h2 class="modal-title">Você deseja excluir o perfil?</h3>
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

    <script src="{{ asset('js/admin/perfil/dom-elements.js') }}"></script>
    <script src="{{ asset('js/admin/perfil/utils.js') }}"></script>
    <script src="{{ asset('js/admin/perfil/modals.js') }}"></script>
    <script src="{{ asset('js/admin/perfil/api.js') }}"></script>
    <script src="{{ asset('js/admin/perfil/events.js') }}"></script>
</body>
</html>