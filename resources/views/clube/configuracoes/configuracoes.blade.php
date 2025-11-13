<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <script>(function(){try{var t=localStorage.getItem('clube_theme')||'system';if(t&&t!=='system'){document.documentElement.setAttribute('data-theme',t);}else{document.documentElement.removeAttribute('data-theme');}}catch(e){} })();</script>
  <link rel="stylesheet" href="{{ asset('css/clube/vars.css') }}">
    <meta charset="utf-8">
    <title>Configurações — Clube</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{ asset('css/Clube/config/config.css') }}">
    <link rel="stylesheet" href="{{ asset('css/clube/sidebar/sidebar.css') }}">
     <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>


    <main class="conteudo-principal">
    <!--NAVBAR LT1-->
    <nav class="barra-lateral" id="barra-lateral">

        <!--ESPAÇO PRA LOGO LT1-->
        <div class="logo-container">
            <!-- LOGO PEQUENA-->
            <img src="../img/logo-clube-reduzida.png" alt="Logo" class="logo-pequena">
            <!--LOGO GRANDE-->
            <img src="../img/logo-clube-completa.jpeg" alt="Logo" class="logo-grande">
            <!--ESPAÇO PRA LOGO LT1-->
        </div>

        <ul class="menu-navegacao">
            <li class=".">
                <a href="{{route('clube-dashboard')}}">
                    <i class='bx bx-home-alt'></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="">
                <a href="{{route('clube-oportunidades')}}">
                    <i class='bx bx-briefcase'></i>
                    <span>Oportunidades</span>
                </a>
            </li>
            <li>
                <a href="#">
                    <i class='bx bx-list-ul'></i>
                    <span>Listas</span>
                </a>
            </li>
            <li>
                <a href="#">
                    <i class='bx bx-message-dots'></i>
                    <span>Mensagens</span>
                </a>
            </li>
            <li>
                <a href="#">
                    <i class='bx bx-bell'></i>
                    <span>Notificações</span>
                </a>
            </li>
            <li>
                <a href="/clube/perfil">
                    <i class='bx bx-user'></i>
                    <span>Perfil</span>
                </a>
            </li>
            <li>
                <a href="../tela-pesquisa/pesquisa.html">
                    <i class='bx bx-search'></i>
                    <span>Pesquisa</span>
                </a>
            </li>
            <li  class="ativo">
                <a href="{{route('clube-configuracoes')}}">
                    <i class='bx bx-cog'></i>
                    <span>Configurações</span>
                </a>
            </li>
            <li>
                  <!-- ===== Barra vermelha antes de SAIR ===== -->
            <hr class="barra-vermelha">   <!-- // ↓↓↓ ALTERADO -->

            <li class="sair-link">        <!-- // ↓↓↓ ALTERADO -->
                <a href="#">
                    <i class='bx bx-log-out'></i>
                    <span>Sair</span>
                </a>
            </li>
        </ul>
    </nav>
    
    <!--NAVBAR LT1-->

    </main>

<header class='titulo'>
    <h1 id="page-title">Configuração</h1>


<main aria-labelledby="page-title" id='container'>
    <!-- Preferências -->
    <section aria-labelledby="prefs-title">
        <h2 id="prefs-title">Preferências</h2>

        <article aria-labelledby="notif-title">
            <h3 id="notif-title">Notificações</h3>
            <button id="btnOpenNotificacoes" type="button">Alterar</button>
        </article>

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
</body>
</html>
