async function saveOportunidade(oportunidadeId = null) {
    const editMode = oportunidadeId !== null;

    try {
        const url =
            "../api/clube/oportunidade/" + (editMode ? oportunidadeId : "");

        const formData = new FormData(
            document.querySelector("#oportunidade-form")
        );

        if (editMode) {
            formData.append("_method", "PUT");
        }

        const response = await fetch(url, {
            method: "POST",
            headers: {
                Authorization: BEARER,
                "X-CSRF-TOKEN": csrfToken,
                Accept: "application/json",
            },
            body: formData,
        });

        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }

        const data = await response.json();

        if (!data.error || !data.errors) {
            const erroModal = document.getElementById("opoModal");
            erroModal.style.display = "flex";
            setTimeout(() => {
                erroModal.style.display = "none";
            }, 1000);
            setTimeout(() => {}, 1000);

            if (!editMode) {
                oportunidades.appendChild(createOportunidadeRow(data));
            } else {
                const oldRow = oportunidades.querySelector(
                    `.opportunity[data-oportunidade-id="${oportunidadeId}"]`
                );
                const newRow = createOportunidadeRow(data.data);
                oportunidades.replaceChild(newRow, oldRow);
            }

            fecharModal(modalOportunidade);
        }
    } catch (error) {
        console.error("Erro ao salvar oportunidade:", error);
        const erroModal = document.getElementById("erro2Modal");
        erroModal.style.display = "flex";
        setTimeout(() => {
            erroModal.style.display = "none";
        }, 1000);
        setTimeout(() => {}, 1000);
    }
}

async function saveMembro() {
    const usuarioId =
        modalAdicionarMembro.content.querySelector(".user-selected").dataset
            .usuarioId;

    const esporteId = modalAdicionarMembro.content.querySelector(
        "#adicionar-membro-form-esporte"
    ).value;

    const funcaoId = modalAdicionarMembro.content.querySelector(
        "#adicionar-membro-form-funcao"
    ).value;

    const formData = new FormData();
    formData.append("esporte_id", esporteId);
    formData.append("funcao_id", funcaoId);

    try {
        const url = `../api/clube/${clubeId}/membros/${usuarioId}`;

        const response = await fetch(url, {
            method: "POST",
            headers: {
                Authorization: BEARER,
                "X-CSRF-TOKEN": csrfToken,
                Accept: "application/json",
            },
            body: formData,
        });

        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }

        const data = await response.json();
        const addModal = document.getElementById("addModal");
        const espModal = document.getElementById("esporteModal");

        if (!data.error && !data.errors) {
            fecharModal(modalAdicionarMembro);
            searchMembers("");
            addModal.style.display = "flex";
            setTimeout(() => {
                addModal.style.display = "none";
            }, 1000);
            setTimeout(() => {}, 1000);
        } else {
            console.error("Erro retornado pela API:", data);
            espModal.style.display = "flex";
            setTimeout(() => {
                espModal.style.display = "none";
            }, 1000);
            setTimeout(() => {}, 1000);
        }
    } catch (error) {
        console.error("Erro ao salvar membro:", error);
        espModal.style.display = "flex";
        setTimeout(() => {
            espModal.style.display = "none";
        }, 1000);
        setTimeout(() => {}, 1000);
    }
}

async function saveClube(clubeId = null) {
    const editMode = clubeId !== null;

    try {
        const url = editMode
            ? `../api/clube/${clubeId}`
            : "../api/admin/clube/";

        const form = document.querySelector("#clube-form");
        const formData = new FormData(form);

        if (editMode) formData.append("_method", "PUT");

        const response = await fetch(url, {
            method: "POST",
            headers: {
                Authorization: BEARER,
                "X-CSRF-TOKEN": csrfToken,
                Accept: "application/json",
            },
            body: formData,
        });

        if (!response.ok)
            throw new Error(`HTTP error! status: ${response.status}`);

        const data = await response.json();

        if (data.error || data.errors) {
            console.error("Erro ao salvar clube:", data);
            alert("Erro ao salvar informações do clube");
            return;
        }

        updateClube(data.data || data);
        const espModal = document.getElementById("clubesalvoModal");

        espModal.style.display = "flex";
        setTimeout(() => {
            espModal.style.display = "none";
        }, 1000);
        setTimeout(() => {}, 1000);

        fecharModal(modalClube);
    } catch (error) {
        console.error("Erro ao salvar clube:", error);
        alert("Erro ao salvar informações do clube");
    }
}

async function fetchOportunidadeDetails(oportunidadeId) {
    try {
        const response = await fetch(
            `../api/clube/oportunidade/${oportunidadeId}`,
            {
                headers: {
                    Authorization: BEARER,
                    "X-CSRF-TOKEN": csrfToken,
                    "Content-Type": "application/json",
                    Accept: "application/json",
                },
            }
        );

        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }

        const data = await response.json();

        console.log(data);

        modalOportunidade.inputs[0].value = data.descricaoOportunidades;
        modalOportunidade.inputs[1].value = data.datapostagemOportunidades;
        modalOportunidade.inputs[2].value = data.esporte.id;

        await loadEsportesData();

        populatePosicoes(data.esporte.id, data.posicao.id);

        modalOportunidade.inputs[3].value = data.posicao.id;

        modalOportunidade.inputs[4].value = data.idadeMinima;
        modalOportunidade.inputs[5].value = data.idadeMaxima;
        modalOportunidade.inputs[6].value = data.enderecoOportunidade;
        modalOportunidade.inputs[7].value = data.cidadeOportunidade;
        modalOportunidade.inputs[8].value = data.estadoOportunidade;
        modalOportunidade.inputs[9].value = data.cepOportunidade;
    } catch (error) {
        console.error("Erro ao buscar detalhes da oportunidade:", error);
        oportunidadeModalTitle.textContent = "Erro ao carregar oportunidade";
    }
}

async function fetchInscritos(oportunidadeId) {
    try {
        const url = `../api/clube/oportunidade/${oportunidadeId}/inscritos`;

        const response = await fetch(url, {
            headers: {
                Authorization: BEARER,
                "X-CSRF-TOKEN": csrfToken,
                Accept: "application/json",
            },
        });

        if (!response.ok)
            throw new Error(`HTTP error! status: ${response.status}`);

        const data = await response.json();

        renderInscritosList(data.data || data);
    } catch (error) {
        console.error("Erro ao buscar inscritos:", error);
        const body = modalInscritos.content.querySelector("#inscritos-list");
        body.innerHTML =
            '<div class="no-data"><span>Erro ao carregar inscritos</span></div>';
    }
}

async function fetchClubeDetails(clubeId) {
    try {
        const response = await fetch(`../api/clube/${clubeId}`, {
            headers: {
                Authorization: BEARER,
                "X-CSRF-TOKEN": csrfToken,
                "Content-Type": "application/json",
                Accept: "application/json",
            },
        });

        if (!response.ok)
            throw new Error(`HTTP error! status: ${response.status}`);

        const data = await response.json();

        modalClube.inputs[0].value = data.nomeClube;
        modalClube.inputs[1].value = data.anoCriacaoClube;
        modalClube.inputs[2].value = data.enderecoClube;
        modalClube.inputs[3].value = data.cidadeClube;
        modalClube.inputs[4].value = data.estadoClube;
        modalClube.inputs[5].value = data.bioClube;
        modalClube.inputs[6].value = data.categoria.id;
        modalClube.inputs[7].value = data.esporte.id;

        if (data.fotoPerfilClube) {
            previewImagem.src = storageUrl + "/" + data.fotoPerfilClube;
            previewImagem.style.display = "block";
        } else {
            previewImagem.src = "";
            previewImagem.style.display = "none";
        }

        if (data.fotoBannerClube) {
            previewImagemBanner.src = storageUrl + "/" + data.fotoBannerClube;
            previewImagemBanner.style.display = "block";
        } else {
            previewImagemBanner.src = "";
            previewImagemBanner.style.display = "none";
        }
    } catch (error) {
        console.error("Erro ao buscar detalhes do clube:", error);
        alert("Erro ao carregar dados do clube");
    }
}

async function searchUsers(query) {
    if (searchUserContainer.classList.contains("hidden")) {
        searchUserContainer.classList.remove("hidden");
        hideUserNeeded();
    }

    const url = `../api/search-usuarios?pesquisa=${
        query ? encodeURIComponent(query) : ""
    }`;

    try {
        const response = await fetch(url, {
            headers: {
                Authorization: BEARER,
                "X-CSRF-TOKEN": csrfToken,
                "Content-Type": "application/json",
                Accept: "application/json",
            },
        });

        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }

        const data = await response.json();

        searchUserContainer.innerHTML = "";

        renderUsersList(data.data);
    } catch (error) {
        console.error("Erro ao buscar usuários:", error);
    }
}

async function searchMembers(query) {
    try {
        const response = await fetch(
            `../api/clube/${clubeId}/membros?search=${encodeURIComponent(
                query
            )}`,
            {
                headers: {
                    Authorization: BEARER,
                    "X-CSRF-TOKEN": csrfToken,
                    "Content-Type": "application/json",
                    Accept: "application/json",
                },
            }
        );

        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }

        const data = await response.json();

        console.log(data);

        renderMembersList(data);
    } catch (error) {
        console.error("Erro ao buscar membros do clube:", error);
    }
}

async function deleteOportunidade(oportunidadeId) {
    try {
        const url = "../api/clube/oportunidade/" + oportunidadeId;

        const response = await fetch(url, {
            method: "DELETE",
            headers: {
                Authorization: BEARER,
                "X-CSRF-TOKEN": csrfToken,
                Accept: "application/json",
            },
        });

        if (response.ok) {
            if (response.status === 204) {
                oportunidades
                    .querySelector(
                        `.opportunity[data-oportunidade-id="${oportunidadeId}"]`
                    )
                    ?.remove();
                const erroModal = document.getElementById("erroModal");
                erroModal.style.display = "flex";
                setTimeout(() => {
                    erroModal.style.display = "none";
                }, 1000);
                setTimeout(() => {}, 1000);
            } else {
                const data = await response.json();

                if (data.error || data.errors) {
                    console.error("Erro retornado pela API:", data);
                    alert("Erro ao excluir oportunidade");
                } else {
                    const erroModal = document.getElementById("erroModal");
                    erroModal.style.display = "flex";
                    setTimeout(() => {
                        erroModal.style.display = "none";
                    }, 1000);
                    setTimeout(() => {}, 1000);
                    oportunidades
                        .querySelector(
                            `.opportunity[data-oportunidade-id="${oportunidadeId}"]`
                        )
                        ?.remove();
                }
            }
        } else {
            console.error("Erro HTTP:", response.status, response.statusText);

            try {
                const errorData = await response.json();
                alert(
                    `Erro ao excluir oportunidade: ${
                        errorData.message || response.statusText
                    }`
                );
            } catch (jsonError) {
                alert(`Erro ao excluir oportunidade: ${response.statusText}`);
            }
        }
    } catch (error) {
        console.error("Erro ao excluir oportunidade:", error);
        alert("Erro ao excluir oportunidade!");
    }
}

async function deleteInscrito(oportunidadeId, usuarioId) {
    try {
        const url = `../api/clube/oportunidade/${oportunidadeId}/inscricoes/${usuarioId}/remover`;

        const formData = new FormData();

        const response = await fetch(url, {
            method: "POST",
            headers: {
                Authorization: BEARER,
                "X-CSRF-TOKEN": csrfToken,
                Accept: "application/json",
            },
            body: formData,
        });

        if (!response.ok)
            throw new Error(`HTTP error! status: ${response.status}`);

        const data = await response.json();

        if (data.error || data.errors) {
            console.error("Erro ao remover inscrito:", data);
            alert("Erro ao remover inscrito");
        } else {
            alert("Inscrito removido com sucesso!");
            fetchInscritos(oportunidadeId);
        }
    } catch (error) {
        console.error("Erro ao remover inscrito:", error);
        alert("Erro ao remover inscrito");
    }
}

async function deleteMembro(membroId) {
    try {
        const row = document.querySelector(
            `.members-list-row[data-member-id="${membroId}"]`
        );

        const esporteId = row.dataset.esporteId;
        const funcaoId = row.dataset.funcaoId;

        const url = `../api/clube/${clubeId}/membros/${membroId}`;

        const formData = new FormData();

        formData.append("esporte_id", esporteId);
        formData.append("funcao_id", funcaoId);

        formData.append("_method", "DELETE");

        const response = await fetch(url, {
            method: "POST",
            headers: {
                Authorization: BEARER,
                "X-CSRF-TOKEN": csrfToken,
                Accept: "application/json",
            },
            body: formData,
        });

        if (response.ok) {
            if (response.status === 204) {
                const caraModal = document.getElementById("caraModal");
                caraModal.style.display = "flex";
                setTimeout(() => {
                    caraModal.style.display = "none";
                }, 1000);
                setTimeout(() => {}, 1000);
            } else {
                const data = await response.json();
                if (data.error || data.errors) {
                    console.error("Erro retornado pela API:", data);
                    alert("Erro ao remover membro");
                } else {
                    const caraModal = document.getElementById("caraModal");
                    caraModal.style.display = "flex";
                    setTimeout(() => {
                        caraModal.style.display = "none";
                    }, 1000);
                    setTimeout(() => {}, 1000);
                }
            }

            searchMembers("");
        } else {
            console.error("Erro HTTP:", response.status, response.statusText);
            try {
                const errorData = await response.json();
                alert(
                    `Erro ao remover membro: ${
                        errorData.message || response.statusText
                    }`
                );
            } catch (jsonError) {
                alert(`Erro ao remover membro: ${response.statusText}`);
            }
        }
    } catch (error) {
        console.error("Erro ao remover membro:", error);
        alert("Erro ao remover membro!");
    }
}

async function loadEsportesData() {
    if (esportesData) return esportesData;

    try {
        const response = await fetch("../api/esporte", {
            headers: {
                Accept: "application/json",
            },
        });

        if (!response.ok)
            throw new Error(`HTTP error! status: ${response.status}`);

        const data = await response.json();

        esportesData = data;

        return esportesData;
    } catch (error) {
        console.error("Erro ao carregar esportes:", error);

        esportesData = [];

        return esportesData;
    }
}
