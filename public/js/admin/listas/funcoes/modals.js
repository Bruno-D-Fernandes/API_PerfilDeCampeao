function abrirModal(modal) {
    modal.content.classList.remove('hidden');
    const outroAberto = Object.values(modais).some(m => !m.content.classList.contains('hidden') && m !== modal);
    modalBackdrop.classList.remove('hidden');
}

function fecharModal(modal) {
    modal.content.classList.add('hidden');
    limparModal(modal);

    const algumAberto = Object.values(modais).some(m => !m.content.classList.contains('hidden'));
    if (!algumAberto) modalBackdrop.classList.add('hidden');
}

function limparModal(modal) {
    if (modal.inputs) modal.inputs.forEach(inp => inp.value = "");
    funcaoModalTitle.textContent = 'Adicionar função';
}

function criarConfirmacao(titulo, texto, funcaoSim, funcaoNao) {
    confirmarModalTitle.textContent = titulo;
    confirmarModalAlert.textContent = texto;

    const saveBtn = modalConfirmar.content.querySelector('#save-confirm-btn');
    const cancelBtn = modalConfirmar.content.querySelector('#cancel-confirm-btn');
    const modalexc = document.getElementById('deleteModal')


    const newSaveBtn = saveBtn.cloneNode(true);
    saveBtn.parentNode.replaceChild(newSaveBtn, saveBtn);

    const newCancelBtn = cancelBtn.cloneNode(true);
    cancelBtn.parentNode.replaceChild(newCancelBtn, cancelBtn);

    abrirModal(modalConfirmar);

    newSaveBtn.addEventListener('click', () => {
        funcaoSim();
        modalexc.style.display = 'flex';
        fecharModal(modalConfirmar);
        setTimeout(() => {
        modalexc.style.display = "none";
        window.location.reload(true);
      }, 2000);
    });

    newCancelBtn.addEventListener('click', () => {
        funcaoNao();
        fecharModal(modalConfirmar);
    });
}

function disableInputs() {
    if (readOnly) {
        modalFuncao.inputs[0].disabled = true;
        modalFuncao.inputs[1].disabled = true;
        salvarFuncaoBtn.disabled = true;
        cancelarFuncaoBtn.disabled = true;
        salvarFuncaoBtn.style.display = 'none';
        cancelarFuncaoBtn.style.display = 'none';

    }
}

function enableInputs() {
    modalFuncao.inputs[0].disabled = false;
    modalFuncao.inputs[1].disabled = false;
    salvarFuncaoBtn.disabled = false;
    cancelarFuncaoBtn.disabled = false;
    salvarFuncaoBtn.style.display = 'flex';
    cancelarFuncaoBtn.style.display = 'flex';

}