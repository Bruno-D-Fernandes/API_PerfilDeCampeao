<!-- sidebar.php -->
<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

<style>
  /* === FONTES === */
  @import url('https://fonts.googleapis.com/css2?family=Segoe+UI:wght@400;500;600&display=swap');

  * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
  }

  /* === TEMA CLARO (PADRÃO) === */
  :root {
    --bg-primary: #ffffff;
    --bg-secondary: #f0f8ff; /* Azul muito claro de fundo */
    --text-primary: #1a1a1a;
    --text-secondary: #333333;
    --border-color: #4b93ffff;
    --shadow: rgba(0, 102, 255, 0.15); /* Sombra azulada */
    --hover-bg: #e6f2ff;
    --active-bg: #0066ff; /* Azul vibrante ativo */
    --active-text: #ffffff;
    --danger-color: #dc3545;
    --icon-color: #000000ff;
  }

  /* === TEMA ESCURO === */
  [data-theme="dark"] {
    --bg-primary: #0a0a1a;
    --bg-secondary: #0f0f2a;
    --text-primary: #e0e0ff;
    --text-secondary: #b3d9ff;
    --border-color: #1a3366;
    --shadow: rgba(0, 102, 255, 0.3);
    --hover-bg: #1a3366;
    --active-bg: #0055cc;
    --active-text: #ffffff;
    --danger-color: #dc3545;
    --icon-color: #66b3ff;
  }

  body {
    font-family: 'Segoe UI', sans-serif;
    background: var(--bg-primary);
    color: var(--text-primary);
    font-size: 16px;
    transition: background 0.3s, color 0.3s;
  }

  .barra-lateral {
    position: fixed;
    left: 0;
    top: 0;
    height: 100vh;
    width: 70px;
    background: var(--bg-secondary);
    box-shadow: 4px 0 16px rgba(0, 0, 0, 0.35); /* SOMBRA ESCURA */
    transition: width 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    overflow: hidden;
    z-index: 1000;
    display: flex;
    flex-direction: column;
  }

  .barra-lateral:hover {
    width: 220px;
  }

  .logo-container {
    height: 80px;
    border-bottom: 1px solid var(--border-color);
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
  }

  .logo-pequena {
    width: 56px;
    height: 52px;
    border-radius: 15px;
    opacity: 1;
    transition: opacity 0.2s;
  }

  .logo-grande {
    position: absolute;
    width: 150px;
    border-radius: 15px;
    height: 70px;
    opacity: 0;
    transition: opacity 0.2s;
  }

  .barra-lateral:hover .logo-pequena {
    opacity: 0;
  }

  .barra-lateral:hover .logo-grande {
    opacity: 1;
  }

  .menu-navegacao {
    list-style: none;
    padding: 20px 0;
    flex: 1;
  }

  .menu-navegacao li,
  .sair-link {
    margin: 4px 0;
  }
.sair-link button {
 display: flex;
    align-items: center;
    font-weight: bold;
    gap: 5px;

    color: var(--text-secondary);
    text-decoration: none;
    white-space: nowrap;
    transition: all 0.2s;
    background: none;
    border: none;
    cursor: pointer;
    width: 100%;
    font-family: 'Segoe UI', sans-serif;
    font-size: 16px;
}
  .menu-navegacao a{
    display: flex;
    align-items: center;
    font-weight: bold;
    gap: 5px;
    padding: 12px 20px;
    color: var(--text-secondary);
    text-decoration: none;
    white-space: nowrap;
    transition: all 0.2s;
    background: none;
    border: none;
    cursor: pointer;
    width: 100%;
    text-align: left;
    font-family: 'Segoe UI', sans-serif;
    font-size: 16px;
  }

  /* Ícones sempre visíveis, mesmo na versão fechada */
  .menu-navegacao i,
  .sair-link i {
    font-size: 20px;
    min-width: 24px;
    text-align: center;
    color: var(--icon-color);
  }

  /* Texto some quando fechado */
  .menu-navegacao span,
  .sair-link span {
    opacity: 0;
    transition: opacity 0.25s ease;
    white-space: nowrap;
  }

  .barra-lateral:hover .menu-navegacao span,
  .barra-lateral:hover .sair-link span {
    opacity: 1;
  }

  .menu-navegacao a:hover,
  .sair-link button:hover {
    background: var(--hover-bg);
    color: var(--text-primary);
  }

  .menu-navegacao .ativo a {
    background: var(--active-bg);
    color: var(--active-text);
    border-radius: 0 25px 25px 0;
    box-shadow: 2px 2px 6px rgba(0, 0, 0, 0.15);
  }

  /* FORÇA COR DO ÍCONE NO ITEM ATIVO */
  .menu-navegacao .ativo a i {
    color: var(--active-text) !important;
  }

  /* Botão de Sair com vermelho */
  .sair-link button {
    color: var(--danger-color) !important;
  }

  .sair-link i {
    color: var(--danger-color) !important;
  }

  .spacer {
    text-align: left;
    font-weight: bold;
  }
  .sair{
    color:var(--danger-color)
  }
</style>

<?php
$pagina_atual = Route::currentRouteName();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>
  
</body>

<nav class="barra-lateral" id="barra-lateral">
  <div class="logo-container">
    <img src="/img/logo-admin-reduzida.jpeg" alt="Logo Pequena" class="logo-pequena">
    <img src="../img/logo-admin-completa.jpeg" alt="Logo Grande" class="logo-grande">
  </div>

  <ul class="menu-navegacao">
    <li class="{{ ($pagina_atual === 'admin.dashboard') ? 'ativo' : '' }}">
      <a href="/admin/dashboard">
        <i class='bx bx-home-alt'></i>
        <span>Dashboard</span>
      </a>
    </li>
    <li class="{{ ($pagina_atual === 'admin.oportunidades') ? 'ativo' : '' }}">
      <a href="/admin/oportunidades">
        <i class='bx bx-briefcase'></i>
        <span>Oportunidades</span>
      </a>
    </li>
    <li class="<?= ($pagina_atual === 'usuarios.php') ? 'ativo' : '' ?>">
      <a href="/admin/usuarios">
        <i class='bx bx-group'></i>
        <span>Usuários</span>
      </a>
    </li>
    <li class="<?= ($pagina_atual === 'clubes.php') ? 'ativo' : '' ?>">
      <a href="/admin/clubes">
        <i class='bx bx-shield'></i>
        <span>Clubes</span>
      </a>
    </li>
    <li class="<?= ($pagina_atual === 'funcoes.php') ? 'ativo' : '' ?>">
      <a href="/admin/funcoes">
        <i class='bx bx-crown'></i>
        <span>Funções</span>
      </a>
    </li>
    <li class="<?= ($pagina_atual === 'esportes.php') ? 'ativo' : '' ?>">
      <a href="/admin/esportes">
        <i class='bx bx-trophy'></i>
        <span>Esportes</span>
      </a>
    </li>
    <li class="<?= ($pagina_atual === 'lista.php') ? 'ativo' : '' ?>">
      <a href="/admin/lista">
        <i class='bx bx-list-ul'></i>
        <span>Lista</span>
      </a>
    </li>
    <li class="<?= ($pagina_atual === 'configuracao.php') ? 'ativo' : '' ?>">
      <a href="/admin/configuracoes">
        <i class='bx bx-cog'></i>
        <span>Configurações</span>
      </a>
    </li>
<li>
  <form id='logout'>
  <div class="spacer">
      <div class="sair-link">
        <button type="submit">
      <a>
      <i class='bx bx-log-out'></i>
      <span class='sair'>Sair</span>
      </a>
      </button>
  </div></form>
</li>
  </ul>

  
  </div>

  <!-- Botão de Sair como <button> -->

 
</nav>
</html>