<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
        <script>(function(){try{var t=localStorage.getItem('admin_theme')||'system';if(t&&t!=='system'){document.documentElement.setAttribute('data-theme',t);}else{document.documentElement.removeAttribute('data-theme');}}catch(e){} })();</script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/Admin/esporte/esporte.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">

</head>

<body>

<main id='totaltotal'>

 @include('admin.sidebar.sidebar-adm')

        <h1 class='titulo'>Esportes</h1>
        <br>

    <!--NAVBAR LT1-->
    
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
      <div class="success erro">Erro ao Adicinoar Posição!</div>
    </div>
  </div>

  <div class="modal" id="esporteModal">
    <div class="modal-content">
      <div class="success erro">Erro ao Adicinoar Esporte!</div>
    </div>
  </div>

   <div class="modal" id="caraModal">
    <div class="modal-content">
      <div class="success erro">Erro ao Adicinoar Caracteristica!</div>
    </div>
  </div>

<div class="esportes-header">
            
        <div class="search-box">
                    <i class='bx bx-search'></i>
                    <input type="text" placeholder="Pesquisar">
                </div>


            <button id="esporte-add-btn">
                <span>
                    Adicionar Esporte
                </span>
            </button>
        </div>

    <div class="esportes-container">
    <div class="esportes">
        

        <div class="list-header">
            <div class="header-col">
                <span>Nome</span>
            </div>

            <div class="header-col">
                <span>Descrição</span>
            </div>

            <div class="header-col">
                <span>Posições</span>
            </div>

            <div class="header-col">
                <span>Características</span>
            </div>

            <div class="header-col">
                <span>Data de cadastro</span>
            </div>

            <div class="header-col">
                <span>Ações</span>
            </div>
        </div>

        @foreach($esportes as $esporte)
            <div class="esporte" data-esporte-id="{{ $esporte->id }}">
                <div class="esporte-nome">
                    <span>{{ $esporte->nomeEsporte }}</span>
                </div>

                <div class="esporte-descricao">
                    <span>{{ $esporte->descricaoEsporte ?? 'Sem descrição' }}</span>
                </div>

                <div class="esporte-posicoes">
                    <span>{{ $esporte->posicoes->count() }}</span>
                </div>

                <div class="esporte-caracteristicas">
                    <span>{{ $esporte->caracteristicas->count() }}</span>
                </div>

                <div class="esporte-data">
                    <span>
                        {{ \Carbon\Carbon::parse($esporte->created_at)
                            ->locale('pt_BR')
                            ->translatedFormat('d \d\e F')
                        }}
                    </span>
                </div>

                <div class="esporte-acoes">
                    <button class="esporte-ver-btn">
                        <span><i class="fa-solid fa-eye"></i></span>
                    </button>

                    <button class="esporte-editar-btn">
                        <span><i class="fa-solid fa-pen"></i></span>
                    </button>

                    <button class="esporte-excluir-btn">
                        <span><i class="fa-solid fa-trash"></i></span>
                    </button>
                </div>
            </div>
        @endforeach
    </div>
                    </main>

    <div class="modal-backdrop hidden"></div>

    <div id="esporte-modal" class="app-modal hidden">
        <div class="modal-header">
            <h2 class="modal-title">Adicionar esporte</h2>
            <button class="close-modal-btn" data-modal-target="esporte-modal">&times;</button>
        </div>

        <form class="modal-body" id="esporte-form">
            <div id="esporte-view">
                <div class="form-group">
                    <label for="esporte-form-nome">Nome:</label>

                    <input type="text" name="nomeEsporte" id="esporte-form-nome">
                </div>
                <br>

                <div class="form-group">
                    <label for="esporte-form-descricao">Descrição:</label>

                    <input type="text" name="descricaoEsporte" id="esporte-form-descricao">
                </div>
            </div>
        <div class='pfvv'>
            <div class="modal-tabs">
                <button class="tab-button active" id='posicao' data-target-tab="posicoes-tab" type="button">
                    <span>
                        Posições
                    </span>
                </button>

                <button class="tab-button" id='caracteristica' data-target-tab="caracteristicas-tab" type="button">
                    <span>
                        Características
                    </span>
                </button>
            </div>

            <div id="posicoes-tab" class="tab-content active">
                <div class="tab-header">
                    <h3>Posições</h3>

                    <button id="posicao-add-btn" type="button">
                        <span>
                            Adicionar posição
                        </span>
                    </button>
                </div>

                <div class="posicoes-list-container">
                    
                </div>
            </div>

            <div id="caracteristicas-tab" class="tab-content">
                <div class="tab-header">
                    <h3>Características</h3>

                    <button id="caracteristica-add-btn" type="button">
                        <span>
                            Adicionar característica
                        </span>
                    </button>
                </div>

                <div class="caracteristicas-list-container">
                    
                </div>
            </div>
            </div>
        </form>

        <div class="modal-footer">
            <button id="esporte-cancelar-btn">
                <span>Cancelar</span>
            </button>

            <button id="esporte-salvar-btn">
                <span>Salvar</span>
            </button>
        </div>
    </div>

    <div class="modal-backdrop second hidden"></div>

    <div id="posicao-modal" class="app-modal hidden">
        <div class="modal-header">
            <h2 class="modal-title">Adicionar posição</h2>
            <button class="close-modal-btn" data-modal-target="posicao-modal">&times;</button>
        </div>

        <form class="modal-body" id="posicao-form">
            <div id="posicao-view">
                <div class="form-group">
                    <label for="posicao-form-nome">Nome:</label>

                    <input type="text" name="nomePosicao" id="posicao-form-nome">
                </div>
            </div>
        </form>

        <div class="modal-footer">
            <button id="posicao-cancelar-btn">
                <span>Cancelar</span>
            </button>

            <button id="posicao-salvar-btn">
                <span>Salvar</span>
            </button>
        </div>
    </div>

    <div id="caracteristica-modal" class="app-modal hidden">
        <div class="modal-header">
            <h2 class="modal-title">Adicionar característica</h2>
            <button class="close-modal-btn" data-modal-target="caracteristica-modal">&times;</button>
        </div>

        <form class="modal-body" id="caracteristica-form">
            <div id="caracteristica-view">
                <div class="form-group">
                    <label for="caracteristica-form-caracteristica">Característica:</label>

                    <input type="text" name="caracteristica" id="caracteristica-form-caracteristica">
                </div>

                <div class="form-group">
                    <label for="caracteristica-form-unidade">Unidade de medida:</label>

                    <input type="text" name="unidade_medida" id="caracteristica-form-unidade">
                </div>
            </div>
        </form>

        <div class="modal-footer">
            <button id="caracteristica-cancelar-btn">
                <span>Cancelar</span>
            </button>

            <button id="caracteristica-salvar-btn">
                <span>Salvar</span>
            </button>
        </div>
    </div>

    <div id="confirmar-modal" class="app-modal hidden">
        <div class="modal-header excluir">
            <h2 class="modal-title">Você deseja excluir este usuário?</h3>
        </div>
        
        <div class="modal-body">
            <p class="modal-alert">
                Essa ação não será possível reverter.
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
    <script src="{{ asset('js/thema-dark/script.js') }}"></script>
    <script src="{{ asset('js/admin/listas/esportes/ativo.js') }}"></script>
    <script src="{{ asset('js/admin/listas/esportes/dom-elements.js') }}"></script>
    <script src="{{ asset('js/admin/listas/esportes/utils.js') }}"></script>
    <script src="{{ asset('js/admin/listas/esportes/modals.js') }}"></script>
    <script src="{{ asset('js/admin/listas/esportes/api.js') }}"></script>
    <script src="{{ asset('js/admin/listas/esportes/events.js') }}"></script>
    <script src="{{ asset('js/admin/listas/oportunidades/logout.js') }}"></script>


    <script>// Força o primeiro item (Dashboard) como ativo
const dashboardItem = document.querySelector('.menu-navegacao li:nth-child(6)');
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

<script>
document.addEventListener('DOMContentLoaded', () => {
    const searchInput = document.querySelector('.search-box input');
    const esportes = Array.from(document.querySelectorAll('.esporte'));

    if (!searchInput || esportes.length === 0) return;

    // Remove acentos
    const normalize = (texto) =>
        texto.toLowerCase()
             .normalize('NFD')
             .replace(/[\u0300-\u036f]/g, '')
             .trim();

    // Junta todo o texto pesquisável do esporte
    const getEsporteTexto = (item) => {
        const nome = item.querySelector('.esporte-nome span')?.textContent || '';
        const descricao = item.querySelector('.esporte-descricao span')?.textContent || '';
        const posicoes = item.querySelector('.esporte-posicoes span')?.textContent || '';
        const caracteristicas = item.querySelector('.esporte-caracteristicas span')?.textContent || '';
        const data = item.querySelector('.esporte-data span')?.textContent || '';

        return normalize(`${nome} ${descricao} ${posicoes} ${caracteristicas} ${data}`);
    };

    searchInput.addEventListener('input', () => {
        const termo = normalize(searchInput.value);

        esportes.forEach(esporte => {
            const texto = getEsporteTexto(esporte);
            const match = termo === '' || texto.includes(termo);

            esporte.style.display = match ? 'grid' : 'none';
        });
    });
});
</script>

</body>
</html>