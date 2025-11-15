
@php
    $pagina_atual = 'admin-oportunidades';
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <script>(function(){try{var t=localStorage.getItem('clube_theme')||'system';if(t&&t!=='system'){document.documentElement.setAttribute('data-theme',t);}else{document.documentElement.removeAttribute('data-theme');}}catch(e){} })();</script>
    <link rel="stylesheet" href="{{ asset('css/Clube/vars.css') }}">
    <meta charset="UTF-8" [data-theme="dark"]>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Oportunidades</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/Admin/oportunidades/oportunidades.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
  @include('admin.sidebar.sidebar-adm')
</head>
<body>
    
    <!--NAVBAR LT1-->
    <h1 class='titulo'>Oportunidades</h1><br>


         <div class="modal" id="deleteModal">
    <div class="modal-content">
      <div class="success delete">Rejeitada com sucesso!</div>
    </div>
  </div>

  <div class="modal" id="editModal">
    <div class="modal-content">
      <div class="success edit"> Aprovada com sucesso!</div>
    </div>
  </div>

  <div class="modal" id="addModal">
    <div class="modal-content">
      <div class="success add">Adicionado com sucesso!</div>
    </div>
  </div>



    <div class="oportunidades-header">
            
            <div class="search-box">
                    <i class='bx bx-search'></i>
                    <input type="text" placeholder="Pesquisar">
                </div>


        </div>
        </div>

        <div class='total'>
    <div class="oportunidades" data-storage-url="{{ asset('storage') }}">
        

        

        <div class="list-header">
            <div class="header-col">
                <span>Clube</span>
            </div>

            <div class="header-col">
                <span>Esporte</span>
            </div>

            <div class="header-col">
                <span>Posição</span>
            </div>

            <div class="header-col">
                <span>Data de postagem</span>
            </div>
            
            <div class="header-col">
                <span>Inscritos</span>
            </div>

            <div class="header-col">
                <span>Status</span>
            </div>

            <div class="header-col">
                <span>Ações</span>
            </div>
        </div>

        @foreach($oportunidades as $oportunidade)
            <div class="oportunidade" data-oportunidade-id="{{ $oportunidade->id }}">
                <div class="oportunidade-clube">
                    <span>{{ $oportunidade->clube->nomeClube }}</span>
                </div>

                <div class="oportunidade-esporte">
                    <span>{{ $oportunidade->esporte->nomeEsporte }}</span>
                </div>

                <div class="oportunidade-posicao">
                    <span>{{ $oportunidade->posicao->nomePosicao }}</span>
                </div>

                <div class="oportunidade-data">
                    <span>{{ \Carbon\Carbon::parse($oportunidade->datapostagemOportunidades)
                            ->locale('pt_BR')
                            ->translatedFormat('d \d\e F \d\e Y')
                    }}</span>
                </div>

                <div class="oportunidade-inscritos">
                    <span>{{ $oportunidade->inscricoes->count() }}</span>
                </div>

                <div class="oportunidade-status">
                    <span>{{ $oportunidade->showHTMLStatus() }}</span>
                </div>

                <div class="oportunidade-acoes">
                    <button class="oportunidade-ver-btn">
                        <span><i class="fa-solid fa-eye"></i></span>
                    </button>

                    @if ($oportunidade->status === \App\Models\Oportunidade::STATUS_PENDING)
                        <button class="oportunidade-aprovar-btn">
                            <i class='bx bx-check'></i>
                        </button>

                        <button class="oportunidade-rejeitar-btn">
                            <i class='bx bx-x'></i>
                        </button>
                    @else
                        @endif
                </div>
            </div>
        @endforeach
    </div>
    </div>

    <div class="modal-backdrop hidden"></div>

    <div id="oportunidade-modal" class="app-modal hidden">
        <div class="modal-header">
            <h2 class="modal-title">Adicionar oportunidade</h2>
            <button class="close-modal-btn" data-modal-target="oportunidade-modal">&times;</button>
        </div>

        <form class="modal-body detalhes" id="oportunidade-form">
            <div id="oportunidade-view">
                <div class="modal-tabs">
                    <button class="tab-button active" data-target-tab="detalhes-tab" type="button">
                        <span>
                            Detalhes
                        </span>
                    </button>

                    <button class="tab-button" data-target-tab="inscritos-tab" type="button">
                        <span>
                            Inscritos
                        </span>
                    </button>
                    
                </div>

                <div id="detalhes-tab" class="tab-content active">
                    <div class="tab-header">
                        <h3>Detalhes</h3>
                    </div><br>

                    <div class="detalhes-list-container">
                        <div class="detalhe-group">
                            <h4>
                                Data de postagem
                            </h4>

                            <span>
                                <!-- Data formatada aqui -->
                            </span>
                        </div>

                        <div class="detalhe-group">
                            <h4>
                                Descrição
                            </h4>

                            <span>
                                <!-- Descrição aqui -->
                            </span>
                        </div>

                        <div class="detalhe-group">
                            <h4>
                                Requisitos
                            </h4>

                            <span>
                                <!-- Texto com o limite de idades aqui -->
                            </span>
                        </div>

                        <div class="detalhe-group">
                            <h4>
                                Localização
                            </h4>

                            <span>
                                <!-- Localização aqui -->
                            </span>
                        </div>

                        <div class="detalhe-group">
                            <h4>
                                Contexto
                            </h4>

                            <span>
                                <!-- Contexto aqui -->
                            </span>
                        </div>
                    </div>
                </div>

                <div id="inscritos-tab" class="tab-content">
                    <div class="tab-header">
                        <h3>Inscritos</h3>
                    </div>
                    <br>

                    <div class="inscritos-list-container">

                    </div>
                </div>
            </div>
        </form>
    </div>

    <div id="status-modal" class="app-modal hidden">
        <div class="modal-header reject">
            <h2 class="modal-title">Alterar status de oportunidade</h2>

            <button class="close-modal-btn" data-modal-target="status-modal">&times;</button>
        </div>

        <form class="modal-body" id="status-form">
            <div id="status-view">
                <div class="form-group">
                    <label for="rejeicao-status">Motivo:</label>

                    <textarea name="rejection_reason" id="rejeicao-status"></textarea>
                </div>
            </div>
        </form>

        <div class="modal-footer1">
            <button id="cancel-status-btn">
                <span>
                    Cancelar
                </span>
            </button>

            <button id="save-status-btn" >
                <span>
                    Rejeitar
                </span>
            </button>
        </div>
    </div>

    <div id="confirmar-modal" class="app-modal hidden">
        <div class="modal-header">
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
                    Aprovar
                </span>
            </button>
        </div>
    </div>

    <script src="{{ asset('js/admin/listas/oportunidades/dom-elements.js') }}"></script>
    <script src="{{ asset('js/admin/listas/oportunidades/utils.js') }}"></script>
    <script src="{{ asset('js/admin/listas/oportunidades/modals.js') }}"></script>
    <script src="{{ asset('js/admin/listas/oportunidades/api.js') }}"></script>
    <script src="{{ asset('js/admin/listas/oportunidades/events.js') }}"></script>
    <script src="{{ asset('js/admin/listas/oportunidades/logout.js') }}"></script>

<script>// Força o primeiro item (Dashboard) como ativo
const dashboardItem = document.querySelector('.menu-navegacao li:nth-child(2)');
if (dashboardItem) {
    dashboardItem.classList.add('ativo');
}

// Alternativa: buscar especificamente pelo link do dashboard
const dashboardLink = document.querySelector('a[href*="admin-oportundidades"], a[href*="dashboard"]');
if (dashboardLink && dashboardLink.closest('li')) {
    // Remove ativo de todos primeiro
    menuItems.forEach(item => item.classList.remove('ativo'));
    // Adiciona no dashboard
    dashboardLink.closest('li').classList.add('ativo');
}

</script>
</body>
</html>