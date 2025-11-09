closeModalBtns.forEach(btn => {
    btn.addEventListener('click', () => {
        const modalTarget = btn.dataset.modalTarget;
        fecharModal(modais[modalTarget]);
    });
});

listasContainer.addEventListener('click', (e) => {
    const btnVer = e.target.closest('.lista-ver-btn');
    const btnExcluir = e.target.closest('.lista-excluir-btn');

    if (btnVer) {
        listaId = btnVer.closest('.lista').dataset.listaId;
        fetchListaDetails(listaId);
        abrirModal(modalLista);
    } else if (btnExcluir) {
        listaId = btnExcluir.closest('.lista').dataset.listaId;
        criarConfirmacao(
            'Excluir Lista?', 'Esta ação é irreversível. Deseja continuar?', () => { deleteLista(listaId) }, () => {}
        );
    } else {
        return;
    }
});