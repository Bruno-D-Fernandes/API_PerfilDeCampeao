@extends('admin.config.layout')

@section('content')
  <h2>Backups</h2>

  <h3>Sistema</h3>
  <button id="btnDumpSql" type="button">Baixar dump (.sql)</button>

  <h3>Exportar relatórios (.csv)</h3>
  <ul>
    <li><button data-type="usuarios" class="btnCsv" type="button">Usuários</button></li>
    <li><button data-type="clubes" class="btnCsv" type="button">Clubes</button></li>
    <li><button data-type="oportunidades" class="btnCsv" type="button">Oportunidades</button></li>
    <li><button data-type="funcoes" class="btnCsv" type="button">Funções</button></li>
    <li><button data-type="esportes" class="btnCsv" type="button">Esportes</button></li>
    <li><button data-type="denuncias" class="btnCsv" type="button">Denúncias</button></li>
  </ul>
@endsection

@section('scripts')
<script src="{{ asset('js/admin/settings/backup.js') }}"></script>
@endsection
