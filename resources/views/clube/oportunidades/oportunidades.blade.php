<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Oportunidades</title>
</head>
<body>
    <form id="formOportunidades">
        @csrf

        <label>Descrição</label>
        
        <input type="text" name="descricaoOportunidades" id="descricaoOportunidades" required>

        <br>

        <select name="esporte_id" id="esporte_id" required>
            <option value="">Selecione o esporte...</option>
        </select>

        <br>
        <select name="posicoes_id" id="posicoes_id" required>
            <option value="">Selecione a Posição...</option>
        </select>

        <br>

        <input type="number" name="idadeMinima" required>

        <br>

        <input type="number" name="idadeMaxima" required>

        <br>
        
        <input type="text" name="cepOportunidade" id="cep" maxlength="9" onblur="buscaCep()" required>

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

    <script src="{{ asset('js/clube/oportunidades/utils.js') }}"></script>
    <script src="{{ asset('js/clube/oportunidades/modals.js') }}"></script>
    <script src="{{ asset('js/clube/oportunidades/dom-elements.js') }}"></script>
    <script src="{{ asset('js/clube/oportunidades/api.js') }}"></script>
    <script src="{{ asset('js/clube/oportunidades/events.js') }}"></script>
</body>
</html>