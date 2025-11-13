document.addEventListener("DOMContentLoaded", function () {
    const cepInput = document.getElementById("oportunidade-form-cep");
    const enderecoInput = document.getElementById("oportunidade-form-endereco");
    const cidadeInput = document.getElementById("oportunidade-form-cidade");
    const estadoInput = document.getElementById("oportunidade-form-estado");

    if (!cepInput) return;

    cepInput.addEventListener("blur", function () {
        let cep = cepInput.value.replace(/\D/g, ""); // Remove tudo que não for número

        if (cep.length !== 8) {
            alert("CEP inválido! Digite 8 números.");
            return;
        }

        // Indica que está buscando
        enderecoInput.value = "Buscando endereço...";
        cidadeInput.value = "";
        estadoInput.value = "";

        fetch(`https://viacep.com.br/ws/${cep}/json/`)
            .then(response => response.json())
            .then(data => {
                if (data.erro) {
                    alert("CEP não encontrado!");
                    enderecoInput.value = "";
                    cidadeInput.value = "";
                    estadoInput.value = "";
                    return;
                }

                // Preenche os campos
                enderecoInput.value = data.logradouro || "";
                cidadeInput.value = data.localidade || "";
                estadoInput.value = data.uf || "";
            })
            .catch(() => {
                alert("Erro ao buscar o CEP. Tente novamente.");
                enderecoInput.value = "";
                cidadeInput.value = "";
                estadoInput.value = "";
            });
    });
});