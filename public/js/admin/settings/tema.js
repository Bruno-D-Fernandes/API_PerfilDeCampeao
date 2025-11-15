document.addEventListener('DOMContentLoaded', () => {
  const current = Settings.getTheme();
  const input = document.querySelector(`input[name="theme"][value="${current}"]`);
  if (input) input.checked = true;

  document.getElementById('themeForm')?.addEventListener('submit', async (e) => {
    e.preventDefault();
    const value = new FormData(e.target).get('theme') || 'system';
    await Settings.saveThemePref(value);
        const amodal = document.getElementById('aModal')
                amodal.style.display='flex'
        setTimeout(() => {
        amodal.style.display = 'none';

    }, 3000);
    
  });
});
