async function fetchFuncaoDetails(funcaoId) {
    try {
        const response = await fetch(`../api/admin/funcao/${funcaoId}`, {
            headers: {
                'Authorization': `Bearer ${BEARER}`,
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
                'Authorization': `Bearer ${BEARER}`,
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: formData
        });

        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }

        const data = await response.json();

        if(!data.error || !data.errors) {
            alert('Função salva com sucesso!');
            window.location.reload(true);

            if (!editMode) {
                funcoes.appendChild(createFuncaoRow(data));
            } else {
                const oldRow = funcoes.querySelector(`.funcao[data-funcao-id="${funcaoId}"]`);
                const newRow = createFuncaoRow(data);
                funcoes.replaceChild(newRow, oldRow);
            }
            
            fecharModal(modalFuncao);
        }                
    } catch (error) {
        console.error('Erro ao salvar função:', error);
        alert('Erro ao salvar função!');
    }
}

async function deleteFuncao(funcaoId) {
    try {
        const url = "../api/admin/funcao/" + funcaoId;

        const response = await fetch(url, {
            method: 'DELETE',
            headers: {
                'Authorization': `Bearer ${BEARER}`,
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
        });

        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }

        const data = await response.json();

        if(!data.error && !data.errors) {
            alert('Função excluída com sucesso!');
            funcoes.querySelector(`.funcao[data-funcao-id="${funcaoId}"]`)?.remove();
            funcaoId = -1;
        }                
    } catch (error) {
        console.error('Erro ao excluir função:', error);
        alert('Erro ao excluir função!');
    }
}