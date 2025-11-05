closeModalBtns.forEach(btn => {
    btn.addEventListener('click', () => {
        const tgt = btn.dataset.modalTarget;
        fecharModal(modais[tgt]);
    });
});

addUsuarioBtn.addEventListener('click', () => {
    usuarioId = -1;
    readOnly = false;
    enableInputs();
    abrirModal(modalUsuario);
});

salvarUsuarioBtn.addEventListener('click', () => {
    if(usuarioId !== -1) saveUsuario(usuarioId); 
    else saveUsuario();
});

cancelarUsuarioBtn.addEventListener('click', () => fecharModal(modalUsuario));

usuarios.addEventListener('click', (e) => {
    const btnEditar = e.target.closest('.usuario-editar-btn');
    const btnVer = e.target.closest('.usuario-ver-btn');
    const btnExcluir = e.target.closest('.usuario-excluir-btn');

    if (btnEditar) {
        readOnly = false;
        usuarioId = btnEditar.closest('.usuario').dataset.usuarioId;
        enableInputs();
        fetchUsuarioDetails(usuarioId);
        abrirModal(modalUsuario);
    } else if (btnVer) {
        readOnly = true;
        usuarioId = btnVer.closest('.usuario').dataset.usuarioId;
        disableInputs();
        unhideFormImgs();
        fetchUsuarioDetails(usuarioId);
        abrirModal(modalUsuario);
    } else if (btnExcluir) {
        readOnly = false;
        usuarioId = btnExcluir.closest('.usuario').dataset.usuarioId;
        criarConfirmacao('Deseja excluir este usuário?', 'Essa ação é irreversível.', () => deleteUsuario(usuarioId), () => {});
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