<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <h1>Login</h1>

    <form id="loginForm">
        <input type="email" name="emailUsuario" placeholder="Email" required>
        <input type="password" name="senhaUsuario" placeholder="Senha" required>
        <button type="submit">Entrar</button>
    </form>

    <div id="result"></div>

    <script>
        const form = document.getElementById('loginForm');
        const resultDiv = document.getElementById('result');

        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            const formData = new FormData(form);
            const data = Object.fromEntries(formData.entries());

            try {
                const response = await fetch('http://localhost:8000/api/login', {
                    method: 'POST',
                    headers: {'Content-Type':'application/json'},
                    body: JSON.stringify(data)
                });

                const result = await response.json();

                if(response.ok){
                    localStorage.setItem('token', result.access_token);
                    resultDiv.innerHTML = '<p style="color:green;">Login realizado! Redirecionando...</p>';
                    window.location.href = '/perfil';
                } else {
                    resultDiv.innerHTML = `<p style="color:red;">${result.message}</p>`;
                }
            } catch (error) {
                resultDiv.innerHTML = `<p style="color:red;">Erro na requisição: ${error}</p>`;
            }
        });
    </script>
</body>
</html>
