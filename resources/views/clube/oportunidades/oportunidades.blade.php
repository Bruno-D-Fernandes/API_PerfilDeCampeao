<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Oportunidades</title>




<!-- O CODIGO TA MUITO ESTRUTURADO AGR PARA NAO SE PERDER, MANTER ORGANIZADO POR FAVORRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRR-->






  <!-- CSS (Bootstrap + seus estilos) -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('/css/clube/oportunidadesClube.css') }}">
  <link rel="stylesheet" href="{{ asset('css/clube/sidebar/sidebar.css') }}">
  <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
  <!-- =================== START: SIDEBAR =================== -->
  <nav class="barra-lateral" id="barra-lateral">
    <div class="logo-container">
      <img src="../img/logo-clube-reduzida.png" alt="Logo" class="logo-pequena">
      <img src="../img/logo-clube-completa.jpeg" alt="Logo" class="logo-grande">
    </div>

    <ul class="menu-navegacao">
      <li><a href="./index.html"><i class='bx bx-home-alt'></i><span>Dashboard</span></a></li>
      <li class="ativo"><a href=""><i class='bx bx-briefcase'></i><span>Oportunidades</span></a></li>
      <li><a href="#"><i class='bx bx-list-ul'></i><span>Listas</span></a></li>
      <li><a href="#"><i class='bx bx-message-dots'></i><span>Mensagens</span></a></li>
      <li><a href="#"><i class='bx bx-bell'></i><span>Notificações</span></a></li>
      <li><a href="#"><i class='bx bx-user'></i><span>Perfil</span></a></li>
      <li><a href="./tela-pesquisa/pesquisa.html"><i class='bx bx-search'></i><span>Pesquisa</span></a></li>
      <li><a href="#"><i class='bx bx-cog'></i><span>Configurações</span></a></li>
      <li><hr class="barra-vermelha"></li>
      <li class="sair-link"><a href="#"><i class='bx bx-log-out'></i><span>Sair</span></a></li>
    </ul>
  </nav>
  <!-- =================== END: SIDEBAR =================== -->

  <!-- =================== START: MAIN CONTAINER =================== -->
  <div class="container">
    <h1 class="mb-3">Oportunidades</h1>

    <!-- START: Header da seção -->
    <div class="d-flex align-items-center justify-content-between mb-3">
      <h3 class="m-0">Minhas oportunidades</h3>
      <div class="d-flex align-items-center gap-2">
        <button id="btnFiltrarAtivos" type="button" class="btn btn-outline-success btn-sm">
          Ativos <span id="countAtivos" class="badge bg-success ms-1">0</span>
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

            <div class="d-flex gap-2">
              <button class="btn btn-primary" type="submit">Salvar alterações</button>
              <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Cancelar</button>
            </div>
          </form>
        </div>

      </div>
    </div>
  </div>
  <!-- =================== END: MODAL EDITAR =================== -->


  <!-- =================== START: JS DA PÁGINA =================== -->


<script src="{{ asset('js/clube/oportunidades/utils.js') }}"></script>
<script src="{{ asset('js/clube/oportunidades/modals.js') }}"></script>
<script src="{{ asset('js/clube/oportunidades/dom-elements.js') }}"></script>
<script src="{{ asset('js/clube/oportunidades/events.js') }}"></script>
<script src="{{ asset('js/clube/oportunidades/api.js') }}"></script>

  <script>
    // Helpers básicos
    const $     = (s) => document.querySelector(s);
    const token = localStorage.getItem('clube_token');
    const csrf  = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    const headers = {
      'X-Requested-With': 'XMLHttpRequest',
      'X-CSRF-TOKEN': csrf,
      'Accept': 'application/json',
      'Authorization': token,
      'Content-Type': 'application/json'
    };

    const state = { oportunidades: [], showOnlyActive: false };

    const getJSON = async (url) => {
      const res = await fetch(url, { method:'GET', credentials:'same-origin', headers });
      const txt = await res.text();
      let data; try { data = txt ? JSON.parse(txt) : null; } catch { data = txt; }
      if (!res.ok) throw new Error((data && (data.message||data.error)) || `Erro ${res.status}`);
      return data;
    };
    const delJSON = async (url) => {
      const res = await fetch(url, { method:'DELETE', credentials:'same-origin', headers });
      const txt = await res.text();
      let data; try { data = txt ? JSON.parse(txt) : null; } catch { data = txt; }
      if (!res.ok) throw new Error((data && (data.message||data.error)) || `Erro ${res.status}`);
      return data;
    };
    const putJSON = async (url, body) => {
      const res = await fetch(url, { method:'PUT', credentials:'same-origin', headers, body: JSON.stringify(body) });
      const txt = await res.text();
      let data; try { data = txt ? JSON.parse(txt) : null; } catch { data = txt; }
      if (!res.ok) throw new Error((data && (data.message||data.error)) || `Erro ${res.status}`);
      return data;
    };

    const normalizeList = (d) => {
      if (Array.isArray(d)) return d;
      if (d?.data && Array.isArray(d.data)) return d.data;
      if (d?.items && Array.isArray(d.items)) return d.items;
      if (d && typeof d === 'object') return Object.values(d);
      return [];
    };
    const isApproved = (st) => {
      if (!st) return false;
      const s = String(st).toLowerCase();
      return s.includes('aprov') || s === 'approved' || s === 'true' || s === '1';
    };
    const statusLabel = (raw) => {
      const s = String(raw || '').toLowerCase();
      if (s.includes('aprov') || s === 'approved') return 'Aprovada';
      if (s.includes('pend')  || s === 'pending')  return 'Pendente';
      if (s.includes('rej')   || s === 'rejected') return 'Rejeitada';
      return String(raw || '—');
    };
    const renderBadge = (t) => `<span class="border rounded-pill px-2 py-1">${t}</span>`;
    const subLabel    = (op) => (op.idadeMaxima ? `Sub-${op.idadeMaxima}` : (op.idadeMinima ? `≥${op.idadeMinima}` : '—'));

    // Item da lista (sem descrição)
    const renderItem = (op) => {
      const id      = op.id || op.oportunidade_id || op.uuid || '';
      const posNome = op.posicao?.nomePosicao || op.posicao?.nome || op.posicao || '—';
      const espNome = op.esporte?.nomeEsporte || op.esporte?.nome || op.esporte || '—';
      const cat     = subLabel(op);
      const st      = statusLabel(op.status);

      return `
        <li class="list-group-item" data-op="${id}">
          <div class="d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-2 flex-wrap">
              ${renderBadge(posNome)}
              ${renderBadge(espNome)}
              ${renderBadge(cat)}
              <span class="ms-2">${st}</span>
            </div>

            <div class="dropdown">
              <button class="btn btn-sm btn-link p-0 text-decoration-none" data-bs-toggle="dropdown" aria-expanded="false" aria-label="menu">
                &#8226;&#8226;&#8226;
              </button>
              <div class="dropdown-menu dropdown-menu-end">
                <button class="dropdown-item" data-action="inscritos" data-id="${id}">Inscritos</button>
                <button class="dropdown-item" data-action="editar" data-id="${id}">Editar</button>
                <button class="dropdown-item text-danger" data-action="excluir" data-id="${id}">Excluir</button>
              </div>
            </div>
          </div>
        </li>
      `;
    };

    const renderLista = () => {
      const ul = $('#listaOportunidades');
      if (!ul) return;
      const src = state.showOnlyActive ? state.oportunidades.filter(o => isApproved(o.status)) : state.oportunidades;
      ul.innerHTML = src.length ? src.map(renderItem).join('') : `<li class="list-group-item text-muted">Nenhuma oportunidade.</li>`;
      $('#countAtivos').textContent = state.oportunidades.filter(o => isApproved(o.status)).length;
    };

    const carregarOportunidades = async () => {
      try {
        const resp = await getJSON('/api/clube/minhasOportunidades');
        state.oportunidades = normalizeList(resp)
          .sort((a,b) => new Date(b.updated_at || b.created_at || 0) - new Date(a.updated_at || a.created_at || 0));
        renderLista();
      } catch (e) {
        console.error(e);
        alert('Não foi possível carregar as oportunidades.');
      }
    };
    window.refreshOportunidades = carregarOportunidades;

    // --- edição ---
    const getEsportes = async () => {
      const r = await fetch('/api/clube/esporte', { headers:{ Authorization: token, Accept:'application/json' }});
      return r.json();
    };
    const getPosicoes = async (idEsporte) => {
      const r = await fetch(`/api/clube/posicao?idEsporte=${encodeURIComponent(idEsporte)}`, { headers:{ Authorization: token, Accept:'application/json' }});
      return r.json();
    };
    const fillSelect = (el, items, valueKey, labelKey, placeholder) => {
      if (!el) return;
      el.innerHTML = `<option value="">${placeholder}</option>`;
      (items||[]).forEach(i => {
        const opt = document.createElement('option');
        opt.value = i[valueKey];
        opt.textContent = i[labelKey] || i.nome || i.titulo || `#${i[valueKey]}`;
        el.appendChild(opt);
      });
    };

    async function abrirEditar(id) {
      const op = state.oportunidades.find(o => (o.id || o.oportunidade_id || o.uuid) == id);
      if (!op) { alert('Oportunidade não encontrada.'); return; }

      $('#edit_id').value                     = op.id || op.oportunidade_id || op.uuid || '';
      $('#edit_descricaoOportunidades').value = op.descricaoOportunidades || '';
      $('#edit_idadeMinima').value            = op.idadeMinima ?? '';
      $('#edit_idadeMaxima').value            = op.idadeMaxima ?? '';
      $('#edit_cep').value                    = op.cepOportunidade || '';
      $('#edit_cidadeOportunidade').value     = op.cidadeOportunidade || '';
      $('#edit_enderecoOportunidade').value   = op.enderecoOportunidade || '';
      $('#edit_estadoOportunidade').value     = op.estadoOportunidade || '';

      try {
        const esportes = await getEsportes();
        fillSelect($('#edit_esporte_id'), esportes, 'id', 'nomeEsporte', 'Selecione o esporte...');
        const esporteId = op.esporte_id || op.esporte?.id || '';
        if (esporteId) $('#edit_esporte_id').value = String(esporteId);

        if (esporteId) {
          const posicoes = await getPosicoes(esporteId);
          fillSelect($('#edit_posicoes_id'), posicoes, 'id', 'nomePosicao', 'Selecione a posição...');
          const posId = op.posicoes_id || op.posicao_id || op.posicao?.id || '';
          if (posId) $('#edit_posicoes_id').value = String(posId);
        } else {
          $('#edit_posicoes_id').innerHTML = '<option value="">Selecione um esporte primeiro...</option>';
        }
      } catch (err) {
        console.error('Erro ao carregar esporte/posição para edição', err);
      }

      const modalEl = document.getElementById('modalEditarOportunidade');
      if (window.bootstrap && modalEl) {
        window.bootstrap.Modal.getOrCreateInstance(modalEl).show();
      }
    }

    document.addEventListener('change', async (e) => {
      if (e.target && e.target.id === 'edit_esporte_id') {
        const idEsporte = e.target.value;
        const posSel = $('#edit_posicoes_id');
        if (!idEsporte) { posSel.innerHTML = '<option value="">Selecione um esporte primeiro...</option>'; return; }
        posSel.innerHTML = '<option value="">Carregando posições...</option>';
        try {
          const pos = await getPosicoes(idEsporte);
          fillSelect(posSel, pos, 'id', 'nomePosicao', 'Selecione a posição...');
        } catch (err) {
          console.error(err);
          posSel.innerHTML = '<option value="">Erro ao carregar posições</option>';
        }
      }
    });

    async function handleEditCepBlur() {
      const cepEl = $('#edit_cep');
      let cep = (cepEl.value || '').replace(/\D/g, '');
      if (cep.length !== 8) return;
      try {
        const r = await fetch(`https://viacep.com.br/ws/${cep}/json/`);
        const d = await r.json();
        if (!d.erro) {
          $('#edit_cidadeOportunidade').value   = d.localidade || '';
          $('#edit_enderecoOportunidade').value = d.logradouro || '';
          $('#edit_estadoOportunidade').value   = d.uf || '';
        }
      } catch {}
    }
    document.addEventListener('blur', (e) => {
      if (e.target && e.target.id === 'edit_cep') handleEditCepBlur();
    }, true);

    document.addEventListener('submit', async (e) => {
      if (e.target && e.target.id === 'formEditarOportunidade') {
       async function onSubmitEditar(e) {
  e.preventDefault();
  e.stopPropagation();

  const id = $('#edit_id').value;
  const payload = {
    // inclui também o nome (muitos backends validam isso)
    nomeOportunidade:       $('#edit_nomeOportunidade').value,
    descricaoOportunidades: $('#edit_descricaoOportunidades').value,
    idadeMinima:            $('#edit_idadeMinima').value || null,
    idadeMaxima:            $('#edit_idadeMaxima').value || null,
    cepOportunidade:        $('#edit_cep').value,
    cidadeOportunidade:     $('#edit_cidadeOportunidade').value,
    enderecoOportunidade:   $('#edit_enderecoOportunidade').value,
    estadoOportunidade:     $('#edit_estadoOportunidade').value,
    esporte_id:             $('#edit_esporte_id').value || null,
    posicoes_id:            $('#edit_posicoes_id').value || null,
  };

  try {
    const resp = await putJSON(`/api/clube/oportunidade/${id}`, payload);
    // esconde modal
    const modalEl = document.getElementById('modalEditarOportunidade');
    if (window.bootstrap && modalEl) {
      window.bootstrap.Modal.getOrCreateInstance(modalEl).hide();
    }
    await carregarOportunidades();
    alert('Oportunidade atualizada!');
    console.debug('PUT OK', resp);
  } catch (err) {
    console.error('PUT FAIL', err);
    alert(err?.message || 'Não foi possível atualizar a oportunidade.');
  }
}
      }
    });

    // Ações do dropdown
    document.addEventListener('click', async (e) => {
      const act = e.target.closest('[data-action]');
      if (!act) return;

      const action = act.getAttribute('data-action');
      const id     = act.getAttribute('data-id');

      if (action === 'inscritos') {
        window.location.href = `/clube/oportunidade/${id}/inscritos`;
        return;
      }
      if (action === 'editar') {
        abrirEditar(id);
        return;
      }
      if (action === 'excluir') {
        if (!confirm('Deseja realmente excluir esta oportunidade?')) return;
        try {
          await delJSON(`/api/clube/oportunidade/${id}`);
          state.oportunidades = state.oportunidades.filter(o => (o.id || o.oportunidade_id || o.uuid) != id);
          renderLista();
        } catch (e2) {
          console.error(e2);
          alert('Não foi possível excluir.');
        }
      }
    });

    // CEP do formulário de criação (por causa do onblur="handleCepBlur()")
    async function handleCepBlur() {
      const cepInput = document.getElementById('cep');
      if (!cepInput) return;
      let cep = (cepInput.value || '').replace(/\D/g, '');
      if (cep.length !== 8) return;
      try {
        const r = await fetch(`https://viacep.com.br/ws/${cep}/json/`);
        const d = await r.json();
        if (!d.erro) {
          document.getElementById('cidadeOportunidade').value   = d.localidade || '';
          document.getElementById('enderecoOportunidade').value = d.logradouro || '';
          document.getElementById('estadoOportunidade').value   = d.uf || '';
        }
      } catch {}
    }

    document.addEventListener('DOMContentLoaded', () => {
      carregarOportunidades();
      document.getElementById('btnFiltrarAtivos')?.addEventListener('click', () => {
        state.showOnlyActive = !state.showOnlyActive;
        renderLista();
      });

      // Quando fechar o modal de criar, recarrega a lista
      const modalCreate = document.getElementById('modalOportunidades');
      if (modalCreate && window.bootstrap) {
        modalCreate.addEventListener('hidden.bs.modal', () => carregarOportunidades());
      }
    });
  </script>
  <!-- =================== END: JS DA PÁGINA =================== -->

  <!-- Bootstrap JS (apenas UM bundle) -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
