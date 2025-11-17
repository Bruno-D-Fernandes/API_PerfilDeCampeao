function formatarDataPortugues(dataString) {
    let data;

    if (!dataString) {
        data = new Date();
    } else {
        data = new Date(dataString);
    }

    const dia = data.getUTCDate().toString().padStart(2, "0");
    const mes = data.toLocaleString("pt-BR", {
        month: "long",
        timeZone: "UTC",
    });

    return `${dia} de ${mes}`;
}

function formatarDataAnoPortugues(dataString) {
    let data;

    if (!dataString) {
        data = new Date();
    } else {
        data = new Date(dataString);
    }

    const dia = data.getUTCDate().toString().padStart(2, "0");
    const mes = data.toLocaleString("pt-BR", {
        month: "long",
        timeZone: "UTC",
    });
    const ano = data.getUTCFullYear();

    return `${dia} de ${mes} de ${ano}`;
}

function createOportunidadeRow(oportunidade) {
    const div = document.createElement("div");
    div.className = "opportunity";

    div.dataset.oportunidadeId = oportunidade.id;

    div.innerHTML = `
        <div class="opportunity-details">
            <span>
                ${oportunidade.posicao.nomePosicao}
            </span>
            <span>
                ${oportunidade.esporte.nomeEsporte}
            </span>
            <span>
                Sub - ${oportunidade.idadeMaxima}
            </span>
            <span>
                Interessados - ${oportunidade.candidatos.length}
            </span>
        </div>
        <button class="see-details-btn">
            <i class="fa-solid fa-ellipsis"></i>
        </button>
        <div class="opportunity-options hidden">
            <button class="oportunidade-ver-btn">
                <span>
                    Ver
                </span>
            </button>
            <button class="oportunidade-editar-btn">
                <span>
                    Editar 
                </span>
            </button>
            <button class="oportunidade-excluir-btn">
                <span>
                    Excluir
                </span>
            </button>
            <button class="oportunidade-inscritos-btn">
                <span>
                    Inscritos
                </span>
            </button>
        </div>
    `;
    return div;
}

function createMemberRow(id, nome, esporteId, funcaoId) {
    const div = document.createElement("div");

    div.className = "members-list-row";

    div.dataset.memberId = id;

    div.dataset.esporteId = esporteId;
    div.dataset.funcaoId = funcaoId;

    div.innerHTML = `
        <span class="member-name">${nome}</span>
        <div class="members-btns">
            <button class="membro-ver-btn"><span>Ver perfil</span></button>
            <button class="membro-excluir-btn"><span>Remover</span></button>
        </div>
    `;

    return div;
}

function populatePosicoes(esporteId, selectedPosicaoId = null) {
    const posSelect = document.querySelector("#oportunidade-form-posicao");

    if (!esporteId) {
        posSelect.innerHTML = `<option value="">Selecione uma posição</option>`;
        return;
    }

    const esporte = esportesData.find((e) => e.id == esporteId);

    if (!esporte || !esporte.posicoes) {
        posSelect.innerHTML = `<option value="">Nenhuma posição disponível</option>`;

        return;
    }

    posSelect.innerHTML = esporte.posicoes
        .map(
            (p) => `
        <option value="${p.id}" ${
                p.id == selectedPosicaoId ? "selected" : ""
            }>${p.nomePosicao}</option>
    `
        )
        .join("");
}

function updateClube(data) {
    const nomeEl = document.querySelector(".profile-name");
    const bioEl = document.querySelector(".profile-bio");

    nomeEl.textContent = data.nomeClube || nomeEl.textContent;

    bioEl.textContent = data.bioClube || bioEl.textContent;

    const bannerEl = document.querySelector(".profile-imgs .banner");

    const pictureEl = document.querySelector(".profile-imgs .picture");

    if (data.fotoBannerClube)
        bannerEl.innerHTML = `<img src="${storageUrl}/${data.fotoBannerClube}" alt="banner" />`;
    else bannerEl.innerHTML = "";

    if (data.fotoPerfilClube)
        pictureEl.innerHTML = `<img src="${storageUrl}/${data.fotoPerfilClube}" alt="foto" />`;
    else pictureEl.innerHTML = "";

    const aboutPs = document.querySelectorAll(".about-container .info p");

    try {
        aboutPs[0].textContent = data.anoCriacaoClube
            ? formatarDataAnoPortugues(data.anoCriacaoClube)
            : "";
    } catch (e) {
        aboutPs[0].textContent = data.anoCriacaoClube || "";
    }

    aboutPs[1].textContent = data.esporte.nomeEsporte;
    aboutPs[2].textContent = data.categoria.nomeCategoria;
    aboutPs[3].innerHTML = `${data.enderecoClube}<br>${data.cidadeClube} - ${data.estadoClube}`;
    aboutPs[4].textContent = data.emailClube;
    aboutPs[5].textContent = data.cnpjClube;
}

function renderInscritosList(inscritos) {
    const listContainer =
        modalInscritos.content.querySelector("#inscritos-list");

    if (inscritos.length === 0) {
        listContainer.innerHTML = `<div class="no-data"><span>Sem dados para mostrar</span></div>`;
        return;
    }

    let html = "";

    inscritos.forEach((inscrito) => {
        html += `
            <div class="inscrito-row" data-usuario-id="${inscrito.id}">
                <span>${
                    inscrito.usuario.nomeCompletoUsuario ||
                    inscrito.nome ||
                    "Usuário"
                }</span> <br><br>
                <div class="members-btns">
                    <button class="inscrito-ver-btn" data-usuario-id="${
                        inscrito.usuario.id
                    }"><span>Ver perfil</span></button>
                    <button class="inscrito-remover-btn" data-usuario-id="${
                        inscrito.usuario.id
                    }"><span>Remover</span></button>
                </div>
            </div>
        `;
    });

    listContainer.innerHTML = html;

    listContainer.querySelectorAll(".inscrito-ver-btn").forEach((btn) => {
        btn.addEventListener("click", (e) => {
            const id = btn.dataset.usuarioId;
            window.location.href = `../usuarios/${id}`;
        });
    });

    listContainer.querySelectorAll(".inscrito-remover-btn").forEach((btn) => {
        btn.addEventListener("click", (e) => {
            const usuarioId = btn.dataset.usuarioId;

            criarConfirmacao(
                "Remover inscrito?",
                "Deseja remover este inscrito da oportunidade?",
                () => deleteInscrito(oportunidadeId, usuarioId),
                () => {}
            );
        });
    });
}

function renderMembersList(membrosAgrupados) {
    let htmlContent = "";

    const hasData = Object.keys(membrosAgrupados).length > 0;

    if (!hasData) {
        htmlContent = `
            <div class="no-data">
                <span>
                    Sem dados para mostrar
                </span>
            </div>
        `;
    } else {
        for (const esporteNome in membrosAgrupados) {
            if (membrosAgrupados.hasOwnProperty(esporteNome)) {
                htmlContent += `
                    <span>
                        ${esporteNome}:
                    </span>
                `;

                const funcoesNoEsporte = membrosAgrupados[esporteNome];

                for (const funcaoNome in funcoesNoEsporte) {
                    if (funcoesNoEsporte.hasOwnProperty(funcaoNome)) {
                        htmlContent += `
                            <div class="members-list-group-function">
                                <span>
                                    ${funcaoNome}:
                                </span>

                                <div class="members-list-rows">
                        `;

                        const membros = funcoesNoEsporte[funcaoNome];

                        membros.forEach((membro) => {
                            const esporteId =
                                membro.pivot && membro.pivot.esporte_id
                                    ? membro.pivot.esporte_id
                                    : membro.esporte
                                    ? membro.esporte.id
                                    : membro.esporte_id || "";
                            const funcaoId =
                                membro.pivot && membro.pivot.funcao_id
                                    ? membro.pivot.funcao_id
                                    : membro.funcao
                                    ? membro.funcao.id
                                    : membro.funcao_id || "";
                            htmlContent += `
                                    <div class="members-list-row" data-member-id="${membro.id}" data-esporte-id="${esporteId}" data-funcao-id="${funcaoId}">
                                        <span class="member-name">
                                            ${membro.nomeCompletoUsuario}
                                        </span>

                                        <div class="members-btns">
                                            <button class="membro-ver-btn">
                                                <span>
                                                    Ver perfil
                                                </span>
                                            </button>

                                            <button class="membro-excluir-btn">
                                                <span>
                                                    Remover
                                                </span>
                                            </button>
                                        </div>
                                    </div>
                            `;
                        });
                        htmlContent += `
                                </div> 
                            </div>
                        `;
                    }
                }
            }
        }
    }

    membersDataContainer.innerHTML = htmlContent;
}

function renderUsersList(usuarios) {
    let htmlContent = "";

    const hasData = usuarios.length > 0;

    if (hasData) {
        for (const usuario of usuarios) {
            htmlContent += `
                <div class="search-user-row" 
                    data-id="${usuario.id}" 
                    data-nome="${usuario.nomeCompletoUsuario}" 
                    data-img="${usuario.fotoPerfilUsuario}">
                    <span>${usuario.nomeCompletoUsuario}</span>
                </div>
            `;
        }
    }

    searchUserContainer.innerHTML = htmlContent;

    const userRows = searchUserContainer.querySelectorAll(".search-user-row");

    userRows.forEach((row) => {
        row.addEventListener("click", () => {
            searchUserContainer.classList.add("hidden");

            showUserNeeded();

            enableBtns();

            const userSelected = document.querySelector(".user-selected");

            const nome = row.dataset.nome;
            const img = row.dataset.img;

            userSelected.dataset.usuarioId = row.dataset.id;

            userSelected.querySelector("span").textContent = nome;

            const profilePicture =
                userSelected.querySelector(".profile-picture");

            if (img !== "undefined" && img !== "") {
                profilePicture.innerHTML = `<img src="${storageUrl}/${img}" alt="" />`;
            } else {
                profilePicture.innerHTML = "";
            }

            userSelected.classList.remove("hidden");
        });
    });
}
