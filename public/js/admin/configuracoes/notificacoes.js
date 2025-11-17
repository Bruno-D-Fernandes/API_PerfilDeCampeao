document.addEventListener('DOMContentLoaded', async () => {
  try {
    const data = await Settings.loadNotifications();
    Settings.fillNotifForm('#notifForm', data);
  } catch {}

  document.getElementById('notifForm')?.addEventListener('submit', async (e) => {
    e.preventDefault();
    const payload = Settings.collectNotifForm('#notifForm');
    await Settings.saveNotifications(payload);
    alert('Preferências salvas.');
  });
});
