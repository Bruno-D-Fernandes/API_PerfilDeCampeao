function limparEnderecoOportunidade() {
    const cidadeInput = document.getElementById('cidadeOportunidade');
    const enderecoInput = document.getElementById('enderecoOportunidade');
    const estadoSelect = document.getElementById('estadoOportunidade');

    if (cidadeInput) cidadeInput.value = '';
    if (enderecoInput) enderecoInput.value = '';
    if (estadoSelect) estadoSelect.value = '';
}

function setEnderecoOportunidade({ cidade, logradouro, uf }) {
    const cidadeInput = document.getElementById('cidadeOportunidade');
    const enderecoInput = document.getElementById('enderecoOportunidade');
    const estadoSelect = document.getElementById('estadoOportunidade');

    if (cidadeInput) cidadeInput.value = cidade || '';
    if (enderecoInput) enderecoInput.value = logradouro || '';
    if (estadoSelect) estadoSelect.value = uf || '';
}

function getTokenClube() {
    return localStorage.getItem('clube_token');
}