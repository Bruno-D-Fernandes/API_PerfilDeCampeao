<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('css/sidebar/sidebar.css') }}">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/Admin/esporte/esporte.css') }}">
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
                <a href="/admin/oportunidades">
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
            <li  class="ativo"> 
                <a href="#">
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
        <h1 class='titulo'>Esportes</h1>
    </main>
    <!--NAVBAR LT1-->
    
     <div class="modal" id="deleteModal">
    <div class="modal-content">
      <div class="success delete">Excluído com sucesso!</div>
    </div>
  </div>

  <div class="modal" id="editModal">
    <div class="modal-content">
      <div class="success edit">Editado com sucesso!</div>
    </div>
  </div>

  <div class="modal" id="addModal">
    <div class="modal-content">
      <div class="success add">Adicionado com sucesso!</div>
    </div>
  </div>

<div class="esportes-header">
            
        <div class="search-box">
                    <i class='bx bx-search'></i>
                    <input type="text" placeholder="Pesquisar">
                </div>


            <button id="esporte-add-btn">
                <span>
                    Adicionar Esporte
                </span>
            </button>
        </div>

    <div class="esportes-container">
    <div class="esportes">
        

        <div class="list-header">
            <div class="header-col">
                <span>Nome</span>
            </div>

            <div class="header-col">
                <span>Descrição</span>
            </div>

            <div class="header-col">
                <span>Posições</span>
            </div>

            <div class="header-col">
                <span>Características</span>
            </div>

            <div class="header-col">
                <span>Data de cadastro</span>
            </div>

            <div class="header-col">
                <span>Ações</span>
            </div>
        </div>

        @foreach($esportes as $esporte)
            <div class="esporte" data-esporte-id="{{ $esporte->id }}">
                <div class="esporte-nome">
                    <span>{{ $esporte->nomeEsporte }}</span>
                </div>

                <div class="esporte-descricao">
                    <span>{{ $esporte->descricaoEsporte ?? 'Sem descrição' }}</span>
                </div>

                <div class="esporte-posicoes">
                    <span>{{ $esporte->posicoes->count() }}</span>
                </div>

                <div class="esporte-caracteristicas">
                    <span>{{ $esporte->caracteristicas->count() }}</span>
                </div>

                <div class="esporte-data">
                    <span>
                        {{ \Carbon\Carbon::parse($esporte->created_at)
                            ->locale('pt_BR')
                            ->translatedFormat('d \d\e F')
                        }}
                    </span>
                </div>

                <div class="esporte-acoes">
                    <button class="esporte-ver-btn">
                        <span><i class="fa-solid fa-eye"></i></span>
                    </button>

                    <button class="esporte-editar-btn">
                        <span><i class="fa-solid fa-pen"></i></span>
                    </button>

                    <button class="esporte-excluir-btn">
                        <span><i class="fa-solid fa-trash"></i></span>
                    </button>
                </div>
            </div>
        @endforeach
    </div>

    <div class="modal-backdrop hidden"></div>

    <div id="esporte-modal" class="app-modal hidden">
        <div class="modal-header">
            <h2 class="modal-title">Adicionar esporte</h2>
            <button class="close-modal-btn" data-modal-target="esporte-modal">&times;</button>
        </div>

        <form class="modal-body" id="esporte-form">
            <div id="esporte-view">
                <div class="form-group">
                    <label for="esporte-form-nome">Nome:</label>

                    <input type="text" name="nomeEsporte" id="esporte-form-nome">
                </div>
                <br>

                <div class="form-group">
                    <label for="esporte-form-descricao">Descrição:</label>

                    <input type="text" name="descricaoEsporte" id="esporte-form-descricao">
                </div>
            </div>
        
            <div class="modal-tabs">
                <button class="tab-button active" data-target-tab="posicoes-tab" type="button">
                    <span>
                        Posições
                    </span>
                </button>

                <button class="tab-button" data-target-tab="caracteristicas-tab" type="button">
                    <span>
                        Características
                    </span>
                </button>
            </div>

            <div id="posicoes-tab" class="tab-content active">
                <div class="tab-header">
                    <h3>Posições</h3>

                    <button id="posicao-add-btn" type="button">
                        <span>
                            Adicionar posição
                        </span>
                    </button>
                </div>

                <div class="posicoes-list-container">
                    
                </div>
            </div>

            <div id="caracteristicas-tab" class="tab-content">
                <div class="tab-header">
                    <h3>Características</h3>

                    <button id="caracteristica-add-btn" type="button">
                        <span>
                            Adicionar característica
                        </span>
                    </button>
                </div>

                <div class="caracteristicas-list-container">
                    
                </div>
            </div>
        </form>

        <div class="modal-footer">
            <button id="esporte-cancelar-btn">
                <span>Cancelar</span>
            </button>

            <button id="esporte-salvar-btn">
                <span>Salvar</span>
            </button>
        </div>
    </div>

    <div class="modal-backdrop second hidden"></div>

    <div id="posicao-modal" class="app-modal hidden">
        <div class="modal-header">
            <h2 class="modal-title">Adicionar posição</h2>
            <button class="close-modal-btn" data-modal-target="posicao-modal">&times;</button>
        </div>

        <form class="modal-body" id="posicao-form">
            <div id="posicao-view">
                <div class="form-group">
                    <label for="posicao-form-nome">Nome:</label>

                    <input type="text" name="nomePosicao" id="posicao-form-nome">
                </div>
            </div>
        </form>

        <div class="modal-footer">
            <button id="posicao-cancelar-btn">
                <span>Cancelar</span>
            </button>

            <button id="posicao-salvar-btn">
                <span>Salvar</span>
            </button>
        </div>
    </div>

    <div id="caracteristica-modal" class="app-modal hidden">
        <div class="modal-header">
            <h2 class="modal-title">Adicionar característica</h2>
            <button class="close-modal-btn" data-modal-target="caracteristica-modal">&times;</button>
        </div>

        <form class="modal-body" id="caracteristica-form">
            <div id="caracteristica-view">
                <div class="form-group">
                    <label for="caracteristica-form-caracteristica">Característica:</label>

                    <input type="text" name="caracteristica" id="caracteristica-form-caracteristica">
                </div>

                <div class="form-group">
                    <label for="caracteristica-form-unidade">Unidade de medida:</label>

                    <input type="text" name="unidade_medida" id="caracteristica-form-unidade">
                </div>
            </div>
        </form>

        <div class="modal-footer">
            <button id="caracteristica-cancelar-btn">
                <span>Cancelar</span>
            </button>

            <button id="caracteristica-salvar-btn">
                <span>Salvar</span>
            </button>
        </div>
    </div>

    <div id="confirmar-modal" class="app-modal hidden">
        <div class="modal-header excluir">
            <h2 class="modal-title">Você deseja excluir este usuário?</h3>
        </div>
        
        <div class="modal-body">
            <p class="modal-alert">
                Essa ação não será possível reverter.
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
    

    <script src="{{ asset('js/admin/listas/esportes/dom-elements.js') }}"></script>
    <script src="{{ asset('js/admin/listas/esportes/utils.js') }}"></script>
    <script src="{{ asset('js/admin/listas/esportes/modals.js') }}"></script>
    <script src="{{ asset('js/admin/listas/esportes/api.js') }}"></script>
    <script src="{{ asset('js/admin/listas/esportes/events.js') }}"></script>
</body>
</html>