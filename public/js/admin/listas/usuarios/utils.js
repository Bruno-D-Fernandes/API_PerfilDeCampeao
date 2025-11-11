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

function createUsuarioRow(usuario) {
    const div = document.createElement('div');
    div.className = "usuario";
    div.dataset.usuarioId = usuario.id;
    div.innerHTML = `
        <div class="usuario-nome">
            <span>${usuario.nomeCompletoUsuario}</span>
        </div>
        <div class="usuario-email">
            <span>${usuario.emailUsuario}</span>
        </div>
        <div class="usuario-genero">
            <span>${usuario.generoUsuario ?? 'N/A'}</span>
        </div>
        <div class="usuario-data-nascimento">
            <span>${formatarDataAnoPortugues(usuario.dataNascimentoUsuario)}</span>
        </div>
        <div class="usuario-data">
            <span>${formatarDataPortugues(usuario.created_at)}</span>
        </div>
        <div class="usuario-acoes">
            <button class="usuario-ver-btn">
                <span>Ver</span>
            </button>
            <button class="usuario-editar-btn">
                <span>Editar</span>
            </button>
            <button class="usuario-excluir-btn">
                <span>Excluir</span>
            </button>
        </div>
    `;
    return div;
}