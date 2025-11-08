const state = {
  opps: [],
  oppsPageSize: 5,
  oppsPageShown: 1,
  pending: [],
  pendingPageSize: 5,
  pendingShown: 1,
  recentActions: []
};

function renderMetrics({ usersRes, clubsRes, oppsRes }) {
  $('#metricUsers').textContent = normalizeTotal(usersRes);
  $('#metricClubs').textContent = normalizeTotal(clubsRes);
  $('#metricOpps').textContent  = normalizeTotal(oppsRes);
  $('#metricReports').textContent = '—';
}

function renderLatestOpps() {
  const ul = $('#latestOpps');
  ul.innerHTML = '';
  const ordered = state.opps.slice().sort((a,b) => new Date(b.created_at||0) - new Date(a.created_at||0));
  const slice = ordered.slice(0, state.oppsPageShown * state.oppsPageSize);
  slice.forEach(o => {
    const li = document.createElement('li');
    const desc = o.descricaoOportunidades || '(sem descrição)';
    const pos  = o.posicao?.nomePosicao || '-';
    const esp  = o.esporte?.nomeEsporte || '-';
    const club = o.clube?.nomeClube || o.clube?.nome || `#${o.clube_id}`;
    const created = formatDate(o.created_at);
    const status = (o.status || '').toUpperCase();
    const motivo = (o.status === 'REJECTED' && o.rejection_reason) ? ` — Motivo: ${o.rejection_reason}` : '';
    li.textContent = `[${status || '-'}] ${desc} — ${pos} / ${esp} — ${club} — ${created}${motivo}`;
    ul.appendChild(li);
  });
  $('#moreOpps').disabled = slice.length >= state.opps.length;
}

function buildRecentActions() {
  state.recentActions = state.opps.slice()
    .sort((a,b)=>new Date(b.created_at||0)-new Date(a.created_at||0))
    .slice(0, 10)
    .map(o => ({
      date: o.reviewed_at || o.created_at || '',
      object: 'Oportunidade',
      action: (o.status === 'APPROVED' ? 'Aprovar' : (o.status === 'REJECTED' ? 'Recusar' : 'Criar')),
      entity: o.clube?.nomeClube || o.clube?.nome || `#${o.clube_id}`,
      entityType: 'Clube',
      description: (o.status === 'REJECTED' && o.rejection_reason) ? `Motivo: ${o.rejection_reason}` : (o.descricaoOportunidades || '-'),
      status: o.status || '-'
    }));
}

function renderActions() {
  const tbody = $('#recentActionsBody');
  tbody.innerHTML = '';
  state.recentActions.forEach(a => {
    const tr = document.createElement('tr');
    [formatDate(a.date), a.object, a.action, a.entity, a.entityType, a.description, a.status]
      .forEach(val => { const td=document.createElement('td'); td.textContent=val; tr.appendChild(td); });
    tbody.appendChild(tr);
  });
}

function renderPendingOpps() {
  const ul = $('#pendingOpps');
  ul.innerHTML = '';
  const ordered = state.pending.slice().sort((a,b) => new Date(b.created_at||0) - new Date(a.created_at||0));
  const slice = ordered.slice(0, state.pendingShown * state.pendingPageSize);
  slice.forEach(o => {
    const li = document.createElement('li');
    const href = `/admin/oportunidades`;
    const desc = o.descricaoOportunidades || '(sem descrição)';
    const pos  = o.posicao?.nomePosicao || '-';
    const esp  = o.esporte?.nomeEsporte || '-';
    const club = o.clube?.nomeClube || o.clube?.nome || `#${o.clube_id}`;
    const date = o.created_at ? new Date(o.created_at).toLocaleString() : '-';
    li.innerHTML = `<a href="${href}">[PENDENTE] ${desc} — ${pos} / ${esp} — ${club} — ${date}</a>`;
    ul.appendChild(li);
  });
  const btn = $('#morePending');
  if (btn) btn.disabled = slice.length >= state.pending.length;
}
