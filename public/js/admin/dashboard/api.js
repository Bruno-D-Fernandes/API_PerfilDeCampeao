async function apiGet(url) {
  const token = getToken();
  if (!token) throw new Error('Sem token do admin');
  const res = await fetch(url, {
    method: 'GET',
    credentials: 'same-origin',
    headers: {
      'Accept': 'application/json',
      'Authorization': token,
      'X-CSRF-TOKEN': getCsrf(),
      'X-Requested-With': 'XMLHttpRequest'
    }
  });
  const raw = await res.text();
  let data = null;
  try { data = raw ? JSON.parse(raw) : null; } catch {}
  if (!res.ok) {
    const err = new Error((data && (data.message || data.error)) || `HTTP ${res.status}`);
    err.status = res.status;
    err.body = raw;
    throw err;
  }
  return data ?? raw;
}

const api = {
  users: () => apiGet('/api/admin/usuarios'),
  clubs: () => apiGet('/api/admin/clubes'),
  oppsAll: () => apiGet('/api/admin/list'),
  oppsRejected: async () => {
    try { return await apiGet('/api/admin/oportunidades?status=REJECTED'); }
    catch (e) {
      if (e.status === 404) {
        try { return await apiGet('/api/admin/oportunidades/rejeitadas'); }
        catch (e2) { if (e2.status !== 404) throw e2; return []; }
      }
      throw e;
    }
  },
};
