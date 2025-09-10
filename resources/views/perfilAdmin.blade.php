<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil do Admin</title>
</head>
<body>
    <h1>Perfil do Admin</h1>

    <div id="adminInfo">
        <!-- Informações do admin serão carregadas aqui -->
    </div>

    <button id="logoutBtn">Logout</button>

    <script>
        const adminInfoDiv = document.getElementById('adminInfo');
        const logoutBtn = document.getElementById('logoutBtn');

        // Pega o token do localStorage
        const token = localStorage.getItem('token');

        if (!token) {
            // Se não tiver token, redireciona para login
            window.location.href = '/login';
        } else {
            // Busca as informações do admin
            fetch('/api/admin/perfil', {
                method: 'GET',
                headers: {
                    'Authorization': 'Bearer ' + token,
                    'Accept': 'application/json'
                }
            })
            .then(response => {
                if (!response.ok) throw new Error('Token inválido ou expirado');
                return response.json();
            })
            .then(data => {
                // Mostra as informações do admin
                adminInfoDiv.innerHTML = `
                    <p><strong>ID:</strong> ${data.id}</p>
                    <p><strong>Email:</strong> ${data.email}</p>
                `;
            })
            .catch(err => {
                console.error(err);
                alert('Erro ao carregar perfil. Faça login novamente.');
                localStorage.removeItem('token');
                window.location.href = '/login';
            });
        }

        // Logout
        logoutBtn.addEventListener('click', () => {
            fetch('/api/admin/logout', {
                method: 'POST',
                headers: {
                    'Authorization': 'Bearer ' + token,
                    'Accept': 'application/json'
                }
            })
            .finally(() => {
                localStorage.removeItem('token');
                window.location.href = '/login';
            });
        });
    </script>
</body>
</html>
