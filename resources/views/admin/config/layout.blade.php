<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8" />
  <title>Configurações — Admin</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="stylesheet" href="{{asset('/css/admin/layoutConfig.css')}}">
  <link rel="stylesheet" href="{{ asset('css/admin/sidebar/sidebar.css') }}">
</head>
<body>
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
                <a href="./tela-pesquisa/pesquisa.html">
                    <i class='bx bx-search'></i>
                    <span>Pesquisa</span>
                </a>
            </li>
            <li class="ativo">
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
  <h1>Configurações</h1>

  <nav class="navConfig">
        <h5>Menu</h5>
    <ul>
      <li><img src="{{asset('/img/iconPerfilAdm.png')}}" class="iconEmail" alt=""><a href="{{ url('/admin/config/perfil') }}">Perfil</a></li>
      <li><img src="{{asset('/img/iconNotificacaoAdm.png')}}" class="iconNotifica" alt=""><a href="{{ url('/admin/config/notificacoes') }}">Notificações</a></li>
      <li><img src="{{asset('/img/iconTemaAdm.png')}}" class="iconTema" alt=""><a href="{{ url('/admin/config/tema') }}">Tema</a></li>
      <li><img src="{{asset('/img/iconBackupAdm.png')}}" class="iconBackup" alt=""><a href="{{ url('/admin/config/backup') }}">Backup</a></li>
      <li><img src="{{asset('/img/iconSobreAdm.png')}}" class="iconSobre" alt=""><a href="{{ url('/admin/config/sobre') }}">Sobre</a></li>
    </ul>
  </nav>

  <main>
    @yield('content')
  </main>

  <script src="{{ asset('js/admin/settings/utils.js') }}"></script>
  @yield('scripts')
</body>
</html>