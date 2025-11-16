function abrirModal(modal) {
      const modalopor = document.getElementById('totaltotal')
   modalopor.classList.add('hidden1');
    modal.content.classList.remove('hidden');
    modalBackdrop.classList.remove('hidden');
}

function fecharModal(modal) {
    modal.content.classList.add('hidden');
    const modalopor = document.getElementById('totaltotal')
    modalopor.classList.remove('hidden1');
    limparModal(modal);
    const algumAberto = Object.values(modais).some(m => !m.content.classList.contains('hidden'));
    if (!algumAberto) modalBackdrop.classList.add('hidden');
        
    
}

function limparModal(modal) {
    if (modal.inputs) modal.inputs.forEach(inp => inp.value = "");
    clubeModalTitle.textContent = 'Adicionar clube';
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
        modalexc.style.display = 'flex'
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
    const view = document.getElementById('sumir')
    if (clubeId === -1) {
        hideFormImgs();
    }

    if (readOnly) {
        const sele = document.getElementById('sele')
        const sele1 = document.getElementById('sele1')
        modalClube.inputs.forEach(inp => inp.disabled = true);
        salvarClubeBtn.style.display = 'none';
        sele.style.display='none'
        sele1.style.display='none'
        salvarClubeBtn.disabled = true;
        cancelarClubeBtn.style.display = 'none';
        cancelarClubeBtn.disabled = true;
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
    if (clubeId === -1) {
        hideFormImgs();
    } else {
        unhideFormImgs();
    }

    modalClube.inputs.forEach(inp => inp.disabled = false);
    const sele = document.getElementById('sele')
    const sele1 = document.getElementById('sele1')
    sele.style.display='flex'
    sele1.style.display='flex'
    salvarClubeBtn.disabled = false
    salvarClubeBtn.style.display = 'flex';
    cancelarClubeBtn.style.display = 'flex';
    cancelarClubeBtn.disabled = false;
}