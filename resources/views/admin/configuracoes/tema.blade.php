@extends('admin.config.layout')

@section('content')

<div class="modal" id="aModal">
    <div class="modal-content">
      <div class="success add">Tema Salvo Com Sucesso</div>
    </div>
  </div>


<div class="corpoTema">
  <h2>Tema</h2>
  <h6>Escolha seu tema de interface preferido. Você pode trocar manualmente ou ativar a troca automática dependendo do  sistema.</h6>



  <form id="themeForm" class="formTema">

    <div class="opcoesTema">

    <label class="labelTemaSistema">
    <img src="{{asset('/img/iconTemaSis.png')}}" class="iconSis" alt=""><strong class="nomeSis">Tema do Sistema</strong>  
    <input type="radio" name="theme" value="system" checked>
      <div class="imagemTema">
        <img src="{{asset('/img/imgTemaSis.png')}}" alt="referencia" class="tema">
      </div>
      <h4>Padrão</h4>
    <h6>Esse tema vai usar o tema padrão do sistema </h6>
    </label>

    <label class="labelTemaClaro">
      <img src="{{asset('/img/iconTemaClaro.png')}}" class="iconClaro" alt=""><strong class="nomeClaro">Tema Claro</strong>
      <input type="radio" name="theme" value="light">
       <div class="imagemTema">
        <img src="{{asset('/img/imgTemaSis.png')}}" alt="referencia" class="tema">
      </div>
      <h4>Modo Claro</h4>
      <h6>Ative se preferir um modo claro para utilização</h6>
    </label>  

    <label class="labelTemaEscuro">
      <img src="{{asset('/img/iconTemaEscuro.png')}}" class="iconEscuro" alt=""><strong class="nomeEscuro">Tema Escuro</strong>
      <input type="radio" name="theme" value="dark">
       <div class="imagemTema">
        <img src="{{asset('/img/imgTemaEscuro.png')}}" alt="referencia" class="tema">
      </div>
      <h4>Modo Escuro</h4>
      <h6>Ative se preferir um modo escuro para utilização</h6>
    </label>

    </div>
    <button type="submit" class="botaoNotifica">Salvar</button>
  </form>
  </div>
@endsection

@section('scripts')
<script src="{{ asset('js/admin/settings/tema.js') }}"></script> 

@endsection
