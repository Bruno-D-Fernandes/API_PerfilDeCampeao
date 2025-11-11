async function fetchCaracteristicaDetails(caracteristicaId) {
    try {
        const response = await fetch(`../api/admin/caracteristica/${caracteristicaId}`, {
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
        
        caracteristicaModalTitle.textContent = `Detalhes da Característica: ${data.caracteristica}`;

        document.querySelector('#caracteristica-form-caracteristica').value = data.caracteristica;
        document.querySelector('#caracteristica-form-unidade').value = data.unidade_medida;
    } catch (error) {
        console.error('Erro ao buscar detalhes da característica:', error);
        caracteristicaModalTitle.textContent = "Erro ao carregar característica";
    }
}

async function fetchPosicaoDetails(posicaoId) {
    try {
        const response = await fetch(`../api/admin/posicao/${posicaoId}`, {
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
        
        posicaoModalTitle.textContent = `Detalhes da Posição: ${data.nomePosicao}`;

        document.querySelector('#posicao-form-nome').value = data.nomePosicao;
    } catch (error) {
        console.error('Erro ao buscar detalhes da posição:', error);
        posicaoModalTitle.textContent = "Erro ao carregar posição";
    }
}

async function fetchEsporteDetails(esporteId) {
    try {
        const response = await fetch(`../api/admin/esporte/${esporteId}`, {
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
        
        esporteModalTitle.textContent = `Detalhes do Esporte: ${data.nomeEsporte}`;

        modalEsporte.inputs[0].value = data.nomeEsporte;
        modalEsporte.inputs[1].value = data.descricaoEsporte;

        posicoesListContainer.innerHTML = `
            <div class="posicoes-list-header">
                <div class="posicoes-header-col"><span>Nome</span></div>
                <div class="posicoes-header-col"><span>Data de cadastro</span></div>
                <div class="posicoes-header-col"><span>Ações</span></div>
            </div>
        `;

        if (data.posicoes && data.posicoes.length > 0) {
            data.posicoes.forEach(posicao => {
                posicoesListContainer.innerHTML += `
                    <div class="posicoes-list-row" data-posicao-id="${posicao.id}">
                        <div class="posicao-col nome"><span>${posicao.nomePosicao}</span></div>
                        <div class="posicao-col data"><span>${formatarDataPortugues(posicao.created_at)}</span></div>
                        <div class="posicao-col acoes">
                            <button class="posicao-editar-btn" data-posicao-id="${posicao.id}" ${readOnly ? 'disabled="true"' : ''} type="button"><span>Editar</span></button>
                            <button class="posicao-excluir-btn" data-posicao-id="${posicao.id}" ${readOnly ? 'disabled="true"' : ''} type="button"><span>Excluir</span></button>
                        </div>
                    </div>
                `;
            });
        }

        caracteristicasListContainer.innerHTML = `
            <div class="caracteristicas-list-header">
                <div class="caracteristicas-header-col"><span>Nome</span></div>
                <div class="caracteristicas-header-col"><span>Unidade</span></div>
                <div class="caracteristicas-header-col"><span>Data de cadastro</span></div>
                <div class="caracteristicas-header-col"><span>Ações</span></div>
            </div>
        `;
        
        if (data.caracteristicas && data.caracteristicas.length > 0) {
            data.caracteristicas.forEach(caracteristica => {
                caracteristicasListContainer.innerHTML += `
                    <div class="caracteristicas-list-row" data-caracteristica-id="${caracteristica.id}">
                        <div class="caracteristica-col caracteristica"><span>${caracteristica.caracteristica}</span></div>
                        <div class="caracteristica-col unidade"><span>${caracteristica.unidade_medida || 'N/A'}</span></div>
                        <div class="caracteristica-col data"><span>${formatarDataPortugues(caracteristica.created_at) || 'N/A'}</span></div>
                        <div class="caracteristica-col acoes">
                            <button class="caracteristica-editar-btn" data-caracteristica-id="${caracteristica.id}" ${readOnly ? 'disabled="true"' : ''} type="button"><span>Editar</span></button>
                            <button class="caracteristica-excluir-btn" data-caracteristica-id="${caracteristica.id}" ${readOnly ? 'disabled="true"' : ''} type="button"><span>Excluir</span></button>
                        </div>
                    </div>
                `;
            });
        }
    } catch (error) {
        console.error('Erro ao buscar detalhes do esporte:', error);
        esporteModalTitle.textContent = "Erro ao carregar esporte";
        posicoesListContainer.innerHTML = '<p style="color: red;">Não foi possível carregar as posições.</p>';
        caracteristicasListContainer.innerHTML = '<p style="color: red;">Não foi possível carregar as características.</p>';
    }
}

async function saveCaracteristica(caracteristicaId = null) {
    const editMode = caracteristicaId !== null;

    try {
        const url = editMode ? '../api/admin/caracteristica/' + caracteristicaId : "../api/admin/caracteristica/";

        const formData = new FormData(document.querySelector('#caracteristica-form'));

        formData.append('esporte_id', esporteId);

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
            alert('Característica salva com sucesso!');

            if (!editMode) {
                document.querySelector('.caracteristicas-list-container').appendChild(createCaracteristicaRow(data));
            } else {
                const oldRow = document.querySelector('.caracteristicas-list-container').querySelector(`.caracteristicas-list-row[data-caracteristica-id="${caracteristicaId}"]`);
                const newRow = createCaracteristicaRow(data);
                document.querySelector('.caracteristicas-list-container').replaceChild(newRow, oldRow);
            }

            fecharModal(modais['caracteristica-modal']);
        }                
    } catch (error) {
        console.error('Erro ao salvar caracteristica:', error);
        alert('Erro ao salvar caracteristica!');
    }
}

async function savePosicao(posicaoId = null) {
    const editMode = posicaoId !== null;

    try {
        const url = editMode ? '../api/admin/posicao/' + posicaoId : "../api/admin/posicao/";

        const formData = new FormData(document.querySelector('#posicao-form'));

        formData.append('idEsporte', esporteId);

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
            alert('Posição salvo com sucesso!');

            if (!editMode) {
                document.querySelector('.posicoes-list-container').appendChild(createPosicaoRow(data));
            } else {
                const oldRow = document.querySelector('.posicoes-list-container').querySelector(`.posicoes-list-row[data-posicao-id="${posicaoId}"]`);
                const newRow = createPosicaoRow(data);
                document.querySelector('.posicoes-list-container').replaceChild(newRow, oldRow);
            }

            fecharModal(modais['posicao-modal']);
        }                
    } catch (error) {
        console.error('Erro ao salvar posição:', error);
        alert('Erro ao salvar posição!');
    }
}

async function saveEsporte(esporteId = null) {
    const editMode = esporteId !== null;

    try {
        const url = editMode ? '../api/admin/esporte/' + esporteId : "../api/admin/esporte/";

        const formData = new FormData(document.querySelector('#esporte-form'));

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
            alert('Esporte salvo com sucesso!');

            if (!editMode) {
                esportes.appendChild(createEsporteRow(data));
            } else {
                const oldRow = esportes.querySelector(`.esporte[data-esporte-id="${esporteId}"]`);
                const newRow = createEsporteRow(data);
                esportes.replaceChild(newRow, oldRow);
            }
            
            fecharModal(modais['esporte-modal']);
        }                
    } catch (error) {
        console.error('Erro ao salvar esporte:', error);
        alert('Erro ao salvar esporte!');
    }
}

async function deleteCaracteristica(caracteristicaId) {
    try {
        const url = "../api/admin/caracteristica/" + caracteristicaId;

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
            alert('Caractéristica excluída com sucesso!');
            caracteristicasListContainer.querySelector(`.caracteristicas-list-row[data-caracteristica-id="${caracteristicaId}"]`)?.remove();
            caracteristicaId = -1;
        }                
    } catch (error) {
        console.error('Erro ao excluir característica:', error);
        alert('Erro ao excluir característica!');
    }
}

async function deletePosicao(posicaoId) {
    try {
        const url = "../api/admin/posicao/" + posicaoId;

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
            alert('Posição excluída com sucesso!');
            posicoesListContainer.querySelector(`.posicoes-list-row[data-posicao-id="${posicaoId}"]`)?.remove();
            posicaoId = -1;
        }                
    } catch (error) {
        console.error('Erro ao excluir posição:', error);
        alert('Erro ao excluir posição!');
    }
}

async function deleteEsporte(esporteId) {
    try {
        const url = "../api/admin/esporte/" + esporteId;

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
            alert('Esporte excluído com sucesso!');
            esportes.querySelector(`.esporte[data-esporte-id="${esporteId}"]`)?.remove();
            esporteId = -1;
        }                
    } catch (error) {
        console.error('Erro ao excluir esporte:', error);
        alert('Erro ao excluir esporte!');
    }
}