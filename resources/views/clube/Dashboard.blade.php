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

    <main>
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

            </ul>

            <button id="VerMaisSugestoes" type="button">Ver mais</button>
        </section>

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
            
                </tbody>
            </table>
        </section>
    </main>
 
    <div id="modalRoot"></div>

    <script src="{{ asset('js/clube/dashboard/utils.js') }}"></script>
    <script src="{{ asset('js/clube/dashboard/api.js') }}"></script>
    <script src="{{ asset('js/clube/dashboard/models.js') }}"></script>
    <script src="{{ asset('js/clube/dashboard/dom-elements.js') }}"></script>
    <script src="{{ asset('js/clube/dashboard/events.js') }}"></script>
</body>
</html>