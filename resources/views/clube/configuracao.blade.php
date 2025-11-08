{{-- resources/views/clube/configuracoes.blade.php --}}
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <title>Configurações — Clube</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>

<header>
    <h1>Configuração</h1>
</header>

<main aria-labelledby="page-title">

    {{-- ===========================
         PREFERÊNCIAS
    ============================ --}}
    <section aria-labelledby="prefs-title">
        <h2 id="prefs-title">Preferências</h2>

        <article aria-labelledby="notif-title">
            <div>
                <h3 id="notif-title">Notificações</h3>
            </div>
            <p class="muted">Gerenciar alertas por e-mail e sistema.</p>
            <a href="{{ url('/clube/configuracoes/notificacoes') }}" aria-label="Abrir configurações de notificações">Gerenciar</a>
        </article>

        <article aria-labelledby="theme-title">
            <div>
                <h3 id="theme-title">Tema</h3>
            </div>
            <form method="post" action="{{ url('/clube/configuracoes/tema') }}">
                @csrf
                @method('PUT')

                <fieldset>
                    <legend class="sr-only">Escolha o tema</legend>

                    @php($theme = $theme ?? 'system')

                    <label>
                        <input type="radio" name="theme" value="system" {{ $theme === 'system' ? 'checked' : '' }}>
                        Sistema
                    </label>

                    <label>
                        <input type="radio" name="theme" value="light" {{ $theme === 'light' ? 'checked' : '' }}>
                        Claro
                    </label>

                    <label>
                        <input type="radio" name="theme" value="dark" {{ $theme === 'dark' ? 'checked' : '' }}>
                        Escuro
                    </label>
                </fieldset>

                <button type="submit">Salvar tema</button>
            </form>
        </article>
    </section>

    {{-- ===========================
         CONTA
    ============================ --}}
    <section aria-labelledby="account-title">
        <h2 id="account-title">Conta</h2>

        <article>
            <div>
                <h3>Email</h3>
            </div>
            <p class="muted">Alterar e-mail de acesso.</p>
            <a href="{{ url('/clube/configuracoes/email') }}">Alterar</a>
        </article>

        <article>
            <div>
                <h3>Senha</h3>
            </div>
            <p class="muted">Definir uma nova senha.</p>
            <a href="{{ url('/clube/configuracoes/senha') }}">Alterar</a>
        </article>

        <article>
            <div>
                <h3>Autentificação de 2 fatores</h3>
            </div>
            <p class="muted">Aumente a segurança da sua conta.</p>
            <a href="{{ url('/clube/configuracoes/2fa') }}">Configurar</a>
        </article>

        <article>
            <div>
                <h3>Sair</h3>
            </div>
            <p class="muted">Encerrar sessão atual.</p>
            <form method="post" action="{{ url('/clube/logout') }}">
                @csrf
                <button type="submit">Sair</button>
            </form>
        </article>

        <article>
            <div>
                <h3>Excluir conta</h3>
            </div>
            <p class="muted">Remover permanentemente sua conta e dados.</p>
            <form method="post" action="{{ url('/clube/configuracoes/excluir-conta') }}">
                @csrf
                @method('DELETE')
                <button type="submit">Excluir conta</button>
            </form>
        </article>
    </section>

    {{-- ===========================
         SOBRE
    ============================ --}}
    <section aria-labelledby="about-title">
        <h2 id="about-title">Sobre</h2>

        <article>
            <div>
                <h3>Políticas de privacidade</h3>
            </div>
            <a href="{{ url('/politica-de-privacidade') }}">Abrir</a>
        </article>

        <article>
            <div>
                <h3>Termos e condições</h3>
            </div>
            <a href="{{ url('/termos-e-condicoes') }}">Abrir</a>
        </article>

        <article>
            <div>
                <h3>Saiba mais</h3>
            </div>
            <a href="{{ url('/sobre') }}">Abrir</a>
        </article>
    </section>

</main>

</body>
</html>
