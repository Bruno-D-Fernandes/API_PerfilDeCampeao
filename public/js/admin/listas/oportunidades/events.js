closeModalBtns.forEach(btn => {
    btn.addEventListener('click', () => {
        const modalTarget = btn.dataset.modalTarget;
        fecharModal(modais[modalTarget]);
    });
});

oportunidadesContainer.addEventListener('click', async (e) => {
    const btnVer = e.target.closest('.oportunidade-ver-btn');
    const btnAprovar = e.target.closest('.oportunidade-aprovar-btn');
    const btnRejeitar = e.target.closest('.oportunidade-rejeitar-btn');

    if (btnVer) {
        oportunidadeId = btnVer.closest('.oportunidade').dataset.oportunidadeId;
        await fetchOportunidadeDetails(oportunidadeId);
        abrirModal(modalOportunidade);
    } else if (btnAprovar) {
        oportunidadeId = btnAprovar.closest('.oportunidade').dataset.oportunidadeId;
        await criarConfirmacao(
            'Aprovar Oportunidade?', 
            'Esta ação tornará a oportunidade pública. Deseja continuar?', 
            () => { 
                approveOportunidade(oportunidadeId) 
            }, () => {}
        );
    } else if (btnRejeitar) {
        oportunidadeId = btnRejeitar.closest('.oportunidade').dataset.oportunidadeId;
        limparModal(modalStatus);
        abrirModal(modalStatus);
    } else {
        return;
    }
});

tabButtons.forEach(btn => {
    btn.addEventListener('click', () => {
        const targetId = btn.dataset.targetTab;

        tabDetalhes.classList.remove('active');
        tabInscritos.classList.remove('active');

        document.getElementById(targetId).classList.add('active');
    });
});

salvarStatusBtn.addEventListener('click', () => {
    rejectOportunidade(oportunidadeId);
});

cancelarStatusBtn.addEventListener('click', () => {
    fecharModal(modalStatus);
});