<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuário</title>
</head>
<body>
    <h1>Registro de Usuário</h1>

                                         <!-- trabalhem front-ends -->


    <form id="registerForm">
        <input type="text" name="nomeClube" placeholder="Nome do clube" required>
        <input type="text" name="cidadeClube" placeholder="Cidade do clube" required>
        <input type="text" name="estadoClube" placeholder="Estado do clube" required>
        <input type="date" name="anoCriacaoClube" placeholder="Ano de criação" required>
        <input type="cnpj" name="cnpjClube" placeholder="CNPJ" required>
        <input type="text" name="enderecoClube" placeholder="Endereço" required>
        <input type="text" name="bioClube" placeholder="Bio do clube" required>
        <input type="password" name="senhaClube" placeholder="Senha do clube" required>
        <input type="password" name="senhaClube_confirmation" placeholder="Confirmação da senha" required>

        <button type="submit">Registrar</button>
    </form>
                                        <!-- javascript ta explicado ai, caso queiram que eu explique mais me manda msg
                                         ass: Luan
                                          -->
    <script>
        const form = document.getElementById('registerForm');

        form.addEventListener('submit', async function(e) {
            e.preventDefault(); // Evita o envio padrão do formulário

            // Captura os dados do formulário
            const formData = new FormData(form);
            const data = Object.fromEntries(formData.entries()); // Converte para objeto JS

            try {
                const response = await fetch('/api/clube/register', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json', // Indica que é JSON
                        'Accept': 'application/json'
                        // CSRF não é necessário em rotas API do Sanctum
                    },
                    body: JSON.stringify(data) // Converte o objeto para JSON
                });

                const result = await response.json();

                if(response.ok){
            alert('Registro realizado com sucesso!');
            // Redireciona para login
            window.location.href = '/login';
        } else {
            alert('Erro no registro: ' + JSON.stringify(result));
        }
    } catch(error){
        console.error('Erro de rede:', error);
    }
});
    </script>
</body>
</html>
