
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <script>(function(){try{var t=localStorage.getItem('clube_theme')||'system';if(t&&t!=='system'){document.documentElement.setAttribute('data-theme',t);}else{document.documentElement.removeAttribute('data-theme');}}catch(e){} })();</script>
  <link rel="stylesheet" href="{{ asset('css/clube/vars.css') }}">
  <script src="{{ asset('js/theme-init.js') }}"></script>
  <meta charset="utf-8" />
  <title>Dashboard — Clube</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="stylesheet" href="{{asset('/css/clube/dashboard.css')}}">

    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
@include('clube.sidebar.sidebar')
<h1>Dashboard</h1>

<div class="dashContainer">

  <div class="cards">
    <div class="cardOport">
      <img src="/img/iconOportuDashClube.png" alt="" class="iconOportu">
      <h4>Oportunidades</h4>
      <h5>Ativas</h5>
      <div id="countOppsAtivas" class="oportuAtivas">-</div>
      <a id="linkOppsAtivas" href="/clube/oportunidades">
      <img src="/img/iconAbrirDashClube.png" alt="" class="iconAbrirOportu">
        </a>
    </div>

    <div class="cardCamp">
      <img src="/img/iconCampeDashClube.png" alt="" class="iconCampe">
      <h4>Lista de Campeões</h4>
      <a id="linkListaCampeoes" href="/clube/lista"><img src="/img/iconAbrirDashClube.png" alt="" class="iconAbrirLista"></a>
    </div>

    <section class="cardSug" id="sugestoes">
      <h4>Sugestões</h4>
      <select id="tipoSugestao">
        <option value="Lateral">Lateral</option>
        <option value="Zagueiro">Zagueiro</option>
        <option value="Meia">Meia</option>
        <option value="Atacante">Atacante</option>
        <option value="Goleiro">Goleiro</option>
      </select>

      <ul id="listaSugestoes" class="listaSugestoes"></ul>

      <button= id="VerMaisSugestoes" type="button">Ver mais</button>
    </section>
  </div>

 

  <!-- <div class="interessados">
    <div class="cardInt">
      <h4>Interessados</h4>
    </div>
  </div>
 -->
  <div class="recentes">
    <section class="cardAtiv" id="atividadesRecentes">
      <h2>Atividades recentes</h2>

      <table border="1" cellpadding="4" cellspacing="0">
        <thead>
          <tr>
            <th>Perfil</th>
            <th>Atividade</th>
            <th>Oportunidade</th>
            <th>Data</th>
          </tr>
        </thead>
        <tbody id="recentActivitiesBody"></tbody>
      </table>
    </section>
  </div>

</div>

  <div id="modalRoot"></div>


    <script src="{{ asset('js/clube/dashboard/utils.js') }}"></script>
    <script src="{{ asset('js/clube/dashboard/api.js') }}"></script>
    <script src="{{ asset('js/clube/dashboard/models.js') }}"></script>
    <script src="{{ asset('js/clube/dashboard/dom-elements.js') }}"></script>
    <script src="{{ asset('js/clube/dashboard/events.js') }}"></script>
    <script src="{{asset('js/clube/dashboard/logout.js')}}"></script>

    <script src="{{ asset('js/clube/dashboard/dashboard-atividades.js') }}"></script>
    <script src="{{ asset('js/clube/dashboard/grafico-oportunidades.js') }}"></script>

  

<script>// Força o primeiro item (Dashboard) como ativo
const dashboardItem = document.querySelector('.menu-navegacao li:nth-child(1)');
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

</body>
</html>