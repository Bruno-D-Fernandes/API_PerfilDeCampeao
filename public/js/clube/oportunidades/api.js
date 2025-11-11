async function apiCriarOportunidade(payload) {
    const token = getTokenClube();
    if (!token) {
        throw new Error('Você não está autenticado como clube.');
    }

    const response = await fetch('/api/clube/oportunidade', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Authorization': token,
        },
        body: JSON.stringify(payload),
    });

    const data = await response.json();
    return { ok: response.ok, data };
}

async function apiCarregarEsportes() {
    const token = getTokenClube();
    if (!token) {
        throw new Error('Sem token do clube. Faça login primeiro.');
    }

    const response = await fetch('/api/clube/esporte', {
        method: 'GET',
        headers: {
            'Authorization': token,
            'Accept': 'application/json',
        },
    });

    const data = await response.json();
    return { ok: response.ok, data };
}

async function apiCarregarPosicoes(idEsporte) {
    const token = getTokenClube();
    if (!token) {
        throw new Error('Sem token do clube. Faça login primeiro.');
    }

    const response = await fetch(`/api/clube/posicao?idEsporte=${encodeURIComponent(idEsporte)}`, {
        method: 'GET',
        headers: {
            'Authorization': token,
            'Accept': 'application/json',
        },
    });

    const data = await response.json();
    return { ok: response.ok, data };
}

async function apiBuscarCep(cepLimpo) {
    const response = await fetch(`https://viacep.com.br/ws/${cepLimpo}/json/`);
    if (!response.ok) {
        throw new Error('Erro de rede ou na API do ViaCEP.');
    }
    return response.json();
}