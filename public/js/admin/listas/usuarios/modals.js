function abrirModal(modal) {
    modal.content.classList.remove('hidden');
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
    usuarioModalTitle.textContent = 'Adicionar clube';
    previewImagem.src = "";
    previewImagemBanner.src = "";
    hideFormImgs();
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
    if (usuarioId === -1) {
        hideFormImgs();
    }

    if (readOnly) {
        modalUsuario.inputs.forEach(inp => inp.disabled = true);
        salvarUsuarioBtn.disabled = true;
        cancelarUsuarioBtn.disabled = true;
        salvarUsuarioBtn.style.display = 'none';
        cancelarUsuarioBtn.style.display = 'none';

    }
}

function hideFormImgs() {
    document.querySelectorAll('.form-group.img').forEach(formImg => {
        formImg.classList.add('hidden');
    });
    previewImagem.style.display = 'none';
    previewImagemBanner.style.display = 'none';
}

function unhideFormImgs() {
    document.querySelectorAll('.form-group.img').forEach(formImg => {
        formImg.classList.remove('hidden');
    });
}

function enableInputs() {
    if (usuarioId === -1) {
        hideFormImgs();
    } else {
        unhideFormImgs();
    }

    modalUsuario.inputs.forEach(inp => inp.disabled = false);
    salvarUsuarioBtn.disabled = false;
    cancelarUsuarioBtn.disabled = false;
    salvarUsuarioBtn.style.display = 'flex';
    cancelarUsuarioBtn.style.display = 'flex';
}