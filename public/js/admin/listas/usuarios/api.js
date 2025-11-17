async function fetchUsuarioDetails(usuarioId) {
    try {
        const response = await fetch(`../api/usuario/${usuarioId}`, {
            headers: {
                'Authorization': BEARER,
                'X-CSRF-TOKEN': csrfToken,
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            }
        });

        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }

        const data = await response.json();

        console.log(data);
        
        usuarioModalTitle.textContent = `Detalhes do Usuario: ${data.nomeCompletoUsuario}`;

        if (data.fotoPerfilUsuario) {
            previewImagem.src = data.fotoPerfilUsuario;
            previewImagem.style.display = 'block';
        } 

        if (data.fotoBannerUsuario) {
            previewImagemBanner.src = data.fotoBannerUsuario;
            previewImagemBanner.style.display = 'block';
        }

        modalUsuario.inputs[0].value = data.nomeCompletoUsuario;
        modalUsuario.inputs[1].value = data.emailUsuario;
        document.querySelector('#usuario-form-genero').value = data.generoUsuario || '';
        modalUsuario.inputs[3].value = data.dataNascimentoUsuario;
        
        let dataNascimentoApi = data.dataNascimentoUsuario;
        let dataFormatada = '';

        if (dataNascimentoApi && typeof dataNascimentoApi === 'string' && dataNascimentoApi.length >= 10) {
            dataFormatada = dataNascimentoApi.substring(0, 10);
        }

        modalUsuario.inputs[3].value = dataFormatada;
        modalUsuario.inputs[4].value = data.cidadeUsuario;
        modalUsuario.inputs[5].value = data.estadoUsuario;
        modalUsuario.inputs[6].value = data.alturaCm;
        modalUsuario.inputs[7].value = data.pesoKg;
        modalUsuario.inputs[8].value = data.peDominante;
        modalUsuario.inputs[9].value = data.maoDominante;
    } catch (error) {
        console.error('Erro ao buscar detalhes do usuário:', error);
        usuarioModalTitle.textContent = "Erro ao carregar usuário";
    }
}

async function saveUsuario(usuarioId = null) {
    const editMode = usuarioId !== null;

    try {
        const url = editMode ? '../api/usuario/' + usuarioId : "../api/admin/usuario/";

        const formData = new FormData(document.querySelector('#usuario-form'));

        if (editMode) {
            formData.append('_method', 'PUT');
        }

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
            throw new Error(`HTTP error! status: ${response.status}`);
        }

        const data = await response.json();
        const addModal = document.getElementById('addModal');
            const editModal = document.getElementById('editModal');

        if(!data.error || !data.errors) {

            if (editMode) {
                editModal.style.display = 'flex';
                fecharModal(modalUsuario);
                setTimeout(() => {
                    editModal.style.display = 'none';
                    window.location.reload(true);
                }, 500);
            } else {
                addModal.style.display = 'flex';
                fecharModal(modalUsuario);
                setTimeout(() => {
                    addModal.style.display = 'none';
                    window.location.reload(true);
                }, 500);
            }

           
            
            fecharModal(modalUsuario);
        }                
    } catch (error) {
        setTimeout(() => {
        const addModal = document.getElementById('addModal');
        const erroModal = document.getElementById('erroModal');
        erroModal.style.display = 'flex';
        console.error('Erro ao salvar usuário:', error);
        setTimeout(() => {
                    erroModal.style.display = 'none';

                }, 1000);
                }, 700);

    }
}

async function deleteUsuario(usuarioId) {
    try {
        const url = "../api/usuario/" + usuarioId;

        const response = await fetch(url, {
            method: 'DELETE',
            headers: {
                'Authorization': BEARER,
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
        });

        if (response.ok) {
            const data = await response.json();

            if (data.error || data.errors) {
                console.error('Erro retornado pela API:', data);
                alert('Erro ao excluir usuário');
            } else {

                usuarios.querySelector(`.usuario[data-usuario-id="${usuarioId}"]`)?.remove();
            }
        } else {
            console.error('Erro HTTP:', response.status, response.statusText);

            try {
                const errorData = await response.json();
                alert(`Erro ao excluir usuário: ${errorData.message || response.statusText}`);
            } catch (jsonError) {
                alert(`Erro ao excluir usuário: ${response.statusText}`);
            }
        }          
    } catch (error) {
        console.error('Erro ao excluir usuário:', error);
        alert('Erro ao excluir usuário!');
    }
}