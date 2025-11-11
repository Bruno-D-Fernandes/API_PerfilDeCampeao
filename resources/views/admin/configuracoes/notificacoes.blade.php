@extends('admin.config.layout')

@section('content')
    <h2>Notificações</h2>
    <p>Ative/desative alertas por e-mail.</p>

    <form id="notifForm">
        <label>
            <input type="checkbox" name="email_enabled">
            Ativar notificações por e-mail
        </label>

        <h3>Moderação</h3>

        <label>
            <input type="checkbox" name="notify_new_opportunity">
            Avisar quando um clube criar oportunidade
        </label>

        <br>

        <label>
            <input type="checkbox" name="notify_new_report">
            Avisar quando houver nova denúncia
        </label>

        <br><br>

        <button type="submit">Salvar preferências</button>
    </form>
@endsection

@section('scripts')
    <script src="{{ asset('js/admin/configuracoes/notificacoes.js') }}"></script>
@endsection