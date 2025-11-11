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

function createClubeRow(clube) {
    const div = document.createElement('div');
    div.className = "clube";
    div.dataset.clubeId = clube.id;
    div.innerHTML = `
        <div class="clube-nome">
            <span>${clube.nomeClube}</span>
        </div>
        <div class="clube-email">
            <span>${clube.emailClube}</span>
        </div>
        <div class="clube-cnpj">
            <span>${clube.cnpjClube}</span>
        </div>
        <div class="clube-data-criacao">
            <span>${formatarDataAnoPortugues(clube.anoCriacaoClube)}</span>
        </div>
        <div class="clube-data">
            <span>${formatarDataPortugues(clube.created_at)}</span>
        </div>
        <div class="clube-acoes">
            <button class="clube-ver-btn">
                <span>Ver</span>
            </button>
            <button class="clube-editar-btn">
                <span>Editar</span>
            </button>
            <button class="clube-excluir-btn">
                <span>Excluir</span>
            </button>
        </div>
    `;
    return div;
}