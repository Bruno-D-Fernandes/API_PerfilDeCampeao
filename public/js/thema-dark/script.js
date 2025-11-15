const THEME_KEY = 'clube_theme';

const applyTheme = (val) => {
  const theme = ['light', 'dark', 'system'].includes(val) ? val : 'system';

  if (theme === 'system') {
    document.documentElement.removeAttribute('clube-theme');
  } else {
    document.documentElement.setAttribute('clube-theme', theme);
  }

  // Atualizar radios corretamente
  $('#themeLight').prop('checked', theme === 'light');
  $('#themeDark').prop('checked', theme === 'dark');
  $('#themeSystem').prop('checked', theme === 'system');
};

document.addEventListener('DOMContentLoaded', async () => {
  // Tema
  applyTheme(localStorage.getItem(THEME_KEY) || 'system');

  $('#btnSalvarTema')?.addEventListener('click', () => {
    const theme =
      ($('#themeLight').prop('checked') && 'light') ||
      ($('#themeDark').prop('checked') && 'dark') ||
      'system';

    saveTheme(theme);
  });
});
