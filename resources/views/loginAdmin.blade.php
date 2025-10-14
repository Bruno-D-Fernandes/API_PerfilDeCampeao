<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login Admin</title>
</head>
<body>
    <h1>Login Admin</h1>

    <form id="loginForm">
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Senha" required>
        <button type="submit">Entrar</button>
    </form>

                                    <!-- javascript ta explicado ai, caso queiram que eu explique mais me manda msg
                                         ass: Luan
                                          -->

    <script>
        const loginForm = document.getElementById('loginForm');

        loginForm.addEventListener('submit', async function(e) {
            e.preventDefault(); // Evita o envio padrão do formulário

            // Captura os dados do formulário
            const formData = new FormData(loginForm);
            const data = Object.fromEntries(formData.entries());

            try {
                const response = await fetch('/api/admin/login', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]' ).getAttribute('content')
                    },
                    body: JSON.stringify(data)
                });

                const result = await response.json();

                if(response.ok){
                        // Salva o token no localStorage
                        localStorage.setItem('admin_auth_token', result.access_token);
                        // Redireciona para o perfil
                        window.location.href = '/esporte';
                    } else {
                        alert('Erro no login: ' + JSON.stringify(result));
                    }

                } catch(error){
                    console.error('Erro de rede:', error);
                }
            });
    </script>
</body>
</html>
