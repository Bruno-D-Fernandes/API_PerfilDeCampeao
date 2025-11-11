function abrirModal(modal) {
    modal.content.classList.remove('hidden');

    if (modal.type === 2) {
        if (modalBackdropSecond) modalBackdropSecond.classList.remove('hidden');

        modalBackdrop.classList.remove('hidden');
    } else {
        modalBackdrop.classList.remove('hidden');
    }
}

function fecharModal(modal) {
    modal.content.classList.add('hidden');

    limparModal(modal);

    const tipo2Aberto = Object.values(modais).some(m => 
        m.type === 2 && !m.content.classList.contains('hidden')
    );

    if (!tipo2Aberto && modalBackdropSecond) {
        modalBackdropSecond.classList.add('hidden');
    }

    const algumAberto = Object.values(modais).some(m => 
        !m.content.classList.contains('hidden')
    );

    if (!algumAberto) {
        modalBackdrop.classList.add('hidden');
    }
}

function limparModal(modal) {
    if (modal.inputs) {
        modal.inputs.forEach(inp => {
            if (inp) inp.value = "";
        });
    }
    
    if (modal === modalListas) {
        const itens = listasContainer.querySelectorAll('.lista-item');
        itens.forEach(item => item.remove());
    }
}