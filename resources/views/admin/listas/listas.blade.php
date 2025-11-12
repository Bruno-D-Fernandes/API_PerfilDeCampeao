<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('css/sidebar/sidebar.css') }}">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/Admin/lista/lista.css') }}">
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
            <li >
                <a href="/admin/dashboard">
                    <i class='bx bx-home-alt'></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li>
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
            <li>
                <a href="/admin/clubes">
                    <i class='bx bx-group'></i>
                    <span>Clubes</span>
                </a>
            </li>
            <li>
                <a href="/admin/funcoes">
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
            <li  class="ativo">
                <a href="/admin/listas">
                    <i class='bx bx-list-ul'></i>
                    <span>Listas</span>
                </a>
            </li>
            <li>
                <a href="/admin/configuracoes/perfil">
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
        <h1 class='titulo'>Listas</h1>
    </main>

    <div class="listas-header">
            <div class="search-box">
                    <i class='bx bx-search'></i>
                    <input type="text" placeholder="Pesquisar">
                </div>
</div>

    <div class="listas" data-storage-url="{{ asset('storage') }}">
        
        

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
                       <span><i class="fa-solid fa-eye"></i></span>
                    </button>

                    <button class="lista-excluir-btn">
                        <span><i class="fa-solid fa-trash"></i></span>
                    </button>
                </div>
            </div>
        @endforeach
    </div>
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
                    Excluir
                </span>
            </button>
        </div>
    </div>

    <script src="{{ asset('js/admin/listas/listas/dom-elements.js') }}"></script>
    <script src="{{ asset('js/admin/listas/listas/utils.js') }}"></script>
    <script src="{{ asset('js/admin/listas/listas/modals.js') }}"></script>
    <script src="{{ asset('js/admin/listas/listas/api.js') }}"></script>
    <script src="{{ asset('js/admin/listas/listas/events.js') }}"></script>
</body>
</html>