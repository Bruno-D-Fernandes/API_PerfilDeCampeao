closeModalBtns.forEach(btn => {
    btn.addEventListener('click', () => {
        const modalTarget = btn.dataset.modalTarget;
        fecharModal(modais[modalTarget]);
    });
});

editarPerfilBtn.addEventListener('click', () => {
    const nomeInput = modais['perfil-modal'].inputs[0];
    
    nomeInput.value = displayNome.textContent.trim();
    
    const fotoAtual = displayFotoContainer.querySelector('img');

    if (fotoAtual) {
        previewFoto.src = fotoAtual.src;
        previewFoto.style.display = 'block';
    } else {
        previewFoto.style.display = 'none';
    }



    
    abrirModal(modalPerfil);
});

perfilSalvarBtn.addEventListener('click', () => {
    savePerfil();
});

perfilCancelarBtn.addEventListener('click', () => {
    fecharModal(modalPerfil);
});

inputFoto.addEventListener('change', function(e) {
    if (e.target.files && e.target.files[0]) {
        const file = e.target.files[0];

        if (!file.type.startsWith('image/')) {
            console.error("O arquivo selecionado não é uma imagem.");
            previewFoto.src = "";
            previewFoto.style.display = 'none';
            return;
        }

        const reader = new FileReader();

        reader.onload = function(ev) {
            previewFoto.src = ev.target.result;
            previewFoto.style.display = 'block';
        };

        reader.readAsDataURL(file);
    }
});


editarInformacoesBtn.addEventListener('click', () => {
    const emailInput = modais['informacoes-modal'].inputs[0];
    const telefoneInput = modais['informacoes-modal'].inputs[1];
    const enderecoInput = modais['informacoes-modal'].inputs[2];
    const dataInput = modais['informacoes-modal'].inputs[3];

    emailInput.value = displayEmail.textContent.trim();

    telefoneInput.value = (displayTelefone.textContent === '(Não informado)') ? '' : displayTelefone.textContent.trim();
    enderecoInput.value = (displayEndereco.textContent === '(Não informado)') ? '' : displayEndereco.textContent.trim();
    
    dataInput.value = ''; 

    abrirModal(modalInformacoes);
});

informacoesSalvarBtn.addEventListener('click', () => {
    saveInformacoes();
});

informacoesCancelarBtn.addEventListener('click', () => {
    fecharModal(modalInformacoes);
});

confirmarCancelarBtn.addEventListener('click', () => {
    fecharModal(modalConfirmar);
});

confirmarSalvarBtn.addEventListener('click', () => {
    fecharModal(modalConfirmar);
});
document.querySelectorAll('.tabs button').forEach(button => {
    button.addEventListener('click', function() {
        const targetTab = this.getAttribute('data-target-tab');

        document.querySelectorAll('.tabs button').forEach(btn => {
            btn.classList.remove('active');
        });

        document.querySelectorAll('.tab-content').forEach(content => {
            content.classList.remove('active');
        });

        this.classList.add('active');

        const content = document.getElementById(targetTab);
        if (content) {
            content.classList.add('active');
        }
    });
});