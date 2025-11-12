// Apply saved theme as early as possible to avoid flash-of-unstyled-theme (FOUC)
// Reads 'clube_theme' from localStorage and sets data-theme on <html>.
(function () {
  try {
    var key = 'clube_theme';
    var t = localStorage.getItem(key) || 'system';
    if (t && t !== 'system') {
      // valid values: 'light' or 'dark' expected by CSS selectors
      document.documentElement.setAttribute('data-theme', t);
    } else {
      // if 'system' or not set, remove attribute so prefers-color-scheme can take over
      document.documentElement.removeAttribute('data-theme');
    }
  } catch (e) {
    // ignore - localStorage might be unavailable in some contexts
  }
})();
