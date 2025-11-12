<!DOCTYPE html>
<html lang="en">
<head>
    <script>(function(){try{var t=localStorage.getItem('clube_theme')||'system';if(t&&t!=='system'){document.documentElement.setAttribute('data-theme',t);}else{document.documentElement.removeAttribute('data-theme');}}catch(e){} })();</script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('css/sidebar/sidebar.css') }}">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/Admin/oportunidades/oportunidades.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">

</head>
<body>
    <main class="conteudo-principal">
          <h1 class="titulo"></h1>
          <section class="cards-topo">
    <!--NAVBAR LT1-->
    <nav class="barra-lateral" id="barra-lateral">

        <!--ESPAÇO PRA LOGO LT1-->
        <div class="logo-container">
            <!-- LOGO PEQUENA-->
            <img src="../img/logo-admin-reduzida.jpeg" alt="Logo" class="logo-pequena">
            <!--LOGO GRANDE-->
            <img src="../img/logo-admin-completa.jpeg" alt="Logo" class="logo-grande">
            <!--ESPAÇO PRA LOGO LT1-->
        </div>

        <ul class="menu-navegacao">
            <li>
                <a href="/admin/dashboard">
                    <i class='bx bx-home-alt'></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li  class="ativo">
                <a href="">
                    <i class='bx bx-briefcase'></i>
                    <span>Oportunidades</span>
                </a>
            </li>
            <li>
                <a href="/admin/usuarios">
                    <i class='bx bx-user'></i>
                    <span>Usuarios</span>
                </a>
            </li>
            <li >
                <a href="/admin/clubes">
                    <i class='bx bx-group'></i>
                    <span>Clubes</span>
                </a>
            </li>
            <li>
                <a href="#">
                    <i class='bx bx-extension'></i>
                    <span>Funções</span>
                </a>
            </li>
            <li>
                <a href="/admin/esportes">
                    <i class='bx bx-football'></i>
                    <span>Esportes</span>
                </a>
            </li>
            <li>
                <a href="/admin/listas">
                    <i class='bx bx-list-ul'></i>
                    <span>Listas</span>
                </a>
            </li>
            <li>
                <a href="#">
                    <i class='bx bx-cog'></i>
                    <span>Configurações</span>
                </a>
            </li>
            <li>
            <hr class="barra-vermelha">  
            <li class="sair-link"> 
                <a href="#">
                    <i class='bx bx-log-out'></i>
                    <span>Sair</span>
                </a>
            </li>
        </ul>
    </nav>
    <!--NAVBAR LT1-->
    <h1 class='titulo'>Oportunidades</h1>
    </main>

         <div class="modal" id="deleteModal">
    <div class="modal-content">
      <div class="success delete">Rejeitada com sucesso!</div>
    </div>
  </div>

  <div class="modal" id="editModal">
    <div class="modal-content">
      <div class="success edit"> Aprovada com sucesso!</div>
    </div>
  </div>

  <div class="modal" id="addModal">
    <div class="modal-content">
      <div class="success add">Adicionado com sucesso!</div>
    </div>
  </div>



    <div class="oportunidades-header">
            
            <div class="search-box">
                    <i class='bx bx-search'></i>
                    <input type="text" placeholder="Pesquisar">
                </div>


        </div>
        </div>

        <div class='total'>
    <div class="oportunidades" data-storage-url="{{ asset('storage') }}">
        

        

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
                        <span><i class="fa-solid fa-eye"></i></span>
                    </button>

                    @if ($oportunidade->status === \App\Models\Oportunidade::STATUS_PENDING)
                        <button class="oportunidade-aprovar-btn">
                            <i class='bx bx-check'></i>
                        </button>

                        <button class="oportunidade-rejeitar-btn">
                            <i class='bx bx-x'></i>
                        </button>
                    @else
                        @endif
                </div>
            </div>
        @endforeach
    </div>
    </div>

    <div class="modal-backdrop hidden"></div>

    <div id="oportunidade-modal" class="app-modal hidden">
        <div class="modal-header">
            <h2 class="modal-title">Adicionar oportunidade</h2>
            <button class="close-modal-btn" data-modal-target="oportunidade-modal">&times;</button>
        </div>

        <form class="modal-body detalhes" id="oportunidade-form">
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
        <div class="modal-header reject">
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
                    Rejeitar
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
                    Aprovar
                </span>
            </button>
        </div>
    </div>

    <script src="{{ asset('js/admin/listas/oportunidades/dom-elements.js') }}"></script>
    <script src="{{ asset('js/admin/listas/oportunidades/utils.js') }}"></script>
    <script src="{{ asset('js/admin/listas/oportunidades/modals.js') }}"></script>
    <script src="{{ asset('js/admin/listas/oportunidades/api.js') }}"></script>
    <script src="{{ asset('js/admin/listas/oportunidades/events.js') }}"></script>
</body>
</html>