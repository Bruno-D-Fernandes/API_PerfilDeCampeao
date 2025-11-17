@extends('admin.config.layout')

@section('content')
<div class="corpoBackup">
  <h2>Backups</h2>
  <h6>Guarde arquivos de resturação ou exporte planilhas inteiras com os dados salvos para gerar insights</h6>

  <h3>Sistema</h3>
  <h6>Guarde todos os arquivos salvos em .sql</h6>
  <button id="btnDumpSql" type="button" class="btnDump">Baixar dump (.sql)</button>

  <h3>Exportar relatórios (.csv)</h3> 
  <h6>Exporte tabelas inteiras com dados em forma de planilha .csv para gerar insights</h6>
  <div class="listaDownloads">
  <ul>
    <li><h4>Usuários(.csv)</h4><button data-type="usuarios" class="btnUser" type="button">Baixar</button></li>
    <li><h4>Clubes(.csv)</h4><button data-type="clubes" class="btnClube" type="button">Baixar</button></li>
    <li><h4>Oportunidades(.csv)</h4><button data-type="oportunidades" class="btnOportu" type="button">Baixar</button></li>
    <li><h4>Funções(.csv)</h4><button data-type="funcoes" class="btnFunc" type="button">Baixar</button></li>
    <li><h4>Esportes(.csv)</h4><button data-type="esportes" class="btnEspo" type="button">Baixar</button></li>
    <li><h4>Denúncias(.csv)</h4><button data-type="denuncias" class="btnDenun" type="button">Baixar</button></li>
  </ul>
  </div>
  </div>
@endsection

@section('scripts')
<script src="{{ asset('js/admin/settings/backup.js') }}"></script>
@endsection