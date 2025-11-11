async function fetchOportunidadeDetails(oportunidadeId) {
    try {
        const url = `../api/admin/oportunidade/${oportunidadeId}`; 

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

        console.log(data);

        oportunidadeModalTitle.textContent = `Detalhes: ${data.esporte.nomeEsporte} - ${data.posicao.nomePosicao}`;
        spanDataPostagem.textContent = formatarDataAnoPortugues(data.datapostagemOportunidades);
        spanDescricao.textContent = data.descricaoOportunidades;
        spanRequisitos.textContent = `De ${data.idadeMinima} até ${data.idadeMaxima} anos`;
        spanLocalizacao.textContent = `${data.enderecoOportunidade}, ${data.cidadeOportunidade} - ${data.estadoOportunidade}`;
        spanContexto.textContent = `Clube: ${data.clube.nomeClube}\nEsporte: ${data.esporte.nomeEsporte}\nPosição: ${data.posicao.nomePosicao}`;

        inscritosListContainer.innerHTML = '';
        if (data.inscricoes && data.inscricoes.length > 0) {
            data.inscricoes.forEach(inscrito => {
                const inscritoHTML = document.createElement('span');
                inscritoHTML.textContent = inscrito.usuario.nomeCompletoUsuario;
                inscritosListContainer.appendChild(inscritoHTML);
            });
        } else {
            inscritosListContainer.innerHTML = '<p>Nenhum usuário inscrito ainda.</p>';
        }

    } catch (error) {
        console.error('Erro ao buscar detalhes da oportunidade:', error);
        oportunidadeModalTitle.textContent = "Erro ao carregar detalhes";
    }
}

async function approveOportunidade(oportunidadeId) {
    try {
        const url = `../api/admin/oportunidade/${oportunidadeId}/status`;

        const formData = new FormData();
        formData.append('_method', 'PUT');
        formData.append('status', 'approved');

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

        if(data) {
            alert('Oportunidade APROVADA com sucesso!');

            const row = oportunidadesContainer.querySelector(`.oportunidade[data-oportunidade-id="${oportunidadeId}"]`);

            const statusSpan = row.querySelector('.oportunidade-status span');

            statusSpan.textContent = data.status;
        } else {
            alert('Erro ao processar a resposta do servidor.');
        }               
    } catch (error) {
        console.error('Erro ao aprovar oportunidade:', error);
        alert('Erro ao aprovar oportunidade!');
    }
}

async function rejectOportunidade(oportunidadeId) {
    try {
        const url = `../api/admin/oportunidade/${oportunidadeId}/status`;

        const form = document.querySelector('#status-form');

        const formData = new FormData(form);

        formData.append('_method', 'PUT');
        formData.append('status', 'rejected');

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

        if (data) {
            alert('Oportunidade REJEITADA com sucesso!');

            const row = oportunidadesContainer.querySelector(`.oportunidade[data-oportunidade-id="${oportunidadeId}"]`);
                
            const statusSpan = row.querySelector('.oportunidade-status span');
            statusSpan.textContent = data.status === 'rejected' ? 'Rejeitada' : 'Aprovada';

            row.querySelector('.oportunidade-aprovar-btn').remove();
            row.querySelector('.oportunidade-rejeitar-btn').remove();
            
            fecharModal(modalStatus);
        } else {
            alert('Erro ao processar a resposta do servidor.');
        }               
    } catch (error) {
        console.error('Erro ao rejeitar oportunidade:', error);
        alert('Erro ao rejeitar oportunidade!');
    }
}