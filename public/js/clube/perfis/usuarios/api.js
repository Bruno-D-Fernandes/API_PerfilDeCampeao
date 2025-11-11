async function saveNovaLista() {
    try {
        const url = "../api/clube/listas"; 

        const formData = new FormData(document.querySelector('#criar-lista-form'));

        const response = await fetch(url, {
            method: 'POST',
            headers: {
                'Authorization': BEARER,
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: formData
        });

        if (!response.ok) {
            const errorData = await response.json();
            throw new Error(errorData.message || `HTTP error! status: ${response.status}`);
        }

        const data = await response.json();

        if(!data.error || !data.errors) {
            alert('Lista criada com sucesso!');
            
            const novaLinha = createListaRow(data.data);
            listasContainer.prepend(novaLinha);
            
            await fetchListasDoClube();

            fecharModal(modalCriarLista);

            abrirModal(modalListas);
        }
    } catch (error) {
        console.error('Erro ao salvar nova lista:', error);
        alert('Erro ao salvar nova lista: ' + error.message);
    }
}

async function fetchListasDoClube() {
    listasContainer.querySelectorAll('.lista-item').forEach(item => item.remove());
    
    try {
        const url = `../api/clube/listas`; 

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

        const listas = await response.json(); 

        if (listas && listas.length > 0) {
            listas.forEach(lista => {
                const linha = createListaRow(lista);
                listasContainer.prepend(linha);
            });
        } else {
            const p = document.createElement('p');

            p.textContent = 'Nenhuma lista encontrada.';
            p.className = 'lista-item';

            listasContainer.prepend(p);
        }

    } catch (error) {
        console.error('Erro ao buscar listas:', error);

        const p = document.createElement('p');
        p.textContent = 'Não foi possível carregar as listas.';
        p.style.color = 'red';
        p.className = 'lista-item';

        listasContainer.prepend(p);
    }
}

async function toggleUsuarioNaLista(listaId, adicionar = true) {
    try {
        const url = `../api/clube/listas/${listaId}/usuarios/${usuarioId}`; 

        const response = await fetch(url, {
            method: adicionar ? 'POST' : 'DELETE', 
            headers: {
                'Authorization': BEARER,
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            }
        });

        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }

        const data = await response.json();
        
        alert(data.message || (adicionar ? 'Usuário adicionado!' : 'Usuário removido!'));

    } catch (error) {
        console.error(`Erro ao ${adicionar ? 'adicionar' : 'remover'} usuário da lista:`, error);
        alert('Ocorreu um erro.');
        
        const checkbox = document.querySelector(`#lista-${listaId}`);
        if (checkbox) checkbox.checked = !adicionar;
    }
}