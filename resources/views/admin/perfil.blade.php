<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('css/sidebar/sidebar.css') }}">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/Admin/perfil/perfil.css') }}">
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
                <a href="./index.html">
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
            <li>
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
    <h1 class='titulo'>Perfil</h1>
    </main>
 
    <nav class='menu'>
    <ul>
      <li><a href="{{ url('/admin/config/perfil') }}">Perfil</a></li>
      <li><a href="{{ url('/admin/config/notificacoes') }}">Notificações</a></li>
      <li><a href="{{ url('/admin/config/tema') }}">Tema</a></li>
      <li><a href="{{ url('/admin/config/backup') }}">Backup</a></li>
      <li><a href="{{ url('/admin/config/sobre') }}">Sobre</a></li>
    </ul>
  </nav>

  <main>
    @yield('content')
  </main>

  <script src="{{ asset('js/admin/settings/utils.js') }}"></script>
  @yield('scripts')

    <div class="perfil" data-storage-url="{{ asset('storage') }}" data-admin-id="{{ $admin->id }}">

        <div class="info">
            <div class="general">
                <div class="general-profile">
                    <div class="profile-picture">
                        @if($admin->foto_perfil)
                            <img src="{{ asset('storage/' . $admin->foto_perfil) }}" alt="Foto de Perfil">
                        @else
                            @endif
                    </div>

                    <div class="admin">
                        <span class="nome">
                            {{ $admin->nome }}
                        </span>

                        <span class="cargo">
                            Administrador
                        </span>
                    </div>
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
                            {{ $admin->email }}
                        </span>
                    </div>

                    <div class="personal-info-group telefone">
                        <h3>
                            Telefone
                        </h3>

                        <span>
                            @if($admin->telefone)
                                {{ $admin->telefone }}
                            @else
                                (Não informado)
                            @endif
                        </span>
                    </div>

                    <div class="personal-info-group endereco">
                        <h3>
                            Endereço
                        </h3>

                        <span>
                            @if($admin->endereco)
                                {{ $admin->endereco }}
                            @else
                                (Não informado)
                            @endif
                        </span>
                    </div>

                    <div class="personal-info-group data">
                        <h3>
                            Data de nascimento
                        </h3>

                        <span>
                            @if($admin->data_nascimento)
                                {{ \Carbon\Carbon::parse($admin->data_nascimento)
                                    ->locale('pt_BR')
                                    ->translatedFormat('d \d\e F \d\e Y')
                                }}
                            @else
                                (Não informado)
                            @endif
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

                    <<div class="img-preview foto">
                        <img 
                            src="{{ $admin->foto_perfil ? asset('storage/' . $admin->foto_perfil) : '' }}" 
                            alt="Preview" 
                            class="foto-preview" 
                            style="{{ $admin->foto_perfil ? '' : 'display: none;' }}"
                        >
                    </div>

                    <input type="file" name="foto_perfil" id="perfil-form-foto" accept="image/*">
                </div>

                <div class="form-group">
                    <label for="perfil-form-nome">Nome:</label>
                    
                    <input 
                        type="text" 
                        name="nome" 
                        id="perfil-form-nome" 
                        value="{{ trim($admin->nome) }}"
                    >
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

                    <input 
                        type="text" 
                        name="email" 
                        id="informacoes-form-email" 
                        value="{{ $admin->email }}"
                    >
                </div>

                <div class="form-group">
                    <label for="informacoes-form-contato">Telefone:</label>

                    <input 
                        type="text" 
                        name="telefone" 
                        id="informacoes-form-telefone" 
                        value="{{ $admin->telefone }}"
                    >
                </div>

                <div class="form-group">
                    <label for="informacoes-form-endereco">Endereço:</label>

                    <input 
                        type="text" 
                        name="endereco" 
                        id="informacoes-form-endereco" 
                        value="{{ $admin->endereco }}"
                    >
                </div>

                <div class="form-group">
                    <label for="informacoes-form-data">Data de Nascimento:</label>

                    <input 
                        type="date" 
                        name="data_nascimento" 
                        id="informacoes-form-data" 
                        value="{{ $admin->data_nascimento }}"
                    >
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

    <script src="{{ asset('js/admin/perfil/config.js') }}"></script>

</body>
</html>