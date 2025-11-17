<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('css/Clube/usuarios/usuarios.css') }}">
    <link rel="stylesheet" href="{{ asset('css/sidebar/sidebar.css') }}">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <script>
        (function() {
            try {
                var t = localStorage.getItem('clube_theme') || 'system';
                if (t && t !== 'system') {
                    document.documentElement.setAttribute('data-theme', t);
                } else {
                    document.documentElement.removeAttribute('data-theme');
                }
            } catch (e) {}
        })();
    </script>
    <meta name="csrf-token" content="{{ csrf_token() }}">


</head>

<body>

    @include('clube.sidebar.sidebar')


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

                    <!-- <button id="add-to-list-btn">
                        <span>
                            Adicionar à lista
                        </span>
                    </button> -->
                </div>
            </div>

            <div class="profile-tabs">
                @foreach($usuario->perfis as $index => $perfil)
                <button
                    class="tab-btn"
                    data-target-tab="perfil-tab-{{ $perfil->id }}">
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
                                    alt="">
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
                                    <p class="estatistica-value">{{ $posicaoPerfil->nomePosicao }}</p>
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
    <script src="{{asset('js/clube/dashboard/logout.js')}}"></script>

    <script>
        // Força o primeiro item (Dashboard) como ativo
        const dashboardItem = document.querySelector('.menu-navegacao li:nth-child(3)');
        if (dashboardItem) {
            dashboardItem.classList.add('ativo');
        }

        // Alternativa: buscar especificamente pelo link do dashboard
        const dashboardLink = document.querySelector('a[href*="admin-clubes"], a[href*="dashboard"]');
        if (dashboardLink && dashboardLink.closest('li')) {
            // Remove ativo de todos primeiro
            menuItems.forEach(item => item.classList.remove('ativo'));
            // Adiciona no dashboard
            dashboardLink.closest('li').classList.add('ativo');
        }
    </script>

</body>

</html>