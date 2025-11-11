
const $ = (s) => document.querySelector(s);
const token = localStorage.getItem('clube_token');
const csrf  = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
const headers = {
  'X-Requested-With': 'XMLHttpRequest',
  'X-CSRF-TOKEN': csrf,
  'Accept': 'application/json',
  'Authorization': token,
  'Content-Type': 'application/json'
};

const getJSON = async (url) => {
  const res = await fetch(url, { method: 'GET', credentials: 'same-origin', headers });
  const raw = await res.text();
  let data;
  try { data = raw ? JSON.parse(raw) : null; } catch { data = raw; }
  if (!res.ok) {
    const errMsg = (data && (data.message || data.error)) || `Erro ${res.status}`;
    throw new Error(errMsg);
  }
  return data;
};

const handleError = (msg, el) => {
  if (el) el.innerHTML = `<span style="color:red;">${msg}</span>`;
  console.error(msg);
};

const normalizeList = (data) => {
  if (Array.isArray(data)) return data;
  if (data?.data && Array.isArray(data.data)) return data.data;
  if (data?.items && Array.isArray(data.items)) return data.items;
  if (data && typeof data === 'object') return Object.values(data);
  return [];
};

const isApproved = (status) => {
  if (!status) return false;
  const s = String(status).toLowerCase();
  return s.includes('aprov') || s === 'approved' || s === 'true' || s === '1';
};

const statusToAtividade = (statusRaw) => {
  const s = String(statusRaw ?? '').toLowerCase();
  if (s.includes('aprov') || s === 'approved') return 'Inscrição aprovada';
  if (s.includes('recus') || s === 'rejected') return 'Inscrição recusada';
  if (s.includes('pend')  || s === 'pending')  return 'Inscrição pendente';
  return 'Inscrição atualizada';
};

const dateFmt = (d) => new Date(d).toLocaleString();

window.ClubDash = window.ClubDash || {};
window.ClubDash.utils = { $, token, csrf, headers, getJSON, handleError, normalizeList, isApproved, statusToAtividade, dateFmt };
