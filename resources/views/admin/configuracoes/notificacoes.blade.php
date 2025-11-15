@extends('admin.config.layout')

@section('content')
<div class="corpoNotifica">
  <h2 class>Notificações</h2><br>

<form id="notifForm" class="formNotifica">
  
  <h2>Ativar notificações por email</h2>
    <label class="labelNotiMail">
      <h4>Receba e-mails em tempo real quando novas atualizações surgirem</h4>
      <input type="checkbox" name="email_enabled">
      <span class="checkSlide"></span>
    </label>

    <h2>Moderação</h2>
    <h5>Me avise por email quando...</h5>
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
