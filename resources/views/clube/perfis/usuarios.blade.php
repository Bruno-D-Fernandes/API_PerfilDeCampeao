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

        .profile-container, .profile-info, #profile, .modal-body, .form-group, #listas-view {
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

        .profile-details {
            display: flex;
            justify-content: space-between;
        }
        
        .profile-tabs {
            display: flex;
            gap: 16px; 
        }

        .profile-imgs {
            width: 100%;
            height: 228px;
            position: relative;
        }

        .profile-imgs img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .profile-banner {
            width: 100%;
            height: 180px;
            background-color: #000;
        }

        .profile-picture {
            height: 96px;
            aspect-ratio: 1 / 1;
            border-radius: 50%;
            background-color: #fff;
            border: 8px solid #fff;
            position: absolute;
            left: 48px;
            bottom: 0px;
            overflow: hidden;
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

        .modal-body {
            max-height: 300px;
            overflow-y: auto;
        }

        .close-modal-btn {
            width: 32px;
            height: 32px;
        }

        .modal-body, .form-group {
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

        .profile-picture img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .tab-content.active {
            display: flex !important;
        }

        .tab-content {
            display: none !important;
            flex-direction: column;
            gap: 16px;
        }

        .sub-tab-content.active {
            display: flex !important;
        }

        .sub-tab-content {
            display: none !important;
            flex-direction: column;
            gap: 16px;
        }

        .estatisticas-list {
            width: 100%;
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            grid-template-rows: auto
        }

        .estatistica-item {
            display: flex;
            flex-direction: column;
            gap: 8px;
            align-items: center;
        }

        .postagens {
            width: 100%;
            display: flex;
            flex-direction: column;
            gap: 16px;
            align-items: center;
        }

        .postagem-card {
            width: 320px;
            display: flex;
            flex-direction: column;
            gap: 16px;
            background-color: #fafafa;
            padding: 16px;
        }

        .postagem-user {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .post-profile-picture {
            height: 100%;
            aspect-ratio: 1 / 1;
            overflow: hidden;
        }

        .post-profile-picture img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .postagem-localizacao {
            font-size: 12px;
        }

        .carousel-container {
            height: 128px;
            width: 100%;
            display: flex;
            justify-content: center;
        }

        .carousel-container img {
            height: 100%;
            object-fit: contain;
        }

        .lista-item {
            width: 100%;
            display: flex;
            gap: 16px;
        }

        #add-lista-btn {
            height: 32px;
        }
    </style>
</head>
<body>
    <div class="profile-container" data-storage-url="{{ asset('/storage') }}" data-usuario-id="{{ $usuario->id }}">
        <div id="profile">
            <div class="profile-info">
                <div class="profile-imgs">
                    <div class="profile-banner">
                        @if($usuario->fotoBannerUsuario)
                            <img src="{{ asset('storage/' . $usuario->fotoBannerUsuario) }}" alt="Banner do usuário">
                        @endif
                    </div>
                    <div class="profile-picture">
                        @if($usuario->fotoPerfilUsuario)
                            <img src="{{ asset('storage/' . $usuario->fotoPerfilUsuario) }}" alt="Foto de perfil do usuário">
                        @endif
                    </div>
                </div>

                <div class="profile-details">
                    <span class="profile-name">
                        {{ $usuario->nomeCompletoUsuario }}
                    </span>

                    <button id="add-to-list-btn">
                        <span>
                            Adicionar à lista
                        </span>
                    </button>
                </div>
            </div>

            <div class="profile-tabs">
                @foreach($usuario->perfis as $index => $perfil)
                    <button 
                        class="tab-btn"
                        data-target-tab="perfil-tab-{{ $perfil->id }}"
                    >
                        <span>
                            {{ $perfil->esporte->nomeEsporte }}
                        </span>
                    </button>
                @endforeach
            </div>
        </div>

        <div class="tab-container">
            @foreach($usuario->perfis as $index => $perfil)
                <div id="perfil-tab-{{ $perfil->id }}" class="tab-content {{ $index == 0 ? 'active' : '' }}">
                    
                    <div class="sub-tabs">
                        <button class="sub-tab-btn" data-target-subtab="postagens-{{ $perfil->id }}" type="button">
                            <span>
                                Postagens
                            </span>
                        </button>

                        <button class="sub-tab-btn" data-target-subtab="informacoes-{{ $perfil->id }}" type="button">
                            <span>
                                Informações
                            </span>
                        </button>
                    </div>

                    <div class="sub-tab-container">
                        <div id="postagens-{{ $perfil->id }}" class="sub-tab-content active postagens">
                            @if($perfil->postagens->count() > 0)
                                @foreach($perfil->postagens as $post)
                                    <div class="postagem-card">
                                        <div class="postagem-user">
                                            @if($usuario->fotoPerfilUsuario)
                                                <div class="post-profile-picture">
                                                    <img src="{{ asset('storage/' . $usuario->fotoPerfilUsuario) }}" alt="Foto de perfil">
                                                </div>
                                            @endif

                                            <span>
                                                {{ $usuario->nomeCompletoUsuario }}
                                            </span>
                                        </div>

                                        <span class="postagem-text">{{ $post->textoPostagem }}</span>

                                        <span class="postagem-localizacao">{{ $post->localizacaoPostagem }}</span>

                                        @if($post->imagens->count() > 0)
                                            <div class="carousel-container">
                                                @foreach($post->imagens as $midia)
                                                    <img 
                                                    src="{{ asset('storage/' . $midia->caminhoImagem) }}" 
                                                    class="carousel-item"
                                                    alt=""
                                                    >
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            @else
                                <span>Nenhuma postagem neste perfil ainda.</span>
                            @endif
                        </div>

                        <div id="informacoes-{{ $perfil->id }}" class="sub-tab-content">
                            <div class="estatisticas-list">
                                <div class="estatistica-item">
                                    <span class="estatistica-label">Posição</span>
                                    <span class="estatistica-value">{{ $perfil->posicao->nomePosicao }}</span>
                                </div>
                                
                                @if($perfil->caracteristicas)
                                    @foreach($perfil->caracteristicas as $caracteristica)
                                        <div class="estatistica-item">
                                            <span class="estatistica-label">{{ $caracteristica->caracteristica }}</span>
                                            
                                            <span class="estatistica-value">{{ $caracteristica->pivot->valor }}</span>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="estatistica-item">
                                        <span class="estatistica-label">Nenhuma característica informada.</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="modal-backdrop hidden"></div>

    <div id="listas-modal" class="app-modal hidden">
        <div class="modal-header">
            <h2 class="modal-title">Adicionar à lista</h2>
            <button class="close-modal-btn" data-modal-target="listas-modal">&times;</button>
        </div>

        <div class="modal-body" id="inscritos-modal-body">
            <div id="listas-view">
                
                <button id="add-lista-btn">
                    <span>
                        Criar lista
                    </span>
                </button>
            </div>
        </div>
    </div>
    
    <div class="modal-backdrop-second hidden"></div>

    <div id="criar-lista-modal" class="app-modal hidden">
        <div class="modal-header">
            <h2 class="modal-title">Adicionar à lista</h2>
            <button class="close-modal-btn" data-modal-target="criar-lista-modal">&times;</button>
        </div>

        <form class="modal-body" id="criar-lista-form">
            <div class="form-group">
                <label for="criar-lista-form-nome">Nome</label>

                <input type="text" name="nome" id="criar-lista-form-nome">
            </div>

            <div class="form-group">
                <label for="criar-lista-form-descricao">Descrição</label>

                <textarea type="text" name="descricao" id="criar-lista-form-descricao"></textarea>
            </div>
        </form>

        <div class="modal-footer">
            <button id="criar-lista-cancelar-btn">
                <span>Cancelar</span>
            </button>

            <button id="criar-lista-salvar-btn">
                <span>Salvar</span>
            </button>
        </div>
    </div>

    <script src="{{ asset('js/clube/perfis/usuarios/dom-elements.js') }}"></script>
    <script src="{{ asset('js/clube/perfis/usuarios/utils.js') }}"></script>
    <script src="{{ asset('js/clube/perfis/usuarios/modals.js') }}"></script>
    <script src="{{ asset('js/clube/perfis/usuarios/api.js') }}"></script>
    <script src="{{ asset('js/clube/perfis/usuarios/events.js') }}"></script>
</body>
</html>