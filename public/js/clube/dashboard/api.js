
(function () {
  const { getJSON } = window.ClubDash.utils;

  const fetchMinhasOportunidades = () =>
    getJSON('/api/clube/minhasOportunidades');

  const fetchSearchUsuarios = () =>
    getJSON('/api/clube/search-usuarios');

  const fetchInscritosByOportunidadeId = (id) =>
    getJSON(`/api/clube/oportunidade/${id}/inscritos`);

  window.ClubDash.api = {
    fetchMinhasOportunidades,
    fetchSearchUsuarios,
    fetchInscritosByOportunidadeId
  };
})();
