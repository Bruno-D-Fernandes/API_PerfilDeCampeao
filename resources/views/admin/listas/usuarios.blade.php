<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script>(function(){try{var t=localStorage.getItem('admin_theme')||'system';if(t&&t!=='system'){document.documentElement.setAttribute('data-theme',t);}else{document.documentElement.removeAttribute('data-theme');}}catch(e){} })();</script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/Admin/usuarios/usuarios.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        
    </style>
</head>
<body>

@include('admin.sidebar.sidebar-adm')

                <h1 class='titulo'>Usuários</h1>
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
      <div class="success erro">Erro ao Excluir Usuario!</div>
    </div>
  </div>

        <div class="modal" id="erroAModal">
    <div class="modal-content">
      <div class="success erro">Erro ao Adicinoar Usuario!</div>
    </div>
  </div>

    
    
    <div class="usuarios">
        <div class="usuarios-header">
            <div class="search-box">
                    <i class='bx bx-search'></i>
                    <input type="text" placeholder="Pesquisar">
                </div>


           <button id="usuario-add-btn">
        <span>Adicionar Usuario</span>
    </button>
        </div>

            <div class='usuarios-container' >
            
               
        <div class="list-header">
            <div class="header-col">
                <span>Nome</span>
            </div>

            <div class="header-col">
                <span>Email</span>
            </div>

            <div class="header-col">
                <span>Genero</span>
            </div>

            <div class="header-col">
                <span>Data de Nascimento</span>
            </div>
            
            <div class="header-col">
                <span>Data de cadastro</span>
            </div>

            <div class="header-col">
                <span>Ações</span>
            </div>
        </div>
        

        @foreach($usuarios as $usuario)
            <div class="usuario" data-usuario-id="{{ $usuario->id }}">
                <div class="usuario-nome">
                    <span>{{ $usuario->nomeCompletoUsuario }}</span>
                </div>

                <div class="usuario-email">
                    <span>{{ $usuario->emailUsuario }}</span>
                </div>

                <div class="usuario-genero">
                    <span>{{ $usuario->generoUsuario ?? 'N/A' }}</span>
                </div>

                <div class="usuario-data-nascimento">
                    <span>{{ \Carbon\Carbon::parse($usuario->dataNascimentoUsuario)
                            ->locale('pt_BR')
                            ->translatedFormat('d \d\e F \d\e Y')
                    }}</span>
                </div>

                <div class="usuario-data">
                    <span>{{ \Carbon\Carbon::parse($usuario->created_at)
                            ->locale('pt_BR')
                            ->translatedFormat('d \d\e F')
                    }}</span>
                </div>

                <div class="usuario-acoes">
                    <button class="usuario-ver-btn">
                        <span><i class="fa-solid fa-eye"></i></span>
                    </button>

                    <button class="usuario-editar-btn">
                        <span><i class="fa-solid fa-pen"></i></span>
                    </button>

                    <button class="usuario-excluir-btn">
                        <span><i class="fa-solid fa-trash"></i></span>
                    </button>
                </div>
            </div>
        @endforeach
    </div>
    </div>

    <div class="modal-backdrop hidden"></div>

    <div id="usuario-modal" class="app-modal hidden">
        <div class="modal-header">
            <h2 class="modal-title">Adicionar Usuário</h2>
            <button class="close-modal-btn" data-modal-target="usuario-modal">&times;</button>
        </div>

        <form class="modal-body" id="usuario-form">
            <div id="usuario-view">
                <div class="form-group img">
                    <label for="usuario-form-foto">Foto:</label>

                    <div class="img-preview foto">
                        <img src="" alt="" class="foto-preview" style="display: none;">
                    </div>

                    <input type="file" name="fotoPerfilUsuario" id="usuario-form-foto" accept="image/*">
                </div>

                <div class="form-group img">
                    <label for="usuario-form-banner">Banner:</label>

                    <div class="img-preview banner">
                        <img src="" alt="" class="banner-preview" style="display: none;">
                    </div>

                    <input type="file" name="fotoBannerUsuario" id="usuario-form-banner" accept="image/*">
                </div>

                <div class="form-group">
                    <label for="usuario-form-nome">Nome:</label>

                    <input type="text" name="nomeCompletoUsuario" id="usuario-form-nome">
                </div>

                <div class="form-group">
                    <label for="usuario-form-email">Email:</label>

                    <input type="text" name="emailUsuario" id="usuario-form-email">
                </div>

<div class="form-group">
    <label for="usuario-form-genero">Gênero:</label>
    <select  name="generoUsuario" id="usuario-form-genero">
        <option value="" disabled>Selecione...</option>
        <option value="Masculino">Masculino</option>
        <option value="Feminino">Feminino</option>
        <option value="Outro">Outro</option>
    </select>
</div>

                <div class="form-group">
                    <label for="usuario-form-data">Data de Nascimento:</label>

                    <input type="date" name="dataNascimentoUsuario" id="usuario-form-data">
                </div>

                <div class="form-group">
                    <label for="usuario-form-cidade">Cidade:</label>

                    <input type="text" name="cidadeUsuario" id="usuario-form-cidade">
                </div>

                <div class="form-group">
                    <label for="usuario-form-estado">Estado:</label>

                    <input type="text" name="estadoUsuario" id="usuario-form-estado">
                </div>

                <div class="form-group">
                    <label for="usuario-form-altura">Altura (cm):</label>

                    <input type="number" name="alturaCm" id="usuario-form-altura" min="50" max="300">
                </div>

                <div class="form-group">
                    <label for="usuario-form-peso">Peso (kg):</label>

                    <input type="number" name="pesoKg" id="usuario-form-peso" step="0.1" lang="pt-BR" min="20" max="500">
                </div>

                <div class="form-group">
                    <label for="usuario-form-pe">Pé dominante:</label>

                    <select name="peDominante" id="usuario-form-pe">
                        <option value="Esquerdo">Esquerdo</option>
                        <option value="Direito">Direito</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="usuario-form-mao">Mão dominante:</label>

                    <select name="maoDominante" id="usuario-form-mao">
                        <option value="Canhoto">Canhoto</option>
                        <option value="Destro">Destro</option>
                    </select>
                </div>
            </div>
        </form>

        <div class="modal-footer">
            <button id="usuario-cancelar-btn">
                <span>Cancelar</span>
            </button>

            <button id="usuario-salvar-btn">
                <span>Salvar</span>
            </button>
        </div>
    </div>

    <div id="confirmar-modal" class="app-modal hidden">
        <div class="modal-header excluir">
            <h2 class="modal-title">Você deseja excluir este usuario?</h3>
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

    <script src="{{ asset('js/admin/listas/usuarios/dom-elements.js') }}"></script>
    <script src="{{ asset('js/admin/listas/usuarios/utils.js') }}"></script>
    <script src="{{ asset('js/admin/listas/usuarios/modals.js') }}"></script>
    <script src="{{ asset('js/admin/listas/usuarios/api.js') }}"></script>
    <script src="{{ asset('js/admin/listas/usuarios/events.js') }}"></script>
    <script src="{{ asset('js/admin/listas/oportunidades/logout.js') }}"></script>

    <script>// Força o primeiro item (Dashboard) como ativo
const dashboardItem = document.querySelector('.menu-navegacao li:nth-child(3)');
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
const searchInput = document.querySelector(".search-box input");

function getUserRows() {
    return document.querySelectorAll(".usuario");
}

searchInput.addEventListener("input", () => {
    const termo = searchInput.value.toLowerCase().trim();
    const userRows = getUserRows(); // ← sempre atualizado

    userRows.forEach(row => {
        const nome = row.querySelector(".usuario-nome span")?.textContent.toLowerCase() || "";

        if (nome.includes(termo)) {
            row.style.display = "grid"; 
        } else {
            row.style.display = "none";
        }
    });
});
</script>

</body>
</html> 