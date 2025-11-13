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
    <link rel="stylesheet" href="{{ asset('css/sidebar/sidebar.css') }}">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
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
                <a href="{{route('clube-dashboard')}}">
                    <i class='bx bx-home-alt'></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li>
                <a href="{{route('clube-oportunidades')}}">
                    <i class='bx bx-briefcase'></i>
                    <span>Oportunidades</span>
                </a>
            </li>
            <!-- <li>
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
            </li> -->
            <li>
               <a id='verPerfil' href="#">
                    <i class='bx bx-user'></i>
                    <span>Perfil</span>
                </a>
            </li>
            <li>
                <a href="{{route('clube-pesquisa')}}">
                    <i class='bx bx-search'></i>
                    <span>Pesquisa</span>
                </a>
            </li>
            <li>
                <a href="{{route('clube-configuracoes')}}">
                    <i class='bx bx-cog'></i>
                    <span>Configurações</span>
                </a>
            </li>
            <li>
                  <!-- ===== Barra vermelha antes de SAIR ===== -->
            <hr class="barra-vermelha">   <!-- // ↓↓↓ ALTERADO -->

            <li class="sair-link">        <!-- // ↓↓↓ ALTERADO -->
                <form id="logout">
                    <button class="logout" type="submit"><i class='bx bx-log-out'></i>
                      <span>Sair</span>
                  </button>
                </form>
            </li>
        </ul>
    </nav>
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

  <div class="interessados">
    <div class="cardInt">
      <h4>Interessados</h4>
    </div>
  </div>

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

    <script>
document.addEventListener("DOMContentLoaded", async () => {
    const token = localStorage.getItem('clube_token'); // o token salvo no login

    if (!token) {
        console.error("Token não encontrado!");
        return;
    }

    try {
        const response = await fetch('/api/clube/perfil', {
            headers: {
                'Authorization': 'Bearer ' + token,
                'Accept': 'application/json'
            }
        });
        const data = await response.json();
        
        if (data.id) {
            console.log("ID do Clube:", data.id);
            localStorage.setItem('clube_id', data.id);
        } else {
            console.error("Erro ao buscar ID do clube:", data);
        }
    } catch (err) {
        console.error("Falha na requisição:", err);
    }
});


 const linkPerfil = document.getElementById('verPerfil');

  // Adiciona o evento de clique
  linkPerfil.addEventListener('click', function (event) {
    event.preventDefault(); // impede o link de redirecionar imediatamente

    // Pega o ID do clube do localStorage
    const clubeId = localStorage.getItem('clube_id');

    if (clubeId) {
      // Redireciona para a URL desejada
      window.location.href = `/clube/${clubeId}`;
    } else {
      alert('Nenhum clube_id encontrado no localStorage!');
    }
  });

</script>
</body>
</html>