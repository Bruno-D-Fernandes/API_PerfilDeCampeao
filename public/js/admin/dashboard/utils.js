const $ = (sel) => document.querySelector(sel);
const getToken = () => localStorage.getItem('adm_token');
const getCsrf  = () => document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
const formatDate = (iso) => iso ? new Date(iso).toLocaleString() : '-';

function normalizeList(resp) {
  if (Array.isArray(resp)) return resp;
  if (resp && Array.isArray(resp.data)) return resp.data;
  return [];
}

function normalizeTotal(resp) {
  if (resp && typeof resp.total === 'number') return resp.total;
  return normalizeList(resp).length;
}

function mergeById(...arrays) {
  const m = new Map();
  arrays.flat().forEach(it => { if (it && it.id) m.set(it.id, { ...(m.get(it.id)||{}), ...it }); });
  return Array.from(m.values());
}

function showInlineError(whereSel, msg) {
  const el = $(whereSel);
  if (!el) return;
  const p = document.createElement('p');
  p.textContent = msg;
  p.style.color = 'red';
  el.appendChild(p);
}
