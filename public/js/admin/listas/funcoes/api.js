async function fetchFuncaoDetails(funcaoId) {
    try {
        const response = await fetch(`../api/admin/funcao/${funcaoId}`, {
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

        console.log(data);
        
        funcaoModalTitle.textContent = `Detalhes da Função: ${data.nome}`;

        modalFuncao.inputs[0].value = data.nome;
        modalFuncao.inputs[1].value = data.descricao;
    } catch (error) {
        console.error('Erro ao buscar detalhes da função:', error);
        funcaoModalTitle.textContent = "Erro ao carregar função";
    }
}

async function saveFuncao(funcaoId = null) {
    const editMode = funcaoId !== null;

    try {
        const url = editMode ? '../api/admin/funcao/' + funcaoId : "../api/admin/funcao/";

        const formData = new FormData(document.querySelector('#funcao-form'));

        

        if (editMode) {
            formData.append('_method', 'PUT');
        }

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
            throw new Error(`HTTP error! status: ${response.status}`);
        }

        const data = await response.json();

         const addModal = document.getElementById('addModal');
        const editModal = document.getElementById('editModal');
        

        if (!data.error && !data.errors) {
            fecharModal(modalFuncao);

            if (editMode) {
                // Mostra modal de edição
                editModal.style.display = 'flex';
                setTimeout(() => {
                    editModal.style.display = 'none';
                    window.location.reload(true);
                }, 2000);
            } else {
                // Mostra modal de adição
                addModal.style.display = 'flex';
                setTimeout(() => {
                    addModal.style.display = 'none';
                    window.location.reload(true);
                }, 2000);
            }

            if (!editMode) {
                funcoes.appendChild(createFuncaoRow(data));
                 window.FontAwesome?.dom?.i2svg(); // AQUI
            } else {
                const oldRow = funcoes.querySelector(`.funcao[data-funcao-id="${funcaoId}"]`);
                const newRow = createFuncaoRow(data);
                funcoes.replaceChild(newRow, oldRow);
            }

            fecharModal(modalFuncao);
        }          
    } catch (error) {
        const erroModal = document.getElementById('erroModal');
        console.error('Erro ao salvar função:', error);
    erroModal.style.display = 'flex';
                setTimeout(() => {
                    erroModal.style.display = 'none';
                }, 1000);
        

    }
}

async function deleteFuncao(funcaoId) {
    try {
        const url = "../api/admin/funcao/" + funcaoId;

        const response = await fetch(url, {
            method: 'DELETE',
            headers: {
                'Authorization': BEARER,
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
        });

        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }

        const data = await response.json();

        if(!data.error && !data.errors) {

            funcoes.querySelector(`.funcao[data-funcao-id="${funcaoId}"]`)?.remove();
            funcaoId = -1;
        }                
    } catch (error) {
        console.error('Erro ao excluir função:', error);
/*         alert('Erro ao excluir função!'); */
    }
}