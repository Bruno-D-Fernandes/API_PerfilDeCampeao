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

function createEsporteRow(esporte) {
    const div = document.createElement('div');
    div.className = "esporte";
    div.dataset.esporteId = esporte.id;
    div.innerHTML = `
        <div class="esporte-nome"><span>${esporte.nomeEsporte}</span></div>
        <div class="esporte-descricao"><span>${esporte.descricaoEsporte || "Sem descrição"}</span></div>
        <div class="esporte-posicoes"><span>${esporte.posicoes.length}</span></div>
        <div class="esporte-caracteristicas"><span>${esporte.caracteristicas.length}</span></div>
        <div class="esporte-cadastro"><span>${formatarDataPortugues(new Date().toISOString())}</span></div>
        <div class="esporte-acoes">
            <button class="esporte-ver-btn"><span>Ver</span></button>
            <button class="esporte-editar-btn"><span>Editar</span></button>
            <button class="esporte-excluir-btn"><span>Excluir</span></button>
        </div>
    `;
    return div;
}

function createPosicaoRow(posicao) {
    const div = document.createElement('div');
    div.className = "posicoes-list-row";
    div.dataset.posicaoId = posicao.id;
    div.innerHTML = `
        <div class="posicao-col nome"><span>${posicao.nomePosicao}</span></div>
        <div class="posicao-col data"><span>${formatarDataPortugues(new Date().toISOString())}</span></div>
        <div class="posicao-col acoes">
            <button class="posicao-editar-btn" type="button"><span>Editar</span></button>
            <button class="posicao-excluir-btn" type="button"><span>Excluir</span></button>
        </div>
    `;
    return div;
}

function createCaracteristicaRow(caracteristica) {
    const div = document.createElement('div');
    div.className = "caracteristicas-list-row";
    div.dataset.caracteristicaId = caracteristica.id;
    div.innerHTML = `
        <div class="caracteristica-col caracteristica"><span>${caracteristica.caracteristica}</span></div>
        <div class="caracteristica-col unidade"><span>${caracteristica.unidade_medida}</span></div>
        <div class="caracteristica-col data"><span>${formatarDataPortugues(new Date().toISOString())}</span></div>
        <div class="caracteristica-col acoes">
            <button class="caracteristica-editar-btn" type="button"><span>Editar</span></button>
            <button class="caracteristica-excluir-btn" type="button"><span>Excluir</span></button>
        </div>
    `;
    return div;
}