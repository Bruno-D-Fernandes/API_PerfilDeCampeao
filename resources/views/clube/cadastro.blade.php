<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    <form action="" id="cadastro-clube">
        @csrf

        <label for="clube-nome">Nome:</label>
        <input type="text" name="nomeClube" id="clube-nome">

        <label for="clube-email">Email:</label>
        <input type="text" name="emailClube" id="clube-email">

        <label for="clube-ano-criacao">Ano de Criação:</label>
        <input type="text" name="anoCriacaoClube" id="clube-ano-criacao">

        <label for="clube-categoria">Categoria:</label>
        <select name="categoria_id" id="clube-categoria">
            @foreach($categorias as $categoria)
                <option value="{{ $categoria->id }}">{{ $categoria->nomeCategoria }}</option>
            @endforeach
        </select>

        <label for="clube-esporte">Esporte:</label>
        <select name="esporte_id" id="clube-esporte">
            @foreach($esportes as $esporte)
                <option value="{{ $esporte->id }}">{{ $esporte->nomeEsporte }}</option>
            @endforeach
        </select>

        <label for="clube-cnpj">Cnpj:</label>
        <input type="text" name="cnpjClube" id="clube-cnpj">

        <label for="clube-cidade">Cidade:</label>
        <input type="text" name="cidadeClube" id="clube-cidade">

        <label for="clube-estado">Estado:</label>
        <input type="text" name="estadoClube" id="clube-estado">

        <label for="clube-endereco">Endereco:</label>
        <input type="text" name="enderecoClube" id="clube-endereco">

        <label for="clube-senha">Senha:</label>
        <input type="password" name="senhaClube" id="clube-senha">

        <button type="submit">Enviar</button>
    </form>

    <script src="{{ asset('js/clube/cadastro.js') }}"></script>
</body>
</html>