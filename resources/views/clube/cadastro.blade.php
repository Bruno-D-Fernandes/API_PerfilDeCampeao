<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    <form action="" id="cadastro">
        @csrf

        <label for="nomeClube">Nome:</label>
        <input type="text" name="nomeClube">

        <label for="cnpjClube">cnpjClube:</label>
        <input type="text" name="cnpjClube">

        <label for="emailClube">Email:</label>
        <input type="text" name="emailClube">

        <label for="cidadeClube">Cidade:</label>
        <input type="text" name="cidadeClube">

        <label for="estadoClube">Estado:</label>
        <input type="text" name="estadoClube">

        <label for="anoCriacaoClube">Ano de Criação:</label>
        <input type="text" name="anoCriacaoClube">

        <label for="enderecoClube">Endereco:</label>
        <input type="text" name="enderecoClube">

        <label for="bioClube">Biografia:</label>
        <textarea name="bioClube"></textarea>

        <label for="senhaClube">Senha:</label>
        <input type="text" name="senhaClube">

        <button type="submit">Enviar</button>
    </form>

    <script src="{{ asset('js/clube/cadastro.js') }}"></script>
</body>
</html>