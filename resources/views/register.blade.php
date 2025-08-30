<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuário</title>
</head>
<body>
    <h1>Registro de Usuário</h1>

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
    <input type="number" name="alturaCm" placeholder="Altura (cm)">
    <input type="number" name="pesoKg" placeholder="Peso (kg)">
    <select name="peDominante">
        <option value="">Escolha o pé dominante</option>
        <option value="direito">Direito</option>
        <option value="esquerdo">Esquerdo</option>
    </select>
    <select name="maoDominante">
        <option value="">Escolha a mão dominante</option>
        <option value="direita">Direita</option>
        <option value="esquerda">Esquerda</option>
    </select>
    <button type="submit">Registrar</button>
</form>

    <div id="result"></div>

    <script>
        const form = document.getElementById('registerForm');
        const resultDiv = document.getElementById('result');

        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            const formData = new FormData(form);
            const data = Object.fromEntries(formData.entries());

            try {
                const response = await fetch('http://localhost:8000/api/registro', {
                    method: 'POST',
                    headers: {'Content-Type':'application/json'},
                    body: JSON.stringify(data)
                });

                const result = await response.json();

                if(response.ok){
                    resultDiv.innerHTML = `<p style="color:green;">${result.message}</p>`;
                    form.reset();
                    setTimeout(() => window.location.href = '/login', 1500);
                } else {
                    let errors = '';
                    if(result.errors){
                        errors = Object.values(result.errors).flat().join('<br>');
                    } else {
                        errors = result.message || 'Erro ao registrar';
                    }
                    resultDiv.innerHTML = `<p style="color:red;">${errors}</p>`;
                }
            } catch (error) {
                resultDiv.innerHTML = `<p style="color:red;">Erro na requisição: ${error}</p>`;
            }
        });
    </script>
</body>
</html>
