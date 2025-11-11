closeModalBtns.forEach(btn => {
    btn.addEventListener('click', () => {
        const tgt = btn.dataset.modalTarget;
        fecharModal(modais[tgt]);
    });
});

addFuncaoBtn.addEventListener('click', () => {
    funcaoId = -1;
    readOnly = false;
    enableInputs();
    abrirModal(modalFuncao);
});

salvarFuncaoBtn.addEventListener('click', () => {
    if(funcaoId !== -1) saveFuncao(funcaoId); 
    else saveFuncao();
});

cancelarFuncaoBtn.addEventListener('click', () => fecharModal(modalFuncao));

funcoes.addEventListener('click', (e) => {
    const btnEditar = e.target.closest('.funcao-editar-btn');
    const btnVer = e.target.closest('.funcao-ver-btn');
    const btnExcluir = e.target.closest('.funcao-excluir-btn');

    if (btnEditar) {
        readOnly = false;
        enableInputs();
        funcaoId = btnEditar.closest('.funcao').dataset.funcaoId;
        fetchFuncaoDetails(funcaoId);
        abrirModal(modalFuncao);
    } else if (btnVer) {
        readOnly = true;
        disableInputs();
        funcaoId = btnVer.closest('.funcao').dataset.funcaoId;
        fetchFuncaoDetails(funcaoId);
        abrirModal(modalFuncao);
    } else if (btnExcluir) {
        readOnly = false;
        funcaoId = btnExcluir.closest('.funcao').dataset.funcaoId;
        criarConfirmacao('Deseja excluir esta função?', 'Essa ação é irreversível.', () => deleteFuncao(funcaoId), () => {});
    } else {
        return;
    }
});