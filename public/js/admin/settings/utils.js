// Utils básicos
const Settings = (() => {
  const getToken = () => localStorage.getItem('adm_token');
  const getCsrf  = () => document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

  function headers(json = true) {
    const h = {};
    const token = getToken();
    if (token) h['Authorization'] = token;
    // Inclui CSRF por padrão para páginas web/sessão
    h['X-CSRF-TOKEN'] = getCsrf();
    h['X-Requested-With'] = 'XMLHttpRequest';
    if (json) h['Content-Type'] = 'application/json';
    h['Accept'] = 'application/json';
    return h;
  }

  async function apiGet(url) {
    const res = await fetch(url, { method: 'GET', credentials: 'same-origin', headers: headers(false) });
    if (!res.ok) throw new Error(`GET ${url} => ${res.status}`);
    const raw = await res.text();
    try { return raw ? JSON.parse(raw) : null; } catch { return raw; }
  }
  async function apiPost(url, data) {
    const res = await fetch(url, { method: 'POST', credentials: 'same-origin', headers: headers(true), body: JSON.stringify(data || {}) });
    const payload = await res.json().catch(() => ({}));
    if (!res.ok) throw new Error(payload?.message || `POST ${url} => ${res.status}`);
    return payload;
  }
  async function apiPut(url, data) {
    const res = await fetch(url, { method: 'PUT', credentials: 'same-origin', headers: headers(true), body: JSON.stringify(data || {}) });
    const payload = await res.json().catch(() => ({}));
    if (!res.ok) throw new Error(payload?.message || `PUT ${url} => ${res.status}`);
    return payload;
  }


  async function downloadFile(url, filename) {
    const res = await fetch(url, { method: 'GET', credentials: 'same-origin', headers: headers(false) });
    if (!res.ok) throw new Error(`DOWNLOAD ${url} => ${res.status}`);
    const blob = await res.blob();
    const a = document.createElement('a');
    a.href = URL.createObjectURL(blob);
    a.download = filename || 'download';
    document.body.appendChild(a);
    a.click();
    a.remove();
    URL.revokeObjectURL(a.href);
  }

  const THEME_KEY = 'admin_theme';
  function getTheme() {
    const v = localStorage.getItem(THEME_KEY);
    return v === 'light' || v === 'dark' || v === 'system' ? v : 'system';
  }
  function applyTheme(value) {
   
    document.documentElement.setAttribute('data-theme', value);
  }
  async function saveThemePref(value) {
    localStorage.setItem(THEME_KEY, value);
    applyTheme(value);
   
  }
  
  applyTheme(getTheme());

 
  async function loadNotifications() {

    return {
      email_enabled: true,
      notify_new_opportunity: false,
      notify_new_report: false,
    };
  }
  async function saveNotifications(payload) {

    localStorage.setItem('admin_notifications', JSON.stringify(payload));
    return { ok: true };
  }
  function fillNotifForm(formSel, data) {
    const f = document.querySelector(formSel);
    if (!f) return;
    f.email_enabled.checked         = !!data.email_enabled;
    f.notify_new_opportunity.checked= !!data.notify_new_opportunity;
    f.notify_new_report.checked     = !!data.notify_new_report;
  }
  function collectNotifForm(formSel) {
    const f = document.querySelector(formSel);
    return {
      email_enabled: !!f.email_enabled.checked,
      notify_new_opportunity: !!f.notify_new_opportunity.checked,
      notify_new_report: !!f.notify_new_report.checked,
    };
  }

  return {
    apiGet, apiPost, apiPut, downloadFile,
    getTheme, saveThemePref, loadNotifications, saveNotifications,
    fillNotifForm, collectNotifForm, applyTheme
  };
})();
