<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
        <script>(function(){try{var t=localStorage.getItem('admin_theme')||'system';if(t&&t!=='system'){document.documentElement.setAttribute('data-theme',t);}else{document.documentElement.removeAttribute('data-theme');}}catch(e){} })();</script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
        <link rel="stylesheet" href="{{ asset('css/Admin/clubes/clubes.css') }}">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="stylesheet" href="{{ asset('css/Clube/vars.css') }}">
    <style>
        .hidden {
            display: none !important;
        }
.clubes-header {
}

.clube, .list-header {

    grid-template-columns: 1.4fr 1fr 1.5fr 1fr 1fr 1fr;
}



/* CORREÇÃO: Adicione estas regras para controlar o overflow */
.clube > div, .list-header > div {
    display: flex;
    align-items: center;
    justify-content: center;
    min-width: 0; /* Permite que o grid encolha a coluna */
    text-overflow: ellipsis; /* Adiciona "..." no texto cortado */
    white-space: nowrap; /* Evita quebra de linha */
}

/* Se você quiser permitir quebra de texto em vez de cortar */
.clube > div.allow-wrap {
    white-space: normal;
    word-break: break-word;
    overflow-wrap: break-word;
}

.clube-acoes {
    display: flex;
    gap: 16px;
    justify-content: center; /* Centraliza os ícones */
}


        .modal-backdrop {
            width: 100%;
            height: 100%;
            position: fixed;
            top: 0;
            left: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 100;
        }

        .app-modal {
            width: 600px;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: #fff;
            z-index: 101;
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .close-modal-btn {
            width: 32px;
            height: 32px;
        }

        .modal-body, .form-group, #clube-view {
            width: 100%;
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .form-group.img {
            align-items: center;
        }

        .form-group.img .img-btns {
            display: flex;
            gap: 16px;
        }

        .form-group label {
            width: 100%;
        }

        .img-preview {
            background-color: #000;
        }

        .img-preview.foto {

            aspect-ratio: 1 / 1;
            border-radius: 100%;
            overflow: hidden;
        }

        .img-preview.banner {
            height: 60px;
            aspect-ratio: 3 / 1;
            overflow: hidden;
        }

        .img-preview img {
            height: 100%;
            width: 100%;
            object-fit: cover;
        }

        .modal-body {
            max-height: 300px;
            overflow-y: auto;
        }

      
    </style>
</head>
<body>
<main id='totaltotal'>
@include('admin.sidebar.sidebar-adm')

        <h1 class='titulo'>Clube</h1>
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
      <div class="success erro">Erro ao Excluir Clube!</div>
    </div>
  </div>

        <div class="modal" id="erroAModal">
    <div class="modal-content">
      <div class="success erro">Erro ao Adicinoar Clube!</div>
    </div>
  </div>

<div class='header' >

 <div class="search-box">
                    <i class='bx bx-search'></i>
                    <input type="text" placeholder="Pesquisar">
                </div>


           <button id="clube-add-btn">
        <span>Adicionar clube</span>
    </button>
        </div>
            
            
    
            </div>

<div class="clubes-container">
    <div class="clubes" data-storage-url="{{ asset('storage') }}">
        <div class="clubes-header">

            
        </div>
        
        <div class="list-header">
            <div class="header-col">
                <span>Nome</span>
            </div>

            <div class="header-col">
                <span>Email</span>
            </div>

            <div class="header-col">
                <span>CNPJ</span>
            </div>

            <div class="header-col">
                <span>Data de Criação</span>
            </div>
            
            <div class="header-col">
                <span>Data de cadastro</span>
            </div>

            <div class="header-col">
                <span>Ações</span>
            </div>
        </div>

        @foreach($clubes as $clube)
            <div class="clube" data-clube-id="{{ $clube->id }}">
                <div class="clube-nome">
                    <span>{{ $clube->nomeClube }}</span>
                </div>

                <div class="clube-email">
                    <span>{{ $clube->emailClube }}</span>
                </div>

                <div class="clube-cnpj">
                    <span>{{ $clube->cnpjClube }}</span>
                </div>

                <div class="clube-ano">
                    <span>{{ \Carbon\Carbon::parse($clube->anoCriacaoClube)
                            ->locale('pt_BR')
                            ->translatedFormat('d \d\e F \d\e Y')
                    }}</span>
                </div>

                <div class="clube-data">
                    <span>{{ \Carbon\Carbon::parse($clube->created_at)
                            ->locale('pt_BR')
                            ->translatedFormat('d \d\e F')
                    }}</span>
                </div>

                <div class="clube-acoes">
                    <button class="clube-ver-btn">
                        <span><i class="fa-solid fa-eye"></i></span>
                    </button>

                    <button class="clube-editar-btn">
                        <span><i class="fa-solid fa-pen"></i></span>
                    </button>

                    <button class="clube-excluir-btn">
                        <span><i class="fa-solid fa-trash"></i></span>
                    </button>
                </div>
            </div>
        @endforeach
    </div>

    </main>

    <div class="modal-backdrop hidden"></div>

    <div id="clube-modal" class="app-modal hidden">
        <div class='azul'>
        <div class="modal-header">
            <h2 class="modal-title">Adicionar clube</h2>
            <button class="close-modal-btn" data-modal-target="clube-modal">&times;</button>
        </div>

        <form class="modal-body" id="clube-form">
            
            <div id="clube-view">
                <div class="form-group img">
                    <label for="clube-form-foto">Foto:</label>

                    <div class="img-preview foto">
                        <img src="" alt="" class="foto-preview" style="display: none;">
                    </div>

                    <input type="file" name="fotoPerfilClube" id="clube-form-foto" accept="image/*">
                    <label for="clube-form-foto" id="sele">Selecionar Foto</label>
                </div>
                

                <div class="form-group img">
                    <label for="clube-form-banner">Banner:</label>

                    <div class="img-preview banner">
                        <img src="" alt="" class="banner-preview" style="display: none;">
                    </div>

                    <input type="file" name="fotoBannerClube" id="clube-form-banner" accept="image/*">
                    <label for="clube-form-banner" id="sele1">Selecionar Banner</label>
                </div>

                <div class="form-group">
                    <label for="clube-form-nome">Nome:</label>

                    <input type="text" name="nomeClube" id="clube-form-nome">
                </div>

                <div class="form-group">
                    <label for="clube-form-email">Email:</label>

                    <input type="text" name="emailClube" id="clube-form-email">
                </div>

                <div class="form-group">
                    <label for="clube-form-cnpj">CNPJ:</label>

                    <input type="text" name="cnpjClube" id="clube-form-cnpj">
                </div>

                <div class="form-group">
                    <label for="clube-form-data">Data de Criação:</label>

                    <input type="date" name="anoCriacaoClube" id="clube-form-data">
                </div>

                <div class="form-group">
                    <label for="clube-form-endereco">Endereço:</label>

                    <input type="text" name="enderecoClube" id="clube-form-endereco">
                </div>

                <div class="form-group">
                    <label for="clube-form-cidade">Cidade:</label>

                    <input type="text" name="cidadeClube" id="clube-form-cidade">
                </div>

                <div class="form-group">
                    <label for="clube-form-estado">Estado:</label>

                    <input type="text" name="estadoClube" id="clube-form-estado">
                </div>

                <div class="form-group">
                    <label for="clube-form-bio">Biografia:</label>

                    <textarea name="bioClube" id="clube-form-bio"></textarea>
                </div>

                <div class="form-group">
                    <label for="clube-form-categoria">Categoria:</label>

                    <select name="categoria_id" id="clube-form-categoria">
                        @foreach($categorias as $categoria)
                            <option value="{{ $categoria->id }}">{{ $categoria->nomeCategoria }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="clube-form-esporte">Esporte:</label>

                    <select name="esporte_id" id="clube-form-esporte">
                        @foreach($esportes as $esporte)
                            <option value="{{ $esporte->id }}">{{ $esporte->nomeEsporte }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            
        </form>
                


        

                    
        <div class="modal-footer">
            <button id="clube-cancelar-btn">
                <span>Cancelar</span>
            </button>

            <button id="clube-salvar-btn">
                <span>Salvar</span>
            </button>
        </div>
    </div>
    </div>

    <div id="confirmar-modal" class="app-modal hidden">
        <div>
        <div class="modal-header excluir">
            <h2 class="modal-title">Você deseja excluir este clube?</h3>
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

    <script src="{{ asset('js/admin/listas/clubes/dom-elements.js') }}"></script>
    <script src="{{ asset('js/admin/listas/clubes/utils.js') }}"></script>
    <script src="{{ asset('js/admin/listas/clubes/modals.js') }}"></script>
    <script src="{{ asset('js/admin/listas/clubes/api.js') }}"></script>
    <script src="{{ asset('js/admin/listas/clubes/events.js') }}"></script>
    <script src="{{ asset('js/admin/listas/oportunidades/logout.js') }}"></script>

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

<script>
document.addEventListener('DOMContentLoaded', () => {
  const searchInput = document.querySelector('.search-box input');
  const clubes = Array.from(document.querySelectorAll('.clube'));

  if (!searchInput || clubes.length === 0) return; // nada a fazer

  const normalize = (s) => (s || '').toString().toLowerCase()
    .normalize('NFD').replace(/[\u0300-\u036f]/g, '') // remove acentos
    .trim();

  const getRowText = (row) => {
    const nome = row.querySelector('.clube-nome span')?.textContent || '';
    const email = row.querySelector('.clube-email span')?.textContent || '';
    const cnpj = row.querySelector('.clube-cnpj span')?.textContent || '';
    // concatena os campos que quiser pesquisar
    return normalize(`${nome} ${email} ${cnpj}`);
  };

  // opcional: mostrar "nenhum resultado" — cria um elemento apenas quando necessário
  let noResultsEl = null;
  const ensureNoResults = () => {
    if (!noResultsEl) {
      noResultsEl = document.createElement('div');
      noResultsEl.className = 'no-results';
      noResultsEl.style.padding = '16px';
      noResultsEl.style.textAlign = 'center';

      document.querySelector('.clubes')?.appendChild(noResultsEl);
    }
  };
  const hideNoResults = () => { if (noResultsEl) noResultsEl.style.display = 'none'; };

  searchInput.addEventListener('input', () => {
    const termo = normalize(searchInput.value);
    let anyVisible = false;

    clubes.forEach(clube => {
      const texto = getRowText(clube);
      const matches = termo === '' || texto.includes(termo);

      clube.style.display = matches ? '' : 'none'; // '' volta para o display definido no CSS (grid)
      if (matches) anyVisible = true;
    });

    if (!anyVisible) {
      ensureNoResults();
      noResultsEl.style.display = 'block';
    } else {
      hideNoResults();
    }
  });
});
</script>

</body>
</html>