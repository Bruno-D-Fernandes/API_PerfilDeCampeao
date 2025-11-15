<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Pesquisar perfis</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <link rel="stylesheet" href="{{ asset('css/Clube/pesquisa/pesquisa.css') }}">
     <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>

@include('clube.sidebar.sidebar')

<main id="search-root"
      data-endpoint="{{ url('/api/clube/search-usuarios') }}"
      data-profile-url-base="{{ url('/usuario') }}"
>
    <header class='titi'>
        
        <h1 class='titulo'>Pesquisar perfis</h1>
</div>
    </header>

    <section>
        <form id="simple-search-form">
            <label>
                <div class="search-box">
                    <i class='bx bx-search'></i>
                <input type="text" id="pesquisa" name="pesquisa" autocomplete="off" placeholder='Pesquisar clubes, atletas...'>
</div>
            </label>

            <button type="button" id="btn-advanced-search">
                Pesquisa avançada
            </button>
            <br><br>
        </form>

        <div class='total'>
            <div id="active-filters"></div>

            <button type="button" id="btn-open-filters-modal">+</button>

            <button type="button" id="btn-clear-filters">Limpar filtros</button>
        </div>
    </section>

    <div id="filters-modal" hidden>
        <div id="filters-modal-backdrop"></div>

        <div id="filters-modal-panel">
            <header>
                <h2>Filtros avançados</h2>
                <button type="button" id="filters-close">X</button>
            </header>

            <div id="filter-options">
                <button type="button" data-filter-option="localizacao">Localização</button>
                <button type="button" data-filter-option="idade">Idade</button>
                <button type="button" data-filter-option="altura">Altura</button>
                <button type="button" data-filter-option="peso">Peso</button>
            </div>

            <form id="advanced-search-form">
                <section data-filter-panel="localizacao" hidden>
                    <h3>Localização</h3>

                    <div>
                        <label for="estadoUsuario">Estado</label>
                        <input type="text" id="estadoUsuario" name="estadoUsuario">
                    </div>

                    <div>
                        <label for="cidadeUsuario">Cidade</label>
                        <input type="text" id="cidadeUsuario" name="cidadeUsuario">
                    </div>
                </section>

                <section data-filter-panel="idade" hidden>
                    <h3>Idade (anos)</h3>

                    <div>
                        <label for="idade_min">Idade mínima</label>
                        <input type="number" id="idade_min" name="idade_min" min="0" max="120" step="1">
                    </div>

                    <div>
                        <label for="idade_max">Idade máxima</label>
                        <input type="number" id="idade_max" name="idade_max" min="0" max="120" step="1">
                    </div>
                </section>

                <section data-filter-panel="altura" hidden>
                    <h3>Altura (cm)</h3>

                    <div>
                        <label for="altura_min">Altura mínima</label>
                        <input type="number" id="altura_min" name="altura_min" min="50" max="300" step="1">
                    </div>

                    <div>
                        <label for="altura_max">Altura máxima</label>
                        <input type="number" id="altura_max" name="altura_max" min="50" max="300" step="1">
                    </div>
                </section>

                <section data-filter-panel="peso" hidden>
                    <h3>Peso (kg)</h3>

                    <div>
                        <label for="peso_min">Peso mínimo</label>
                        <input type="number" id="peso_min" name="peso_min" min="20" max="500" step="0.1">
                    </div>

                    <div>
                        <label for="peso_max">Peso máximo</label>
                        <input type="number" id="peso_max" name="peso_max" min="20" max="500" step="0.1">
                    </div>
                </section>

                <div>
                    <button type="submit" id="btn-apply-filters">Aplicar filtros</button>
                </div>
            </form>
        </div>
    </div>

    <section id="results-section">
        <header>
            <h2>Resultados</h2>

            <div id="order-wrapper">
                <label for="ordenarpor">Ordenar por</label>
                <select id="ordenarpor" name="ordenarpor">
                    <option value="recentes">Mais recentes</option>
                    <option value="nome">Nome</option>
                    <option value="idade">Idade</option>
                    <option value="altura">Altura</option>
                    <option value="peso">Peso</option>
                    <option value="todos">Sem ordenação específica</option>
                </select>

                <select id="direction" name="direction">
                    <option value="asc">Crescente</option>
                    <option value="desc" selected>Decrescente</option>
                </select>
            </div>
        </header>

        <div id="results-container"></div>

        <footer id="pagination-controls">
            <button type="button" id="btn-prev-page" disabled>Anterior</button>
            <span id="pagination-info"></span>
            <button type="button" id="btn-next-page" disabled>Próxima</button>
        </footer>
    </section>
</main>


    <script src="{{asset('js/clube/pesquisa/api.js')}}"></script>
    <script src="{{asset('js/clube/pesquisa/events.js')}}"></script>
    <script src="{{asset('js/clube/pesquisa/dom-elements.js')}}"></script>
    <script src="{{asset('js/clube/pesquisa/utils.js')}}"></script>
    <script src="{{asset('js/clube/pesquisa/models.js')}}"></script>
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

<script>// Força o primeiro item (Dashboard) como ativo
const dashboardItem = document.querySelector('.menu-navegacao li:nth-child(4)');
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