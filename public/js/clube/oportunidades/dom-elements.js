const formOportunidadesEl   = document.getElementById('formOportunidades');
const cepInputEl            = document.getElementById('cep');
const esporteSelectEl       = document.getElementById('esporte_id');
const posicaoSelectEl       = document.getElementById('posicoes_id');

function resetPosicaoSelectCarregando() {
    if (!posicaoSelectEl) return;
    posicaoSelectEl.innerHTML = '<option value="">Carregando posições...</option>';
}

function resetPosicaoSelectSemEsporte() {
    if (!posicaoSelectEl) return;
    posicaoSelectEl.innerHTML = '<option value="">Selecione um esporte primeiro...</option>';
}

function fillEsporteSelect(esportes) {
    if (!esporteSelectEl) return;

    esporteSelectEl.innerHTML = '<option value="">Selecione o esporte...</option>';

    esportes.forEach(esporte => {
        const opt = document.createElement('option');
        opt.value = esporte.id;
        opt.textContent = esporte.nomeEsporte;
        esporteSelectEl.appendChild(opt);
    });
}

function fillPosicaoSelect(posicoes) {
    if (!posicaoSelectEl) return;

    posicaoSelectEl.innerHTML = '<option value="">Selecione a posição...</option>';

    posicoes.forEach(posicao => {
        const opt = document.createElement('option');
        opt.value = posicao.id;
        opt.textContent = posicao.nomePosicao;
        posicaoSelectEl.appendChild(opt);
    });
}

function getFormPayload(formEl) {
    const formData = new FormData(formEl);
    return Object.fromEntries(formData.entries());
}