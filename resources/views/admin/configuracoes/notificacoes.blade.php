@extends('admin.config.layout')

@section('content')
<div class="corpoNotifica">
  <h2 class>Notificações</h2>

<form id="notifForm" class="formNotifica">
  
  <h3>Ativar notificações por email</h3>
    <label class="labelNotiMail">
      <h6>Receba e-mails em tempo real quando novas atualizações surgirem</h6>
      <input type="checkbox" name="email_enabled">
      <span class="checkSlide"></span>
    </label>

    <h3>Moderação</h3>
    <h6>me avise por email quando...</h6>
    <label class="labelNotiOportu">
      <h4>Uma nova oportunidade criada por um clube</h4>
      <input type="checkbox" name="notify_new_opportunity">
      <span class="checkSlide"></span>
    </label>

    <label class="labelNotifiDenun">
      <h4>Uma denúncia for registrada</h4>
      <input type="checkbox" name="notify_new_report">
      <span class="checkSlide"></span>
    </label>
    <button type="submit" class="botaoNotifica">Salvar</button>
  </form>
  </div>
@endsection

@section('scripts')
<script src="{{ asset('js/admin/settings/notificacoes.js') }}"></script>
@endsection
