<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Clube</title>
</head>

<body>
    <h1>Login do Clube</h1>

    <form id="loginForm">
        <input type="text" name="cnpjClube" placeholder="CNPJ" required>
        <input type="password" name="senhaClube" placeholder="Senha" required>
        <button type="submit">Entrar</button>
    </form>

    <p id="message" style="color: red;"></p>

    <script>
        const loginForm = document.getElementById('loginForm');
        const messageElement = document.getElementById('message');

        loginForm.addEventListener('submit', async function(e) {
            e.preventDefault(); 
            messageElement.textContent = ''; // Limpa mensagens anteriores

            // Captura os dados do formulário
            const formData = new FormData(loginForm);
            const data = Object.fromEntries(formData.entries());

            try {
                // Requisição para o endpoint de login do Laravel
                const response = await fetch('/api/clube/login', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(data)
                });

                const result = await response.json();

                if (response.ok) {
                    // Verifica se o token está na resposta
                    if (result.access_token) {
                        // 🔑 Salva o token no localStorage
                        localStorage.setItem('token', result.access_token);
                        messageElement.textContent = 'Login bem-sucedido! Redirecionando...';
                        console.log('Token recebido:', result.access_token);
                        
                        // Redireciona para o perfil ou dashboard do clube
                        window.location.href = '/perfil-clube'; // Altere para a sua rota real
                    } else {
                        messageElement.textContent = 'Login bem-sucedido, mas token não foi retornado. Verifique a API.';
                    }
                } else {
                    // Trata erros de validação (422) ou credenciais inválidas (401)
                    let errorMessage = 'Erro desconhecido ao logar.';
                    if (result.message) {
                        errorMessage = result.message;
                    } else if (result.errors) {
                        // Exibe os erros de validação da API
                        errorMessage = Object.values(result.errors).flat().join(' | ');
                    }
                    messageElement.textContent = 'Erro no login: ' + errorMessage;
                    console.error('Resposta da API:', result);
                }

            } catch(error) {
                console.error('Erro de rede ou fetch:', error);
                messageElement.textContent = 'Erro de conexão. Verifique se o servidor está rodando.';
            }
        });
    </script>
</body>

</html>