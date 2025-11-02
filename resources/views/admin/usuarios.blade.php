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

        .usuarios {
            width: 100%;
            height: 100%;
            display: flex;
            flex-direction: column;
            gap: 16px;/
        }

        .usuarios-header {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .usuario, .list-header {
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

        .usuario > div {
            display: flex;
            align-items: center;
            justify-content: center;
        } 

        .usuario-acoes {
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

        .modal-body, .form-group, #usuario-view {
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
    <div class="usuarios">
        <div class="usuarios-header">
            <h1>Usuarios</h1>

            <button id="usuario-add-btn">
                <span>
                    Adicionar usuário
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
                <span>Genero</span>
            </div>

            <div class="header-col">
                <span>Data de Nascimento</span>
            </div>
            
            <div class="header-col">
                <span>Data de cadastro</span>
            </div>

            <div class="header-col">
                <span>Ações</span>
            </div>
        </div>

        @foreach($usuarios as $usuario)
            <div class="usuario" data-usuario-id="{{ $usuario->id }}">
                <div class="usuario-nome">
                    <span>{{ $usuario->nomeCompletoUsuario }}</span>
                </div>

                <div class="usuario-email">
                    <span>{{ $usuario->emailUsuario }}</span>
                </div>

                <div class="usuario-genero">
                    <span>{{ $usuario->generoUsuario ?? 'N/A' }}</span>
                </div>

                <div class="usuario-data-nascimento">
                    <span>{{ \Carbon\Carbon::parse($usuario->dataNascimentoUsuario)
                            ->locale('pt_BR')
                            ->translatedFormat('d \d\e F \d\e Y')
                    }}</span>
                </div>

                <div class="usuario-data">
                    <span>{{ \Carbon\Carbon::parse($usuario->created_at)
                            ->locale('pt_BR')
                            ->translatedFormat('d \d\e F')
                    }}</span>
                </div>

                <div class="usuario-acoes">
                    <button class="usuario-ver-btn">
                        <span>Ver</span>
                    </button>

                    <button class="usuario-editar-btn">
                        <span>Editar</span>
                    </button>

                    <button class="usuario-excluir-btn">
                        <span>Excluir</span>
                    </button>
                </div>
            </div>
        @endforeach
    </div>

    <div class="modal-backdrop hidden"></div>

    <div id="usuario-modal" class="app-modal hidden">
        <div class="modal-header">
            <h2 class="modal-title">Adicionar usuario</h2>
            <button class="close-modal-btn" data-modal-target="usuario-modal">&times;</button>
        </div>

        <form class="modal-body" id="usuario-form">
            <div id="usuario-view">
                <div class="form-group img">
                    <label for="usuario-form-foto">Foto:</label>

                    <div class="img-preview foto">
                        <img src="" alt="" class="foto-preview" style="display: none;">
                    </div>

                    <input type="file" name="fotoPerfilUsuario" id="usuario-form-foto" accept="image/*">
                </div>

                <div class="form-group img">
                    <label for="usuario-form-banner">Banner:</label>

                    <div class="img-preview banner">
                        <img src="" alt="" class="banner-preview" style="display: none;">
                    </div>

                    <input type="file" name="fotoBannerUsuario" id="usuario-form-banner" accept="image/*">
                </div>

                <div class="form-group">
                    <label for="usuario-form-nome">Nome:</label>

                    <input type="text" name="nomeCompletoUsuario" id="usuario-form-nome">
                </div>

                <div class="form-group">
                    <label for="usuario-form-email">Email:</label>

                    <input type="text" name="emailUsuario" id="usuario-form-email">
                </div>

                <div class="form-group">
                    <label for="usuario-form-genero">Gênero:</label>

                    <input type="text" name="generoUsuario" id="usuario-form-genero">
                </div>

                <div class="form-group">
                    <label for="usuario-form-data">Data de Nascimento:</label>

                    <input type="date" name="dataNascimentoUsuario" id="usuario-form-data">
                </div>

                <div class="form-group">
                    <label for="usuario-form-cidade">Cidade:</label>

                    <input type="text" name="cidadeUsuario" id="usuario-form-cidade">
                </div>

                <div class="form-group">
                    <label for="usuario-form-estado">Estado:</label>

                    <input type="text" name="estadoUsuario" id="usuario-form-estado">
                </div>

                <div class="form-group">
                    <label for="usuario-form-altura">Altura (cm):</label>

                    <input type="number" name="alturaCm" id="usuario-form-altura" min="50" max="300">
                </div>

                <div class="form-group">
                    <label for="usuario-form-peso">Peso (kg):</label>

                    <input type="number" name="pesoKg" id="usuario-form-peso" step="0.1" lang="pt-BR" min="20" max="500">
                </div>

                <div class="form-group">
                    <label for="usuario-form-pe">Pé dominante:</label>

                    <select name="peDominante" id="usuario-form-pe">
                        <option value="Esquerdo">Esquerdo</option>
                        <option value="Direito">Direito</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="usuario-form-mao">Mão dominante:</label>

                    <select name="maoDominante" id="usuario-form-mao">
                        <option value="Canhoto">Canhoto</option>
                        <option value="Destro">Destro</option>
                    </select>
                </div>
            </div>
        </form>

        <div class="modal-footer">
            <button id="usuario-cancelar-btn">
                <span>Cancelar</span>
            </button>

            <button id="usuario-salvar-btn">
                <span>Salvar</span>
            </button>
        </div>
    </div>

    <div id="confirmar-modal" class="app-modal hidden">
        <div class="modal-header">
            <h2 class="modal-title">Você deseja excluir este usuario?</h3>
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

    <script src="{{ asset('js/admin/usuarios/dom-elements.js') }}"></script>
    <script src="{{ asset('js/admin/usuarios/utils.js') }}"></script>
    <script src="{{ asset('js/admin/usuarios/modals.js') }}"></script>
    <script src="{{ asset('js/admin/usuarios/api.js') }}"></script>
    <script src="{{ asset('js/admin/usuarios/events.js') }}"></script>
</body>
</html>