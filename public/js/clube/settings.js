const $       = (s) => document.querySelector(s);
const token   = localStorage.getItem('clube_token');
const csrf    = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
const authHd  = token ? { Authorization: token } : {};
const baseHd  = {
  'X-Requested-With': 'XMLHttpRequest',
  'X-CSRF-TOKEN': csrf,
  'Accept': 'application/json',
};


const get = async (url) => {
  const res = await fetch(url, {
    credentials: 'same-origin',
    headers: { ...baseHd, ...authHd },
  });

  const text = await res.text();
  try { return text ? JSON.parse(text) : null; }
  catch { return text; }
};

const post = async (url, body = {}) => {
  const res = await fetch(url, {
    method: 'POST',
    credentials: 'same-origin',
    headers: { ...baseHd, ...authHd, 'Content-Type': 'application/json' },
    body: JSON.stringify(body),
  });

  const data = await res.json().catch(() => ({}));
  if (!res.ok) throw new Error(data.message || `POST ${res.status}`);
  return data;
};

const put = async (url, body = {}) => {
  const res = await fetch(url, {
    method: 'PUT',
    credentials: 'same-origin',
    headers: { ...baseHd, ...authHd, 'Content-Type': 'application/json' },
    body: JSON.stringify(body),
  });

  const data = await res.json().catch(() => ({}));
  if (!res.ok) throw new Error(data.message || `PUT ${res.status}`);
  return data;
};

const del = async (url, body) => {
  const res = await fetch(url, {
    method: 'DELETE',
    credentials: 'same-origin',
    headers: { ...baseHd, ...authHd, 'Content-Type': 'application/json' },
    body: body ? JSON.stringify(body) : undefined,
  });

  const data = await res.json().catch(() => ({}));
  if (!res.ok) throw new Error(data.message || `DELETE ${res.status}`);
  return data;
};


const openModal  = (id) => { const el = document.getElementById(id); if (el) el.hidden = false; };
const closeModal = (id) => { const el = document.getElementById(id); if (el) el.hidden = true; };

document.addEventListener('click', (e) => {
  const btn = e.target.closest('[data-close]');
  if (btn) closeModal(btn.getAttribute('data-close'));
});

// ===== Tema (localStorage) =====
const THEME_KEY = 'clube_theme';

const applyTheme = (val) => {
  const theme = ['light', 'dark', 'system'].includes(val) ? val : 'system';
  // Keep behavior consistent with theme-init: remove attribute for 'system'
  if (theme === 'system') document.documentElement.removeAttribute('data-theme');
  else document.documentElement.setAttribute('data-theme', theme);

  if (theme === 'light') $('#themeLight').checked = true;
  else if (theme === 'dark') $('#themeDark').checked = true;
  else $('#themeSystem').checked = true;
};

const saveTheme = (val) => {
  localStorage.setItem(THEME_KEY, val);
  applyTheme(val);
  const tema = document.getElementById('temaModal')
  tema.style.display='flex'
  setTimeout(() => {
    tema.style.display = 'none';
  }, 2000);
};

const NOTIF_KEY = 'clube_notifications';
const notifDefaults = {
  email_enabled: true,
  notify_new_opportunity: false,
  notify_new_report: false,
};

const loadNotifs = async () => {
  try {
    return await get('/api/clube/settings/notifications') ?? notifDefaults;
  } catch {
    return JSON.parse(localStorage.getItem(NOTIF_KEY) || JSON.stringify(notifDefaults));
  }
};

const saveNotifs = async (payload) => {
  try {
    return await post('/api/clube/settings/notifications', payload);
  } catch {
    localStorage.setItem(NOTIF_KEY, JSON.stringify(payload));
    return { ok: true };
  }
};

document.addEventListener('DOMContentLoaded', async () => {

  // Tema
  applyTheme(localStorage.getItem(THEME_KEY) || 'system');

  $('#btnSalvarTema')?.addEventListener('click', () => {
    const theme =
      ($('#themeLight')?.checked && 'light') ||
      ($('#themeDark')?.checked && 'dark') ||
      'system';
    saveTheme(theme);
  });

  // Notificações
  $('#btnOpenNotificacoes')?.addEventListener('click', async () => {
    const data = await loadNotifs();
    const f = $('#formNotificacoes');

    if (f) {
      f.email_enabled.checked          = !!data.email_enabled;
      f.notify_new_opportunity.checked = !!data.notify_new_opportunity;
      f.notify_new_report.checked      = !!data.notify_new_report;
    }

    openModal('modalNotifications');
  });

  $('#formNotificacoes')?.addEventListener('submit', async (e) => {
    e.preventDefault();

    const f = e.target;
    const payload = {
      email_enabled: !!f.email_enabled.checked,
      notify_new_opportunity: !!f.notify_new_opportunity.checked,
      notify_new_report: !!f.notify_new_report.checked,
    };

    try {
      await saveNotifs(payload);
      alert('Preferências salvas');
      closeModal('modalNotifications');
    } catch (err) {
      alert(err.message || 'Falha ao salvar notificações');
    }
  });

  // Alterar e-mail
  $('#btnAlterarEmail')?.addEventListener('click', () => openModal('modalEmail'));

  $('#formEmail')?.addEventListener('submit', async (e) => {
    e.preventDefault();
     const fd = new FormData(e.target);
    const emailClube       = fd.get('emailClube');
    const current_password = fd.get('current_password');

    try {
      await put('/api/clube/update', { emailClube, current_password });
      const email = document.getElementById('emailModal')
  email.style.display='flex'
  setTimeout(() => {
    email.style.display = 'none';
  }, 2000);
      closeModal('modalEmail');
    } catch (err) {
      alert(err.message || 'Erro ao atualizar e-mail');
    }
  });

  // Alterar senha
  $('#btnAlterarSenha')?.addEventListener('click', () => openModal('modalSenha'));

  $('#formSenha')?.addEventListener('submit', async (e) => {
    e.preventDefault();
    const f = e.target;

    const payload = {
      current_password: f.current_password.value,
      senhaClube: f.senhaClube.value,
      senhaClube_confirmation: f.senhaClube_confirmation.value,
    };

    try {
      await put('/api/clube/update', payload);
       const tema = document.getElementById('senhaModal')
  tema.style.display='flex'
  setTimeout(() => {
    tema.style.display = 'none';
  }, 2000);
      closeModal('modalSenha');
    } catch (err) {
      const senhar = document.getElementById('senharModal')
  senhar.style.display='flex'
  setTimeout(() => {
    senhar.style.display = 'none';
  }, 2000);
      /* alert(err.message || 'Erro ao atualizar senha'); */
    }
  });

  // 2FA
  $('#btnConfig2FA')?.addEventListener('click', () => openModal('modal2FA'));

  $('#btn2FAEnable')?.addEventListener('click', async () => {
    try {
      await post('/api/clube/2fa/enable');
      alert('2FA ativado');
      closeModal('modal2FA');
    } catch {
      alert('Endpoint de 2FA não disponível');
    }
  });

  $('#btn2FADisable')?.addEventListener('click', async () => {
    try {
      await post('/api/clube/2fa/disable');
      alert('2FA desativado');
      closeModal('modal2FA');
    } catch {
      alert('Endpoint de 2FA não disponível');
    }
  });

  // Logout
  $('#btnLogout')?.addEventListener('click', () => openModal('modalLogout'));

  $('#btnConfirmLogout')?.addEventListener('click', async () => {
    try {
      await post('/api/clube/logout');
      localStorage.removeItem('clube_token');
       const tema = document.getElementById('sairModal')
  tema.style.display='flex'
  setTimeout(() => {
    tema.style.display = 'none';
  }, 2000);
      /* alert('Sessão encerrada'); */
      window.location.href = '/clube/login';
      closeModal('modalLogout');
    } catch (err) {
      alert(err.message || 'Erro ao sair');
    }
  });

  // Excluir conta
  $('#btnExcluirConta')?.addEventListener('click', () => openModal('modalExcluir'));

  $('#formExcluir')?.addEventListener('submit', async (e) => {
    e.preventDefault();
    const { current_password } = Object.fromEntries(new FormData(e.target).entries());

    try {
      await del('/api/clube/delete', { current_password });
      localStorage.removeItem('clube_token');
      alert('Conta excluída');
      window.location.href = '/clube/login';
      closeModal('modalExcluir');
    } catch (err) {
      alert(err.message || 'Erro ao excluir conta');
    }
  });

  // Documentos simples
  const openDoc = (title, body) => {
    $('#modalDocsTitle').textContent = title;
    $('#modalDocsBody').textContent  = body;
    openModal('modalDocs');
  };

  $('#btnPolitica')?.addEventListener('click', () => openDoc('Política de Privacidade', 'Conteúdo da política...'));
  $('#btnTermos')?.addEventListener('click',   () => openDoc('Termos e Condições', 'Conteúdo dos termos...'));
  $('#btnSobre')?.addEventListener('click',    () => openDoc('Sobre', 'Informações do sistema...'));
});