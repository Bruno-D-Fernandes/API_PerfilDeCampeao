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

const hideUserNeeded = () => {
    userNeededInfo.forEach(item => {
        item.classList.add('hidden');
    });
}

const showUserNeeded = () => {
    userNeededInfo.forEach(item => {
        item.classList.remove('hidden');
    });
}

function disableBtns() {
    modalAdicionarMembro.content.querySelectorAll('button').forEach(btn => {
        if (btn.classList.contains('close-modal-btn')) return;

        const isClearSearchBtn = [...clearSearchBtns].some(
            clearBtn => clearBtn === btn && clearBtn.dataset.clearTarget === 'user-search-input'
        );

        if (isClearSearchBtn) return;

        btn.disabled = true;
    });
}

function enableBtns() {
    modalAdicionarMembro.content.querySelectorAll('button').forEach(btn => {
        btn.disabled = false;
    });
}

function abrirModal(modal) {
    if (modal === modalAdicionarMembro) {
        searchUserContainer.classList.remove('hidden');
        searchUsers('');
        disableBtns();
    }

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
    if (modal.inputs) modal.inputs.forEach(inp => {
        if (inp.tagName === 'SELECT' && (inp.id === 'adicionar-membro-form-esporte' || inp.id === 'adicionar-membro-form-funcao')) {
            const firstOption = inp.querySelector('option');
            if (firstOption) inp.value = firstOption.value;
        } else {
            inp.value = '';
        }
    });
}

function disableInputs() {
    if (readOnly) {
        modalOportunidade.inputs.forEach(inp => inp.disabled = true);
        salvarOportunidadeBtn.disabled = true;
        cancelarOportunidadeBtn.disabled = true;
    }
}

function enableInputs() {
    modalOportunidade.inputs.forEach(inp => inp.disabled = false);
    salvarOportunidadeBtn.disabled = false;
    cancelarOportunidadeBtn.disabled = false;
}