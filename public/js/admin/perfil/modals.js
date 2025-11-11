function abrirModal(modal) {
    modal.content.classList.remove('hidden');
    modalBackdrop.classList.remove('hidden');
}

function fecharModal(modal) {
    modal.content.classList.add('hidden');
    limparModal(modal);

    const algumAberto = Object.values(modais).some(m => !m.content.classList.contains('hidden'));
    
    if (!algumAberto) {
        modalBackdrop.classList.add('hidden');
    }
}

function limparModal(modal) {
    if (modal.inputs) {
        modal.inputs.forEach(inp => inp.value = "");
    }
    
    if (modal === modalPerfil) {
        previewFoto.src = "";
        previewFoto.style.display = 'none';
    }
}

function criarConfirmacao(titulo, texto, funcaoSim, funcaoNao) {
    confirmarModalTitle.textContent = titulo;
    confirmarModalAlert.textContent = texto;

    const saveBtn = confirmarSalvarBtn;
    const cancelBtn = confirmarCancelarBtn;

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