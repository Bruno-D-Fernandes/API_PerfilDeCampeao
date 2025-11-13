function handleCepBlur() {
    let cep = cepInputEl.value;
    cep = cep.replace(/\D/g, '');

    if (cep.length !== 8) {
        limparEnderecoOportunidade();
        showError('CEP inválido. Deve conter 8 dígitos.');
        return;
    }


    const cidadeInput = document.getElementById('cidadeOportunidade');
    if (cidadeInput) cidadeInput.value = '...';

    apiBuscarCep(cep)
        .then(data => {
            if (!data.erro) {
                setEnderecoOportunidade({
                    cidade: data.localidade || '',
                    logradouro: data.logradouro || '',
                    uf: data.uf || ''
                });
            } else {
                limparEnderecoOportunidade();
                showError('CEP não encontrado.');
            }
        })
        .catch(err => {
            logError('Erro ao buscar o CEP:', err);
            showError('Não foi possível buscar o CEP agora.');
        });
}


async function handleSubmitOportunidade(event) {
    event.preventDefault();

    const payload = getFormPayload(formOportunidadesEl);

    try {
        const { ok, data } = await apiCriarOportunidade(payload);

        if (!ok) {
            logError('Erro API:', data);
            showError(data.message || data.error || 'Erro ao criar oportunidade.');
            return;
        }

        // ==========================================
        // 🔧 LINHAS ADICIONADAS PARA CORRIGIR:
        // ==========================================
        
        // 1. Fechar o modal do Bootstrap que está aberto
        const modalElement = document.getElementById('modalOportunidades');
        if (modalElement) {
            const modal = bootstrap.Modal.getInstance(modalElement);
            if (modal) {
                modal.hide(); // Fecha o modal do Bootstrap
            }
        }
        
        // 2. Agora sim, abrir o seu modal customizado
        const addModal = document.getElementById('addModal');
        addModal.style.display = 'flex';
        
        // 3. Recarregar após 2 segundos
        setTimeout(() => {
            window.location.reload();
        }, 2000);

        console.log('Criado:', data);

    } catch (err) {
        logError('Erro inesperado ao enviar oportunidade:', err);
        showError('Erro inesperado ao enviar oportunidade.');
    }
}


async function handleEsporteChange() {
    const idEsporte = esporteSelectEl.value;

    if (!idEsporte) {
        resetPosicaoSelectSemEsporte();
        return;
    }

    resetPosicaoSelectCarregando();

    try {
        const { ok, data } = await apiCarregarPosicoes(idEsporte);

        if (!ok) {
            logError('Erro ao buscar posições:', data);
            showError('Erro ao carregar posições.');
            return;
        }

        fillPosicaoSelect(data);
    } catch (err) {
        logError('Falha na requisição /api/clube/posicao:', err);
        showError('Não foi possível carregar posições agora.');
    }
}


async function initEsportes() {
    try {
        const { ok, data } = await apiCarregarEsportes();

        if (!ok) {
            logError('Erro ao buscar esportes:', data);
            showError('Erro ao carregar esportes.');
            return;
        }

        fillEsporteSelect(data);
    } catch (err) {
        logError('Falha na requisição /api/clube/esporte:', err);
        showError('Não foi possível carregar esportes agora.');
    }
}


document.addEventListener('DOMContentLoaded', function () {
    if (cepInputEl) {
        cepInputEl.addEventListener('blur', handleCepBlur);
    }

    if (formOportunidadesEl) {
        formOportunidadesEl.addEventListener('submit', handleSubmitOportunidade);
    }

    if (esporteSelectEl) {
        esporteSelectEl.addEventListener('change', handleEsporteChange);
    }

    initEsportes();
});