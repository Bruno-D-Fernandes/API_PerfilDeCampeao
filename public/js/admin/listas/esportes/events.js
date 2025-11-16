closeModalBtns.forEach(btn => {
    btn.addEventListener('click', () => {
        const tgt = btn.dataset.modalTarget;
        fecharModal(modais[tgt]);
    });
});

tabBtns.forEach(tabBtn => {
    tabBtn.addEventListener('click', () => {
        // Primeiro, remove 'active' de todos os botões de aba
        tabBtns.forEach(btn => btn.classList.remove('active'));
        // Adiciona 'active' apenas no botão clicado
        tabBtn.classList.add('active');
        
        // Esconde todos os conteúdos de aba
        document.querySelectorAll('.tab-content').forEach(tc => tc.classList.remove('active'));
        // Mostra apenas o conteúdo da aba correspondente
        document.querySelector(`#${tabBtn.dataset.targetTab}`).classList.add('active');
    });
});


addEsporteBtn.addEventListener('click', () => {
    esporteId = -1;
    readOnly = false;
    enableInputs();
    abrirModal(modalEsporte);
    
    // --- MINHA MODIFICAÇÃO ---
    // Esconde as abas ao adicionar um novo esporte
    document.querySelector('.pfvv').classList.add('hidden');
});

addPosicaoBtn.addEventListener('click', () => {
    posicaoId = -1;
    abrirModal(modalPosicao);
});

addCaracteristicaBtn.addEventListener('click', () => {
    caracteristicaId = -1;
    abrirModal(modalCaracteristica);
});

salvarEsporteBtn.addEventListener('click', () => {
    if(esporteId !== -1) saveEsporte(esporteId); 
    else saveEsporte();
});

cancelarEsporteBtn.addEventListener('click', () => fecharModal(modalEsporte));

salvarPosicaoBtn.addEventListener('click', () => {
    if(posicaoId !== -1) savePosicao(posicaoId);
    else savePosicao();
});

cancelarPosicaoBtn.addEventListener('click', () => fecharModal(modalPosicao));

salvarCaracteristicaBtn.addEventListener('click', () => {
    if(caracteristicaId !== -1) saveCaracteristica(caracteristicaId);
    else saveCaracteristica();
});

cancelarCaracteristicaBtn.addEventListener('click', () => fecharModal(modalCaracteristica));

esportes.addEventListener('click', (e) => {
    const btnEditar = e.target.closest('.esporte-editar-btn');
    const btnVer = e.target.closest('.esporte-ver-btn');
    const btnExcluir = e.target.closest('.esporte-excluir-btn');

    if (btnEditar) {
        readOnly = false;
        enableInputs();
        esporteId = btnEditar.closest('.esporte').dataset.esporteId;
        fetchEsporteDetails(esporteId);
        abrirModal(modais['esporte-modal']);

        // --- MINHA MODIFICAÇÃO ---
        // Mostra as abas ao editar
        document.querySelector('.pfvv').classList.remove('hidden');

    } else if (btnVer) {
        readOnly = true;
        disableInputs();
        esporteId = btnVer.closest('.esporte').dataset.esporteId;
        fetchEsporteDetails(esporteId);
        abrirModal(modais['esporte-modal']);

        // --- MINHA MODIFICAÇÃO ---
        // Mostra as abas ao visualizar
        document.querySelector('.pfvv').classList.remove('hidden');

    } else if (btnExcluir) {
        readOnly = false;
        esporteId = btnExcluir.closest('.esporte').dataset.esporteId;
        criarConfirmacao('Deseja excluir este esporte?', 'Essa ação é irreversível.', () => deleteEsporte(esporteId), () => {});
    } else {
        return;
    }
});

posicoesListContainer.addEventListener('click', (e) => {
    const btnEditar = e.target.closest('.posicao-editar-btn');
    const btnExcluir = e.target.closest('.posicao-excluir-btn');

    if (btnEditar) {
        posicaoId = btnEditar.closest('.posicoes-list-row').dataset.posicaoId;
        fetchPosicaoDetails(posicaoId);
        abrirModal(modais['posicao-modal']);
    } else if (btnExcluir) {
        posicaoId = btnExcluir.closest('.posicoes-list-row').dataset.posicaoId;
        criarConfirmacao('Deseja excluir esta posição?', 'Essa ação é irreversível.', () => deletePosicao(posicaoId), () => {});
    }

    if (!btnEditar) return;
});

caracteristicasListContainer.addEventListener('click', (e) => {
    const btnEditar = e.target.closest('.caracteristica-editar-btn');
    const btnExcluir = e.target.closest('.caracteristica-excluir-btn');

    if (btnEditar) {
        caracteristicaId = btnEditar.closest('.caracteristicas-list-row').dataset.caracteristicaId;
        fetchCaracteristicaDetails(caracteristicaId);
        abrirModal(modais['caracteristica-modal']);
    } else if (btnExcluir) {
        caracteristicaId = btnExcluir.closest('.caracteristicas-list-row').dataset.caracteristicaId;
        criarConfirmacao('Deseja excluir esta característica?', 'Essa ação é irreversível.', () => deleteCaracteristica(caracteristicaId), () => {});
    }

    if (!btnEditar) return;
});
