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
    --bg-secondary: #f5f7fa;
    --text-primary: #2d2d2d;
    --text-secondary: #666666;
    --border-color: #d1d1d1;
    --shadow: rgba(0, 0, 0, 0.1);
    --hover-bg: #e9ecef;
    --active-bg: #36B37E;     /* Verde ativo */
    --active-text: #ffffff;
    --danger-color: #dc3545;
    --icon-color: #36B37E;    /* ÍCONES VERDES */
  }

  /* === TEMA ESCURO === */
  [data-theme="dark"] {
    --bg-primary: #161616ff;
    --bg-secondary: #232323ff;
    --text-primary: #e0e0e0;
    --text-secondary: #a0a0a0;
    --border-color: #404040;
    --shadow: rgba(0, 0, 0, 0.6);
    --hover-bg: #3a3a3a;
    --active-bg: #66bb6a;   /* Verde escuro */
    --active-text: #000000ff;
    --danger-color: #c14444;
    --icon-color: #66bb6a;   /* ÍCONES VERDES NO MODO ESCURO */
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
    /* REMOVIDA A BORDA LATERAL */
    /* ADICIONADA SOMENTE SOMBRAS ESCURAS */
    box-shadow: 4px 0 16px rgba(0, 0, 0, 0.25); /* Sombra escura no modo claro */
    transition: width 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    overflow: hidden;
    z-index: 1000;
    display: flex;
    flex-direction: column;
    /* REMOVIDO: border-right: ... */
  }

  /* Sombra mais intensa no modo escuro */
  [data-theme="dark"] .barra-lateral {
    box-shadow: 4px 0 16px rgba(0, 0, 0, 0.45);
  }

  .barra-lateral:hover {
    width: 240px;
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
    width: 56px;
    border-radius: 15px;
    height: 52px;
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
    text-align: left;
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

  /* Ícones sempre visíveis e VERDES */
  .menu-navegacao i,
  .sair-link i {
    font-size: 20px;
    min-width: 24px;
    text-align: center;
    color: var(--icon-color); /* Agora VERDE em todos os modos */
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

  /* Garante que o ícone fique branco quando ativo (sobre fundo verde) */
  .menu-navegacao .ativo a i {
    color: var(--active-text) !important;
  }

  /* Botão Sair em vermelho (não verde) */
  .sair-link button {
    color: var(--danger-color) !important;
  }
  .sair-link i {
    color: var(--danger-color) !important;
  }

  .spacer {
    flex: 1;
  }
  #vaisim{
    color: var(--danger-color)
  }
</style>

<?php
$pagina_atual = basename($_SERVER['PHP_SELF']);
?>

<nav class="barra-lateral" id="barra-lateral">
  <div class="logo-container">
    <img src="/img/logo-reduzida.png" alt="Logo Pequena" class="logo-pequena">
    <img src="/img/logo-reduzida.png" alt="Logo Grande" class="logo-grande">
  </div>

  <ul class="menu-navegacao">
    <li class="<?= ($pagina_atual === 'dashboard.php') ? 'ativo' : '' ?>">
      <a href="/clube/dashboard">
        <i class='bx bx-home-alt'></i>
        <span>Dashboard</span>
      </a>
    </li>
    <li class="<?= ($pagina_atual === 'oportunidades.php') ? 'ativo' : '' ?>">
      <a href="/clube/oportunidades">
        <i class='bx bx-briefcase'></i>
        <span>Oportunidades</span>
      </a>
    </li>
    <li class="<?= ($pagina_atual === 'perfil.php') ? 'ativo' : '' ?>">
     <form id='verPerfil'>  

    <a id='verPerfil'>
        <i class='bx bx-user'></i>
        <span>Clube</span>
      </a>
    </li>
    </form>
 
    <li class="<?= ($pagina_atual === 'pesquisa.php') ? 'ativo' : '' ?>">
      <a href="/clube/pesquisa">
        <i class='bx bx-search'></i>
        <span>Pesquisa</span>
      </a>
    </li>
    <li class="<?= ($pagina_atual === 'configuracao.php') ? 'ativo' : '' ?>">
      <a href="/clube/configuracoes">
        <i class='bx bx-cog'></i>
        <span>Configuração</span>
      </a>
    </li>
  <li>
  <form id='logout'>
  <div class="spacer">
      <div class="sair-link">
        <button type="submit">
      <a>
      <i class='bx bx-log-out'></i>
      <span class='sair' id='vaisim'>Sair</span>
      </a>
      </button>
  </div></form>
</li>
  </ul>


  <!-- Botão Sair como <button> -->
    
</nav>

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