<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Oportunidades</title>
</head>
<body>
    <form action="" id="formOportunidades">
        @csrf
        <input type="text" name="nomeOportunidade" required>
        <br>
        <input type="text" name="descricaoOportunidade" required>
        <br>
        <input type="number" name="idadeMinima" required>
        <br>
        <input type="number" name="idadeMaxima" required>
        <br>
        <input type="text" name="cepOportunidade" id="cep" maxlength="8" onblur="buscaCep()" required>
        <br>
        <select name="estadoOportunidade" id="estadoOportunidade" required>
            <option value="AC">Acre</option>
            <option value="AL">Alagoas</option>
            <option value="AP">Amapá</option>
            <option value="AM">Amazonas</option>
            <option value="BA">Bahia</option>
            <option value="CE">Ceará</option>
            <option value="DF">Distrito Federal</option>
            <option value="ES">Espírito Santo</option>
            <option value="GO">Goiás</option>
            <option value="MA">Maranhão</option>
            <option value="MT">Mato Grosso</option>
            <option value="MS">Mato Grosso do Sul</option>
            <option value="MG">Minas Gerais</option>
            <option value="PA">Pará</option>
            <option value="PB">Paraíba</option>
            <option value="PR">Paraná</option>
            <option value="PE">Pernambuco</option>
            <option value="PI">Piauí</option>
            <option value="RJ">Rio de Janeiro</option>
            <option value="RN">Rio Grande do Norte</option>
            <option value="RS">Rio Grande do Sul</option>
            <option value="RO">Rondônia</option>
            <option value="RR">Roraima</option>
            <option value="SC">Santa Catarina</option>
            <option value="SP">São Paulo</option>
            <option value="SE">Sergipe</option>
            <option value="TO">Tocantins</option>
        </select>
        <br>
        <input type="text" name="cidadeOportunidade" id="cidadeOportunidade" required>
        <br>
        <input type="text" name="enderecoOportunidade" id="enderecoOportunidade" required>
        <br>
        <button type="submit">Enviar</button>
    </form>
    <script>
//src="{{ asset('js/clube/oportunidades.js')}}"

    function buscaCep() {
        let cep = document.getElementById('cep').value;
        cep = cep.replace(/\D/g, '');
        
        if (cep.length !== 8) { 

            document.getElementById('cidadeOportunidade').value = '';
            document.getElementById('enderecoOportunidade').value = '';
            document.getElementById('estadoOportunidade').value = '';
            return alert('CEP inválido. Deve conter 8 dígitos.');

            if(cep.length > 0){
                alert('CEP inválido. Deve conter 8 dígitos.');
            }
            return
        }

    document.getElementById('cidadeOportunidade').value = '...';

    const url = `https://viacep.com.br/ws/${cep}/json/`;

    fetch(url)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Erro de rede ou na API do ViaCEP.');
                }
                return response.json(); 
            })
        .then(data => {
            if (!data.erro) {
                document.getElementById('cidadeOportunidade').value = data.localidade;
                document.getElementById('enderecoOportunidade').value = data.logradouro;
                document.getElementById('estadoOportunidade').value = data.uf;
            } else {
                document.getElementById('cidadeOportunidade').value = '';
                document.getElementById('enderecoOportunidade').value = '';
                document.getElementById('estadoOportunidade').value = '';
                alert('CEP não encontrado.');
            }
        })
        .catch(error => {
            console.error('Erro ao buscar o CEP:', error);
        });

    }

    </script>
</body>
</html>