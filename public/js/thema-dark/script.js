const THEME_KEY = 'clube_theme';

const applyTheme = (val) => {
  const theme = ['light', 'dark', 'system'].includes(val) ? val : 'system';
  document.documentElement.setAttribute('data-theme', theme);

  if (theme === 'light') $('#themeLight').checked = true;
  else if (theme === 'dark') $('#themeDark').checked = true;
  else $('#themeSystem').checked = true;
};

const saveTheme = (val) => {
  localStorage.setItem(THEME_KEY, val);
  applyTheme(val);
  alert('Tema salvo!');
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
 });