<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <script>(function(){try{var t=localStorage.getItem('clube_theme')||'system';if(t&&t!=='system'){document.documentElement.setAttribute('data-theme',t);}else{document.documentElement.removeAttribute('data-theme');}}catch(e){} })();</script>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Oportunidades</title>




<!-- O CODIGO TA MUITO ESTRUTURADO AGR PARA NAO SE PERDER, MANTER ORGANIZADO POR FAVORRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRR-->






  <!-- CSS (Bootstrap + seus estilos) -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/clube/vars.css') }}">
  <link rel="stylesheet" href="{{ asset('/css/clube/oportunidade/oportunidadesClube.css') }}">
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
  <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
  <!-- =================== START: SIDEBAR =================== -->
 

   @include('clube.sidebar.sidebar')

      <div class="modala" id="addModal">
    <div class="modal-contenta">
      <div class="success add">Adicionado com sucesso!</div>
    </div>
  </div>

<div class="modala" id="deleteModal">
  <div class="modal-contenta">
    <div class="success delete">Excluído com sucesso!</div>
    <button class='sumir4' id="deleteOk">OK</button>
    <button class='sumir4' id="deleteCancel">Cancelar</button>
  </div>
</div>

  <div class="modala" id="editModal">
    <div class="modal-contenta">
      <div class="success edit">Editado com sucesso!</div>
    </div>
  </div>
  <!-- =================== END: SIDEBAR =================== -->

  <!-- =================== START: MAIN CONTAINER =================== -->
  <div class="container">
    <h1 class="mb-3">Oportunidades</h1>
 
    <!-- START: Header da seção -->
     <div class="boxDentro">
    <div class="d-flex align-items-center justify-content-between mb-3">
      <h3 class="m-0">Minhas oportunidades</h3>
      <div class="d-flex align-items-center gap-2">
        <button id="btnFiltrarAtivos" type="button" class="botaoAtivo">
          Ativos <span id="countAtivos" class=""></span>
        </button>
        <button type="button" class="btn btn-light" data-bs-toggle="modal" data-bs-target="#modalOportunidades">
          <span class="me-1">+</span> Novo
        </button>
      </div>
    </div>
    <!-- END: Header da seção -->

    <!-- START: Lista renderizada via JS -->
    <ul id="listaOportunidades" class="list-group">
      <!-- itens inseridos via JS -->
    </ul>
</div>
    <!-- END: Lista renderizada via JS -->
  </div>
  <!-- =================== END: MAIN CONTAINER =================== -->


  <!-- =================== START: MODAL CRIAR (fora do container) =================== -->
  <div class="modal fade" id="modalOportunidades" tabindex="-1" aria-labelledby="modalOportunidadesLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">

        <div class="modal-header">
          <h4 class="modal-title" id="modalOportunidadesLabel">Cadastrar Oportunidade</h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
        </div>

        <div class="modal-body">
          <form class="row g-3" id="formOportunidades">
            @csrf
            <div class="col">
              <div class="mb-3 input-conteiner">
                <input class="form-control" type="text" name="nomeOportunidade" placeholder="Nome" required>
              </div>

              <div class="mb-3 input-conteiner">
                <input class="form-control" type="text" name="descricaoOportunidades" placeholder="Descrição" required>
              </div>

              <div class="mb-3 input-conteiner">
                <input class="form-control" type="number" name="idadeMinima" placeholder="Idade mínima" required>
              </div>

              <div class="mb-3 input-conteiner">
                <input class="form-control" type="number" name="idadeMaxima" placeholder="Idade máxima" required>
              </div>

              <div class="mb-3 input-conteiner">
                <input class="form-control" type="text" name="cepOportunidade" id="cep" maxlength="9" placeholder="CEP" onblur="handleCepBlur()" required>
              </div>
            </div>

            <div class="col">
              <div class="mb-3 input-conteiner">
                <select class="form-select" name="esporte_id" id="esporte_id" required>
                  <option value="">Carregando esportes...</option>
                </select>
              </div>

              <div class="mb-3 input-conteiner">
                <select class="form-select" name="posicoes_id" id="posicoes_id" required>
                  <option value="">Selecione um esporte primeiro...</option>
                </select>
              </div>

              <select class="form-select" name="estadoOportunidade" id="estadoOportunidade" required>
                <option value="" selected disabled>Estado</option>
                <option value="AC">Acre</option><option value="AL">Alagoas</option><option value="AP">Amapá</option>
                <option value="AM">Amazonas</option><option value="BA">Bahia</option><option value="CE">Ceará</option>
                <option value="DF">Distrito Federal</option><option value="ES">Espírito Santo</option><option value="GO">Goiás</option>
                <option value="MA">Maranhão</option><option value="MT">Mato Grosso</option><option value="MS">Mato Grosso do Sul</option>
                <option value="MG">Minas Gerais</option><option value="PA">Pará</option><option value="PB">Paraíba</option>
                <option value="PR">Paraná</option><option value="PE">Pernambuco</option><option value="PI">Piauí</option>
                <option value="RJ">Rio de Janeiro</option><option value="RN">Rio Grande do Norte</option><option value="RS">Rio Grande do Sul</option>
                <option value="RO">Rondônia</option><option value="RR">Roraima</option><option value="SC">Santa Catarina</option>
                <option value="SP">São Paulo</option><option value="SE">Sergipe</option><option value="TO">Tocantins</option>
              </select>

              <div class="mb-3 input-conteiner">
                <input class="form-control" type="text" name="cidadeOportunidade" id="cidadeOportunidade" placeholder="Cidade" required>
              </div>

              <div class="mb-3 input-conteiner">
                <input class="form-control" type="text" name="enderecoOportunidade" id="enderecoOportunidade" placeholder="Endereço" required>
              </div>
            </div>

            <button class="botaoEnviar" type="submit">Enviar</button>
          </form>
        </div>

      </div>
    </div>
  </div>

  <!-- =================== END: MODAL CRIAR =================== -->


  <!-- =================== START: MODAL EDITAR (fora do container) =================== -->
  <div class="modal fade" id="modalEditarOportunidade" tabindex="-1" aria-labelledby="modalEditarOportunidadeLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">

        <div class="modal-header">
          <h4 class="modal-title" id="modalEditarOportunidadeLabel">Editar Oportunidade</h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
        </div>

        <div class="modal-body">
          <form class="row g-3" id="formEditarOportunidade">
            @csrf
            <input type="hidden" name="id" id="edit_id">

            <div class="col">
              <div class="mb-3 input-conteiner">
                <input class="form-control" type="text" name="nomeOportunidade" id="edit_nomeOportunidade" placeholder="Nome" required>
              </div>

              <div class="mb-3 input-conteiner">
                <input class="form-control" type="text" name="descricaoOportunidades" id="edit_descricaoOportunidades" placeholder="Descrição" required>
              </div>

              <div class="mb-3 input-conteiner">
                <input class="form-control" type="number" name="idadeMinima" id="edit_idadeMinima" placeholder="Idade mínima" required>
              </div>

              <div class="mb-3 input-conteiner">
                <input class="form-control" type="number" name="idadeMaxima" id="edit_idadeMaxima" placeholder="Idade máxima" required>
              </div>

              <div class="mb-3 input-conteiner">
                <input class="form-control" type="text" name="cepOportunidade" id="edit_cep" maxlength="8" placeholder="CEP" required>
              </div>
            </div>

            <div class="col">
              <div class="mb-3 input-conteiner">
                <select class="form-select" name="esporte_id" id="edit_esporte_id" required>
                  <option value="">Carregando esportes...</option>
                </select>
              </div>

              <div class="mb-3 input-conteiner">
                <select class="form-select" name="posicoes_id" id="edit_posicoes_id" required>
                  <option value="">Selecione um esporte primeiro...</option>
                </select>
              </div>

              <select class="form-select" name="estadoOportunidade" id="edit_estadoOportunidade" required>
                <option value="" selected disabled>Estado</option>
                <option value="AC">Acre</option><option value="AL">Alagoas</option><option value="AP">Amapá</option>
                <option value="AM">Amazonas</option><option value="BA">Bahia</option><option value="CE">Ceará</option>
                <option value="DF">Distrito Federal</option><option value="ES">Espírito Santo</option><option value="GO">Goiás</option>
                <option value="MA">Maranhão</option><option value="MT">Mato Grosso</option><option value="MS">Mato Grosso do Sul</option>
                <option value="MG">Minas Gerais</option><option value="PA">Pará</option><option value="PB">Paraíba</option>
                <option value="PR">Paraná</option><option value="PE">Pernambuco</option><option value="PI">Piauí</option>
                <option value="RJ">Rio de Janeiro</option><option value="RN">Rio Grande do Norte</option><option value="RS">Rio Grande do Sul</option>
                <option value="RO">Rondônia</option><option value="RR">Roraima</option><option value="SC">Santa Catarina</option>
                <option value="SP">São Paulo</option><option value="SE">Sergipe</option><option value="TO">Tocantins</option>
              </select>

              <div class="mb-3 input-conteiner">
                <input class="form-control" type="text" name="cidadeOportunidade" id="edit_cidadeOportunidade" placeholder="Cidade" required>
              </div>

              <div class="mb-3 input-conteiner">
                <input class="form-control" type="text" name="enderecoOportunidade" id="edit_enderecoOportunidade" placeholder="Endereço" required>
              </div>
            </div>

          
              <button class="botaoEnviar" type="submit">Atualizar</button>
          </form>
        </div>

      </div>
    </div>
  </div>
  <!-- =================== END: MODAL EDITAR =================== -->
    <!-- =================== MODAL INSCRITOS =================== -->
<div class="modal fade" id="modalInscritos" tabindex="-1">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Inscritos</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">
        <div id="inscritosChips"></div>
        <div id="inscritosContainer"></div>
      </div>
    </div>
  </div>
</div>
<!-- ================= END MODAL ================= -->


  <!-- =================== START: JS DA PÁGINA =================== -->


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

<script src="{{ asset('js/clube/oportunidades/utils.js') }}"></script>
<script src="{{ asset('js/clube/oportunidades/modals.js') }}"></script>
<script src="{{ asset('js/clube/oportunidades/dom-elements.js') }}"></script>
<script src="{{ asset('js/clube/oportunidades/events.js') }}"></script>
<script src="{{ asset('js/clube/oportunidades/api.js') }}"></script>
<script src="{{asset('js/clube/oportunidades/oportunidade.js')}}"></script>
<script src="{{asset('js/clube/oportunidades/logout.js')}}"></script>

  <!-- =================== END: JS DA PÁGINA =================== -->

  <!-- Bootstrap JS (apenas UM bundle) -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
<script>// Força o primeiro item (Dashboard) como ativo
const dashboardItem = document.querySelector('.menu-navegacao li:nth-child(2)');
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
