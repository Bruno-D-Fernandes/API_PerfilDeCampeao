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
        <input type="text" name="nomeCompletoUsuario" placeholder="Nome completo" required>
        <input type="text" name="nomeUsuario" placeholder="Nome de usuário" required>
        <input type="email" name="emailUsuario" placeholder="Email" required>
        <input type="password" name="senhaUsuario" placeholder="Senha" required>
        <input type="text" name="nacionalidadeUsuario" placeholder="Nacionalidade">
        <input type="date" name="dataNascimentoUsuario" placeholder="Data de nascimento" required>
        <input type="date" name="dataCadastroUsuario" placeholder="Data de cadastro">
        <input type="text" name="fotoPerfilUsuario" placeholder="URL da foto de perfil">
        <input type="text" name="fotoBannerUsuario" placeholder="URL do banner">
        <textarea name="bioUsuario" placeholder="Bio do usuário"></textarea>
        <input type="number" name="alturaCmUsuario" placeholder="Altura (cm)">
        <input type="number" name="pesoKgUsuario" placeholder="Peso (kg)">
        <select name="peDominanteUsuario">
            <option value="">Escolha o pé dominante</option>
            <option value="direito">Direito</option>
            <option value="esquerdo">Esquerdo</option>
        </select>
        <select name="maoDominanteUsuario">
            <option value="">Escolha a mão dominante</option>
            <option value="direita">Direita</option>
            <option value="esquerda">Esquerda</option>
        </select>

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
                const response = await fetch('/api/registro', {
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
