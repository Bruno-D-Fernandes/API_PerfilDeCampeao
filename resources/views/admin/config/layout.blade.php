<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <script>(function(){try{var t=localStorage.getItem('admin_theme')||'system';if(t&&t!=='system'){document.documentElement.setAttribute('data-theme',t);}else{document.documentElement.removeAttribute('data-theme');}}catch(e){} })();</script>
    <link rel="stylesheet" href="{{ asset('css/Clube/vars.css') }}">
  <meta charset="utf-8" />
  <title>Configurações — Admin</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
  <link rel="stylesheet" href="{{asset('/css/admin/layoutConfig.css')}}">
</head>
<body>

@include('admin.sidebar.sidebar-adm')

  <h1>Configurações</h1>

  

  <nav class="navConfig">
  <h5>Menu</h5>
  <ul>
    <li><a href="{{ url('/admin/configuracoes/perfil') }}"><i class='bx bxs-user-circle'></i>Perfil</a></li>
    <!-- <li><a href="{{ url('/admin/configuracoes/notificacoes') }}"><i class='bx bxs-bell'></i>Notificações</a></li> -->
    <li><a href="{{ url('/admin/configuracoes/tema') }}"><i class='bx bxs-paint'></i>Tema</a></li>
    <li><a href="{{ url('/admin/configuracoes/backup') }}"><i class='bx bxs-cloud-download'></i>Backup</a></li>
    <li><a href="{{ url('/admin/configuracoes/sobre') }}"><i class='bx bxs-info-circle'></i>Sobre</a></li>
  </ul>
</nav>

  <main>
    @yield('content')
  </main>


    <script>// Força o primeiro item (Dashboard) como ativo
const dashboardItem = document.querySelector('.menu-navegacao li:nth-child(7)');
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

  <script src="{{ asset('js/admin/settings/utils.js') }}"></script>
  <script src="{{ asset('js/admin/settings/logout.js') }}"></script>

  @yield('scripts')
</body>
</html>