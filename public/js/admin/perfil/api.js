async function savePerfil() {
    try {
        const url = '/api/admin/perfil/identidade';

        const formData = new FormData(document.querySelector('#perfil-form'));

        formData.append('_method', 'PUT');

        const response = await fetch(url, {
            method: 'POST',
            headers: {
                'Authorization': BEARER,
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: formData
        });

        if (!response.ok) {
            const errorData = await response.json();
            throw new Error(errorData.message || `HTTP error! status: ${response.status}`);
        }

        const data = await response.json();

        if (data) {
            alert('Perfil salvo com sucesso!');

            displayNome.textContent = data.nome;

            if (data.foto_perfil) {
                displayFotoContainer.innerHTML = `<img src="${storageUrl}/${data.foto_perfil}" alt="Foto de Perfil">`;
            } else {
                displayFotoContainer.innerHTML = '';
            }
            
            fecharModal(modalPerfil);
        } else {
            alert('Erro ao processar a resposta do servidor.');
        }

    } catch (error) {
        console.error('Erro ao salvar perfil:', error);
        alert('Erro ao salvar perfil: ' + error.message);
    }
}

async function saveInformacoes() {
    try {
        const url = '/api/admin/perfil/informacoes';

        const formData = new FormData(document.querySelector('#informacoes-form'));

        formData.append('_method', 'PUT');

        const response = await fetch(url, {
            method: 'POST',
            headers: {
                'Authorization': BEARER,
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: formData
        });

        if (!response.ok) {
            const errorData = await response.json();
            throw new Error(errorData.message || `HTTP error! status: ${response.status}`);
        }

        const data = await response.json();

        if (data) {
            alert('Informações salvas com sucesso!');

            displayEmail.textContent = data.email;

            if (data.telefone) {
                displayTelefone.textContent = data.telefone;
            } else {
                displayTelefone.textContent = '(Não informado)';
            }
            
            if (data.endereco) {
                displayEndereco.textContent = data.endereco;
            } else {
                displayEndereco.textContent = '(Não informado)';
            }
            
            if (data.data_nascimento) {
                displayData.textContent = formatarDataAnoPortugues(data.data_nascimento);
            } else {
                displayData.textContent = '(Não informado)';
            }
            
            fecharModal(modalInformacoes);
        } else {
            alert('Erro ao processar a resposta do servidor.');
        }
    } catch (error) {
        console.error('Erro ao salvar informações:', error);
        alert('Erro ao salvar informações: ' + error.message);
    }
}