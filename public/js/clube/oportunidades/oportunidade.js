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
  let text = '—';
  let classe = 'statusTag ';

  if (s.includes('aprov') || s === 'approved') {
    text = 'Aprovada';
    classe += 'statusAprovada';
  } else if (s.includes('pend') || s === 'pending') {
    text = 'Pendente';
    classe += 'statusPendente';
  } else if (s.includes('rej') || s === 'rejected') {
    text = 'Rejeitada';
    classe += 'statusRejeitada';
  }

  return `<span class="${classe}">${text}</span>`;
};

  const renderBadge = (t) => {
  const lower = String(t).toLowerCase();
  let classe = "tag";

  if (lower.includes("atac")) classe += " tagAzul";
  else if (lower.includes("fut")) classe += " tagVerde";
  else if (lower.includes("sub")) classe += " tagVerde";
  else classe += " tagCinza";

  return `<span class="${classe}">${t}</span>`;
};

  const subLabel    = (op) => (op.idadeMaxima ? `Sub-${op.idadeMaxima}` : (op.idadeMinima ? `≥${op.idadeMinima}` : '—'));

const renderItem = (op) => {
  const id      = op.id || op.oportunidade_id || op.uuid || '';
  const posNome = op.posicao?.nomePosicao || op.posicao?.nome || op.posicao || '—';
  const espNome = op.esporte?.nomeEsporte || op.esporte?.nome || op.esporte || '—';
  const cat     = subLabel(op);
  const st      = statusLabel(op.status);
  const approved = isApproved(op.status);

  return `
    <li class="list-group-item itemOportunidade ${approved ? 'itemAprovado' : 'itemPendente'}" data-op="${id}">
      <div class="conteudoItem d-flex align-items-center justify-content-between">
        <div class="infoItem d-flex align-items-center gap-2 flex-wrap">
          ${renderBadge(posNome)}
          ${renderBadge(espNome)}
          ${renderBadge(cat)}
          <span class="statusItem ms-2">${st}</span>
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

    const editEsporteEl = $('#edit_esporte_id');
    const editPosEl = $('#edit_posicoes_id');

    if (esporteId) {
      const posicoes = await getPosicoes(esporteId);
      fillSelect(editPosEl, posicoes, 'id', 'nomePosicao', 'Selecione a posição...');
      const posId = op.posicoes_id || op.posicao_id || op.posicao?.id || '';
      if (posId) editPosEl.value = String(posId);
    } else {
      if (editPosEl) editPosEl.innerHTML = '<option value="">Selecione um esporte primeiro...</option>';
    }

    if (editEsporteEl) {
      editEsporteEl.onchange = async (ev) => {
        const id = ev.target.value;
        if (!editPosEl) return;
        if (!id) {
          editPosEl.innerHTML = '<option value="">Selecione um esporte primeiro...</option>';
          return;
        }
        try {
          const posicoes = await getPosicoes(id);
          fillSelect(editPosEl, posicoes, 'id', 'nomePosicao', 'Selecione a posição...');
        } catch (err) {
          console.error('Erro ao carregar posições para edição (change):', err);
          editPosEl.innerHTML = '<option value="">Erro ao carregar posições</option>';
        }
      };
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
    const editModal = document.getElementById('editModal');
if (editModal) {
  editModal.style.display = 'flex';
  setTimeout(() => {
    editModal.style.display = 'none';
  }, 2000);
} else {
  alert('Oportunidade atualizada!'); // Fallback
}
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
  const deleteModal = document.getElementById('deleteModal');
const btnDeleteOk = document.getElementById('deleteOk');
const btnDeleteCancel = document.getElementById('deleteCancel');

let deleteCallback = null;

function openDeleteModal(callback) {
  deleteCallback = callback;
  deleteModal.style.display = 'flex'; // aparece
}

function closeDeleteModal() {
  deleteModal.style.display = 'none';
  deleteCallback = null;
}

btnDeleteOk.addEventListener('click', () => {
  if (deleteCallback) deleteCallback(); 
  closeDeleteModal();
});

btnDeleteCancel.addEventListener('click', closeDeleteModal);

  if (action === 'inscritos') {
    // <<< ALTERADO: agora abre modal, não navega >>>
    e.preventDefault();
    e.stopPropagation();
    abrirInscritosModal(id);
    return;
  }
  if (action === 'editar') {
    abrirEditar(id);
    return;
  }
  if (action === 'excluir') {
  openDeleteModal(async () => {
    try {
      const response = await fetch(`/oportunidades/${id}`, {
        method: 'DELETE',
        headers: { Authorization: token }
      });

      if (!response.ok) throw new Error('Erro ao excluir');

      loadOportunidades(); // recarrega tabela
    } catch (error) {
      console.error(error);
    }
  });

  try {
    // ✅ 1. Fazer exclusão PRIMEIRO
    await delJSON(`/api/clube/oportunidade/${id}`);
    
    // ✅ 2. Remover da lista
    state.oportunidades = state.oportunidades.filter(o => (o.id || o.oportunidade_id || o.uuid) != id);
    renderLista();
    
    // ✅ 3. Mostrar modal
    const deleteModal = document.getElementById('deleteModal');
    deleteModal.style.display = 'flex';
    
    // ✅ 4. Recarregar
    setTimeout(() => {
      deleteModal.style.display = 'none';
      window.location.reload();
    }, 2000);

  } catch (e2) {
    console.error('Erro ao excluir:', e2);
    alert('Não foi possível excluir a oportunidade.');
  }
  return; // Importante!
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

  // ===== Populate create-form selects (esporte -> posicoes) using shared api helpers =====
  const createEsporteEl = document.getElementById('esporte_id');
  const createPosicoesEl = document.getElementById('posicoes_id');

  async function populateCreateEsportes() {
    if (!createEsporteEl) return;
    try {
      console.debug('[oportunidade] populateCreateEsportes: requesting esportes');
      const { ok, data } = (typeof apiCarregarEsportes === 'function')
        ? await apiCarregarEsportes()
        : { ok: true, data: await (await fetch('/api/clube/esporte', { headers:{ Authorization: token, Accept: 'application/json' }})).json() };

      if (!ok) {
        console.error('[oportunidade] apiCarregarEsportes returned error', data);
        createEsporteEl.innerHTML = '<option value="">Erro ao carregar esportes</option>';
        return;
      }

      fillSelect(createEsporteEl, data, 'id', 'nomeEsporte', 'Selecione o esporte...');
    } catch (err) {
      console.error('[oportunidade] populateCreateEsportes failed', err);
      createEsporteEl.innerHTML = '<option value="">Erro ao carregar esportes</option>';
    }
  }

  async function populateCreatePosicoes(esporteId) {
    if (!createPosicoesEl) return;
    if (!esporteId) {
      createPosicoesEl.innerHTML = '<option value="">Selecione um esporte primeiro...</option>';
      return;
    }
    try {
      const { ok, data } = (typeof apiCarregarPosicoes === 'function')
        ? await apiCarregarPosicoes(esporteId)
        : { ok: true, data: await (await fetch(`/api/clube/posicao?idEsporte=${encodeURIComponent(esporteId)}`, { headers:{ Authorization: token, Accept: 'application/json' }})).json() };

      if (!ok) {
        console.error('[oportunidade] apiCarregarPosicoes returned error', data);
        createPosicoesEl.innerHTML = '<option value="">Erro ao carregar posições</option>';
        return;
      }

      fillSelect(createPosicoesEl, data, 'id', 'nomePosicao', 'Selecione a posição...');
    } catch (err) {
      console.error('[oportunidade] populateCreatePosicoes failed', err);
      createPosicoesEl.innerHTML = '<option value="">Erro ao carregar posições</option>';
    }
  }

  // Populate when modal is shown to ensure selects exist and token is available
  const modalCreateEl = document.getElementById('modalOportunidades');
  if (modalCreateEl) {
    modalCreateEl.addEventListener('show.bs.modal', async () => {
      await populateCreateEsportes();
      // clear posicoes until esporte selected
      if (createPosicoesEl) createPosicoesEl.innerHTML = '<option value="">Selecione um esporte primeiro...</option>';
    });
  }

  // Also handle change events on esporte select
  if (createEsporteEl) {
    createEsporteEl.addEventListener('change', (ev) => {
      const id = ev.target.value;
      populateCreatePosicoes(id);
    });
  }

  const formEdit = document.getElementById('formEditarOportunidade');
  formEdit?.addEventListener('submit', onSubmitEditar);
});


// =====================  INSCRITOS (MODAL)  =====================
window.DEBUG_INSCRITOS = true;
let CURRENT_INSCRITOS_OP_ID = null;

function statusInscricaoLabel(s) {
  const v = String(s ?? 'pendente').toLowerCase();
  if (v.includes('aprov')) return { txt: 'Aprovado' };
  if (v.includes('rejei')) return { txt: 'Rejeitado' };
  return { txt: 'Pendente' };
}

async function parseJSON(res) {
  const txt = await res.text();
  try { return txt ? JSON.parse(txt) : null; } catch { return txt; }
}

function pick(...vals) {
  return vals.find(v => v !== undefined && v !== null);
}

// Carrega dados do usuário caso necessário
async function fetchUsuario(usuarioId) {
  if (!usuarioId) return null;
  const res  = await fetch(`/api/usuario/${usuarioId}`, { headers });
  const data = await parseJSON(res);
  if (!res.ok) return null;
  return data;
}

// GET /api/clube/oportunidade/{id}/inscritos
async function fetchInscricoes(oportunidadeId) {
  const url = `/api/clube/oportunidade/${oportunidadeId}/inscritos`;
  const res = await fetch(url, { headers });
  const data = await parseJSON(res);

  if (!res.ok) throw new Error("Erro ao buscar inscritos.");

  const arr = Array.isArray(data) ? data
           : Array.isArray(data?.data) ? data.data
           : [];

  window.__INSCRITOS_CACHE__ = arr;

  return arr.map(it => ({
    id: it.id,
    status: it.status,
    usuario: it.usuario || null,
    usuario_id: it.usuario_id ?? (it.usuario?.id ?? null),
  }));
}

// POST aprovar / remover
async function updateInscricaoStatusByUser(opId, usuarioId, status) {
  const url = status === 'approved'
    ? `/api/clube/oportunidade/${opId}/inscricoes/${usuarioId}/aceitar`
    : `/api/clube/oportunidade/${opId}/inscricoes/${usuarioId}/remover`;

  const res = await fetch(url, { method: 'POST', headers });
  const data = await parseJSON(res);

  if (!res.ok) console.warn("Falha no backend:", data);

  return data;
}

// =================================================================
// RENDER DA LISTA
// =================================================================
function renderInscritosLista(container, lista) {
  if (!lista || lista.length === 0) {
    container.innerHTML = `<div>Nenhum usuário inscrito.</div>`;
    return;
  }

  container.innerHTML = `
    ${lista.map(item => {
      const u   = item.usuario || {};
      const lbl = statusInscricaoLabel(item.status);

      const nome      = pick(u.nomeCompletoUsuario, 'Usuário');
      const cidade    = pick(u.cidadeUsuario, '');
      const estado    = pick(u.estadoUsuario, '');
      const idade     = pick(u.idade, '');
      const avatarURL = pick(u.fotoPerfilUsuario, '');

      const normalized =
        item.status.includes('aprov') ? 'approved' :
        item.status.includes('rejei') ? 'rejected' : 'pending';

      return `
        <div data-insc="${item.id}"
             data-usuario-id="${item.usuario_id || ''}"
             data-status="${normalized}">

          <div>
            ${avatarURL ? `<img src="${avatarURL}" width="40" height="40">` : ``}
          </div>

          <div>
            <strong>${nome}</strong><br>
            <span>${cidade} - ${estado}</span><br>
            <span>${idade ? idade+' anos' : ''}</span>
          </div>

          <div data-role="pill">${lbl.txt}</div>

          <div data-role="actions">
            <button data-acao="aprovar">Aprovar</button>
            <button data-acao="rejeitar">Rejeitar</button>
          </div>

        </div>
      `;
    }).join('')}
  `;

  // Ajusta visibilidade dos botões
  container.querySelectorAll('[data-insc]').forEach(row => {
    const status = row.dataset.status;
    const btnAprovar = row.querySelector('[data-acao="aprovar"]');
    const btnRejeitar = row.querySelector('[data-acao="rejeitar"]');

    if (status === 'approved') {
      btnAprovar.style.display = "none";
      btnRejeitar.style.display = "inline-block";
    } else if (status === 'rejected') {
      btnRejeitar.style.display = "none";
      btnAprovar.style.display = "inline-block";
    } else {
      btnAprovar.style.display = "inline-block";
      btnRejeitar.style.display = "inline-block";
    }
  });
}

// =================================================================
// ABRIR MODAL
// =================================================================
async function abrirInscritosModal(oportunidadeId) {
  CURRENT_INSCRITOS_OP_ID = oportunidadeId;

  const container = document.getElementById('inscritosContainer');
  container.innerHTML = "Carregando...";

  try {
    const lista = await fetchInscricoes(oportunidadeId);
    renderInscritosLista(container, lista);
  } catch (e) {
    container.innerHTML = "Erro ao carregar inscritos.";
  }

  const modalEl = document.getElementById('modalInscritos');
  if (window.bootstrap) {
    window.bootstrap.Modal.getOrCreateInstance(modalEl).show();
  }
}

// =================================================================
// AÇÕES: Aprovar / Rejeitar
// =================================================================
document.addEventListener('click', async (e) => {
  const btn = e.target.closest('#modalInscritos [data-acao]');
  if (!btn) return;

  const row = btn.closest('[data-insc]');
  const usuarioId = row.dataset.usuarioId;
  const pill = row.querySelector('[data-role="pill"]');

  const acao = btn.dataset.acao;
  const status = acao === 'aprovar' ? 'approved' : 'rejected';

  // Atualiza UI imediatamente (UI otimista)
  row.dataset.status = status;
  pill.textContent = status === 'approved' ? 'Aprovado' : 'Rejeitado';

  const btnAprovar = row.querySelector('[data-acao="aprovar"]');
  const btnRejeitar = row.querySelector('[data-acao="rejeitar"]');

  if (status === 'approved') {
    btnAprovar.style.display = "none";
    btnRejeitar.style.display = "inline-block";
  } else {
    btnRejeitar.style.display = "none";
    btnAprovar.style.display = "inline-block";
  }

  try {
    await updateInscricaoStatusByUser(CURRENT_INSCRITOS_OP_ID, usuarioId, status);
  } catch (err) {
    console.warn("Backend falhou, mas UI permanece atualizada.");
  }
});
