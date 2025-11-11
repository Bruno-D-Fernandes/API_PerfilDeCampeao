<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8" />
  <title>Configurações — Admin</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    <h1>Configurações</h1>

    <nav>
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

  <script src="{{ asset('js/admin/configuracoes/utils.js') }}"></script>

  @yield('scripts')
</body>
</html>