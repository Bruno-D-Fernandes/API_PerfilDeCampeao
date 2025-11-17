@php
    $pagina_atual = 'admin-dashboard';
@endphp
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <script>(function(){try{var t=localStorage.getItem('admin_theme')||'system';if(t&&t!=='system'){document.documentElement.setAttribute('data-theme',t);}else{document.documentElement.removeAttribute('data-theme');}}catch(e){} })();</script>
  <link rel="stylesheet" href="{{ asset('css/Clube/vars.css') }}">
  <meta charset="utf-8" />
  <title>Dashboard Admin</title>
  <link rel="stylesheet" href="{{asset('css/admin/dashboard.css')}}">
  <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
  @include('admin.sidebar.sidebar-adm')

  <h1 id='titulo'>Dashboard</h1>
  <!-- <div id="adminProfile">Admin logado</div> -->

  <!-- Cards -->
   <div class="total">
  <section id="metrics">
    <div class="grupoCardCima">
    <div class="cardCima">
      <h4>Usuários</h4>
      <div id="metricUsers" class="numUser">-</div>
      <i class='bx bx-group'></i>
    </div>

    <div class="cardCima">
      <h4>Clubes</h4>
      <div id="metricClubs" class="numClubes">-</div>
      <i class='bx bx-shield'></i>
    </div>
    <div class="cardCima">
      <h4>Oportunidades</h4>
      <div id="metricOpps" class="numOportu">-</div>
      <i class='bx bx-briefcase'></i>
    </div>
<!--     <div class="cardCima">
      <h4>Denúncias</h4>
      <div id="metricReports" class="numDenun">—</div>
    <small>(API ainda não implementada)</small>
    </div> -->
    </div>
  </section>

  <!-- Blocos -->
  <main class="conteudo-principal">
    <div class="grupoCardMeio">
    <!-- <section class="cardCadaUser">
      <img src="{{asset('/img/cadaUsuarioDashAdmin.png')}}" class="iconUser" alt="">
      <h4>Cadastro de usuários</h4>
      <div id="usersChartPlaceholder">[gráfico futuro]</div>
      <select id="usersChartRange" class="tempoCada">
        <option value="6m">6 meses</option>
        <option value="12m">12 meses</option>
        <option value="3m">3 meses</option>
      </select>
    </section> -->

    <section class="cardUltiOpor">
      <img src="{{asset('/img/oportuDashAdm.png')}}" class="iconOportuUm" alt="">
      <h4 style='font-size: 21px;'>Últimas oportunidades</h4> 
      <ul id="latestOpps"></ul>
  <button id="moreOpps" type="button"><a class='ver-mais' href="/admin/oportunidades">Ver mais</a></button>
    </section>

<!--     <section class="cardOportuPen">
      <img src="{{asset('/img/oportuDashAdm.png')}}" class="iconOportuDois" alt="">
        <h4>Oportunidades pendentes</h4>
        <ul id="pendingOpps"></ul>
        <button id="morePending" type="button">Ver mais</button>
    </section> -->

   <!--  <section class="cardUltiDenun">
      <img src="{{asset('/img/denunDashAdm.png')}}" class="iconDenun" alt="">
      <h4>Últimas denúncias</h4>
      <ul id="latestReports">
        <li>Em breve: conectar API de denúncias</li>
      </ul>
    </section> -->
</div>
  </main>

  <!-- Ações recentes -->
  <section class="acoes">
    <div class="acoes-topo">
    <h3>Ações recentes</h3>
 <!--    <div class="ordenar">
    <label for="orderBy">Ordenar por</label>
    <select id="orderBy" class="selectData">
      <option class='nada' value="date_desc">Data (mais recente)</option>
      <option class='nada' value="date_asc">Data (mais antiga)</option>
    </select>
    </div> -->
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
</div>
  <script src="{{ asset('js/admin/dashboard/utils.js') }}"></script>
  <script src="{{ asset('js/admin/dashboard/api.js') }}"></script>
  <script src="{{ asset('js/admin/dashboard/dom-elements.js') }}"></script>
  <script src="{{ asset('js/admin/dashboard/modals.js') }}"></script>
  <script src="{{ asset('js/admin/dashboard/events.js') }}"></script>
  <script src="{{ asset('js/admin/dashboard/logout.js') }}"></script>
  

<script>// Força o primeiro item (Dashboard) como ativo
const dashboardItem = document.querySelector('.menu-navegacao li:first-child');
if (dashboardItem) {
    dashboardItem.classList.add('ativo');
}

// Alternativa: buscar especificamente pelo link do dashboard
const dashboardLink = document.querySelector('a[href*="admin-dashboard"], a[href*="dashboard"]');
if (dashboardLink && dashboardLink.closest('li')) {
    // Remove ativo de todos primeiro
    menuItems.forEach(item => item.classList.remove('ativo'));
    // Adiciona no dashboard
    dashboardLink.closest('li').classList.add('ativo');
}

</script>
</body>
</html>

