<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <script>(function(){try{var t=localStorage.getItem('clube_theme')||'system';if(t&&t!=='system'){document.documentElement.setAttribute('data-theme',t);}else{document.documentElement.removeAttribute('data-theme');}}catch(e){} })();</script>
  <link rel="stylesheet" href="{{ asset('css/clube/vars.css') }}">
    <meta charset="utf-8">
    <title>Configurações — Clube</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{ asset('css/Clube/config/config.css') }}">
    <link rel="stylesheet" href="{{ asset('css/sidebar/sidebar.css') }}">
     <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body>

@include('clube.sidebar.sidebar')

    <div class="modal" id="temaModal">
    <div class="modal-content">
      <div class="success add">Tema Salvo</div>
    </div>
  </div>

  <div class="modal" id="emailModal">
    <div class="modal-content">
      <div class="success edit">Email Alterado Com Sucesso!</div>
    </div>
  </div>

    <div class="modal" id="senhaModal">
    <div class="modal-content">
      <div class="success edit">Senha Alterado Com Sucesso!</div>
    </div>
  </div>

  <div class="modal" id="senharModal">
    <div class="modal-content">
      <div class="success delete">Falha ao Alterar Senha!</div>
    </div>
  </div>

    <div class="modal" id="sairModal">
    <div class="modal-content">
      <div class="success delete">Sessão encerrada!</div>
    </div>
  </div>

<header class='titulo'>
    <h1 id="page-title">Configuração</h1>


<main aria-labelledby="page-title" id='container'>
    <!-- Preferências -->
    <section aria-labelledby="prefs-title">
        <h2 id="prefs-title">Preferências</h2>

<!--         <article aria-labelledby="notif-title">
            <h3 id="notif-title">Notificações</h3>
            <button id="btnOpenNotificacoes" type="button">Alterar</button>
        </article> -->

        <article aria-labelledby="theme-title">
            <h3 id="theme-title">Tema</h3>
            <fieldset>
                <legend class="sr-only">Escolha o tema</legend>
                <div class='teste' >
                <label><input id="themeSystem" type="radio" name="theme" value="system"> Sistema</label>
                <label><input id="themeLight"  type="radio" name="theme" value="light">  Claro  </label>
                <label><input id="themeDark"   type="radio" name="theme" value="dark">   Escuro </label>
                </div>
              </fieldset>
            <button id="btnSalvarTema" type="button">Salvar tema</button>
        </article>
    </section>

    <!-- Conta -->
    <section aria-labelledby="account-title">
        <h2 id="account-title">Conta</h2>

        <article>
            <h3>Email</h3>
            <button id="btnAlterarEmail" type="button">Alterar</button>
        </article>

        <article>
            <h3>Senha</h3>
            <button id="btnAlterarSenha" type="button">Alterar</button>
        </article>

        <article>
            <h3>Sair</h3>
            <button id="btnLogout" type="button">Sair</button>
        </article>

        <article>
            <h3>Excluir conta</h3>
            <button id="btnExcluirConta" type="button">Excluir conta</button>
        </article>
    </section>

    <!-- Sobre -->
    <section aria-labelledby="about-title">
        <h2 id="about-title">Sobre</h2>
        <article>
            <h3>Políticas de privacidade</h3>
            <button id="btnPolitica" type="button">Abrir</button>
        </article>
        <article>
            <h3>Termos e condições</h3>
            <button id="btnTermos" type="button">Abrir</button>
        </article>
        <article>
            <h3>Saiba mais</h3>
            <button id="btnSobre" type="button">Abrir</button>
        </article>
    </section>
</main>


<div id="modalNotifications" hidden>
  <div>
    <h3>Notificações</h3>
    <form id="formNotificacoes">
      <label><input type="checkbox" name="email_enabled"> Receber por e-mail</label><br>
      <label><input type="checkbox" name="notify_new_opportunity"> Nova oportunidade criada</label><br>
      <label><input type="checkbox" name="notify_new_report"> Nova denúncia registrada</label><br>
      <div>
        <button id="btnSalvarNotificacoes" type="submit">Salvar</button>
        <button data-close="modalNotifications" type="button">Fechar</button>
      </div>
    </form>
  </div>
</div>


<div id="modalEmail" hidden>
  <div>
    <h3>Alterar e-mail</h3>
    <form id="formEmail">
      <label>Novo e-mail
        <input type="email" name="emailClube" id='email' required>
      </label><br>
      <label>Senha atual
        <input type="password" name="current_password" id='senha' required>
      </label><br>
      <div>
        <button type="submit" id='salvar'>Salvar</button>
        <button data-close="modalEmail" type="button" id='fechar'>Fechar</button>
      </div>
    </form>
  </div>
</div>


<div id="modalSenha" hidden>
  <div>
    <h3>Alterar senha</h3>
    <form id="formSenha">
      <label>Senha atual
        <input type="password" name="current_password" required>
      </label><br>
      <label>Nova senha
        <input type="password" name="senhaClube" required>
      </label><br>
      <label>Confirmar nova senha
        <input type="password" name="senhaClube_confirmation" required>
      </label><br>
      <div>
        <button type="submit" class='salvar'>Salvar</button>
        <button data-close="modalSenha" type="button" class='fechar'>Fechar</button>
      </div>
    </form>
  </div>
</div>


<div id="modalLogout" hidden>
  <div>
    <h3>Sair</h3>
    <p>Deseja encerrar a sessão?</p>
    <div>
      <button id="btnConfirmLogout" type="button">Sair</button>
      <button data-close="modalLogout" type="button">Cancelar</button>
    </div>
  </div>
</div>


<div id="modalExcluir" hidden>
  <div>
    <h3>Excluir conta</h3>
    <p>Esta ação é irreversível.</p>
    <form id="formExcluir">
      <label>Digite sua senha
        <input type="password" name="current_password" required>
      </label><br>
      <div>
        <button type="submit" id='excluir'>Excluir</button>
        <button data-close="modalExcluir" type="button">Cancelar</button>
      </div>
    </form>
  </div>
</div>


<div id="modalDocs" hidden>
  <div>
    <h3 id="modalDocsTitle">Documento</h3>
    <br><br>
    <div id="modalDocsBody">Conteúdo...</div>
    <button data-close="modalDocs" type="button">Fechadsa</button>
  </div>
</div>
<script src="{{ asset('js/clube/settings.js') }}"></script>
<script src="{{ asset('js/clube/logout.js') }}"></script>



<script>
document.addEventListener("DOMContentLoaded", async () => {
    const token = localStorage.getItem('clube_token'); // o token salvo no login

    if (!token) {
        console.error("Token não encontrado!");
        return;
    }

    try {
        const response = await fetch('/api/clube/perfil', {
            headers: {
                'Authorization': 'Bearer ' + token,
                'Accept': 'application/json'
            }
        });
        const data = await response.json();
        
        if (data.id) {
            console.log("ID do Clube:", data.id);
            localStorage.setItem('clube_id', data.id);
        } else {
            console.error("Erro ao buscar ID do clube:", data);
        }
    } catch (err) {
        console.error("Falha na requisição:", err);
    }
});


 const linkPerfil = document.getElementById('verPerfil');

  // Adiciona o evento de clique
  linkPerfil.addEventListener('click', function (event) {
    event.preventDefault(); // impede o link de redirecionar imediatamente

    // Pega o ID do clube do localStorage
    const clubeId = localStorage.getItem('clube_id');

    if (clubeId) {
      // Redireciona para a URL desejada
      window.location.href = `/clube/${clubeId}`;
    } else {
      alert('Nenhum clube_id encontrado no localStorage!');
    }
  });

</script>

<script>// Força o primeiro item (Dashboard) como ativo
const dashboardItem = document.querySelector('.menu-navegacao li:nth-child(6)');
if (dashboardItem) {
    dashboardItem.classList.add('ativo');
}

// Alternativa: buscar especificamente pelo link do dashboard
const dashboardLink = document.querySelector('a[href*="admin-clubes"], a[href*="dashboard"]');
if (dashboardLink && dashboardLink.closest('li')) {
    // Remove ativo de todos primeiro
    menuItems.forEach(item => item.classList.remove('ativo'));
    // Adiciona no dashboard
    dashboardLink.closest('li').classList.add('ativo');
}

</script>

</body>
</html>
