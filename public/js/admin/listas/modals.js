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
    if (modal.inputs) {
        modal.inputs.forEach(inp => inp.value = "");
    }

    if (modal === modalLista) {
        spanModalListaNome.textContent = '';
        spanModalListaClube.textContent = '';
        spanModalListaDescricao.textContent = '';
        spanModalListaUserCount.textContent = '';
        usersListContainer.innerHTML = '';

        listaModalTitle.textContent = 'Detalhes da lista';
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