
(function () {
  const { token, $ } = window.ClubDash.utils;
  const { renderOppsCount, renderSugestoes, renderAtividades } = window.ClubDash.dom;

  document.addEventListener('DOMContentLoaded', () => {
    if (!token) console.warn('Token do clube não encontrado no localStorage (clube_token).');

    renderOppsCount();
    renderSugestoes(true);
    renderAtividades();

    $('#tipoSugestao')?.addEventListener('change', () => renderSugestoes(true));
    $('#VerMaisSugestoes')?.addEventListener('click',  () => renderSugestoes(false));
  });
})();
