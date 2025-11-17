

@php
    $pagina_atual = 'admin-listas';
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('css/admin/sidebar/sidebar.css') }}">
        <script>(function(){try{var t=localStorage.getItem('admin_theme')||'system';if(t&&t!=='system'){document.documentElement.setAttribute('data-theme',t);}else{document.documentElement.removeAttribute('data-theme');}}catch(e){} })();</script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/Admin/lista/lista.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
</head>

<body>
    <main id='totaltotal'>
  @include('admin.sidebar.sidebar-adm')

        <h1 class='titulo'>Listas</h1>
        <br>

    <div class="modal" id="deleteModal">
    <div class="modal-content">
      <div class="success delete">Excluído com sucesso!</div>
    </div>
  </div>

          <div class="modal" id="erroModal">
    <div class="modal-content">
      <div class="success erro">Erro ao Excluir a Lista!</div>
    </div>
  </div>

    <div class="listas-header">
            <div class="search-box">
                    <i class='bx bx-search'></i>
                    <input type="text" placeholder="Pesquisar">
                </div>
</div>

    <div class="listas" data-storage-url="{{ asset('storage') }}">
        
        

        <div class="list-header">
            <div class="header-col">
                <span>Nome</span>
            </div>

            <div class="header-col">
                <span>Clube</span>
            </div>

            <div class="header-col">
                <span>Usuários</span>
            </div>

            <div class="header-col">
                <span>Data de criação</span>
            </div>

            <div class="header-col">
                <span>Ações</span>
            </div>
        </div>

        @foreach($listas as $lista)
            <div class="lista" data-lista-id="{{ $lista->id }}">
                <div class="lista-nome">
                    <span>{{ $lista->nome }}</span>
                </div>

                <div class="lista-clube">
                    <span>{{ $lista->clube->nomeClube }}</span>
                </div>

                <div class="lista-usuarios">
                    <span>{{ $lista->usuarios->count() }}</span>
                </div>

                <div class="lista-data">
                    <span>{{ \Carbon\Carbon::parse($lista->created_at)
                        ->locale('pt_BR')
                        ->translatedFormat('d \d\e F \d\e Y') }}
                    </span>
                </div>

                <div class="lista-acoes">
                    <button class="lista-ver-btn">
                       <span><i class="fa-solid fa-eye"></i></span>
                    </button>

                    <button class="lista-excluir-btn">
                        <span><i class="fa-solid fa-trash"></i></span>
                    </button>
                </div>
            </div>
        @endforeach
    </div>
    
    </div>
    </main>
                    

    <div class="modal-backdrop hidden"></div>

    <div id="lista-modal" class="app-modal hidden">
        <div class="modal-header">
            <h2 class="modal-title">Detalhes da lista:</h2>
            <button class="close-modal-btn" data-modal-target="lista-modal">&times;</button>
        </div>

        <div class="modal-body" id="lista-form">
            <div id="lista-view">
                <h3>
                    <!-- Nome da Lista -->
                </h3>

                <span>
                    Criada por: 
                </span><br>

                <span>
                    Descrição: 
                </span>

                <div class="users-list">
                    <span>
                        Usuários (<!-- Quantidade de usuários  -->)
                    </span>

                    <div class="users-list-container">

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="confirmar-modal" class="app-modal hidden">
        <div class="modal-header">
            <h2 class="modal-title">Você deseja excluir esta lista?</h3>
        </div>
        
        <div class="modal-body">
            <p class="modal-alert">
                Essa ação é irreversível.
            </p>
        </div>

        <div class="modal-footer">
            <button id="cancel-confirm-btn">
                <span>
                    Cancelar
                </span>
            </button>

            <button id="save-confirm-btn">
                <span>
                    Excluir
                </span>
            </button>
        </div>
    </div>

    <script src="{{ asset('js/admin/listas/listas/dom-elements.js') }}"></script>
    <script src="{{ asset('js/admin/listas/listas/utils.js') }}"></script>
    <script src="{{ asset('js/admin/listas/listas/modals.js') }}"></script>
    <script src="{{ asset('js/admin/listas/listas/api.js') }}"></script>
    <script src="{{ asset('js/admin/listas/listas/events.js') }}"></script>
    <script src="{{ asset('js/admin/listas/oportunidades/logout.js') }}"></script>

<script>// Força o primeiro item (Dashboard) como ativo
const dashboardItem = document.querySelector('.menu-navegacao li:nth-child(7)');
if (dashboardItem) {
    dashboardItem.classList.add('ativo');
}

// Alternativa: buscar especificamente pelo link do dashboard
const dashboardLink = document.querySelector('a[href*="admin-listas"], a[href*="dashboard"]');
if (dashboardLink && dashboardLink.closest('li')) {
    // Remove ativo de todos primeiro
    menuItems.forEach(item => item.classList.remove('ativo'));
    // Adiciona no dashboard
    dashboardLink.closest('li').classList.add('ativo');
}

</script>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const searchInput = document.querySelector('.search-box input');
    const listas = Array.from(document.querySelectorAll('.lista'));

    if (!searchInput || listas.length === 0) return;

    // Remove acentos
    const normalize = (texto) =>
        texto.toLowerCase()
             .normalize('NFD')
             .replace(/[\u0300-\u036f]/g, '')
             .trim();

    // Retorna todos textos pesquisáveis da lista
    const getListaTexto = (item) => {
        const nome = item.querySelector('.lista-nome span')?.textContent || '';
        const clube = item.querySelector('.lista-clube span')?.textContent || '';
        const usuarios = item.querySelector('.lista-usuarios span')?.textContent || '';
        const data = item.querySelector('.lista-data span')?.textContent || '';

        return normalize(`${nome} ${clube} ${usuarios} ${data}`);
    };

    searchInput.addEventListener('input', () => {
        const termo = normalize(searchInput.value);

        listas.forEach(lista => {
            const texto = getListaTexto(lista);
            const match = termo === '' || texto.includes(termo);

            lista.style.display = match ? 'grid' : 'none';
        });
    });
});
</script>
</body>
</html>