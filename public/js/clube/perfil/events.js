document.addEventListener('click', (e) => {
    const openOptions = [...opportunityOptions].filter(opt => !opt.classList.contains('hidden'));

    if (openOptions.length === 0) return;

    openOptions.forEach(opt => {
        if (!opt.contains(e.target)) {
            opt.classList.add('hidden');
        }
    });
});

tabBtns.forEach(tabBtn => {
    tabBtn.addEventListener('click', async () => {
        if (tabBtn.dataset.targetTab === 'members-tab' && membersDataContainer.children.length === 0) {
            searchUsers('');
        }

        tabBtn.classList.add('active');

        document.querySelectorAll('.tab-content').forEach(tc => tc.classList.remove('active'));
        
        document.querySelector(`#${tabBtn.dataset.targetTab}`).classList.add('active');
    });
});

closeModalBtns.forEach(btn => {
    btn.addEventListener('click', () => {
        const tgt = btn.dataset.modalTarget;
        fecharModal(modais[tgt]);
    });
});

oportunidades.addEventListener('click', async (e) => {
    const btnOptions = e.target.closest('.see-details-btn');
    const btnEditar = e.target.closest('.oportunidade-editar-btn');
    const btnVer = e.target.closest('.oportunidade-ver-btn');
    const btnExcluir = e.target.closest('.oportunidade-excluir-btn');
    const btnInscritos = e.target.closest('.oportunidade-inscritos-btn');

    if (btnOptions) {
        e.stopPropagation();

        const opportunity = btnOptions.closest('.opportunity');
        const options = opportunity.querySelector('.opportunity-options');
        
        options.classList.toggle('hidden');
    } else if (btnEditar) {
        readOnly = false;

        oportunidadeId = btnEditar.closest('.opportunity').dataset.oportunidadeId;

        enableInputs();

        await fetchOportunidadeDetails(oportunidadeId);

        abrirModal(modalOportunidade);
    } else if (btnVer) {
        readOnly = true;

        oportunidadeId = btnVer.closest('.opportunity').dataset.oportunidadeId;

        disableInputs();

        await fetchOportunidadeDetails(oportunidadeId);

        oportunidadeModalTitle.textContent = 'Detalhes da oportunidade:';

        abrirModal(modalOportunidade);
    } else if (btnExcluir) {
        readOnly = false;

        oportunidadeId = btnExcluir.closest('.opportunity').dataset.oportunidadeId;

        oportunidadeModalTitle.textContent = 'Detalhes da oportunidade:';

        criarConfirmacao('Deseja excluir esta oportunidade?', 'Essa ação é irreversível.', () => deleteOportunidade(oportunidadeId), () => {});
    } else if (btnInscritos) {
        oportunidadeId = btnInscritos.closest('.opportunity').dataset.oportunidadeId;

        await fetchInscritos(oportunidadeId);

        abrirModal(modalInscritos);
    } else {
        return;
    }
});

addOportunidadeBtn.addEventListener('click', async () => {
    readOnly = false;
    oportunidadeId = -1;

    if (modalOportunidade.inputs) {
        modalOportunidade.inputs.forEach(inp => {
            if (!inp) return;
            if (inp.tagName === 'SELECT') inp.selectedIndex = 0;
            else inp.value = '';
        });
    }

    oportunidadeModalTitle.textContent = 'Criar oportunidade';

    const selectedEsporte = modalOportunidade.inputs && modalOportunidade.inputs[2] ? modalOportunidade.inputs[2].value : null;

    await loadEsportesData();

    populatePosicoes(selectedEsporte);

    enableInputs();

    abrirModal(modalOportunidade);
});

oportunidadeEsporteSelect.addEventListener('change', async (ev) => {
    await loadEsportesData();
    populatePosicoes(ev.target.value);
});

salvarOportunidadeBtn.addEventListener('click', () => {
    if(oportunidadeId !== -1) saveOportunidade(oportunidadeId); 
    else saveOportunidade();
});

cancelarOportunidadeBtn.addEventListener('click', () => fecharModal(modalOportunidade));

let timer;

searchInput.addEventListener('input', function() {
    const query = this.value;

    clearTimeout(timer);

    timer = setTimeout(() => {
        searchMembers(query);
    }, 300);
});

let timer2;

searchUserInput.addEventListener('input', function() {
    const query = this.value;

    clearTimeout(timer2);

    timer2 = setTimeout(() => {
        searchUsers(query);

        if (searchUserContainer.classList.contains('hidden')) {
            searchUserContainer.classList.remove('hidden')
        }
    }, 300);
});

addMembroBtn.addEventListener('click', () => {
    abrirModal(modalAdicionarMembro);

    hideUserNeeded();
});

clearSearchBtns.forEach(clearSearchBtn => {
    clearSearchBtn.addEventListener('click', () => {
        const clearTgt = clearSearchBtn.dataset.clearTarget;

        document.querySelector(`#${clearTgt}`).value = '';

        if (clearTgt === 'member-search-input') {
            if (row) row.remove();
        } else {
            searchUsers('');
            disableBtns();
        }
    });
});

membersDataContainer.addEventListener('click', (e) => {
    const btnVer = e.target.closest('.membro-ver-btn');
    const btnRemover = e.target.closest('.membro-excluir-btn');
    const row = e.target.closest('.members-list-row');

    if (!row) return;

    const memberId = row.dataset.memberId;

    if (btnVer) {
        window.location.href = `../usuarios/${memberId}`;
    } else if (btnRemover) {
        criarConfirmacao('Deseja remover este membro do clube?', 'Essa ação é irreversível.', () => deleteMembro(memberId), () => {});
    }
});

cancelarMembroBtn.addEventListener('click', () => {
    fecharModal(modalAdicionarMembro);
});

salvarMembroBtn.addEventListener('click', () => {
    saveMembro();
});

clubeEditarBtn.addEventListener('click', async () => {
    await fetchClubeDetails(clubeId);
    abrirModal(modalClube);
});

inputImagem.addEventListener('change', function(e) {
    if (e.target.files && e.target.files[0]) {
        const file = e.target.files[0];
        
        if (!file.type.startsWith('image/')) {
            previewImagem.src = '';
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
            previewImagemBanner.src = '';
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

cancelarClubeBtn.addEventListener('click', () => fecharModal(modalClube));
salvarClubeBtn.addEventListener('click', () => saveClube(clubeId));