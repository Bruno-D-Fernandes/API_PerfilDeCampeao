document.addEventListener('DOMContentLoaded', () => {
  document.getElementById('btnDumpSql')?.addEventListener('click', async () => {
    await Settings.downloadFile('/api/admin/backups/dump-sql', 'backup.sql');
  });

  document.querySelectorAll('.btnCsv').forEach(btn => {
    btn.addEventListener('click', async () => {
      const type = btn.getAttribute('data-type');
      await Settings.downloadFile(`/api/admin/export/${encodeURIComponent(type)}.csv`, `${type}.csv`);
    });
  });
});
