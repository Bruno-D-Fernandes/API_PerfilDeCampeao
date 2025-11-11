closeModalBtns.forEach(btn => {
    btn.addEventListener('click', () => {
        const tgt = btn.dataset.modalTarget;
        fecharModal(modais[tgt]);
    });
});

mainTabBtns.forEach(tabBtn => {
    tabBtn.addEventListener('click', () => {
        mainTabContents.forEach(tc => tc.classList.remove('active'));
        document.querySelector(`#${tabBtn.dataset.targetTab}`).classList.add('active');
    });
});

subTabBtns.forEach(subTabBtn => {
    subTabBtn.addEventListener('click', () => {
        const targetContentId = subTabBtn.dataset.targetSubtab;
        const parentTabContent = subTabBtn.closest('.tab-content');
        
        parentTabContent.querySelectorAll('.sub-tab-content').forEach(content => content.classList.remove('active'));

        document.querySelector(`#${targetContentId}`).classList.add('active');
    });
});


abrirListasBtn.addEventListener('click', async () => {
    await fetchListasDoClube();
    abrirModal(modalListas);
});

addListaBtn.addEventListener('click', () => {
    fecharModal(modalListas);
    abrirModal(modalCriarLista);
});

criarListaSalvarBtn.addEventListener('click', () => {
    saveNovaLista();
});

criarListaCancelarBtn.addEventListener('click', () => {
    fecharModal(modalCriarLista);
});

listasContainer.addEventListener('change', (e) => {
    if (e.target.matches('input[type="checkbox"]')) {
        const checkbox = e.target;
        
        const listaId = checkbox.closest('.lista-item').dataset.listaId;
        
        const adicionar = checkbox.checked;
        
        toggleUsuarioNaLista(listaId, adicionar);
    }
});