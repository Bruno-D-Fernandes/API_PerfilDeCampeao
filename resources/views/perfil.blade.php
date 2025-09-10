<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil</title>
</head>
<body>
    <h1>Perfil do Usuário</h1>

    <div id="userData">Carregando dados...</div>
    <button type="button" id="logoutBtn">Sair</button>

    <script>
        const token = localStorage.getItem('token');
        const userDiv = document.getElementById('userData');
        const logoutBtn = document.getElementById('logoutBtn');

        if(!token){
            window.location.href = '/login';
        } else {
            fetch('/api/clube/perfil', {
                headers: { 'Authorization': 'Bearer ' + token }
            })
            .then(res => res.json())
            .then(user => {
                userDiv.innerHTML = `
                    <p>Nome: ${user.nomeClube}</p>
                    <p>Cidade: ${user.cidadeClube}</p>
                    <p>Estado: ${user.estadoClube}</p>
                    <p>Ano de Criação: ${user.anoCriacaoClube}</p>
                    <p>CNPJ: ${user.cnpjClube}</p>
                    <p>Endereço: ${user.enderecoClube}</p>
                    <p>Bio: ${user.bioClube || 'Sem bio'}</p>

                `;
            })
            .catch(err => {
                console.log(err);
                localStorage.removeItem('token');
                window.location.href = '/login';
            });
        }

        logoutBtn.addEventListener('click', () => {
            fetch('/api/logout', {
                method: 'POST',
                headers: {
                    'Authorization': 'Bearer ' + token,
                    'Content-Type': 'application/json'
                }
            }).then(() => {
                localStorage.removeItem('token');
                window.location.href = '/login';
            });
        });
    </script>
</body>
</html>
