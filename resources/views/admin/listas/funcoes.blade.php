<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
        <script>(function(){try{var t=localStorage.getItem('admin_theme')||'system';if(t&&t!=='system'){document.documentElement.setAttribute('data-theme',t);}else{document.documentElement.removeAttribute('data-theme');}}catch(e){} })();</script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/Admin/funcoes/funcoes.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
    
    </style>
</head>
<body>
      @include('admin.sidebar.sidebar-adm')

        <h1 class="titulo">Funções</h1>
        <br>

 
     <div class="modal" id="deleteModal">
    <div class="modal-content">
      <div class="success delete">Excluído com sucesso!</div>
    </div>
  </div>

  <div class="modal" id="editModal">
    <div class="modal-content">
      <div class="success edit">Editado com sucesso!</div>
    </div>
  </div>

  <div class="modal" id="addModal">
    <div class="modal-content">
      <div class="success add">Adicionado com sucesso!</div>
    </div>
  </div>

    <div class="modal" id="erroModal">
    <div class="modal-content">
      <div class="success erro">Erro ao Adicinoar Função!</div>
    </div>
  </div>

<div class='header'>
<div class="search-box">
                    <i class='bx bx-search'></i>
                    <input type="text" placeholder="Pesquisar">
                </div>

            <button id="funcao-add-btn">
                <span>
                    Adicionar Função
                </span>
            </button>
        </div>

    <div class="funcoes-container">
    <div class="funcoes">
        <div class="funcoes-header">
            



        </div>

        <div class="list-header">
            <div class="header-col">
                <span>Nome</span>
            </div>

            <div class="header-col">
                <span>Descrição</span>
            </div>

            <div class="header-col">
                <span>Data de cadastro</span>
            </div>

            <div class="header-col">
                <span>Ações</span>
            </div>
        </div>

        @foreach($funcoes as $funcao)
            <div class="funcao" data-funcao-id="{{ $funcao->id }}">
                <div class="funcao-nome">
                    <span>{{ $funcao->nome }}</span>
                </div>

                <div class="funcao-descricao">
                    <span>{{ $funcao->descricao ?? 'Sem descrição' }}</span>
                </div>

                <div class="funcao-data">
                    <span>{{ \Carbon\Carbon::parse($funcao->created_at)
                            ->locale('pt_BR')
                            ->translatedFormat('d \d\e F')
                    }}</span>
                </div>

                <div class="funcao-acoes">
                    <button class="funcao-ver-btn">
                        <span><i class="fa-solid fa-eye"></i></span>
                    </button>

                    <button class="funcao-editar-btn">
                        <span><i class="fa-solid fa-pen"></i></span>
                    </button>

                    <button class="funcao-excluir-btn">
                        <span><i class="fa-solid fa-trash"></i></span>
                    </button>
                </div>
            </div>
        @endforeach
    </div>
    </div>

    <div class="modal-backdrop hidden"></div>

    <div id="funcao-modal" class="app-modal hidden">
        <div class="modal-header">
            <h2 class="modal-title">Adicionar função</h2>
            <button class="close-modal-btn" data-modal-target="funcao-modal">&times;</button>
        </div>

        <form class="modal-body" id="funcao-form">
            <div id="funcao-view">
                <div class="form-group">
                    <label for="funcao-form-nome">Nome:</label>

                    <input type="text" name="nome" id="funcao-form-nome">
                </div>
                <br>

                <div class="form-group">
                    <label for="funcao-form-descricao">Descrição:</label>

                    <input type="text" name="descricao" id="funcao-form-descricao">
                </div>
            </div>
        </form>

        <div class="modal-footer">
            <button id="funcao-cancelar-btn">
                <span>Cancelar</span>
            </button>

            <button id="funcao-salvar-btn">
                <span>Salvar</span>
            </button>
        </div>
    </div>

    <div id="confirmar-modal" class="app-modal hidden">
        <div class="modal-header2">
            <h2 class="modal-title aqui"> Você deseja excluir esta função?</h3>
        </div>
        
        <div class="modal-body">
            <p class="modal-alert">
                Essa ação é irreversível.
            </p>
        </div>

        <div class="modal-footer1">
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
 
    <script src="{{ asset('js/admin/listas/funcoes/dom-elements.js') }}"></script>
    <script src="{{ asset('js/admin/listas/funcoes/utils.js') }}"></script>
    <script src="{{ asset('js/admin/listas/funcoes/modals.js') }}"></script>
    <script src="{{ asset('js/admin/listas/funcoes/api.js') }}"></script>
    <script src="{{ asset('js/admin/listas/funcoes/events.js') }}"></script>
    <script src="{{ asset('js/admin/listas/oportunidades/logout.js') }}"></script>

<script>// Força o primeiro item (Dashboard) como ativo
const dashboardItem = document.querySelector('.menu-navegacao li:nth-child(5)');
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
    const funcoes = Array.from(document.querySelectorAll('.funcao'));

    if (!searchInput || funcoes.length === 0) return;

    // Remove acentos
    const normalize = (texto) => 
        texto.toLowerCase()
            .normalize('NFD')
            .replace(/[\u0300-\u036f]/g, '')
            .trim();

    // Retorna todos os textos pesquisáveis da função
    const getFuncaoTexto = (item) => {
        const nome = item.querySelector('.funcao-nome span')?.textContent || '';
        const descricao = item.querySelector('.funcao-descricao span')?.textContent || '';
        const data = item.querySelector('.funcao-data span')?.textContent || '';

        return normalize(`${nome} ${descricao} ${data}`);
    };

    searchInput.addEventListener('input', () => {
        const termo = normalize(searchInput.value);

        funcoes.forEach(f => {
            const texto = getFuncaoTexto(f);
            const match = termo === '' || texto.includes(termo);

            // Retorna ao display normal do CSS
            f.style.display = match ? "grid" : "none";
        });
    });
});
</script>

</body>
</html>