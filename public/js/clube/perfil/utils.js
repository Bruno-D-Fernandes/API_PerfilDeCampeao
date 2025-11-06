function formatarDataPortugues(dataString) {
    let data;

    if (!dataString) {
        data = new Date();
    } else {
        data = new Date(dataString);
    }

    const dia = data.getUTCDate().toString().padStart(2, '0');
    const mes = data.toLocaleString('pt-BR', { month: 'long', timeZone: 'UTC' });

    return `${dia} de ${mes}`;
}

function formatarDataAnoPortugues(dataString) {
    let data;

    if (!dataString) {
        data = new Date();
    } else {
        data = new Date(dataString);
    }

    const dia = data.getUTCDate().toString().padStart(2, '0');
    const mes = data.toLocaleString('pt-BR', { month: 'long', timeZone: 'UTC' });
    const ano = data.getUTCFullYear();

    return `${dia} de ${mes} de ${ano}`;
}

function createOportunidadeRow(oportunidade) {
    const div = document.createElement('div');
    div.className = "opportunity";

    div.dataset.oportunidadeId = oportunidade.id;

    div.innerHTML = `
        <div class="opportunity-details">
            <span>
                ${oportunidade.posicao.nomePosicao}
            </span>
            <span>
                ${oportunidade.esporte.nomeEsporte}
            </span>
            <span>
                Sub - ${oportunidade.idadeMaxima}
            </span>
            <span>
                Interessados - ${oportunidade.candidatos.length}
            </span>
        </div>
        <button class="see-details-btn">
            <i class="fa-solid fa-ellipsis"></i>
        </button>
        <div class="opportunity-options hidden">
            <button class="oportunidade-ver-btn">
                <span>
                    Ver
                </span>
            </button>
            <button class="oportunidade-editar-btn">
                <span>
                    Editar 
                </span>
            </button>
            <button class="oportunidade-excluir-btn">
                <span>
                    Excluir
                </span>
            </button>
            <button class="oportunidade-inscritos-btn">
                <span>
                    Inscritos
                </span>
            </button>
        </div>
    `;
    return div;
}

function createMemberRow(id, nome, esporteId = '', funcaoId = '') {
    const div = document.createElement('div');

    div.className = 'members-list-row';

    div.dataset.memberId = id;

    if (esporteId) div.dataset.esporteId = esporteId;
    if (funcaoId) div.dataset.funcaoId = funcaoId;

    div.innerHTML = `
        <span class="member-name">${nome}</span>
        <div class="members-btns">
            <button class="membro-ver-btn"><span>Ver perfil</span></button>
            <button class="membro-excluir-btn"><span>Remover</span></button>
        </div>
    `;

    return div;
}

function populatePosicoes(esporteId, selectedPosicaoId = null) {
    const posSelect = document.querySelector('#oportunidade-form-posicao');

    if (!esporteId) {
        posSelect.innerHTML = `<option value="">Selecione uma posição</option>`;
        return;
    }

    const esporte = esportesData.find(e => e.id == esporteId);

    if (!esporte || !esporte.posicoes) {
        posSelect.innerHTML = `<option value="">Nenhuma posição disponível</option>`;
        
        return;
    }

    posSelect.innerHTML = esporte.posicoes.map(p => `
        <option value="${p.id}" ${p.id == selectedPosicaoId ? 'selected' : ''}>${p.nomePosicao}</option>
    `).join('');
}

function updateClube(data) {
    const nomeEl = document.querySelector('.profile-name');
    const bioEl = document.querySelector('.profile-bio');

    nomeEl.textContent = data.nomeClube || nomeEl.textContent;

    bioEl.textContent = data.bioClube || bioEl.textContent;

    const bannerEl = document.querySelector('.profile-imgs .banner');

    const pictureEl = document.querySelector('.profile-imgs .picture');

    if (data.fotoBannerClube) bannerEl.innerHTML = `<img src="${storageUrl}/${data.fotoBannerClube}" alt="banner" />`;
    else bannerEl.innerHTML = '';

    if (data.fotoPerfilClube) pictureEl.innerHTML = `<img src="${storageUrl}/${data.fotoPerfilClube}" alt="foto" />`;
    else pictureEl.innerHTML = '';

    const aboutPs = document.querySelectorAll('.about-container .info p');

    try {
        aboutPs[0].textContent = data.anoCriacaoClube ? formatarDataAnoPortugues(data.anoCriacaoClube) : '';
    } catch(e) { 
        aboutPs[0].textContent = data.anoCriacaoClube || ''; 
    }

    aboutPs[1].textContent = data.esporte.nomeEsporte;
    aboutPs[2].textContent = data.categoria.nomeCategoria;
    aboutPs[3].innerHTML = `${data.enderecoClube}<br>${data.cidadeClube} - ${data.estadoClube}`;
    aboutPs[4].textContent = data.emailClube;
    aboutPs[5].textContent = data.cnpjClube;
}