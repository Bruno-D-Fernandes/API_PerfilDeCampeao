// Adicionar variável para controlar a pilha de modais fechados
let modaisFechados = [];

// Função modificada para abrir modal
function abrirModal(modal) {
    // Se está abrindo um modal de tipo 2 ou 3, fechar os outros modais primeiro e salvá-los na pilha
    if (modal.type === 2 || modal.type === 3) {
        modaisFechados = [];
        
        // Fechar todos os outros modais abertos e salvá-los na pilha
        Object.values(modais).forEach(m => {
            if (m !== modal && !m.content.classList.contains('hidden')) {
                m.content.classList.add('hidden');
                modaisFechados.push(m);
            }
        });
        
        // Limpar backdrops
        modalBackdrop.classList.add('hidden');
        modalBackdropSecond.classList.add('hidden');
    }
    
    modal.content.classList.remove('hidden');
    
    // Configurar backdrops normalmente
    if (modal.type === 2) {
        modalBackdropSecond.classList.remove('hidden');
        modalBackdrop.classList.remove('hidden');
    } else if (modal.type === 3) {
        modalBackdropSecond.classList.remove('hidden');
    } else {
        modalBackdrop.classList.remove('hidden');
    }
}

// Função modificada para fechar modal
function fecharModal(modal) {
    const isModalEspecifico = modal.type === 2 || modal.type === 3;
    
    modal.content.classList.add('hidden');
    limparModal(modal);

    // Para modais de tipo 2 ou 3, reabrir os modais da pilha se existirem
    if (isModalEspecifico && modaisFechados.length > 0) {
        modaisFechados.forEach(modalFechado => {
            modalFechado.content.classList.remove('hidden');
        });
        modaisFechados = [];
        
        // Reconfigurar backdrops após reabrir os modais
        const algumModalEspecialAberto = Object.values(modais).some(m => 
            !m.content.classList.contains('hidden') && (m.type === 2 || m.type === 3)
        );
        
        if (algumModalEspecialAberto) {
            const algumTipo2Aberto = Object.values(modais).some(m => 
                !m.content.classList.contains('hidden') && m.type === 2
            );
            
            if (algumTipo2Aberto) {
                modalBackdropSecond.classList.remove('hidden');
                modalBackdrop.classList.remove('hidden');
            } else {
                modalBackdropSecond.classList.remove('hidden');
            }
        } else {
            modalBackdropSecond.classList.add('hidden');
        }
    } else {
        // Lógica original para modais normais
        const tipo2Aberto = Object.values(modais).some(m => !m.content.classList.contains('hidden') && m.type === 2);
        if (!tipo2Aberto) modalBackdropSecond.classList.add('hidden');

        const algumAberto = Object.values(modais).some(m => !m.content.classList.contains('hidden'));
        if (!algumAberto) modalBackdrop.classList.add('hidden');
    }
}

// Resto das funções permanece igual
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
    const modalexc = document.getElementById('deleteModal');

    const newSaveBtn = saveBtn.cloneNode(true);
    saveBtn.parentNode.replaceChild(newSaveBtn, saveBtn);

    const newCancelBtn = cancelBtn.cloneNode(true);
    cancelBtn.parentNode.replaceChild(newCancelBtn, cancelBtn);

    abrirModal(modalConfirmar);

    newSaveBtn.addEventListener('click', () => {
        funcaoSim();
        fecharModal(modalConfirmar);
        modalexc.style.display = 'flex';
        
        setTimeout(() => {
            modalexc.style.display = "none";
        }, 2000);
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
        salvarEsporteBtn.style.display = 'none';
        cancelarEsporteBtn.style.display = 'none';
        addPosicaoBtn.style.display = 'none';
        addCaracteristicaBtn.style.display = 'none';
    }

    addPosicaoBtn.disabled = true;
    addCaracteristicaBtn.disabled = true;

    document.querySelectorAll('.posicao-editar-btn, .posicao-excluir-btn, .caracteristica-editar-btn, .caracteristica-excluir-btn')
        .forEach(btn => btn.style.display = 'none');
}

function enableInputs() {
    modalEsporte.inputs[0].disabled = false;
    modalEsporte.inputs[1].disabled = false;
    salvarEsporteBtn.disabled = false;
    cancelarEsporteBtn.disabled = false;

    addPosicaoBtn.disabled = false;
    addCaracteristicaBtn.disabled = false;

    salvarEsporteBtn.style.display = 'flex';
    cancelarEsporteBtn.style.display = 'flex';
    addPosicaoBtn.style.display = 'flex';
    addCaracteristicaBtn.style.display = 'flex';

    document.querySelectorAll('.posicao-editar-btn, .posicao-excluir-btn, .caracteristica-editar-btn, .caracteristica-excluir-btn')
        .forEach(btn => btn.disabled = false);
}