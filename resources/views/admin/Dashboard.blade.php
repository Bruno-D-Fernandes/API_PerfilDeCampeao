<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8" />
  <title>Dashboard Admin</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="stylesheet" href="{{asset('/css/admin/dashboard.css')}}">
  <link rel="stylesheet" href="{{ asset('css/admin/sidebar/sidebar.css') }}">
  <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
  <nav class="barra-lateral" id="barra-lateral">
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
  <h1>Dashboard</h1>
  <div id="adminProfile">Admin logado</div>

  <!-- Cards -->
  <section id="metrics">
    <div>
      <h6>Usuários</h6>
      <div id="metricUsers">-</div>
    </div>
    <div>
      <h2>Clubes</h2>
      <div id="metricClubs">-</div>
    </div>
    <div>
      <h2>Oportunidades</h2>
      <div id="metricOpps">-</div>
    </div>
    <div>
      <h2>Denúncias</h2>
      <div id="metricReports">—</div>
      <small>(API ainda não implementada)</small>
    </div>
  </section>

  <!-- Blocos -->
  <main>
    <section>
      <h3>Cadastro de usuários</h3>
      <div id="usersChartPlaceholder">[gráfico futuro]</div>
      <select id="usersChartRange">
        <option value="6m">6 meses</option>
        <option value="12m">12 meses</option>
        <option value="3m">3 meses</option>
      </select>
    </section>

    <section>
      <h3>Últimas oportunidades</h3>
      <ul id="latestOpps"></ul>
      <button id="moreOpps">Ver mais</button>
    </section>

    <section>
        <h3>Oportunidades pendentes</h3>
        <ul id="pendingOpps"></ul>
        <button id="morePending" type="button">Ver mais</button>
    </section>

    <section>
      <h3>Últimas denúncias</h3>
      <ul id="latestReports">
        <li>Em breve: conectar API de denúncias</li>
      </ul>
    </section>

  </main>

  <!-- Ações recentes -->
  <section>
    <h3>Ações recentes</h3>

    <label for="orderBy">Ordenar por</label>
    <select id="orderBy">
      <option value="date_desc">Data (mais recente)</option>
      <option value="date_asc">Data (mais antiga)</option>
    </select>

     <table border="1" cellpadding="4" cellspacing="0">
      <thead>
        <tr>
          <th>Data</th>
          <th>Objeto</th>
          <th>Ação</th>
          <th>Entidade</th>
          <th>Tipo de Entidade</th>
          <th>Descrição</th>
          <th>Status</th>
        </tr>
      </thead>
      <tbody id="recentActionsBody"></tbody>
    </table>
  </section>

  <script src="{{ asset('js/admin/dashboard/utils.js') }}"></script>
  <script src="{{ asset('js/admin/dashboard/api.js') }}"></script>
  <script src="{{ asset('js/admin/dashboard/dom-elements.js') }}"></script>
  <script src="{{ asset('js/admin/dashboard/modals.js') }}"></script>
  <script src="{{ asset('js/admin/dashboard/events.js') }}"></script>

</body>
</html>
