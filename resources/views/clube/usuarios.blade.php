<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
     <link rel="stylesheet" href="{{ asset('css/Clube/usuarios/usuarios.css') }}">
    <link rel="stylesheet" href="{{ asset('css/sidebar-clube/sidebar-clube.css') }}">
     <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">


</head>
<body>
        <main class="conteudo-principal">
    <!--NAVBAR LT1-->
    <nav class="barra-lateral" id="barra-lateral">

        <!--ESPAÇO PRA LOGO LT1-->
        <div class="logo-container">
            <!-- LOGO PEQUENA-->
            <img src="../img/logo-reduzida.png" alt="Logo" class="logo-pequena">
            <!--LOGO GRANDE-->
            <img src="../img/logo-completa.png" alt="Logo" class="logo-grande">
            <!--ESPAÇO PRA LOGO LT1-->
        </div>

        <ul class="menu-navegacao">
            <li class=".">
                <a href="../index.html">
                    <i class='bx bx-home-alt'></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="">
                <a href="">
                    <i class='bx bx-briefcase'></i>
                    <span>Oportunidades</span>
                </a>
            </li>
            <li>
                <a href="#">
                    <i class='bx bx-list-ul'></i>
                    <span>Listas</span>
                </a>
            </li>
            <li>
                <a href="#">
                    <i class='bx bx-message-dots'></i>
                    <span>Mensagens</span>
                </a>
            </li>
            <li>
                <a href="#">
                    <i class='bx bx-bell'></i>
                    <span>Notificações</span>
                </a>
            </li>
            <li>
                <a href="#">
                    <i class='bx bx-user'></i>
                    <span>Perfil</span>
                </a>
            </li>
            <li>
                <a href="../tela-pesquisa/pesquisa.html">
                    <i class='bx bx-search'></i>
                    <span>Pesquisa</span>
                </a>
            </li>
            <li  class="ativo">
                <a href="#">
                    <i class='bx bx-cog'></i>
                    <span>Configurações</span>
                </a>
            </li>
            <li>
                  <!-- ===== Barra vermelha antes de SAIR ===== -->
            <hr class="barra-vermelha">   <!-- // ↓↓↓ ALTERADO -->

            <li class="sair-link">        <!-- // ↓↓↓ ALTERADO -->
                <a href="#">
                    <i class='bx bx-log-out'></i>
                    <span>Sair</span>
                </a>
            </li>
        </ul>
    </nav>
    
    <!--NAVBAR LT1-->

    </main>
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
                                @if($perfil->posicoes->count() > 0)
                                    <div class="estatistica-item">
                                        <span class="estatistica-label">Posições</span>

                                        <div class="posicoes">
                                            @foreach($perfil->posicoes as $posicaoPerfil)
                                                <p class="estatistica-value">{{ $perfil->posicaoPerfil->nomePosicao }}</p>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                                
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
                    <span id='lista'>
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