<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('css/sidebar/sidebar.css') }}">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/Admin/funcoes/funcoes.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
    
    </style>
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
                <a href="./index.html">
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
                    <i class='bx bx-list-ul'></i>
                    <span>Usuarios</span>
                </a>
            </li>
            <li >
                <a href="/admin/clubes">
                    <i class='bx bx-message-dots'></i>
                    <span>Clubes</span>
                </a>
            </li>
            <li class="ativo">
                <a href="#">
                    <i class='bx bx-bell'></i>
                    <span>Funções</span>
                </a>
            </li>
            <li>
                <a href="/admin/esportes">
                    <i class='bx bx-user'></i>
                    <span>Esportes</span>
                </a>
            </li>
            <li>
                <a href="./tela-pesquisa/pesquisa.html">
                    <i class='bx bx-search'></i>
                    <span>Pesquisa</span>
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
        <h1 class="titulo">Funções</h1>
    </main>


<div class='header'>
<div class="search-box">
                    <i class='bx bx-search'></i>
                    <input type="text" placeholder="Pesquisar">
                </div>

            <button id="funcao-add-btn">
                <span>
                    Adicionar Função
                </span>
            </button>
        </div>

    <div class="funcoes-container">
    <div class="funcoes">
        <div class="funcoes-header">
            



        </div>

        <div class="list-header">
            <div class="header-col">
                <span>Nome</span>
            </div>

            <div class="header-col">
                <span>Descrição</span>
            </div>

            <div class="header-col">
                <span>Data de cadastro</span>
            </div>

            <div class="header-col">
                <span>Ações</span>
            </div>
        </div>

        @foreach($funcoes as $funcao)
            <div class="funcao" data-funcao-id="{{ $funcao->id }}">
                <div class="funcao-nome">
                    <span>{{ $funcao->nome }}</span>
                </div>

                <div class="funcao-descricao">
                    <span>{{ $funcao->descricao ?? 'Sem descrição' }}</span>
                </div>

                <div class="funcao-data">
                    <span>{{ \Carbon\Carbon::parse($funcao->created_at)
                            ->locale('pt_BR')
                            ->translatedFormat('d \d\e F')
                    }}</span>
                </div>

                <div class="funcao-acoes">
                    <button class="funcao-ver-btn">
                        <span><i class="fa-solid fa-eye"></i></span>
                    </button>

                    <button class="funcao-editar-btn">
                        <span><i class="fa-solid fa-pen"></i></span>
                    </button>

                    <button class="funcao-excluir-btn">
                        <span><i class="fa-solid fa-trash"></i></span>
                    </button>
                </div>
            </div>
        @endforeach
    </div>
    </div>

    <div class="modal-backdrop hidden"></div>

    <div id="funcao-modal" class="app-modal hidden">
        <div class="modal-header">
            <h2 class="modal-title">Adicionar função</h2>
            <button class="close-modal-btn" data-modal-target="funcao-modal">&times;</button>
        </div>

        <form class="modal-body" id="funcao-form">
            <div id="funcao-view">
                <div class="form-group">
                    <label for="funcao-form-nome">Nome:</label>

                    <input type="text" name="nome" id="funcao-form-nome">
                </div>
                <br>

                <div class="form-group">
                    <label for="funcao-form-descricao">Descrição:</label>

                    <input type="text" name="descricao" id="funcao-form-descricao">
                </div>
            </div>
        </form>

        <div class="modal-footer">
            <button id="funcao-cancelar-btn">
                <span>Cancelar</span>
            </button>

            <button id="funcao-salvar-btn">
                <span>Salvar</span>
            </button>
        </div>
    </div>

    <div id="confirmar-modal" class="app-modal hidden">
        <div class="modal-header">
            <h2 class="modal-title">Você deseja excluir esta função?</h3>
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

    <script src="{{ asset('js/admin/funcoes/dom-elements.js') }}"></script>
    <script src="{{ asset('js/admin/funcoes/utils.js') }}"></script>
    <script src="{{ asset('js/admin/funcoes/modals.js') }}"></script>
    <script src="{{ asset('js/admin/funcoes/api.js') }}"></script>
    <script src="{{ asset('js/admin/funcoes/events.js') }}"></script>
</body>
</html>