<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configuração</title>
    <link rel="stylesheet" href="./css/configuracaoClub.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
<style>#Logo{
        width: 150px;
        border-radius: 20px;
    }
    .item-icon {
    font-size: 20px;
    margin-right: 10px;
    color: #555;
    vertical-align: middle;
}

.item-icon-danger {
    color: #e63946;
}
    </style>
</head>
<body>
    <div class="container">
        <!-- Sidebar (IDÊNTICA AOS SEUS EXEMPLOS) -->
        <aside class="sidebar">
            <div class="logo-section">
                <img id="Logo" src="{{ asset('img/logoPerfil.jpeg') }}" alt="Logo do Perfil">
            </div>
            
            <nav class="nav-menu">
                <ul>
                    <li class="nav-item">
                        <a href="dashClub" class="nav-link">
                            <img class="nav-icon" src="./img/dashboard.png" alt="Dashboard">
                            <span class="nav-text">Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="oportunidades" class="nav-link">
                            <img class="nav-icon" src="./img/oportunidades.png" alt="Perfil">
                            <span class="nav-text">Oportunidades</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <img class="nav-icon" src="./img/vector.png" alt="Lista">
                            <span class="nav-text">Listas</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <img class="nav-icon" src="./img/mensagem.png" alt="Mensagens">
                            <span class="nav-text">Mensagens</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                             <img class="nav-icon" src="./img/notificaçao.png" alt="Notificação">
                            <span class="nav-text">Notificações</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="perfil2" class="nav-link">
                            <img class="nav-icon" src="./img/perfil.png" alt="Perfil">
                            <span class="nav-text">Perfil</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="pesquisa" class="nav-link">
                            <img class="nav-icon" src="./img/pesquisa.png" alt="Pesquisa">
                            <span class="nav-text">Pesquisa</span>
                        </a>
                    </li>
                    <!-- ITEM ATIVO -->
                    <li class="nav-item active">
                        <a href="#" class="nav-link">
                            <img class="nav-icon" src="./img/configuracoes.png" alt="Configurações">
                            <span class="nav-text">Configurações</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <img class="nav-icon" src="./img/sair.png" alt="Sair">
                            <span class="nav-text">Sair</span>
                        </a>

                    </li>
                </ul>
            </nav>
        </aside>

        <!-- Conteúdo Principal -->
        <main class="main-content">
            <h1 class="page-title">Configuração</h1>

            <!-- Seção de Preferências -->
           <section class="settings-section">
    <h2 class="section-title">Preferências</h2>
    <div class="settings-card">
        <div class="setting-item">
            <div class="item-label">
                <ion-icon name="notifications-outline" class="item-icon"></ion-icon>
                <span>Notificações</span>
            </div>
        </div>
        <div class="setting-item">
            <div class="item-label">
                <ion-icon name="color-palette-outline" class="item-icon"></ion-icon>
                <span>Tema</span>
            </div>
            <div class="item-control">
                <span id="theme-name">Claro</span>
                <label class="switch">
                    <input type="checkbox" id="theme-toggle">
                    <span class="slider round"></span>
                </label>
            </div>
        </div>
    </div>
</section>

<!-- Seção da Conta -->
<section class="settings-section">
    <h2 class="section-title">Conta</h2>
    <div class="settings-card">
        <div class="setting-item">
            <div class="item-label">
                <ion-icon name="mail-outline" class="item-icon"></ion-icon>
                <span>Email</span>
            </div>
            <a href="#" id="btn-alterar-email" class="item-action">Alterar ></a>
        </div>
        <div class="setting-item">
            <div class="item-label">
                <ion-icon name="lock-closed-outline" class="item-icon"></ion-icon>
                <span>Senha</span>
            </div>
            <a href="#" id="btn-alterar-senha" class="item-action">Alterar ></a>
        </div>
        <div class="setting-item">
            <div class="item-label">
                <ion-icon name="key-outline" class="item-icon"></ion-icon>
                <span>Autenticação de 2 fatores</span>
            </div>
        </div>
        <div class="setting-item">
            <div class="item-label">
                <ion-icon name="log-out-outline" class="item-icon item-icon-danger"></ion-icon>
                <span>Sair</span>
            </div>
        </div>
        <div class="setting-item" id="btn-excluir-conta">
            <div class="item-label">
                <ion-icon name="trash-outline" class="item-icon item-icon-danger"></ion-icon>
                <span class="text-danger">Excluir conta</span>
            </div>
        </div>
    </div>
</section>

<!-- Seção Sobre -->
<section class="settings-section">
    <h2 class="section-title">Sobre</h2>
    <div class="settings-card">
        <div class="setting-item">
            <div class="item-label">
                <ion-icon name="shield-checkmark-outline" class="item-icon"></ion-icon>
                <span>Políticas de privacidade</span>
            </div>
        </div>
        <div class="setting-item">
            <div class="item-label">
                <ion-icon name="document-text-outline" class="item-icon"></ion-icon>
                <span>Termos e condições</span>
            </div>
        </div>
        <div class="setting-item">
            <div class="item-label">
                <ion-icon name="information-circle-outline" class="item-icon"></ion-icon>
                <span>Saiba mais</span>
            </div>
        </div>
    </div>
</section>
        </main>
    </div>

<div id="modal-email" class="modal-overlay" style="display: none;">
    <div class="modal-container">
        <div class="modal-header">
            <h2>Alterar Email</h2>
            <button class="modal-close-btn" data-close-modal="modal-email">&times;</button>
        </div>
        <div class="modal-body">
            <form id="form-alterar-email">
                <div class="form-group">
                    <label for="email-novo">Novo Endereço de Email</label>
                    <input type="email" id="email-novo" name="email" required>
                    <small id="error-email" class="error-message"></small>
                </div>
                <div class="form-group">
                    <label for="email-senha-atual">Confirme sua Senha Atual</label>
                    <input type="password" id="email-senha-atual" name="senha_atual" required>
                    <small id="error-email-senha-atual" class="error-message"></small>
                </div>
                <div id="form-email-feedback" class="form-feedback"></div>
                <button type="submit" class="btn-submit">Salvar Alterações</button>
            </form>
        </div>
    </div>
</div>

<!-- Modal para Alterar Senha -->
<div id="modal-senha" class="modal-overlay" style="display: none;">
    <div class="modal-container">
        <div class="modal-header">
            <h2>Alterar Senha</h2>
            <button class="modal-close-btn" data-close-modal="modal-senha">&times;</button>
        </div>
        <div class="modal-body">
            <form id="form-alterar-senha">
                <div class="form-group">
                    <label for="senha-atual">Senha Atual</label>
                    <input type="password" id="senha-atual" name="senha_atual" required>
                    <small id="error-senha-atual" class="error-message"></small>
                </div>
                <div class="form-group">
                    <label for="nova-senha">Nova Senha</label>
                    <input type="password" id="nova-senha" name="nova_senha" required>
                    <small>Mínimo 8 caracteres, com letras maiúsculas, minúsculas, números e símbolos.</small>
                    <small id="error-nova-senha" class="error-message"></small>
                </div>
                <div class="form-group">
                    <label for="nova-senha-confirmation">Confirme a Nova Senha</label>
                    <input type="password" id="nova-senha-confirmation" name="nova_senha_confirmation" required>
                </div>
                <div id="form-senha-feedback" class="form-feedback"></div>
                <button type="submit" class="btn-submit">Salvar Nova Senha</button>
            </form>
        </div>
    </div>
<div id="modal-excluir" class="modal-overlay" style="display: none;">
    <div class="modal-container">
        <div class="modal-header">
            <h2 class="text-danger">Excluir Conta Permanentemente</h2>
            <button class="modal-close-btn" data-close-modal="modal-excluir">&times;</button>
        </div>
        <div class="modal-body">
            <p><strong>Atenção!</strong> Esta ação é irreversível. Todos os seus dados, incluindo oportunidades e listas, serão apagados para sempre.</p>
            <p>Para confirmar, por favor, digite sua senha atual abaixo.</p>
            <form id="form-excluir-conta">
                <div class="form-group">
                    <label for="senha-confirmacao">Senha Atual</label>
                    <input type="password" id="senha-confirmacao" name="senha_confirmacao" required>
                    <small id="error-senha-confirmacao" class="error-message"></small>
                </div>
                <div id="form-excluir-feedback" class="form-feedback"></div>
                <button type="submit" class="btn-submit btn-danger">Eu entendo, excluir minha conta</button>
            </form>
        </div>
    </div>
</div>

</div>


<script>
        // Seleciona os elementos do DOM
        const themeToggle = document.getElementById('theme-toggle');
        const themeName = document.getElementById('theme-name');
        const body = document.body;

        // Função para aplicar o tema salvo
        const applyTheme = (theme) => {
            if (theme === 'dark') {
                body.classList.add('dark-theme');
                themeName.textContent = 'Escuro';
                themeToggle.checked = true;
            } else {
                body.classList.remove('dark-theme');
                themeName.textContent = 'Claro';
                themeToggle.checked = false;
            }
        };

        // Verifica se há um tema salvo no localStorage
        const savedTheme = localStorage.getItem('theme');
        
        // Aplica o tema salvo ao carregar a página
        // Se não houver tema salvo, o padrão será 'claro'
        applyTheme(savedTheme);

        // Adiciona o evento de clique ao toggle
        themeToggle.addEventListener('change', () => {
            let newTheme;
            // Se o toggle estiver marcado, o tema é 'escuro'
            if (themeToggle.checked) {
                newTheme = 'dark';
            } else {
                newTheme = 'claro';
            }
            
            // Aplica o novo tema
            applyTheme(newTheme);
            
            // Salva a preferência no localStorage
            localStorage.setItem('theme', newTheme);
        });
    </script>

    <script>
document.addEventListener('DOMContentLoaded', function() {
    // --- LÓGICA PARA ABRIR E FECHAR MODAIS ---
    const btnAlterarEmail = document.getElementById('btn-alterar-email');
    const btnAlterarSenha = document.getElementById('btn-alterar-senha');
    const btnExcluirConta = document.getElementById('btn-excluir-conta');

    const modalEmail = document.getElementById('modal-email');
    const modalSenha = document.getElementById('modal-senha');
    const modalExcluir = document.getElementById('modal-excluir');

    function openModal(modal) {
        if (modal) modal.style.display = 'flex';
    }

    function closeModal(modal) {
        if (modal) {
            modal.style.display = 'none';
            // Limpa formulários e mensagens de erro ao fechar
            const form = modal.querySelector('form');
            if (form) form.reset();
            modal.querySelectorAll('.error-message').forEach(el => el.textContent = '');
            modal.querySelector('.form-feedback').style.display = 'none';
        }
    }

    btnAlterarEmail.addEventListener('click', (e) => {
        e.preventDefault();
        openModal(modalEmail);
    });

    btnAlterarSenha.addEventListener('click', (e) => {
        e.preventDefault();
        openModal(modalSenha);
    });

    btnExcluirConta.addEventListener('click', (e) => {
        e.preventDefault();
        openModal(modalExcluir);
    });


    document.querySelectorAll('[data-close-modal]').forEach(btn => {
        btn.addEventListener('click', () => {
            const modal = document.getElementById(btn.dataset.closeModal);
            closeModal(modal);
        });
    });

    // Fecha o modal se clicar fora dele
    window.addEventListener('click', (e) => {
        if (e.target.classList.contains('modal-overlay')) {
            closeModal(e.target);
        }
    });

    // --- LÓGICA PARA SUBMETER OS FORMULÁRIOS ---
    const formEmail = document.getElementById('form-alterar-email');
    const formSenha = document.getElementById('form-alterar-senha');
    const formExcluir = document.getElementById('form-excluir-conta');

    // Função genérica para lidar com a submissão
    async function handleFormSubmit(form, url, feedbackElId) {
        const formData = new FormData(form);
        const data = Object.fromEntries(formData.entries());
        const feedbackEl = document.getElementById(feedbackElId);

        async function handleExcluirSubmit(form, url, feedbackElId) {
        const formData = new FormData(form);
        const data = Object.fromEntries(formData.entries());
        const feedbackEl = document.getElementById(feedbackElId);
        const submitButton = form.querySelector('button[type="submit"]');

        // Limpa erros antigos
        form.querySelectorAll('.error-message').forEach(el => el.textContent = '');
        feedbackEl.style.display = 'none';
        submitButton.disabled = true;
        submitButton.textContent = 'Excluindo...';

try {
            const response = await fetch(url, {
                method: 'DELETE', // MÉTODO DELETE
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify(data)
            });

            const result = await response.json();

            if (!response.ok) {
                if (response.status === 422 && result.errors) {
                    Object.keys(result.errors).forEach(key => {
                        document.getElementById(`error-${key.replace('_', '-')}`).textContent = result.errors[key][0];
                    });
                } else {
                    feedbackEl.textContent = result.message || 'Ocorreu um erro.';
                    feedbackEl.className = 'form-feedback error';
                }
                // Reabilita o botão em caso de erro
                submitButton.disabled = false;
                submitButton.textContent = 'Eu entendo, excluir minha conta';
            } else {
                // Sucesso! Redireciona o usuário
                feedbackEl.textContent = result.message;
                feedbackEl.className = 'form-feedback success';
                // Redireciona para a página inicial após 2 segundos
                setTimeout(() => {
                    window.location.href = result.redirect_url;
                }, 2000);
            }
        } catch (error) {
            feedbackEl.textContent = 'Falha na comunicação com o servidor.';
            feedbackEl.className = 'form-feedback error';
            submitButton.disabled = false;
            submitButton.textContent = 'Eu entendo, excluir minha conta';
        }
    }

        try {
            const response = await fetch(url, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}', // Essencial para Laravel
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify(data)
            });

            const result = await response.json();

            if (!response.ok) {
                // Erros de validação (422)
                if (response.status === 422 && result.errors) {
                    Object.keys(result.errors).forEach(key => {
                        const errorEl = form.querySelector(`#error-${key.replace('_', '-')}`);
                        if (errorEl) {
                            errorEl.textContent = result.errors[key][0];
                        }
                    });
                } else {
                    // Outros erros
                    feedbackEl.textContent = result.message || 'Ocorreu um erro.';
                    feedbackEl.className = 'form-feedback error';
                }
            } else {
                // Sucesso
                feedbackEl.textContent = result.message;
                feedbackEl.className = 'form-feedback success';
                form.reset(); // Limpa o formulário
                // Fecha o modal após 3 segundos
                setTimeout(() => closeModal(form.closest('.modal-overlay')), 3000);
            }
        } catch (error) {
            feedbackEl.textContent = 'Falha na comunicação com o servidor.';
            feedbackEl.className = 'form-feedback error';
        }
    }

    formEmail.addEventListener('submit', (e) => {
        e.preventDefault();
        handleFormSubmit(formEmail, '{{ route("conta.update.email") }}', 'form-email-feedback');
    });

    formSenha.addEventListener('submit', (e) => {
        e.preventDefault();
        handleFormSubmit(formSenha, '{{ route("conta.update.password") }}', 'form-senha-feedback');
    });
     formExcluir.addEventListener('submit', (e) => {
        e.preventDefault();
        handleExcluirSubmit(formExcluir, '{{ route("conta.delete") }}', 'form-excluir-feedback');
    });
});
</script>

</body>
</html>
