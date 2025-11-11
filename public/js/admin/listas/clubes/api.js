async function fetchClubeDetails(clubeId) {
    try {
        const response = await fetch(`../api/clube/${clubeId}`, {
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
        
        clubeModalTitle.textContent = `Detalhes do Clube: ${data.nomeClube}`;

        if (data.fotoPerfilClube) {
            previewImagem.src = storageUrl + "/" + data.fotoPerfilClube;
            previewImagem.style.display = 'block';
        } 

        if (data.fotoBannerClube) {
            previewImagemBanner.src = storageUrl + "/" + data.fotoBannerClube;
            previewImagemBanner.style.display = 'block';
        }

        modalClube.inputs[0].value = data.nomeClube;
        modalClube.inputs[1].value = data.emailClube;
        modalClube.inputs[2].value = data.cnpjClube;
        modalClube.inputs[3].value = data.anoCriacaoClube;
        modalClube.inputs[4].value = data.enderecoClube;
        modalClube.inputs[5].value = data.cidadeClube;
        modalClube.inputs[6].value = data.estadoClube;
        modalClube.inputs[7].value = data.bioClube;
        modalClube.inputs[8].value = data.categoria.id;
        modalClube.inputs[9].value = data.esporte.id;
    } catch (error) {
        console.error('Erro ao buscar detalhes do clube:', error);
        clubeModalTitle.textContent = "Erro ao carregar clube";
    }
}

async function saveClube(clubeId = null) {
    const editMode = clubeId !== null;

    try {
        const url = editMode ? '../api/clube/' + clubeId : "../api/admin/clube/";

        const formData = new FormData(document.querySelector('#clube-form'));

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

        if(!data.error || !data.errors) {
            alert('Clube salvo com sucesso!');
            window.location.reload(true);

            if (!editMode) {
                clubes.appendChild(createClubeRow(data));
            } else {
                const oldRow = clubes.querySelector(`.clube[data-clube-id="${clubeId}"]`);
                const newRow = createClubeRow(data);
                clubes.replaceChild(newRow, oldRow);
            }
            
            fecharModal(modalClube);
        }                
    } catch (error) {
        console.error('Erro ao salvar clube:', error);
        alert('Erro ao salvar clube!');
    }
}

async function deleteClube(clubeId) {
    try {
        const url = "../api/clube/" + clubeId;

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
                alert('Clube excluído com sucesso!');
                clubes.querySelector(`.clube[data-clube-id="${clubeId}"]`)?.remove();
            } else {
                const data = await response.json();

                if (data.error || data.errors) {
                    console.error('Erro retornado pela API:', data);
                    alert('Erro ao excluir clube');
                } else {
                    alert('Clube excluído com sucesso! (Obteve retorno de dados)');
                    clubes.querySelector(`.clube[data-clube-id="${clubeId}"]`)?.remove();
                }
            }
        } else {
            console.error('Erro HTTP:', response.status, response.statusText);

            try {
                const errorData = await response.json();
                alert(`Erro ao excluir clube: ${errorData.message || response.statusText}`);
            } catch (jsonError) {
                alert(`Erro ao excluir clube: ${response.statusText}`);
            }
        }          
    } catch (error) {
        console.error('Erro ao excluir clube:', error);
        alert('Erro ao excluir clube!');
    }
}

searchUsers('');