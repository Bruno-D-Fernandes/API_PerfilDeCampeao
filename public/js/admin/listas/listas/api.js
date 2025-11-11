async function fetchListaDetails(listaId) {
    try {
        const url = `../api/admin/listas/${listaId}`; 

        const response = await fetch(url, {
            headers: {
                'Authorization': BEARER,
                'X-CSRF-TOKEN': csrfToken,
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            }
        });

        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }

        const data = await response.json(); 
        
        listaModalTitle.textContent = `Detalhes: ${data.nome}`;
        spanModalListaNome.textContent = data.nome;
        spanModalListaClube.textContent = `Criada por: ${data.clube.nomeClube}`;
        spanModalListaDescricao.textContent = `Descrição: ${data.descricao}`;
        spanModalListaUserCount.textContent = `Usuários: (${data.usuarios.length})`;

        usersListContainer.innerHTML = '';
        if (data.usuarios && data.usuarios.length > 0) {
            data.usuarios.forEach(usuario => {
                const userHTML = document.createElement('span');
                userHTML.textContent = usuario.nomeCompletoUsuario;
                usersListContainer.appendChild(userHTML);
            });
        } else {
            usersListContainer.innerHTML = '<p>Nenhum usuário nesta lista.</p>';
        }

    } catch (error) {
        console.error('Erro ao buscar detalhes da lista:', error);
        listaModalTitle.textContent = "Erro ao carregar lista";
    }
}

async function deleteLista(listaId) {
    try {
        const url = `../api/admin/listas/${listaId}`;

        const response = await fetch(url, {
            method: 'DELETE',
            headers: {
                'Authorization': BEARER,
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
        });

        if (response.ok) {
            if (response.status === 204) {
                alert('Lista excluída com sucesso!');

                const row = listasContainer.querySelector(`.lista[data-lista-id="${listaId}"]`);

                row.remove();
            } else {
                const data = await response.json();

                if (data.error || data.errors) {
                    console.error('Erro retornado pela API:', data);
                    alert('Erro ao excluir lista');
                } else {
                    alert('Lista excluída com sucesso! (Obteve retorno de dados)');

                    const row = listasContainer.querySelector(`.lista[data-lista-id="${listaId}"]`);
                    
                    row.remove();
                }
            }
        } else {
            console.error('Erro HTTP:', response.status, response.statusText);

            try {
                const errorData = await response.json();
                alert(`Erro ao excluir lista: ${errorData.message || response.statusText}`);
            } catch (jsonError) {
                alert(`Erro ao excluir lista: ${response.statusText}`);
            }
        }          
    } catch (error) {
        console.error('Erro ao excluir lista:', error);
        alert('Erro ao excluir lista!');
    }
}