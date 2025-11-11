
(function () {
  const { $, handleError, dateFmt } = window.ClubDash.utils;
  const { loadOppsAtivasCount, resetSugestoes, nextSugestoes, hasMoreSugestoes, loadAtividadesRecentes } = window.ClubDash.model;

  const renderOppsCount = async () => {
    const el = $('#countOppsAtivas');
    try {
      const n = await loadOppsAtivasCount();
      el.textContent = n;
    } catch {
      handleError('Erro ao carregar oportunidades', el);
    }
  };

  const renderSugestoes = async (reset = false) => {
    const ul  = $('#listaSugestoes');
    const btn = $('#VerMaisSugestoes');

    try {
      if (reset) {
        ul.innerHTML = '<li>Carregando...</li>';
        const first = await resetSugestoes();
        ul.innerHTML = '';
        if (!first.length) {
          ul.innerHTML = '<li>Nenhuma sugestão encontrada.</li>';
          if (btn) { btn.disabled = true; btn.textContent = 'Ver mais'; }
          return;
        }
        first.forEach(user => {
          const li = document.createElement('li');
          li.textContent = user.nomeCompletoUsuario || user.nome || user.name || 'Usuário sem nome';
          ul.appendChild(li);
        });
        if (btn) {
          btn.disabled = !hasMoreSugestoes();
          btn.textContent = hasMoreSugestoes() ? 'Ver mais' : 'Todas exibidas';
        }
        if (ul.lastElementChild) ul.lastElementChild.scrollIntoView({ behavior: 'smooth', block: 'end' });
        return;
      }

      const more = nextSugestoes();
      more.forEach(user => {
        const li = document.createElement('li');
        li.textContent = user.nomeCompletoUsuario || user.nome || user.name || 'Usuário sem nome';
        ul.appendChild(li);
      });
      if (btn) {
        btn.disabled = !hasMoreSugestoes();
        btn.textContent = hasMoreSugestoes() ? 'Ver mais' : 'Todas exibidas';
      }
      if (ul.lastElementChild) ul.lastElementChild.scrollIntoView({ behavior: 'smooth', block: 'end' });
    } catch {
      handleError('Erro ao carregar sugestões', ul);
      if (btn) { btn.disabled = false; btn.textContent = 'Ver mais'; }
    }
  };

  const renderAtividades = async () => {
    const tbody = $('#recentActivitiesBody');
    tbody.innerHTML = '<tr><td colspan="4">Carregando...</td></tr>';

    try {
      const atividades = await loadAtividadesRecentes();
      if (!atividades.length) {
        tbody.innerHTML = '<tr><td colspan="4">Sem inscrições recentes.</td></tr>';
        return;
      }
      tbody.innerHTML = '';
      atividades.forEach(a => {
        const tr = document.createElement('tr');
        tr.innerHTML = `
          <td>${a.perfil}</td>
          <td>${a.atividade}</td>
          <td>${a.oportunidade}</td>
          <td>${dateFmt(a.data)}</td>
        `;
        tbody.appendChild(tr);
      });
    } catch {
      tbody.innerHTML = '<tr><td colspan="4" style="color:red;">Erro ao carregar atividades recentes.</td></tr>';
    }
  };

  window.ClubDash.dom = { renderOppsCount, renderSugestoes, renderAtividades };
})();
