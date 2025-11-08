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

        .container, .profile-info, #profile, .profile-details, .modal-body, .form-group, #oportunidade-view, #opportunities, #members-list, .members-list-group, .members-list-group-function, .members-list-rows, #adicionar-membro-view, #about, #clube-view {
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
            flex-shrink: 0;
        }

        .img-preview img {
            height: 100%;
            width: 100%;
            object-fit: cover;
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

        .profile-imgs img {
            width: 100%;
            height: 100%;
            object-fit: cover;
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
            overflow: hidden;
        }
        
        .opportunity {
            width: 100%;
            height: 48px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: relative;
        }

        .opportunity-details, .members-btns {
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

        #members-list, .members-list-group, .members-list-group-function, .members-list-rows, .members-list-row {
            width: 100%;
        }

        .members-list-search {
            width: 100%;
            height: 32px;
            display: flex;
            gap: 16px;
            align-items: center;
        }

        .members-list-row, .opportunities-header, .about-header {
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

        .tab-content.active {
            display: flex !important;
        }

        .tab-content {
            display: none !important;
        }

        #confirmar-modal, #adicionar-membro-modal, #inscritos-modal {
            width: 420px;
        }

        .about-container {
            width: 100%;
            display: grid;
            grid-template-columns: repeat(3, 1fr);
        }

        .info {
            aspect-ratio: 5 / 2;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 16px;
        }
    </style>
</head>
<body>
    <div class="container" data-storage-url="{{ asset('/storage') }}" data-usuario-id="{{ $usuario->id }}">

        <div id="profile">
            <div class="profile-info">
                <div class="profile-imgs">
                    <div class="banner">
                        @if($usuario->fotoBannerUsuario)
                            <img src="{{ asset('storage/' . $usuario->fotoBannerUsuario) }}" alt="Banner do usuário">
                        @endif
                    </div>
                    <div class="picture">
                        @if($usuario->fotoPerfilUsuario)
                            <img src="{{ asset('storage/' . $usuario->fotoPerfilUsuario) }}" alt="Foto de perfil do usuário">
                        @endif
                    </div>
                </div>

                <div class="profile-details">
                    <span class="profile-name">
                        {{ $usuario->nomeCompletoUsuario }}
                    </span>
                </div>
            </div>

            <div class="tabs">
                @foreach($usuario->perfis as $index => $perfil)
                    <button 
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
                        <button data-target-subtab="postagens-{{ $perfil->id }}" type="button">
                            <span>
                                Postagens
                            </span>
                        </button>

                        <button data-target-subtab="informacoes-{{ $perfil->id }}" type="button">
                            <span>
                                Informações
                            </span>
                        </button>
                    </div>

                    <div class="sub-tab-container">
                        <div id="postagens-{{ $perfil->id }}" class="sub-tab-content active">
                            @forelse($perfil->posts as $post)
                                <div class="post-card">
                                    <span class="post-text">{{ $post->textoPostagem }}</span>
                                    
                                    @if($post->midias->isNotEmpty())
                                        <div class="carrossel-container">
                                            @foreach($post->midias as $midia)
                                                <!-- 
                                                  Idealmente, verificar o tipo (imagem/video)
                                                  Para o TCC, só imagem é mais simples.
                                                -->
                                                <img 
                                                  src="{{ asset('storage/' . $midia->caminho_arquivo) }}" 
                                                  class="carrossel-item"
                                                  alt="Mídia do post"
                                                >
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            @empty
                                <p>Nenhuma postagem neste perfil ainda.</p>
                            @endforelse
                        </div>

                        <div id="informacoes-{{ $perfil->id }}" class="sub-tab-content">
                            <div class="lista-de-estatisticas">
                                <div class="stat-item">
                                    <span class="stat-label">Posição Principal</span>
                                    <span class="stat-value">{{ $perfil->posicao_principal ?? 'N/A' }}</span>
                                </div>
                                
                                @if($perfil->caracteristicas)
                                    @foreach($perfil->caracteristicas as $label => $valor)
                                        <div class="stat-item">
                                            <span class="stat-label">{{ $label }}</span>
                                            <span class="stat-value">{{ $valor }}</span>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="stat-item">
                                        <span class="stat-label">Nenhuma característica informada.</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <script src="{{ asset('js/clube/usuarios/dom-elements.js') }}"></script>
    <script src="{{ asset('js/clube/usuarios/utils.js') }}"></script>
    <script src="{{ asset('js/clube/usuarios/modals.js') }}"></script>
    <script src="{{ asset('js/clube/usuarios/api.js') }}"></script>
    <script src="{{ asset('js/clube/usuarios/events.js') }}"></script>
</body>
</html>