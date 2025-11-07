closeModalBtns.forEach(btn => {
    btn.addEventListener('click', () => {
        const tgt = btn.dataset.modalTarget;
        fecharModal(modais[tgt]);
    });
});

addClubeBtn.addEventListener('click', () => {
    clubeId = -1;
    readOnly = false;
    enableInputys();
    abrirModal(modalClube);
});

salvarClubeBtn.addEventListener('click', () => {
    if(clubeId !== -1) saveClube(clubeId); 
    else saveClube();
});

cancelarClubeBtn.addEventListener('click', () => fecharModal(modalClube));

clubes.addEventListener('click', (e) => {
    const btnEditar = e.target.closest('.clube-editar-btn');
    const btnVer = e.target.closest('.clube-ver-btn');
    const btnExcluir = e.target.closest('.clube-excluir-btn');

    if (btnEditar) {
        readOnly = false;
        clubeId = btnEditar.closest('.clube').dataset.clubeId;
        enableInputs();
        fetchClubeDetails(clubeId);
        abrirModal(modalClube);
    } else if (btnVer) {
        readOnly = true;
        clubeId = btnVer.closest('.clube').dataset.clubeId;
        disableInputs();
        unhideFormImgs();
        fetchClubeDetails(clubeId);
        abrirModal(modalClube);
    } else if (btnExcluir) {
        readOnly = false;
        clubeId = btnExcluir.closest('.clube').dataset.clubeId;
        criarConfirmacao('Deseja excluir este clube?', 'Essa ação é irreversível.', () => deleteClube(clubeId), () => {});
    } else {
        return;
    }
});

inputImagem.addEventListener('change', function(e) {
    if (e.target.files && e.target.files[0]) {
        const file = e.target.files[0];

        if (!file.type.startsWith('image/')) {
            console.error("O arquivo selecionado não é uma imagem.");
            previewImagem.src = "";
            previewImagem.style.display = 'none';
            return;
        }

        const reader = new FileReader();

        reader.onload = function(ev) {
            previewImagem.src = ev.target.result;
            previewImagem.style.display = 'block';
        };

        reader.readAsDataURL(file);
    }
});

inputImagemBanner.addEventListener('change', function(e) {
    if (e.target.files && e.target.files[0]) {
        const file = e.target.files[0];

        if (!file.type.startsWith('image/')) {
            console.error("O arquivo selecionado não é uma imagem.");
            previewImagemBanner.src = "";
            previewImagemBanner.style.display = 'none';
            return;
        }

        const reader = new FileReader();

        reader.onload = function(ev) {
            previewImagemBanner.src = ev.target.result;
            previewImagemBanner.style.display = 'block';
        };

        reader.readAsDataURL(file);
    }
});