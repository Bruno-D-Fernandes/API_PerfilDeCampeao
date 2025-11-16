function formatarDataPortugues(dataString) {
    const data = new Date(dataString);
    const dia = data.getDate().toString().padStart(2, '0');
    const mes = data.toLocaleString('pt-BR', { month: 'long' });
    return `${dia} de ${mes}`;
}

function createFuncaoRow(funcao) {
    const div = document.createElement('div');
    div.className = "funcao";
    div.dataset.funcaoId = funcao.id;
    div.innerHTML = `
        <div class="funcao-nome">
            <span>${funcao.nome}</span>
        </div>
        <div class="funcao-descricao">
            <span>${funcao.descricao || 'Sem descrição'}</span>
        </div>
        <div class="funcao-data">
            <span>${formatarDataPortugues(funcao.created_at)}</span>
        </div>
        <div class="funcao-acoes">
            <button class="funcao-ver-btn">
                <span><i class="fa-solid fa-eye"></i></span>
            </button>
            <button class="funcao-editar-btn">
                <span><i class="fa-solid fa-pen"></i></span>
            </button>
            <button class="funcao-excluir-btn">
                <span><i class="fa-solid fa-trash"></i></span>
            </button>
        </div>
    `;
    return div;
}