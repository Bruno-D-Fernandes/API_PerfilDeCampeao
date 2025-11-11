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

        <!--ESPAÇO PRA LOGO LT1-->
        <div class="logo-container">
            <!-- LOGO PEQUENA-->
            <img src="/img/logo-admin-reduzida.jpeg" alt="Logo" class="logo-pequena">
            <!--LOGO GRANDE-->
            <img src="/img/logo-admin-completa.jpeg" alt="Logo" class="logo-grande">
            <!--ESPAÇO PRA LOGO LT1-->
        </div>

        <ul class="menu-navegacao">
            <li class="ativo">
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
            <li >
                <a href="/admin/config/layout">
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
  <!-- <div id="adminProfile">Admin logado</div> -->

  <!-- Cards -->
  <section id="metrics">
    <div class="grupoCardCima">
    <div class="cardCima">
      <h4>Usuários</h4>
      <div id="metricUsers" class="numUser">-</div>
      <img src="/img/usuarioDashAdm.png" alt="" class="imgUserDash">
    </div>

    <div class="cardCima">
      <h4>Clubes</h4>
      <div id="metricClubs" class="numClubes">-</div>
      <img src="/img/clubeDashAdm.png" alt="" class="imgClubeDash">
    </div>
    <div class="cardCima">
      <h4>Oportunidades</h4>
      <div id="metricOpps" class="numOportu">-</div>
    </div>
    <div class="cardCima">
      <h4>Denúncias</h4>
      <div id="metricReports" class="numDenun">—</div>
      <!--<small>(API ainda não implementada)</small>-->
    </div>
    </div>
  </section>

  <!-- Blocos -->
  <main>
    <div class="grupoCardMeio">
    <section class="cardCadaUser">
      <img src="{{asset('/img/cadaUsuarioDashAdmin.png')}}" class="iconUser" alt="">
      <h4>Cadastro de usuários</h4>
      <!--<div id="usersChartPlaceholder">[gráfico futuro]</div>-->
      <select id="usersChartRange" class="tempoCada">
        <option value="6m">6 meses</option>
        <option value="12m">12 meses</option>
        <option value="3m">3 meses</option>
      </select>
    </section>

    <section class="cardUltiOpor">
      <img src="{{asset('/img/oportuDashAdm.png')}}" class="iconOportuUm" alt="">
      <h4>Últimas oportunidades</h4>
      <ul id="latestOpps"></ul>
      <button id="moreOpps">Ver mais</button>
    </section>

    <section class="cardOportuPen">
      <img src="{{asset('/img/oportuDashAdm.png')}}" class="iconOportuDois" alt="">
        <h4>Oportunidades pendentes</h4>
        <ul id="pendingOpps"></ul>
        <button id="morePending" type="button">Ver mais</button>
    </section>

    <section class="cardUltiDenun">
      <img src="{{asset('/img/denunDashAdm.png')}}" class="iconDenun" alt="">
      <h4>Últimas denúncias</h4>
      <ul id="latestReports">
        <!--<li>Em breve: conectar API de denúncias</li>-->
      </ul>
    </section>
</div>
  </main>

  <!-- Ações recentes -->
  <section class="acoes">
    <div class="acoes-topo">
    <h4>Ações recentes</h4>
    <div class="ordenar">
    <label for="orderBy">Ordenar por</label>
    <select id="orderBy" class="selectData">
      <option value="date_desc">Data (mais recente)</option>
      <option value="date_asc">Data (mais antiga)</option>
    </select>
    </div>
    </div>
     <table border="0" cellpadding="4" cellspacing="0">
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

        <!--ESPAÇO PRA LOGO LT1-->
        <div class="logo-container">
            <!-- LOGO PEQUENA-->
            <img src="/img/logo-admin-reduzida.jpeg" alt="Logo" class="logo-pequena">
            <!--LOGO GRANDE-->
            <img src="/img/logo-admin-completa.jpeg" alt="Logo" class="logo-grande">
            <!--ESPAÇO PRA LOGO LT1-->
        </div>

        <ul class="menu-navegacao">
            <li class="ativo">
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
            <li >
                <a href="/admin/config/layout">
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
  <!-- <div id="adminProfile">Admin logado</div> -->

  <!-- Cards -->
  <section id="metrics">
    <div class="grupoCardCima">
    <div class="cardCima">
      <h4>Usuários</h4>
      <div id="metricUsers" class="numUser">-</div>
      <img src="/img/usuarioDashAdm.png" alt="" class="imgUserDash">
    </div>

    <div class="cardCima">
      <h4>Clubes</h4>
      <div id="metricClubs" class="numClubes">-</div>
      <img src="/img/clubeDashAdm.png" alt="" class="imgClubeDash">
    </div>
    <div class="cardCima">
      <h4>Oportunidades</h4>
      <div id="metricOpps" class="numOportu">-</div>
    </div>
    <div class="cardCima">
      <h4>Denúncias</h4>
      <div id="metricReports" class="numDenun">—</div>
      <!--<small>(API ainda não implementada)</small>-->
    </div>
    </div>
  </section>

  <!-- Blocos -->
  <main>
    <div class="grupoCardMeio">
    <section class="cardCadaUser">
      <img src="{{asset('/img/cadaUsuarioDashAdmin.png')}}" class="iconUser" alt="">
      <h4>Cadastro de usuários</h4>
      <!--<div id="usersChartPlaceholder">[gráfico futuro]</div>-->
      <select id="usersChartRange" class="tempoCada">
        <option value="6m">6 meses</option>
        <option value="12m">12 meses</option>
        <option value="3m">3 meses</option>
      </select>
    </section>

    <section class="cardUltiOpor">
      <img src="{{asset('/img/oportuDashAdm.png')}}" class="iconOportuUm" alt="">
      <h4>Últimas oportunidades</h4>
      <ul id="latestOpps"></ul>
      <button id="moreOpps">Ver mais</button>
    </section>

    <section class="cardOportuPen">
      <img src="{{asset('/img/oportuDashAdm.png')}}" class="iconOportuDois" alt="">
        <h4>Oportunidades pendentes</h4>
        <ul id="pendingOpps"></ul>
        <button id="morePending" type="button">Ver mais</button>
    </section>

    <section class="cardUltiDenun">
      <img src="{{asset('/img/denunDashAdm.png')}}" class="iconDenun" alt="">
      <h4>Últimas denúncias</h4>
      <ul id="latestReports">
        <!--<li>Em breve: conectar API de denúncias</li>-->
      </ul>
    </section>
</div>
  </main>

  <!-- Ações recentes -->
  <section class="acoes">
    <div class="acoes-topo">
    <h4>Ações recentes</h4>
    <div class="ordenar">
    <label for="orderBy">Ordenar por</label>
    <select id="orderBy" class="selectData">
      <option value="date_desc">Data (mais recente)</option>
      <option value="date_asc">Data (mais antiga)</option>
    </select>
    </div>
    </div>
     <table border="0" cellpadding="4" cellspacing="0">
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
