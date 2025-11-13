<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <script>(function(){try{var t=localStorage.getItem('clube_theme')||'system';if(t&&t!=='system'){document.documentElement.setAttribute('data-theme',t);}else{document.documentElement.removeAttribute('data-theme');}}catch(e){} })();</script>
    <link rel="stylesheet" href="{{ asset('css/Clube/vars.css') }}">
  <meta charset="utf-8" />
  <title>Configurações — Admin</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
  <link rel="stylesheet" href="{{asset('/css/admin/layoutConfig.css')}}">
  <link rel="stylesheet" href="{{ asset('css/admin/sidebar/sidebar.css') }}">
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
            <img src="/img/logo-admin-reduzida.jpeg" alt="Logo" class="logo-pequena">
            <!--LOGO GRANDE-->
            <img src="/img/logo-admin-completa.jpeg" alt="Logo" class="logo-grande">
            <!--ESPAÇO PRA LOGO LT1-->
        </div>

        <ul class="menu-navegacao">
            <li>
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
                <a href="#">
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
            <li>
                <a href="/admin/listas">
                    <i class='bx bx-list-ul'></i>
                    <span>Lista</span>
                </a>
            </li>
            <li class="ativo">
                <a href="/admin/configuracoes/perfil">
                    <i class='bx bx-cog'></i>
                    <span>Configurações</span>
                </a>
            </li>
            <li>
            <hr class="barra-vermelha">  
            <li class="sair-link"> 
                <form id="logout">
                    <button class="logout" type="submit"><i class='bx bx-log-out'></i>
                      <span>Sair</span>
                  </button>
                </form>
            </li>
        </ul>
    </nav>
    <!--NAVBAR LT1-->
    </main>
  <h1>Configurações</h1>

  <nav class="navConfig">
  <h5>Menu</h5>
  <ul>
    <li><a href="{{ url('/admin/configuracoes/perfil') }}"><i class='bx bxs-user-circle'></i>Perfil</a></li>
    <li><a href="{{ url('/admin/configuracoes/notificacoes') }}"><i class='bx bxs-bell'></i>Notificações</a></li>
    <li><a href="{{ url('/admin/configuracoes/tema') }}"><i class='bx bxs-paint'></i>Tema</a></li>
    <li><a href="{{ url('/admin/configuracoes/backup') }}"><i class='bx bxs-cloud-download'></i>Backup</a></li>
    <li><a href="{{ url('/admin/configuracoes/sobre') }}"><i class='bx bxs-info-circle'></i>Sobre</a></li>
  </ul>
</nav>

  <main>
    @yield('content')
  </main>


  <script src="{{ asset('js/admin/settings/utils.js') }}"></script>
  <script src="{{ asset('js/admin/settings/logout.js') }}"></script>

  @yield('scripts')
</body>
</html>