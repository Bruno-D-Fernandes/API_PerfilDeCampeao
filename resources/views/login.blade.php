<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/login.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login</title>

    <style>
        body, html {
    width: 100%;
    height: 100vh;
    font-family: 'Inter', 'Poppins', sans-serif;
    background-image: url("{{ asset('img/fundo.png') }}");
    background-size: cover;
    background-position: center;
    background-attachment: fixed;
    display: flex;
    align-items: center;
    justify-content: center;

}
    </style>
</head>
<body>


    <div class="main-container">
        <!-- Seção do Texto -->
        <div class="text-section">
            <h1>
                Se você acredita,<br> 
                <span class="highlight">o mundo</span> também<br>
                vai acreditar.
            </h1>
        </div>

        <!-- Seção do Formulário -->
         <div class="form-section">
         <form id="loginForm">
            <div class="login-form">
                <form id="loginForm">
                    <!-- Campo de E-mail -->
                    <div class="input-group">
                        <label for="email">E-mail</label>
                        
                        <input 
                            type="text" 
                            id="email" 
                            name="cnpjClube"
                            placeholder="Cnpj"
                            required
                        >
                        <div class="error-message" id="emailError"></div>
                    </div>

                    <!-- Campo de Senha -->
                    <div class="input-group">
                        <label for="password">Senha</label>
                        <input 
                            type="password" 
                            id="password" 
                            name="senhaClube"
                            required
                        >
                        <div class="error-message" id="passwordError"></div>
                    </div>

                    <!-- Link "Esqueceu a senha?" -->
                    <a href="#" class="forgot-password">Esqueceu sua senha?</a>

                    <!-- Botão de Envio -->
                    <button type="submit" id="submitButton" class="submit-button">
                        Entrar
                    </button>
                    
                    <!-- Link "Ainda não tem cadastro?" -->
                    <a href="/cadastro/clube/passo-1" class="signup-link">
                        Ainda não tem cadastro?
                    </a>
                </form>
            </div>
        </div>
    </div>


    </form>

                                    <!-- javascript ta explicado ai, caso queiram que eu explique mais me manda msg
                                         ass: Luan
                                          -->

    <script>
    
    document.addEventListener('DOMContentLoaded', function() {

    const loginForm = document.getElementById('loginForm');

        loginForm.addEventListener('submit', async function(e) {
                    
            e.preventDefault(); // Evita o envio padrão do formulário

            // Captura os dados do formulário
            const formData = new FormData(loginForm);
            const data = Object.fromEntries(formData.entries());

            try {
                const response = await fetch('http://127.0.0.1:8000/api/clube/login', {
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
                    console.log('Login bem-sucedido!', result)
                        // Salva o token no localStorage
                        localStorage.setItem('token', result.access_token);
                        // Redireciona para o perfil
                        window.location.href = '/perfil';
                    } else {
                        alert('Erro no login: ' + result.message);
                    }

                } catch(error){
                    console.error('Erro de rede:', error);
                }
            });
        });
    </script>
</body>
</html>
