// ==== Helpers ====
  const $     = (s) => document.querySelector(s);
  // token stored in localStorage already contains 'Bearer ' prefix
  const token = localStorage.getItem('clube_token');
  const csrf  = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

  const headers = {
    'X-Requested-With': 'XMLHttpRequest',
    'X-CSRF-TOKEN': csrf,
    'Accept': 'application/json',
    'Authorization': token, // já vem com Bearer
    'Content-Type': 'application/json',
  };

  const state = { oportunidades: [], showOnlyActive: false };

  // ==== Fetch helpers ====
  const getJSON = async (url) => {
    const res = await fetch(url, { method: 'GET', credentials: 'same-origin', headers });
    const txt = await res.text();
    let data; try { data = txt ? JSON.parse(txt) : null; } catch { data = txt; }
    if (!res.ok) throw new Error((data && (data.message || data.error)) || `Erro ${res.status}`);
    return data;
  };
  const delJSON = async (url) => {
    const res = await fetch(url, { method: 'DELETE', credentials: 'same-origin', headers });
    const txt = await res.text();
    let data; try { data = txt ? JSON.parse(txt) : null; } catch { data = txt; }
    if (!res.ok) throw new Error((data && (data.message || data.error)) || `Erro ${res.status}`);
    return data;
  };
  const putJSON = async (url, body) => {
    const res = await fetch(url, { method: 'PUT', credentials: 'same-origin', headers, body: JSON.stringify(body) });
    const txt = await res.text();
    let data; try { data = txt ? JSON.parse(txt) : null; } catch { data = txt; }
    if (!res.ok) throw new Error((data && (data.message || data.error)) || `Erro ${res.status}`);
    return data;
  };

  // ==== Render ====
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

  const renderItem = (op) => {
  const id      = op.id || op.oportunidade_id || op.uuid || '';
  const posNome = op.posicao?.nomePosicao || op.posicao?.nome || op.posicao || '—';
  const espNome = op.esporte?.nomeEsporte || op.esporte?.nome || op.esporte || '—';
  const cat     = subLabel(op);
  const st      = statusLabel(op.status);
  const approved = isApproved(op.status);

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
            ${approved ? `<button class="dropdown-item" data-action="inscritos" data-id="${id}">Inscritos</button>` : ``}
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

  // ==== Edição: carregar selects ====
  const getEsportes = async () => {
    // Prefer the centralized client in public/js/clube/oportunidades/api.js
    if (typeof apiCarregarEsportes === 'function') {
      try {
        const { ok, data } = await apiCarregarEsportes();
        if (!ok) throw new Error((data && (data.message || data.error)) || 'Erro ao carregar esportes');
        return data;
      } catch (err) {
        console.error('getEsportes failed via apiCarregarEsportes', err);
        throw err;
      }
    }

    // fallback to direct fetch
    const r = await fetch('/api/clube/esporte', { headers:{ Authorization: token, Accept: 'application/json' }});
    return r.json();
  };

  const getPosicoes = async (idEsporte) => {
    if (typeof apiCarregarPosicoes === 'function') {
      try {
        const { ok, data } = await apiCarregarPosicoes(idEsporte);
        if (!ok) throw new Error((data && (data.message || data.error)) || 'Erro ao carregar posições');
        return data;
      } catch (err) {
        console.error('getPosicoes failed via apiCarregarPosicoes', err);
        throw err;
      }
    }

    const r = await fetch(`/api/clube/posicao?idEsporte=${encodeURIComponent(idEsporte)}`, { headers:{ Authorization: token, Accept: 'application/json' }});
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
    $('#edit_nomeOportunidade').value       = op.nomeOportunidade || op.nome || '';
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

  // CEP Edit
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

  // ==== SUBMIT EDITAR ====
  async function onSubmitEditar(e) {
    e.preventDefault();
    e.stopPropagation();

    const id = $('#edit_id').value;
    const payload = {
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

  // ==== Ações do dropdown ====
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

  // CEP criação
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

  // ==== INIT ====
  document.addEventListener('DOMContentLoaded', async () => {
    carregarOportunidades();

    document.getElementById('btnFiltrarAtivos')?.addEventListener('click', () => {
      state.showOnlyActive = !state.showOnlyActive;
      renderLista();
    });

    const modalCreate = document.getElementById('modalOportunidades');
    if (modalCreate && window.bootstrap) {
      modalCreate.addEventListener('hidden.bs.modal', () => carregarOportunidades());
    }

    // ===== Populate create-form selects (esporte -> posicoes) =====
    const createEsporteEl = document.getElementById('esporte_id');
    const createPosicoesEl = document.getElementById('posicoes_id');

    if (createEsporteEl) {
      try {
        const esportes = await getEsportes();
        fillSelect(createEsporteEl, esportes, 'id', 'nomeEsporte', 'Selecione o esporte...');

        createEsporteEl.addEventListener('change', async (ev) => {
          const id = ev.target.value;
          if (!createPosicoesEl) return;
          if (!id) {
            createPosicoesEl.innerHTML = '<option value="">Selecione um esporte primeiro...</option>';
            return;
          }
          try {
            const posicoes = await getPosicoes(id);
            fillSelect(createPosicoesEl, posicoes, 'id', 'nomePosicao', 'Selecione a posição...');
          } catch (err) {
            console.error('Erro ao carregar posições (create):', err);
            createPosicoesEl.innerHTML = '<option value="">Erro ao carregar posições</option>';
          }
        });
      } catch (err) {
        console.error('Erro ao carregar esportes (create):', err);
      }
    }

    const formEdit = document.getElementById('formEditarOportunidade');
    formEdit?.addEventListener('submit', onSubmitEditar);
  });