function abrirModal(modal) {
    modal.content.classList.remove('hidden');
    const outroAberto = Object.values(modais).some(m => !m.content.classList.contains('hidden') && m !== modal);
    if (modal.type === 2) {
        modalBackdropSecond.classList.remove('hidden');
        modalBackdrop.classList.remove('hidden');
    } else if (modal.type === 3) {
        if (outroAberto) modalBackdropSecond.classList.remove('hidden');
        else modalBackdrop.classList.remove('hidden');
    } else {
        modalBackdrop.classList.remove('hidden');
    }
}

function fecharModal(modal) {
    modal.content.classList.add('hidden');
    limparModal(modal);

    const tipo2Aberto = Object.values(modais).some(m => !m.content.classList.contains('hidden') && m.type === 2);
    if (!tipo2Aberto) modalBackdropSecond.classList.add('hidden');

    const algumAberto = Object.values(modais).some(m => !m.content.classList.contains('hidden'));
    if (!algumAberto) modalBackdrop.classList.add('hidden');
}

function limparModal(modal) {
    if (modal.inputs) modal.inputs.forEach(inp => inp.value = "");
    if (modal === modalEsporte) {
        esporteModalTitle.textContent = 'Adicionar esporte';
        posicoesListContainer.innerHTML = '';
        caracteristicasListContainer.innerHTML = '';
    } else if (modal === modalPosicao) {
        posicaoModalTitle.textContent = 'Adicionar posição';
    } else if (modal === modalCaracteristica) {
        caracteristicaModalTitle.textContent = 'Adicionar característica';
    } else {
        confirmarModalTitle.textContent = 'Você deseja continuar?';
        confirmarModalAlert.textContent = 'Essa ação não poderá ser desfeita.';
    }
}

function criarConfirmacao(titulo, texto, funcaoSim, funcaoNao) {
    confirmarModalTitle.textContent = titulo;
    confirmarModalAlert.textContent = texto;

    const saveBtn = modalConfirmar.content.querySelector('#save-confirm-btn');
    const cancelBtn = modalConfirmar.content.querySelector('#cancel-confirm-btn');

    const newSaveBtn = saveBtn.cloneNode(true);
    saveBtn.parentNode.replaceChild(newSaveBtn, saveBtn);

    const newCancelBtn = cancelBtn.cloneNode(true);
    cancelBtn.parentNode.replaceChild(newCancelBtn, cancelBtn);

    abrirModal(modalConfirmar);

    newSaveBtn.addEventListener('click', () => {
        funcaoSim();
        fecharModal(modalConfirmar);
    });

    newCancelBtn.addEventListener('click', () => {
        funcaoNao();
        fecharModal(modalConfirmar);
    });
}

function disableInputs() {
    if (readOnly) {
        modalEsporte.inputs[0].disabled = true;
        modalEsporte.inputs[1].disabled = true;
        salvarEsporteBtn.disabled = true;
        cancelarEsporteBtn.disabled = true;
    }

    addPosicaoBtn.disabled = true;
    addCaracteristicaBtn.disabled = true;

    document.querySelectorAll('.posicao-editar-btn, .posicao-excluir-btn, .caracteristica-editar-btn, .caracteristica-excluir-btn')
        .forEach(btn => btn.disabled = true);
}

function enableInputs() {
    modalEsporte.inputs[0].disabled = false;
    modalEsporte.inputs[1].disabled = false;
    salvarEsporteBtn.disabled = false;
    cancelarEsporteBtn.disabled = false;

    addPosicaoBtn.disabled = false;
    addCaracteristicaBtn.disabled = false;

    document.querySelectorAll('.posicao-editar-btn, .posicao-excluir-btn, .caracteristica-editar-btn, .caracteristica-excluir-btn')
        .forEach(btn => btn.disabled = false);
}