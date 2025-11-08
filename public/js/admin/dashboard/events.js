async function loadMetricsFlow() {
  const [usersRes, clubsRes, oppsRes] = await Promise.all([
    api.users(), api.clubs(), api.oppsAll()
  ]);
  renderMetrics({ usersRes, clubsRes, oppsRes });
}

async function loadOppsFlow() {
  const base = await api.oppsAll();
  let rejected = [];
  try { rejected = await api.oppsRejected(); } catch {}
  const baseList = normalizeList(base);
  const rejectedList = normalizeList(rejected);
  state.opps = mergeById(baseList, rejectedList);
  state.oppsPageShown = 1;
  renderLatestOpps();
  buildRecentActions();
  renderActions();
}

async function loadPendingFlow() {
  try {
    const res = await api.oppsPending();
    state.pending = normalizeList(res);
    state.pendingShown = 1;
    renderPendingOpps();
  } catch {}
}

document.addEventListener('DOMContentLoaded', async () => {
  const token = getToken();
  if (!token || !token.startsWith('Bearer ')) {
    alert('Faça login do admin.');
    return;
  }
  try {
    await loadMetricsFlow();
  } catch (e) { showInlineError('#metrics', e.message); }

  try {
    await loadOppsFlow();
  } catch (e) { showInlineError('section h3:nth-of-type(2)', e.message); }

  await loadPendingFlow();

  $('#orderBy')?.addEventListener('change', (e) => {
    const v = e.target.value;
    if (v==='date_desc') state.recentActions.sort((a,b)=>new Date(b.date)-new Date(a.date));
    else if (v==='date_asc') state.recentActions.sort((a,b)=>new Date(a.date)-new Date(b.date));
    renderActions();
  });

  $('#moreOpps')?.addEventListener('click', () => {
    state.oppsPageShown += 1;
    renderLatestOpps();
  });

  $('#morePending')?.addEventListener('click', () => {
    state.pendingShown += 1;
    renderPendingOpps();
  });
});
