@extends('admin.config.layout')

@section('content')
    <h2>Tema</h2>
    
    <p>Escolha o tema preferido.</p>

    <form id="themeForm">
        <label>
            <input type="radio" name="theme" value="system" checked>
            Tema do Sistema
        </label>

        <br>

        <label>
            <input type="radio" name="theme" value="light">
            Tema Claro
        </label>

        <br>

        <label>
            <input type="radio" name="theme" value="dark">
            Tema Escuro
        </label>

        <br><br>

        <button type="submit">Salvar</button>
    </form>
@endsection

@section('scripts')
    <script src="{{ asset('js/admin/configuracoes/tema.js') }}"></script> 
@endsection
