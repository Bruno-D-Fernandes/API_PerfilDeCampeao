
(function () {
  const { normalizeList, isApproved, statusToAtividade } = window.ClubDash.utils;
  const { fetchMinhasOportunidades, fetchSearchUsuarios, fetchInscritosByOportunidadeId } = window.ClubDash.api;

  let sugestoesData = [];
  let sugestoesIndex = 0;
  const PAGE_SIZE = 5;

  const loadOppsAtivasCount = async () => {
    const resp = await fetchMinhasOportunidades();
    const lista = normalizeList(resp);
    const ativas = lista.filter(op => isApproved(op.status));
    return ativas.length || 0;
  };

  const resetSugestoes = async () => {
    sugestoesIndex = 0;
    const resp = await fetchSearchUsuarios();
    sugestoesData = normalizeList(resp);
    return sugestoesData.slice(0, PAGE_SIZE);
  };

  const nextSugestoes = () => {
    const start = sugestoesIndex + PAGE_SIZE;
    const end   = start + PAGE_SIZE;
    const next  = sugestoesData.slice(start, end);
    sugestoesIndex = start;
    return next;
  };

  const hasMoreSugestoes = () => (sugestoesIndex + PAGE_SIZE) < sugestoesData.length;

  const loadAtividadesRecentes = async () => {
    const oppsResp = await fetchMinhasOportunidades();
    const opps = normalizeList(oppsResp).filter(op => isApproved(op.status));
    if (!opps.length) return [];

    const MAX_OPPS = 5;
    const subset = opps
      .slice()
      .sort((a,b) => new Date(b.updated_at || b.created_at || 0) - new Date(a.updated_at || a.created_at || 0))
      .slice(0, MAX_OPPS);

    const inscritosPromises = subset.map(async (op) => {
      const id = op.id || op.oportunidade_id || op.codigo || op.uuid;
      if (!id) return [];
      try {
        const r = await fetchInscritosByOportunidadeId(id);
        const lista = normalizeList(r);
        return lista.map(item => {
          const usuario = item.usuario || item.user || item.inscrito || item.perfil || {};
          const perfilNome =
            usuario.nomeCompletoUsuario || usuario.nome || usuario.name ||
            item.nomeUsuario || item.nome || 'Usuário';

          const oportunidadeTitulo =
            op.tituloOportunidades || op.titulo || op.descricaoOportunidades || `#${id}`;

          const statusInscricao = item.status ?? item.pivot?.status;

          const when =
            item.created_at || item.updated_at ||
            (item.pivot && (item.pivot.created_at || item.pivot.updated_at)) ||
            new Date().toISOString();

          return {
            perfil: perfilNome,
            atividade: statusToAtividade(statusInscricao),
            oportunidade: oportunidadeTitulo,
            data: when
          };
        });
      } catch {
        return [];
      }
    });

    const nested = await Promise.all(inscritosPromises);
    const atividades = nested.flat();

    atividades.sort((a,b)=> new Date(b.data) - new Date(a.data));
    return atividades.slice(0, 10);
  };

  window.ClubDash.model = {
    loadOppsAtivasCount,
    resetSugestoes,
    nextSugestoes,
    hasMoreSugestoes,
    loadAtividadesRecentes
  };
})();
