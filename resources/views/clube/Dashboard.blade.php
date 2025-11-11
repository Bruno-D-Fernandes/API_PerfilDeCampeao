<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8" />
  <title>Dashboard — Clube</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="stylesheet" href="{{asset('/css/clube/dashboard.css')}}">
    <link rel="stylesheet" href="{{ asset('css//clube/sidebar/sidebar.css') }}">
</head>
<body>
<nav class="barra-lateral" id="barra-lateral">

        <!--ESPAÇO PRA LOGO LT1-->
        <div class="logo-container">
            <!-- LOGO PEQUENA-->
            <img src="../img/logo-clube-reduzida.png" alt="Logo" class="logo-pequena">
            <!--LOGO GRANDE-->
            <img src="../img/logo-clube-completa.jpeg" alt="Logo" class="logo-grande">
            <!--ESPAÇO PRA LOGO LT1-->
        </div>

        <ul class="menu-navegacao">
            <li class="ativo">
                <a href="./index.html">
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
<h1>Dashboard</h1>

<div class="dashContainer">

  <div class="cards">
    <div class="cardOport">
      <h5>Oportunidades (ativas)</h5>
      <div id="countOppsAtivas">-</div>
      <a id="linkOppsAtivas" href="/clube/oportunidades">abrir</a>
    </div>

    <div class="cardCamp">
      <h5>Lista de Campeões</h5>
      <a id="linkListaCampeoes" href="/clube/lista">ver lista</a>
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

      <ul id="listaSugestoes"></ul>

      <button= id="VerMaisSugestoes" type="button">Ver mais</button>
    </section>
  </div>

  <div class="interessados">
    <div class="cardInt">
      <h4>Interessados</h4>
    </div>
  </div>

  <div class="recentes">
    <section class="cardAtiv" id="atividadesRecentes">
      <h3>Atividades recentes</h3>

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

</body>
</html>