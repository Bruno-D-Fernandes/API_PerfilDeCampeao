<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8" />
  <title>Dashboard — Clube</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>

  <h1>Dashboard</h1>

  <!-- Cards -->
  <section id="cards">
    <div class="card">
      <h2>Oportunidades (ativas)</h2>
      <div id="countOppsAtivas">-</div>
      <a id="linkOppsAtivas" href="/clube/oportunidades">abrir</a>
    </div>

    <div class="card">
      <h2>Lista de Campeões</h2>
      <a id="linkListaCampeoes" href="/clube/lista">ver lista</a>
    </div>
  </section>

  <!-- Blocos -->
  <main>
    <!-- Sugestões -->
    <section id="sugestoes">
      <h3>Sugestões</h3>

      <label for="tipoSugestao">Categoria</label>
      <select id="tipoSugestao">
        <option value="Lateral">Lateral</option>
        <option value="Zagueiro">Zagueiro</option>
        <option value="Meia">Meia</option>
        <option value="Atacante">Atacante</option>
        <option value="Goleiro">Goleiro</option>
      </select>

      <ul id="listaSugestoes">
        <!-- itens carregados via JS (sem pessoas mockadas aqui) -->
      </ul>

      <button id="VerMaisSugestoes" type="button">Ver mais</button>
    </section>

    <!-- Atividades recentes -->
    <section id="atividadesRecentes">
      <h3>Atividades recentes</h3>

      <table border="1" cellpadding="4" cellspacing="0">
        <thead>
          <tr>
            <th>Perfil</th>
            <th>Atividade</th>
            <th>Oportunidade</th>
            <th>Data</th>
          </tr>
        </thead>
        <tbody id="recentActivitiesBody">
          <!-- linhas carregadas via JS -->
        </tbody>
      </table>
    </section>
  </main>

  <!-- (reservado para modais quando forem necessários) -->
  <div id="modalRoot"></div>


   <script>
    const $ = (s) => document.querySelector(s);
    const token = localStorage.getItem('clube_token');
    const csrf  = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const headers = {
      'X-Requested-With': 'XMLHttpRequest',
      'X-CSRF-TOKEN': csrf,
      'Accept': 'application/json',
      'Authorization': token,
      'Content-Type': 'application/json'
    };

    // ========================
    // FUNÇÕES AUXILIARES
    // ========================

    const getJSON = async (url) => {
      const res = await fetch(url, { headers });
      if (!res.ok) throw new Error(`Erro ${res.status}`);
      return await res.json();
    };

    const handleError = (msg, el) => {
      if (el) el.innerHTML = `<span style="color:red;">${msg}</span>`;
      console.error(msg);
    };

    // ========================
    // CONTADOR DE OPORTUNIDADES ATIVAS
    // ========================
    async function carregarOportunidades() {
      const el = $('#countOppsAtivas');
      try {
        const data = await getJSON('/api/clube/minhasOportunidades');
        const ativas = data.filter(op => op.status === 'approved');
        el.textContent = ativas.length || 0;
      } catch (err) {
        handleError('Erro ao carregar oportunidades', el);
      }
    }

    // ========================
    // LISTAR SUGESTÕES (jogadores)
    // ========================
    async function carregarSugestoes() {
      const el = $('#listaSugestoes');
      el.innerHTML = '<li>Carregando...</li>';
      try {
        const data = await getJSON('/api/clube/search-usuarios');
        el.innerHTML = '';
        if (!data || data.length === 0) {
          el.innerHTML = '<li>Nenhuma sugestão encontrada.</li>';
          return;
        }
        data.slice(0, 5).forEach(user => {
          const li = document.createElement('li');
          li.textContent = user.nome || user.name || 'Usuário sem nome';
          el.appendChild(li);
        });
      } catch (err) {
        handleError('Erro ao carregar sugestões', el);
      }
    }

    // ========================
    // ATIVIDADES RECENTES (simuladas)
    // ========================
    function carregarAtividadesRecentes() {
      const tbody = $('#recentActivitiesBody');
      const dataSimulada = [
        { perfil: 'João Silva', atividade: 'Inscrição aprovada', oportunidade: 'Copa Sub-20', data: '2025-11-10' },
        { perfil: 'Maria Souza', atividade: 'Novo jogador seguido', oportunidade: '-', data: '2025-11-09' }
      ];

      tbody.innerHTML = '';
      dataSimulada.forEach(item => {
        const tr = document.createElement('tr');
        tr.innerHTML = `
          <td>${item.perfil}</td>
          <td>${item.atividade}</td>
          <td>${item.oportunidade}</td>
          <td>${item.data}</td>
        `;
        tbody.appendChild(tr);
      });
    }

    // ========================
    // EVENTOS E INICIALIZAÇÃO
    // ========================
    document.addEventListener('DOMContentLoaded', () => {
      carregarOportunidades();
      carregarSugestoes();
      carregarAtividadesRecentes();

      $('#tipoSugestao')?.addEventListener('change', carregarSugestoes);
      $('#VerMaisSugestoes')?.addEventListener('click', carregarSugestoes);
    });
  </script>

</body>
</html>
